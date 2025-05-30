<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'class']);
        
        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_code', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Lọc theo lớp
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }
        
        // Lọc theo chương trình
        if ($request->has('program') && $request->program != '') {
            $query->where('program', $request->program);
        }
        
        // Lọc theo trạng thái
        if ($request->has('graduation_status') && $request->graduation_status != '') {
            $query->where('graduation_status', $request->graduation_status);
        }
        
        // Lọc theo năm nhập học
        if ($request->has('enrollment_year') && $request->enrollment_year != '') {
            $query->where('enrollment_year', $request->enrollment_year);
        }
        
        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy == 'name') {
            $query->join('users', 'students.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sortOrder)
                  ->select('students.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        // Số lượng items mỗi trang
        $perPage = $request->get('per_page', 10);
        
        // Phân trang với giữ lại query parameters
        $students = $query->paginate($perPage)->appends($request->query());
        
        // Lấy dữ liệu cho dropdown filters
        $classes = ClassRoom::orderBy('class_name')->get();
        $programs = Student::getPrograms();
        $graduationStatuses = Student::getGraduationStatuses();
        $enrollmentYears = Student::distinct()
                                   ->whereNotNull('enrollment_year')
                                   ->orderBy('enrollment_year', 'desc')
                                   ->pluck('enrollment_year');

         // Thống kê
        $stats = [
            'total' => Student::count(),
            'student_k63' => Student::where('enrollment_year', 2021)->count(),
            'student_k64' => Student::where('enrollment_year', 2022)->count(),
            'student_k65' => Student::where('enrollment_year', 2023)->count(),
            'student_k66' => Student::where('enrollment_year', 2024)->count(),
        ];
        
        return view('admin.contact.student.index', compact(
            'students', 
            'classes', 
            'programs', 
            'graduationStatuses',
            'enrollmentYears',
            'stats'
        ));
    }

    public function export(Request $request)
    {
        // Áp dụng các filters giống như index
        $query = Student::with(['user', 'class']);
        
        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_code', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Lọc theo lớp
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }
        
        // Lọc theo chương trình
        if ($request->has('program') && $request->program != '') {
            $query->where('program', $request->program);
        }
        
        // Lọc theo trạng thái
        if ($request->has('graduation_status') && $request->graduation_status != '') {
            $query->where('graduation_status', $request->graduation_status);
        }
        
        // Lọc theo năm nhập học
        if ($request->has('enrollment_year') && $request->enrollment_year != '') {
            $query->where('enrollment_year', $request->enrollment_year);
        }
        
        $students = $query->get();
        
        // Export logic (CSV/Excel)
        // ...
    }

    public function resetFilters()
    {
        return redirect()->route('admin.student.index');
    }

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
            'role' => 'student',
        ]);

        // Upload avatar nếu có
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
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
        $student = Student::with(['user', 'class'])->findOrFail($id);
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
                Storage::delete('public/avatars/' . $user->avatar);
            }
            
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
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
        try {
            DB::beginTransaction();
            
            $student = Student::findOrFail($id);
            $user = User::find($student->user_id);
            
            // Xóa các quan hệ của user trước
            if ($user) {
                // Xóa user_has_roles
                DB::table('user_has_roles')->where('user_id', $user->id)->delete();
                
                // Xóa user_has_permissions
                DB::table('user_has_permissions')->where('user_id', $user->id)->delete();
                
                // Xóa avatar nếu có
                if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                    Storage::delete('public/avatars/' . $user->avatar);
                }
            }
            
            // Xóa student
            $student->delete();
            
            // Xóa user
            if ($user) {
                $user->delete();
            }
            
            DB::commit();

            return redirect()->route('admin.student.index')
                ->with('success', 'Sinh viên đã được xóa thành công!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.student.index')
                ->with('error', 'Không thể xóa sinh viên. Lỗi: ' . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)     
{         
    try {             
        // Validate input             
        $request->validate([                 
            'student_ids' => 'required|string'             
        ]);                          
        
        // Chuyển đổi string thành array và làm sạch             
        $studentIds = explode(',', $request->student_ids);             
        $studentIds = array_filter(array_map('trim', $studentIds));             
        $studentIds = array_map('intval', $studentIds);             
        $studentIds = array_filter($studentIds, function($id) { return $id > 0; });                          
        
        if (empty($studentIds)) {                 
            return redirect()->route('admin.student.index')                     
                ->with('error', 'Không có sinh viên nào được chọn để xóa.');             
        }                          
        
        DB::beginTransaction();                          
        
        // Lấy thông tin students và user_ids trước khi xóa             
        $students = Student::whereIn('id', $studentIds)->get();             
        
        if ($students->isEmpty()) {                 
            DB::rollBack();                 
            return redirect()->route('admin.student.index')                     
                ->with('error', 'Không tìm thấy sinh viên nào để xóa.');             
        }
        
        $studentNames = [];             
        $userIds = [];             
        $avatarsToDelete = [];                          
        
        foreach ($students as $student) {                 
            // Lấy tên sinh viên                 
            $studentInfo = $student->student_code ?                      
                $student->student_code . ' - ' . $student->user->name :                      
                $student->user->name;                 
            $studentNames[] = $studentInfo;                                  
            
            // Lấy user_id để xóa user                 
            $userIds[] = $student->user_id;                                  
            
            // Lưu avatar để xóa file                 
            if ($student->user && $student->user->avatar) {                     
                $avatarsToDelete[] = $student->user->avatar;                 
            }             
        }                          
        
        // Xóa các quan hệ liên quan             
        if (!empty($userIds)) {
            DB::table('user_has_roles')->whereIn('user_id', $userIds)->delete();             
            DB::table('user_has_permissions')->whereIn('user_id', $userIds)->delete();
        }                          
        
        // Xóa students trước             
        Student::whereIn('id', $studentIds)->delete();                          
        
        // Sau đó xóa users             
        if (!empty($userIds)) {
            User::whereIn('id', $userIds)->delete();             
        }
        
        // Xóa files avatar             
        foreach ($avatarsToDelete as $avatar) {                 
            $avatarPath = 'public/avatars/' . $avatar;
            if (Storage::exists($avatarPath)) {                     
                Storage::delete($avatarPath);                 
            }             
        }                          
        
        DB::commit();                          
        
        $count = count($studentNames);             
        $message = "Đã xóa thành công {$count} sinh viên";                          
        
        // Nếu ít hơn 5 sinh viên, liệt kê tên             
        if ($count <= 5 && $count > 0) {                 
            $message .= ": " . implode(', ', $studentNames);             
        }                          
        
        return redirect()->route('admin.student.index')             
            ->with('success', $message);                          
            
    } catch (\Exception $e) {             
        DB::rollBack();             
        Log::error('Student bulk delete error: ' . $e->getMessage());             
        
        return redirect()->route('admin.student.index')             
            ->with('error', "Không thể xóa sinh viên. Lỗi: " . $e->getMessage());         
    }     
}

    

}