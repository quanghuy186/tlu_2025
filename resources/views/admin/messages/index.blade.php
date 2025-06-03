{{-- resources/views/admin/messages/index.blade.php --}}
@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý tin nhắn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Tin nhắn</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
      <!-- Thống kê nhanh -->
      <div class="row mb-4">
        <div class="col-xxl-3 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Tổng tin nhắn</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-chat-dots"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($statistics['total']) }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Chưa đọc</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-envelope"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($statistics['unread']) }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Hôm nay</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-calendar-check"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($statistics['today']) }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-3 col-md-6">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Đã xóa</h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-trash"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ number_format($statistics['deleted']) }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <!-- Form tìm kiếm và lọc -->
          <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light">
              <h5 class="card-title m-0 fw-bold text-secondary">Tìm kiếm & Lọc</h5>
            </div>
            <div class="card-body mt-3">
              <form method="GET" action="{{ route('admin.messages.index') }}" id="filterForm">
                <div class="row g-3">
                  <!-- Tìm kiếm -->
                  <div class="col-md-4">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nội dung, người gửi, người nhận...">
                  </div>
                  
                  <!-- Lọc theo trạng thái đọc -->
                  <div class="col-md-2">
                    <label for="is_read" class="form-label">Trạng thái</label>
                    <select class="form-select" id="is_read" name="is_read">
                      <option value="">Tất cả</option>
                      <option value="0" {{ request('is_read') == '0' ? 'selected' : '' }}>Chưa đọc</option>
                      <option value="1" {{ request('is_read') == '1' ? 'selected' : '' }}>Đã đọc</option>
                    </select>
                  </div>
                  
                  <!-- Lọc theo loại tin nhắn -->
                  <div class="col-md-2">
                    <label for="message_type" class="form-label">Loại tin nhắn</label>
                    <select class="form-select" id="message_type" name="message_type">
                      <option value="">Tất cả</option>
                      <option value="text" {{ request('message_type') == 'text' ? 'selected' : '' }}>Văn bản</option>
                      <option value="image" {{ request('message_type') == 'image' ? 'selected' : '' }}>Hình ảnh</option>
                      <option value="file" {{ request('message_type') == 'file' ? 'selected' : '' }}>Tệp tin</option>
                      <option value="video" {{ request('message_type') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                  </div>
                  
                  <!-- Người gửi -->
                  <div class="col-md-2">
                    <label for="sender_user_id" class="form-label">Người gửi</label>
                    <select class="form-select" id="sender_user_id" name="sender_user_id">
                      <option value="">Tất cả</option>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('sender_user_id') == $user->id ? 'selected' : '' }}>
                          {{ $user->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                  
                  <!-- Người nhận -->
                  <div class="col-md-2">
                    <label for="recipient_user_id" class="form-label">Người nhận</label>
                    <select class="form-select" id="recipient_user_id" name="recipient_user_id">
                      <option value="">Tất cả</option>
                      @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('recipient_user_id') == $user->id ? 'selected' : '' }}>
                          {{ $user->name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                
                <div class="row g-3 mt-2">
                  <!-- Lọc theo ngày -->
                  <div class="col-md-2">
                    <label for="date_from" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                  </div>
                  
                  <div class="col-md-2">
                    <label for="date_to" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                  </div>
                  
                  <!-- Hiển thị tin đã xóa -->
                  <div class="col-md-2">
                    <label for="show_deleted" class="form-label">Hiển thị đã xóa</label>
                    <select class="form-select" id="show_deleted" name="show_deleted">
                      <option value="0" {{ request('show_deleted') == '0' ? 'selected' : '' }}>Không</option>
                      <option value="1" {{ request('show_deleted') == '1' ? 'selected' : '' }}>Có</option>
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
                  
                  <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                      <i class="bi bi-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">
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
                Danh sách tin nhắn 
                <span class="badge bg-success text-white ms-2">{{ $messages->total() }} kết quả</span>
              </h5>
              <div class="d-flex gap-2">
                <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                  <i class="bi bi-trash me-2"></i>Xóa đã chọn (<span id="selectedCount">0</span>)
                </button>
                <a href="{{ route('admin.messages.statistics') }}" class="btn btn-info btn-sm d-flex align-items-center">
                  <i class="bi bi-bar-chart me-2"></i>Thống kê
                </a>
                <a href="{{ route('admin.messages.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                  <i class="bi bi-plus-circle me-2"></i>Gửi tin nhắn
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
                        <a href="{{ request()->fullUrlWithQuery(['sort_field' => 'sent_at', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                           class="text-decoration-none text-dark">
                          Thời gian
                          @if(request('sort_field') == 'sent_at')
                            <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="8" class="text-center py-4">
                        <div class="text-muted">
                          <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                          Không tìm thấy tin nhắn nào
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
              @if ($messages->hasPages())
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    Hiển thị {{ $messages->firstItem() }} - {{ $messages->lastItem() }} 
                    của {{ $messages->total() }} kết quả
                  </div>
                  
                  {{ $messages->links() }}
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Xác nhận xóa tin nhắn -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa tin nhắn</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa tin nhắn này?</p>
          <p class="text-muted"><strong>Nội dung:</strong> <span id="deleteMessageContent"></span></p>
          <p class="text-danger">Lưu ý: Tin nhắn sẽ được chuyển vào thùng rác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteMessageForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa tin nhắn</button>
          </form>
        </div>
      </div>
    </div>
  </div>  

  <!-- Modal Xác nhận xóa nhiều tin nhắn -->
  <div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa nhiều tin nhắn</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa <strong id="bulkDeleteCount">0</strong> tin nhắn đã chọn?</p>
          <div id="selectedMessagesList" class="mb-3"></div>
          <p class="text-danger">Lưu ý: Các tin nhắn sẽ được chuyển vào thùng rác.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="bulkDeleteForm" action="{{ route('admin.messages.bulkDestroy') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <input type="hidden" name="message_ids" id="messageIdsInput">
            <button type="submit" class="btn btn-danger">Xóa tin nhắn</button>
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
          const messageId = button.getAttribute('data-message-id');
          const messageContent = button.getAttribute('data-message-content');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const contentElement = deleteModal.querySelector('#deleteMessageContent');
          if (contentElement) {
            contentElement.textContent = messageContent;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteMessageForm');
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

      // Xử lý chọn nhiều tin nhắn
      const selectAllCheckbox = document.getElementById('selectAll');
      const messageCheckboxes = document.querySelectorAll('.message-checkbox:not([disabled])');
      const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
      const selectedCountSpan = document.getElementById('selectedCount');
      const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
      const selectedMessagesList = document.getElementById('selectedMessagesList');
      const messageIdsInput = document.getElementById('messageIdsInput');

      // Cập nhật trạng thái nút xóa nhiều
      function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.message-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
          bulkDeleteBtn.classList.remove('d-none');
          selectedCountSpan.textContent = count;
          bulkDeleteCountSpan.textContent = count;
          
          // Cập nhật danh sách tin nhắn được chọn
          let messagesList = '<ul class="mb-0">';
          const messageIds = [];
          checkedBoxes.forEach(function(checkbox) {
            const messageContent = checkbox.getAttribute('data-message-content');
            messagesList += `<li>${messageContent}</li>`;
            messageIds.push(checkbox.value);
          });
          messagesList += '</ul>';
          selectedMessagesList.innerHTML = messagesList;
          messageIdsInput.value = messageIds.join(',');
        } else {
          bulkDeleteBtn.classList.add('d-none');
        }
      }

      // Chọn/bỏ chọn tất cả
      selectAllCheckbox.addEventListener('change', function() {
        messageCheckboxes.forEach(function(checkbox) {
          checkbox.checked = selectAllCheckbox.checked;
        });
        updateBulkDeleteButton();
      });

      // Xử lý khi chọn/bỏ chọn từng checkbox
      messageCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
          // Cập nhật trạng thái của checkbox "select all"
          const allChecked = Array.from(messageCheckboxes).every(cb => cb.checked);
          const someChecked = Array.from(messageCheckboxes).some(cb => cb.checked);
          
          selectAllCheckbox.checked = allChecked;
          selectAllCheckbox.indeterminate = someChecked && !allChecked;
          
          updateBulkDeleteButton();
        });
      });
    });

    // Đánh dấu đã đọc
    function markAsRead(messageId) {
      fetch(`{{ url('admin/messages') }}/${messageId}/mark-read`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        }
      });
    }

    // Đánh dấu chưa đọc
    function markAsUnread(messageId) {
      fetch(`{{ url('admin/messages') }}/${messageId}/mark-unread`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload();
        }
      });
    }

    // Khôi phục tin nhắn
    function restoreMessage(messageId) {
      if (confirm('Bạn có chắc muốn khôi phục tin nhắn này?')) {
        fetch(`{{ url('admin/messages') }}/${messageId}/restore`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
          }
        })
        .then(response => {
          location.reload();
        });
      }
    }
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
    .message-checkbox:disabled {
      cursor: not-allowed;
      opacity: 0.5;
    }
    .table-warning {
      background-color: #fff3cd !important;
    }
  </style>

