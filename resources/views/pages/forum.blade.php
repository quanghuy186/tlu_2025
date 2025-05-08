@extends('layouts.app')

@section('content')

<section class="forum-header">
    <div class="container text-center">
        <h1>Diễn đàn trao đổi TLU</h1>
        <p>Nơi trao đổi, chia sẻ kiến thức, thông tin và giải đáp thắc mắc trong cộng đồng Đại học Thủy Lợi</p>
        <div class="search-box bg-white p-2 rounded-pill d-flex align-items-center justify-content-between mt-4 mx-auto" style="max-width: 600px;">
            <input type="text" class="border-0 flex-grow-1 p-2 ms-3" placeholder="Tìm kiếm chủ đề, bài viết...">
            <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold"><i class="fas fa-search me-2"></i> Tìm kiếm</button>
        </div>
    </div>
</section>


<!-- Modal Tạo Bài Viết -->
<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Tạo bài viết mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newPostForm" action="{{ route('forum.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-2 col-form-label">Chuyên mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">-- Chọn chuyên mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="content" class="col-sm-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hỗ trợ định dạng Markdown</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="images" class="col-sm-2 col-form-label">Hình ảnh</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Có thể chọn nhiều hình ảnh (JPG, PNG, GIF - Tối đa 2MB/ảnh)</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="tags" class="col-sm-2 col-form-label">Thẻ</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="Thêm thẻ (phân cách bằng dấu phẩy)">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ví dụ: toán cao cấp, kinh nghiệm học tập, tài liệu</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notify_replies" name="notify_replies" {{ old('notify_replies') ? 'checked' : '' }} checked>
                                <label class="form-check-label" for="notify_replies">
                                    Thông báo cho tôi khi có bình luận mới
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="submit" class="btn btn-success" id="submitPost">Đăng bài viết</button>
            </div>
        </div>
    </div>
</div>


<!-- Breadcrumb -->
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Diễn đàn</li>
            </ol>
        </nav>
    </div>
</div>


<!-- Thêm phần tab để xem các bài viết theo trạng thái -->
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-2"></i> Bài viết của tôi
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="myPostsTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="posts-all-tab" data-bs-toggle="pill" data-bs-target="#posts-all" type="button" role="tab" aria-controls="posts-all" aria-selected="true">
                                Tất cả <span class="badge bg-secondary ms-1">{{ count($userPosts ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="posts-pending-tab" data-bs-toggle="pill" data-bs-target="#posts-pending" type="button" role="tab" aria-controls="posts-pending" aria-selected="false">
                                Chờ duyệt <span class="badge bg-warning text-dark ms-1">{{ count($pendingPosts ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="posts-approved-tab" data-bs-toggle="pill" data-bs-target="#posts-approved" type="button" role="tab" aria-controls="posts-approved" aria-selected="false">
                                Đã duyệt <span class="badge bg-success ms-1">{{ count($approvedPosts ?? []) }}</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="posts-rejected-tab" data-bs-toggle="pill" data-bs-target="#posts-rejected" type="button" role="tab" aria-controls="posts-rejected" aria-selected="false">
                                Từ chối <span class="badge bg-danger ms-1">{{ count($rejectedPosts ?? []) }}</span>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="myPostsTabContent">
                        <!-- Tab tất cả bài viết -->
                        <div class="tab-pane fade show active" id="posts-all" role="tabpanel" aria-labelledby="posts-all-tab">
                            @if(isset($userPosts) && count($userPosts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Chuyên mục</th>
                                                <th>Ngày đăng</th>
                                                <th>Trạng thái</th>
                                                <th>Tương tác</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($userPosts as $post)
                                            <tr data-post-id="{{ $post->id }}">
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                                                </td>
                                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    @if($post->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Chờ duyệt</span>
                                                    @elseif($post->status == 'approved')
                                                        <span class="badge bg-success">Đã duyệt</span>
                                                    @elseif($post->status == 'rejected')
                                                        <span class="badge bg-danger">Từ chối</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <i class="far fa-comment me-1"></i> {{ $post->comments_count ?? 0 }}
                                                    <i class="far fa-eye ms-2 me-1"></i> {{ $post->view_count ?? 0 }}
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                        @if($post->status != 'approved')
                                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-post-btn" data-post-id="{{ $post->id }}" title="Chỉnh sửa">
                                                                <i class="far fa-edit"></i>
                                                            </button>
                                                        @endif
                                                        @if($post->status == 'rejected')
                                                            <button type="button" class="btn btn-sm btn-outline-info view-rejection-reason" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal" data-rejection="{{ $post->rejection_reason ?? 'Không có lý do được cung cấp.' }}" data-post-id="{{ $post->id }}" title="Xem lý do từ chối">
                                                                <i class="fas fa-info-circle"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Bạn chưa có bài viết nào.
                                    <button type="button" class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                        <i class="fas fa-plus-circle me-1"></i> Tạo bài viết mới
                                    </button>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tab bài viết chờ duyệt -->
                        <div class="tab-pane fade" id="posts-pending" role="tabpanel" aria-labelledby="posts-pending-tab">
                            @if(isset($pendingPosts) && count($pendingPosts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Chuyên mục</th>
                                                <th>Ngày đăng</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingPosts as $post)
                                            <tr data-post-id="{{ $post->id }}">
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                                                </td>
                                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary edit-post-btn" data-post-id="{{ $post->id }}" title="Chỉnh sửa">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Bạn không có bài viết nào đang chờ duyệt.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tab bài viết đã duyệt -->
                        <div class="tab-pane fade" id="posts-approved" role="tabpanel" aria-labelledby="posts-approved-tab">
                            @if(isset($approvedPosts) && count($approvedPosts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Chuyên mục</th>
                                                <th>Ngày đăng</th>
                                                <th>Ngày duyệt</th>
                                                <th>Tương tác</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($approvedPosts as $post)
                                            <tr data-post-id="{{ $post->id }}">
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                                                </td>
                                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $post->approved_at ? $post->approved_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                                <td>
                                                    <i class="far fa-comment me-1"></i> {{ $post->comments_count ?? 0 }}
                                                    <i class="far fa-eye ms-2 me-1"></i> {{ $post->views_count ?? 0 }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Bạn chưa có bài viết nào được duyệt.
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tab bài viết bị từ chối -->
                        <div class="tab-pane fade" id="posts-rejected" role="tabpanel" aria-labelledby="posts-rejected-tab">
                            @if(isset($rejectedPosts) && count($rejectedPosts) > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Chuyên mục</th>
                                                <th>Ngày đăng</th>
                                                <th>Ngày từ chối</th>
                                                <th>Lý do từ chối</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rejectedPosts as $post)
                                            <tr data-post-id="{{ $post->id }}">
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                                                </td>
                                                <td>{{ $post->category->name ?? 'N/A' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $post->rejected_at ? $post->rejected_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info view-rejection-reason" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal" data-rejection="{{ $post->rejection_reason ?? 'Không có lý do được cung cấp.' }}" data-post-id="{{ $post->id }}">
                                                        Xem lý do
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary edit-post-btn" data-post-id="{{ $post->id }}" title="Chỉnh sửa">
                                                            <i class="far fa-edit"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Bạn không có bài viết nào bị từ chối.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xem lý do từ chối -->
<div class="modal fade" id="rejectionReasonModal" tabindex="-1" aria-labelledby="rejectionReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectionReasonModalLabel">Lý do từ chối bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <div id="rejectionReasonText">Không có lý do cụ thể</div>
                </div>
                <p class="text-muted mt-3">Bạn có thể chỉnh sửa bài viết theo gợi ý và gửi lại.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary edit-rejected-post">Chỉnh sửa bài viết</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal chỉnh sửa bài viết -->
<div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Chỉnh sửa bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPostForm" action="{{ route('forum.post.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="post_id" id="edit_post_id" value="">
                    
                    <div class="row mb-3">
                        <label for="edit_title" class="col-sm-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="edit_title" name="title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="edit_category_id" class="col-sm-2 col-form-label">Chuyên mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="edit_category_id" name="category_id" required>
                                <option value="">-- Chọn chuyên mục --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="edit_content" class="col-sm-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('content') is-invalid @enderror" id="edit_content" name="content" rows="8" required></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hỗ trợ định dạng Markdown</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="edit_images" class="col-sm-2 col-form-label">Hình ảnh</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="edit_images" name="images[]" multiple accept="image/*">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Có thể chọn nhiều hình ảnh (JPG, PNG, GIF - Tối đa 2MB/ảnh)</small>
                            
                            <div id="current_images" class="mt-3">
                                <h6>Hình ảnh hiện tại:</h6>
                                <div class="row" id="image_preview_container">
                                    <!-- JS sẽ hiển thị hình ảnh hiện tại ở đây -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="edit_tags" class="col-sm-2 col-form-label">Thẻ</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="edit_tags" name="tags" placeholder="Thêm thẻ (phân cách bằng dấu phẩy)">
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Ví dụ: toán cao cấp, kinh nghiệm học tập, tài liệu</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_anonymous" name="is_anonymous">
                                <label class="form-check-label" for="edit_is_anonymous">
                                    Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_notify_replies" name="notify_replies" checked>
                                <label class="form-check-label" for="edit_notify_replies">
                                    Thông báo cho tôi khi có bình luận mới
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-success" id="updatePost">Cập nhật bài viết</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript để xử lý chức năng -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý hiển thị lý do từ chối
    var currentPostId = null;
    
    document.querySelectorAll('.view-rejection-reason').forEach(function(button) {
        button.addEventListener('click', function() {
            var rejectionReason = this.getAttribute('data-rejection');
            currentPostId = this.getAttribute('data-post-id');
            
            document.getElementById('rejectionReasonText').textContent = rejectionReason;
        });
    });
    
    // Xử lý nút chỉnh sửa bài bị từ chối
    document.querySelector('.edit-rejected-post').addEventListener('click', function() {
        // Đóng modal hiện tại
        var currentModal = bootstrap.Modal.getInstance(document.getElementById('rejectionReasonModal'));
        currentModal.hide();
        
        // Hiển thị modal chỉnh sửa bài viết
        if (currentPostId) {
            openEditPostModal(currentPostId);
        }
    });
    
    // Xử lý tất cả các nút chỉnh sửa bài viết
    document.querySelectorAll('.edit-post-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var postId = this.getAttribute('data-post-id');
            openEditPostModal(postId);
        });
    });
    
    // Hàm mở modal chỉnh sửa và tải dữ liệu
    function openEditPostModal(postId) {
        if (!postId) return;
        
        // Thiết lập ID bài viết cần chỉnh sửa
        document.getElementById('edit_post_id').value = postId;
        
        // Mở modal chỉnh sửa
        var editModal = new bootstrap.Modal(document.getElementById('editPostModal'));
        
        // Tải dữ liệu bài viết bằng AJAX (giả lập)
        // Trong thực tế, bạn sẽ cần gọi API để lấy dữ liệu bài viết
        fetch(`/api/forum/posts/${postId}`)
            .then(response => response.json())
            .then(data => {
                // Điền dữ liệu vào form
                document.getElementById('edit_title').value = data.title;
                document.getElementById('edit_category_id').value = data.category_id;
                document.getElementById('edit_content').value = data.content;
                document.getElementById('edit_tags').value = data.tags;
                document.getElementById('edit_is_anonymous').checked = data.is_anonymous;
                document.getElementById('edit_notify_replies').checked = data.notify_replies;
                
                // Hiển thị hình ảnh hiện tại (nếu có)
                var imageContainer = document.getElementById('image_preview_container');
                imageContainer.innerHTML = '';
                
                if (data.images && data.images.length > 0) {
                    data.images.forEach(function(image, index) {
                        var col = document.createElement('div');
                        col.className = 'col-md-3 mb-2';
                        
                        var card = document.createElement('div');
                        card.className = 'card';
                        
                        var img = document.createElement('img');
                        img.className = 'card-img-top';
                        img.src = `/storage/${image}`;
                        img.alt = `Hình ảnh ${index + 1}`;
                        
                        var cardBody = document.createElement('div');
                        cardBody.className = 'card-body p-2';
                        
                        var removeBtn = document.createElement('button');
                        removeBtn.className = 'btn btn-sm btn-danger w-100';
                        removeBtn.textContent = 'Xóa';
                        removeBtn.setAttribute('data-image-id', index);
                        removeBtn.addEventListener('click', function() {
                            // Xử lý xóa hình ảnh
                            col.remove();
                        });
                        
                        cardBody.appendChild(removeBtn);
                        card.appendChild(img);
                        card.appendChild(cardBody);
                        col.appendChild(card);
                        imageContainer.appendChild(col);
                    });
                } else {
                    imageContainer.innerHTML = '<p class="text-muted">Không có hình ảnh</p>';
                }
                
                // Mở modal
                editModal.show();
            })
            .catch(error => {
                console.error('Error fetching post data:', error);
                // Trong trường hợp thực tế, mở modal với form trống
                editModal.show();
            });
    }
    
    // Xử lý cập nhật bài viết
    document.getElementById('updatePost').addEventListener('click', function() {
        var form = document.getElementById('editPostForm');
        if (form.checkValidity()) {
            form.submit();
        } else {
            form.reportValidity();
        }
    });
});
</script>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <!-- Left Column - Categories and Posts -->
        <div class="col-lg-8">
            <!-- Forum Categories -->
            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-graduation-cap category-icon"></i>
                        Học tập & Nghiên cứu
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">4 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Hỏi đáp về môn Toán cao cấp</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Nguyễn Văn A</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">24</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">142</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Chia sẻ đề tài nghiên cứu khoa học sinh viên năm 2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Trần Thị B</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 1 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">18</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">203</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Khó khăn khi học lập trình Java và cách khắc phục</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Lê Văn C</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 3 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">36</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">310</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-bullhorn category-icon"></i>
                        Thông báo & Sự kiện
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">2 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Thông báo lịch thi học kỳ II năm học 2024-2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user-tie me-1"></i> Phòng Đào tạo</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 3 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">12</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">578</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Hội thảo cơ hội việc làm cho sinh viên CNTT 2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user-tie me-1"></i> Khoa CNTT</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">8</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">425</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users category-icon"></i>
                        Đời sống sinh viên
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">5 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Phạm Thị D</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 5 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">45</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">389</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Top 10 quán ăn ngon bổ rẻ gần trường TLU</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Trần Văn E</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">67</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">520</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Posts -->
            <div class="latest-posts">
                <h4 class="section-title text-center">Bài viết mới nhất</h4>

                <div class="post-card">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                        <div>
                            <h6 class="post-author">Nguyễn Văn A</h6>
                            <span class="post-time">Đăng 2 giờ trước</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <h5 class="post-title">Cách giải bài tập Toán cao cấp phần đạo hàm</h5>
                        <p class="post-text">Chào các bạn, mình đang gặp khó khăn với bài tập đạo hàm hàm số nhiều biến trong môn Toán cao cấp. Mình đã thử giải theo phương pháp...</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="post-footer">
                        <div class="post-actions">
                            <a href="#"><i class="far fa-comment"></i> 8 bình luận</a>
                            <a href="#"><i class="far fa-heart"></i> 15 thích</a>
                            <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                        </div>
                        <div class="post-meta">
                            <span><i class="fas fa-folder me-1"></i> Học tập & Nghiên cứu</span>
                        </div>
                    </div>
                </div>

                <div class="post-card">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                        <div>
                            <h6 class="post-author">Phòng Đào tạo</h6>
                            <span class="post-time">Đăng 3 giờ trước</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <h5 class="post-title">Thông báo lịch thi học kỳ II năm học 2024-2025</h5>
                        <p class="post-text">Phòng Đào tạo thông báo lịch thi học kỳ II năm học 2024-2025 dành cho các khoa như sau: 1. Khoa Công nghệ thông tin: từ ngày 15/06 đến 30/06/2025...</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="post-footer">
                        <div class="post-actions">
                            <a href="#"><i class="far fa-comment"></i> 12 bình luận</a>
                            <a href="#"><i class="far fa-heart"></i> 34 thích</a>
                            <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                        </div>
                        <div class="post-meta">
                            <span><i class="fas fa-folder me-1"></i> Thông báo & Sự kiện</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav aria-label="Forum pagination">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <div class="forum-sidebar">
                <!-- Statistics Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-2"></i> Thống kê diễn đàn
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users"></i> Thành viên</span>
                            <span class="fw-bold">15,243</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-comments"></i> Chủ đề</span>
                            <span class="fw-bold">2,456</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-reply"></i> Bài viết</span>
                            <span class="fw-bold">18,789</span>
                        </div>

                    </div>
                </div>

                <!-- Active Topics Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-fire me-2"></i> Chủ đề nổi bật
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</span>
                                <span class="badge rounded-pill bg-primary">45</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Top 10 quán ăn ngon bổ rẻ gần trường TLU</span>
                                <span class="badge rounded-pill bg-primary">67</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Khó khăn khi học lập trình Java và cách khắc phục</span>
                                <span class="badge rounded-pill bg-primary">36</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Thông báo lịch thi học kỳ II năm học 2024-2025</span>
                                <span class="badge rounded-pill bg-primary">12</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Hỏi đáp về môn Toán cao cấp</span>
                                <span class="badge rounded-pill bg-primary">24</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Category Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-folder me-2"></i> Chuyên mục
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-graduation-cap me-2"></i> Học tập & Nghiên cứu</span>
                            <span class="badge rounded-pill bg-primary">324</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-bullhorn me-2"></i> Thông báo & Sự kiện</span>
                            <span class="badge rounded-pill bg-primary">156</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i> Đời sống sinh viên</span>
                            <span class="badge rounded-pill bg-primary">289</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-briefcase me-2"></i> Việc làm & Thực tập</span>
                            <span class="badge rounded-pill bg-primary">127</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-lightbulb me-2"></i> Ý tưởng & Sáng tạo</span>
                            <span class="badge rounded-pill bg-primary">98</span>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- New Topic Button -->
<a href="#" class="new-topic-btn">
    <i class="fas fa-plus"></i>
</a>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khi nhấn nút tạo bài viết mới
        document.querySelector('.new-topic-btn').addEventListener('click', function(e) {
            e.preventDefault();
            var createPostModal = new bootstrap.Modal(document.getElementById('createPostModal'));
            createPostModal.show();
        });
        
        // Xử lý khi nhấn nút đăng bài viết
        document.getElementById('submitPost').addEventListener('click', function() {
            // Kiểm tra form hợp lệ
            var form = document.getElementById('newPostForm');
            if (form.checkValidity()) {
                // Submit form
                form.submit();
            } else {
                // Kích hoạt validation của form
                form.reportValidity();
            }
        });
        
        // Debug form submit để xác định lỗi
        document.getElementById('newPostForm').addEventListener('submit', function(e) {
            console.log('Form đang được gửi...');
            // Nếu muốn chặn submit để debug:
            // e.preventDefault();
            // console.log(new FormData(this));
        });
    });
</script>

@endsection

