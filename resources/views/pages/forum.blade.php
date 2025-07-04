@extends('layouts.app')

@section('title')
    Danh sách bài viết diễn đàn
@endsection

@section('content')

<section class="forum-header">
    <div class="container text-center">
        <h1>Diễn đàn trao đổi TLU</h1>
        <p>Nơi trao đổi, chia sẻ kiến thức, thông tin và giải đáp thắc mắc trong cộng đồng Đại học Thủy Lợi</p>
    </div>
</section>

{{-- @include('partials.create_post_modal') --}}

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
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                            @if($errors->has('title'))
								<div class="text-danger alert alert-danger">{{ $errors->first('title') }}</div>
							@endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-2 col-form-label">Chuyên mục <span class="text-danger"></span></label>
                        <div class="col-sm-10">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
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
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                {{-- <button type="submit" class="btn btn-success" id="submitPost">Đăng bài viết</button> --}}
                <button type="button" class="btn btn-success" onclick="document.getElementById('newPostForm').submit()">Đăng bài viết</button>
            </div>
        </div>
    </div>
</div>

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

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-2"></i> Bài viết của tôi

                    <button type="button" class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#createPostModal">
                         <i class="fas fa-plus-circle me-1"></i> Tạo bài viết mới
                    </button>

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
                                                <td>{{ $post->category->name ?? 'Chưa phân loại' }}</td>
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
                                                        @if($post->status == 'approved')
                                                            <a href="{{ route('forum.post.show', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                                <i class="far fa-eye"></i>
                                                            </a>
                                                        @endif

                                                        @if($post->status != 'approved')
                                                            <button type="button" class="btn btn-sm btn-outline-secondary edit-post-btn" data-post-id="{{ $post->id }}" title="Chỉnh sửa">
                                                                <i class="far fa-edit"></i>
                                                            </button>
                                                        @endif

                                                        @if($post->status == 'rejected')
                                                            <button type="button" class="btn btn-sm btn-outline-info view-rejection-reason" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal" data-rejection="{{ $post->reject_reason ?? 'Không có lý do được cung cấp.' }}" data-post-id="{{ $post->id }}" title="Xem lý do từ chối">
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
                                                {{-- <th>Thao tác</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingPosts as $post)
                                            <tr data-post-id="{{ $post->id }}">
                                                <td>
                                                    <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="fw-semibold text-decoration-none">{{ $post->title }}</a>
                                                </td>
                                                <td>{{ $post->category->name ?? 'Chưa phân loại' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group">
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
                                                <td>{{ $post->category->name ?? 'Chưa phân loại' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $post->approved_at ? $post->approved_at->format('d/m/Y H:i') : 'Chưa phân loại' }}</td>
                                                <td>
                                                    <i class="far fa-comment me-1"></i> {{ $post->comments_count ?? 0 }}
                                                    <i class="far fa-eye ms-2 me-1"></i> {{ $post->view_count ?? 0 }}
                                                </td>
                                                <td>
                                                    {{-- <a href="{{ route('forum.index') }}?post={{ $post->id }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                        <i class="far fa-eye"></i>
                                                    </a> --}}

                                                    <a href="{{ route('forum.post.show', $post->id) }}" class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
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
                                                <td>{{ $post->category->name ?? 'Chưa phân loại' }}</td>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $post->rejected_at ? $post->rejected_at->format('d/m/Y H:i') : 'Chưa phân loại' }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info view-rejection-reason" data-bs-toggle="modal" data-bs-target="#rejectionReasonModal" data-rejection="{{ $post->reject_reason ?? 'Không có lý do được cung cấp.' }}" data-post-id="{{ $post->id }}">
                                                        Xem lý do
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                       
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
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="edit_title" name="title" value="">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="edit_category_id" class="col-sm-2 col-form-label">Chuyên mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="edit_category_id" name="category_id">
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
                            <textarea class="form-control @error('content') is-invalid @enderror" id="edit_content" name="content" rows="8"></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_is_anonymous" name="is_anonymous">
                                <label class="form-check-label" for="edit_is_anonymous">
                                    Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
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

<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('forum.index') }}" method="GET" id="searchFilterForm">
                        <div class="row align-items-end">
                            <div class="col-md-4 mb-3">
                                <label for="search" class="form-label">
                                    <i class="fas fa-search me-1"></i> Tìm kiếm
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="search" 
                                       name="search" 
                                       placeholder="Nhập từ khóa tìm kiếm..." 
                                       value="{{ request('search') }}">
                            </div>
                            
                            <!-- Category Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="category" class="form-label">
                                    <i class="fas fa-folder me-1"></i> Chuyên mục
                                </label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Tất cả chuyên mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @if($category->childCategories && $category->childCategories->count() > 0)
                                            @foreach($category->childCategories as $child)
                                                <option value="{{ $child->id }}" 
                                                        {{ request('category') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;└─ {{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Sort Filter -->
                            <div class="col-md-3 mb-3">
                                <label for="sort" class="form-label">
                                    <i class="fas fa-sort me-1"></i> Sắp xếp
                                </label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                        Mới nhất
                                    </option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                        Cũ nhất
                                    </option>
                                    <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>
                                        Xem nhiều nhất
                                    </option>
                                    <option value="most_commented" {{ request('sort') == 'most_commented' ? 'selected' : '' }}>
                                        Bình luận nhiều nhất
                                    </option>
                                </select>
                            </div>
                            
                            <!-- Items per page -->
                            <div class="col-md-2 mb-3">
                                <label for="per_page" class="form-label">
                                    <i class="fas fa-list-ol me-1"></i> Hiển thị
                                </label>
                                <select class="form-select" id="per_page" name="per_page">
                                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                                    <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <div>
                                    @if(request()->filled('search') || request()->filled('category') || request()->filled('sort'))
                                        <a href="{{ route('forum.index') }}" class="btn btn-link text-decoration-none">
                                            <i class="fas fa-times-circle me-1"></i> Xóa bộ lọc
                                        </a>
                                    @endif
                                    <span class="text-muted ms-3">
                                        Tìm thấy <strong>{{ $latestPosts->total() }}</strong> bài viết
                                    </span>
                                </div>
                                
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter me-1"></i> Áp dụng
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            @foreach($categories as $parentCategory)
                <div class="forum-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-folder category-icon"></i>
                            <a class="text-white" href="{{ route('forum.category', $parentCategory->slug) }}">{{ $parentCategory->name }}</a>
                        </div>
                        <span class="badge rounded-pill bg-light text-dark">
                            {{ $parentCategory->posts->where('created_at', '>', now()->subDays(7))->count() }} chủ đề mới
                        </span>
                    </div>
                    <div class="card-body p-0">
                        @if($parentCategory->posts->count() > 0)
                            @foreach($parentCategory->posts->take(3) as $post)
                                <div class="topic-item">
                                    <div class="topic-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="topic-content">
                                        <a href="{{ route('forum.post.show', $post->id) }}" class="topic-title">{{ $post->title }}</a>
                                        <div class="topic-info">

                                            @can('show-anonymously', $post)
                                                <span>
                                                    {{-- <i class="fas fa-user me-1"></i> {{ $post->author->name }} --}}
                                                    @if($post->author->managedDepartment)
                                                        {{ $post->author->managedDepartment->name }}
                                                    @else
                                                        {{ $$post->author->name }}
                                                    @endif
                                                </span>
                                            @else   
                                                <span><i class="fas fa-user me-1"></i> {{ $post->is_anonymous == 1 ? "Ẩn danh" : $post->author->name }} </span>
                                            @endcan

                                            {{-- <span class="ms-3"><i class="far fa-clock me-1"></i> {{ $post->created_at->diffForHumans() }}</span> --}}

                                            <span class="ms-3">
                                                <i class="far fa-clock me-1"></i> 
                                                {{ timeAgo($post->created_at) }}
                                            </span>

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
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 text-center text-muted">Chưa có bài viết nào trong chuyên mục này</div>
                        @endif
                    </div>
                    
                    @if($parentCategory->childCategories && $parentCategory->childCategories->count() > 0)
                        @foreach($parentCategory->childCategories as $childCategory)
                            <div class="card-header child-category d-flex justify-content-between align-items-center">
                                <div class="ps-4">
                                    <i class="fas fa-angle-right category-icon"></i>
                                    <a href="{{ route('forum.category', $childCategory->slug) }}">{{ $childCategory->name }}</a>
                                </div>
                                <span class="badge rounded-pill bg-light text-dark">
                                    {{ $childCategory->posts->where('created_at', '>', now()->subDays(7))->count() }} chủ đề mới
                                </span>
                            </div>
                            <div class="card-body p-0">
                                @if($childCategory->posts->count() > 0)
                                    @foreach($childCategory->posts->take(2) as $post)
                                        <div class="topic-item child-topic">
                                            <div class="topic-icon">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="topic-content">
                                                <a href="{{ route('forum.post', $post->id) }}" class="topic-title">{{ $post->title }}</a>
                                                <div class="topic-info">
                                                    <span><i class="fas fa-user me-1"></i> {{ $post->author->name }}</span>
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
                                        </div>
                                    @endforeach
                                @else
                                    <div class="p-3 text-center text-muted">Chưa có bài viết nào trong chuyên mục này</div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
            
            <div class="latest-posts">
                @foreach ($latestPosts as $p)
                    <div class="post-card">
                        <div class="post-header">
                            <div class="d-flex align-items-center flex-grow-1">
                                @if($p->author->avatar)
                                    <img src="{{ asset('storage/avatars/'.$p->author->avatar) }}"
                                        alt="{{ $p->author->name }}" style="border-radius: 50%"
                                        class="unit-logo">
                                @else
                                    <img src="{{ asset('user_default.jpg') }}"
                                        alt="" class="unit-logo" style="border-radius: 50%;">
                                @endif
                                <div class="ms-2">
                                    @can('show-anonymously', $p)
                                        <h6 class="post-author mb-0">{{ $p->author->name }}</h6>
                                    @else
                                        <h6 class="post-author mb-0">{{ $p->is_anonymous == 1 ? "Ẩn danh" : $p->author->name }}</h6>
                                    @endcan
                                    <span class="text-muted small">
                                        <i class="far fa-clock me-1"></i>
                                        {{ timeAgo($p->created_at) ?? 'Chưa xác định' }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($p->user_id == Auth::id())
                                <div class="dropdown">
                                    <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <button type="button" class="btn btn-sm edit-post-btn" data-post-id="{{ $p->id }}" title="Chỉnh sửa">
                                                    <i class="bi bi-pencil me-2"></i> Chỉnh sửa bài viết
                                                </button>
                                            </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('forum.post.delete') }}" class="delete-form mb-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id" value="{{ $p->id }}">
                                                <button type="submit" class="dropdown-item text-danger" 
                                                        onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                    <i class="bi bi-trash me-2"></i>Xóa bài viết
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        
                        <div class="post-body">
                            <h5 class="post-title">{{ $p->title }}</h5>
                            <p class="post-text">{{ $p->content }}</p>
                            <a href="{{ route('forum.post.show', $p->id) }}" class="btn btn-sm btn-outline-primary">
                                Đọc tiếp <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        
                        <div class="post-footer">
                            <div class="post-actions">
                                <a href="{{ route('forum.post.show', $p->id) }}" class="text-decoration-none text-muted me-3">
                                    <i class="far fa-comment"></i> {{ $p->comments_count }} bình luận
                                </a>
                                
                                <a href="#" class="like-button text-decoration-none me-3 {{ Auth::check() && $p->likedByUser(Auth::id()) ? 'liked' : '' }}" 
                                data-post-id="{{ $p->id }}">
                                    <i class="{{ Auth::check() && $p->likedByUser(Auth::id()) ? 'fas' : 'far' }} fa-heart"></i>
                                    <span class="like-count">{{ $p->likes_count }}</span> thích
                                </a>
                                
                                <a href="#" class="text-decoration-none text-muted">
                                    <i class="far fa-eye me-1"></i> {{ $p->view_count }}
                                </a>
                            </div>
                            <div class="post-meta">
                                <span class="badge bg-secondary">
                                    <i class="fas fa-folder me-1"></i>{{ $p->category->name ?? '' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($latestPosts->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        @if ($latestPosts->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $latestPosts->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        @foreach ($latestPosts->getUrlRange(1, $latestPosts->lastPage()) as $page => $url)
                            @if ($page == $latestPosts->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($latestPosts->hasMorePages())
                            <li><a href="{{ $latestPosts->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
                        @else
                            <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="forum-sidebar">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-2"></i> Thống kê diễn đàn
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users"></i> Thành viên</span>
                            <span class="fw-bold">{{ $totalUsers }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-comments"></i> Chủ đề</span>
                            <span class="fw-bold">{{ $totalCategories }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-reply"></i> Bài viết</span>
                            <span class="fw-bold">  {{ $totalPosts }} </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-fire me-2"></i> Bài viết nổi bật
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($mostLikedPosts as $post)
                            <a href="{{ route('forum.post.show', $post->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">{{ $post->title }}</span>
                                    <span class="badge rounded-pill bg-primary">{{ $post->likes_count }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="list-group-item">Chưa có bài viết nào.</div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-folder me-2"></i> Chuyên mục
                    </div>
                    <div class="list-group list-group-flush">
                        @forelse($categories as $parentCategory)
                            <a href="{{ route('forum.category', $parentCategory->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-folder me-2"></i> {{ $parentCategory->name }}
                                </span>
                                <span class="badge rounded-pill bg-primary">{{ $parentCategory->posts_count ?? $parentCategory->posts->count() }}</span>
                            </a>
                            
                            @if($parentCategory->childCategories && $parentCategory->childCategories->count() > 0)
                                @foreach($parentCategory->childCategories as $childCategory)
                                    <a href="{{ route('forum.category', $childCategory->slug) }}" class="list-group-item list-group-item-action d-flex ps-4 justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-angle-right me-2"></i> {{ $childCategory->name }}
                                        </span>
                                        <span class="badge rounded-pill bg-secondary">{{ $childCategory->posts_count ?? $childCategory->posts->count() }}</span>
                                    </a>
                                @endforeach
                            @endif
                        @empty
                            <div class="list-group-item">Chưa có chuyên mục nào.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="#" class="new-topic-btn" data-bs-toggle="modal" data-bs-target="#createPostModal">
    <i class="fas fa-plus"></i>
</a>

{{-- <script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Bạn có chắc muốn xóa bài viết này?')) {
                e.preventDefault();
            }
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var currentPostId = null;
        
        document.querySelectorAll('.view-rejection-reason').forEach(function(button) {
            button.addEventListener('click', function() {
                var rejectionReason = this.getAttribute('data-rejection');
                currentPostId = this.getAttribute('data-post-id');
                
                document.getElementById('rejectionReasonText').textContent = rejectionReason;
            });
        });
        
        document.querySelector('.edit-rejected-post').addEventListener('click', function() {
            var currentModal = bootstrap.Modal.getInstance(document.getElementById('rejectionReasonModal'));
            currentModal.hide();
            
            if (currentPostId) {
                openEditPostModal(currentPostId);
            }
        });
        
        document.querySelectorAll('.edit-post-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                var postId = this.getAttribute('data-post-id');
                openEditPostModal(postId);
            });
        });
        
        function openEditPostModal(postId) {
    if (!postId) return;
    document.getElementById('edit_post_id').value = postId;
    var editModal = new bootstrap.Modal(document.getElementById('editPostModal'));

    fetch(`/forum/api/posts/${postId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Cập nhật các trường trong form
            document.getElementById('edit_title').value = data.title;
            document.getElementById('edit_category_id').value = data.category_id;
            document.getElementById('edit_content').value = data.content;
            document.getElementById('edit_is_anonymous').checked = data.is_anonymous;

            // Xóa các dòng code gây lỗi ở đây
            // document.getElementById('edit_tags').value = data.tags; // Lỗi: Element không tồn tại
            // document.getElementById('edit_notify_replies').checked = data.notify_replies; // Lỗi: Element không tồn tại
            // document.getElementById('edit_images').checked = data.images; // Lỗi: Thao tác sai trên input file

            // Lấy container chứa ảnh preview
            var imageContainer = document.getElementById('image_preview_container');
            imageContainer.innerHTML = ''; // Xóa ảnh cũ trước khi thêm ảnh mới

            // Kiểm tra và hiển thị ảnh hiện tại của bài viết
            if (data.images && Array.isArray(data.images) && data.images.length > 0) {
                document.getElementById('current_images').style.display = 'block'; // Hiển thị khu vực ảnh
                data.images.forEach(function(image, index) {
                    // Tạo cột
                    var col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6 mb-2';

                    // Tạo card cho ảnh
                    var card = document.createElement('div');
                    card.className = 'card h-100 position-relative';

                    // Tạo ảnh
                    var img = document.createElement('img');
                    img.className = 'card-img-top';
                    img.src = `/storage/${image}`; // Đảm bảo đường dẫn storage của bạn là chính xác
                    img.alt = `Hình ảnh ${index + 1}`;
                    img.style.objectFit = 'cover';
                    img.style.height = '120px';

                    // Tạo nút xóa
                    var removeBtn = document.createElement('button');
                    removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                    removeBtn.type = 'button';
                    removeBtn.title = 'Xóa ảnh này';

                    removeBtn.onclick = function() {
                        // Tạo một input ẩn để gửi thông tin ảnh cần xóa lên server
                        var hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'removed_images[]';
                        hiddenInput.value = image;
                        document.getElementById('editPostForm').appendChild(hiddenInput);

                        // Xóa card ảnh khỏi giao diện
                        col.remove();
                    };
                    
                    // Gắn các element vào nhau
                    card.appendChild(img);
                    card.appendChild(removeBtn);
                    col.appendChild(card);
                    imageContainer.appendChild(col);
                });
            } else {
                // Nếu không có ảnh, ẩn khu vực hiển thị ảnh
                 document.getElementById('current_images').style.display = 'none';
                 imageContainer.innerHTML = '<p class="text-muted">Không có hình ảnh</p>';
            }

            // Hiển thị modal
            editModal.show();
        })
        .catch(error => {
            console.error('Lỗi khi lấy dữ liệu bài viết:', error);
            // Có thể hiển thị thông báo lỗi cho người dùng ở đây
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when changing filters (giữ lại cho dropdown)
    const filterElements = ['#category', '#sort', '#per_page'];
    
    filterElements.forEach(selector => {
        document.querySelector(selector).addEventListener('change', function() {
            document.getElementById('searchFilterForm').submit();
        });
    });
    
    // Chỉ search khi nhấn Enter trong ô tìm kiếm
    const searchInput = document.getElementById('search');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('searchFilterForm').submit();
            }
        });
    }
});
</script>

<script>
class ForumSearch {
    constructor() {
        this.searchInput = document.getElementById('search');
        this.categorySelect = document.getElementById('category');
        this.sortSelect = document.getElementById('sort');
        this.perPageSelect = document.getElementById('per_page');
        this.resultsContainer = document.querySelector('.latest-posts');
        this.searchTimer = null;
        this.isLoading = false;
        
        this.init();
    }
    
    init() {
        // Bind events
        // BỎ auto search khi nhập - chỉ search khi nhấn nút hoặc Enter
        if (this.searchInput) {
            this.searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.performSearch();
                }
            });
        }
        
        // Auto submit on filter change (giữ lại cho dropdown)
        [this.categorySelect, this.sortSelect, this.perPageSelect].forEach(element => {
            if (element) {
                element.addEventListener('change', () => this.performSearch());
            }
        });
        this.bindPaginationLinks();
        
        
        const searchForm = document.getElementById('searchFilterForm');
        if (searchForm) {
            const searchButton = searchForm.querySelector('button[type="submit"]');
            if (searchButton) {
                searchButton.addEventListener('click', (e) => {
                    e.preventDefault(); 
                    this.performSearch();
                });
            }
        }
    }
    
    async performSearch(page = 1) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        const formData = new FormData();
        
        // Collect all form data
        formData.append('q', this.searchInput ? this.searchInput.value : '');
        formData.append('category', this.categorySelect ? this.categorySelect.value : '');
        formData.append('sort', this.sortSelect ? this.sortSelect.value : 'latest');
        formData.append('per_page', this.perPageSelect ? this.perPageSelect.value : '10');
        formData.append('page', page);
        
        try {
            const response = await fetch('/forum/search?' + new URLSearchParams(formData), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            
            if (data.success) {
                this.updateResults(data.data, data.pagination);
                this.updateUrl(formData);
            }
        } catch (error) {
            console.error('Search error:', error);
            this.showErrorMessage('Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại.');
        } finally {
            this.isLoading = false;
            this.hideLoadingIndicator();
        }
    }
    
    updateResults(posts, pagination) {
        if (!this.resultsContainer) return;
        
        // Clear current results
        this.resultsContainer.innerHTML = '';
        
        if (posts.length === 0) {
            this.resultsContainer.innerHTML = `
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Không tìm thấy bài viết nào phù hợp với tiêu chí tìm kiếm.
                </div>
            `;
            return;
        }
        
        // Render posts
        posts.forEach(post => {
            this.resultsContainer.innerHTML += this.renderPost(post);
        });
        
        // Update pagination
        this.updatePagination(pagination);
        
        // Re-bind like buttons
        this.bindLikeButtons();
    }
    
    renderPost(post) {
        const timeAgo = this.getTimeAgo(post.created_at);
        const authorName = post.is_anonymous == 1 ? "Ẩn danh" : post.author.name;
        const avatarUrl = post.author.avatar 
            ? `/storage/avatars/${post.author.avatar}` 
            : '/user_default.jpg';
        
        return `
            <div class="post-card">
                <div class="post-header">
                    <img src="${avatarUrl}" alt="${authorName}" class="unit-logo" style="border-radius: 50%;">
                    <div>       
                        <h6 class="post-author">${authorName}</h6>
                        <span class="post-time">
                            <i class="far fa-clock me-1"></i> ${timeAgo}
                        </span>
                    </div>
                </div>
                <div class="post-body">
                    <h5 class="post-title">${this.escapeHtml(post.title)}</h5>
                    <p class="post-text">${this.escapeHtml(post.content.substring(0, 200))}...</p>
                    <a href="/forum/post/${post.id}" class="btn btn-sm btn-outline-primary">
                        Đọc tiếp <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="post-footer">
                    <div class="post-actions">
                        <a href="#"><i class="far fa-comment"></i> ${post.comments_count} bình luận</a>
                        <a href="#" class="like-button" data-post-id="${post.id}">
                            <i class="far fa-heart"></i> 
                            <span class="like-count">${post.likes_count || 0}</span> thích
                        </a>
                        <a href="#"><i class="far fa-eye ms-2 me-1"></i> ${post.view_count}</a>
                    </div>
                    <div class="post-meta">
                        <span><i class="fas fa-folder me-1"></i>${post.category.name || ''}</span>
                    </div>
                </div>
            </div>
        `;
    }
    
    updatePagination(pagination) {
        const paginationContainer = document.querySelector('.pagination-container');
        if (!paginationContainer) return;
        
        let paginationHtml = '<ul class="pagination">';
        
        // Previous button
        if (pagination.current_page > 1) {
            paginationHtml += `
                <li><a href="#" data-page="${pagination.current_page - 1}">
                    <i class="fas fa-angle-double-left"></i>
                </a></li>
            `;
        } else {
            paginationHtml += '<li><a href="#" class="disabled"><i class="fas fa-angle-double-left"></i></a></li>';
        }
        
        // Page numbers
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === pagination.current_page) {
                paginationHtml += `<li><a href="#" class="active">${i}</a></li>`;
            } else {
                paginationHtml += `<li><a href="#" data-page="${i}">${i}</a></li>`;
            }
        }
        
        // Next button
        if (pagination.has_more_pages) {
            paginationHtml += `
                <li><a href="#" data-page="${pagination.current_page + 1}">
                    <i class="fas fa-angle-double-right"></i>
                </a></li>
            `;
        } else {
            paginationHtml += '<li><a href="#" class="disabled"><i class="fas fa-angle-double-right"></i></a></li>';
        }
        
        paginationHtml += '</ul>';
        paginationContainer.innerHTML = paginationHtml;
        
        // Bind pagination clicks
        this.bindPaginationLinks();
    }
    
    bindPaginationLinks() {
        document.querySelectorAll('.pagination a[data-page]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = e.currentTarget.dataset.page;
                this.performSearch(page);
                
                this.resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    }
    
    bindLikeButtons() {
        document.querySelectorAll('.like-button').forEach(button => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const postId = e.currentTarget.dataset.postId;
                
                try {
                    const response = await fetch(`/forum/post/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        const likeCount = e.currentTarget.querySelector('.like-count');
                        const icon = e.currentTarget.querySelector('i');
                        
                        likeCount.textContent = data.likeCount;
                        
                        if (data.action === 'liked') {
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                            e.currentTarget.classList.add('liked');
                        } else {
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            e.currentTarget.classList.remove('liked');
                        }
                    }
                } catch (error) {
                    console.error('Like error:', error);
                }
            });
        });
    }
    
    showLoadingIndicator() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.classList.add('loading');
        }
        
        // Add loading overlay to results
        if (this.resultsContainer) {
            this.resultsContainer.style.opacity = '0.5';
        }
    }
    
    hideLoadingIndicator() {
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.classList.remove('loading');
        }
        
        if (this.resultsContainer) {
            this.resultsContainer.style.opacity = '1';
        }
    }
    
    showErrorMessage(message) {
        if (this.resultsContainer) {
            this.resultsContainer.innerHTML = `
                <div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    ${message}
                </div>
            `;
        }
    }
    
    updateUrl(formData) {
        const url = new URL(window.location);
        
        // Update URL parameters
        for (const [key, value] of formData.entries()) {
            if (value) {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        }
        
        // Update browser history without reload
        window.history.pushState({}, '', url);
    }
    
    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    
    getTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);
        
        const intervals = {
            năm: 31536000,
            tháng: 2592000,
            tuần: 604800,
            ngày: 86400,
            giờ: 3600,
            phút: 60
        };
        
        for (const [unit, secondsInUnit] of Object.entries(intervals)) {
            const interval = Math.floor(seconds / secondsInUnit);
            if (interval >= 1) {
                return `${interval} ${unit} trước`;
            }
        }
        
        return 'Vừa xong';
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ForumSearch();
});
</script>
@endsection

