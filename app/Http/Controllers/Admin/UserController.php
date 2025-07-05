<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        
        $sortField = $request->get('sort_field', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortField, $sortOrder);
        $perPage = $request->get('per_page', 10);
        
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

    public function create(){
        $list_classes = ClassRoom::all();
        // $list_roles = DB::table('roles')->whereNot('role_name', 'don_vi');
        $list_roles = DB::table('roles')->whereNot('role_name',  'don_vi')->get();
        $list_department = DB::table('departments')->whereNot('level',1)->get();

        return view('admin.user.create')->with('list_roles', $list_roles)->with('list_classes', $list_classes)->with('list_department', $list_department);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'class_id' => 'nullable',
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
                    'department_id' => $request->department_id,
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
            $userIds = explode(',', $request->user_ids);
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
            User::whereIn('id', $userIds)->delete();
            DB::commit();
            $count = count($userNames);
            $message = "Đã xóa thành công {$count} tài khoản";
            
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