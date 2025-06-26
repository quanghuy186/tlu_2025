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
        // Đếm số lượng bài đăng theo trạng thái
        $count_approved_posts = ForumPost::where('status', '=', 'approved')->count();
        $count_pending_posts = ForumPost::where('status', '=', 'pending')->count();
        $count_reject_reason_posts = ForumPost::where('status', '=', 'rejected')->count();
        
        // Lấy thông tin tháng và năm hiện tại
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $daysInMonth = Carbon::now()->daysInMonth;
        
        // Khởi tạo mảng dữ liệu trống cho các ngày trong tháng
        $dailyData = [
            'approved' => array_fill(0, $daysInMonth, 0),
            'pending' => array_fill(0, $daysInMonth, 0),
            'rejected' => array_fill(0, $daysInMonth, 0),
        ];
        
        // Lấy dữ liệu bài viết đã được phê duyệt theo ngày
        $approvedPostsByDay = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        // Lấy dữ liệu bài viết đang chờ phê duyệt theo ngày
        $pendingPostsByDay = ForumPost::where('status', 'pending')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        // Lấy dữ liệu bài viết bị từ chối theo ngày
        $rejectedPostsByDay = ForumPost::where('status', 'rejected')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->select(DB::raw('DAY(created_at) as day'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();
        
        // Gán dữ liệu vào mảng theo ngày
        foreach ($approvedPostsByDay as $post) {
            $dailyData['approved'][$post->day - 1] = $post->count;
        }
        
        foreach ($pendingPostsByDay as $post) {
            $dailyData['pending'][$post->day - 1] = $post->count;
        }
        
        foreach ($rejectedPostsByDay as $post) {
            $dailyData['rejected'][$post->day - 1] = $post->count;
        }
        
        // Khởi tạo mảng dữ liệu theo tháng
        $monthlyData = [
            'approved' => array_fill(0, 12, 0),
            'pending' => array_fill(0, 12, 0),
            'rejected' => array_fill(0, 12, 0),
        ];
        
        // Lấy dữ liệu bài viết đã được phê duyệt theo tháng
        $approvedPostsByMonth = ForumPost::where('status', 'approved')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        // Lấy dữ liệu bài viết đang chờ phê duyệt theo tháng
        $pendingPostsByMonth = ForumPost::where('status', 'pending')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        // Lấy dữ liệu bài viết bị từ chối theo tháng
        $rejectedPostsByMonth = ForumPost::where('status', 'rejected')
            ->whereYear('created_at', $currentYear)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        
        // Gán dữ liệu vào mảng theo tháng
        foreach ($approvedPostsByMonth as $post) {
            $monthlyData['approved'][$post->month - 1] = $post->count;
        }
        
        foreach ($pendingPostsByMonth as $post) {
            $monthlyData['pending'][$post->month - 1] = $post->count;
        }
        
        foreach ($rejectedPostsByMonth as $post) {
            $monthlyData['rejected'][$post->month - 1] = $post->count;
        }
        
        // Thêm thông tin về ngày hiện tại
        $data = [
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'daysInMonth' => $daysInMonth
        ];
        
        // Chuyển đổi dữ liệu thành JSON để sử dụng trong JavaScript
        $dailyDataJson = json_encode($dailyData);
        $monthlyDataJson = json_encode($monthlyData);
        
        return view('admin.dashboard.home', compact(
            'count_approved_posts', 
            'count_pending_posts', 
            'count_reject_reason_posts',
            'dailyDataJson',
            'monthlyDataJson',
            'data'
        ));
    }
}
