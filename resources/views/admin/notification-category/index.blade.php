@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý danh mục thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Danh mục thông báo</li>
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
              <h5 class="card-title m-0 fw-bold text-primary">Danh sách danh mục thông báo</h5>
              <a href="{{ route('admin.notification-category.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Thêm danh mục
              </a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Tên danh mục</th>
                      <th>Slug</th>
                      <th>Mô tả</th>
                      <!-- <th class="text-center">Icon</th> -->
                      <th class="text-center">Thứ tự hiển thị</th>
                      <th class="text-center">Số thông báo</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $category)
                    <tr>
                      <td>{{ $category->name }}</td>
                      <td><code>{{ $category->slug }}</code></td>
                      <td>
                        @if ($category->description)
                          {{ Str::limit($category->description, 50) }}
                        @else
                          <span class="text-muted">Không có mô tả</span>
                        @endif
                      </td>
                      <!-- <td class="text-center">
                        @if ($category->icon)
                          <i class="bi bi-{{ $category->icon }} fs-4"></i>
                        @else
                          <span class="text-muted">-</span>
                        @endif
                      </td> -->
                      <td class="text-center">{{ $category->display_order }}</td>
                      <td class="text-center">
                        <span class="badge bg-info rounded-pill px-3">{{ $category->notifications->count() }}</span>
                      </td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('admin.notification-category.edit', $category->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <a href="#" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmModal"
                            data-category-id="{{ $category->id }}"
                            data-category-name="{{ $category->name }}"
                            data-delete-url="{{ route('admin.notification-category.destroy', $category->id) }}"
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
              <!-- Phân trang -->
              {{ $categories->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Modal Xác nhận xóa danh mục -->
  <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa danh mục</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Bạn có chắc chắn muốn xóa danh mục <strong id="deleteCategoryName"></strong>?</p>
          <p class="text-danger">Lưu ý: Không thể xóa danh mục đang có thông báo. Bạn cần chuyển tất cả thông báo sang danh mục khác trước.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
          <form id="deleteCategoryForm" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Xóa danh mục</button>
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
          const categoryId = button.getAttribute('data-category-id');
          const categoryName = button.getAttribute('data-category-name');
          const deleteUrl = button.getAttribute('data-delete-url');
          
          const nameElement = deleteModal.querySelector('#deleteCategoryName');
          if (nameElement) {
            nameElement.textContent = categoryName;
          }
          
          const deleteForm = deleteModal.querySelector('#deleteCategoryForm');
          if (deleteForm) {
            deleteForm.action = deleteUrl;
          }
        });
      }
    });
  </script>

@endsection