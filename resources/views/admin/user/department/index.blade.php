@extends('layouts/admin')

@section('content')

@dd($users)

<div class="pagetitle">
    <h1>Quản lý tài khoản đơn vị</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Đơn vị</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold text-primary">Danh sách đơn vị</h5>
            <div class="d-flex gap-2">
              {{-- <a href="{{ route('admin.user.create') }}" class="btn btn-warning btn-sm d-flex align-items-center">
                Quản lý tài khoản người dùng
              </a> --}}
              <a href="{{ route('admin.user.index') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-person-circle me-2"></i>QL tài khoản
              </a>
              <a href="{{ route('admin.user.department.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Thêm tài khoản cho đơn vị
              </a>
            </div>
          </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <!-- <th class="text-center" width="5%">ID</th> -->
                      <th>Tên đơn vị</th>
                      <th>Mã đơn vị</th>
                      <th>Trưởng đơn vị</th>
                      <th class="text-center">Trạng thái</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    {{-- @foreach ($departments as $department)
                    <tr>
                      <!-- <td class="text-center fw-bold">{{ $department->id }}</td> -->
                      <td>{{ $department->name }}</td>
                      <td><span class="text-muted">{{ $department->code }}</span></td>
                      <td>{{ $department->manager_name ?? 'Chưa phân công' }}</td>
                      <td class="text-center">
                        @if ($department->is_active == 1)
                        <span class="badge bg-success rounded-pill px-3">Hoạt động</span>
                        @elseif ($department->is_active == 0)
                        <span class="badge bg-danger rounded-pill px-3">Ngừng hoạt động</span>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <!-- 1. Edit Department -->
                          <a href="{{ route('admin.department.edit', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <!-- 2. Manage Department Users -->
                          <a href="{{ route('admin.department.users', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Quản lý thành viên" class="btn btn-sm btn-info">
                            <i class="bi bi-people"></i>
                          </a>

                          <!-- 3. Assign Department Permissions -->
                          <a href="{{ route('admin.department.permissions', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Phân quyền" class="btn btn-sm btn-warning">
                            <i class="bi bi-shield-lock"></i>
                          </a>

                          <!-- 4. View Department Info -->
                          <a href="{{ route('admin.department.detail', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                          </a>

                          <!-- 5. Delete Department -->
                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-department-id="{{ $department->id }}"
                            data-department-name="{{ $department->name }}"
                            data-delete-url="{{ route('admin.department.destroy', $department->id) }}"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @endforeach --}}
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white py-3">
              <!-- Phân trang -->
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Sau</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Xác nhận xóa đơn vị -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa đơn vị</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa đơn vị <strong id="deleteDepartmentName"></strong>?</p>
          <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác và có thể ảnh hưởng đến các tài khoản thuộc đơn vị này.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteDepartmentForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa đơn vị</button>
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
          const departmentId = button.getAttribute('data-department-id');
          const departmentName = button.getAttribute('data-department-name');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const departmentNameElement = deleteModal.querySelector('#deleteDepartmentName');
          if (departmentNameElement) {
            departmentNameElement.textContent = departmentName;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteDepartmentForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
    });
  </script>

@endsection