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
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Schema;


class TeacherController extends Controller
{
    /**
     * Display a listing of teachers with advanced search, filter and pagination
     */
    public function index(Request $request)
    {
        // Start query with necessary relationships
        $query = Teacher::with(['user', 'department']);

        // Advanced search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('teacher_code', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('office_location', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by department
        if ($request->filled('department_id') && $request->department_id !== '') {
            $query->where('department_id', $request->department_id);
        }

        // Filter by academic rank
        if ($request->filled('academic_rank') && $request->academic_rank !== '') {
            $query->where('academic_rank', $request->academic_rank);
        }

        // Filter by status (active/inactive users)
        if ($request->filled('status')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                if ($request->status === 'active') {
                    $userQuery->whereNull('deleted_at');
                } elseif ($request->status === 'inactive') {
                    $userQuery->whereNotNull('deleted_at');
                }
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting functionality
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        switch ($sortField) {
            case 'name':
                $query->join('users', 'teachers.user_id', '=', 'users.id')
                      ->orderBy('users.name', $sortDirection)
                      ->select('teachers.*');
                break;
            case 'email':
                $query->join('users', 'teachers.user_id', '=', 'users.id')
                      ->orderBy('users.email', $sortDirection)
                      ->select('teachers.*');
                break;
            case 'department':
                $query->leftJoin('departments', 'teachers.department_id', '=', 'departments.id')
                      ->orderBy('departments.name', $sortDirection)
                      ->select('teachers.*');
                break;
            case 'teacher_code':
                $query->orderBy('teacher_code', $sortDirection);
                break;
            case 'academic_rank':
                $query->orderBy('academic_rank', $sortDirection);
                break;
            case 'specialization':
                $query->orderBy('specialization', $sortDirection);
                break;
            default:
                $query->orderBy('teachers.created_at', $sortDirection);
        }

        // Pagination with custom per page
        $perPage = $request->get('per_page', 10);
        
        // Validate per_page value
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $teachers = $query->paginate($perPage);

        // Preserve query parameters in pagination links
        $teachers->appends($request->all());

        // Get data for filter dropdowns
        $departments = Department::orderBy('name')->get();
        $academicRanks = Teacher::whereNotNull('academic_rank')
                                ->distinct()
                                ->pluck('academic_rank')
                                ->sort()
                                ->values();

        // Statistics for dashboard
        $stats = [
            'total' => Teacher::count(),
            'with_department' => Teacher::whereNotNull('department_id')->count(),
            'without_department' => Teacher::whereNull('department_id')->count(),
            'recent' => Teacher::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        return view('admin.contact.teacher.index', compact(
            'teachers', 
            'departments', 
            'academicRanks', 
            'stats'
        ));
    }

    /**
     * Export filtered results
     */
    public function export(Request $request)
    {
        // Apply same filters as index method
        $query = Teacher::with(['user', 'department']);

        // Apply all the same filters from index method
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('teacher_code', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('department_id') && $request->department_id !== '') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('academic_rank') && $request->academic_rank !== '') {
            $query->where('academic_rank', $request->academic_rank);
        }

        $teachers = $query->get();

        // Return Excel file or CSV
        return response()->streamDownload(function () use ($teachers) {
            $handle = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($handle, [
                'Mã GV',
                'Họ tên',
                'Email',
                'Điện thoại',
                'Khoa/Bộ môn',
                'Học hàm/Học vị',
                'Chuyên ngành',
                'Chức vụ',
                'Phòng làm việc',
                'Ngày tạo'
            ]);

            // Data rows
            foreach ($teachers as $teacher) {
                fputcsv($handle, [
                    $teacher->teacher_code ?? '',
                    $teacher->user->name ?? '',
                    $teacher->user->email ?? '',
                    $teacher->user->phone ?? '',
                    $teacher->department->name ?? '',
                    $teacher->academic_rank ?? '',
                    $teacher->specialization ?? '',
                    $teacher->position ?? '',
                    $teacher->office_location ?? '',
                    $teacher->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($handle);
        }, 'danh-sach-giang-vien-' . date('Y-m-d') . '.csv', [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="danh-sach-giang-vien-' . date('Y-m-d') . '.csv"',
        ]);
    }

    /**
     * Get teachers data for AJAX requests (for datatables or live search)
     */
    public function getData(Request $request)
    {
        $query = Teacher::with(['user', 'department']);

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('teacher_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $teachers = $query->paginate($request->get('per_page', 10));

        return response()->json([
            'data' => $teachers->items(),
            'pagination' => [
                'total' => $teachers->total(),
                'per_page' => $teachers->perPage(),
                'current_page' => $teachers->currentPage(),
                'last_page' => $teachers->lastPage(),
                'from' => $teachers->firstItem(),
                'to' => $teachers->lastItem(),
            ]
        ]);
    }

    /**
     * Bulk actions for multiple teachers
     */
    
    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.contact.teacher.create', compact('departments'));
    }

    /**
     * Store a newly created teacher
     */
    public function store(Request $request)
    {
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

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
        ]);

        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = $avatarName;
            $user->save();
        }

        Teacher::create([
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
     * Display the specified teacher
     */
    public function show($id)
    {
        $teacher = Teacher::with(['user', 'department'])->findOrFail($id);
        return view('admin.contact.teacher.detail', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $departments = Department::orderBy('name')->get();
        return view('admin.contact.teacher.edit', compact('teacher', 'departments'));
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
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

        $user = User::find($teacher->user_id);
        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->email = $validated['email'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = $avatarName;
        }
        
        $user->save();

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
     * Remove the specified teacher
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $user = User::find($teacher->user_id);
        
        if ($user && $user->avatar) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
        
        if ($user) {
            DB::table('user_has_roles')->where('user_id', $user->id)->delete();
                
            DB::table('user_has_permissions')->where('user_id', $user->id)->delete();
                
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);                
            }
        }

        $teacher->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.teacher.index')
            ->with('success', 'Giảng viên đã được xóa thành công!');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,assign_department,export',
            'teacher_ids' => 'required|array',
            'teacher_ids.*' => 'exists:teachers,id',
            'department_id' => 'required_if:action,assign_department|exists:departments,id',
        ]);

        $teachers = Teacher::whereIn('id', $request->teacher_ids);

        switch ($request->action) {
            case 'delete':
                $count = $teachers->count();
                
                // Use transaction to ensure data consistency
                DB::transaction(function () use ($teachers) {
                    foreach ($teachers->get() as $teacher) {
                        $user = User::find($teacher->user_id);
                        
                        if ($user) {
                            // Delete user's roles and permissions
                            DB::table('user_has_roles')->where('user_id', $user->id)->delete();
                            DB::table('user_has_permissions')->where('user_id', $user->id)->delete();
                            
                            // Delete avatar if exists
                            if ($user->avatar) {
                                if (Storage::disk('public')->exists('avatars/' . $user->avatar)) {
                                    Storage::disk('public')->delete('avatars/' . $user->avatar);
                                }
                            }
                        }
                        
                        // Delete teacher first (to avoid foreign key constraint)
                        $teacher->delete();
                        
                        // Then delete user
                        if ($user) {
                            $user->delete();
                        }
                    }
                });
                
                return redirect()->back()->with('success', "Đã xóa {$count} giảng viên thành công!");

            case 'export':
                $teachersList = $teachers->with(['user', 'department'])->get();
                
                return response()->streamDownload(function () use ($teachersList) {
                    $handle = fopen('php://output', 'w');
                    
                    // Add BOM for Excel UTF-8 compatibility
                    fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
                    
                    fputcsv($handle, ['Mã GV', 'Họ tên', 'Email', 'Khoa/Bộ môn', 'Học hàm/Học vị']);
                    
                    foreach ($teachersList as $teacher) {
                        fputcsv($handle, [
                            $teacher->teacher_code ?? '',
                            $teacher->user->name ?? '',
                            $teacher->user->email ?? '',
                            $teacher->department->name ?? '',
                            $teacher->academic_rank ?? '',
                        ]);
                    }
                    
                    fclose($handle);
                }, 'selected-teachers-' . date('Y-m-d') . '.csv');
        }
    }

    public function importForm()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.contact.teacher.import', compact('departments'));
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = [
            'A1' => 'Mã giảng viên',
            'B1' => 'Họ và tên (*)',
            'C1' => 'Email (*)',
            'D1' => 'Mật khẩu (*)',
            'E1' => 'Số điện thoại',
            'F1' => 'Mã khoa/bộ môn',
            'G1' => 'Học hàm/học vị',
            'H1' => 'Chuyên ngành',
            'I1' => 'Chức vụ',
            'J1' => 'Phòng làm việc',
            'K1' => 'Giờ làm việc'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style headers
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4154f1']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ]);

        // Auto size columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Add sample data
        $sampleData = [
            ['GV001', 'Nguyễn Văn A', 'nguyenvana@example.com', 'password123', '0901234567', 'CNTT', 'Tiến sĩ', 'Khoa học máy tính', 'Giảng viên chính', 'A5-301', 'Thứ 2-6: 8h-17h'],
            ['GV002', 'Trần Thị B', 'tranthib@example.com', 'password123', '0902345678', 'KTPM', 'Thạc sĩ', 'Kỹ thuật phần mềm', 'Giảng viên', 'A5-302', 'Thứ 2-6: 8h-17h'],
        ];

        $row = 2;
        foreach ($sampleData as $data) {
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }

        // Add border to sample data
        $sheet->getStyle('A2:K3')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ]);

