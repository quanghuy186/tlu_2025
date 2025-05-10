<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Models\ForumCategory;
use App\Models\ForumComment;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ForumController extends Controller
{   
    public function index()
    {
        $categories = ForumCategory::where('is_active', true)
        ->with(['posts' => function($query) {
            $query->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->take(3);
        }])
        ->paginate(5);
        
        if (Auth::check()) {
            $userId = Auth::id();
            
            // Lấy tất cả bài viết của người dùng đăng nhập
            $userPosts = ForumPost::where('user_id', $userId)
                ->with('category') // Eager loading relationship
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
        
        $latestPosts = ForumPost::where('status', 'approved')
            ->with(['category', 'author'])
            ->withCount('comments')
            // ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->paginate(5);

        $totalPosts = ForumPost::where('status', 'approved')->count();
        $totalCategories = ForumCategory::where('is_active', 1)->count();
        $totalUsers = User::where('is_active', 1)->count();

        return view('pages.forum', [
            'categories' => $categories,
            'userPosts' => $userPosts, // Tất cả bài viết của người dùng
            'pendingPosts' => $pendingPosts, // Bài viết đang chờ duyệt
            'approvedPosts' => $approvedPosts, // Bài viết đã duyệt
            'rejectedPosts' => $rejectedPosts, // Bài viết bị từ chối
            'selectedPost' => $selectedPost, // Bài viết được chọn để xem chi tiết
            'latestPosts' => $latestPosts, // Các bài viết mới nhất
            'totalPosts' => $totalPosts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers
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
            // 'tags' => $post->tags,
            'is_anonymous' => (bool) $post->is_anonymous,
            'notify_replies' => (bool) $post->notify_replies,
        ]);
    }

    public function showPost($id)
    {
        // Find the post with its relationships
        $post = ForumPost::with(['author', 'category', 'comments.author'])
            ->findOrFail($id);
        
        // Increment view count
        $post->increment('view_count');
        
        // Get related posts from the same category
        $relatedPosts = ForumPost::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();
        
        // Get categories for the sidebar
        $categories = ForumCategory::with('children')->whereNull('parent_id')->get();
        
        return view('pages.forum_post_detail', compact('post', 'relatedPosts', 'categories'));
    }

    public function showCategory($slug)
    {
        $category = ForumCategory::where('slug', $slug)->firstOrFail();
        
        // Get posts for this category and its children (if any)
        $postsQuery = ForumPost::with(['author', 'category', 'comments'])
            ->where('status', 'approved');
            
        if ($category->childCategories && $category->childCategories->count() > 0) {
            // If this is a parent category, include posts from child categories too
            $categoryIds = collect([$category->id]);
            $categoryIds = $categoryIds->merge($category->childCategories->pluck('id'));
            
            $postsQuery->whereIn('category_id', $categoryIds);
        } else {
            // Just use this category's ID
            $postsQuery->where('category_id', $category->id);
        }
        
        // Apply sorting (default to newest first)
        $sort = request('sort', 'newest');
        
        switch ($sort) {
            case 'most_viewed':
                $postsQuery->orderBy('view_count', 'desc');
                break;
            case 'most_commented':
                $postsQuery->withCount('comments')->orderBy('comments_count', 'desc');
                break;
            case 'oldest':
                $postsQuery->oldest();
                break;
            case 'newest':
            default:
                $postsQuery->latest();
                break;
        }
        
        // Paginate the results
        $posts = $postsQuery->paginate(10)->withQueryString();
        
        // Get categories for sidebar
        $categories = ForumCategory::with(['children', 'posts'])
            ->whereNull('parent_id')
            ->get();
        
        // Get popular tags used in this category
        // $popularTags = Tag::withCount(['posts' => function($query) use ($category) {
        //     $query->where('category_id', $category->id);
        // }])
        // ->orderBy('posts_count', 'desc')
        // ->take(10)
        // ->get();
        
        return view('pages.forum_category', compact('category', 'posts', 'categories', 'sort'));
    }

    public function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:forum_posts,id',
            'content' => 'required|string|min:2|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        
        // Chỉ cho phép bình luận trên bài viết đã duyệt
        if ($post->status != 'approved') {
            return redirect()->back()
                ->with('error', 'Không thể bình luận trên bài viết chưa được duyệt.');
        }
        
        $comment = new ForumComment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;
        $comment->is_anonymous = $request->has('is_anonymous') ? true : false;
        $comment->save();
        
        // Gửi thông báo cho tác giả bài viết (nếu có cài đặt nhận thông báo)
        if ($post->notify_replies && $post->user_id != Auth::id()) {
            // Gọi hàm gửi thông báo ở đây (có thể triển khai sau)
            // $this->sendCommentNotification($post, $comment);
        }
        
        return redirect()->back()
            ->with('success', 'Bình luận của bạn đã được đăng thành công.');
    }

    
    public function storeReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:forum_posts,id',
            'parent_id ' => 'required|exists:forum_comments,id',
            'content' => 'required|string|min:2|max:1000',
            'is_anonymous' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        $parentComment = ForumComment::findOrFail($request->parent_id);
        
        // Kiểm tra xem parent comment có thuộc về post này không
        if ($parentComment->post_id != $post->id) {
            return redirect()->back()
                ->with('error', 'Yêu cầu không hợp lệ.');
        }
        
        $reply = new ForumComment();
        $reply->post_id = $post->id;
        $reply->user_id = Auth::id();
        $reply->parent_id = $parentComment->id;
        $reply->content = $request->content;
        $reply->is_anonymous = $request->has('is_anonymous') ? true : false;
        $reply->save();
        
        // Gửi thông báo cho người comment gốc
        if ($parentComment->user_id != Auth::id()) {
            // Gọi hàm gửi thông báo ở đây (có thể triển khai sau)
            // $this->sendReplyNotification($parentComment, $reply);
        }
        
        return redirect()->back()
            ->with('success', 'Phản hồi của bạn đã được đăng thành công.');
    }

    public function deleteComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|exists:forum_comments,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $comment = ForumComment::findOrFail($request->comment_id);
        
        // Kiểm tra quyền xóa (chỉ người viết comment hoặc admin mới được xóa)
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền xóa bình luận này.');
        }
        
        // Nếu có các phản hồi con, xóa chúng trước
        ForumComment::where('parent_id', $comment->id)->delete();
        
        // Sau đó xóa comment chính
        $comment->delete();
        
        return redirect()->back()
            ->with('success', 'Bình luận đã được xóa thành công.');
    }

   
    public function getComments($postId)
    {
        $post = ForumPost::findOrFail($postId);
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        
        // Lấy các bình luận gốc (không có parent)
        $comments = ForumComment::with(['author', 'replies.author'])
            ->where('post_id', $postId)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
        // Format dữ liệu cho response
        $formattedComments = $comments->map(function($comment) {
            $formattedReplies = $comment->replies->map(function($reply) {
                return [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'created_at' => $reply->created_at->format('Y-m-d H:i:s'),
                    'created_at_human' => $reply->created_at->diffForHumans(),
                    'is_anonymous' => $reply->is_anonymous,
                    'user' => $reply->is_anonymous ? [
                        'name' => 'Ẩn danh',
                        'avatar' => null
                    ] : [
                        'id' => $reply->author->id,
                        'name' => $reply->author->name,
                        'avatar' => $reply->author->avatar
                    ],
                    'can_delete' => Auth::check() && (Auth::id() == $reply->user_id)
                ];
            });
            
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                'created_at_human' => $comment->created_at->diffForHumans(),
                'is_anonymous' => $comment->is_anonymous,
                'user' => $comment->is_anonymous ? [
                    'name' => 'Ẩn danh',
                    'avatar' => null
                ] : [
                    'id' => $comment->author->id,
                    'name' => $comment->author->name,
                    'avatar' => $comment->author->avatar
                ],
                'replies' => $formattedReplies,
                'can_delete' => Auth::check() && (Auth::id() == $comment->user_id)
            ];
        });
        
        return response()->json([
            'data' => $formattedComments,
            'meta' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total()
            ]
        ]);
    }

}
