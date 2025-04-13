<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;

class ApiRoleHasPermissionController extends Controller
{
    public function getByRoleId($role_id){
        // $list_role_has_permission = RoleHasPermission::all();
        $list_role_has_permission = RoleHasPermission::where('role_id', $role_id)->pluck('permission_id')->toArray();

        return response()->json([
            'statusCode' => 200,
            'message' => 'Đã lấy dữ liệu thành công!',
            'data' => $list_role_has_permission
        ]
        );
    }
}
