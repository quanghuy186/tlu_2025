@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa quyền truy cập</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item">Hệ thống</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.permission.index') }}">Quyền</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3">
            <h5 class="card-title m-0 fw-bold text-primary">Thông tin quyền truy cập</h5>
          </div>
          <div class="card-body mt-3">
            @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            <form action="{{ route('admin.permission.update', $permission->id) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="mb-3">
                <label for="permission_name" class="form-label">Tên quyền <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('permission_name') is-invalid @enderror" id="permission_name" name="permission_name" value="{{ old('permission_name', $permission->permission_name) }}" required>
                <small class="text-muted">Ví dụ: users.create, users.view, products.edit</small>
                @error('permission_name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $permission->description) }}</textarea>
                <small class="text-muted">Mô tả ngắn gọn về chức năng của quyền này</small>
                @error('description')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              
              <div class="d-flex mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-save me-1"></i> Cập nhật quyền
                </button>
                <a href="{{ route('admin.permission.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection