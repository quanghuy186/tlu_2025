<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $count_approved_posts = ForumPost::where('status', '=', 'approved')->count();
        $count_pending_posts = ForumPost::where('status', '=', 'pending')->count();
        $count_reject_reason_posts = ForumPost::where('status', '=', 'rejected')->count();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;
        
        $dailyData = [
            'approved' => array_fill(0, $daysInMonth, 0),
            'pending' => array_fill(0, $daysInMonth, 0),
            'rejected' => array_fill(0, $daysInMonth, 0),
        ];
        
        $approvedPostsByDay = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        $pendingPostsByDay = ForumPost::where('status', 'pending')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        $rejectedPostsByDay = ForumPost::where('status', 'rejected')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        foreach ($approvedPostsByDay as $post) {
            $dailyData['approved'][$post->day - 1] = $post->count;
        }
        
        foreach ($pendingPostsByDay as $post) {
            $dailyData['pending'][$post->day - 1] = $post->count;
        }
        
        foreach ($rejectedPostsByDay as $post) {
            $dailyData['rejected'][$post->day - 1] = $post->count;
        }
        
        $monthlyData = [
            'approved' => array_fill(0, 12, 0),
            'pending' => array_fill(0, 12, 0),
            'rejected' => array_fill(0, 12, 0),
        ];
        
        $approvedPostsByMonth = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $pendingPostsByMonth = ForumPost::where('status', 'pending')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $rejectedPostsByMonth = ForumPost::where('status', 'rejected')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        foreach ($approvedPostsByMonth as $post) {
            $monthlyData['approved'][$post->month - 1] = $post->count;
        }
        
        foreach ($pendingPostsByMonth as $post) {
            $monthlyData['pending'][$post->month - 1] = $post->count;
        }
        
        foreach ($rejectedPostsByMonth as $post) {
            $monthlyData['rejected'][$post->month - 1] = $post->count;
        }
        
        $data = [
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'daysInMonth' => $daysInMonth
        ];
        
        $dailyDataJson = json_encode($dailyData);
        $monthlyDataJson = json_encode($monthlyData);


        //thống kê tài khoản người dùng
        $count_account_success = User::where('is_active', 1)->where('email_verified', 1)->count();
        $count_account_error = User::where('is_active', 0)->orwhere('email_verified', 0)->count();
        $userDailyData = [
            'active' => array_fill(0, $daysInMonth, 0),
            'inactive' => array_fill(0, $daysInMonth, 0),
        ];
        
        $activeUsersByDay = User::where('is_active', 1)
            ->where('email_verified', 1)
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        $inactiveUsersByDay = User::where(function($query) {
                $query->where('is_active', 0)
                      ->orWhere('email_verified', 0);
            })
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        foreach ($activeUsersByDay as $user) {
            $userDailyData['active'][$user->day - 1] = $user->count;
        }
        
        foreach ($inactiveUsersByDay as $user) {
            $userDailyData['inactive'][$user->day - 1] = $user->count;
        }
        
        $userMonthlyData = [
            'active' => array_fill(0, 12, 0),
            'inactive' => array_fill(0, 12, 0),
        ];
        
        $activeUsersByMonth = User::where('is_active', 1)
            ->where('email_verified', 1)
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $inactiveUsersByMonth = User::where(function($query) {
                $query->where('is_active', 0)
                      ->orWhere('email_verified', 0);
            })
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        foreach ($activeUsersByMonth as $user) {
            $userMonthlyData['active'][$user->month - 1] = $user->count;
        }
        
        foreach ($inactiveUsersByMonth as $user) {
            $userMonthlyData['inactive'][$user->month - 1] = $user->count;
        }
        
        $data = [
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'daysInMonth' => $daysInMonth
        ];
        
        $dailyDataJson = json_encode($dailyData);
        $monthlyDataJson = json_encode($monthlyData);
        $userDailyDataJson = json_encode($userDailyData);
        $userMonthlyDataJson = json_encode($userMonthlyData);
        
        return view('admin.dashboard.home', compact(
            'count_approved_posts', 
            'count_pending_posts', 
            'count_reject_reason_posts',
            'dailyDataJson',
            'monthlyDataJson',
            'data',
            'count_account_success',
            'count_account_error',
            'userDailyDataJson',
            'userMonthlyDataJson'
        ));
    }
}
