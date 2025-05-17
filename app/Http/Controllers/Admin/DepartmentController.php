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
    public function index(){

        $departments = Department::with('manager', 'parent', 'children')
            ->orderBy('level')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.contact.department.index', compact('departments'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            // Tính toán level dựa trên đơn vị cha
            $level = 0;
            if ($request->parent_id) {
                $parentDepartment = Department::find($request->parent_id);
                if ($parentDepartment) {
                    $level = $parentDepartment->level + 1;
                }
            }

            // Tạo người quản lý mới cho đơn vị
            $randomPassword = Str::random(10);
            $manager = new User();
            $manager->name = $request->manager_name;
            $manager->email = $request->manager_email;
            $manager->password = Hash::make($randomPassword);
            $manager->email_verified = 0; // Chưa xác thực email
            $manager->is_active = 1; // Trạng thái hoạt động

            // Xử lý upload avatar nếu có
            if ($request->hasFile('manager_avatar')) {
                $avatar = $request->file('manager_avatar');
                $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                
                // Thay đổi từ 'avatars' thành 'public/avatars' hoặc chỉ định disk 'public'
                $avatar->storeAs('avatars', $filename, 'public');
                
                $manager->avatar = $filename;
            }

            $manager->save();

            // Tạo đơn vị mới và liên kết với người quản lý
            $department = new Department();
            $department->name = $request->name;
            $department->code = $request->code;
            $department->parent_id = $request->parent_id;
            $department->user_id = $manager->id; // Liên kết với người quản lý vừa tạo
            $department->description = $request->description;
            $department->phone = $request->phone;
            $department->email = $request->email;
            $department->address = $request->address;
            $department->level = $level;
            $department->save();

            // Commit transaction
            DB::commit();

            // Hiển thị thông báo với mật khẩu tạm thời
            return redirect()->route('admin.department.index')
                ->with('success', 'Đơn vị đã được tạo thành công. Tài khoản quản lý: ' . $manager->email . ' - Mật khẩu tạm thời: ' . $randomPassword);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
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

    // public function update(Request $request, $id)
    // {
    //     $department = Department::with('manager')->findOrFail($id);
        
    //     // Chuẩn bị quy tắc xác thực
    //     $rules = [
    //         'name' => 'required|string|max:100',
    //         'code' => [
    //             'required',
    //             'string',
    //             'max:20',
    //             Rule::unique('departments')->ignore($id)
    //         ],
    //         'parent_id' => [
    //             'nullable',
    //             'different:id',
    //             'exists:departments,id'
    //         ],
    //         'description' => 'nullable|string',
    //         'phone' => 'nullable|string|max:20',
    //         'email' => 'nullable|email|max:100',
    //         'address' => 'nullable|string',
    //         'manager_name' => 'required|string|max:255',
    //     ];

    //     // Kiểm tra nếu email người quản lý thay đổi
    //     if ($department->manager && $request->manager_email != $department->manager->email) {
    //         $rules['manager_email'] = 'required|email|max:255|unique:users,email';
    //     } else {
    //         $rules['manager_email'] = 'required|email|max:255';
    //     }

    //     $validator = Validator::make($request->all(), $rules);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     // Ngăn chặn chu kỳ trong phân cấp
    //     if ($request->parent_id) {
    //         $descendantIds = $this->getAllDescendantIds($department->id);
    //         if (in_array($request->parent_id, $descendantIds)) {
    //             return redirect()->back()
    //                 ->withErrors(['parent_id' => 'Không thể chọn một đơn vị con làm đơn vị cha.'])
    //                 ->withInput();
    //         }
    //     }

    //     // Tính toán cấp độ mới
    //     $oldLevel = $department->level;
    //     $newLevel = 0;
        
    //     if ($request->parent_id) {
    //         $parentDepartment = Department::find($request->parent_id);
    //         if ($parentDepartment) {
    //             $newLevel = $parentDepartment->level + 1;
    //         }
    //     }
        
    //     $levelDifference = $newLevel - $oldLevel;

    //     // Cập nhật thông tin người quản lý
    //     $resetPassword = false;
    //     $newPassword = '';
    //     $managerId = null;

    //     if ($department->manager) {
    //         // Cập nhật người quản lý hiện tại
    //         $department->manager->name = $request->manager_name;
            
    //         // Nếu email thay đổi, cập nhật email và tạo mật khẩu mới
    //         if ($request->manager_email != $department->manager->email) {
    //             $department->manager->email = $request->manager_email;
    //             $newPassword = Str::random(10);
    //             $department->manager->password = Hash::make($newPassword);
    //             $resetPassword = true;
    //         }
            
    //         $department->manager->save();
    //         $managerId = $department->manager->id;
    //     } else {
    //         // Tạo người quản lý mới nếu chưa có
    //         $newPassword = Str::random(10);
    //         $manager = new User();
    //         $manager->name = $request->manager_name;
    //         $manager->email = $request->manager_email;
    //         $manager->password = Hash::make($newPassword);
    //         $manager->email_verified = 1;
    //         $manager->is_active = 1;
    //         $manager->save();
            
    //         $managerId = $manager->id;
    //         $resetPassword = true;
    //     }

    //     // Cập nhật thông tin đơn vị
    //     $department->name = $request->name;
    //     $department->code = $request->code;
    //     $department->parent_id = $request->parent_id;
    //     $department->user_id = $managerId;
    //     $department->description = $request->description;
    //     $department->phone = $request->phone;
    //     $department->email = $request->email;
    //     $department->address = $request->address;
    //     $department->level = $newLevel;
    //     $department->save();

    //     // Cập nhật cấp độ cho tất cả đơn vị con nếu cấp độ thay đổi
    //     if ($levelDifference != 0) {
    //         $this->updateDescendantLevels($department->id, $levelDifference);
    //     }

    //     // Thông báo thành công
    //     $successMessage = 'Đơn vị đã được cập nhật thành công.';
    //     if ($resetPassword) {
    //         $successMessage .= ' Mật khẩu mới cho tài khoản ' . $request->manager_email . ': ' . $newPassword;
    //     }

    //     return redirect()->route('admin.department.index')
    //         ->with('success', $successMessage);
    // }

    
    public function update(Request $request, $id)
    {
        $department = Department::with('manager')->findOrFail($id);
        
        // Chuẩn bị quy tắc xác thực
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

        // Kiểm tra nếu email người quản lý thay đổi
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

        // Bắt đầu transaction
        DB::beginTransaction();

        try {
            // Ngăn chặn chu kỳ trong phân cấp
            if ($request->parent_id) {
                $descendantIds = $this->getAllDescendantIds($department->id);
                if (in_array($request->parent_id, $descendantIds)) {
                    return redirect()->back()
                        ->withErrors(['parent_id' => 'Không thể chọn một đơn vị con làm đơn vị cha.'])
                        ->withInput();
                }
            }

            // Tính toán cấp độ mới
            $oldLevel = $department->level;
            $newLevel = 0;
            
            if ($request->parent_id) {
                $parentDepartment = Department::find($request->parent_id);
                if ($parentDepartment) {
                    $newLevel = $parentDepartment->level + 1;
                }
            }
            
            $levelDifference = $newLevel - $oldLevel;

            // Cập nhật thông tin người quản lý
            $resetPassword = false;
            $newPassword = '';
            $managerId = null;

            if ($department->manager) {
                // Cập nhật người quản lý hiện tại
                $department->manager->name = $request->manager_name;
                
                // Nếu email thay đổi, cập nhật email và tạo mật khẩu mới
                if ($request->manager_email != $department->manager->email) {
                    $department->manager->email = $request->manager_email;
                    $newPassword = Str::random(10);
                    $department->manager->password = Hash::make($newPassword);
                    $resetPassword = true;
                }
                
                // Xử lý upload avatar mới (nếu có)
                if ($request->hasFile('manager_avatar')) {
                    // Xóa avatar cũ nếu có
                    if ($department->manager->avatar) {
                        // Đảm bảo xóa file từ thư mục đúng
                        Storage::disk('public')->delete('avatars/' . $department->manager->avatar);
                    }
                    
                    // Upload avatar mới
                    $avatar = $request->file('manager_avatar');
                    $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                    
                    // Thay đổi từ 'avatars' thành 'public/avatars' hoặc chỉ định disk 'public'
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
                
                // Xử lý upload avatar nếu có
                if ($request->hasFile('manager_avatar')) {
                    $avatar = $request->file('manager_avatar');
                    $filename = time() . '_' . Str::slug(pathinfo($avatar->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $avatar->getClientOriginalExtension();
                    $avatar->storeAs('avatars', $filename);
                    $manager->avatar = $filename;
                }
                
                $manager->save();
                
                $managerId = $manager->id;
                $resetPassword = true;
            }

            // Cập nhật thông tin đơn vị
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

            // Cập nhật cấp độ cho tất cả đơn vị con nếu cấp độ thay đổi
            if ($levelDifference != 0) {
                $this->updateDescendantLevels($department->id, $levelDifference);
            }

            // Commit transaction
            DB::commit();

            // Thông báo thành công
            $successMessage = 'Đơn vị đã được cập nhật thành công.';
            if ($resetPassword) {
                $successMessage .= ' Mật khẩu mới cho tài khoản ' . $request->manager_email . ': ' . $newPassword;
            }

            return redirect()->route('admin.department.index')
                ->with('success', $successMessage);
                
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            
            return redirect()->back()
                ->withErrors(['error' => 'Đã xảy ra lỗi khi cập nhật đơn vị: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function destroy($id)
    {
        try {
            // Bắt đầu transaction để đảm bảo tính nhất quán của dữ liệu
            DB::beginTransaction();
            
            $department = Department::with('manager')->findOrFail($id);
            
            // Kiểm tra xem đơn vị có đơn vị con không
            if ($department->children()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Không thể xóa đơn vị này vì nó có các đơn vị con.');
            }
            
            // Lưu ID người dùng để xóa sau
            $userId = $department->user_id;
            
            // Quan trọng: Ngắt liên kết người dùng khỏi đơn vị trước
            $department->user_id = null;
            $department->save();
            
            // Xóa đơn vị
            $department->delete();
            
            // Nếu có user_id và user tồn tại, xóa user
            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->delete();
                }
            }
            
            // Commit transaction
            DB::commit();
            
            return redirect()->route('admin.department.index')
                ->with('success', 'Đơn vị và tài khoản quản lý đã được xóa thành công.');
                
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
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

    
}
