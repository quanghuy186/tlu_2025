<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use  App\Models\Role;
use App\Models\RoleHasPermission;

class RoleHasPermissionController extends Controller
{
    public function index()
    {
        //eager loadding
        $list_role_has_permission = RoleHasPermission::with('role')->with('permission')->get();
        $grouped_role_has_permission = $list_role_has_permission->groupBy('role.description');
        return view('admin.role_has_permission.index')
        ->with('grouped_role_has_permission', $grouped_role_has_permission); 
    }

    public function create(){
        $list_roles = Role::all();
        $list_permissions = Permission::all();
        return view('admin.role_has_permission.create')->with('list_roles', $list_roles)
        ->with('list_permissions', $list_permissions);
    }

    public function store(Request $request)
    {
        $role_id = $request->role_id;
        $permission_ids = $request->permission_id ?? [];
        RoleHasPermission::where('role_id', $role_id)->delete();
        
        foreach ($permission_ids as $permission_id) {
            RoleHasPermission::create([
                'role_id' => $role_id,
                'permission_id' => $permission_id
            ]);
        }
        
        return redirect(route('admin.role_has_permission'))->with('success', 'Cập nhật quyền cho vai trò thành công');
    }
}