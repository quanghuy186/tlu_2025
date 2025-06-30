<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with(['user', 'category']);
        
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }
        
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->byCategory($request->category_id);
        }
        
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('priority') && !empty($request->priority)) {
            $query->byPriority($request->priority);
        }
        
        if ($request->has('date_from') && !empty($request->date_from)) {
            $dateFrom = Carbon::createFromFormat('d/m/Y', $request->date_from)->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $dateTo = Carbon::createFromFormat('d/m/Y', $request->date_to)->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }
        
        $sortField = $request->input('sort_field', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortField, $sortDirection);
        
        $perPage = $request->input('per_page', 10);
        $notifications = $query->paginate($perPage)->withQueryString();
        
        $categories = NotificationCategory::orderBy('name')->get();
        
        return view('admin.notification.index', compact('notifications', 'categories'));
    }

    public function create()
    {
        $categories = NotificationCategory::orderBy('display_order')
            ->orderBy('name')
            ->pluck('name', 'id');
        
        return view('admin.notification.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:notification_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'title.required' => 'Tiêu đề không được để trống',
            'content.required' => 'Nội dung không được bỏ trống',
            'images.*.image' => 'Mỗi file tải lên phải là hình ảnh',
            'images.*.max' => 'Ảnh không được lớn hơn 2MB',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug($originalName) . '.' . $extension;
                $path = $image->storeAs('notifications', $fileName, 'public');
                $imagePaths[] = $path;
            }
        }

        // Create new notification
        $notification = new Notification();
        $notification->title = $request->title;
        $notification->content = $request->content;
        $notification->category_id = $request->category_id;
        $notification->images = !empty($imagePaths) ? implode(',', $imagePaths) : null;
        $notification->user_id = Auth::id();
        $notification->save();

        return redirect()->route('admin.notification.index')
            ->with('success', 'Thông báo đã được tạo thành công.');
    }
    
    public function detail($id)
    {
        $notification = Notification::with(['user', 'category'])->findOrFail($id);
        
        return view('admin.notification.detail', compact('notification'));
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        
        $categories = NotificationCategory::orderBy('display_order')
            ->orderBy('name')
            ->pluck('name', 'id');
        
        return view('admin.notification.edit', compact('notification', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:notification_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'nullable|array',
        ]);

        // Handle removing selected images
        $existingImages = $notification->images_array;
        $imagesToRemove = $request->input('remove_images', []);
        $remainingImages = [];

        foreach ($existingImages as $image) {
            if (!in_array($image, $imagesToRemove)) {
                $remainingImages[] = $image;
            } else {
                // Delete the image file
                Storage::disk('public')->delete($image);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName = time() . '_' . Str::slug($originalName) . '.' . $extension;
                $path = $image->storeAs('notifications', $fileName, 'public');
                $remainingImages[] = $path;
            }
        }

        // Update notification
        $notification->title = $request->title;
        $notification->content = $request->content;
        $notification->category_id = $request->category_id;
        $notification->images = !empty($remainingImages) ? implode(',', $remainingImages) : null;
        $notification->save();

        return redirect()->route('admin.notification.index')
            ->with('success', 'Thông báo đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        
        // Delete attached images
        $images = $notification->images_array;
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
        
        $notification->delete();
        
        return redirect()->route('admin.notification.index')
            ->with('success', 'Thông báo đã được xóa thành công.');
    }

    public function togglePin($id)
    {
        $notify = Notification::findOrFail($id);
        
        $notify->update([
            'is_pinned' => !$notify->is_pinned
        ]);
        
        $message = $notify->is_pinned ? 'Thông báo đã được ghim!' : 'Thông báo đã được bỏ ghim!';
        
        return redirect()->route('admin.notification.detail', $notify->id)
            ->with('success', $message);
    }
    
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array',
            // 'selected_ids.*' => 'exists:notifications,id',
        ]);
        
        $selectedIds = $request->input('selected_ids');
        
        // Lấy tất cả hình ảnh của các thông báo được chọn để xóa
        $notifications = Notification::whereIn('id', $selectedIds)->get();
        
        foreach ($notifications as $notification) {
            // Xóa hình ảnh
            $images = $notification->images_array;
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        // Xóa các thông báo
        Notification::whereIn('id', $selectedIds)->delete();
        
        return redirect()->route('admin.notification.index')
            ->with('success', 'Đã xóa ' . count($selectedIds) . ' thông báo thành công.');
    }
}