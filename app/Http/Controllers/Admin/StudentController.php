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
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['user', 'class']);
        
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
        
        if ($request->has('class_id') && $request->class_id != '') {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->has('enrollment_year') && $request->enrollment_year != '') {
            $query->where('enrollment_year', $request->enrollment_year);
        }
        
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if ($sortBy == 'name') {
            $query->join('users', 'students.user_id', '=', 'users.id')
                  ->orderBy('users.name', $sortOrder)
                  ->select('students.*');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }
        
        $perPage = $request->get('per_page', 10);
        
        $students = $query->paginate($perPage)->appends($request->query());
        
        $classes = ClassRoom::orderBy('class_name')->get();
        $enrollmentYears = Student::distinct()
                                   ->whereNotNull('enrollment_year')
                                   ->orderBy('enrollment_year', 'desc')
                                   ->pluck('enrollment_year');
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
            'enrollmentYears',
            'stats'
        ));
    }

    public function resetFilters()
    {
        return redirect()->route('admin.student.index');
    }

    public function create()
    {
        $classes = ClassRoom::all();
        $currentYear = date('Y');
        $enrollmentYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.contact.student.create', compact('classes', 'enrollmentYears'));
    }

  
    public function store(Request $request)
    {
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
        ],[
            'name.required' => 'Tên sinh viên là bắt buộc',
            'email.unique' => 'Email đã được sử dụng',
            'student_code.unique' => 'Mã sinh viên đã tồn tại',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = $avatarName;
            $user->save();
        }

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

    public function show($id)
    {
        $student = Student::with(['user', 'class'])->findOrFail($id);
        return view('admin.contact.student.detail', compact('student'));
    }

    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $classes = ClassRoom::all();
        // $programs = Student::getPrograms();
        // $graduationStatuses = Student::getGraduationStatuses();
        $currentYear = date('Y');
        $enrollmentYears = range($currentYear - 10, $currentYear + 1);
        
        return view('admin.contact.student.edit', compact('student', 'classes', 'enrollmentYears'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
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
        ],[
            'name.required' => 'Tên sinh viên là bắt buộc',
            'email.unique' => 'Email đã được sử dụng',
            'student_code.unique' => 'Mã sinh viên đã tồn tại',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
        ]);

        $user = User::find($student->user_id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = $avatarName;
        }
        
        $user->save();

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

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $student = Student::findOrFail($id);
            $user = User::find($student->user_id);
            
            if ($user) {
                DB::table('user_has_roles')->where('user_id', $user->id)->delete();
                DB::table('user_has_permissions')->where('user_id', $user->id)->delete();
                if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                    Storage::delete('public/avatars/' . $user->avatar);
                }
            }
            
            $student->delete();
            
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
            $request->validate([                 
                'student_ids' => 'required|string'             
            ]);                          
            
            $studentIds = explode(',', $request->student_ids);             
            $studentIds = array_filter(array_map('trim', $studentIds));             
            $studentIds = array_map('intval', $studentIds);             
            $studentIds = array_filter($studentIds, function($id) { return $id > 0; });                          
            
            if (empty($studentIds)) {                 
                return redirect()->route('admin.student.index')                     
                    ->with('error', 'Không có sinh viên nào được chọn để xóa.');             
            }                          
            
            DB::beginTransaction();                          
            
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
                $studentInfo = $student->student_code ?                      
                    $student->student_code . ' - ' . $student->user->name :                      
                    $student->user->name;                 
                $studentNames[] = $studentInfo;                                  
                
                $userIds[] = $student->user_id;                                  
                if ($student->user && $student->user->avatar) {                     
                    $avatarsToDelete[] = $student->user->avatar;                 
                }             
            }                          
            
            if (!empty($userIds)) {
                DB::table('user_has_roles')->whereIn('user_id', $userIds)->delete();             
                DB::table('user_has_permissions')->whereIn('user_id', $userIds)->delete();
            }                          
            
            Student::whereIn('id', $studentIds)->delete();                          
            
            if (!empty($userIds)) {
                User::whereIn('id', $userIds)->delete();             
            }
            
            foreach ($avatarsToDelete as $avatar) {                 
                $avatarPath = 'public/avatars/' . $avatar;
                if (Storage::exists($avatarPath)) {                     
                    Storage::delete($avatarPath);                 
                }             
            }                          
            
            DB::commit();                          
            
            $count = count($studentNames);             
            $message = "Đã xóa thành công {$count} sinh viên";                          
            
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

    public function importForm()
    {
        $classes = ClassRoom::orderBy('class_name')->get();
        return view('admin.contact.student.import', compact('classes'));
    }


    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'A1' => 'Mã sinh viên (*)',
            'B1' => 'Họ và tên (*)',
            'C1' => 'Email (*)',
            'D1' => 'Mật khẩu (*)',
            'E1' => 'Mã lớp',
            'F1' => 'Năm nhập học',
            'G1' => 'Chương trình',
            'H1' => 'Trạng thái (studying/graduated/suspended)'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E7E6E6']
            ]
        ]);

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->setCellValue('A2', 'SV001');
        $sheet->setCellValue('B2', 'Nguyễn Văn A');
        $sheet->setCellValue('C2', 'nguyenvana@example.com');
        $sheet->setCellValue('D2', 'password123');
        $sheet->setCellValue('E2', 'CNTT1');
        $sheet->setCellValue('F2', '2024');
        $sheet->setCellValue('G2', 'Công nghệ thông tin');
        $sheet->setCellValue('H2', 'studying');

        $sheet->setCellValue('A4', 'Hướng dẫn:');
        $sheet->setCellValue('A5', '- Các cột có dấu (*) là bắt buộc');
        $sheet->setCellValue('A6', '- Mã lớp phải tồn tại trong hệ thống');
        $sheet->setCellValue('A7', '- Email phải duy nhất');
        $sheet->setCellValue('A8', '- Mật khẩu tối thiểu 8 ký tự');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'student_import_template.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
            'default_class_id' => 'nullable|exists:classes,id',
            'default_enrollment_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $header = array_shift($rows);
            $imported = 0;
            $skipped = 0;
            $errors = [];

            $classes = ClassRoom::pluck('id', 'class_code')->toArray();

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; 

                if (empty(array_filter($row))) {
                    continue;
                }
                try {
                    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
                        $errors[] = "Dòng {$rowNumber}: Thiếu thông tin bắt buộc";
                        $skipped++;
                        continue;
                    }
                    $studentCode = trim($row[0]);
                    $name = trim($row[1]);
                    $email = trim($row[2]);
                    $password = trim($row[3]);
                    $class_code = !empty($row[4]) ? trim($row[4]) : null;
                    $enrollmentYear = !empty($row[5]) ? intval($row[5]) : $request->default_enrollment_year;

                    if (User::where('email', $email)->exists()) {
                        $errors[] = "Dòng {$rowNumber}: Email '{$email}' đã tồn tại";
                        $skipped++;
                        continue;
                    }

                    if (Student::where('student_code', $studentCode)->exists()) {
                        $errors[] = "Dòng {$rowNumber}: Mã sinh viên '{$studentCode}' đã tồn tại";
                        $skipped++;
                        continue;
                    }

                    $classId = null;
                    if ($class_code && isset($classes[$class_code])) {
                        $classId = $classes[$class_code];
                    } elseif ($class_code) {
                        $errors[] = "Dòng {$rowNumber}: Lớp '{$class_code}' không tồn tại";
                        $skipped++;
                        continue;
                    } else {
                        $classId = $request->default_class_id;
                    }

                    if (strlen($password) < 8) {
                        $errors[] = "Dòng {$rowNumber}: Mật khẩu phải có ít nhất 8 ký tự";
                        $skipped++;
                        continue;
                    }

                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                    ]);

                    DB::table('user_has_roles')->insert([
                        'user_id' => $user->id,
                        'role_id' => 1,
                    ]);

                    Student::create([
                        'user_id' => $user->id,
                        'student_code' => $studentCode,
                        'class_id' => $classId,
                        'enrollment_year' => $enrollmentYear,
                    ]);

                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Dòng {$rowNumber}: " . $e->getMessage();
                    $skipped++;
                    Log::error("Import student error at row {$rowNumber}: " . $e->getMessage());
                }
            }

            DB::commit();

            $message = "Import hoàn tất: {$imported} sinh viên được thêm thành công";
            if ($skipped > 0) {
                $message .= ", {$skipped} dòng bị bỏ qua";
            }

            return redirect()->route('admin.student.index')
                ->with('success', $message)
                ->with('import_errors', $errors);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Student import error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Lỗi khi import file: ' . $e->getMessage());
        }
    }

}