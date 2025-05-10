@extends('layouts.app')

@section('content')
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li> --}}
                <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none">Diễn đàn</a></li>
                <li class="breadcrumb-item"><a href="{{ route('forum.category', $post->category->slug) }}" class="text-decoration-none">{{ $post->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 30) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <!-- Main Content - Post Details -->
        <div class="col-lg-8">
            <!-- Post Card -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $post->title }}</h4>
                    </div>
                    <span class="badge bg-secondary">{{ $post->category->name }}</span>
                </div>
                <div class="card-body">
                    <!-- Author Info -->
                    <div class="d-flex align-items-center mb-3">
                        @if($post->is_anonymous)
                            <span class="avatar bg-secondary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </span>
                            <div>
                                <div class="fw-bold">Ẩn danh</div>
                                <small class="text-muted">Đăng {{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        @else
                            @if($post->author->avatar)
                                <img src="{{ asset('storage/avatars/'.$post->author->avatar) }}" 
                                    alt="{{ $post->author->name }}" class="rounded-circle me-2" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <span class="avatar bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                </span>
                            @endif
                            <div>
                                <div class="fw-bold">{{ $post->author->name }}</div>
                                <small class="text-muted">Đăng {{ $post->created_at->diffForHumans() }}</small>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Post Content -->
                    <div class="post-content my-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    
                    <!-- Post Images -->
                    {{-- @if($post->images && count($post->images) > 0)
                        <div class="post-images my-4">
                            <h6>Hình ảnh đính kèm:</h6>
                            <div class="row">
                                @foreach($post->images as $image)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ asset('storage/'.$image) }}" data-lightbox="post-images" data-title="Ảnh đính kèm">
                                            <img src="{{ asset('storage/'.$image) }}" alt="Hình ảnh bài viết" class="img-fluid rounded">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                    
                    <!-- Post Tags -->
                    {{-- @if($post->tags && count($post->tags) > 0)
                        <div class="post-tags my-3">
                            @foreach($post->tags as $tag)
                                <a href="{{ route('forum.tag', $tag->slug) }}" class="badge bg-light text-dark text-decoration-none me-1">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif --}}
                    
                    <!-- Post Statistics -->
                    <div class="post-stats mt-4 d-flex justify-content-between">
                        <div>
                            <i class="far fa-eye me-1"></i> {{ number_format($post->view_count) }} lượt xem
                            <i class="far fa-comment ms-3 me-1"></i> {{ count($post->comments) }} bình luận
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary" id="sharePostBtn">
                                <i class="fas fa-share-alt me-1"></i> Chia sẻ
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-2" id="reportPostBtn">
                                <i class="fas fa-flag me-1"></i> Báo cáo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Comments Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="far fa-comments me-2"></i> Bình luận ({{ count($post->comments) }})
                </div>
                <div class="card-body">
                    <!-- Comment Form -->
                    @auth
                        <form action="" method="POST" class="mb-4">
                        {{-- <form action="{{ route('forum.comment.store') }}" method="POST" class="mb-4"> --}}

                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="mb-3">
                                <textarea class="form-control" name="content" rows="3" placeholder="Viết bình luận của bạn..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="comment_is_anonymous" name="is_anonymous">
                                    <label class="form-check-label" for="comment_is_anonymous">
                                        Bình luận ẩn danh
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="far fa-paper-plane me-1"></i> Gửi bình luận
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.
                        </div>
                    @endauth
                    
                    <!-- Comments List -->
                    <div class="comments-list">
                        @forelse($post->comments as $comment)
                            <div class="comment-item p-3 border-bottom">
                                <div class="d-flex">
                                    @if($comment->is_anonymous)
                                        <span class="avatar bg-secondary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-bold">Ẩn danh</div>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                    @else
                                        @if($comment->author->avatar)
                                            <img src="{{ asset('storage/avatars/'.$comment->author->avatar) }}" 
                                                alt="{{ $comment->author->name }}" class="rounded-circle me-2" 
                                                style="width: 32px; height: 32px; object-fit: cover;">
                                        @else
                                            <span class="avatar bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($comment->author->name, 0, 1)) }}
                                            </span>
                                        @endif
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="fw-bold">{{ $comment->author->name }}</div>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                    @endif
                                    <p class="mb-1 mt-2">{{ $comment->content }}</p>
                                    
                                    <!-- Comment Actions -->
                                    <div class="comment-actions mt-2">
                                        <button class="btn btn-sm btn-link text-decoration-none p-0 reply-btn" data-comment-id="{{ $comment->id }}">
                                            <i class="far fa-comment-dots"></i> Trả lời
                                        </button>
                                        
                                        @if(auth()->check() && (auth()->id() == $comment->user_id || auth()->user()->isAdmin()))
                                            <button class="btn btn-sm btn-link text-decoration-none text-danger p-0 ms-3 delete-comment-btn" data-comment-id="{{ $comment->id }}">
                                                <i class="far fa-trash-alt"></i> Xóa
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Reply Form (hidden by default) -->
                            <div class="reply-form ps-5 mt-2 mb-3 d-none" id="replyForm{{ $comment->id }}">
                                @auth
                                    <form action="{{ route('forum.reply.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="mb-2">
                                            <textarea class="form-control form-control-sm" name="content" rows="2" placeholder="Viết phản hồi của bạn..." required></textarea>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="reply_is_anonymous_{{ $comment->id }}" name="is_anonymous">
                                                <label class="form-check-label" for="reply_is_anonymous_{{ $comment->id }}">
                                                    Phản hồi ẩn danh
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="far fa-paper-plane me-1"></i> Gửi
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info py-2">
                                        <i class="fas fa-info-circle me-2"></i> Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để phản hồi.
                                    </div>
                                @endauth
                            </div>
                            
                            <!-- Nested Replies -->
                            @if($comment->replies && count($comment->replies) > 0)
                                <div class="replies-list ps-4 ms-4 border-start">
                                    @foreach($comment->replies as $reply)
                                        <div class="reply-item p-2">
                                            <div class="d-flex">
                                                @if($reply->is_anonymous)
                                                    <span class="avatar bg-secondary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="fw-bold">Ẩn danh</div>
                                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                        </div>
                                                @else
                                                    @if($reply->author->avatar)
                                                        <img src="{{ asset('storage/avatars/'.$reply->author->avatar) }}" 
                                                            alt="{{ $reply->author->name }}" class="rounded-circle me-2" 
                                                            style="width: 24px; height: 24px; object-fit: cover;">
                                                    @else
                                                        <span class="avatar bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                                                            {{ strtoupper(substr($reply->author->name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div class="fw-bold">{{ $reply->author->name }}</div>
                                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                        </div>
                                                @endif
                                                <p class="mb-1 mt-1 small">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-4">
                                <i class="far fa-comment-dots fs-4 mb-3 text-muted"></i>
                                <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Related Posts -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-link me-2"></i> Bài viết liên quan
                </div>
                <div class="list-group list-group-flush">
                    @forelse($relatedPosts as $relatedPost)
                        <a href="{{ route('forum.post.show', $relatedPost->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ Str::limit($relatedPost->title, 50) }}</h6>
                                <small>{{ $relatedPost->created_at->diffForHumans() }}</small>
                            </div>
                            <small class="text-muted">
                                <i class="far fa-comment me-1"></i> {{ count($relatedPost->comments) }}
                                <i class="far fa-eye ms-2 me-1"></i> {{ $relatedPost->view_count }}
                            </small>
                        </a>
                    @empty
                        <div class="list-group-item">Không có bài viết liên quan</div>
                    @endforelse
                </div>
            </div>
            
            <!-- Categories -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-folder me-2"></i> Chuyên mục
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <a href="{{ route('forum.category', $category->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>{{ $category->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $category->posts->count() }}</span>
                        </a>
                        @if($category->childCategories && count($category->childCategories) > 0)
                            @foreach($category->childCategories as $childCategory)
                                <a href="{{ route('forum.category', $childCategory->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ps-4">
                                    <span><i class="fas fa-angle-right me-1"></i> {{ $childCategory->name }}</span>
                                    <span class="badge bg-secondary rounded-pill">{{ $childCategory->posts->count() }}</span>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Create New Post Button -->
            @auth
                <div class="d-grid gap-2 mb-4">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createPostModal">
                        <i class="fas fa-plus-circle me-2"></i> Tạo bài viết mới
                    </button>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Modal: Share Post -->
<div class="modal fade" id="sharePostModal" tabindex="-1" aria-labelledby="sharePostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sharePostModalLabel">Chia sẻ bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Chia sẻ bài viết này tới:</p>
                <div class="d-flex justify-content-center gap-3 my-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="btn btn-outline-info">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode('Xem bài viết này tại: ' . request()->url()) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                </div>
                <div class="input-group mt-3">
                    <input type="text" class="form-control" id="postUrlInput" value="{{ request()->url() }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyUrlBtn">
                        <i class="far fa-copy"></i> Sao chép
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Report Post -->
<div class="modal fade" id="reportPostModal" tabindex="-1" aria-labelledby="reportPostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportPostModalLabel">Báo cáo bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reportPostForm" action="" method="POST">
                {{-- <form id="reportPostForm" action="{{ route('forum.report') }}" method="POST"> --}}

                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    
                    <div class="mb-3">
                        <label for="report_reason" class="form-label">Lý do báo cáo <span class="text-danger">*</span></label>
                        <select class="form-select" id="report_reason" name="reason" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="spam">Spam / Quảng cáo</option>
                            <option value="inappropriate">Nội dung không phù hợp</option>
                            <option value="offensive">Xúc phạm / Quấy rối</option>
                            <option value="copyright">Vi phạm bản quyền</option>
                            <option value="other">Lý do khác</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="report_details" class="form-label">Chi tiết (tùy chọn)</label>
                        <textarea class="form-control" id="report_details" name="details" rows="3" placeholder="Mô tả chi tiết lý do báo cáo..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="submitReport">Gửi báo cáo</button>
            </div>
        </div> 
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Share Button
        document.getElementById('sharePostBtn').addEventListener('click', function() {
            var shareModal = new bootstrap.Modal(document.getElementById('sharePostModal'));
            shareModal.show();
        });
        
        // Handle Copy URL Button
        document.getElementById('copyUrlBtn').addEventListener('click', function() {
            var urlInput = document.getElementById('postUrlInput');
            urlInput.select();
            document.execCommand('copy');
            
            // Change button text temporarily
            var originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-check"></i> Đã sao chép';
            
            setTimeout(() => {
                this.innerHTML = originalText;
            }, 2000);
        });
        
        // Handle Report Button
        document.getElementById('reportPostBtn').addEventListener('click', function() {
            var reportModal = new bootstrap.Modal(document.getElementById('reportPostModal'));
            reportModal.show();
        });
        
        // Handle Submit Report
        document.getElementById('submitReport').addEventListener('click', function() {
            var form = document.getElementById('reportPostForm');
            if (form.checkValidity()) {
                form.submit();
            } else {
                form.reportValidity();
            }
        });
        
        // Toggle Reply Forms
        document.querySelectorAll('.reply-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var commentId = this.getAttribute('data-comment-id');
                var replyForm = document.getElementById('replyForm' + commentId);
                
                // Hide all other reply forms
                document.querySelectorAll('.reply-form').forEach(function(form) {
                    if (form !== replyForm) {
                        form.classList.add('d-none');
                    }
                });
                
                // Toggle current reply form
                replyForm.classList.toggle('d-none');
            });
        });
        
        // Handle Delete Comment
        document.querySelectorAll('.delete-comment-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
                    var commentId = this.getAttribute('data-comment-id');
                    
                    // Create form and submit
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';   
                    form.style.display = 'none';
                    
                    var csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    
                    var methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    
                    var commentInput = document.createElement('input');
                    commentInput.type = 'hidden';
                    commentInput.name = 'comment_id';
                    commentInput.value = commentId;
                    
                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    form.appendChild(commentInput);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

<!-- Now, update the existing index page to link to post details -->
<!-- Add this to the topic-item in index.blade.php -->
{{-- 
<div class="topic-item">
    <div class="topic-icon">
        <i class="fas fa-file-alt"></i>
    </div>
    <div class="topic-content">
        <a href="{{ route('forum.post.show', $post->id) }}" class="topic-title">{{ $post->title }}</a>
        <div class="topic-info">
            <span><i class="fas fa-user me-1"></i> {{ $post->is_anonymous == 1 ? "Ẩn danh" : $post->author->name}}</span>
            <span class="ms-3"><i class="far fa-clock me-1"></i> {{ $post->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="topic-stats">
        <div class="stat-item">
            <div class="stat-count">{{ $post->comments_count ?? $post->comments->count() }}</div>
            <div class="stat-label">Trả lời</div>
        </div>
        <div class="stat-item">
            <div class="stat-count">{{ $post->views_count ?? 0 }}</div>
            <div class="stat-label">Lượt xem</div>
        </div>
    </div>
</div> --}}

<!-- Update the "Read More" button in your latest posts section -->
<!-- Replace this in your index.blade.php -->

{{-- <div class="post-body">
    <h5 class="post-title">{{ $p->title }}</h5>
    <p class="post-text">{{ Str::limit($p->content, 150) }}</p>
    <a href="{{ route('forum.post.show', $p->id) }}" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
</div> --}}