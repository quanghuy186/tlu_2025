<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index(){
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        $userRoles = Auth()->user()->roles;

        $classes = ClassRoom::all();

        return view('home.index')->with('notification_latests', $notification_latests)->with('userRoles', $userRoles)
        ->with('classes', $classes);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Xác thực dữ liệu chung
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|integer|min:1|max:4',
            'avatar' => 'nullable|image|max:2048',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('/avatars', $filename);
            $user->avatar = $filename;
        }
        
        $roleId = $request->input('role_id');
        
        switch ($roleId) {
            case 1: // Sinh viên
                if (hasRole(1, $user)) {
                    $this->validateAndUpdateStudentInfo($request, $user);
                }
                break;
                
            case 2: // Giảng viên
                if (hasRole(2, $user)) {
                    $this->validateAndUpdateTeacherInfo($request, $user);
                }
                break;
                
            case 3: // Đơn vị
                if (hasRole(3, $user)) {
                    $this->validateAndUpdateDepartmentInfo($request, $user);
                }
                break;
                
            case 4: // Kiểm duyệt viên
                if (hasRole(4, $user)) {
                    $this->validateAndUpdateModeratorInfo($request, $user);
                }
                break;
        }
        
        // Lưu thông tin người dùng
        $user->save();
        
        return redirect()->back()->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }

    private function validateAndUpdateStudentInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('student'), [
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $studentData = $request->input('student');
        
        $user->name = $studentData['name'];
        if ($user->student) {
            $user->student->student_code = $studentData['student_id'];
            $user->student->class_id = $studentData['class_id'];
            $user->student->save();
        }
        $user->phone = $studentData['phone'];
        $user->address = $studentData['address'];
    }

    // Phương thức xử lý thông tin giảng viên
    private function validateAndUpdateTeacherInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('teacher'), [
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|string|max:20',
            'faculty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'academic_title' => 'nullable|string|max:50',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $teacherData = $request->input('teacher');
        
        $user->name = $teacherData['name'];
        $user->teacher_id = $teacherData['teacher_id'];
        $user->faculty = $teacherData['faculty'];
        $user->phone = $teacherData['phone'];
        $user->address = $teacherData['address'];
        $user->academic_title = $teacherData['academic_title'];
    }

    // Phương thức xử lý thông tin đơn vị
    private function validateAndUpdateDepartmentInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('department'), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $departmentData = $request->input('department');
        
        // Cập nhật thông tin đơn vị
        if ($user->managedDepartment) {
            $department = $user->managedDepartment;
            $department->name = $departmentData['name'];
            $department->type = $departmentData['type'];
            $department->email = $departmentData['email'];
            $department->phone = $departmentData['phone'];
            $department->address = $departmentData['address'];
            $department->save();
        }
    }

    // Phương thức xử lý thông tin kiểm duyệt viên (tiếp theo)
    private function validateAndUpdateModeratorInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('moderator'), [
            'name' => 'required|string|max:255',
            'moderator_id' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $moderatorData = $request->input('moderator');
        
        $user->name = $moderatorData['name'];
        $user->moderator_id = $moderatorData['moderator_id'];
        $user->phone = $moderatorData['phone'];
        $user->department_id = $moderatorData['department_id'];
    }


}