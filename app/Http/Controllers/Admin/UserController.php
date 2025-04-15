<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        $hasPermission = false;
        $permission = 'user::view';
        $hasPermission = tluHasPermission(Auth::user(),$permission);
       
        if(!$hasPermission){
            return abort(403);
        }

        $users = User::all();
        return view('admin.user.index', compact('users'));
    }


    
}
