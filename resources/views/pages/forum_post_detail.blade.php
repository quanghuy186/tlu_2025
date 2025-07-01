@extends('layouts.app')

@section('title')
    Xem chi tiết bài viết diễn đàn
@endsection

@section('content')
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li> --}}
                <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none">Diễn đàn</a></li>

                @if($post->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('forum.category', $post->category->slug) }}" class="text-decoration-none">
                            {{ $post->category->name }}
                        </a>
                    </li>
                @else
                    <li class="breadcrumb-item">
                        <span class="text-muted">Chưa phân loại</span>
                    </li>
                @endif


                {{-- <li class="breadcrumb-item"><a href="{{ route('forum.category', $post->category->slug) }}" class="text-decoration-none">{{ $post->category->name }}</a></li> --}}
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
                    @if($post->category)
                        <span class="badge bg-secondary">{{ $post->category->name }}</span>

                    @endif
                </div>
                <div class="card-body">
                    <!-- Author Info -->
                    <div class="d-flex align-items-center mb-3">
                        @if($post->is_anonymous)
                            <span class="avatar bg-secondary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-user"></i>
                            </span>
                            <div>
                                @can('show-anonymously', $post)
                                    <div class="fw-bold">{{ $post->author->name }}</div>
                                @else
                                    <div class="fw-bold">Ẩn danh</div>
                                @endcan
                                <small class="text-muted">Đăng {{ timeAgo($post->created_at) }}</small>
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
                                <small class="text-muted">Đăng {{ timeAgo($post->created_at) }}</small>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Post Content -->
                    <div class="post-content my-4">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    
                    <!-- Post Images -->
                    @if($post->images)
                        @php
                            // If images is stored as a JSON string, decode it
                            $imagesArray = is_string($post->images) ? json_decode($post->images, true) : [];
                            
                            // If json_decode returned null (invalid JSON) or false, try treating it as a comma-separated string
                            if (!$imagesArray) {
                                $imagesArray = is_string($post->images) ? explode(',', $post->images) : [];
                            }
                        @endphp
                        
                        @if(is_array($imagesArray) && count($imagesArray) > 0)
                            <div class="post-images my-4">
                                <h6>Hình ảnh đính kèm:</h6>
                                <div class="row">
                                    @foreach($imagesArray as $image)
                                        <div class="col-md-4 mb-3">
                                            <a href="{{ asset('storage/'.trim($image)) }}" data-lightbox="post-images" data-title="Ảnh đính kèm">
                                                <img src="{{ asset('storage/'.trim($image)) }}" alt="Hình ảnh bài viết" class="img-fluid rounded">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                    
                    <!-- Post Statistics -->
                    <div class="post-stats mt-4 d-flex justify-content-between">
                        

                        <div>
                            <i class="far fa-eye me-1"></i> {{ number_format($post->view_count) }} lượt xem
                            <a style="text-decoration: none;" href="#" class="mx-3 like-button {{ Auth::check() && $post->likedByUser(Auth::id()) ? 'liked' : '' }}" data-post-id="{{ $post->id }}">
                                <i class="{{ Auth::check() && $post->likedByUser(Auth::id()) ? 'fas' : 'far' }} fa-heart"></i> 
                                    <span  class="like-count">{{ $post->likes_count }}</span> thích
                            </a>
                            <i class="far fa-comment ms-3 me-1"></i> {{ count($post->comments) }} bình luận
                        </div>
                        {{-- <div>
                            <button class="btn btn-sm btn-outline-primary" id="sharePostBtn">
                                <i class="fas fa-share-alt me-1"></i> Chia sẻ
                            </button>
                            <button class="btn btn-sm btn-outline-danger ms-2" id="reportPostBtn">
                                <i class="fas fa-flag me-1"></i> Báo cáo
                            </button>
                        </div> --}}

                        
                    </div>

                    <div class="share-section">
                            <h5>Chia sẻ bài viết:</h5>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                target="_blank" class="btn btn-facebook">
                                    <i class="fab fa-facebook-f text-white"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                                target="_blank" class="btn btn-twitter">
                                    <i class="fab fa-twitter"></i> Twitter
                                </a>
                                <a href="mailto:?subject={{ urlencode($post->title) }}&body={{ urlencode(request()->url()) }}" 
                                class="btn btn-email">
                                    <i class="far fa-envelope"></i> Email
                                </a>
                                <button onclick="copyToClipboard('{{ request()->url() }}')" class="btn btn-copy">
                                    <i class="far fa-copy"></i> Copy Link
                                </button>
                            </div>
                    </div>

                </div>
            </div>
            
            @include('partials.forum_comments')
           
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
                                {{-- <small>{{ $relatedPost->created_at->diffForHumans() }}</small> --}}
                                <small>{{ timeAgo($relatedPost->created_at) }}</small>
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
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    // Khai báo các biến cần thiết cho JavaScript
    const assetPath = "{{ asset('storage/') }}/";
    const csrfToken = "{{ csrf_token() }}";
    const postId = "{{ $post->id }}";
    const deleteCommentRoute = "{{ route('forum.comment.delete') }}";
    const replyCommentRoute = "{{ route('forum.comment.reply') }}";
    const loginRoute = "{{ route('login') }}";
    const isAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
</script>

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

<style>
.share-section {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-top: 30px;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 15px;
}

.share-buttons .btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

</style>
