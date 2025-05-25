<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Notification;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){
        $notification_latests = Notification::with(['user', 'category'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(4);
        return view('pages.contact')->with('notification_latests', $notification_latests);
    }

    public function department(){
        
        // $departments = Department::with('manager')->paginate(10);
        $departments = Department::with('manager')->paginate(10);
        return view('pages.contact.department')->with('departments', $departments);
    }

    public function search_department(Request $request)
    {
        $fullname = $request->input('fullname');
        
        $query = Department::query()
            ->leftJoin('users', 'departments.user_id', '=', 'users.id')
            ->select('departments.*')
            ->with('manager');
        
        // Add search conditions with null handling
        if (!empty($fullname)) {
            $query->where(function($q) use ($fullname) {
                $q->where('users.name', 'LIKE', "%{$fullname}%")
                ->orWhere('departments.code', 'LIKE', "%{$fullname}%")
                ->orWhere('departments.name', 'LIKE', "%{$fullname}%"); // Add department name search
            });
        }
        
        $departments = $query->paginate(10);
        
        // Check if it's an Ajax request
        if ($request->ajax()) {
            return view('partials.department_list', compact('departments'));
        }
        
        return view('pages.contact.department')
            ->with('fullname', $fullname)
            ->with('departments', $departments);
    }

    public function sort_department(Request $request)
    {
        $sortBy = $request->input('sort', 'name');
        $fullname = $request->input('fullname', '');
        
        $query = Department::query()
            ->leftJoin('users', 'departments.user_id', '=', 'users.id')
            ->select('departments.*')
            ->with('manager');
            
        if (!empty($fullname)) {
            $query->where(function($q) use ($fullname) {
                $q->where('users.name', 'LIKE', "%{$fullname}%")
                ->orWhere('departments.code', 'LIKE', "%{$fullname}%")
                ->orWhere('departments.name', 'LIKE', "%{$fullname}%"); // Add department name search
            });
        }

        // Modified sorting to handle null managers
        switch ($sortBy) {
            case 'name':
                // First sort by whether manager exists, then by name
                $query->orderByRaw('CASE WHEN users.name IS NULL THEN 1 ELSE 0 END')
                    ->orderBy('users.name', 'asc');
                break;
            case 'name-desc':
                $query->orderByRaw('CASE WHEN users.name IS NULL THEN 1 ELSE 0 END')
                    ->orderBy('users.name', 'desc');
                break;
            default:
                // Default to sorting by department name if no sorting specified
                $query->orderBy('departments.name', 'asc');
        }
        
        $departments = $query->paginate(10);
        
        // Return partial view for Ajax
        return view('partials.department_list', compact('departments'));
    }


    public function teacher()
    {
        $departments = Department::all();
        $academic_rank = Teacher::select('academic_rank')
                        ->whereNotNull('academic_rank')
                        ->distinct()
                        ->get();
        $teachers = Teacher::with(['user', 'department'])->paginate(10);
        
        return view('pages.contact.teacher')
            ->with('departments', $departments)
            ->with('academic_rank', $academic_rank)
            ->with('teachers', $teachers);
    }

    public function search_teacher(Request $request)
{
    $departments = Department::all();
    $academic_rank = Teacher::select('academic_rank')
                    ->whereNotNull('academic_rank')
                    ->distinct()
                    ->get();

    $fullname = $request->input('fullname', '');
    $department_id = $request->input('department_id', 'all');
    $selected_rank = $request->input('academic_rank', 'all');
    $sort = $request->input('sort', 'name');
    
    $query = Teacher::query()
        ->join('users', 'teachers.user_id', '=', 'users.id')
        ->select('teachers.*')
        ->with(['user', 'department']);
    
    // Thêm điều kiện tìm kiếm theo tên hoặc mã cán bộ
    if (!empty($fullname)) {
        $query->where(function($q) use ($fullname) {
            $q->where('users.name', 'LIKE', "%{$fullname}%")
            ->orWhere('teachers.teacher_code', 'LIKE', "%{$fullname}%");
        });
    }
    
    // Thêm điều kiện lọc theo department_id
    if (!empty($department_id) && $department_id != 'all') {
        $query->where('teachers.department_id', $department_id);
    }
    
    // Thêm điều kiện lọc theo academic_rank
    if (!empty($selected_rank) && $selected_rank != 'all') {
        $query->where('teachers.academic_rank', $selected_rank);
    }
    
    // Áp dụng sắp xếp
    switch ($sort) {
        case 'name':
            $query->orderBy('users.name', 'asc');
            break;
        case 'name-desc':
            $query->orderBy('users.name', 'desc');
            break;
        case 'department':
            $query->leftJoin('departments', 'teachers.department_id', '=', 'departments.id')
                  ->orderBy('departments.name', 'asc')
                  ->select('teachers.*');
            break;
        case 'position':
            $query->orderBy('teachers.position', 'asc');
            break;
        default:
            $query->orderBy('users.name', 'asc');
    }
    
    // Phân trang
    $teachers = $query->paginate(10);
    
    // Thêm các tham số vào pagination links
    $teachers->appends($request->all());
    
    // Kiểm tra nếu là yêu cầu Ajax
    if ($request->ajax()) {
        return view('partials.teacher_list', compact('teachers'))->render();
    }
    
    return view('pages.contact.teacher')
        ->with('departments', $departments)
        ->with('fullname', $fullname)
        ->with('department_id', $department_id)
        ->with('selected_rank', $selected_rank)
        ->with('sort', $sort)
        ->with('academic_rank', $academic_rank)
        ->with('teachers', $teachers);
}

public function sort_teacher(Request $request)
{
    $sortBy = $request->input('sort', 'name');
    $fullname = $request->input('fullname', '');
    $department_id = $request->input('department_id', 'all');
    $selected_rank = $request->input('academic_rank', 'all');
    
    $query = Teacher::query()
        ->join('users', 'teachers.user_id', '=', 'users.id')
        ->select('teachers.*')
        ->with(['user', 'department']);
    
    // Áp dụng điều kiện tìm kiếm theo tên hoặc mã nếu có
    if (!empty($fullname)) {
        $query->where(function($q) use ($fullname) {
            $q->where('users.name', 'LIKE', "%{$fullname}%")
            ->orWhere('teachers.teacher_code', 'LIKE', "%{$fullname}%");
        });
    }
    
    // Áp dụng điều kiện lọc theo department_id
    if (!empty($department_id) && $department_id != 'all') {
        $query->where('teachers.department_id', $department_id);
    }
    
    // Áp dụng điều kiện lọc theo academic_rank
    if (!empty($selected_rank) && $selected_rank != 'all') {
        $query->where('teachers.academic_rank', $selected_rank);
    }
    
    // Áp dụng sắp xếp
    switch ($sortBy) {
        case 'name':
            $query->orderBy('users.name', 'asc');
            break;
        case 'name-desc':
            $query->orderBy('users.name', 'desc');
            break;
        case 'department':
            $query->leftJoin('departments', 'teachers.department_id', '=', 'departments.id')
                  ->orderBy('departments.name', 'asc')
                  ->select('teachers.*'); // Đảm bảo chỉ select teachers
            break;
        case 'position':
            $query->orderBy('teachers.position', 'asc');
            break;
        default:
            $query->orderBy('users.name', 'asc');
    }
    
    // Phân trang
    $teachers = $query->paginate(10);
    
    // Thêm các tham số vào pagination links
    $teachers->appends($request->all());
    
    // Trả về partial view khi được gọi bằng Ajax
    return view('partials.teacher_list', compact('teachers'))->render();
}

    public function student()
    {
        $classes = ClassRoom::all();
        
        // Lấy danh sách các năm nhập học duy nhất
        $enrollment_years = Student::select('enrollment_year')
                            ->whereNotNull('enrollment_year')
                            ->distinct()
                            ->orderBy('enrollment_year', 'desc')
                            ->pluck('enrollment_year')
                            ->toArray();
        
        $students = Student::with(['user', 'class'])->paginate(10);
        
        return view('pages.contact.student')
            ->with('classes', $classes)
            ->with('enrollment_years', $enrollment_years)
            ->with('students', $students);
    }

    public function search_student(Request $request)
    {
        $classes = ClassRoom::all();
        
        // Lấy danh sách các năm nhập học duy nhất
        $enrollment_years = Student::select('enrollment_year')
                            ->whereNotNull('enrollment_year')
                            ->distinct()
                            ->orderBy('enrollment_year', 'desc')
                            ->pluck('enrollment_year')
                            ->toArray();
        
        $fullname = $request->input('fullname');
        $class_id = $request->input('class_id');
        $enrollment_year = $request->input('enrollment_year');
        
        $query = Student::query()
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.*')
            ->with(['user', 'class']);
        
        // Thêm điều kiện tìm kiếm theo tên hoặc mã sinh viên
        if (!empty($fullname)) {
            $query->where(function($q) use ($fullname) {
                $q->where('users.name', 'LIKE', "%{$fullname}%")
                  ->orWhere('students.student_code', 'LIKE', "%{$fullname}%");
            });
        }
        
        // Thêm điều kiện lọc theo class_id
        if (!empty($class_id) && $class_id != 'all') {
            $query->where('students.class_id', $class_id);
        }
        
        // Thêm điều kiện lọc theo enrollment_year
        if (!empty($enrollment_year) && $enrollment_year != 'all') {
            $query->where('students.enrollment_year', $enrollment_year);
        }
        
        $students = $query->paginate(10);
        
        // Kiểm tra nếu là yêu cầu Ajax
        if ($request->ajax()) {
            return view('partials.student_list', compact('students'));
        }
        
        return view('pages.contact.student')
            ->with('classes', $classes)
            ->with('enrollment_years', $enrollment_years)
            ->with('fullname', $fullname)
            ->with('class_id', $class_id)
            ->with('enrollment_year', $enrollment_year)
            ->with('students', $students);
    }

    public function sort_student(Request $request)
    {
        $sortBy = $request->input('sort', 'name');
        $fullname = $request->input('fullname', '');
        $class_id = $request->input('class_id', 'all');
        $enrollment_year = $request->input('enrollment_year', 'all');
        
        $query = Student::query()
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('students.*')
            ->with(['user', 'class']);
        
        // Áp dụng điều kiện tìm kiếm theo tên hoặc mã sinh viên
        if (!empty($fullname)) {
            $query->where(function($q) use ($fullname) {
                $q->where('users.name', 'LIKE', "%{$fullname}%")
                  ->orWhere('students.student_code', 'LIKE', "%{$fullname}%");
            });
        }
        
        // Áp dụng điều kiện lọc theo class_id
        if (!empty($class_id) && $class_id != 'all') {
            $query->where('students.class_id', $class_id);
        }
        
        // Áp dụng điều kiện lọc theo enrollment_year
        if (!empty($enrollment_year) && $enrollment_year != 'all') {
            $query->where('students.enrollment_year', $enrollment_year);
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
        
        $students = $query->paginate(10);
        
        // Trả về partial view khi được gọi bằng Ajax
        return view('partials.student_list', compact('students'));
    }
}
