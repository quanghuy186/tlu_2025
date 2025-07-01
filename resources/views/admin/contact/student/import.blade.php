@extends('layouts/admin')

@section('title')
    Nhập danh sách sinh viên file excel
@endsection

@section('content')
<div class="pagetitle">
    <h1>Import sinh viên từ Excel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.student.index') }}">Sinh viên</a></li>
            <li class="breadcrumb-item active">Nhập từ file Excel</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Import Form Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Import danh sách sinh viên</h5>
                    
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
                            <li>Điền thông tin sinh viên vào file (các cột có dấu * là bắt buộc)</li>
                            <li>Upload file và chọn các tùy chọn mặc định (nếu cần)</li>
                            <li>Nhấn "Import" để thêm sinh viên vào hệ thống</li>
                        </ol>
                    </div>

                    <!-- Download Template -->
                    <div class="mb-4">
                        <a href="{{ route('admin.student.download-template') }}" class="btn btn-primary">
                            <i class="bi bi-download me-2"></i>Tải file Excel mẫu
                        </a>
                    </div>

                    <!-- Import Form -->
                    <form action="{{ route('admin.student.import') }}" method="POST" enctype="multipart/form-data">
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
                            <label class="col-sm-3 col-form-label">Lớp mặc định</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="default_class_id">
                                    <option value="">-- Không chọn --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text">Áp dụng cho sinh viên không có thông tin lớp trong file</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Năm nhập học mặc định</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="default_enrollment_year" 
                                       value="{{ date('Y') }}" min="1900" max="{{ date('Y') + 1 }}">
                                <div class="form-text">Áp dụng cho sinh viên không có năm nhập học trong file</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-success" id="importBtn">
                                    <i class="bi bi-upload me-2"></i>Nhập sinh viên
                                </button>
                                <a href="{{ route('admin.student.index') }}" class="btn btn-secondary ms-2">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- File Format Info -->
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
                                    <td>Mã sinh viên</td>
                                    <td><span class="badge bg-danger">Bắt buộc</span></td>
                                    <td>Mã sinh viên duy nhất</td>
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
                                    <td>Mã lớp</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Tên lớp phải tồn tại trong hệ thống</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>Năm nhập học</td>
                                    <td><span class="badge bg-secondary">Tùy chọn</span></td>
                                    <td>Năm (VD: 2024)</td>
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