<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = ForumComment::with(['post', 'user'])
            ->orderBy('created_at', 'desc');

        // Lọc theo nội dung bình luận
        if ($request->has('search') && !empty($request->search)) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        // Lọc theo bài viết
        if ($request->has('post_id') && !empty($request->post_id)) {
            $query->where('post_id', $request->post_id);
        }

        // Lọc theo loại bình luận (gốc hoặc phản hồi)
        if ($request->has('parent_id')) {
            if ($request->parent_id === 'parent') {
                $query->whereNull('parent_id');
            } elseif ($request->parent_id === 'reply') {
                $query->whereNotNull('parent_id');
            }
        }

        // Lọc theo trạng thái ẩn danh
        if ($request->has('is_anonymous') && $request->is_anonymous !== '') {
            $query->where('is_anonymous', $request->is_anonymous);
        }

        $comments = $query->paginate(15);
        $posts = ForumPost::select('id', 'title')->orderBy('title')->get();

        return view('admin.forum.comments.index', compact('comments', 'posts'));
    }

    public function show(ForumComment $comment)
    {
        $comment->load(['post', 'user']);
        
        // Nếu là bình luận gốc, lấy các phản hồi
        $replies = collect([]);
        if (!$comment->parent_id) {
            $replies = $comment->replies()->with(['user'])->get();
        }
        
        return view('admin.forum.comments.detail', compact('comment', 'replies'));
    }

    public function edit(ForumComment $comment)
    {
        $comment->load(['post', 'user']);
        return view('admin.forum.comments.edit', compact('comment'));
    }
 
    public function update(Request $request, ForumComment $comment)
    {
        $request->validate([
            'content' => 'required|string|min:2',
        ], [
            'content.required' => 'Nội dung bình luận không được để trống',
            'content.min' => 'Nội dung bình luận phải có ít nhất 2 ký tự',
        ]);

        try {
            $comment->content = $request->content;
            $comment->is_anonymous = $request->has('is_anonymous') ? 1 : 0;
            $comment->save();

            return redirect()->route('admin.forum.comments.show', $comment->id)
                ->with('success', 'Bình luận đã được cập nhật thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã xảy ra lỗi khi cập nhật bình luận: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(ForumComment $comment)
    {
        try {
            DB::beginTransaction();
            
            // Nếu là bình luận gốc, xóa tất cả phản hồi trước
            if (!$comment->parent_id) {
                $comment->replies()->delete();
            }
            
            $comment->delete();
            
            DB::commit();
            
            return redirect()->route('admin.forum.comments.index')
                ->with('success', 'Bình luận đã được xóa thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã xảy ra lỗi khi xóa bình luận: ' . $e->getMessage());
        }
    }
}