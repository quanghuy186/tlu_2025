@extends('layouts/admin')

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
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
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
                      <td colspan="7" class="text-center py-4">
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
    });
  </script>

@endsection