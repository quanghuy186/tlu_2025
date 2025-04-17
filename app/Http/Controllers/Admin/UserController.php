<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\UserHasRole;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        // $hasPermission = false;
        // $permission = 'view-user';
        // $hasPermission = tluHasPermission(Auth::user(),$permission);
       
        // if(!$hasPermission){
        //     return abort(403);
        // }

        // if(!Gate::allows('view-user')){
        //     abort(403);
        // }

        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create(){
        $list_roles = Role::all();
        return view('admin.user.create')->with('list_roles', $list_roles);
    }

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive', // Sửa từ is_active thành status nếu form của bạn dùng status
        ]);

        try {
            DB::beginTransaction();
            
            // Create a new user
            $user = new User();
            $user->name = $request->fullname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            
            if (isset($request->status)) {
                $user->is_active = ($request->status === 'active') ? 1 : 0;
                $user->email_verified = ($request->status === 'active') ? 1 : 0;
            }
            
            $user->save();
            
            // Assign role to user
            $userHasRole = new UserHasRole();
            $userHasRole->user_id = $user->id;
            $userHasRole->role_id = $request->role_id;
            $userHasRole->save();
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('admin.user.index')
                ->with('success', 'Tài khoản đã được tạo thành công!');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.user.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'email_verified' => 'required|boolean',  
        ]);

        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->is_active = $request->is_active;
        $user->email_verified = $request->email_verified;  
        $user->save();

        return redirect()->route('admin.user.index')
            ->with('success', 'Thông tin tài khoản đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        try {
            // Bắt đầu một transaction để đảm bảo tính toàn vẹn dữ liệu
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            $userName = $user->name;
            
            // Xóa các bản ghi liên quan trong bảng user_has_roles trước
            DB::table('user_has_roles')->where('user_id', $id)->delete();
            
            // Sau đó xóa người dùng
            $user->delete();
            
            // Commit transaction nếu mọi thứ thành công
            DB::commit();
            
            return redirect()->route('admin.user.index')
                ->with('success', "Tài khoản '{$userName}' đã được xóa thành công.");
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.user.index')
                ->with('error', "Không thể xóa tài khoản. Lỗi: " . $e->getMessage());
        }
    }
}