<style>
    .loading {
        background-image: url('data:image/svg+xml;charset=utf8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Ccircle cx="50" cy="50" r="20" fill="none" stroke="%230066cc" stroke-width="4"%3E%3Canimate attributeName="stroke-dasharray" values="0 126;126 126" dur="1.5s" repeatCount="indefinite"/%3E%3Canimate attributeName="stroke-dashoffset" values="0;-126" dur="1.5s" repeatCount="indefinite"/%3E%3C/circle%3E%3C/svg%3E');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 20px 20px;
    }

    .post-card {
        transition: all 0.3s ease;
    }

    .pagination a.disabled {
        pointer-events: none;
        opacity: 0.5;
    }

    .alert {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .card {
        border: none;
        border-radius: 10px;
        background: #ffffff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 0.25rem rgba(0, 102, 204, 0.25);
    }

    .btn-primary {
        background-color: #0066cc;
        border-color: #0066cc;
    }

    .btn-primary:hover {
        background-color: #0052a3;
        border-color: #0052a3;
    }
    .post-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        padding: 20px;
    }

    .post-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .unit-logo {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    .post-author {
        font-weight: 600;
        color: #333;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .btn-link:focus {
        box-shadow: none;
    }

    .post-body {
        margin-bottom: 15px;
    }

    .post-title {
        color: #333;
        margin-bottom: 10px;
    }

    .post-text {
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .post-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #eee;
        padding-top: 15px;
    }

    .post-actions a {
        color: #666;
        transition: color 0.3s;
    }

    .post-actions a:hover {
        color: #333;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item.text-danger:hover {
        background-color: #fee;
        color: #dc3545 !important;
    }
</style>