{{-- resources/views/admin/contact/teacher/import.blade.php --}}
@extends('layouts/admin')

@section('title')
   Nhập danh sách giảng viên từ excel
@endsection

@section('content')
<div class="pagetitle">
    <h1>Thêm giảng viên từ Excel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.teacher.index') }}">Giảng viên</a></li>
            <li class="breadcrumb-item active">Thêm từ Excel</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Import Form Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Thêm danh sách giảng viên</h5>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Instructions -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Hướng dẫn:</h6>
                        <ol class="mb-0">
                            <li>Tải file Excel mẫu</li>
                            <li>Điền thông tin giảng viên vào file (các cột có dấu * là bắt buộc)</li>
                            <li>Upload file và chọn khoa/bộ môn mặc định (nếu cần)</li>
                            <li>Nhấn "Import" để thêm giảng viên vào hệ thống</li>
                        </ol>
                    </div>

                    <!-- Download Template -->
                    <div class="mb-4">
                        <a href="{{ route('admin.teacher.download-template') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Tải file Excel mẫu
                        </a>
                    </div>

                    <!-- Import Form -->
                    <form action="{{ route('admin.teacher.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">File Excel <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                       name="file" accept=".xlsx,.xls" required>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Chấp nhận file .xlsx, .xls (tối đa 10MB)</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Khoa/Bộ môn mặc định</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="default_department_id">
                                    <option value="">-- Không chọn --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Áp dụng cho giảng viên không có thông tin khoa/bộ môn trong file</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-success" id="importBtn">
                                    <i class="bi bi-upload me-2"></i>Thêm giảng viên
                                </button>
                                <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Định dạng file Excel</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Cột</th>
                                    <th>Tên trường</th>
                                    <th>Bắt buộc</th>
                                    <th>Mô tả</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A</td>
                                    <td>Mã giảng viên</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Mã giảng viên duy nhất</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Họ và tên</td>
                                    <td><span class="badge bg-danger">Bắt buộc</span></td>
                                    <td>Họ và tên đầy đủ</td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td>Email</td>
                                    <td><span class="badge bg-danger">Bắt buộc</span></td>
                                    <td>Email duy nhất</td>
                                </tr>
                                <tr>
                                    <td>D</td>
                                    <td>Mật khẩu</td>
                                    <td><span class="badge bg-danger">Bắt buộc</span></td>
                                    <td>Tối thiểu 8 ký tự</td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>Số điện thoại</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Số điện thoại liên hệ</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>Mã khoa/bộ môn</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Mã khoa phải tồn tại trong hệ thống</td>
                                </tr>
                                <tr>
                                    <td>G</td>
                                    <td>Học hàm/Học vị</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>VD: Giáo sư, Tiến sĩ, Thạc sĩ...</td>
                                </tr>
                                <tr>
                                    <td>H</td>
                                    <td>Chuyên ngành</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Chuyên ngành giảng dạy</td>
                                </tr>
                                <tr>
                                    <td>I</td>
                                    <td>Chức vụ</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Chức vụ trong khoa/bộ môn</td>
                                </tr>
                                <tr>
                                    <td>J</td>
                                    <td>Phòng làm việc</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Địa chỉ phòng làm việc</td>
                                </tr>
                                <tr>
                                    <td>K</td>
                                    <td>Giờ làm việc</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Giờ làm việc/tiếp sinh viên</td>
                                </tr>
                            </tbody>
                        </table>
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
    const form = document.querySelector('form');
    const importBtn = document.getElementById('importBtn');
    
    form.addEventListener('submit', function() {
        importBtn.disabled = true;
        importBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang xử lý...';
    });
});
</script>
@endsection