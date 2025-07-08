<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumPost;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $status = $request->get('status', 'pending');
        $search = $request->get('search');
        
        $reports = Report::with(['post', 'user'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('post', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);
            
        $pendingCount = Report::pending()->count();
        $resolvedCount = Report::resolved()->count();
        $rejectedCount = Report::rejected()->count();
        
        $pendingChange = $this->calculatePercentageChange(
            Report::pending()->where('created_at', '>=', now()->subDay())->count(),
            Report::pending()->where('created_at', '<', now()->subDay())->where('created_at', '>=', now()->subDays(2))->count()
        );
        
        $resolvedChange = $this->calculatePercentageChange(
            Report::resolved()->where('updated_at', '>=', now()->subDay())->count(),
            Report::resolved()->where('updated_at', '<', now()->subDay())->where('updated_at', '>=', now()->subDays(2))->count()
        );
        
        $rejectedChange = $this->calculatePercentageChange(
            Report::rejected()->where('updated_at', '>=', now()->subDay())->count(),
            Report::rejected()->where('updated_at', '<', now()->subDay())->where('updated_at', '>=', now()->subDays(2))->count()
        );
        
        return view('admin.report.index', compact(
            'reports', 
            'status', 
            'search', 
            'pendingCount', 
            'resolvedCount', 
            'rejectedCount',
            'pendingChange',
            'resolvedChange',
            'rejectedChange'
        ));
    }

    public function store(Request $request, ForumPost $post)
    {
        $request->validate([
            'report_reason' => 'required|string|max:1000'
        ]);
        
        $existingReport = Report::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();
            
        if ($existingReport) {
            return redirect()->back()->with('error', 'Bạn đã báo cáo bài viết này rồi và báo cáo đang được xử lý!');
        }
        
        Report::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'reason' => $request->report_reason,
            'status' => 'pending'
        ]);
        
        return redirect()->back()->with('success', 'Báo cáo đã được gửi thành công!');
    }

    public function show(Report $report)
    {
        $report->load(['post', 'user']);
        
        return view('admin.report.detail', compact('report'));
    }

    public function resolve(Request $request, Report $report)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
            'action' => 'required|in:resolve,reject,delete_post'
        ]);
        
        if ($request->action === 'resolve') {
            $report->markAsResolved(auth()->id(), $request->admin_notes);
            $message = 'Báo cáo đã được đánh dấu là đã xử lý.';
        } elseif ($request->action === 'reject') {
            $report->markAsRejected(auth()->id(), $request->admin_notes);
            $message = 'Báo cáo đã bị từ chối.';
        } elseif ($request->action === 'delete_post') {
            $post = $report->post;
            $report->markAsResolved(auth()->id(), "Bài viết đã bị xóa. " . $request->admin_notes);
            $post->delete();
            $message = 'Bài viết đã bị xóa và báo cáo đã được đánh dấu là đã xử lý.';
        }
        
        return redirect()->route('admin.reports.index')->with('success', $message);
    }
    
    private function calculatePercentageChange($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100);
    }
}
