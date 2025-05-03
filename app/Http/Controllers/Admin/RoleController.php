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

    public function store(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'role_name' => 'required|string|max:100|unique:roles,role_name',
        //     'description' => 'nullable|string|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admin.role.create')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            Role::create([
                'role_name' => $request->input('role_name'),
                'description' => $request->input('description'),
            ]);

            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Vai trò đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.role.create')
                ->with('error', 'Đã xảy ra lỗi khi tạo vai trò: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

 
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Validate the input
        // $validator = Validator::make($request->all(), [
        //     'role_name' => 'required|string|max:100|unique:roles,role_name,' . $id,
        //     'description' => 'nullable|string|max:255',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()
        //         ->route('admin.role.edit', $id)
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        try {
            // Update the role
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
