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
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{   
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryId = $request->get('category');
        $status = $request->get('status');
        $sortBy = $request->get('sort', 'latest'); // Default: latest
        $perPage = $request->get('per_page', 10); // Default: 10 items per page

        $categories = ForumCategory::where('is_active', true)
            ->with(['posts' => function($query) {
                $query->where('status', 'approved')
                    ->orderBy('created_at', 'desc')
                    ->take(3);
            }])
            ->get();
        
        // Query cho user posts nếu đã đăng nhập
        if (Auth::check()) {
            $userId = Auth::id();
            
            $userPosts = ForumPost::where('user_id', $userId)
                ->with('category')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $pendingPosts = $userPosts->where('status', 'pending');
            $approvedPosts = $userPosts->where('status', 'approved');
            $rejectedPosts = $userPosts->where('status', 'rejected');
        } else {
            $userPosts = collect();
            $pendingPosts = collect();
            $approvedPosts = collect();
            $rejectedPosts = collect();
        }
        
        $postsQuery = ForumPost::where('status', 'approved')
            ->with(['category', 'author'])
            ->withCount('comments')
            ->withCount('likes');

        if ($search) {
            $postsQuery->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $postsQuery->where('category_id', $categoryId);
        }

        switch ($sortBy) {
            case 'oldest':
                $postsQuery->orderBy('created_at', 'asc');
                break;
            case 'most_viewed':
                $postsQuery->orderBy('view_count', 'desc');
                break;
            case 'most_commented':
                $postsQuery->orderBy('comments_count', 'desc');
                break;
            case 'latest':
            default:
                $postsQuery->orderBy('created_at', 'desc');
                break;
        }

        $latestPosts = $postsQuery->paginate($perPage)->withQueryString();
        $mostLikedPosts = ForumPost::where('status', 'approved')
                           ->with(['category', 'author'])
                           ->withCount('likes')
                           ->orderBy('likes_count', 'desc')
                           ->take(10) 
                           ->get();

        // Thống kê
        $totalPosts = ForumPost::where('status', 'approved')->count();
        $totalCategories = ForumCategory::where('is_active', 1)->count();
        $totalUsers = User::where('is_active', 1)->count();

        return view('pages.forum', [
            'categories' => $categories,
            'userPosts' => $userPosts,
            'pendingPosts' => $pendingPosts,
            'approvedPosts' => $approvedPosts,
            'rejectedPosts' => $rejectedPosts,
            'latestPosts' => $latestPosts,
            'totalPosts' => $totalPosts,
            'totalCategories' => $totalCategories,
            'totalUsers' => $totalUsers,
            'search' => $search,
            'selectedCategory' => $categoryId,
            'sortBy' => $sortBy,
            'perPage' => $perPage,
            'mostLikedPosts' => $mostLikedPosts
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');
        $categoryId = $request->get('category');
        $sortBy = $request->get('sort', 'latest');
        $page = $request->get('page', 1);
        $perPage = $request->get('per_page', 10);

        $query = ForumPost::where('status', 'approved')
            ->with(['category', 'author'])
            ->withCount('comments')
            ->withCount('likes');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        switch ($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('view_count', 'desc');
                break;
            case 'most_commented':
                $query->orderBy('comments_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $posts = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'has_more_pages' => $posts->hasMorePages()
            ]
        ]);
    }

    public function post(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:forum_categories,id', 
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Vui lòng điền tiêu đề',
            'content.required' => 'Vui lòng điền nội dung',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh hợp lệ',
            'images.*.max' => 'Ảnh không được lớn hơn 2MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->with('Bài viết chưa được đăng vui lòng kiểm tra lại nội dung');
        }

        $imagesPath = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('forum/posts', 'public');
                $imagesPath[] = $path;
            }
        }

        $categoryId = $request->category_id;
        if ($categoryId == '0' || empty($categoryId)) {
            $categoryId = null;
        }

        $post = ForumPost::create([
            'title' => $request->title,
            'category_id' => $categoryId, 
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
            'category_id' => 'nullable|exists:forum_categories,id',
            'content' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        
        if ($post->user_id != Auth::id()) {
            return redirect()->route('forum.index')
                ->with('error', 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        $post->title = $request->title;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->is_anonymous = $request->has('is_anonymous') ? true : false;
        $post->status = 'pending';

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
        
        if ($post->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'category_id' => $post->category_id,
            'content' => $post->content,
            'images' => $post->images ? json_decode($post->images) : [],
            'is_anonymous' => (bool) $post->is_anonymous,
            'notify_replies' => (bool) $post->notify_replies,
        ]);
    }

    public function showPost($id)
    {
        $post = ForumPost::with(['author', 'category', 'comments.author'])
            ->findOrFail($id);
        
        // $post->increment('view_count');

        $viewKey = "post_viewed_{$post->id}";
    
        if(!session()->has($viewKey) && Auth::id() !== $post->user_id) {
            $post->increment('view_count');
            session()->put($viewKey, true);
        }
        
        $likeCount = DB::table('forum_likes')
            ->where('post_id', $post->id)
            ->count();
        
        $userLiked = Auth::check() ? DB::table('forum_likes')
            ->where('post_id', $post->id)
            ->where('user_id', Auth::id())
            ->exists() : false;
        
        $relatedPosts = ForumPost::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'approved')
            ->latest()
            ->take(3)
            ->get();
        
        $categories = ForumCategory::with('children')->whereNull('parent_id')->get();
        
        return view('pages.forum_post_detail', compact(
            'post', 
            'relatedPosts', 
            'categories', 
            'likeCount', 
            'userLiked'
        ));
    }

    public function showCategory($slug)
    {
        $category = ForumCategory::where('slug', $slug)->firstOrFail();
        $postsQuery = ForumPost::with(['author', 'category', 'comments'])
            ->where('status', 'approved');
            
        if ($category->childCategories && $category->childCategories->count() > 0) {
            $categoryIds = collect([$category->id]);
            $categoryIds = $categoryIds->merge($category->childCategories->pluck('id'));
            
            $postsQuery->whereIn('category_id', $categoryIds);
        } else {
            $postsQuery->where('category_id', $category->id);
        }
        
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
        
        $posts = $postsQuery->paginate(10)->withQueryString();
        
        $categories = ForumCategory::with(['children', 'posts'])
            ->whereNull('parent_id')
            ->get();
        
        return view('pages.forum_category', compact('category', 'posts', 'categories', 'sort'));
    }

    public function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:forum_posts,id',
            'content' => 'required|string|min:2|max:1000',
        ], ['content.required' => 'Vui lòng nhập nội dung bình luận']);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        
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
        
        return redirect()->back()
            ->with('success', 'Bình luận của bạn đã được đăng thành công.');
    }

    
    public function storeReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:forum_posts,id',
            'parent_id' => 'required|exists:forum_comments,id',
            'content' => 'required|string|min:2|max:1000',
        ], ['content.required' => 'Vui lòng nhập nội dung!']);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $post = ForumPost::findOrFail($request->post_id);
        $parentComment = ForumComment::findOrFail($request->parent_id);
        
        if ($parentComment->post_id != $post->id) {
            return redirect()->back()
                ->with('error', 'Yêu cầu không hợp lệ.');
        }
        
        $reply = new ForumComment();
        $reply->post_id = $post->id;
        $reply->user_id = Auth::id();
        $reply->parent_id = $parentComment->id;
        $reply->content = $request->content;
        $reply->is_anonymous = $request->has('is_anonymous') ? 1 : 0;
        $reply->save();
        
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
        
        if ($comment->user_id != Auth::id()) {
            return redirect()->back()
                ->with('error', 'Bạn không có quyền xóa bình luận này.');
        }
        
        ForumComment::where('parent_id', $comment->id)->delete();
        
        $comment->delete();
        
        return redirect()->back()
            ->with('success', 'Bình luận đã được xóa thành công.');
    }

    public function getComments($postId)
    {
        $post = ForumPost::findOrFail($postId);
        $perPage = request('per_page', 10);
        $page = request('page', 1);
        
        $comments = ForumComment::with(['author', 'replies.author'])
            ->where('post_id', $postId)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        
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

    public function toggleLike(Request $request, $postId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để thích bài viết'
            ], 401);
        }

        $userId = Auth::id();
        $post = ForumPost::findOrFail($postId);
        
        $existingLike = DB::table('forum_likes')
            ->where('post_id', $postId)
            ->where('user_id', $userId)
            ->first();
        
        if ($existingLike) {
            DB::table('forum_likes')
                ->where('post_id', $postId)
                ->where('user_id', $userId)
                ->delete();
            
            $action = 'unliked';
        } else {
            DB::table('forum_likes')->insert([
                'post_id' => $postId,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $action = 'liked';
        }
        
        $likeCount = DB::table('forum_likes')
            ->where('post_id', $postId)
            ->count();
        
        return response()->json([
            'success' => true,
            'action' => $action,
            'likeCount' => $likeCount
        ]);
    }

    public function getLikeInfo(Request $request, $postId)
    {
        $post = ForumPost::findOrFail($postId);
        $likeCount = DB::table('forum_likes')
            ->where('post_id', $postId)
            ->count();
        
        $userLiked = false;
        
        if (Auth::check()) {
            $userLiked = DB::table('forum_likes')
                ->where('post_id', $postId)
                ->where('user_id', Auth::id())
                ->exists();
        }
        
        return response()->json([
            'success' => true,
            'likeCount' => $likeCount,
            'userLiked' => $userLiked
        ]);
    }
}