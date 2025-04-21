<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\NotificationCategory;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function notification(){
        $notification_categories = NotificationCategory::all();
        // $notifications = Notification::all();
        $notifications = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('pages.notify')
        ->with('notification_categories',$notification_categories)
        ->with('notifications', $notifications)
        ->with('notification_latests', $notification_latests);
    }

    public function notification_category(){
        $notification_categories = NotificationCategory::all();
        return view('pages.notify')
        ->with('notification_categories',$notification_categories);
    }
}
