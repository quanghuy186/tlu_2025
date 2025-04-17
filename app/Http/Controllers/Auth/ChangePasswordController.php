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
 * Thay đổi mật khẩu người dùng
 */
    public function changePassword(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/|confirmed',
        ]);

        // Kiểm tra mật khẩu hiện tại
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Mật khẩu hiện tại không đúng'
            ], 400);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        // Ghi log hệ thống
        $this->logPasswordChange($user->id);

        return response()->json([
            'message' => 'Thay đổi mật khẩu thành công'
        ]);
    }

    /**
     * Ghi log thay đổi mật khẩu
     */
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
