@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý bình luận diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Bình luận diễn đàn</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách bình luận diễn đàn</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-sticky me-2"></i>QL bài viết
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
                        <form action="{{ route('admin.forum.comments.index') }}" method="GET" class="mb-4 card p-3 bg-light">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Nhập nội dung..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="post_id" class="form-label">Bài viết</label>
                                    <select name="post_id" id="post_id" class="form-select">
                                        <option value="">-- Tất cả bài viết --</option>
                                        @foreach($posts as $post)
                                            <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                                                {{ Str::limit($post->title, 40) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="parent_id" class="form-label">Loại bình luận</label>
                                    <select name="parent_id" id="parent_id" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        <option value="parent" {{ request('parent_id') == 'parent' ? 'selected' : '' }}>Bình luận gốc</option>
                                        <option value="reply" {{ request('parent_id') == 'reply' ? 'selected' : '' }}>Phản hồi</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="is_anonymous" class="form-label">Hiển thị</label>
                                    <select name="is_anonymous" id="is_anonymous" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        <option value="1" {{ request('is_anonymous') == '1' ? 'selected' : '' }}>Ẩn danh</option>
                                        <option value="0" {{ request('is_anonymous') == '0' ? 'selected' : '' }}>Công khai</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bi bi-search me-1"></i> Lọc
                                    </button>
                                    <a href="{{ route('admin.forum.comments.index') }}" class="btn btn-secondary">
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
                                        <th width="20%">Nội dung</th>
                                        <th width="20%">Bài viết</th>
                                        <th width="10%">Người bình luận</th>
                                        <th width="10%">Loại</th>
                                        <th width="10%">Ẩn danh</th>
                                        <th width="10%">Ngày tạo</th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($comments as $comment)
                                    <tr>
                                        <td><span class="badge bg-light text-dark">{{ $comment->id }}</span></td>
                                        <td>{{ Str::limit($comment->content, 50) }}</td>
                                        <td>
                                            <a href="{{ route('admin.forum.posts.show', $comment->post_id) }}" class="text-decoration-none">
                                                {{ Str::limit($comment->post->title ?? 'Bài viết không tồn tại', 40) }}
                                            </a>
                                        </td>
                                        <td>
                                            {{-- @if($comment->is_anonymous)
                                                <span class="text-muted"><i class="bi bi-incognito"></i> Ẩn danh</span>
                                            @else --}}
                                                {{ $comment->user->name ?? 'Không xác định' }} @if($comment->is_anonymous) (Ẩn danh) @endif
                                            
                                        </td>
                                        <td>
                                            @if($comment->parent_id)
                                                <span class="badge bg-info">Phản hồi</span>
                                            @else
                                                <span class="badge bg-primary">Gốc</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($comment->is_anonymous)
                                                <span class="badge bg-warning">Có</span>
                                            @else
                                                <span class="badge bg-success">Không</span>
                                            @endif
                                        </td>
                                        <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- View Original Comment (if this is a reply) -->
                                                @if($comment->parent_id)
                                                <a href="{{ route('admin.forum.comments.show', $comment->parent_id) }}" data-bs-toggle="tooltip" data-bs-title="Xem bình luận gốc" class="btn btn-sm btn-info">
                                                    <i class="bi bi-reply-fill"></i>
                                                </a>
                                                @endif
                                                
                                                <!-- View Comment Detail -->
                                                <a href="{{ route('admin.forum.comments.show', $comment->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <!-- Edit Comment (Only admin) -->
                                                <a href="{{ route('admin.forum.comments.edit', $comment->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                <!-- Delete Comment -->
                                                <a href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteConfirmModal"
                                                    data-comment-id="{{ $comment->id }}"
                                                    data-delete-url="{{ route('admin.forum.comments.destroy', $comment->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4">Không có dữ liệu bình luận</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $comments->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Xác nhận xóa bình luận -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa bình luận</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa bình luận này?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác. Nếu đây là bình luận gốc, tất cả các phản hồi cũng sẽ bị xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteCommentForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa bình luận</button>
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
                const commentId = button.getAttribute('data-comment-id');
                const deleteUrl = button.getAttribute('data-delete-url');
                
                const deleteForm = deleteModal.querySelector('#deleteCommentForm');
                if (deleteForm) {
                    deleteForm.action = deleteUrl;
                }
            });
        }
    });
</script>
@endsection