<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifycationController extends Controller
{
    public function notification(Request $request){
        $notification_categories = NotificationCategory::all();
        $query = Notification::with(['user', 'category']);
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('source') && $request->source != 'all') {
            $query->whereHas('user.managedDepartment', function($q) use ($request) {
                switch($request->source) {
                    case 'admin':
                        $q->where('name', 'like', '%admin%');
                        break;
                    case 'faculties':
                        $q->where('name', 'like', '%khoa%');
                        break;
                    case 'departments':
                        $q->where('name', 'like', '%phòng%');
                        break;
                    case 'student-affairs':
                        $q->where('name', 'like', '%sinh viên%');
                        break;
                }
            });
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $sort = $request->get('sort', 'newest');
        switch($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'za':
                $query->orderBy('title', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $notifications = $query->paginate(6)->withQueryString();

        // $notification_gim = Notification::with(['user', 'category'])
        //     ->where('is_pinned', 1)
        //     ->orderBy('created_at', 'desc')
        //     ->take(1)
        //     ->get();

        $notification_gim = Notification::with(['user', 'category'])
        ->where('is_pinned', 1)
        ->orderBy('created_at', 'desc')
        ->first();
        
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            
        $category_counts = [];
        foreach($notification_categories as $category) {
            $category_counts[$category->id] = Notification::where('category_id', $category->id)->count();
        }
        $total_notifications = Notification::count();
        
        return view('pages.notify')
            ->with('notification_categories', $notification_categories)
            ->with('notifications', $notifications)
            ->with('notification_latests', $notification_latests)
            ->with('category_counts', $category_counts)
            ->with('total_notifications', $total_notifications)
            ->with('current_filters', $request->all())
            ->with('notification_gim', $notification_gim);
    }

    public function notificationByCategory($category_id, Request $request)
    {
        $notification_categories = NotificationCategory::all();
        $current_category = NotificationCategory::findOrFail($category_id);
        
        $query = Notification::with(['user', 'category'])
            ->where('category_id', $category_id);
        
        if ($request->filled('source') && $request->source != 'all') {
            $query->whereHas('user.managedDepartment', function($q) use ($request) {
                switch($request->source) {
                    case 'admin':
                        $q->where('name', 'like', '%admin%');
                        break;
                    case 'faculties':
                        $q->where('name', 'like', '%khoa%');
                        break;
                    case 'departments':
                        $q->where('name', 'like', '%phòng%');
                        break;
                    case 'student-affairs':
                        $q->where('name', 'like', '%sinh viên%');
                        break;
                }
            });
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }
        
        $sort = $request->get('sort', 'newest');
        switch($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'az':
                $query->orderBy('title', 'asc');
                break;
            case 'za':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $notifications = $query->paginate(8)->withQueryString();
            
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            
        return view('pages.notify-category')
            ->with('notification_categories', $notification_categories)
            ->with('current_category', $current_category)
            ->with('notifications', $notifications)
            ->with('notification_latests', $notification_latests)
            ->with('current_filters', $request->all());
    }

    public function show($id)
    {
        $notification = Notification::with(['user', 'category'])->findOrFail($id);
        
        // Lấy thông báo liên quan cùng danh mục
        $related_notifications = Notification::with(['user', 'category'])
            ->where('category_id', $notification->category_id)
            ->where('id', '!=', $id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $notification_categories = NotificationCategory::all();
        
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        return view('pages.notify-detail')
            ->with('notification', $notification)
            ->with('related_notifications', $related_notifications)
            ->with('notification_categories', $notification_categories)
            ->with('notification_latests', $notification_latests);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề thông báo',
            'content.required' => 'Vui lòng nhập nội dung thông báo',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ]);

        $imagePaths = [];
        
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('notifications', 'public');
                $imagePaths[] = $path;
            }
        }

        $notification = Notification::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'images' => !empty($imagePaths) ? implode(',', $imagePaths) : null
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thông báo đã được tạo thành công!',
                'notification' => $notification
            ]);
        }

        return redirect()->route('notification.index')
            ->with('success', 'Thông báo đã được tạo thành công!');
    }
}