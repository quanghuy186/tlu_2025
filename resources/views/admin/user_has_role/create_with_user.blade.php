@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Gán vai trò người dùng</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Quản lý tài khoản</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
  </div>

  <section class="section py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0 text-white">Gán vai trò cho người dùng</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.user_has_role.create') }}" method="POST">
                @csrf
                <div class="my-4">
                  <label for="userSelect" class="form-label fw-bold">Thông tin người dùng</label>
                    <h2>{{ $user->email }} - {{ $user->name }}</h2>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                </div>

                <div class="mt-4 mb-4">
                  <h6 class="fw-bold mb-3">Danh sách vai trò</h6>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        @foreach ($list_roles as $i => $role)
                            @if (in_array($role->id, $list_user_has_roles))
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                    <input class="form-check-input" name="role_id[]" type="checkbox" value="{{ $role->id }}" id="role_id_{{ $i }}" checked>
                                    <label class="form-check-label" for="role_id_{{ $i }}">
                                        {{ $role->description }}
                                    </label>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                    <input class="form-check-input" name="role_id[]" type="checkbox" value="{{ $role->id }}" id="role_id_{{ $i }}">
                                    <label class="form-check-label" for="role_id_{{ $i }}">
                                        {{ $role->description }}
                                    </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                      </div>
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


@endsection
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const specialRoles = [1, 2, 3]; // Hoặc {!! $specialRoles ?? '[1, 2, 3]' !!};
      
      const roleCheckboxes = document.querySelectorAll('input[name="role_id[]"]');
      
      roleCheckboxes.forEach(function(checkbox) {
          checkbox.addEventListener('change', function() {
              const roleId = parseInt(this.value);
              if (this.checked && specialRoles.includes(roleId)) {
                  hideOtherSpecialRoles(roleId);
              } else if (!this.checked && specialRoles.includes(roleId)) {
                  showAllSpecialRoles();
              }
          });
      });
      
      function hideOtherSpecialRoles(selectedRoleId) {
          roleCheckboxes.forEach(function(checkbox) {
              const roleId = parseInt(checkbox.value);
              const roleContainer = checkbox.closest('.col-md-6');
              
              if (specialRoles.includes(roleId) && roleId !== selectedRoleId) {
                  roleContainer.style.display = 'none';
                  checkbox.checked = false; // Bỏ chọn vai trò
              }
          });
      }
      
      function showAllSpecialRoles() {
          let anySpecialRoleSelected = false;
          
          roleCheckboxes.forEach(function(checkbox) {
              const roleId = parseInt(checkbox.value);
              if (checkbox.checked && specialRoles.includes(roleId)) {
                  anySpecialRoleSelected = true;
              }
          });
          
          if (!anySpecialRoleSelected) {
              roleCheckboxes.forEach(function(checkbox) {
                  const roleId = parseInt(checkbox.value);
                  const roleContainer = checkbox.closest('.col-md-6');
                  
                  if (specialRoles.includes(roleId)) {
                      roleContainer.style.display = '';
                  }
              });
          }
      }
      
      function checkInitialState() {
          let selectedSpecialRole = null;
          
          roleCheckboxes.forEach(function(checkbox) {
              const roleId = parseInt(checkbox.value);
              if (checkbox.checked && specialRoles.includes(roleId)) {
                  selectedSpecialRole = roleId;
              }
          });
          
          if (selectedSpecialRole) {
              hideOtherSpecialRoles(selectedSpecialRole);
          }
      }
      
      checkInitialState();
  });
</script>