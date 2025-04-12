<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserHasRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class UserHasRoleController extends Controller
{
    public function index(){
        $list_roles = Role::all();
        return view('admin.user_has_role.index')->with('list_roles', $list_roles);
    }

    public function create(){
        $list_users = User::all();
        $list_roles = Role::all();
        return view('admin.user_has_role.create')->with('list_users', $list_users)->with('list_roles', $list_roles);
    }

    public function store(Request $request){
        UserHasRole::where('user_id', $request->user_id)->delete();
        foreach ($request->role_id as $role_id) {
            UserHasRole::create([
                'user_id' => $request->user_id,
                'role_id' => $role_id,
            ]);
        }
        return redirect(route('admin.user_has_role'))->with('success', "Gán vai trò thành công");
    }

    public function create_with_user($id){
        $user = User::find($id);
        $list_roles = Role::all();
        $list_user_has_roles = UserHasRole::where('user_id', $user->id)->pluck('role_id')->toArray();
        return view('admin.user_has_role.create_with_user')
        ->with('list_roles', $list_roles)
        ->with('id', $id)->with('user', $user)
        ->with('list_user_has_roles', $list_user_has_roles);
    }
}