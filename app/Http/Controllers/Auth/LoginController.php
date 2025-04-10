<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            if ($user->email_verified == 0 || $user->is_active == 0) {
                Auth::logout();

                // return back()->withErrors([
                //     'email' => 'Email chưa được xác thực. Vui lòng xác thực email trước khi đăng nhập.',
                // ])->withInput($request->only('email'));

                return back()
                ->with('error', 'Email chưa được xác thực. Vui lòng xác thực email trước khi đăng nhập.')
                ->withInput($request->only('email'));

            }

            $request->session()->regenerate();

            // $isAdmin = $user->roles()->where('role_id', 999)->exists();
            $isAdmin = $user->roles->contains('role_id', 999);

            if ($isAdmin) {
                return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
            }

            return redirect()->route('home.index')->with('success', 'Đăng nhập thành công!');;
        }

        // Xác thực thất bại
        // return back()->withErrors([
        //     'email' => 'Thông tin đăng nhập không chính xác.',
        // ])->withInput($request->only('email'));


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