@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thông tin sinh viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.student.index') }}">Quản lý sinh viên</a></li>
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
                        <h5 class="card-title m-0 fw-bold text-primary">Thông tin chi tiết sinh viên</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-warning btn-sm text-white d-flex align-items-center">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.student.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="student-profile bg-light rounded p-3 h-100">
                                    @if($student->user->avatar)
                                        <img src="{{ asset('storage/avatars/'.$student->user->avatar) }}"
                                            alt="{{ $student->user->name }}"
                                            class="img-thumbnail rounded-circle mb-3"
                                            style="width: 180px; height: 180px; object-fit: cover;">
                                    @else
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 180px; height: 180px;">
                                            <span style="font-size: 5rem;">{{ strtoupper(substr($student->user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                    <h4 class="mb-1">{{ $student->user->name }}</h4>
                                    <p class="text-muted mb-2">{{ $student->student_code ?? 'Chưa có mã sinh viên' }}</p>
                                    
                                    @php
                                        $statusClass = 'bg-secondary';
                                        if($student->graduation_status == 'studying') $statusClass = 'bg-info';
                                        elseif($student->graduation_status == 'graduated') $statusClass = 'bg-success';
                                        elseif($student->graduation_status == 'suspended') $statusClass = 'bg-warning';
                                        elseif($student->graduation_status == 'dropped') $statusClass = 'bg-danger';
                                    @endphp
                                    
                                    <div class="mt-4 text-start">
                                        <p class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope-fill text-primary me-2"></i>
                                            {{ $student->user->email }}
                                        </p>
                                        
                                        @if($student->enrollment_year)
                                            <p class="d-flex align-items-center mb-2">
                                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                                Nhập học: {{ $student->enrollment_year }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-mortarboard-fill me-2 text-primary"></i>Thông tin lớp học
                                            </h6>
                                            @if($student->classWithDetails)
                                                <div class="mb-3">
                                                    <p class="mb-1"><strong>Lớp:</strong> {{ $student->classWithDetails->class_name }} ({{ $student->classWithDetails->class_code }})</p>
                                                    <p class="mb-1"><strong>Năm học:</strong> {{ $student->classWithDetails->academic_year }}</p>
                                                    <p class="mb-1"><strong>Học kỳ:</strong> {{ $student->classWithDetails->semester ?? 'Không xác định' }}</p>
                                                    
                                                    @if($student->classWithDetails->department)
                                                        <p class="mb-1"><strong>Khoa/Bộ môn:</strong> {{ $student->classWithDetails->department->name }}</p>
                                                    @endif
                                                </div>
                                                
                                                @if($student->classWithDetails->teacherWithUser && $student->classWithDetails->teacherWithUser->user)
                                                    <div class="mt-3 pt-3 border-top">
                                                        <h6 class="fw-bold mb-2">Giảng viên phụ trách:</h6>
                                                        <div class="d-flex align-items-center">
                                                            @if($student->classWithDetails->teacherWithUser->user->avatar)
                                                                <img src="{{ asset('storage/avatars/'.$student->classWithDetails->teacherWithUser->user->avatar) }}"
                                                                    alt="{{ $student->classWithDetails->teacherWithUser->user->name }}"
                                                                    class="rounded-circle me-2"
                                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                            @else
                                                                <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                    {{ strtoupper(substr($student->classWithDetails->teacherWithUser->user->name, 0, 1)) }}
                                                                </span>
                                                            @endif
                                                            <div>
                                                                <p class="mb-0 fw-bold">{{ $student->classWithDetails->teacherWithUser->user->name }}</p>
                                                                <p class="text-muted mb-0 small">{{ $student->classWithDetails->teacherWithUser->academic_rank ?? '' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <a href="{{ route('admin.class.show', $student->class_id) }}" class="btn btn-sm btn-outline-primary mt-3">
                                                    <i class="bi bi-eye-fill me-1"></i>Xem thông tin lớp học
                                                </a>
                                            @else
                                                <p class="mb-0 text-muted">Sinh viên chưa được phân lớp</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 mb-4">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-person-vcard me-2 text-primary"></i>Thông tin học tập
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Mã sinh viên</p>
                                                    <p>{{ $student->student_code ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <p class="mb-1 small text-muted fw-bold">Năm nhập học</p>
                                                    <p>{{ $student->enrollment_year ?? 'Chưa cập nhật' }}</p>
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="border rounded p-3">
                                            <h6 class="border-bottom pb-2 mb-3 fw-bold">
                                                <i class="bi bi-clock-history me-2 text-primary"></i>Thông tin hệ thống
                                            </h6>
                                            <div class="row">
                                                <div class="col-md-6 mb-2">
                                                    <p class="mb-0"><strong>Tài khoản tạo vào:</strong> {{ $student->created_at }}</p>
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <p class="mb-0"><strong>Cập nhật lần cuối:</strong> {{ $student->updated_at }}</p>
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