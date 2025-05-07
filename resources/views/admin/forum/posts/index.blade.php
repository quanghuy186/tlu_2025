@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý bài viết diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Bài viết diễn đàn</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách bài viết diễn đàn</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-folder me-2"></i>QL danh mục
                            </a>
                            <a href="{{ route('admin.forum.posts.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm bài viết
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <!-- Filters -->
                        <form action="{{ route('admin.forum.posts.index') }}" method="GET" class="mb-4 card p-3 bg-light">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Nhập tiêu đề..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="category_id" class="form-label">Danh mục</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- Tất cả danh mục --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">-- Tất cả trạng thái --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ duyệt</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bi bi-search me-1"></i> Lọc
                                    </button>
                                    <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Đặt lại
                                    </a>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">ID</th>
                                        <th width="25%">Tiêu đề</th>
                                        <th width="15%">Danh mục</th>
                                        <th width="15%">Tác giả</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="10%">Lượt xem</th>
                                        <th width="10%">Ngày tạo</th>
                                        <th class="text-center" width="10%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($posts as $post)
                                    <tr>
                                        <td><span class="badge bg-light text-dark">{{ $post->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($post->is_pinned)
                                                    <span class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-title="Đã ghim">
                                                        <i class="bi bi-pin-angle-fill"></i>
                                                    </span>
                                                @endif
                                                @if($post->is_locked)
                                                    <span class="badge bg-danger me-2" data-bs-toggle="tooltip" data-bs-title="Đã khóa">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </span>
                                                @endif
                                                <span>{{ Str::limit($post->title, 50) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($post->category)
                                                <span class="badge bg-info text-white">{{ $post->category->name }}</span>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($post->is_anonymous && !auth()->user()->hasRole('admin'))
                                                <span class="text-muted">Ẩn danh</span>
                                            @else
                                                {{ $post->author->name ?? 'Không xác định' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($post->status == 'pending')
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            @elseif($post->status == 'approved')
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @elseif($post->status == 'rejected')
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->view_count }}</td>
                                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- View Post -->
                                                <a href="{{ route('admin.forum.posts.show', $post->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Post (Only author or admin) -->
                                                @if(auth()->id() == $post->user_id || auth()->user()->hasRole('admin'))
                                                <a href="{{ route('admin.forum.posts.edit', $post->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                @endif
                                                
                                                <!-- Delete Post (Only author or admin) -->
                                                @if(auth()->id() == $post->user_id || auth()->user()->hasRole('admin'))
                                                <a href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteConfirmModal"
                                                    data-post-id="{{ $post->id }}"
                                                    data-post-title="{{ $post->title }}"
                                                    data-delete-url="{{ route('admin.forum.posts.destroy', $post->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Không có dữ liệu bài viết</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Xác nhận xóa bài viết -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa bài viết <strong id="deletePostTitle"></strong>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deletePostForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa bài viết</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        const deleteModal = document.getElementById('deleteConfirmModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const postId = button.getAttribute('data-post-id');
                const postTitle = button.getAttribute('data-post-title');
                const deleteUrl = button.getAttribute('data-delete-url');
                
                const postTitleElement = deleteModal.querySelector('#deletePostTitle');
                if (postTitleElement) {
                    postTitleElement.textContent = postTitle;
                }
                
                const deleteForm = deleteModal.querySelector('#deletePostForm');
                if (deleteForm) {
                    deleteForm.action = deleteUrl;
                }
            });
        }
    });
</script>
@endsection 