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

    /**
     * Xử lý đăng ký tài khoản
     */
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

        // Kiểm tra xem email đã tồn tại trong hệ thống nhưng chưa được xác thực chưa
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && !$existingUser->email_verified) {
            // Tạo token xác thực mới và thời gian hết hạn
            $verificationToken = Str::random(64);
            $tokenExpiry = Carbon::now()->addDays(3);

            // Cập nhật thông tin người dùng
            $existingUser->name = $request->full_name;
            $existingUser->password = Hash::make($request->password);
            $existingUser->verification_token = $verificationToken;
            $existingUser->verification_token_expiry = $tokenExpiry;
            $existingUser->save();

            // Gửi lại email xác thực
            Mail::to($existingUser->email)->send(new VerificationEmail($existingUser));

            return redirect()->route('verification.notice')
                ->with('status', 'Tài khoản của bạn đã tồn tại nhưng chưa được xác thực. Vui lòng kiểm tra email để xác thực tài khoản!');
        }

        // Nếu email chưa tồn tại hoặc đã được xác thực (không xử lý ở trên), thì kiểm tra unique
        if ($existingUser) {
            return back()->withErrors(['email' => 'Email này đã được đăng ký trước đó'])->withInput();
        }

        // Tạo token xác thực và thời gian hết hạn
        $verificationToken = Str::random(64);
        $tokenExpiry = Carbon::now()->addDays(3);

        // Xác định role_id dựa trên tên miền email
        $emailDomain = explode('@', $request->email)[1];
        $roleId = ($emailDomain === 'tlu.edu.vn') ? 1 : 2;

        // Bắt đầu transaction để đảm bảo tính nhất quán dữ liệu
        DB::beginTransaction();

        try {
            // Tạo user mới
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => false,
                'verification_token' => $verificationToken,
                'verification_token_expiry' => $tokenExpiry,
                'email_verified' => false,
            ]);

            // Thêm vào bảng user_has_roles
            DB::table('user_has_roles')->insert([
                'user_id' => $user->id,
                'role_id' => $roleId,
            ]);

            // Gửi email xác thực
            Mail::to($user->email)->send(new VerificationEmail($user));

            DB::commit();

            return redirect()->route('verification.notice')
                ->with('status', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản!');

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

    /**
     * Gửi lại email xác thực
     */
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
                ->with('status', 'Email của bạn đã được xác thực. Vui lòng đăng nhập.');
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

        // Tạo token mới
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

        return back()->with('status', 'Email xác thực đã được gửi lại thành công!');
    }

    /**
     * Xác thực email
     */
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

        $user->email_verified = true;
        $user->is_active = true;
        $user->verification_token = null;
        $user->verification_token_expiry = null;
        $user->save();

        return redirect()->route('login')
            ->with('status', 'Tài khoản của bạn đã được xác thực thành công! Vui lòng đăng nhập.');
    }
}
