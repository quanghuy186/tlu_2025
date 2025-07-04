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

        return view('home.index')->with('notification_latests', $notification_latests)->with('userRoles', $userRoles);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
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
        'class_id' => 'nullable',
        'address' => 'nullable|string|max:255',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    
    $studentData = $request->input('student');
    
    $user->name = $studentData['name'];
    $user->phone = $studentData['phone'];
    $user->address = $studentData['address'];
    
    // Kiểm tra và tạo mới student nếu chưa tồn tại
    if ($user->student) {
        $user->student->student_code = $studentData['student_id'];
        $user->student->class_id = $studentData['class_id'];
        $user->student->save();
    } else {
        // Tạo mới student record nếu chưa tồn tại
        $student = new \App\Models\Student();
        $student->user_id = $user->id;
        $student->student_code = $studentData['student_id'];
        $student->class_id = $studentData['class_id'];
        $student->save();
    }
}

    private function validateAndUpdateTeacherInfo(Request $request, $user)
{
    $validator = Validator::make($request->input('teacher'), [
        'name' => 'required|string|max:255',
        'teacher_code' => 'required|string|max:20',
        'department_id' => 'nullable',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }
    
    $teacherData = $request->input('teacher');
    
    $user->name = $teacherData['name'];
    $user->phone = $teacherData['phone'];
    $user->address = $teacherData['address'];
    
    if ($user->teacher) {
        $user->teacher->teacher_code = $teacherData['teacher_code'];
        $user->teacher->department_id = $teacherData['department_id'];
        $user->teacher->save();
    } else {
        // Tạo mới teacher record
        $teacher = new \App\Models\Teacher();
        $teacher->user_id = $user->id;
        $teacher->teacher_code = $teacherData['teacher_code'];
        $teacher->department_id = $teacherData['department_id'];
        $teacher->save();
    }
}

    private function validateAndUpdateDepartmentInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('department'), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'description' => 'nullable',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $departmentData = $request->input('department');
        
        if ($user->managedDepartment) {
            $department = $user->managedDepartment;
            $department->name = $departmentData['name'];
            $department->description = $departmentData['description'];
            $department->email = $departmentData['email'];
            $department->phone = $departmentData['phone'];
            $department->address = $departmentData['address'];
            $department->save();
        }
    }

    private function validateAndUpdateModeratorInfo(Request $request, $user)
    {
        $validator = Validator::make($request->input('moderator'), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $moderatorData = $request->input('moderator');
        
        $user->name = $moderatorData['name'];
        $user->phone = $moderatorData['phone'];
        $user->address = $moderatorData['address_mod'];
    }


}