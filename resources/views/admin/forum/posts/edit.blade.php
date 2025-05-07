@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý bài viết diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.posts.index') }}">Bài viết diễn đàn</a></li>
        <li class="breadcrumb-item active">Thêm bài viết</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Thêm bài viết mới</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.forum.posts.store') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="category_id" class="col-sm-2 col-form-label">Danh mục <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                        <option value="">-- Chọn danh mục --</option>
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
                                <div class="col-sm-10 offset-sm-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_anonymous">
                                            Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Đăng bài viết
                                    </button>
                                    <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-secondary ms-2">
                                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                                    </a>
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

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize editor if you have a WYSIWYG editor
        // For example, if using CKEditor:
        // CKEDITOR.replace('content');
    });
</script>
@endsection