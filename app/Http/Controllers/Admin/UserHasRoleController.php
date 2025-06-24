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

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        UserHasRole::where('user_id', $request->user_id)->delete();
        
        if ($request->has('role_id') && is_array($request->role_id)) {
            foreach ($request->role_id as $role_id) {
                UserHasRole::create([
                    'user_id' => $request->user_id,
                    'role_id' => $role_id,
                ]);
            }
        }
        
        return redirect(route('admin.user.index'))->with('success', "Gán vai trò thành công");
    }

    // public function create_with_user($id){
    //     $user = User::find($id);
    //     $list_roles = Role::all();
    //     $list_user_has_roles = UserHasRole::where('user_id', $user->id)->pluck('role_id')->toArray();
    //     return view('admin.user_has_role.create_with_user')
    //     ->with('list_roles', $list_roles)
    //     ->with('id', $id)->with('user', $user)
    //     ->with('list_user_has_roles', $list_user_has_roles);
    // }

    public function create_with_user($id)
    {
        $user = User::find($id);
        
        $allRoles = Role::all();
        
        $list_user_has_roles = UserHasRole::where('user_id', $user->id)->pluck('role_id')->toArray();
        
        $specialRoles = [1, 2, 3];
        
        $hasSpecialRole = !empty(array_intersect($list_user_has_roles, $specialRoles));
        
        $userSpecialRoles = array_intersect($list_user_has_roles, $specialRoles);
        
        if ($hasSpecialRole) {
            $list_roles = $allRoles->filter(function($role) use ($userSpecialRoles, $specialRoles) {
                if (in_array($role->id, $userSpecialRoles)) {
                    return true;
                }
                
                if (!in_array($role->id, $specialRoles)) {
                    return true;
                }
                
                return false;
            });
        } else {
            $list_roles = $allRoles;
        }
        
        $specialRolesJson = json_encode($specialRoles);
        
        return view('admin.user_has_role.create_with_user')
            ->with('list_roles', $list_roles)
            ->with('id', $id)
            ->with('user', $user)
            ->with('list_user_has_roles', $list_user_has_roles)
            ->with('specialRoles', $specialRolesJson);
    }
}