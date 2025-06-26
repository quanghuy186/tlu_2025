@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thông tin lớp học</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Quản lý lớp học</a></li>
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
                        <h5 class="card-title m-0 fw-bold text-primary">Thông tin chi tiết lớp học</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.class.edit', $class->id) }}" class="btn btn-warning btn-sm text-white d-flex align-items-center">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.class.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body text-center p-4">
                                        <div class="d-inline-block bg-light rounded-circle p-3 mb-3">
                                            <i class="bi bi-mortarboard-fill text-primary fs-1"></i>
                                        </div>
                                        <h4 class="mb-2">{{ $class->class_name }}</h4>
                                        <p class="text-muted mb-2">Mã lớp: <span class="badge bg-light text-dark">{{ $class->class_code }}</span></p>
                                        <p class="text-muted mb-3">Năm học: <span class="badge bg-info text-white">{{ $class->academic_year }}</span></p>
                                        {{-- <p class="text-muted">Học kỳ: {{ $class->semester ?? 'Chưa xác định' }}</p> --}}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-person-badge me-2 text-primary"></i>Thông tin giảng viên phụ trách
                                            </h6>
                                            @if($class->teacherWithUser && $class->teacherWithUser->user)
                                                <div class="d-flex align-items-center">
                                                    @if($class->teacherWithUser->user->avatar)
                                                        <img src="{{ asset('storage/avatars/'.$class->teacherWithUser->user->avatar) }}"
                                                            alt="{{ $class->teacherWithUser->user->name }}"
                                                            class="rounded-circle me-3"
                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <span class="avatar bg-primary text-white rounded-circle me-3 d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            {{ strtoupper(substr($class->teacherWithUser->user->name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $class->teacherWithUser->user->name }}</h6>
                                                        <p class="text-muted mb-0">{{ $class->teacherWithUser->academic_rank ?? '' }}</p>
                                                        <p class="text-muted mb-0">
                                                            <small>Email: {{ $class->teacherWithUser->user->email }}</small>
                                                        </p>
                                                        <a href="{{ route('admin.teacher.show', $class->teacher_id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                            <i class="bi bi-eye-fill me-1"></i>Xem thông tin giảng viên
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="mb-0 text-muted">Chưa phân công giảng viên phụ trách</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-building me-2 text-primary"></i>Thông tin khoa/bộ môn
                                            </h6>
                                            @if($class->department)
                                                <p class="mb-1"><strong>Tên đơn vị:</strong> {{ $class->department->name }}</p>
                                                <p class="mb-1"><strong>Mã đơn vị:</strong> {{ $class->department->code ?? 'Chưa cập nhật' }}</p>
                                                @if($class->department->email || $class->department->phone)
                                                    <p class="mb-1">
                                                        <strong>Liên hệ:</strong> 
                                                        @if($class->department->email)
                                                            <span class="me-3"><i class="bi bi-envelope-fill text-primary me-1"></i> {{ $class->department->email }}</span>
                                                        @endif
                                                        @if($class->department->phone)
                                                            <span><i class="bi bi-telephone-fill text-primary me-1"></i> {{ $class->department->phone }}</span>
                                                        @endif
                                                    </p>
                                                @endif
                                                
                                                <a href="{{ route('admin.department.detail', $class->department_id) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="bi bi-eye-fill me-1"></i>Xem thông tin đơn vị
                                                </a>
                                            @else
                                                <p class="mb-0 text-muted">Chưa thuộc khoa/bộ môn nào</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-clock-history me-2 text-primary"></i>Thông tin hệ thống
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <p class="mb-0"><strong>Ngày tạo lớp:</strong> {{ $class->created_at->format('d/m/Y H:i:s') }}</p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p class="mb-0"><strong>Cập nhật lần cuối:</strong> {{ $class->updated_at->format('d/m/Y H:i:s') }}</p>
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