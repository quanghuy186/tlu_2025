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
        
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->input('academic_year'));
        }
        
        if ($request->filled('semester')) {
            $query->where('semester', $request->input('semester'));
        }
        
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }
        
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }
        
        $classes = $query->paginate(10)->withQueryString();
        
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


    public function create()
    {
        $departments = Department::all();
        $teachers = Teacher::with('user')->get();
        $academicYears = $this->getAcademicYears();
        $semesters = $this->getSemesters();
        
        return view('admin.contact.class.create', compact('departments', 'teachers', 'academicYears', 'semesters'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_code' => 'required|string|max:20|unique:classes',
            'class_name' => 'required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'academic_year' => 'required|string|max:20',
            'semester' => 'nullable|string|max:20',
            'teacher_id' => 'nullable|exists:teachers,id',
        ],[
                'class_code.required' => 'Vui lòng nhập mã lớp học',
                'class_code.string' => 'Mã lớp học phải là chuỗi ký tự',
                'class_code.max' => 'Mã lớp học không được vượt quá 20 ký tự',
                'class_code.unique' => 'Mã lớp học đã tồn tại, vui lòng chọn mã khác',
                'class_name.required' => 'Vui lòng nhập tên lớp học',
                'class_name.string' => 'Tên lớp học phải là chuỗi ký tự',
                'class_name.max' => 'Tên lớp học không được vượt quá 100 ký tự',
                'department_id.exists' => 'Khoa/Phòng ban được chọn không tồn tại',
                'academic_year.required' => 'Vui lòng nhập năm học',
                'academic_year.string' => 'Năm học phải là chuỗi ký tự',
                'academic_year.max' => 'Năm học không được vượt quá 20 ký tự',
                'semester.string' => 'Học kỳ phải là chuỗi ký tự',
                'semester.max' => 'Học kỳ không được vượt quá 20 ký tự',
        ]);

        // Tạo lớp học mới
        $class = ClassRoom::create($validated);

        return redirect()->route('admin.class.index')
            ->with('success', 'Lớp học đã được tạo thành công!');
    }

    public function show($id)
    {
        $class = ClassRoom::with(['department', 'teacherWithUser'])->findOrFail($id);
        return view('admin.contact.class.detail', compact('class'));
    }

    public function edit($id)
    {
        $class = ClassRoom::findOrFail($id);
        $departments = Department::all();
        $teachers = Teacher::with('user')->get();
        $academicYears = $this->getAcademicYears();
        $semesters = $this->getSemesters();
        
        return view('admin.contact.class.edit', compact('class', 'departments', 'teachers', 'academicYears', 'semesters'));
    }

    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);
        
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

        $class->update($validated);

        return redirect()->route('admin.class.index')
            ->with('success', 'Thông tin lớp học đã được cập nhật!');
    }

   
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
        
        for ($i = -5; $i <= 2; $i++) {
            $startYear = $currentYear + $i;
            $endYear = $startYear + 4;
            $years["$startYear-$endYear"] = "Năm học $startYear-$endYear";
        }
        
        return $years;
    }
    
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
        ClassRoom::whereIn('id', $classIds)->update(['teacher_id' => null]);
        foreach ($classIds as $classId) {
            $class = ClassRoom::find($classId);
            if ($class) {
                $class->students()->update(['class_id' => null]);
            }
        }
        ClassRoom::whereIn('id', $classIds)->delete();
        
        return redirect()->route('admin.class.index')
            ->with('success', 'Đã xóa thành công ' . count($classIds) . ' lớp học!');
    }
}
