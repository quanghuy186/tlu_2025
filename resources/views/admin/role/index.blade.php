@extends('layouts/admin')

@section('title')
   Quản lý thông tin vai trò
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý vai trò</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Hệ thống</li>
        <li class="breadcrumb-item active">Vai trò</li>
      </ol>
    </nav>
</div>

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0 fw-bold text-primary">Danh sách vai trò</h5>
              <a href="{{ route('admin.role.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Thêm vai trò
              </a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Tên vai trò</th>
                      <th>Mô tả</th>
                      <th class="text-center">Ngày tạo</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($roles as $role)
                    <tr>
                      <td><span class="fw-bold">{{ $role->role_name }}</span></td>
                      <td>{{ $role->description }}</td>
                      <td class="text-center">{{ $role->created_at }}</td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('admin.role.edit', $role->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-role-id="{{ $role->id }}"
                            data-role-name="{{ $role->role_name }}"
                            data-delete-url="{{ route('admin.role.destroy', $role->id) }}"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white py-3">
              @if ($roles->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        @if ($roles->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $roles->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                            @if ($page == $roles->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if ($roles->hasMorePages())
                            <li><a href="{{ $roles->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
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

  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa vai trò</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa vai trò <strong id="deleteRoleName"></strong>?</p>
          <p class="text-danger">Lưu ý: Hành động này sẽ ảnh hưởng đến tất cả người dùng đang sử dụng vai trò này.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteRoleForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa vai trò</button>
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
          const roleId = button.getAttribute('data-role-id');
          const roleName = button.getAttribute('data-role-name');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const roleNameElement = deleteModal.querySelector('#deleteRoleName');
          if (roleNameElement) {
            roleNameElement.textContent = roleName;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteRoleForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
    });
  </script>

@endsection