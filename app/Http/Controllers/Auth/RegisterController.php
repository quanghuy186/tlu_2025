<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pest\Support\View;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'regex:/[a-z0-9._%+-]+@(tlu\.edu\.vn|e\.tlu\.edu\.vn)$/',
            ],
            'name' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required',
        ], [
            'email.regex' => 'Email phải có định dạng @tlu.edu.vn hoặc @e.tlu.edu.vn',
            'name.required' => 'Vui lòng nhập họ và tên',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Mật khẩu không khớp vui lòng nhập lại',
            'terms.required' => 'Vui lòng chấp nhận điều khoản sử dụng',
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && !$existingUser->email_verified) {
            // Tạo token xác thực mới
            $verificationToken = Str::random(64);
            $tokenExpiry = Carbon::now()->addDays(3);

            $existingUser->name = $request->name;
            $existingUser->password = Hash::make($request->password);
            $existingUser->verification_token = $verificationToken;
            $existingUser->verification_token_expiry = $tokenExpiry;
            $existingUser->save();

            // Gửi lại email xác thực
            Mail::to($existingUser->email)->send(new VerificationEmail($existingUser));

            return redirect()->route('verification.notice')
                ->with('success', 'Tài khoản của bạn đã tồn tại nhưng chưa được xác thực. Vui lòng kiểm tra email để xác thực tài khoản!');
        }

        if ($existingUser) {
            return back()->with('error', 'Email này đã được đăng ký trước đó');
        }

        // Tạo token xác thực                                                                                      
        $verificationToken = Str::random(64);
        $tokenExpiry = Carbon::now()->addDays(3);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => false,
                'verification_token' => $verificationToken,
                'verification_token_expiry' => $tokenExpiry,
                'email_verified' => false,
            ]);

            Mail::to($user->email)->send(new VerificationEmail($user));

            DB::commit();

            return redirect()->route('verification.notice')
                ->with('warning', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('verification.notice')
                ->with('warning', 'Có lỗi xảy ra khi tạo tài khoản. Vui lòng thử lại sau.');
        }
    }

    public function notice()
    {
        return view('auth.verify')->with('success', 'Đăng ký thành công vui lòng kiểm tra email để xác thực!');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                'regex:/[a-z0-9._%+-]+@(tlu\.edu\.vn|e\.tlu\.edu\.vn)$/',
            ],
        ], [
            'email.regex' => 'Email phải có định dạng @tlu.edu.vn hoặc @e.tlu.edu.vn',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy email này trong hệ thống.']);
        }

        if ($user->email_verified) {
            return redirect()->route('login')
                ->with('success', 'Email của bạn đã được xác thực. Vui lòng đăng nhập.');
        }

        $resendLimit = 5;
        $cooldownPeriod = 5; // minutes

        if ($user->verification_resent_count >= $resendLimit) {
            $lastResent = $user->last_verification_resent_at;

            if ($lastResent && Carbon::now()->diffInMinutes($lastResent) < $cooldownPeriod) {
                $minutesLeft = $cooldownPeriod - Carbon::now()->diffInMinutes($lastResent);
                return back()->withErrors(['email' => "Vui lòng đợi {$minutesLeft} phút trước khi gửi lại email xác thực."]);
            }

            $user->verification_resent_count = 0;
        }

        $user->verification_token = Str::random(64);
        $user->verification_token_expiry = Carbon::now()->addDays(3);
        $user->verification_resent_count += 1;
        $user->last_verification_resent_at = Carbon::now();
        $user->save();

        try {
            Mail::to($user->email)->send(new VerificationEmail($user));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Có lỗi khi gửi email xác thực. Vui lòng thử lại sau.']);
        }

        return back()->with('error', 'Email xác thực đã được gửi lại thành công!');
    }

    public function verifyEmail($token)
    {
        $user = User::where('verification_token', $token)->first();
        
        if (!$user) {
            return redirect()->route('verification.notice')
                ->withErrors(['error' => 'Token xác thực không hợp lệ.']);
        }
        
        if (Carbon::now()->isAfter($user->verification_token_expiry)) {
            return redirect()->route('verification.notice')
                ->withErrors(['error' => 'Token xác thực đã hết hạn. Vui lòng yêu cầu gửi lại email xác thực.']);
        }
        
        DB::beginTransaction();
        try {
            $user->email_verified = true;
            $user->email_verified_at = now(); // Thêm timestamp xác thực
            $user->is_active = true;
            $user->verification_token = null;
            $user->verification_token_expiry = null;
            $user->save();
            
            $email_domain = explode('@', $user->email)[1];
            $roleId = ($email_domain === 'e.tlu.edu.vn') ? 1 : 2;
            
            DB::table('user_has_roles')->insert([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);
            
            if($roleId == 2){
                DB::table('teachers')->insert([
                    'user_id' => $user->id,
                ]);
            } else {
                DB::table('students')->insert([
                    'user_id' => $user->id,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('login')
                ->with('success', 'Tài khoản của bạn đã được xác thực thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('verification.notice')
                ->withErrors(['error' => 'Đã xảy ra lỗi khi xác thực tài khoản: ' . $e->getMessage()]);
        }
    }
}
