@extends('layouts/admin')

@section('title')
   Chỉnh sửa thông tin giảng viên
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa giảng viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.teacher.index') }}">Quản lý giảng viên</a></li>
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
                        <h5 class="card-title m-0 fw-bold text-primary">Sửa thông tin giảng viên</h5>
                        <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body my-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.teacher.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="p-3 border rounded bg-light mb-3">
                                        <h6 class="fw-bold text-primary mb-3"><i class="bi bi-person-badge me-2"></i>Thông tin tài khoản</h6>
                                        
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $teacher->user->name) }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Số điện thoại <span class="text-danger"></span></label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $teacher->user->phone) }}">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input readonly type="email" class="form-control" id="email" name="email" value="{{ old('email', $teacher->user->email) }}" required>
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
                                            @if($teacher->user->avatar)
                                                <img src="{{ asset('storage/avatars/'.$teacher->user->avatar) }}" 
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
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Thông tin giảng viên</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="teacher_code" class="form-label">Mã giảng viên</label>
                                        <input type="text" class="form-control" id="teacher_code" name="teacher_code" value="{{ old('teacher_code', $teacher->teacher_code) }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="department_id" class="form-label">Khoa/Bộ môn</label>
                                        <select class="form-select" id="department_id" name="department_id">
                                            <option value="">-- Chọn khoa/bộ môn --</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id', $teacher->department_id) == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_rank" class="form-label">Học hàm/Học vị</label>
                                        <select class="form-select" id="academic_rank" name="academic_rank">
                                            <option value="">-- Chọn học hàm/học vị --</option>
                                            <option value="Giáo sư" {{ old('academic_rank', $teacher->academic_rank) == 'Giáo sư' ? 'selected' : '' }}>Giáo sư</option>
                                            <option value="Phó giáo sư" {{ old('academic_rank', $teacher->academic_rank) == 'Phó giáo sư' ? 'selected' : '' }}>Phó giáo sư</option>
                                            <option value="Tiến sĩ" {{ old('academic_rank', $teacher->academic_rank) == 'Tiến sĩ' ? 'selected' : '' }}>Tiến sĩ</option>
                                            <option value="Thạc sĩ" {{ old('academic_rank', $teacher->academic_rank) == 'Thạc sĩ' ? 'selected' : '' }}>Thạc sĩ</option>
                                            <option value="Cử nhân" {{ old('academic_rank', $teacher->academic_rank) == 'Cử nhân' ? 'selected' : '' }}>Cử nhân</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="position" class="form-label">Chức vụ</label>
                                        <input type="text" class="form-control" id="position" name="position" value="{{ old('position', $teacher->position) }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-3 border rounded bg-light mb-4">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-briefcase me-2"></i>Thông tin chuyên môn</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="specialization" class="form-label">Chuyên ngành</label>
                                        <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization', $teacher->specialization) }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="office_location" class="form-label">Vị trí văn phòng</label>
                                        <input type="text" class="form-control" id="office_location" name="office_location" value="{{ old('office_location', $teacher->office_location) }}">
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="office_hours" class="form-label">Giờ làm việc/tiếp sinh viên</label>
                                        <textarea class="form-control" id="office_hours" name="office_hours" rows="3" placeholder="Ví dụ: Thứ 2, 4, 6: 9h-11h30; Thứ 3, 5: 14h-16h30">{{ old('office_hours', $teacher->office_hours) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Cập nhật thông tin
                                </button>
                                <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary ms-2">Hủy bỏ</a>
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