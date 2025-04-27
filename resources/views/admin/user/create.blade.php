@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thêm tài khoản người dùng</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Thêm tài khoản</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.user.create') }}" method="POST">
              @csrf
              <!-- User Information Section -->
              <div class="mb-4">
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="fullname" class="form-label">Họ và tên <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person"></i></span>
                      <input type="text" class="form-control" id="fullname" name="fullname" required>
                    </div>
                    <div class="form-text">Nhập họ tên đầy đủ</div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                      <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Account Information Section -->
              <div class="mb-4">
                <h6 class="fw-bold pb-2 border-bottom mb-3">Thông tin tài khoản</h6>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-lock"></i></span>
                      <input type="password" class="form-control" id="password" name="password" required>
                      <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i>
                      </button>
                    </div>
                    <div class="progress mt-2" style="height: 5px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 0%" id="passwordStrength"></div>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Role Information Section -->
              <div class="mb-4">
                {{-- <h6 class="fw-bold pb-2 border-bottom mb-3">Lớp học</h6> --}}
                <div class="mb-3">
                  <label class="form-label">Chọn lớp học <span class="text-danger"></span></label>
                  <select id="role_id" class="form-select" name="role_id" required>
                        <option value="1">Chọn lớp học</option>
                         @foreach ($list_classes as $c)
                            <option name="role_id" value="{{ $c->id }}">{{ $c->class_name }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- <h6 class="fw-bold pb-2 border-bottom mb-3">Phân quyền</h6> --}}
                <div class="mb-3">
                  <label class="form-label">Chọn vai trò <span class="text-danger">*</span></label>
                  <select id="role_id" class="form-select" name="role_id" required>
                        <option value="1">Chọn vai trò</option>
                         @foreach ($list_roles as $r)
                            <option name="role_id" value="{{ $r->id }}">{{ $r->description }}</option>
                        @endforeach
                    </select>
                </div>


                
                <div class="mb-3">
                  <label class="form-label d-block">Trạng thái tài khoản</label>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                    <label class="form-check-label" for="active">
                      <span class="badge bg-success">Kích hoạt</span>
                    </label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="status" id="inactive" value="inactive">
                    <label class="form-check-label" for="inactive">
                      <span class="badge bg-secondary">Không kích hoạt</span>
                    </label>
                  </div>
                </div>
              </div>
              
              <!-- Terms and Conditions -->

              <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle me-1"></i> Lưu lại
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    } else {
      passwordInput.type = 'password';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    }
  });
  
  document.getElementById('password').addEventListener('input', function() {
    const strength = this.value.length;
    const progressBar = document.getElementById('passwordStrength');
    
    if (strength === 0) {
      progressBar.style.width = '0%';
      progressBar.className = 'progress-bar bg-danger';
    } else if (strength < 6) {
      progressBar.style.width = '25%';
      progressBar.className = 'progress-bar bg-danger';
    } else if (strength < 10) {
      progressBar.style.width = '50%';
      progressBar.className = 'progress-bar bg-warning';
    } else if (strength < 14) {
      progressBar.style.width = '75%';
      progressBar.className = 'progress-bar bg-info';
    } else {
      progressBar.style.width = '100%';
      progressBar.className = 'progress-bar bg-success';
    }
  });
</script>

@endsection
