<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::paginate(10);
        return view("admin.permission.index")->with("permissions", $permissions);
    }

    public function create()
    {
        return view('admin.permission.create');
    }

  
    public function store(Request $request)
    {
            $validated = $request->validate([
                'permission_name' => 'required|unique:permissions,permission_name|max:255',
                'description' => 'required|max:1000',
            ], [
                'permission_name.required' => 'Tên quyền truy cập là bắt buộc',
                'permission_name.unique' => 'Tên quyền truy cập này đã tồn tại',
                'permission_name.max' => 'Tên quyền truy cập không được vượt quá 255 ký tự',
                'description.required' => 'Vui lòng nhập mô tả',
                'description.max' => 'Mô tả không được vượt quá 1000 ký tự',
            ]);

            Permission::create([
                'permission_name' => $validated['permission_name'],
                'description' => $validated['description'] ?? null,
            ]);
            
            return redirect()
                ->route('admin.permission.index')
                ->with('success', 'Quyền truy cập đã được tạo thành công.');
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permission.edit', compact('permission'));
    }

 
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        try {
            $permission->update([
                'permission_name' => $request->input('permission_name'),
                'description' => $request->input('description'),
            ]);

            return redirect()
                ->route('admin.permission.index')
                ->with('success', 'Quyền truy cập đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permission.edit', $id)
                ->with('error', 'Đã xảy ra lỗi khi cập nhật quyền truy cập: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();

            return redirect()
                ->route('admin.permission.index')
                ->with('success', 'Quyền truy cập đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permission.index')
                ->with('error', 'Đã xảy ra lỗi khi xóa quyền truy cập: ' . $e->getMessage());
        }
    }

}
