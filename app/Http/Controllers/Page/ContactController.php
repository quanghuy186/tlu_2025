<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){

        return view('pages.contact');
    }

    public function department(){
        
        $departments = Department::paginate(10);
        return view('pages.contact.department')->with('departments', $departments);
    }

    public function teacher(){
        // $departments = Department::all();
        $departments = Department::all();

        $teachers = Teacher::paginate(10);
        return view('pages.contact.teacher')
        ->with('departments', $departments)
        ->with('teachers',$teachers);
    }

    public function search_teacher(Request $request){
        $departments = Department::all();

        $search = $request->input('search');
        $teachers = Teacher::query()
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', "%{$search}%")
            ->orWhere('teachers.teacher_code', 'LIKE', "%{$search}%")
            ->select('teachers.*')
            ->with('user')
            ->paginate(10);
        return view('pages.contact.teacher')
        ->with('departments', $departments)
        ->with('search', $search)
        ->with('teachers', $teachers);
    }

    public function student()
    {
        $students = Student::paginate(10); 
        return view('pages.contact.student')->with('students', $students);
    }
}
