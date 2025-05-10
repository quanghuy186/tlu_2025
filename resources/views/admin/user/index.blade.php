@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý tài khoản</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold text-primary">Danh sách tài khoản</h5>
            <div class="d-flex gap-2">
              {{-- <a href="{{ route('admin.user.department') }}" class="btn btn-warning btn-sm d-flex align-items-center">
                Quản lý tài khoản đơn vị
              </a> --}}
              {{-- <a href="{{ route('admin.user.department') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Quản lý tài khoản đơn vị
              </a> --}}
              <a href="{{ route('admin.user.import-excel') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="bi bi-file-earmark-excel me-2"></i>Nhập từ Excel
              </a>
              <a href="{{ route('admin.user.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Thêm tài khoản
              </a>
            </div>
          </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <!-- <th class="text-center" width="5%">ID</th> -->
                      <th>Họ và tên</th>
                      <th>Email</th>
                      <th class="text-center">Trạng thái kích hoạt</th>
                      <th class="text-center">Trạng thái tài khoản</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <!-- <td class="text-center fw-bold">{{ $user->id }}</td> -->
                      <td>{{ $user->name }}</td>
                      <td><span class="text-muted">{{ $user->email }}</span></td>
                      <td class="text-center">
                        @if ($user->email_verified == 1)
                        <span class="badge bg-success rounded-pill px-3">Đã kích hoạt</span>
                        @elseif ($user->email_verified == 0)
                        <span class="badge bg-danger rounded-pill px-3">Chưa kích hoạt</span>
                        @endif
                      </td>
                      <td class="text-center">
                        @if ($user->is_active == 1)
                        <span class="badge bg-success rounded-pill px-3">Hoạt động</span>
                        @elseif ($user->is_active == 0)
                        <span class="badge bg-danger rounded-pill px-3">Ngừng hoạt động</span>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <!-- 1. Edit User - Keep as is with pencil icon -->
                          <a href="{{ route('admin.user.edit', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <!-- 2. Assign Roles - Using person-gear icon -->
                          <a href="{{ route('admin.user_has_role.create_with_user', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Phân vai trò" class="btn btn-sm btn-info">
                            <i class="bi bi-person-gear"></i>
                          </a>

                          <!-- 3. Assign Permissions - Using key icon -->
                          <a href="{{ route('admin.user_has_permission.create_with_user', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Phân quyền" class="btn btn-sm btn-warning">
                            <i class="bi bi-key"></i>
                          </a>

                          <!-- 4. View User Info - Using eye icon -->
                          <!-- <a href="{{ route('admin.user_has_role.create_with_user', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                          </a> -->

                          <a href="{{ route('admin.user.detail', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                          </a>

                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}"
                            data-delete-url="{{ route('admin.user.destroy', $user->id) }}"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>

                          <!-- <a href="#" data-bs-toggle="tooltip" data-bs-title="Xóa" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a> -->
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white py-3">
              <!-- Có thể thêm phân trang ở đây -->
              @if ($users->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        {{-- Liên kết trang trước --}}
                        @if ($users->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $users->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        {{-- Các phần tử phân trang --}}
                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if ($page == $users->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Liên kết trang tiếp theo --}}
                        @if ($users->hasMorePages())
                            <li><a href="{{ $users->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
                        @else
                            <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                        @endif
                    </ul>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Xác nhận xóa tài khoản -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa tài khoản</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa tài khoản <strong id="deleteUserName"></strong>?</p>
          <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteUserForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa tài khoản</button>
          </form>
        </div>
      </div>
    </div>
  </div>  

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
      
      const deleteModal = document.getElementById('deleteConfirmModal');
      if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const userId = button.getAttribute('data-user-id');
          const userName = button.getAttribute('data-user-name');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const userNameElement = deleteModal.querySelector('#deleteUserName');
          if (userNameElement) {
            userNameElement.textContent = userName;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteUserForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
    });
  </script>

  <!-- Thêm script để kích hoạt tooltip -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>


@endsection
