@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý bài viết diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.posts.index') }}">Bài viết diễn đàn</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa bài viết</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <!-- Status message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa bài viết</h5>
                        
                        <!-- Status badges -->
                        <div>
                            @if($post->status == 'published')
                                <span class="badge bg-success">Đã xuất bản</span>
                            @elseif($post->status == 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @elseif($post->status == 'rejected')
                                <span class="badge bg-danger">Đã từ chối</span>
                            @endif
                            
                            @if($post->is_anonymous)
                                <span class="badge bg-info ms-1">Ẩn danh</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.forum.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Store existing images data -->
                            <input type="hidden" id="existing_images" value="{{ $post->images }}">
                            
                            <!-- This will be updated by JavaScript -->
                            <input type="hidden" id="remove_images_json" name="remove_images_json" value="[]">
                            
                            <div id="forum-post-edit-container">
                                <!-- The React component will be rendered here -->
                                
                                <!-- Fallback non-JS form elements -->
                                <div class="row mb-3">
                                    <label for="title" class="col-sm-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
                                        @if($errors->has('title'))
                                            <div class="text-danger alert alert-danger small mt-2">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="category_id" class="col-sm-2 col-form-label">Danh mục</label>
                                    <div class="col-sm-10">
                                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('category_id'))
                                            <div class="text-danger alert alert-danger small mt-2">{{ $errors->first('category_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="content" class="col-sm-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8">{{ old('content', $post->content) }}</textarea>
                                        @if($errors->has('content'))
                                            <div class="text-danger alert alert-danger small mt-2">{{ $errors->first('content') }}</div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Existing Images (Non-JS version) -->
                                @if($post->images)
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Ảnh hiện tại</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                @php
                                                    $images = json_decode($post->images, true);
                                                @endphp
                                                
                                                @if(is_array($images))
                                                    @foreach($images as $index => $image)
                                                        <div class="col-md-3 mb-2">
                                                            <div class="card">
                                                                <img src="{{ asset('storage/' . $image) }}" class="card-img-top" alt="Ảnh {{ $index + 1 }}" style="height: 120px; object-fit: cover;">
                                                                <div class="card-body p-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="remove_images[]" value="{{ $index }}" id="remove_image_{{ $index }}">
                                                                        <label class="form-check-label" for="remove_image_{{ $index }}">
                                                                            Xóa ảnh này
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="row mb-3">
                                    <label for="images" class="col-sm-2 col-form-label">Thêm ảnh mới</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                                        @if($errors->has('images.*'))
                                            <div class="text-danger alert alert-danger small mt-2">{{ $errors->first('images.*') }}</div>
                                        @endif
                                        <small class="text-muted">Hỗ trợ: JPG, PNG, GIF. Tối đa 2MB mỗi ảnh.</small>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous', $post->is_anonymous) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_anonymous">
                                                Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($post->status == 'rejected' && $post->reject_reason)
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Lý do từ chối</label>
                                        <div class="col-sm-10">
                                            <div class="alert alert-danger">
                                                {{ $post->reject_reason }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="row mt-4">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-2"></i>Cập nhật bài viết
                                        </button>
                                        <a href="{{ route('admin.forum.posts.show', $post->id) }}" class="btn btn-secondary ms-2">
                                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                                        </a>
                                    </div>
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
