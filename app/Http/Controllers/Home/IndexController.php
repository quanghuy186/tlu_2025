<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $notification_latests = Notification::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(4);
        return view('home.index')->with('notification_latests', $notification_latests);
    }


}