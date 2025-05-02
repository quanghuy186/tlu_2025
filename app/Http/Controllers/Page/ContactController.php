<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
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
        
        $teachers = Teacher::all();
        return view('pages.contact.teacher')->with('teachers',$teachers);
    }

    public function student(){
        
        $students = Student::all();
        return view('pages.contact.student')->with('students', $students);
    }
}
