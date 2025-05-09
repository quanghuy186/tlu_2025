<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ForumController extends Controller
{   
    public function index()
    {
        // Lấy danh sách chuyên mục
        $categories = ForumCategory::where('is_active', true)
            ->with(['posts' => function($query) {
                $query->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(3); // Chỉ lấy 3 bài viết mới nhất của mỗi chuyên mục
            }])
            ->get();
        
        if (Auth::check()) {
            $userId = Auth::id();
            
            // Lấy tất cả bài viết của người dùng đăng nhập
            $userPosts = ForumPost::where('user_id', $userId)
                ->with('category') // Eager loading relationship
                // ->withCount('comments') // Đếm số lượng comments và views
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Lọc các bài viết theo trạng thái
            $pendingPosts = $userPosts->where('status', 'pending');
            $approvedPosts = $userPosts->where('status', 'approved');
            $rejectedPosts = $userPosts->where('status', 'rejected');
        } else {
            // Nếu chưa đăng nhập, đặt các biến là collections rỗng
            $userPosts = collect();
            $pendingPosts = collect();
            $approvedPosts = collect();
            $rejectedPosts = collect();
        }
        
        // Kiểm tra nếu có query parameter post để hiển thị chi tiết bài viết
        $selectedPost = null;
        if (request()->has('post')) {
            $postId = request()->get('post');
            $selectedPost = ForumPost::with(['category', 'author', 'comments.user'])
                ->findOrFail($postId);
                
            // Tăng lượt xem nếu người xem không phải tác giả
            // if (!Auth::check() || (Auth::check() && Auth::id() != $selectedPost->user_id)) {
            //     $view = new ForumView();
            //     $view->post_id = $selectedPost->id;
            //     $view->user_id = Auth::check() ? Auth::id() : null;
            //     $view->ip_address = request()->ip();
            //     $view->save();
            // }
        }

        // if (!Auth::check() || (Auth::id() !== $selectedPost->user_id)) {
        //     // Kiểm tra xem người dùng đã xem bài viết này chưa (trong vòng 24 giờ)
        //     $hasViewed = false;
            
        //     if (Auth::check()) {
        //         // Nếu đã đăng nhập, kiểm tra theo user_id
        //         $hasViewed = ForumView::where('post_id', $selectedPost->id)
        //             ->where('user_id', Auth::id())
        //             ->where('created_at', '>', now()->subHours(24))
        //             ->exists();
        //     } else {
        //         // Nếu chưa đăng nhập, kiểm tra theo IP
        //         $hasViewed = ForumView::where('post_id', $selectedPost->id)
        //             ->where('ip_address', request()->ip())
        //             ->where('created_at', '>', now()->subHours(24))
        //             ->exists();
        //     }
            
        //     // Nếu chưa xem trong 24 giờ qua, tăng lượt xem
        //     if (!$hasViewed) {
        //         $view = new ForumView();
        //         $view->post_id = $selectedPost->id;
        //         $view->user_id = Auth::check() ? Auth::id() : null;
        //         $view->ip_address = request()->ip();
        //         $view->save();
        //     }
        // }
        
        // Lấy các bài viết được duyệt cho hiển thị công khai
        $categories = ForumCategory::with(['posts' => function($query) {
            $query->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->take(3); // Chỉ lấy 3 bài viết mới nhất của mỗi chuyên mục
        }])->get();
        
        // Lấy các bài viết mới nhất đã được duyệt
        // $latestPosts = ForumPost::where('status', 'approved')
        //     ->with(['category', 'user'])
        //     ->withCount(['comments', 'views'])
        //     ->orderBy('created_at', 'desc')
        //     ->take(5)
        //     ->get();

        $latestPosts = ForumPost::where('status', 'approved')
            ->with(['category', 'author'])
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pages.forum', [
            'categories' => $categories,
            'userPosts' => $userPosts, // Tất cả bài viết của người dùng
            'pendingPosts' => $pendingPosts, // Bài viết đang chờ duyệt
            'approvedPosts' => $approvedPosts, // Bài viết đã duyệt
            'rejectedPosts' => $rejectedPosts, // Bài viết bị từ chối
            'selectedPost' => $selectedPost, // Bài viết được chọn để xem chi tiết
            'latestPosts' => $latestPosts, // Các bài viết mới nhất
        ]);
    }

    public function post(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:forum_categories,id',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean',
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

        return redirect()->route('forum.index')
            ->with('success', 'Bài viết đã được tạo và đang chờ phê duyệt!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:forum_posts,id',
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:forum_categories,id',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_anonymous' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        
        // Kiểm tra quyền sở hữu bài viết
        if ($post->user_id != Auth::id()) {
            return redirect()->route('forum.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        // Cập nhật thông tin bài viết
        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->is_anonymous = $request->has('is_anonymous') ? true : false;
        $post->status = 'pending'; // Reset trạng thái về chờ duyệt

        // Xử lý hình ảnh mới nếu có
        if ($request->hasFile('images')) {
            $imagesPath = $post->images ? json_decode($post->images, true) : [];
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('forum/posts', 'public');
                $imagesPath[] = $path;
            }
            
            $post->images = json_encode($imagesPath);
        }

        $post->save();

        return redirect()->route('forum.index')
            ->with('success', 'Bài viết đã được cập nhật và đang chờ phê duyệt lại!');
    }

    public function getPostData($id)
    {
        $post = ForumPost::findOrFail($id);
        
        // Kiểm tra quyền truy cập
        if ($post->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'category_id' => $post->category_id,
            'content' => $post->content,
            'images' => $post->images ? json_decode($post->images) : [],
            'tags' => $post->tags,
            'is_anonymous' => (bool) $post->is_anonymous,
            'notify_replies' => (bool) $post->notify_replies,
        ]);
    }
}