        // Add instructions
        $sheet->setCellValue('A5', 'HƯỚNG DẪN:');
        $sheet->getStyle('A5')->getFont()->setBold(true);
        
        $instructions = [
            'A6' => '1. Các cột có dấu (*) là bắt buộc phải điền',
            'A7' => '2. Mã khoa/bộ môn phải tồn tại trong hệ thống',
            'A8' => '3. Email phải là duy nhất và đúng định dạng',
            'A9' => '4. Mật khẩu phải có ít nhất 8 ký tự',
            'A10' => '5. Mã giảng viên phải là duy nhất',
            'A11' => '6. Xóa các dòng mẫu (dòng 2-3) trước khi nhập dữ liệu thật'
        ];

        foreach ($instructions as $cell => $instruction) {
            $sheet->setCellValue($cell, $instruction);
        }

        // Add list of departments
        $sheet->setCellValue('M1', 'DANH SÁCH KHOA/BỘ MÔN:');
        $sheet->getStyle('M1')->getFont()->setBold(true);
        
        $departments = Department::select( 'code')->orderBy('code')->get();
        $row = 2;
        foreach ($departments as $dept) {
            $sheet->setCellValue('N' . $row, $dept->code);
            $row++;
        }

        // Add list of academic ranks
        $sheet->setCellValue('P1', 'HỌC HÀM/HỌC VỊ:');
        $sheet->getStyle('P1')->getFont()->setBold(true);
        
