<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $hasPermission = false;
        $email = "2151062781@e.tlu.edu.vn";
        $permission = 'user::view';

        $result = DB::table("users")
        ->join("user_has_roles","user_has_roles.user_id","=","users.id")
        ->join("role_has_permissions","user_has_roles.role_id","=","role_has_permissions.role_id")
        ->join("permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where('users.email',"=", $email)
        ->where('permissions.permission_name', '=', $permission)
        ->count();
        // dd($result);

        $hasPermission = $result > 0;
       
        if(!$hasPermission){
            return abort(404);
        }

        $users = User::all();
        return view('admin.user.index', compact('users'));
    }


    
}
