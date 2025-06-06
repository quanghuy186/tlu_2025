<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if ($user->email_verified == 0 || $user->is_active == 0) {
                Auth::logout();

                return back()
                ->with('error', 'Email chưa được xác thực. Vui lòng xác thực email trước khi đăng nhập.')
                ->withInput($request->only('email'));
            }
            $request->session()->regenerate();

            $userRoles = $user->roles()->with('role')->get();
            $isAdmin = $userRoles->contains(function($userRole) {
                return $userRole->role->role_name === 'admin';
            });

            if ($isAdmin) {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
            }

            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công!');;
        }

        return back()
        ->with('error', 'Thông tin đăng nhập không chính xác.')
        ->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}