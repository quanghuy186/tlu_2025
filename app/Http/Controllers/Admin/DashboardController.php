<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $count_approved_posts = ForumPost::where('status', '=', 'approved')->count();
        $count_pendding_posts = ForumPost::where('status', '=', 'pendding')->count();
        $count_reject_reason_posts = ForumPost::where('status', '=', 'reject_reason')->count();
        
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;
        
        // Khởi tạo mảng dữ liệu trống cho các ngày trong tháng
        $dailyData = [
            'dates' => [],
            'approved' => array_fill(0, $daysInMonth, 0),
            'pending' => array_fill(0, $daysInMonth, 0),
            'rejected' => array_fill(0, $daysInMonth, 0),
        ];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $day);
            $dailyData['dates'][] = $date->format('Y-m-d');
        }
        
        $approvedPostsByDay = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        $pendingPostsByDay = ForumPost::where('status', 'pendding')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        $rejectedPostsByDay = ForumPost::where('status', 'reject_reason')
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
            'months' => [],
            'approved' => array_fill(0, 12, 0),
            'pending' => array_fill(0, 12, 0),
            'rejected' => array_fill(0, 12, 0),
        ];
        
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::createFromDate($currentYear, $month, 1);
            $monthlyData['months'][] = $date->format('Y-m-d');
        }
        
        $approvedPostsByMonth = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $pendingPostsByMonth = ForumPost::where('status', 'pendding')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        $rejectedPostsByMonth = ForumPost::where('status', 'reject_reason')
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
        
        // Chuyển đổi dữ liệu thành JSON để sử dụng trong JavaScript
        $dailyDataJson = json_encode($dailyData);
        $monthlyDataJson = json_encode($monthlyData);
        
        return view('admin.dashboard.home', compact(
            'count_approved_posts', 
            'count_pendding_posts', 
            'count_reject_reason_posts',
            'dailyDataJson',
            'monthlyDataJson'
        ));
    }
}
