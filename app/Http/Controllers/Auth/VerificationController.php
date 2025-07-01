<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerificationEmail;

class VerificationController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $verificationToken = Str::random(64);
        $tokenExpiry = Carbon::now()->addDays(3);

        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'is_active' => false,
            'verification_token' => $verificationToken,
            'verification_token_expiry' => $tokenExpiry,
            'email_verified' => false,
        ]);

        $this->sendVerificationEmail($user);

        return redirect()->route('verification.notice')->with('status', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản!');
    }

    public function notice()
    {
        return view('auth.verify');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy email này trong hệ thống.']);
        }

        if ($user->email_verified) {
            return redirect()->route('login')->with('status', 'Email của bạn đã được xác thực. Vui lòng đăng nhập.');
        }

        $resendLimit = 5;
        $cooldownPeriod = 15; // minutes

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

        $this->sendVerificationEmail($user);

        return back()->with('status', 'Link xác thực đã được gửi lại vào email của bạn!');
    }

    public function verify(Request $request, $token)
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

    // Hàm gửi email xác thực
    private function sendVerificationEmail(User $user)
    {
        Mail::to($user->email)->send(new VerificationEmail($user));
    }
}
