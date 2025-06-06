@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý quyền</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Quản lý tài khoản</a></li>
        <li class="breadcrumb-item active">Quản lý quyền</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0 fw-bold text-primary">Danh sách quyền truy cập</h5>
              <a href="{{ route('admin.permission.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Thêm quyền truy cập
              </a>
            </div>
            
            <!-- @if (session('success'))
              <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif -->

            @if (session('error'))
              <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Tên quyền</th>
                      <th>Mô tả</th>
                      <th class="text-center">Ngày tạo</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($permissions as $permission)
                    <tr>
                      <td><span class="fw-bold">{{ $permission->permission_name }}</span></td>
                      <td>{{ $permission->description }}</td>
                      <td class="text-center">{{ $permission->created_at }}</td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('admin.permission.edit', $permission->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-permission-id="{{ $permission->id }}"
                            data-permission-name="{{ $permission->permission_name }}"
                            data-delete-url="{{ route('admin.permission.destroy', $permission->id) }}"
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
              <!-- Phân trang thủ công -->
              @if ($permissions->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        {{-- Liên kết trang trước --}}
                        @if ($permissions->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $permissions->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        {{-- Các phần tử phân trang --}}
                        @foreach ($permissions->getUrlRange(1, $permissions->lastPage()) as $page => $url)
                            @if ($page == $permissions->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Liên kết trang tiếp theo --}}
                        @if ($permissions->hasMorePages())
                            <li><a href="{{ $permissions->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
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

  <!-- Modal Xác nhận xóa quyền -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa quyền</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa quyền <strong id="deletePermissionName"></strong>?</p>
          <p class="text-danger">Lưu ý: Hành động này sẽ ảnh hưởng đến tất cả vai trò đang sử dụng quyền này.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deletePermissionForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa quyền</button>
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
          const permissionId = button.getAttribute('data-permission-id');
          const permissionName = button.getAttribute('data-permission-name');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const permissionNameElement = deleteModal.querySelector('#deletePermissionName');
          if (permissionNameElement) {
            permissionNameElement.textContent = permissionName;
          }
          
          const deleteForm = deleteModal.querySelector('#deletePermissionForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
    });
  </script>

@endsection