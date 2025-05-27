{{-- Tạo file mới tại resources/views/pages/partials/forum_comments.blade.php --}}

<!-- Phần bình luận -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="far fa-comments me-2"></i> Bình luận 
            <span class="badge bg-secondary ms-1">{{ $post->comments->count() }}</span>
        </h5>
    </div>
    <div class="card-body">
        <!-- Form thêm bình luận -->
            <form action="{{ route('forum.comment.store') }}" method="POST" class="mb-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                
                <div class="mb-3">
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                        name="content" rows="3" placeholder="Viết bình luận của bạn..."></textarea>
                    @error('content')
                        {{-- <div class="invalid-feedback">{{ $message }}</div> --}}
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        {{-- <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous"> --}}
                        <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>

                        <label class="form-check-label" for="is_anonymous">
                            Bình luận ẩn danh
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="far fa-paper-plane me-1"></i> Gửi bình luận
                    </button>
                </div>
            </form>
      
        <!-- Danh sách bình luận -->
        <div class="comments-list">
            @forelse($post->parentComments()->with('replies.author', 'author')->orderBy('created_at', 'desc')->get() as $comment)
                <div class="comment-item" id="comment-{{ $comment->id }}">
                    <div class="d-flex">
                        <!-- Ảnh đại diện/Avatar -->
                        <div class="me-3">
                            @if($comment->is_anonymous)
                                <div class="avatar-circle bg-secondary">
                                    <span class="avatar-text"><i class="fas fa-user"></i></span>
                                </div>
                            @else
                                @if($comment->author && $comment->author->avatar)
                                    <img src="{{ asset('storage/' . $comment->author->avatar) }}" 
                                        alt="{{ $comment->author->name }}" class="avatar-img">
                                @else
                                    <div class="avatar-circle bg-primary">
                                        <span class="avatar-text">{{ $comment->author ? substr($comment->author->name, 0, 1) : 'U' }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                        
                        <!-- Nội dung bình luận -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">
                                    {{ $comment->is_anonymous ? 'Ẩn danh' : ($comment->author ? $comment->author->name : 'Người dùng') }}
                                </h6>
                                <small class="text-muted">  {{ timeAgo($comment->created_at) }}</small>
                            </div>
                            
                            <div class="comment-content my-2">
                                {{ $comment->content }}
                            </div>
                            
                            <!-- Actions -->
                            <div class="comment-actions">
                                <button type="button" class="btn btn-sm btn-link ps-0 reply-btn" 
                                        data-comment-id="{{ $comment->id }}">
                                    <i class="far fa-comment-dots"></i> Phản hồi
                                </button>
                                
                                @if(Auth::check() && (Auth::id() == $comment->user_id || (Auth::user()->isAdmin && Auth::user()->isAdmin())))
                                    <form action="{{ route('forum.comment.delete') }}" method="POST" 
                                          class="d-inline delete-comment-form">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <button type="submit" class="btn btn-sm btn-link text-danger delete-comment-btn">
                                            <i class="far fa-trash-alt"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <!-- Form phản hồi (ẩn mặc định) -->
                            <div class="reply-form mt-3 d-none" id="reply-form-{{ $comment->id }}">
                                {{-- @auth --}}
                                    <form action="{{ route('forum.comment.reply') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        
                                        <div class="mb-2">
                                            <textarea class="form-control form-control-sm" 
                                                name="content" rows="2" 
                                                placeholder="Viết phản hồi của bạn..." required></textarea>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="reply_is_anonymous_{{ $comment->id }}" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                                                {{-- <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}> --}}

                                                <label class="form-check-label" for="reply_is_anonymous_{{ $comment->id }}">
                                                    Phản hồi ẩn danh
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="far fa-paper-plane me-1"></i> Gửi
                                            </button>
                                        </div>
                                    </form>
                            </div>
                            
                            <!-- Các phản hồi -->
                            @if($comment->replies->count() > 0)
                                <div class="replies-list mt-3 ps-3">
                                    @foreach($comment->replies as $reply)
                                        <div class="reply-item mb-2" id="comment-{{ $reply->id }}">
                                            <div class="d-flex">
                                                <!-- Ảnh đại diện/Avatar (nhỏ hơn) -->
                                                <div class="me-2">
                                                    @if($reply->is_anonymous)
                                                        <div class="avatar-circle avatar-circle-sm bg-secondary">
                                                            <span class="avatar-text"><i class="fas fa-user"></i></span>
                                                        </div>
                                                    @else
                                                        @if($reply->author && $reply->author->avatar)
                                                            <img src="{{ asset('storage/' . $reply->author->avatar) }}" 
                                                                alt="{{ $reply->author->name }}" class="avatar-img avatar-img-sm">
                                                        @else
                                                            <div class="avatar-circle avatar-circle-sm bg-primary">
                                                                <span class="avatar-text">{{ $reply->author ? substr($reply->author->name, 0, 1) : 'U' }}</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                <!-- Nội dung phản hồi -->
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="mb-0 small fw-bold">
                                                            {{ $reply->is_anonymous ? 'Ẩn danh' : ($reply->author ? $reply->author->name : 'Người dùng') }}
                                                        </h6>
                                                        <small class="text-muted">{{ timeAgo($reply->created_at) }}</small>
                                                    </div>
                                                    
                                                    <div class="reply-content my-1 small">
                                                        {{ $reply->content }}
                                                    </div>
                                                    
                                                    <!-- Actions -->
                                                    @if(Auth::check() && (Auth::id() == $reply->user_id || (Auth::user()->isAdmin && Auth::user()->isAdmin())))
                                                        <div class="reply-actions">
                                                            <form action="{{ route('forum.comment.delete') }}" method="POST" 
                                                                  class="d-inline delete-comment-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="comment_id" value="{{ $reply->id }}">
                                                                <button type="submit" class="btn btn-sm btn-link p-0 text-danger delete-comment-btn">
                                                                    <small><i class="far fa-trash-alt"></i> Xóa</small>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Divider giữa các bình luận -->
                @if(!$loop->last)
                    <hr class="my-3">
                @endif
            @empty
                <div class="text-center py-4">
                    <i class="far fa-comment-dots text-muted fa-3x mb-3"></i>
                    <p class="text-muted">Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                </div>
            @endforelse
        </div>
        
        <!-- Nút tải thêm bình luận (nếu cần) -->
        @if($post->comments->count() > 10)
            <div class="text-center mt-4">
                <button id="loadMoreComments" 
                        class="btn btn-outline-primary" 
                        data-post-id="{{ $post->id }}" 
                        data-page="1">
                    <i class="fas fa-sync-alt me-1"></i> Tải thêm bình luận
                </button>
            </div>
        @endif
    </div>
</div>