@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thêm danh mục thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notification-category.index') }}">Danh mục thông báo</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Thêm danh mục thông báo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.notification-category.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-2 col-form-label">Tên danh mục <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" oninput="ChangeToSlug()" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="slug" class="col-md-2 col-form-label">Slug</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" readonly>
                                    <small class="text-muted">Slug tự động được tạo từ tên danh mục.</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-md-2 col-form-label">Mô tả</label>
                                <div class="col-md-10">
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
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
                                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon') }}">
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
                                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" id="display_order" name="display_order" value="{{ old('display_order', 0) }}">
                                    <small class="text-muted">Số nhỏ hơn sẽ hiển thị trước. Mặc định là 0.</small>
                                    @error('display_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-primary">Lưu danh mục</button>
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