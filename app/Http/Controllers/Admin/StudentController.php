<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'classWithDetails'])->paginate(15);
        return view('admin.contact.student.index', compact('students'));
    }

    /**
     * Hiển thị form tạo sinh viên mới
     */
    public function create()
    {
        $classes = ClassRoom::all();
        $programs = Student::getPrograms();
        $graduationStatuses = Student::getGraduationStatuses();
        $currentYear = date('Y');
        $enrollmentYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.contact.student.create', compact('classes', 'programs', 'graduationStatuses', 'enrollmentYears'));
    }

    /**
     * Lưu sinh viên mới vào database
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'class_id' => 'nullable|exists:classes,id',
            'student_code' => 'nullable|string|max:20|unique:students',
            'enrollment_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'program' => 'nullable|string|max:50',
            'graduation_status' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tạo user mới
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student', // Giả sử bạn có trường role trong bảng users
        ]);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user->avatar = $avatarName;
            $user->save();
        }

        // Tạo thông tin sinh viên
        $student = Student::create([
            'user_id' => $user->id,
            'class_id' => $validated['class_id'] ?? null,
            'student_code' => $validated['student_code'] ?? null,
            'enrollment_year' => $validated['enrollment_year'] ?? null,
            'program' => $validated['program'] ?? null,
            'graduation_status' => $validated['graduation_status'] ?? 'studying',
        ]);

        return redirect()->route('admin.student.index')
            ->with('success', 'Sinh viên đã được tạo thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết sinh viên
     */
    public function show($id)
    {
        $student = Student::with(['user', 'classWithDetails'])->findOrFail($id);
        return view('admin.contact.student.detail', compact('student'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin sinh viên
     */
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $classes = ClassRoom::all();
        $programs = Student::getPrograms();
        $graduationStatuses = Student::getGraduationStatuses();
        $currentYear = date('Y');
        $enrollmentYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.contact.student.edit', compact('student', 'classes', 'programs', 'graduationStatuses', 'enrollmentYears'));
    }

    /**
     * Cập nhật thông tin sinh viên
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($student->user_id),
            ],
            'class_id' => 'nullable|exists:classes,id',
            'student_code' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('students')->ignore($student->id),
            ],
            'enrollment_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'program' => 'nullable|string|max:50',
            'graduation_status' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        // Cập nhật thông tin user
        $user = User::find($student->user_id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Upload avatar mới nếu có
        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }
            
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user->avatar = $avatarName;
        }
        
        $user->save();

        // Cập nhật thông tin sinh viên
        $student->update([
            'class_id' => $validated['class_id'] ?? null,
            'student_code' => $validated['student_code'] ?? null,
            'enrollment_year' => $validated['enrollment_year'] ?? null,
            'program' => $validated['program'] ?? null,
            'graduation_status' => $validated['graduation_status'] ?? 'studying',
        ]);

        return redirect()->route('admin.student.index')
            ->with('success', 'Thông tin sinh viên đã được cập nhật!');
    }

    /**
     * Xóa sinh viên
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = User::find($student->user_id);
        
        // Xóa avatar nếu có
        if ($user && $user->avatar) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        
        // Xóa student trước, sau đó xóa user
        $student->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.student.index')
            ->with('success', 'Sinh viên đã được xóa thành công!');
    }
}
