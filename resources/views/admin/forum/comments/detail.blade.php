@extends('layouts/admin')

@section('title')
   Xem chi tiết bình luận
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chi tiết bình luận</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.forum.comments.index') }}">Bình luận diễn đàn</a></li>
            <li class="breadcrumb-item active">Chi tiết</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Thông tin bình luận #{{ $comment->id }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.comments.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                            <a href="{{ route('admin.forum.comments.edit', $comment->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="#" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteConfirmModal"
                                data-comment-id="{{ $comment->id }}"
                                data-delete-url="{{ route('admin.forum.comments.destroy', $comment->id) }}"
                                class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill me-1"></i> Xóa
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
                        
                        <!-- Thông tin chung -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0">Thông tin chi tiết</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th width="30%">ID:</th>
                                                        <td><span class="badge bg-light text-dark">{{ $comment->id }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bài viết:</th>
                                                        <td>
                                                            <a href="{{ route('admin.forum.posts.show', $comment->post_id) }}" class="text-decoration-none">
                                                                {{ $comment->post->title ?? 'Bài viết không tồn tại' }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Loại bình luận:</th>
                                                        <td>
                                                            @if($comment->parent_id)
                                                                <span class="badge bg-info">Phản hồi cho bình luận #{{ $comment->parent_id }}</span>
                                                                <a href="{{ route('admin.forum.comments.show', $comment->parent_id) }}" class="btn btn-sm btn-outline-info ms-2">
                                                                    <i class="bi bi-eye-fill"></i> Xem
                                                                </a>
                                                            @else
                                                                <span class="badge bg-primary">Bình luận gốc</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <th width="30%">Người bình luận:</th>
                                                        <td>
                                                            @if($comment->is_anonymous)
                                                                <span class="text-muted"><i class="bi bi-incognito"></i> Ẩn danh</span>
                                                            @else
                                                                {{ $comment->user->name ?? 'Không xác định' }}
                                                                @if($comment->user)
                                                                <a href="{{ route('admin.user.detail', $comment->user_id) }}" class="btn btn-sm btn-outline-primary ms-2">
                                                                    <i class="bi bi-person-fill"></i> Xem
                                                                </a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ẩn danh:</th>
                                                        <td>
                                                            @if($comment->is_anonymous)
                                                                <span class="badge bg-warning">Có</span>
                                                            @else
                                                                <span class="badge bg-success">Không</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Thời gian:</th>
                                                        <td>{{ $comment->created_at->format('d/m/Y H:i:s') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nội dung bình luận -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="m-0">Nội dung bình luận</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($comment->content)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Danh sách các phản hồi cho bình luận này (nếu là bình luận gốc) -->
                        @if(!$comment->parent_id)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0">Các phản hồi ({{ $replies->count() }})</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($replies->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="5%">ID</th>
                                                        <th width="35%">Nội dung</th>
                                                        <th width="15%">Người bình luận</th>
                                                        <th width="10%">Ẩn danh</th>
                                                        <th width="15%">Thời gian</th>
                                                        <th width="20%">Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($replies as $reply)
                                                    <tr>
                                                        <td><span class="badge bg-light text-dark">{{ $reply->id }}</span></td>
                                                        <td>{{ Str::limit($reply->content, 50) }}</td>
                                                        <td>
                                                            {{-- @if($reply->is_anonymous)
                                                                <span class="text-muted"><i class="bi bi-incognito"></i> Ẩn danh</span>
                                                            @else --}}
                                                                {{ $reply->user->name ?? 'Không xác định' }} @if($reply->is_anonymous) (Ẩn danh) @endif
                                                            {{-- @endif --}}
                                                        </td>
                                                        <td>
                                                            @if($reply->is_anonymous)
                                                                <span class="badge bg-warning">Có</span>
                                                            @else
                                                                <span class="badge bg-success">Không</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $reply->created_at->format('d/m/Y H:i') }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="{{ route('admin.forum.comments.show', $reply->id) }}" class="btn btn-sm btn-primary">
                                                                    <i class="bi bi-eye"></i>
                                                                </a>
                                                                <a href="{{ route('admin.forum.comments.edit', $reply->id) }}" class="btn btn-sm btn-warning">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </a>
                                                                <a href="#" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#deleteConfirmModal"
                                                                    data-comment-id="{{ $reply->id }}"
                                                                    data-delete-url="{{ route('admin.forum.comments.destroy', $reply->id) }}"
                                                                    class="btn btn-sm btn-danger">
                                                                    <i class="bi bi-trash-fill"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @else
                                        <p class="text-center text-muted py-3">Không có phản hồi nào cho bình luận này</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
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