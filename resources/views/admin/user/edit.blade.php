@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa tài khoản</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Quản lý tài khoản</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa thông tin tài khoản</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly disabled>
                                    <small class="text-muted">Email không thể thay đổi</small>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-sm-3 col-form-label">Họ và tên <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="is_active" class="col-sm-3 col-form-label">Trạng thái tài khoản <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_1" value="1" {{ old('is_active', $user->is_active) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_1">Hoạt động</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="is_active_0" value="0" {{ old('is_active', $user->is_active) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active_0">Ngừng hoạt động</label>
                                    </div>
                                    @error('is_active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email_verified" class="col-sm-3 col-form-label">Trạng thái kích hoạt <span class="text-danger">*</span></label>
                                <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="email_verified" id="email_verified_1" value="1" {{ old('email_verified', $user->email_verified) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_verified_1">Đã kích hoạt</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="email_verified" id="email_verified_0" value="0" {{ old('email_verified', $user->email_verified) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_verified_0">Hủy kích hoạt</label>
                                    </div>
                                    @error('email_verified')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mt-4">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                                    </button>
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary ms-2">
                                        <i class="bi bi-x-circle me-1"></i> Hủy
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