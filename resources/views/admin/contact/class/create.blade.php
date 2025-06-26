@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thêm lớp học mới</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.class.index') }}">Quản lý lớp học</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Thêm lớp học mới</h5>
                        <a href="{{ route('admin.class.index') }}" class="btn btn-secondary btn-sm d-flex align-items-center">
                            <i class="bi bi-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    <div class="card-body mt-3">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.class.store') }}" method="POST">
                            @csrf
                            
                            <div class="p-3 border rounded bg-light mb-4">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle me-2"></i>Thông tin cơ bản</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="class_code" class="form-label">Mã lớp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="class_code" name="class_code" value="{{ old('class_code') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="class_name" class="form-label">Tên lớp <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="class_name" name="class_name" value="{{ old('class_name') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="department_id" class="form-label">Khoa/Bộ môn</label>
                                        <select class="form-select" id="department_id" name="department_id">
                                            <option value="">-- Chọn khoa/bộ môn --</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="teacher_id" class="form-label">Giảng viên phụ trách</label>
                                        <select class="form-select" id="teacher_id" name="teacher_id">
                                            <option value="">-- Chọn giảng viên --</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                    {{ $teacher->user->name }} - {{ $teacher->teacher_code ?? 'Chưa có mã GV' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-3 border rounded bg-light mb-4">
                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-calendar-event me-2"></i>Thông tin thời gian</h6>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="academic_year" class="form-label">Năm học <span class="text-danger">*</span></label>
                                        <select class="form-select" id="academic_year" name="academic_year" >
                                            <option value="">-- Chọn năm học --</option>
                                            @foreach($academicYears as $value => $label)
                                                <option value="{{ $value }}" {{ old('academic_year') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    {{-- <div class="col-md-6 mb-3">
                                        <label for="semester" class="form-label">Học kỳ</label>
                                        <select class="form-select" id="semester" name="semester">
                                            <option value="">-- Chọn học kỳ --</option>
                                            @foreach($semesters as $value => $label)
                                                <option value="{{ $value }}" {{ old('semester') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Tạo lớp học
                                </button>
                                <a href="{{ route('admin.class.index') }}" class="btn btn-secondary ms-2">Hủy bỏ</a>
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
        // Lắng nghe sự kiện thay đổi khoa/bộ môn để lọc danh sách giảng viên (nếu cần)
        const departmentSelect = document.getElementById('department_id');
        const teacherSelect = document.getElementById('teacher_id');
        
        if (departmentSelect && teacherSelect) {
            departmentSelect.addEventListener('change', function() {
                const departmentId = this.value;
                if (!departmentId) {
                    // Nếu không chọn khoa, hiển thị tất cả giảng viên
                    document.querySelectorAll('#teacher_id option').forEach(option => {
                        if (option.value !== '') {
                            option.style.display = 'block';
                        }
                    });
                    return;
                }
                
                // Logic để lọc giảng viên theo khoa (có thể triển khai sau bằng AJAX)
                // Hiện tại chỉ là ví dụ, cần xây dựng thêm hàm lấy giảng viên theo khoa
            });
        }
    });
</script>
@endsection