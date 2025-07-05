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

        if ($request->has('search') && !empty($request->search)) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        if ($request->has('post_id') && !empty($request->post_id)) {
            $query->where('post_id', $request->post_id);
        }

        if ($request->has('parent_id')) {
            if ($request->parent_id === 'parent') {
                $query->whereNull('parent_id');
            } elseif ($request->parent_id === 'reply') {
                $query->whereNotNull('parent_id');
            }
        }
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

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'post_ids' => 'required|json',
        ]);

        try {
            $postIds = json_decode($request->post_ids, true);
            
            if (empty($postIds) || !is_array($postIds)) {
                return redirect()->route('admin.forum.posts.index')
                    ->with('error', 'Không có bài viết nào được chọn để xóa.');
            }

            DB::beginTransaction();

            DB::table('forum_comments')
                ->whereIn('post_id', $postIds)
                ->delete();

            $deletedCount = ForumPost::whereIn('id', $postIds)->delete();

            DB::commit();

            return redirect()->route('admin.forum.posts.index')
                ->with('success', "Đã xóa thành công {$deletedCount} bài viết.");

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.forum.posts.index')
                ->with('error', 'Đã xảy ra lỗi khi xóa bài viết: ' . $e->getMessage());
        }
    }
}