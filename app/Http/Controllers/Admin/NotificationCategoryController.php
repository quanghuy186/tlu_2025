<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NotificationCategoryController extends Controller
{
    public function index()
    {
        $categories = NotificationCategory::orderBy('display_order')->orderBy('name')->paginate(10);
        
        return view('admin.notification-category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.notification-category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:notification_categories,slug',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer',
        ],[
            'name.required' => 'Tên thông báo khồn được  để  trống',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác',
        ]);

        $category = new NotificationCategory();
        $category->name = $request->name;
        $category->slug = $request->slug ?: Str::slug($request->name);
        $category->description = $request->description;
        // $category->icon = $request->icon;
        $category->display_order = $request->display_order ?: 0;
        $category->save();

        return redirect()->route('admin.notification-category.index')
            ->with('success', 'Danh mục thông báo đã được tạo thành công.');
    }

    public function edit($id)
    {
        $category = NotificationCategory::findOrFail($id);
        
        return view('admin.notification-category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = NotificationCategory::findOrFail($id);
        
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|string|max:255|unique:notification_categories,slug,' . $id,
            'description' => 'nullable',
            'display_order' => 'nullable|integer',
        ],[
            'name.required' => 'Tên thông báo khồn được  để  trống',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác',
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug ?: Str::slug($request->name);
        $category->description = $request->description;
        $category->display_order = $request->display_order ?: 0;
        $category->save();

        return redirect()->route('admin.notification-category.index')
            ->with('success', 'Danh mục thông báo đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $category = NotificationCategory::findOrFail($id);
        
        $notificationsCount = $category->notifications()->count();
        if ($notificationsCount > 0) {
            return redirect()->route('admin.notification-category.index')
                ->with('error', 'Không thể xóa danh mục này vì có ' . $notificationsCount . ' thông báo đang sử dụng.');
        }
        
        $category->delete();
        
        return redirect()->route('admin.notification-category.index')
            ->with('success', 'Danh mục thông báo đã được xóa thành công.');
    }

}
