@extends('layouts/admin')

@section('title')
   Quản lý thông tin người dùng
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý tài khoản</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Người dùng</li>
        <li class="breadcrumb-item active">Quản lý người dùng</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <!-- Form tìm kiếm và lọc -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
              <h5 class="card-title m-0 fw-bold text-secondary">Tìm kiếm & Lọc</h5>
            </div>
            <div class="card-body mt-3">
              <form method="GET" action="{{ route('admin.user.index') }}" id="filterForm">
                <div class="row g-3">
                  <!-- Tìm kiếm -->
                  <div class="col-md-4">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nhập tên hoặc email...">
                  </div>
                  
                  <!-- Lọc theo trạng thái kích hoạt -->
                  <div class="col-md-2">
                    <label for="email_verified" class="form-label">Trạng thái kích hoạt</label>
                    <select class="form-select" id="email_verified" name="email_verified">
                      <option value="">Tất cả</option>
                      <option value="1" {{ request('email_verified') == '1' ? 'selected' : '' }}>Đã kích hoạt</option>
                      <option value="0" {{ request('email_verified') == '0' ? 'selected' : '' }}>Chưa kích hoạt</option>
                    </select>
                  </div>
                  
                  <!-- Lọc theo trạng thái tài khoản -->
                  <div class="col-md-2">
                    <label for="is_active" class="form-label">Trạng thái tài khoản</label>
                    <select class="form-select" id="is_active" name="is_active">
                      <option value="">Tất cả</option>
                      <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Hoạt động</option>
                      <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Ngừng hoạt động</option>
                    </select>
                  </div>
                  
                  <!-- Lọc theo vai trò -->
                  <div class="col-md-2">
                    <label for="role_id" class="form-label">Vai trò</label>
                    <select class="form-select" id="role_id" name="role_id">
                      <option value="">Tất cả</option>
                      @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                          {{ $role->description }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Số lượng hiển thị -->
                  <div class="col-md-2">
                    <label for="per_page" class="form-label">Hiển thị</label>
                    <select class="form-select" id="per_page" name="per_page">
                      <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                      <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                      <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                      <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                    </select>
                  </div>
                </div>
                
                <div class="row mt-3">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                      <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold text-primary">
              Danh sách tài khoản 
              <span class="badge bg-success text-white ms-2">{{ $users->total() }} kết quả</span>
            </h5>
            <div class="d-flex gap-2">
              <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                <i class="bi bi-trash me-2"></i>Xóa đã chọn (<span id="selectedCount">0</span>)
              </button>
              {{-- <a href="{{ route('admin.user.import-excel') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                <i class="bi bi-file-earmark-excel me-2"></i>Nhập từ Excel
              </a> --}}
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
                      <th width="50" class="text-center">
                        <input type="checkbox" class="form-check-input" id="selectAll">
                      </th>
                      <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                          Họ và tên
                          @if(request('sort_field') == 'name')
                            <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                          @endif
                        </a>
                      </th>
                      <th>
                        <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'email', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                          Email
                          @if(request('sort_field') == 'email')
                            <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                          @endif
                        </a>
                      </th>
                      <th class="text-center">Trạng thái kích hoạt</th>
                      <th class="text-center">Trạng thái tài khoản</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($users as $user)
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}" 
                               data-user-name="{{ $user->name }}"
                               @if(Auth::user()->id == $user->id) disabled @endif>
                      </td>
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
                          <a href="{{ route('admin.user.edit', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <a href="{{ route('admin.user_has_role.create_with_user', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Phân vai trò" class="btn btn-sm btn-info">
                            <i class="bi bi-person-gear"></i>
                          </a>
                          <a href="{{ route('admin.user_has_permission.create_with_user', $user->id) }}" data-bs-toggle="tooltip" data-bs-title="Phân quyền" class="btn btn-sm btn-warning">
                            <i class="bi bi-key"></i>
                          </a>
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
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="text-center py-4">
                        <div class="text-muted">
                          <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                          Không tìm thấy kết quả nào
                        </div>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white py-3">
              <!-- Phân trang Bootstrap 5 -->
              @if ($users->hasPages())
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    Hiển thị {{ $users->firstItem() }} - {{ $users->lastItem() }} 
                    của {{ $users->total() }} kết quả
                  </div>
                  
                  <nav aria-label="Pagination">
                    <ul class="pagination mb-0">
                      {{-- Previous Page Link --}}
                      @if ($users->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">‹</span></li>
                      @else
                        <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">‹</a></li>
                      @endif

                      {{-- Pagination Elements --}}
                      @foreach ($users->links()->elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                          <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                          @foreach ($element as $page => $url)
                            @if ($page == $users->currentPage())
                              <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                              <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                          @endforeach
                        @endif
                      @endforeach

                      {{-- Next Page Link --}}
                      @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">›</a></li>
                      @else
                        <li class="page-item disabled"><span class="page-link">›</span></li>
                      @endif
                    </ul>
                  </nav>
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

  <!-- Modal Xác nhận xóa nhiều tài khoản -->
  <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa nhiều tài khoản</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa <strong id="bulkDeleteCount">0</strong> tài khoản đã chọn?</p>
          <div id="selectedUsersList" class="mb-3"></div>
          <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="bulkDeleteForm" action="{{ route('admin.user.bulkDestroy') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <input type="hidden" name="user_ids" id="userIdsInput">
            <button type="submit" class="btn btn-danger">Xóa tài khoản</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Khởi tạo tooltips
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
      
      // Xử lý modal xóa
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

      // Auto submit form khi thay đổi select box
      const selectElements = document.querySelectorAll('#filterForm select');
      selectElements.forEach(function(select) {
        select.addEventListener('change', function() {
          document.getElementById('filterForm').submit();
        });
      });

      // Thêm sự kiện Enter cho ô tìm kiếm
      const searchInput = document.getElementById('search');
      if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterForm').submit();
          }
        });
      }

      // Xử lý chọn nhiều người dùng
      const selectAllCheckbox = document.getElementById('selectAll');
      const userCheckboxes = document.querySelectorAll('.user-checkbox:not([disabled])');
      const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
      const selectedCountSpan = document.getElementById('selectedCount');
      const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
      const selectedUsersList = document.getElementById('selectedUsersList');
      const userIdsInput = document.getElementById('userIdsInput');

      // Cập nhật trạng thái nút xóa nhiều
      function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
          bulkDeleteBtn.classList.remove('d-none');
          selectedCountSpan.textContent = count;
          bulkDeleteCountSpan.textContent = count;
          
          // Cập nhật danh sách người dùng được chọn
          let usersList = '<ul class="mb-0">';
          const userIds = [];
          checkedBoxes.forEach(function(checkbox) {
            const userName = checkbox.getAttribute('data-user-name');
            usersList += `<li>${userName}</li>`;
            userIds.push(checkbox.value);
          });
          usersList += '</ul>';
          selectedUsersList.innerHTML = usersList;
          userIdsInput.value = userIds.join(',');
        } else {
          bulkDeleteBtn.classList.add('d-none');
        }
      }

      // Chọn/bỏ chọn tất cả
      selectAllCheckbox.addEventListener('change', function() {
        userCheckboxes.forEach(function(checkbox) {
          checkbox.checked = selectAllCheckbox.checked;
        });
        updateBulkDeleteButton();
      });

      // Xử lý khi chọn/bỏ chọn từng checkbox
      userCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
          // Cập nhật trạng thái của checkbox "select all"
          const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
          const someChecked = Array.from(userCheckboxes).some(cb => cb.checked);
          
          selectAllCheckbox.checked = allChecked;
          selectAllCheckbox.indeterminate = someChecked && !allChecked;
          
          updateBulkDeleteButton();
        });
      });
    });
  </script>

  <style>
    .table th a {
      color: inherit;
      text-decoration: none;
    }
    .table th a:hover {
      color: #0d6efd;
    }
    .pagination-info {
      color: #6c757d;
      font-size: 0.875rem;
    }
    .form-check-input {
      cursor: pointer;
    }
    #selectAll {
      margin-top: 0;
    }
    .user-checkbox:disabled {
      cursor: not-allowed;
      opacity: 0.5;
    }
  </style>

@endsection