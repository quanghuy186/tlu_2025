<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){

        return view('pages.contact');
    }

    public function department(){
        
        $departments = Department::all();
        return view('pages.contact.department')->with('departments', $departments);
    }

    public function teacher(){
        
        $departments = Department::all();
        return view('pages.contact.teacher')->with('departments', $departments);
    }

    public function student(){
        
        $departments = Department::all();
        return view('pages.contact.student')->with('departments', $departments);
    }
}
