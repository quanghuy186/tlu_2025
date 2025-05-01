@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa sinh viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.student.index') }}">Quản lý sinh viên</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa thông tin sinh viên</h5>
                        <a href="{{ route('admin.student.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
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

                        <form action="{{ route('admin.student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="p-3 border rounded bg-light mb-3">
                                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person me-2"></i>Thông tin tài khoản</h6>
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $student->user->name) }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $student->user->email) }}" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Mật khẩu <small class="text-muted">(để trống nếu không thay đổi)</small></label>
                                            <input type="password" class="form-control" id="password" name="password">
                                            <div class="form-text">Mật khẩu phải có ít nhất 8 ký tự</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="p-3 border rounded bg-light h-100">
                                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-image me-2"></i>Ảnh đại diện</h6>
                                        
                                        <div class="mb-3">
                                            <input type="file" class="form-control" id="avatar" name="avatar">
                                            <div class="form-text">Định dạng: JPEG, PNG, JPG, GIF (Tối đa: 2MB)</div>
                                        </div>
                                        
                                        <div class="text-center mt-3" id="avatar-preview">
                                            @if($student->user->avatar)
                                                <img src="{{ asset('storage/avatars/'.$student->user->avatar) }}" 
                                                    class="img-thumbnail rounded" 
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            @else
                                                <div class="avatar-placeholder bg-white border d-flex align-items-center justify-content-center rounded" style="width: 150px; height: 150px; margin: 0 auto;">
                                                    <i class="bi bi-person-fill fs-1 text-secondary"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-3 border rounded bg-light mb-4">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-mortarboard me-2"></i>Thông tin học tập</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="student_code" class="form-label">Mã sinh viên</label>
                                        <input type="text" class="form-control" id="student_code" name="student_code" value="{{ old('student_code', $student->student_code) }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="class_id" class="form-label">Lớp học</label>
                                        <select class="form-select" id="class_id" name="class_id">
                                            <option value="">-- Chọn lớp học --</option>
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->class_name }} - {{ $class->class_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="enrollment_year" class="form-label">Năm nhập học</label>
                                        <select class="form-select" id="enrollment_year" name="enrollment_year">
                                            <option value="">-- Chọn năm nhập học --</option>
                                            @foreach($enrollmentYears as $year)
                                                <option value="{{ $year }}" {{ old('enrollment_year', $student->enrollment_year) == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="program" class="form-label">Chương trình học</label>
                                        <select class="form-select" id="program" name="program">
                                            <option value="">-- Chọn chương trình --</option>
                                            @foreach($programs as $key => $value)
                                                <option value="{{ $key }}" {{ old('program', $student->program) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="graduation_status" class="form-label">Trạng thái học tập</label>
                                        <select class="form-select" id="graduation_status" name="graduation_status">
                                            <option value="">-- Chọn trạng thái --</option>
                                            @foreach($graduationStatuses as $key => $value)
                                                <option value="{{ $key }}" {{ old('graduation_status', $student->graduation_status) == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Cập nhật thông tin
                                </button>
                                <a href="{{ route('admin.student.index') }}" class="btn btn-secondary ms-2">Hủy bỏ</a>
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
        // Preview ảnh khi upload
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewDiv = document.getElementById('avatar-preview');
                    previewDiv.innerHTML = `<img src="${event.target.result}" class="img-thumbnail rounded" style="width: 150px; height: 150px; object-fit: cover;">`;
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection