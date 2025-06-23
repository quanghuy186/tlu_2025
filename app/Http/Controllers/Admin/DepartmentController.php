<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::with('manager', 'parent', 'children');

        //search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('phone', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhereHas('manager', function($managerQuery) use ($searchTerm) {
                      $managerQuery->where('name', 'like', "%{$searchTerm}%")
                                  ->orWhere('email', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // filter
        if ($request->filled('parent_filter') && $request->parent_filter !== 'all') {
            if ($request->parent_filter === 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_filter);
            }
        }

        if ($request->filled('level_filter') && $request->level_filter !== 'all') {
            $query->where('level', $request->level_filter);
        }

        if ($request->filled('manager_filter') && $request->manager_filter !== 'all') {
            if ($request->manager_filter === 'has_manager') {
                $query->whereNotNull('user_id');
            } else {
                $query->whereNull('user_id');
            }
        }

        $sortBy = $request->get('sort_by', 'level');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'name') {
            $query->orderBy('name', $sortOrder);
        } elseif ($sortBy === 'code') {
            $query->orderBy('code', $sortOrder);
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        } else {
            $query->orderBy('level', 'asc')->orderBy('name', 'asc');
        }

        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [5, 10, 15, 25, 50]) ? $perPage : 10;

        $departments = $query->paginate($perPage)->appends($request->all());

        $parentDepartments = Department::whereNull('parent_id')
            ->orderBy('name')
            ->get();

        $levels = Department::select('level')
            ->distinct()
            ->orderBy('level')
            ->pluck('level')
            ->filter(function($level) {
                return $level !== null;
            });

        // Thống kê
        $stats = [
            'total' => Department::count(),
            'with_manager' => Department::whereNotNull('user_id')->count(),
            'without_manager' => Department::whereNull('user_id')->count(),
            'root_departments' => Department::whereNull('parent_id')->count(),
        ];

        return view('admin.contact.department.index', compact(
            'departments', 
            'parentDepartments', 
            'levels', 
            'stats'
        ));
    }

    public function create()
    {
        $departments = Department::getSelectOptions();
        return view('admin.contact.department.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments',
            'parent_id' => 'nullable|exists:departments,id',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'manager_name' => 'required|string|max:255',
            'manager_email' => 'required|email|max:255|unique:users,email',
            'manager_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Tên đơn vị không được để trống',
            'name.string' => 'Tên đơn vị phải là chuỗi ký tự',
            'name.max' => 'Tên đơn vị không được vượt quá 100 ký tự',

            'code.required' => 'Mã đơn vị không được để trống',
            'code.string' => 'Mã đơn vị phải là chuỗi ký tự',
            'code.max' => 'Mã đơn vị không được vượt quá 20 ký tự',
            'code.unique' => 'Mã đơn vị đã tồn tại trong hệ thống',

            'parent_id.exists' => 'Đơn vị cha không hợp lệ',

            'description.string' => 'Mô tả phải là chuỗi ký tự',

            'phone.string' => 'Số điện thoại phải là chuỗi ký tự',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',

            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email không được vượt quá 100 ký tự',

            'address.string' => 'Địa chỉ phải là chuỗi ký tự',

            'manager_name.required' => 'Tên người quản lý không được để trống',
            'manager_name.string' => 'Tên người quản lý phải là chuỗi ký tự',
            'manager_name.max' => 'Tên người quản lý không được vượt quá 255 ký tự',

            'manager_email.required' => 'Email người quản lý không được để trống',
            'manager_email.email' => 'Email người quản lý không đúng định dạng',
            'manager_email.max' => 'Email người quản lý không được vượt quá 255 ký tự',
            'manager_email.unique' => 'Email người quản lý đã tồn tại trong hệ thống',

            'manager_avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh',
            'manager_avatar.mimes' => 'Ảnh đại diện phải có định dạng: jpeg, png, jpg, gif',
            'manager_avatar.max' => 'Ảnh đại diện không được vượt quá 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $level = 0;
            if ($request->parent_id) {
                $parentDepartment = Department::find($request->parent_id);
                if ($parentDepartment) {
                    $level = $parentDepartment->level + 1;
                }
            }

            $randomPassword = Str::random(10);
            $manager = new User();
            $manager->name = $request->manager_name;
            $manager->email = $request->manager_email;
            $manager->password = Hash::make($randomPassword);
            $manager->email_verified = 0;
            $manager->is_active = 1;

            if ($request->hasFile('manager_avatar')) {
                $avatar = $request->file('manager_avatar');
                $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                $avatar->storeAs('avatars', $filename, 'public');
                $manager->avatar = $filename;
            }

            $manager->save();

            $department = new Department();
            $department->name = $request->name;
            $department->code = $request->code;
            $department->parent_id = $request->parent_id;
            $department->user_id = $manager->id;
            $department->description = $request->description;
            $department->phone = $request->phone;
            $department->email = $request->email;
            $department->address = $request->address;
            $department->level = $level;
            $department->save();

            DB::commit();

            return redirect()->route('admin.department.index')
                ->with('success', 'Đơn vị đã được tạo thành công. Tài khoản quản lý: ' . $manager->email . ' - Mật khẩu tạm thời: ' . $randomPassword);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => 'Đã xảy ra lỗi khi tạo đơn vị: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $department = Department::with('manager')->findOrFail($id);
        
        // Lấy tất cả đơn vị ngoại trừ chính nó và các đơn vị con cháu
        $excludedIds = $this->getAllDescendantIds($department->id);
        $excludedIds[] = $department->id;
        
        $availableDepartments = Department::whereNotIn('id', $excludedIds)
            ->orderBy('level')
            ->orderBy('name')
            ->get();
        
        $departmentOptions = [];
        foreach ($availableDepartments as $dept) {
            $prefix = str_repeat('— ', $dept->level);
            $departmentOptions[$dept->id] = $prefix . $dept->name;
        }
        
        return view('admin.contact.department.edit', compact('department', 'departmentOptions'));
    }

    private function getAllDescendantIds($departmentId)
    {
        $descendantIds = [];
        $children = Department::where('parent_id', $departmentId)->get();
        
        foreach ($children as $child) {
            $descendantIds[] = $child->id;
            $descendantIds = array_merge($descendantIds, $this->getAllDescendantIds($child->id));
        }
        
        return $descendantIds;
    }

    public function detail($id)
    {
        $department = Department::with(['manager', 'parent', 'children.manager'])
            ->findOrFail($id);
            
        return view('admin.contact.department.detail', compact('department'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::with('manager')->findOrFail($id);
        
        $rules = [
            'name' => 'required|string|max:100',
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('departments')->ignore($id)
            ],
            'parent_id' => [
                'nullable',
                'different:id',
                'exists:departments,id'
            ],
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'manager_name' => 'required|string|max:255',
            'manager_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        if ($department->manager && $request->manager_email != $department->manager->email) {
            $rules['manager_email'] = 'required|email|max:255|unique:users,email';
        } else {
            $rules['manager_email'] = 'required|email|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            if ($request->parent_id) {
                $descendantIds = $this->getAllDescendantIds($department->id);
                if (in_array($request->parent_id, $descendantIds)) {
                    return redirect()->back()
                        ->withErrors(['parent_id' => 'Không thể chọn một đơn vị con làm đơn vị cha.'])
                        ->withInput();
                }
            }

            $oldLevel = $department->level;
            $newLevel = 0;
            
            if ($request->parent_id) {
                $parentDepartment = Department::find($request->parent_id);
                if ($parentDepartment) {
                    $newLevel = $parentDepartment->level + 1;
                }
            }
            
            $levelDifference = $newLevel - $oldLevel;

            $resetPassword = false;
            $newPassword = '';
            $managerId = null;

            if ($department->manager) {
                $department->manager->name = $request->manager_name;
                // Nếu email thay đổi, cập nhật email và tạo mật khẩu mới
                if ($request->manager_email != $department->manager->email) {
                    $department->manager->email = $request->manager_email;
                    $newPassword = Str::random(10);
                    $department->manager->password = Hash::make($newPassword);
                    $resetPassword = true;
                }
                
                if ($request->hasFile('manager_avatar')) {
                    // Xóa avatar cũ nếu có
                    if ($department->manager->avatar) {
                        Storage::disk('public')->delete('avatars/' . $department->manager->avatar);
                    }
                    
                    $avatar = $request->file('manager_avatar');
                    $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                    $avatar->storeAs('avatars', $filename, 'public');
                    $department->manager->avatar = $filename;
                }
                
                $department->manager->save();
                $managerId = $department->manager->id;
            } else {
                // Tạo người quản lý mới nếu chưa có
                $newPassword = Str::random(10);
                $manager = new User();
                $manager->name = $request->manager_name;
                $manager->email = $request->manager_email;
                $manager->password = Hash::make($newPassword);
                $manager->email_verified = 0;
                $manager->is_active = 1;
                
                if ($request->hasFile('manager_avatar')) {
                    $avatar = $request->file('manager_avatar');
                    $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                    $avatar->storeAs('avatars', $filename, 'public');
                    $manager->avatar = $filename;
                }
                
                $manager->save();
                
                $managerId = $manager->id;
                $resetPassword = true;
            }

            $department->name = $request->name;
            $department->code = $request->code;
            $department->parent_id = $request->parent_id;
            $department->user_id = $managerId;
            $department->description = $request->description;
            $department->phone = $request->phone;
            $department->email = $request->email;
            $department->address = $request->address;
            $department->level = $newLevel;
            $department->save();

            if ($levelDifference != 0) {
                $this->updateDescendantLevels($department->id, $levelDifference);
            }

            DB::commit();

            $successMessage = 'Đơn vị đã được cập nhật thành công.';
            if ($resetPassword) {
                $successMessage .= ' Mật khẩu mới cho tài khoản ' . $request->manager_email . ': ' . $newPassword;
            }

            return redirect()->route('admin.department.index')
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật đơn vị: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $department = Department::with('manager')->findOrFail($id);
            // Kiểm tra xem đơn vị có đơn vị con không
            if ($department->children()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa đơn vị này vì nó có các đơn vị con.');
            }
            
            $userId = $department->user_id;
            $department->user_id = null;
            $department->save();
            
            $department->delete();
            
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    if ($user->avatar) {
                        Storage::disk('public')->delete('avatars/' . $user->avatar);
                    }
                    $user->delete();
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.department.index')
                ->with('success', 'Đơn vị và tài khoản quản lý đã được xóa thành công.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi khi xóa đơn vị: ' . $e->getMessage());
        }
    }

    private function updateDescendantLevels($departmentId, $levelDifference)
    {
        $children = Department::where('parent_id', $departmentId)->get();
        
        foreach ($children as $child) {
            $child->level = $child->level + $levelDifference;
            $child->save();
            
            // Đệ quy cập nhật cấp độ cho các đơn vị con
            $this->updateDescendantLevels($child->id, $levelDifference);
        }
    }

    // API endpoint để lấy đơn vị con
    public function getSubDepartments(Request $request)
    {
        $parentId = $request->get('parent_id');
        
        if ($parentId === 'root') {
            $departments = Department::whereNull('parent_id')
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $departments = Department::where('parent_id', $parentId)
                ->orderBy('name')
                ->get(['id', 'name']);
        }
        
        return response()->json($departments);
    }
}