<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::all();
        return view('admin.forum.forum-category.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục mới
     */
    public function create()
    {
        return view('admin.forum.forum-category.create');
    }

    /**
     * Lưu danh mục mới vào database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        ForumCategory::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Tạo danh mục thành công!');
    }

    /**
     * Hiển thị chi tiết danh mục
     */
    public function show($id)
    {
        $category = ForumCategory::findOrFail($id);
        return view('admin.forum.forum-category.detail', compact('category'));
    }

    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function edit($id)
    {
        $category = ForumCategory::findOrFail($id);
        return view('admin.forum.forum-category.edit', compact('category'));
    }

    /**
     * Cập nhật thông tin danh mục
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories,name,'.$id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = ForumCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa danh mục khỏi database
     */
    public function destroy($id)
    {
        $category = ForumCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('forum.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}
