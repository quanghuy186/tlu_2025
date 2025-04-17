<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view("admin.role.index")->with("roles", $roles);
    }

    public function create(){

    }

    public function store(Request $request){

    }

}