        $ranks = ['Giáo sư', 'Phó Giáo sư', 'Tiến sĩ', 'Thạc sĩ', 'Cử nhân', 'Kỹ sư'];
        $row = 2;
        foreach ($ranks as $rank) {
            $sheet->setCellValue('P' . $row, $rank);
            $row++;
        }

        // Create file
        $writer = new Xlsx($spreadsheet);
        $fileName = 'mau_import_giang_vien.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240', // Max 10MB
            'default_department_id' => 'nullable|exists:departments,id',
        ]);

        try {
            DB::beginTransaction();

            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            $imported = 0;
            $skipped = 0;
            $errors = [];

            // Get departments mapping by code
            $departments = Department::pluck('id', 'code')->toArray();
            
            // Bắt đầu từ dòng 2 (bỏ qua header)
            for ($row = 2; $row <= $highestRow; $row++) {
                try {
                    // Đọc dữ liệu từng cell
                    $teacherCode = $worksheet->getCell('A' . $row)->getValue();
                    $name = $worksheet->getCell('B' . $row)->getValue();
                    $email = $worksheet->getCell('C' . $row)->getValue();
                    $password = $worksheet->getCell('D' . $row)->getValue();
                    $phone = $worksheet->getCell('E' . $row)->getValue();
                    $departmentCode = $worksheet->getCell('F' . $row)->getValue();
                    $academicRank = $worksheet->getCell('G' . $row)->getValue();
                    $specialization = $worksheet->getCell('H' . $row)->getValue();
                    $position = $worksheet->getCell('I' . $row)->getValue();
                    $officeLocation = $worksheet->getCell('J' . $row)->getValue();
                    $officeHours = $worksheet->getCell('K' . $row)->getValue();

                    // Skip empty rows
                    if (empty($name) && empty($email)) {
                        continue;
                    }

                    // Trim values
                    $teacherCode = $teacherCode ? trim(strval($teacherCode)) : null;
                    $name = $name ? trim(strval($name)) : '';
                    $email = $email ? trim(strval($email)) : '';
                    $password = $password ? trim(strval($password)) : '';
                    $phone = $phone ? trim(strval($phone)) : null;
                    $departmentCode = $departmentCode ? trim(strval($departmentCode)) : null;
                    $academicRank = $academicRank ? trim(strval($academicRank)) : null;
                    $specialization = $specialization ? trim(strval($specialization)) : null;
                    $position = $position ? trim(strval($position)) : null;
                    $officeLocation = $officeLocation ? trim(strval($officeLocation)) : null;
                    $officeHours = $officeHours ? trim(strval($officeHours)) : null;

                    // Validate required fields
                    if (empty($name)) {
                        $errors[] = "Dòng {$row}: Thiếu họ tên";
                        $skipped++;
                        continue;
                    }
                    
                    if (empty($email)) {
                        $errors[] = "Dòng {$row}: Thiếu email";
                        $skipped++;
                        continue;
                    }
                    
                    if (empty($password)) {
                        $errors[] = "Dòng {$row}: Thiếu mật khẩu";
                        $skipped++;
                        continue;
                    }

                    // Validate email format
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "Dòng {$row}: Email không hợp lệ: '{$email}'";
                        $skipped++;
                        continue;
                    }

                    // Check if email already exists
                    if (User::where('email', $email)->exists()) {
                        $errors[] = "Dòng {$row}: Email '{$email}' đã tồn tại";
                        $skipped++;
                        continue;
                    }

                    // Check if teacher code already exists
                    if ($teacherCode && Teacher::where('teacher_code', $teacherCode)->exists()) {
                        $errors[] = "Dòng {$row}: Mã giảng viên '{$teacherCode}' đã tồn tại";
                        $skipped++;
                        continue;
                    }

                    // Find department ID by code
                    $departmentId = null;
                    if ($departmentCode) {
                        // Check if department code exists in our mapping
                        if (isset($departments[$departmentCode])) {
                            $departmentId = $departments[$departmentCode];
                        } else {
                            // Try to find by code directly in case of case sensitivity issues
                            $foundDept = Department::where('code', $departmentCode)->first();
                            
                            if ($foundDept) {
                                $departmentId = $foundDept->id;
                            } else {
                                $errors[] = "Dòng {$row}: Mã đơn vị '{$departmentCode}' không tồn tại";
                                $skipped++;
                                continue;
                            }
                        }
                    } else {
                        // Use default department if no department code provided
                        $departmentId = $request->default_department_id;
                    }

                    // Validate password length
                    if (strlen($password) < 8) {
                        $errors[] = "Dòng {$row}: Mật khẩu phải có ít nhất 8 ký tự";
                        $skipped++;
                        continue;
                    }

                    // Create user
                    $user = User::create([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($password),
                        'phone' => $phone,
                        'role' => 'teacher',
                    ]);

                    // Assign role if using role tables
                    if (Schema::hasTable('user_has_roles')) {
                        DB::table('user_has_roles')->insert([
                            'user_id' => $user->id,
                            'role_id' => 2, // Assuming 2 is teacher role
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }

                    // Create teacher
                    Teacher::create([
                        'user_id' => $user->id,
                        'teacher_code' => $teacherCode,
                        'department_id' => $departmentId,
                        'academic_rank' => $academicRank,
                        'specialization' => $specialization,
                        'position' => $position,
                        'office_location' => $officeLocation,
                        'office_hours' => $officeHours,
                    ]);

                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Dòng {$row}: " . $e->getMessage();
                    $skipped++;
                }
            }

            DB::commit();

            // Prepare result message
            $message = "Import hoàn tất: {$imported} giảng viên được thêm thành công";
            if ($skipped > 0) {
                $message .= ", {$skipped} dòng bị bỏ qua";
            }

            // Limit errors display
            $displayErrors = array_slice($errors, 0, 10);
            if (count($errors) > 10) {
                $displayErrors[] = "... và " . (count($errors) - 10) . " lỗi khác";
            }

            return redirect()->route('admin.teacher.index')
                ->with('success', $message)
                ->with('import_errors', $displayErrors);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Lỗi khi import file: ' . $e->getMessage());
        }
    }

}