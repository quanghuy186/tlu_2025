<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index(Request $request)
{
    $query = ClassRoom::with(['department', 'teacherWithUser']);
    
    // Tìm kiếm
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('class_code', 'like', "%{$search}%")
              ->orWhere('class_name', 'like', "%{$search}%");
        })
        ->orWhereHas('department', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        })
        ->orWhereHas('teacherWithUser.user', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }
    
    // Lọc theo năm học
    if ($request->filled('academic_year')) {
        $query->where('academic_year', $request->input('academic_year'));
    }
    
    // Lọc theo học kỳ
    if ($request->filled('semester')) {
        $query->where('semester', $request->input('semester'));
    }
    
    // Lọc theo khoa/bộ môn
    if ($request->filled('department_id')) {
        $query->where('department_id', $request->input('department_id'));
    }
    
    // Lọc theo giảng viên
    if ($request->filled('teacher_id')) {
        $query->where('teacher_id', $request->input('teacher_id'));
    }
    
    $classes = $query->paginate(10)->withQueryString();
    
    // Lấy dữ liệu cho các bộ lọc
    $departments = Department::all();
    $teachers = Teacher::with('user')->get();
    $academicYears = $this->getAcademicYears();
    $semesters = $this->getSemesters();
    
    return view('admin.contact.class.index', compact(
        'classes', 
        'departments', 
        'teachers', 
        'academicYears', 
        'semesters'
    ));
}


    /**
     * Hiển thị form tạo lớp học mới
     */
    public function create()
    {
        $departments = Department::all();
        $teachers = Teacher::with('user')->get();
        $academicYears = $this->getAcademicYears();
        $semesters = $this->getSemesters();
        
        return view('admin.contact.class.create', compact('departments', 'teachers', 'academicYears', 'semesters'));
    }

    /**
     * Lưu lớp học mới vào database
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'class_code' => 'required|string|max:20|unique:classes',
            'class_name' => 'required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'nullable|string|max:20',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        // Tạo lớp học mới
        $class = ClassRoom::create($validated);

        return redirect()->route('admin.class.index')
            ->with('success', 'Lớp học đã được tạo thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết lớp học
     */
    public function show($id)
    {
        $class = ClassRoom::with(['department', 'teacherWithUser'])->findOrFail($id);
        return view('admin.contact.class.detail', compact('class'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin lớp học
     */
    public function edit($id)
    {
        $class = ClassRoom::findOrFail($id);
        $departments = Department::all();
        $teachers = Teacher::with('user')->get();
        $academicYears = $this->getAcademicYears();
        $semesters = $this->getSemesters();
        
        return view('admin.contact.class.edit', compact('class', 'departments', 'teachers', 'academicYears', 'semesters'));
    }

    /**
     * Cập nhật thông tin lớp học
     */
    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);
        
        // Validate dữ liệu
        $validated = $request->validate([
            'class_code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('classes')->ignore($class->id),
            ],
            'class_name' => 'required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'nullable|string|max:20',
            'teacher_id' => 'nullable|exists:teachers,id',
        ]);

        // Cập nhật thông tin lớp học
        $class->update($validated);

        return redirect()->route('admin.class.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật!');
    }

    /**
     * Xóa lớp học
     */
    public function destroy($id)
    {
        $class = ClassRoom::findOrFail($id);
        $class->teacher_id = null;
        $class->save();
        $class->students()->update(['class_id' => null]);
        $class->delete();

        return redirect()->route('admin.class.index')
            ->with('success', 'Lớp học đã được xóa thành công!');
    }
    
    private function getAcademicYears()
    {
        $currentYear = date('Y');
        $years = [];
        
        // Tạo danh sách năm học từ năm hiện tại trở về 5 năm trước và 2 năm tới
        for ($i = -5; $i <= 2; $i++) {
            $startYear = $currentYear + $i;
            $endYear = $startYear + 1;
            $years["$startYear-$endYear"] = "Năm học $startYear-$endYear";
        }
        
        return $years;
    }
    
    /**
     * Lấy danh sách học kỳ
     */
    private function getSemesters()
    {
        return [
            'Học kỳ 1' => 'Học kỳ 1',
            'Học kỳ 2' => 'Học kỳ 2',
            'Học kỳ 3' => 'Học kỳ 3',
            'Học kỳ hè' => 'Học kỳ hè',
            'Cả năm' => 'Cả năm',
        ];
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'class_ids' => 'required|array',
            'class_ids.*' => 'exists:classes,id',
        ]);
        
        $classIds = $request->input('class_ids');
        
        // Cập nhật tham chiếu trước khi xóa
        ClassRoom::whereIn('id', $classIds)->update(['teacher_id' => null]);
        
        // Cập nhật sinh viên liên quan
        foreach ($classIds as $classId) {
            $class = ClassRoom::find($classId);
            if ($class) {
                $class->students()->update(['class_id' => null]);
            }
        }
        
        // Xóa các lớp học
        ClassRoom::whereIn('id', $classIds)->delete();
        
        return redirect()->route('admin.class.index')
            ->with('success', 'Đã xóa thành công ' . count($classIds) . ' lớp học!');
    }
}
