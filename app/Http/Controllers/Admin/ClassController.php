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
    public function index()
    {
        $classes = ClassRoom::with(['department', 'teacherWithUser'])->paginate(10);
        return view('admin.contact.class.index', compact('classes'));
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
        $class->delete();

        return redirect()->route('admin.class.index')
            ->with('success', 'Lớp học đã được xóa thành công!');
    }
    
    /**
     * Lấy danh sách năm học gần đây
     */
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
}
