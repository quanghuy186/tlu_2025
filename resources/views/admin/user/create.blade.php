@extends('layouts/admin')

@section('title')
   Thêm tài khoản người dùng
@endsection

@section('content')

<div class="pagetitle">
    <h1>Thêm tài khoản người dùng</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Người dùng</a></li>
        <li class="breadcrumb-item active">Thêm tài khoản người dùng</li>
      </ol>
    </nav>
  </div>

  <section class="section py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0 text-white">Thêm tài khoản</h5>
          </div>
          <div class="card-body mt-3">
            <form action="{{ route('admin.user.create') }}" method="POST">
              @csrf
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
              
              <div class="mb-4">
                <div class="mb-3">
                  <label class="form-label">Chọn vai trò <span class="text-danger">*</span></label>
                  <select id="role_id" class="form-select" name="role_id" required>
                        <option value="">Chọn vai trò</option>
                         @foreach ($list_roles as $r)
                            <option value="{{ $r->id }}" data-role-name="{{ $r->name ?? $r->description }}">{{ $r->description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="class_selection" style="display: none;">
                  <label class="form-label">Chọn lớp học <span class="text-danger"></span></label>
                  <select id="class_id" class="form-select" name="class_id">
                        <option value="">Chọn lớp học</option>
                         @foreach ($list_classes as $c)
                            <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="department_selection" style="display: none;">
                  <label class="form-label">Chọn đơn vị <span class="text-danger"></span></label>
                  <select id="department_id" class="form-select" name="department_id">
                        <option value="">Chọn đơn vị</option>
                         @foreach ($list_department as $d)
                            <option value="{{ $d->id }}">{{ $d->name }}</option>
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
  // Toggle password visibility
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
  
  // Password strength indicator
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

  // Show/hide class selection based on role
  document.getElementById('role_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const classSelection = document.getElementById('class_selection');
    const classSelect = document.getElementById('class_id');
    
    if (selectedOption && selectedOption.value) {
      // Lấy tên vai trò từ data attribute hoặc text
      const roleName = selectedOption.getAttribute('data-role-name') || selectedOption.text;
      
      // Kiểm tra xem có phải vai trò sinh viên không (có thể điều chỉnh điều kiện này)
      // Bạn có thể thay đổi điều kiện này tùy theo cách đặt tên vai trò trong database
      if (roleName.toLowerCase().includes('sinh viên') || 
          roleName.toLowerCase().includes('student') ||
          roleName.toLowerCase().includes('học sinh')) {
        classSelection.style.display = 'block';
        classSelect.setAttribute('required', 'required');
      } else {
        classSelection.style.display = 'none';
        classSelect.removeAttribute('required');
        classSelect.value = ''; // Reset giá trị
      }
    } else {
      classSelection.style.display = 'none';
      classSelect.removeAttribute('required');
      classSelect.value = ''; // Reset giá trị
    }
  });

  document.getElementById('role_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const classSelection = document.getElementById('class_selection');
    const classSelect = document.getElementById('class_id');
    const departmentSelection = document.getElementById('department_selection');
    const departmentSelect = document.getElementById('department_id');
    
    // Reset tất cả về trạng thái ẩn
    classSelection.style.display = 'none';
    classSelect.removeAttribute('required');
    classSelect.value = '';
    
    departmentSelection.style.display = 'none';
    departmentSelect.removeAttribute('required');
    departmentSelect.value = '';
    
    if (selectedOption && selectedOption.value) {
      // Lấy tên vai trò từ data attribute hoặc text
      const roleName = selectedOption.getAttribute('data-role-name') || selectedOption.text;
      const roleNameLower = roleName.toLowerCase();
      
      // Kiểm tra vai trò sinh viên
      if (roleNameLower.includes('sinh viên') || 
          roleNameLower.includes('student') ||
          roleNameLower.includes('học sinh')) {
        classSelection.style.display = 'block';
        classSelect.setAttribute('required', 'required');
      }
      // Kiểm tra vai trò giảng viên
      else if (roleNameLower.includes('giảng viên') || 
               roleNameLower.includes('teacher') ||
               roleNameLower.includes('lecturer') ||
               roleNameLower.includes('instructor')) {
        departmentSelection.style.display = 'block';
        departmentSelect.setAttribute('required', 'required');
      }
    }
  });

  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('role_id').dispatchEvent(new Event('change'));
  });
</script>

@endsection