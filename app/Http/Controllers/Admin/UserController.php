<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\UserHasPermission;
use App\Models\UserHasRole;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserController extends Controller
{
    public function index(Request $request){
        $query = User::query();
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->has('email_verified') && $request->email_verified != '') {
            $query->where('email_verified', $request->email_verified);
        }
        
        if ($request->has('is_active') && $request->is_active != '') {
            $query->where('is_active', $request->is_active);
        }
        
         if ($request->has('role_id') && $request->role_id != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('role_id', $request->role_id);
            });
        }
        
        // Sắp xếp
        $sortField = $request->get('sort_field', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);
        
        $perPage = $request->get('per_page', 10);
        
        // Phân trang với giữ lại các tham số tìm kiếm
        $users = $query->paginate($perPage)->appends($request->all());
        
        $roles = Role::all();
        
        return view('admin.user.index', compact('users', 'roles'));
    }

    
    public function showDepartment(){
        $users = DB::table('users')->get();
        return view('admin.user.department.index')->with('users', $users);
    }

    public function showImportForm()
    {
        return view('admin.user.import-excel');
    }

    public function downloadExcelTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Thiết lập header
        $sheet->setCellValue('A1', 'Họ và tên');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Mật khẩu');
        $sheet->setCellValue('D1', 'Trạng thái kích hoạt (1: Đã kích hoạt, 0: Chưa kích hoạt) [Mặc định: 1]');
        $sheet->setCellValue('E1', 'Trạng thái tài khoản (1: Hoạt động, 0: Ngừng hoạt động) [Mặc định: 1]');
        
        // Định dạng header
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FFD3D3D3');
        
        // Thiết lập dữ liệu mẫu
        $sheet->setCellValue('A2', 'Nguyễn Văn A');
        $sheet->setCellValue('B2', 'nguyenvana@example.com');
        $sheet->setCellValue('C2', '12345678');
        $sheet->setCellValue('D2', '1');
        $sheet->setCellValue('E2', '1');
        
        $sheet->setCellValue('A3', 'Trần Thị B');
        $sheet->setCellValue('B3', 'tranthib@example.com');
        $sheet->setCellValue('C3', '87654321');
        
        // Thêm chỉ dẫn
        $sheet->setCellValue('A5', 'Lưu ý:');
        $sheet->setCellValue('A6', '- Họ tên, Email và Mật khẩu là bắt buộc');
        $sheet->setCellValue('A7', '- Cột Trạng thái kích hoạt và Trạng thái tài khoản là tùy chọn, mặc định là 1 (Đã kích hoạt/Hoạt động)');
        $sheet->setCellValue('A8', '- Mật khẩu phải có ít nhất 6 ký tự');
        
        // Định dạng chỉ dẫn
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->mergeCells('A6:E6');
        $sheet->mergeCells('A7:E7');
        $sheet->mergeCells('A8:E8');
        
        // Thiết lập độ rộng cột
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(50);
        
        // download
        $filename = 'user_import_template.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function processImportExcel(Request $request)
    {
        // Kiểm tra file đã được upload
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // max 10MB
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        try {
            // Đọc file Excel
            $file = $request->file('excel_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            // Bỏ qua header
            array_shift($rows);
            
            // Mảng chứa thông báo lỗi và thành công
            $messages = [
                'success' => [],
                'error' => []
            ];
            
            // Bắt đầu transaction
            DB::beginTransaction();
            
            foreach ($rows as $index => $row) {
                // Bỏ qua các dòng trống
                if (empty($row[0]) && empty($row[1])) {
                    continue;
                }
                
                // Lấy dữ liệu từ hàng
                $name = trim($row[0]);
                $email = trim($row[1]);
                $password = trim($row[2]);
                // Mặc định kích hoạt và hoạt động
                $email_verified = isset($row[3]) ? (int)$row[3] : 1; // Mặc định đã kích hoạt
                $is_active = isset($row[4]) ? (int)$row[4] : 1; // Mặc định hoạt động
                
                // Xác thực dữ liệu
                $rowValidator = Validator::make(
                    [
                        'name' => $name,
                        'email' => $email,
                        'password' => $password
                    ],
                    [
                        'name' => 'required|string|max:255',
                        'email' => [
                            'required',
                            'email',
                            Rule::unique('users', 'email')
                        ],
                        'password' => 'required|string|min:6'
                    ]
                );
                
                if ($rowValidator->fails()) {
                    $rowErrors = $rowValidator->errors()->all();
                    $messages['error'][] = "Dòng " . ($index + 2) . ": " . implode(', ', $rowErrors);
                    continue;
                }
                
                // Tạo người dùng mới
                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->password = Hash::make($password);
                $user->email_verified = $email_verified;
                $user->is_active = $is_active;
                
                // Nếu tự động kích hoạt
                if ($email_verified == 1) {
                    $user->email_verified_at = now();
                }
                
                $user->save();
                
                $messages['success'][] = "Tài khoản '{$email}' đã được tạo thành công.";
            }
            
            // Commit transaction nếu không có lỗi
            if (empty($messages['error'])) {
                DB::commit();
                return redirect()->route('admin.user.index')
                    ->with('success', 'Đã nhập ' . count($messages['success']) . ' tài khoản thành công.');
            } else {
                // Rollback nếu có lỗi
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Có lỗi xảy ra: ' . implode('<br>', $messages['error']))
                    ->with('success', empty($messages['success']) ? null : implode('<br>', $messages['success']));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function create(){
        $list_classes = ClassRoom::all();
        $list_roles = Role::all();
        return view('admin.user.create')->with('list_roles', $list_roles)->with('list_classes', $list_classes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'class_id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        
        try {
            DB::beginTransaction();
            
            $user = new User();
            $user->name = $request->fullname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;
            
            if (isset($request->status)) {
                $user->is_active = ($request->status === 'active') ? 1 : 0;
                $user->email_verified = ($request->status === 'active') ? 1 : 0;
            }
            
            // Save the user first to get an ID
            $user->save();
            
            $user_role_id = $request->role_id;
            
            if ($user_role_id == 1) {
                DB::table('students')->insert([
                    'user_id' => $user->id,
                    'class_id' => $request->class_id,
                ]);
            } else {
                DB::table('teachers')->insert([
                    'user_id' => $user->id,
                ]);
            }

            $userHasRole = new UserHasRole();
            $userHasRole->user_id = $user->id;
            $userHasRole->role_id = $user_role_id;
            $userHasRole->save();
            
            DB::commit();
            
            return redirect()->route('admin.user.index')
                ->with('success', 'Tài khoản đã được tạo thành công!');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id){
        $user = User::find($id);
        return view('admin.user.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'required|boolean',
            'email_verified' => 'required|boolean',  
        ]);

        $user = User::findOrFail($id);
        
        $user->name = $request->name;
        $user->is_active = $request->is_active;
        $user->email_verified = $request->email_verified;  
        $user->save();

        return redirect()->route('admin.user.index')
            ->with('success', 'Thông tin tài khoản đã được cập nhật thành công.');
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        
        $userRoles = UserHasRole::where('user_id', $id)->with('role')->get();
        
        $userPermissions = UserHasPermission::where('user_id', $id)->with('permission')->get();
        
        $roles = $userRoles->map(function($userRole) {
            return $userRole->role;
        });
        
        $permissions = $userPermissions->map(function($userPermission) {
            return $userPermission->permission;
        });
        
        return view('admin.user.detail', compact('user', 'roles', 'permissions'));
    }

    public function destroy($id)
    {
        try {
            if (Auth::user()->id == $id) {
                return redirect()->route('admin.user.index')
                    ->with('error', 'Bạn không thể xóa tài khoản của chính mình.');
            }
    
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $userName = $user->name;
            DB::table('user_has_roles')->where('user_id', $id)->delete();
            DB::table('students')->where('user_id', $id)->delete();
            DB::table('teachers')->where('user_id', $id)->delete();
            if ($user->managedDepartment) {
                $departmentId = $user->managedDepartment->id;
                ClassRoom::where('department_id', $departmentId)->update(['department_id' => null]);
                Teacher::where('department_id', $departmentId)->update(['department_id' => null]);
                DB::table('departments')->where('user_id', $id)->update(['user_id' => null]);
            }

            $user->delete();
            DB::commit();
            
            return redirect()->route('admin.user.index')
                ->with('success', "Tài khoản '{$userName}' đã được xóa thành công.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.user.index')
                ->with('error', "Không thể xóa tài khoản. Lỗi: " . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        try {
            $request->validate([
                'user_ids' => 'required|string'
            ]);
            
            // Chuyển đổi string thành array
            $userIds = explode(',', $request->user_ids);
            
            // Loại bỏ ID của user hiện tại để tránh tự xóa chính mình
            $currentUserId = Auth::user()->id;
            $userIds = array_filter($userIds, function($id) use ($currentUserId) {
                return $id != $currentUserId;
            });
            
            if (empty($userIds)) {
                return redirect()->route('admin.user.index')
                    ->with('error', 'Không có tài khoản nào được chọn để xóa.');
            }
            
            DB::beginTransaction();
            
            $users = User::whereIn('id', $userIds)->get();
            $userNames = $users->pluck('name')->toArray();
            
            DB::table('user_has_roles')->whereIn('user_id', $userIds)->delete();
            DB::table('user_has_permissions')->whereIn('user_id', $userIds)->delete();
            DB::table('students')->whereIn('user_id', $userIds)->delete();
            DB::table('teachers')->whereIn('user_id', $userIds)->delete();
            
            // Xóa users
            User::whereIn('id', $userIds)->delete();
            
            DB::commit();
            
            $count = count($userNames);
            $message = "Đã xóa thành công {$count} tài khoản";
            
            // Nếu ít hơn 5 tài khoản, liệt kê tên
            if ($count <= 5) {
                $message .= ": " . implode(', ', $userNames);
            }
            
            return redirect()->route('admin.user.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.user.index')
                ->with('error', "Không thể xóa tài khoản. Lỗi: " . $e->getMessage());
        }
    }
}