<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(){
        // $hasPermission = false;
        // $permission = 'view-user';
        // $hasPermission = tluHasPermission(Auth::user(),$permission);
       
        // if(!$hasPermission){
        //     return abort(403);
        // }

        if(!Gate::allows('view-user')){
            abort(403);
        }

        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create(){

    }

    public function store(){

    }

    public function edit(){

    }

    public function delete(){

    }
}
