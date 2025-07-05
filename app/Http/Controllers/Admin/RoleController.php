<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RoleController extends Controller
{
    public function index(){
        $roles = Role::paginate(10);
        return view("admin.role.index")->with("roles", $roles);
    }

    public function create(){

        return view("admin.role.create");
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'role_name' => 'required|unique:roles,role_name|max:255',
                'description' => 'required|max:1000',
            ], [
                'role_name.required' => 'Tên vai trò là bắt buộc',
                'role_name.unique' => 'Tên vai trò này đã tồn tại trong hệ thống',
                'role_name.max' => 'Tên vai trò không được vượt quá 255 ký tự',
                'description.required' => 'Vui lòng nhập mô tả',
                'description.max' => 'Mô tả không được vượt quá 1000 ký tự',
            ]);

            Role::create([
                'role_name' => $validated['role_name'],
                'description' => $validated['description'] ?? null,
            ]);
            
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Vai trò đã được tạo thành công.');
    }   

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

 
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        try {
            $role->update([
                'role_name' => $request->input('role_name'),
                'description' => $request->input('description'),
            ]);
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Vai trò đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.role.edit', $id)
                ->with('error', 'Đã xảy ra lỗi khi cập nhật vai trò: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Vai trò đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.role.index')
                ->with('error', 'Đã xảy ra lỗi khi xóa vai trò: ' . $e->getMessage());
        }
    }

}
