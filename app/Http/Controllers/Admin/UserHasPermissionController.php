<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserHasPermission;
use Illuminate\Http\Request;

class UserHasPermissionController extends Controller
{
    public function store(Request $request){
        UserHasPermission::where('user_id', $request->user_id)->delete();
        if($request->has('permission_id') && is_array($request->permission_id)){
            foreach ($request->permission_id as $permission_id) {
                UserHasPermission::create([
                    'user_id' => $request->user_id,
                    'permission_id' => $permission_id,
                ]);
            }
        }
        return redirect(route('admin.user.index'))->with('success', "Cập nhật quyền truy cập thành công");
    }

    public function create_with_user($id){
        $user = User::find($id);
        $list_permissions = Permission::all();
        $list_user_has_permissions = UserHasPermission::where('user_id', $user->id)->pluck('permission_id')->toArray();
        return view('admin.user_has_permission.create_with_user')
        ->with('list_permissions', $list_permissions)
        ->with('id', $id)->with('user', $user)
        ->with('list_user_has_permissions', $list_user_has_permissions);
    }
}
