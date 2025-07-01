@extends('layouts/admin')

@section('title')
   Quản lý thông báo
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Thông báo</li>
        <li class="breadcrumb-item active">Danh sách</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container-fluid">
      <!-- Filter & Search Section -->
      <div class="row mb-4">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
              <h5 class="card-title m-0 fw-bold text-primary">Tìm kiếm và lọc</h5>
            </div>
            <div class="card-body mt-3">
              <form action="{{ route('admin.notification.index') }}" method="GET" id="filterForm">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="search" class="form-label">Tìm kiếm</label>
                      <input type="text" class="form-control" id="search" name="search" 
                            placeholder="Tiêu đề, nội dung..." value="{{ request('search') }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="category_id" class="form-label">Danh mục</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                          <option value="{{ $category->id }}" 
                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  {{-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="status" class="form-label">Trạng thái</label>
                      <select class="form-select" id="status" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                      </select>
                    </div>
                  </div> --}}
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="date_from" class="form-label">Từ ngày</label>
                      <input type="text" class="form-control datepicker" id="date_from" name="date_from" 
                            placeholder="DD/MM/YYYY" value="{{ request('date_from') }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="date_to" class="form-label">Đến ngày</label>
                      <input type="text" class="form-control datepicker" id="date_to" name="date_to" 
                            placeholder="DD/MM/YYYY" value="{{ request('date_to') }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sort_field" class="form-label">Sắp xếp theo</label>
                      <select class="form-select" id="sort_field" name="sort_field">
                        <option value="created_at" {{ request('sort_field', 'created_at') == 'created_at' ? 'selected' : '' }}>Ngày tạo</option>
                        <option value="title" {{ request('sort_field') == 'title' ? 'selected' : '' }}>Tiêu đề</option>
                        <option value="views_count" {{ request('sort_field') == 'views_count' ? 'selected' : '' }}>Lượt xem</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="sort_direction" class="form-label">Thứ tự</label>
                      <select class="form-select" id="sort_direction" name="sort_direction">
                        <option value="desc" {{ request('sort_direction', 'desc') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                        <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('admin.notification.index') }}" class="btn btn-secondary">
                      <i class="bi bi-arrow-counterclockwise me-1"></i>Đặt lại
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- End Filter & Search Section -->

      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0 fw-bold text-primary">Danh sách thông báo</h5>
              <div>
                <a href="{{ route('admin.notification-category.index') }}" class="btn btn-info btn-sm me-2">
                  <i class="bi bi-tags me-1"></i>Quản lý danh mục
                </a>
                <a href="{{ route('admin.notification.create') }}" class="btn btn-success btn-sm">
                  <i class="bi bi-plus-circle me-1"></i>Thêm thông báo
                </a>
              </div>
            </div>
            <div class="card-body p-0">
              <form action="{{ route('admin.notification.bulk-destroy') }}" method="POST" id="bulkDeleteForm">
                @csrf
                @method('DELETE')

                <!-- Bulk Actions Toolbar -->
                <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <div class="form-check ms-2">
                      <input class="form-check-input" type="checkbox" id="selectAll">
                      <label class="form-check-label" for="selectAll">Chọn tất cả</label>
                    </div>
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm ms-3" disabled>
                      <i class="bi bi-trash me-1"></i>Xóa đã chọn
                    </button>
                  </div>
                  <div class="me-2">
                    <span class="text-muted">Hiển thị {{ $notifications->count() }} trên {{ $notifications->total() }} thông báo</span>
                  </div>
                </div>

                <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                      <tr>
                        <th width="3%"></th>
                        <th>Tiêu đề</th>
                        <th>Nội dung tóm tắt</th>
                        <th>Người tạo</th>
                        <th>Danh mục</th>
                        <th>Hình ảnh</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center" width="15%">Hành động</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($notifications as $notification)
                      <tr>
                        <td>
                          <div class="form-check">
                            <input class="form-check-input notification-checkbox" type="checkbox" 
                                  name="selected_ids[]" value="{{ $notification->id }}" 
                                  id="notification-{{ $notification->id }}">
                          </div>
                        </td>
                        <td>{{ $notification->title }}</td>
                        <td><span class="text-muted">{{ Str::limit(strip_tags($notification->content), 50) }}</span></td>
                        <td>{{ $notification->user->name }}</td>
                        <td>
                          @if ($notification->category)
                            <span class="badge bg-info rounded-pill px-3">
                              @if($notification->category->icon)
                                <i class="bi bi-{{ $notification->category->icon }} me-1"></i>
                              @endif
                              {{ $notification->category->name }}
                            </span>
                          @else
                            <span class="badge bg-secondary rounded-pill px-3">Chưa phân loại</span>
                          @endif
                        </td>
                        <td>
                          @if ($notification->images)
                            @php
                              $imageCount = count($notification->images_array);
                              $firstImageUrl = $notification->first_image_url;
                            @endphp
                            <a href="{{ route('admin.notification.detail', $notification->id) }}" 
                              data-bs-toggle="tooltip" 
                              data-bs-title="{{ $imageCount }} hình ảnh"
                              class="position-relative d-inline-block">
                              <img src="{{ $firstImageUrl }}" class="img-thumbnail" alt="Thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                              @if($imageCount > 1)
                              <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">+{{ $imageCount - 1 }}</span>
                              @endif
                            </a>
                          @else
                            <span class="text-muted">Không có</span>
                          @endif
                        </td>
                        <td class="text-center">
                          {{ $notification->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                          <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.notification.edit', $notification->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                              <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="{{ route('admin.notification.detail', $notification->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" class="btn btn-sm btn-success">
                              <i class="bi bi-eye"></i>
                            </a>

                            <a href="#" 
                              data-bs-toggle="modal" 
                              data-bs-target="#deleteConfirmModal"
                              data-notification-id="{{ $notification->id }}"
                              data-notification-title="{{ $notification->title }}"
                              data-delete-url="{{ route('admin.notification.destroy', $notification->id) }}"
                              class="btn btn-sm btn-danger">
                              <i class="bi bi-trash-fill"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                      
                      @if(count($notifications) == 0)
                      <tr>
                        <td colspan="8" class="text-center py-4">
                          <div class="text-muted">
                            <i class="bi bi-info-circle me-1"></i> Chưa có thông báo nào.
                            <a href="{{ route('admin.notification.create') }}" class="ms-2">Thêm thông báo mới</a>
                          </div>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                  </table>
                </div>
              </form>
            </div>
            <div class="card-footer bg-white py-3">
              <!-- Phân trang -->
              {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Xác nhận xóa thông báo -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa thông báo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa thông báo <strong id="deleteNotificationTitle"></strong>?</p>
          <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteNotificationForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa thông báo</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal Xác nhận xóa nhiều thông báo -->
  <div class="modal fade" id="bulkDeleteConfirmModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkDeleteConfirmModalLabel">Xác nhận xóa nhiều thông báo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa <strong id="selectedCount">0</strong> thông báo đã chọn?</p>
          <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <button type="button" id="confirmBulkDelete" class="btn btn-danger">Xóa thông báo</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Tooltip initialization
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
      
      // Single delete modal handling
      const deleteModal = document.getElementById('deleteConfirmModal');
      if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;
          const notificationId = button.getAttribute('data-notification-id');
          const notificationTitle = button.getAttribute('data-notification-title');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const titleElement = deleteModal.querySelector('#deleteNotificationTitle');
          if (titleElement) {
            titleElement.textContent = notificationTitle;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteNotificationForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
      
      // Select all checkboxes
      const selectAllCheckbox = document.getElementById('selectAll');
      const notificationCheckboxes = document.querySelectorAll('.notification-checkbox');
      const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
      
      if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
          const isChecked = this.checked;
          
          notificationCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
          });
          
          updateBulkDeleteButton();
        });
      }
      
      // Individual checkbox change handler
      notificationCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
          updateBulkDeleteButton();
          
          // Update "select all" checkbox state
          const allChecked = Array.from(notificationCheckboxes).every(cb => cb.checked);
          const someChecked = Array.from(notificationCheckboxes).some(cb => cb.checked);
          
          if (selectAllCheckbox) {
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
          }
        });
      });
      
      // Update bulk delete button state
      function updateBulkDeleteButton() {
        const checkedCount = document.querySelectorAll('.notification-checkbox:checked').length;
        
        if (bulkDeleteBtn) {
          bulkDeleteBtn.disabled = checkedCount === 0;
          bulkDeleteBtn.textContent = checkedCount > 0 
            ? `Xóa đã chọn (${checkedCount})` 
            : 'Xóa đã chọn';
        }
      }
      
      // Bulk delete button click handler
      if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
          const checkedCount = document.querySelectorAll('.notification-checkbox:checked').length;
          
          if (checkedCount > 0) {
            // Show bulk delete confirmation modal
            const bulkDeleteModal = new bootstrap.Modal(document.getElementById('bulkDeleteConfirmModal'));
            document.getElementById('selectedCount').textContent = checkedCount;
            bulkDeleteModal.show();
          }
        });
      }
      
      // Confirm bulk delete
      const confirmBulkDeleteBtn = document.getElementById('confirmBulkDelete');
      if (confirmBulkDeleteBtn) {
        confirmBulkDeleteBtn.addEventListener('click', function() {
          // Kiểm tra xem có thông báo nào được chọn không
          const checkedCount = document.querySelectorAll('.notification-checkbox:checked').length;
          if (checkedCount === 0) {
            alert('Vui lòng chọn ít nhất một thông báo để xóa.');
            return;
          }
          
          // Submit form
          document.getElementById('bulkDeleteForm').submit();
        });
      }
      
      // Initialize datepicker if available
      if (typeof flatpickr !== 'undefined') {
        flatpickr('.datepicker', {
          dateFormat: 'd/m/Y',
          locale: 'vn'
        });
      }
      
      // Debug form submit
      const bulkDeleteForm = document.getElementById('bulkDeleteForm');
      if (bulkDeleteForm) {
        bulkDeleteForm.addEventListener('submit', function(e) {
          const checkedCount = document.querySelectorAll('.notification-checkbox:checked').length;
          if (checkedCount === 0) {
            e.preventDefault();
            alert('Vui lòng chọn ít nhất một thông báo để xóa.');
            return false;
          }
          // Form sẽ submit bình thường nếu có checkbox được chọn
        });
      }
    });
  </script>

@endsection