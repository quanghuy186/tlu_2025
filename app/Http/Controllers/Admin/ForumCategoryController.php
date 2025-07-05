<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::with('parent')->get();
        return view('admin.forum.forum-category.index', compact('categories'));
    }

    public function create()
    {
        // Lấy danh sách các danh mục để hiển thị trong dropdown parent_id
        $parentCategories = ForumCategory::where('parent_id', null)->get();
        return view('admin.forum.forum-category.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:forum_categories,id',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục không được vượt quá 100 ký tự',
            'name.unique' => 'Tên danh mục đã tồn tại trong hệ thống',
            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $slug = Str::slug($request->name);
        $count = ForumCategory::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        ForumCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Tạo danh mục thành công!');
    }

    public function show($id)
    {
        $category = ForumCategory::findOrFail($id);
        $parentCategory = null;
        
        if ($category->parent_id) {
            $parentCategory = ForumCategory::find($category->parent_id);
        }
        
        return view('admin.forum.forum-category.detail', compact('category', 'parentCategory'));
    }

    public function edit($id)
    {
        $category = ForumCategory::findOrFail($id);
        $parentCategories = ForumCategory::where('id', '!=', $id)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '!=', $id);
            })
            ->get();
            
        return view('admin.forum.forum-category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories,name,' . $id . ',id',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:forum_categories,id',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi ký tự',
            'name.max' => 'Tên danh mục không được vượt quá 100 ký tự',
            'name.unique' => 'Tên danh mục đã tồn tại trong hệ thống',
            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'parent_id.exists' => 'Danh mục cha không hợp lệ',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $category = ForumCategory::findOrFail($id);
        if ($category->name != $request->name) {
            $slug = Str::slug($request->name);
            $count = ForumCategory::where('slug', $slug)
                ->where('id', '!=', $id)
                ->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
        } else {
            $slug = $category->slug;
        }
        
        if ($request->parent_id == $id) {
            return redirect()->back()
                ->with('error', 'Không thể đặt danh mục là danh mục cha của chính nó!')
                ->withInput();
        }
        
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = ForumCategory::findOrFail($id);
        // $childCategories = ForumCategory::where('parent_id', $id)->count();
        // if ($childCategories > 0) {
        //     return redirect()->route('admin.forum.categories.index')
        //         ->with('error', 'Không thể xóa danh mục này vì có ' . $childCategories . ' danh mục con!');
        // }
        $category->delete();
        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}