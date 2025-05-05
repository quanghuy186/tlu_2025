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

    // Trong ContactController.php

    public function teacher()
    {
        $departments = Department::all();
        $academic_rank = Teacher::select('academic_rank')->get();
        $teachers = Teacher::with(['user', 'department'])->paginate(10);
        
        return view('pages.contact.teacher')
            ->with('departments', $departments)
            ->with('academic_rank', $academic_rank)
            ->with('teachers', $teachers);
    }

    public function search_teacher(Request $request)
    {
        $departments = Department::all();
        $academic_rank = Teacher::select('academic_rank')->get();
        $fullname = $request->input('fullname');
        
        $teachers = Teacher::query()
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->where('users.name', 'LIKE', "%{$fullname}%")
            ->orWhere('teachers.teacher_code', 'LIKE', "%{$fullname}%")
            ->select('teachers.*')
            ->with(['user', 'department'])
            ->paginate(10);
        
        // Kiểm tra nếu là yêu cầu Ajax
        if ($request->ajax()) {
            return view('partials.teacher_list', compact('teachers'));
        }
        
        return view('pages.contact.teacher')
            ->with('departments', $departments)
            ->with('fullname', $fullname)
            ->with('academic_rank', $academic_rank)
            ->with('teachers', $teachers);
    }

    public function sort_teacher(Request $request)
    {
        $sortBy = $request->input('sort', 'name');
        $fullname = $request->input('search', ''); // Lấy từ khóa tìm kiếm (nếu có)
        
        $query = Teacher::query()
            ->join('users', 'teachers.user_id', '=', 'users.id')
            ->select('teachers.*')
            ->with(['user', 'department']);
        
        // Áp dụng điều kiện tìm kiếm nếu có
        if (!empty($fullname)) {
            $query->where(function($q) use ($fullname) {
                $q->where('users.name', 'LIKE', "%{$fullname}%")
                ->orWhere('teachers.teacher_code', 'LIKE', "%{$fullname}%");
            });
        }
        
        // Áp dụng sắp xếp
        switch ($sortBy) {
            case 'name':
                $query->orderBy('users.name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('users.name', 'desc');
                break;
            default:
                $query->orderBy('users.name', 'asc');
        }
        
        $teachers = $query->paginate(10);
        
        // Trả về partial view khi được gọi bằng Ajax
        return view('partials.teacher_list', compact('teachers'));
    }

    public function student()
    {
        $students = Student::paginate(10); 
        return view('pages.contact.student')->with('students', $students);
    }
}
