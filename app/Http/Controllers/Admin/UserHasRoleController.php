<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Http\Request;

class UserHasRoleController extends Controller
{
    public function index(){

    }

    public function create(){
        $list_users = User::all();
        $list_roles = Role::all();
        return view('admin.user_has_role.create')->with('list_users', $list_users)->with('list_roles', $list_roles);
    }
}