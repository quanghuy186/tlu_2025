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

    /**
     * Hiển thị form tạo danh mục mới
     */
    public function create()
    {
        // Lấy danh sách các danh mục để hiển thị trong dropdown parent_id
        $parentCategories = ForumCategory::where('parent_id', null)->get();
        return view('admin.forum.forum-category.create', compact('parentCategories'));
    }

    /**
     * Lưu danh mục mới vào database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:forum_categories,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo slug từ tên danh mục
        $slug = Str::slug($request->name);
        
        // Kiểm tra xem slug đã tồn tại chưa
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

    /**
     * Hiển thị chi tiết danh mục
     */
    public function show($id)
    {
        $category = ForumCategory::findOrFail($id);
        $parentCategory = null;
        
        if ($category->parent_id) {
            $parentCategory = ForumCategory::find($category->parent_id);
        }
        
        return view('admin.forum.forum-category.detail', compact('category', 'parentCategory'));
    }

    /**
     * Hiển thị form chỉnh sửa danh mục
     */
    public function edit($id)
    {
        $category = ForumCategory::findOrFail($id);
        // Lấy danh sách các danh mục để hiển thị trong dropdown parent_id (ngoại trừ chính nó và các con của nó)
        $parentCategories = ForumCategory::where('id', '!=', $id)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '!=', $id);
            })
            ->get();
            
        return view('admin.forum.forum-category.edit', compact('category', 'parentCategories'));
    }

    /**
     * Cập nhật thông tin danh mục
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:forum_categories,name,'.$id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:forum_categories,id',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $category = ForumCategory::findOrFail($id);
        
        // Nếu tên thay đổi, cập nhật slug
        if ($category->name != $request->name) {
            $slug = Str::slug($request->name);
            
            // Kiểm tra xem slug đã tồn tại chưa (ngoại trừ slug hiện tại)
            $count = ForumCategory::where('slug', $slug)
                ->where('id', '!=', $id)
                ->count();
                
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
        } else {
            $slug = $category->slug;
        }
        
        // Kiểm tra nếu parent_id là chính nó hoặc con của nó
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

    /**
     * Xóa danh mục khỏi database
     */
    public function destroy($id)
    {
        $category = ForumCategory::findOrFail($id);
        
        // Kiểm tra xem có danh mục con không
        $childCategories = ForumCategory::where('parent_id', $id)->count();
        if ($childCategories > 0) {
            return redirect()->route('admin.forum.categories.index')
                ->with('error', 'Không thể xóa danh mục này vì có ' . $childCategories . ' danh mục con!');
        }
        
        $category->delete();

        return redirect()->route('admin.forum.categories.index')
            ->with('success', 'Xóa danh mục thành công!');
    }
}