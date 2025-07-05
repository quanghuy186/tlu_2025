@extends('layouts/admin')

@section('title')
   Chỉnh sửa danh mục thông báo
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa danh mục thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notification-category.index') }}">Danh mục thông báo</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
</div>

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa danh mục thông báo</h5>
                        <span class="badge bg-info rounded-pill px-3">{{ $category->notifications->count() }} thông báo</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.notification-category.update', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-form-label">Tên danh mục <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" oninput="ChangeToSlug()" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="slug" class="col-md-2 col-form-label">Slug</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" readonly>
                                    <small class="text-muted">Slug tự động được tạo từ tên danh mục.</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-2 col-form-label">Mô tả</label>
                                <div class="col-md-10">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="icon" class="col-md-2 col-form-label">Icon</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <span class="input-group-text">bi bi-</span>
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $category->icon) }}">
                                    </div>
                                    <small class="text-muted">Nhập tên icon từ Bootstrap Icons. Ví dụ: "bell", "envelope", "info-circle"</small>
                                    <div class="mt-2" id="iconPreview"></div>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="display_order" class="col-md-2 col-form-label">Thứ tự hiển thị</label>
                                <div class="col-md-10">
                                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', $category->display_order) }}">
                                    <small class="text-muted">Số nhỏ hơn sẽ hiển thị trước.</small>
                                    @error('display_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
                                    <a href="{{ route('admin.notification-category.index') }}" class="btn btn-secondary">Hủy</a>
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