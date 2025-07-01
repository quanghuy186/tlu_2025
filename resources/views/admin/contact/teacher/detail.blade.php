@extends('layouts/admin')

@section('title')
   Xem chi tiết thông tin giảng viên
@endsection

@section('content')

<div class="pagetitle">
    <h1>Thông tin giảng viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.teacher.index') }}">Quản lý giảng viên</a></li>
        <li class="breadcrumb-item active">Thông tin chi tiết</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Thông tin chi tiết giảng viên</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.teacher.edit', $teacher->id) }}" class="btn btn-warning btn-sm text-white d-flex align-items-center">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="teacher-profile bg-light rounded p-3 h-100">
                                    @if($teacher->user->avatar)
                                        <img src="{{ asset('storage/avatars/'.$teacher->user->avatar) }}"
                                            alt="{{ $teacher->user->name }}"
                                            class="img-thumbnail rounded-circle mb-3"
                                            style="width: 180px; height: 180px; object-fit: cover;">
                                    @else
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 180px; height: 180px;">
                                            <span style="font-size: 5rem;">{{ strtoupper(substr($teacher->user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <h4 class="mb-1">{{ $teacher->user->name }}</h4>
                                    <p class="text-muted mb-2">
                                        {{ $teacher->academic_rank ?? '' }}
                                    </p>
                                    @if($teacher->teacher_code)
                                        <span class="badge bg-info text-white mb-3">Mã GV: {{ $teacher->teacher_code }}</span>
                                    @endif
                                    
                                    <div class="mt-4 text-start">
                                        <p class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                                            {{ $teacher->user->email }}
                                        </p>
                                        @if($teacher->department)
                                            <p class="d-flex align-items-center mb-2">
                                                <i class="bi bi-building text-primary me-2"></i>
                                                {{ $teacher->department->name }}
                                            </p>
                                        @endif
                                        @if($teacher->position)
                                            <p class="d-flex align-items-center mb-2">
                                                <i class="bi bi-person-badge text-primary me-2"></i>
                                                {{ $teacher->position }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold"><i class="bi bi-book me-2 text-primary"></i>Thông tin học thuật</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Chuyên ngành</p>
                                                    <p>{{ $teacher->specialization ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Học hàm/Học vị</p>
                                                    <p>{{ $teacher->academic_rank ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Thông tin liên hệ</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Vị trí văn phòng</p>
                                                    <p>{{ $teacher->office_location ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                                <div class="col-12">
                                                    <p class="mb-1 small text-muted fw-bold">Giờ làm việc/tiếp sinh viên</p>
                                                    <p>{{ $teacher->office_hours ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Thông tin hệ thống</h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Tài khoản tạo vào</p>
                                                    <p>{{ $teacher->created_at}}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Cập nhật lần cuối</p>
                                                    <p>{{ $teacher->updated_at }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection