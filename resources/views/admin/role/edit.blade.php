@extends('layouts/admin')

@section('title')
   Chỉnh sửa vai trò
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa vai trò</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item">Hệ thống</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.role.index') }}">Vai trò</a></li>
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
            <h5 class="card-title m-0 fw-bold text-primary">Thông tin vai trò</h5>
          </div>
          <div class="card-body">
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

            <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="mb-3">
                <label for="role_name" class="form-label">Tên vai trò <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" value="{{ old('role_name', $role->role_name) }}" required>
                @error('role_name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $role->description) }}</textarea>
                @error('description')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <!-- Phần quyền có thể thêm ở đây nếu cần -->
              
              <div class="d-flex mt-4">
                <button type="submit" class="btn btn-primary me-2">
                  <i class="bi bi-save me-1"></i> Cập nhật vai trò
                </button>
                <a href="{{ route('admin.role.index') }}" class="btn btn-secondary">
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