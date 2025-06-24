<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumComment;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ForumPostController extends Controller
{
    public function index(Request $request)
    {
        $query = ForumPost::with(['category', 'author']);
        
        // Lọc theo danh mục
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Tìm kiếm theo tiêu đề
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $posts = $query->orderBy('created_at', 'desc')->paginate(10);
        $categories = ForumCategory::all();
        
        return view('admin.forum.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = ForumCategory::all();
        return view('admin.forum.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:forum_categories,id',
            'content' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'category_id.exists' => 'Danh mục không tồn tại hoặc đã bị xóa',
            'content.required' => 'Nội dung không được để trống',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh',
            'images.*.mimes' => 'Ảnh chỉ được chấp nhận các định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước mỗi ảnh không được vượt quá 2MB',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagesPath = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('forum/posts', 'public');
                $imagesPath[] = $path;
            }
        }

        $post = ForumPost::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'images' => !empty($imagesPath) ? json_encode($imagesPath) : null,
            'status' => 'pending',
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
        ]);

        return redirect()->route('admin.forum.posts.index')
            ->with('success', 'Bài viết đã được tạo và đang chờ phê duyệt!');
    }

   
    public function show($id)
    {
        $post = ForumPost::with(['category', 'author', 'approver', 'comments'])->findOrFail($id);
        
        // Tăng lượt xem nếu không phải là người tạo bài viết
        // if (Auth::id() !== $post->user_id) {
        //     $post->increment('view_count');
        // }s

        $viewKey = "post_viewed_{$post->id}";
    
        if (!session()->has($viewKey) && Auth::id() !== $post->user_id) {
            $post->increment('view_count');
            session()->put($viewKey, true);
        }
        
        return view('admin.forum.posts.detail', compact('post'));
    }

    public function edit($id)
    {
        $post = ForumPost::findOrFail($id);
        $categories = ForumCategory::all();
        
        return view('admin.forum.posts.edit', compact('post', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        
       $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:forum_categories,id',
            'content' => 'required',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Tiêu đề không được để trống',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'category_id.exists' => 'Danh mục đã chọn không tồn tại',
            'content.required' => 'Nội dung không được để trống',
            'images.*.image' => 'Mỗi tệp tải lên phải là hình ảnh',
            'images.*.mimes' => 'Ảnh chỉ chấp nhận các định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước mỗi ảnh không được vượt quá 2MB',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagesPath = $post->images ? json_decode($post->images, true) : [];
        
        // Xử lý ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('forum/posts', 'public');
                $imagesPath[] = $path;
            }
        }
        
        // Xử lý xóa ảnh
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $index) {
                if (isset($imagesPath[$index])) {
                    Storage::disk('public')->delete($imagesPath[$index]);
                    unset($imagesPath[$index]);
                }
            }
            $imagesPath = array_values($imagesPath); // Reindex array
        }

        $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'images' => !empty($imagesPath) ? json_encode($imagesPath) : null,
            'status' => 'pending', // Cập nhật bài viết sẽ cần duyệt lại
            'is_anonymous' => $request->has('is_anonymous') ? true : false,
            'approved_by' => null,
            'approved_at' => null,
            'reject_reason' => null,
        ]);

        return redirect()->route('admin.forum.posts.show', $post->id)
            ->with('success', 'Bài viết đã được cập nhật và đang chờ phê duyệt lại!');
    }

    public function destroy($id)
    {
        $post = ForumPost::findOrFail($id);
        // $post_comment = ForumComment::findOrFail()
        // Xóa ảnh
        if ($post->images) {
            $images = json_decode($post->images, true);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $post->comments()->delete();
        $post->likes()->delete();
        
        $post->delete();

        return redirect()->route('admin.forum.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công!');
    }
    
    public function approve($id)
    {
        $post = ForumPost::findOrFail($id);
        
        $post->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'reject_reason' => null,
        ]);
        
        return redirect()->route('admin.forum.posts.show', $post->id)
            ->with('success', 'Bài viết đã được phê duyệt!');
    }
    
    public function reject(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'reject_reason' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $post->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'reject_reason' => $request->reject_reason,
        ]);
        
        return redirect()->route('admin.forum.posts.show', $post->id)
            ->with('success', 'Bài viết đã bị từ chối!');
    }
    
    public function togglePin($id)
    {
        $post = ForumPost::findOrFail($id);
        
        $post->update([
            'is_pinned' => !$post->is_pinned
        ]);
        
        $message = $post->is_pinned ? 'Bài viết đã được ghim!' : 'Bài viết đã được bỏ ghim!';
        
        return redirect()->route('admin.forum.posts.show', $post->id)
            ->with('success', $message);
    }
    
    public function toggleLock($id)
    {
        $post = ForumPost::findOrFail($id);
        
        $post->update([
            'is_locked' => !$post->is_locked
        ]);
        
        $message = $post->is_locked ? 'Bài viết đã bị khóa!' : 'Bài viết đã được mở khóa!';
        
        return redirect()->route('admin.forum.posts.show', $post->id)
            ->with('success', $message);
    }

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_ids' => 'required|array',
            'post_ids.*' => 'required|exists:forum_posts,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ], 422);
        }

        try {
            $posts = ForumPost::whereIn('id', $request->post_ids)->get();
            $deletedCount = 0;

            foreach ($posts as $post) {
                    if ($post->images) {
                        $images = json_decode($post->images, true);
                        foreach ($images as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                    
                    $post->delete();
                    $deletedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Đã xóa thành công {$deletedCount} bài viết",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa bài viết'
            ], 500);
        }
    }

    /**
     * Cập nhật trạng thái nhiều bài viết
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_ids' => 'required|array',
            'post_ids.*' => 'required|exists:forum_posts,id',
            'status' => 'required|in:approved,rejected',
            'reject_reason' => 'required_if:status,rejected|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ], 422);
        }

        try {
            $updateData = [
                'status' => $request->status,
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ];

            if ($request->status === 'rejected') {
                $updateData['reject_reason'] = $request->reject_reason;
            } else {
                $updateData['reject_reason'] = null;
            }

            $updatedCount = ForumPost::whereIn('id', $request->post_ids)
                ->where('status', 'pending')
                ->update($updateData);

            $statusText = $request->status === 'approved' ? 'phê duyệt' : 'từ chối';

            return response()->json([
                'success' => true,
                'message' => "Đã {$statusText} thành công {$updatedCount} bài viết",
                'updated_count' => $updatedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái'
            ], 500);
        }
    }

}
