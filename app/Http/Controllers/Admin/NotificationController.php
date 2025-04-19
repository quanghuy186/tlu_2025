<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.notification.index', compact('notifications'));
    }

    public function create()
    {
        // $categories = NotificationCategory::orderBy('display_order')
        //     ->orderBy('name')
        //     ->pluck('name', 'id')
        //     ->toArray();

        $categories = NotificationCategory::orderBy('display_order')
            ->orderBy('name')
            ->pluck('name', 'id');  // Quan trọng: Sử dụng pluck('name', 'id') để tạo mảng id => name
        
        // Debug để xem dữ liệu
        // dd($categories);
        
        return view('admin.notification.create', compact('categories'));
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:notification_categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file uploads if images exist
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
}
