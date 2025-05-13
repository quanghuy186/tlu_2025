@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa bình luận</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý</li>
            <li class="breadcrumb-item"><a href="{{ route('admin.forum.comments.index') }}">Bình luận diễn đàn</a></li>
            <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa bình luận #{{ $comment->id }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.comments.show', $comment->id) }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
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
                        
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <!-- Thông tin bài viết và người bình luận -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0">Thông tin liên quan</h6>
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
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Ngày tạo:</th>
                                                        <td>{{ $comment->created_at->format('d/m/Y H:i:s') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Cập nhật:</th>
                                                        <td>{{ $comment->updated_at->format('d/m/Y H:i:s') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Form chỉnh sửa bình luận -->
                        <form action="{{ route('admin.forum.comments.update', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="m-0">Chỉnh sửa nội dung</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="content" class="form-label">Nội dung bình luận <span class="text-danger">*</span></label>
                                                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="5" required>{{ old('content', $comment->content) }}</textarea>
                                                @error('content')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="is_anonymous" id="is_anonymous" value="1" {{ old('is_anonymous', $comment->is_anonymous) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_anonymous">
                                                    Hiển thị bình luận dưới dạng ẩn danh
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <a href="{{ route('admin.forum.comments.show', $comment->id) }}" class="btn btn-secondary me-2">
                                        <i class="bi bi-x-circle me-1"></i> Hủy
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection