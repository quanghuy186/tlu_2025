<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /**
     * Hiển thị form đổi mật khẩu
     *
     * @return \Illuminate\View\View
     */
    public function show_form()
    {
        return view("auth.change-password");
    }

    /**
     * Xử lý thay đổi mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới',
            'new_password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'new_password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 số',
            'new_password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không chính xác');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
            
        // $this->logPasswordChange($user->id);

        return redirect()->route('home.index')->with('success', 'Thay đổi mật khẩu thành công vui lòng đăng xuất để cập nhật');
    }
    private function logPasswordChange($userId)
    {
        DB::table('system_logs')->insert([
            'user_id' => $userId,
            'action' => 'password_change',
            'details' => 'User changed password',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'is_active' => true,
            'created_at' => now()
        ]);
    }
}