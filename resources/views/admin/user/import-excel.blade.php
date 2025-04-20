@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Nhập tài khoản từ Excel</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Quản lý tài khoản</a></li>
        <li class="breadcrumb-item active">Nhập từ Excel</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3">
            <h5 class="card-title m-0 fw-bold text-primary">Nhập danh sách tài khoản từ file Excel</h5>
          </div>
          <div class="card-body">
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle me-1"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle me-1"></i>
              {{ session('error') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="bi bi-exclamation-triangle me-1"></i>
              <strong>Có lỗi xảy ra!</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="alert alert-info" role="alert">
              <i class="bi bi-info-circle me-1"></i>
              <strong>Hướng dẫn:</strong>
              <ul class="mb-0 mt-2">
                <li>Tải file mẫu Excel để xem định dạng yêu cầu</li>
                <li>Điền thông tin người dùng theo mẫu: Họ tên, email, mật khẩu</li>
                <li>Các cột trạng thái kích hoạt và trạng thái tài khoản là tùy chọn (mặc định là 1)</li>
                <li>Upload file Excel đã điền thông tin</li>
                <li>Tất cả tài khoản sẽ được tạo ngay lập tức mà không cần xác nhận qua email</li>
              </ul>
            </div>
            
            <form action="{{ route('admin.user.download-excel-template') }}" method="GET" class="mb-4">
              <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-download me-1"></i> Tải file mẫu Excel
              </button>
            </form>
            
            <form action="{{ route('admin.user.process-import-excel') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="excel_file" class="form-label">Chọn file Excel (.xlsx, .xls)</label>
                <input class="form-control" type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls" required>
                <div class="form-text">Chỉ chấp nhận file Excel có định dạng .xlsx hoặc .xls</div>
              </div>
              
              <div class="alert alert-success mb-3">
                <i class="bi bi-info-circle me-1"></i>
                Tất cả tài khoản sẽ được kích hoạt tự động và ở trạng thái hoạt động.
              </div>
              
              <div class="d-grid gap-2 d-md-flex">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-upload me-1"></i> Nhập dữ liệu
                </button>
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
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