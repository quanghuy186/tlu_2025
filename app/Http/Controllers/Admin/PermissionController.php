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
        // Validate the input
        // $validator = Validator::make($request->all(), [
        //     'permission_name' => 'required|string|max:100|unique:permissions,permission_name',
        //     'description' => 'nullable|string|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admin.permission.create')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            // Create the new permission
            Permission::create([
                'permission_name' => $request->input('permission_name'),
                'description' => $request->input('description'),
            ]);

            return redirect()
                ->route('admin.permission.index')
                ->with('success', 'Quyền truy cập đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.permission.create')
                ->with('error', 'Đã xảy ra lỗi khi tạo quyền truy cập: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permission.edit', compact('permission'));
    }

 
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        // Validate the input
        // $validator = Validator::make($request->all(), [
        //     'permission_name' => 'required|string|max:100|unique:permissions,permission_name,' . $id,
        //     'description' => 'nullable|string|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admin.permission.edit', $id)
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            // Update the permission
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
