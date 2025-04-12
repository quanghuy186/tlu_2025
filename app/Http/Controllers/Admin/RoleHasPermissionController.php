<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleHasPermissionController extends Controller
{
    public function index(){
        $list_permissions = Permission::all();
        return view('admin.role_has_permission.index')->with('list_permissions', $list_permissions);
    }

    public function create(){

    }
}