@endsection
                        </a>
                      </th>
                      <th>Người gửi</th>
                      <th>Người nhận</th>
                      <th>Nội dung</th>
                      <th class="text-center">Loại</th>
                      <th class="text-center">Trạng thái</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($messages as $message)
                    <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                      <td class="text-center">
                        <input type="checkbox" class="form-check-input message-checkbox" value="{{ $message->id }}" 
                               data-message-content="{{ $message->short_content }}">
                      </td>
                      <td>
                        <span class="text-muted small">{{ $message->formatted_sent_at }}</span>
                      </td>
                      <td>
                        @if($message->sender)
                          {{ $message->sender->name }}
                          <br>
                          <small class="text-muted">{{ $message->sender->email }}</small>
                        @else
                          <span class="text-muted">Hệ thống</span>
                        @endif
                      </td>
                      <td>
                        @if($message->recipient)
                          {{ $message->recipient->name }}
                          <br>
                          <small class="text-muted">{{ $message->recipient->email }}</small>
                        @else
                          <span class="text-muted">Tất cả</span>
                        @endif
                      </td>
                      <td>
                        {{ $message->short_content }}
                        @if($message->file_url)
                          <i class="bi bi-paperclip text-primary"></i>
                        @endif
                      </td>
                      <td class="text-center">{!! $message->message_type_badge !!}</td>
                      <td class="text-center">{!! $message->status_badge !!}</td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('admin.messages.show', $message->id) }}" 
                             data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" 
                             class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i>
                          </a>
                          
                          @if(!$message->is_read)
                          <button onclick="markAsRead({{ $message->id }})" 
                                  data-bs-toggle="tooltip" data-bs-title="Đánh dấu đã đọc" 
                                  class="btn btn-sm btn-primary">
                            <i class="bi bi-check2"></i>
                          </button>
                          @else
                          <button onclick="markAsUnread({{ $message->id }})" 
                                  data-bs-toggle="tooltip" data-bs-title="Đánh dấu chưa đọc" 
                                  class="btn btn-sm btn-warning">
                            <i class="bi bi-envelope"></i>
                          </button>
                          @endif
                          
                          @if($message->sender_user_id == auth()->id() && !$message->is_read)
                          <a href="{{ route('admin.messages.edit', $message->id) }}" 
                             data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" 
                             class="btn btn-sm btn-info">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          @endif
                          
                          @if($message->is_deleted)
                          <button onclick="restoreMessage({{ $message->id }})" 
                                  data-bs-toggle="tooltip" data-bs-title="Khôi phục" 
                                  class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                          </button>
                          @else
                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-message-id="{{ $message->id }}"
                            data-message-content="{{ $message->short_content }}"
                            data-delete-url="{{ route('admin.messages.destroy', $message->id) }}"
                            class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>
                          @endif