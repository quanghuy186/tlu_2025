<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with(['user', 'department'])->paginate(10);
        return view('admin.contact.teacher.index', compact('teachers'));
    }

    /**
     * Hiển thị form tạo giảng viên mới
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.contact.teacher.create', compact('departments'));
    }

    /**
     * Lưu giảng viên mới vào database
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'department_id' => 'nullable|exists:departments,id',
            'teacher_code' => 'nullable|string|max:20|unique:teachers',
            'academic_rank' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'office_location' => 'nullable|string|max:100',
            'office_hours' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tạo user mới
        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher', // Giả sử bạn có trường role trong bảng users
        ]);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName);
            $user->avatar = $avatarName;
            $user->save();
        }

        // Tạo thông tin giảng viên
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'] ?? null,
            'teacher_code' => $validated['teacher_code'] ?? null,
            'academic_rank' => $validated['academic_rank'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'position' => $validated['position'] ?? null,
            'office_location' => $validated['office_location'] ?? null,
            'office_hours' => $validated['office_hours'] ?? null,
        ]);

        return redirect()->route('admin.teacher.index')
            ->with('success', 'Giảng viên đã được tạo thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết giảng viên
     */
    public function show($id)
    {
        $teacher = Teacher::with(['user', 'department'])->findOrFail($id);
        return view('admin.contact.teacher.detail', compact('teacher'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin giảng viên
     */
    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $departments = Department::all();
        return view('admin.contact.teacher.edit', compact('teacher', 'departments'));
    }

    /**
     * Cập nhật thông tin giảng viên
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        // Validate dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($teacher->user_id),
            ],
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'teacher_code' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('teachers')->ignore($teacher->id),
            ],
            'academic_rank' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:100',
            'position' => 'nullable|string|max:100',
            'office_location' => 'nullable|string|max:100',
            'office_hours' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        // Cập nhật thông tin user
        $user = User::find($teacher->user_id);
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
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

        // Cập nhật thông tin giảng viên
        $teacher->update([
            'department_id' => $validated['department_id'] ?? null,
            'teacher_code' => $validated['teacher_code'] ?? null,
            'academic_rank' => $validated['academic_rank'] ?? null,
            'specialization' => $validated['specialization'] ?? null,
            'position' => $validated['position'] ?? null,
            'office_location' => $validated['office_location'] ?? null,
            'office_hours' => $validated['office_hours'] ?? null,
        ]);

        return redirect()->route('admin.teacher.index')
            ->with('success', 'Thông tin giảng viên đã được cập nhật!');
    }

    /**
     * Xóa giảng viên
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = User::find($teacher->user_id);
        
        // Xóa avatar nếu có
        if ($user && $user->avatar) {
            Storage::delete('avatars/' . $user->avatar);
        }
        
        // Xóa teacher trước, sau đó xóa user
        $teacher->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.teacher.index')
            ->with('success', 'Giảng viên đã được xóa thành công!');
    }
}
