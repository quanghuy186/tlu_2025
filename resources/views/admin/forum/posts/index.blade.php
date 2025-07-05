@extends('layouts/admin')

@section('title')
   Quản lý bài viết diễn đàn
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý bài viết diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Bài viết diễn đàn</li>
      </ol>
    </nav>
</div>

<div class="row container">
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Tổng số bài viết</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="ps-3">
                        <span class="text-muted small">{{ $toltal_post }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Bài viết đã duyệt</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="ps-3">
                        <span class="text-success small">
                            {{ $toltal_post_approved }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card customers-card">
            <div class="card-body">
                <h5 class="card-title">Bài viết đang chờ duyệt</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="ps-3">
                        <span class="text-warning small">{{ $toltal_pendding }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Bài viết bị từ chối</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle"></i>
                    </div>
                    <div class="ps-3">
                        <span class="text-danger small">{{ $toltal_post_reject_reason }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách bài viết diễn đàn</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-folder me-2"></i>QL danh mục
                            </a>
                            <a href="{{ route('admin.forum.posts.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm bài viết
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-3">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form action="{{ route('admin.forum.posts.index') }}" method="GET" class="mb-4 card p-3 bg-light">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="search" class="form-label">Tìm kiếm</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Nhập tiêu đề..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="category_id" class="form-label">Danh mục</label>
                                    <select name="category_id" id="category_id" class="form-select">
                                        <option value="">-- Tất cả danh mục --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="">-- Tất cả trạng thái --</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ duyệt</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Đã từ chối</option>
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="bi bi-search me-1"></i> Lọc
                                    </button>
                                    <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Đặt lại
                                    </a>
                                </div>
                            </div>
                        </form>

                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div class="bulk-actions" style="display: none;">
                                <span class="me-2"><span id="selected-count">0</span> bài viết được chọn</span>
                                <button type="button" class="btn btn-sm btn-success me-2" onclick="bulkUpdateStatus('approved')">
                                    <i class="bi bi-check-circle me-1"></i>Duyệt
                                </button>
                                <button type="button" class="btn btn-sm btn-warning me-2" onclick="showRejectModal()">
                                    <i class="bi bi-x-circle me-1"></i>Từ chối
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="showBulkDeleteModal()">
                                    <i class="bi bi-trash me-1"></i>Xóa
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="3%">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                            </div>
                                        </th>
                                        <th width="5%">ID</th>
                                        <th width="25%">Tiêu đề</th>
                                        <th width="15%">Danh mục</th>
                                        <th width="15%">Tác giả</th>
                                        <th width="10%">Trạng thái</th>
                                        <th width="10%">Lượt xem</th>
                                        <th width="10%">Ngày tạo</th>
                                        <th class="text-center" width="10%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($posts as $post)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input post-checkbox" type="checkbox" value="{{ $post->id }}">
                                            </div>
                                        </td>
                                        <td><span class="badge bg-light text-dark">{{ $post->id }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($post->is_pinned)
                                                    <span class="badge bg-warning me-2" data-bs-toggle="tooltip" data-bs-title="Đã ghim">
                                                        <i class="bi bi-pin-angle-fill"></i>
                                                    </span>
                                                @endif
                                                @if($post->is_locked)
                                                    <span class="badge bg-danger me-2" data-bs-toggle="tooltip" data-bs-title="Đã khóa">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </span>
                                                @endif
                                                <span>{{ Str::limit($post->title, 50) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($post->category)
                                                <span class="badge bg-info text-white">{{ $post->category->name }}</span>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- @if($post->is_anonymous && !auth()->user()->hasRole('admin'))
                                                <span class="text-muted">Ẩn danh</span>
                                            @else --}}
                                                {{ $post->author->name ?? 'Không xác định' }}
                                            {{-- @endif --}}
                                        </td>
                                        <td>
                                            @if($post->status == 'pending')
                                                <span class="badge bg-warning">Chờ duyệt</span>
                                            @elseif($post->status == 'approved')
                                                <span class="badge bg-success">Đã duyệt</span>
                                            @elseif($post->status == 'rejected')
                                                <span class="badge bg-danger">Đã từ chối</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->view_count }}</td>
                                        <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.forum.posts.show', $post->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('admin.forum.posts.edit', $post->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteConfirmModal"
                                                    data-post-id="{{ $post->id }}"
                                                    data-post-title="{{ $post->title }}"
                                                    data-delete-url="{{ route('admin.forum.posts.destroy', $post->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">Không có dữ liệu bài viết</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->appends(request()->query())->links() }}
                        </div>
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
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa bài viết <strong id="deletePostTitle"></strong>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deletePostForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa bài viết</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa nhiều bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <strong id="bulkDeleteCount">0</strong> bài viết đã chọn?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" onclick="confirmBulkDelete()">Xóa bài viết</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bulkRejectModal" tabindex="-1" aria-labelledby="bulkRejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkRejectModalLabel">Từ chối nhiều bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn đang từ chối <strong id="bulkRejectCount">0</strong> bài viết.</p>
                <div class="mb-3">
                    <label for="bulkRejectReason" class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="bulkRejectReason" rows="3" required placeholder="Nhập lý do từ chối..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-warning" onclick="confirmBulkReject()">Từ chối</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
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
                const postId = button.getAttribute('data-post-id');
                const postTitle = button.getAttribute('data-post-title');
                const deleteUrl = button.getAttribute('data-delete-url');
                
                const postTitleElement = deleteModal.querySelector('#deletePostTitle');
                if (postTitleElement) {
                    postTitleElement.textContent = postTitle;
                }
                
                const deleteForm = deleteModal.querySelector('#deletePostForm');
                if (deleteForm) {
                    deleteForm.action = deleteUrl;
                }
            });
        }
    });

    let selectedPosts = [];

    document.getElementById('selectAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.post-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedPosts();
    });

    document.querySelectorAll('.post-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedPosts();
            
            const allCheckboxes = document.querySelectorAll('.post-checkbox');
            const checkedCheckboxes = document.querySelectorAll('.post-checkbox:checked');
            document.getElementById('selectAll').checked = allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0;
        });
    });

    function updateSelectedPosts() {
        selectedPosts = [];
        document.querySelectorAll('.post-checkbox:checked').forEach(checkbox => {
            selectedPosts.push(checkbox.value);
        });
        
        const bulkActions = document.querySelector('.bulk-actions');
        if (selectedPosts.length > 0) {
            bulkActions.style.display = 'block';
            document.getElementById('selected-count').textContent = selectedPosts.length;
        } else {
            bulkActions.style.display = 'none';
        }
    }

    function showBulkDeleteModal() {
        if (selectedPosts.length === 0) {
            showAlert('warning', 'Vui lòng chọn ít nhất một bài viết để xóa');
            return;
        }
        
        document.getElementById('bulkDeleteCount').textContent = selectedPosts.length;
        const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
        modal.show();
    }

    function confirmBulkDelete() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('bulkDeleteModal'));
        modal.hide();
        
        fetch('{{ route("admin.forum.posts.bulk-delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                post_ids: selectedPosts
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('danger', data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            showAlert('danger', 'Có lỗi xảy ra khi xóa bài viết');
        });
    }

    function showRejectModal() {
        if (selectedPosts.length === 0) {
            showAlert('warning', 'Vui lòng chọn ít nhất một bài viết để từ chối');
            return;
        }
        
        document.getElementById('bulkRejectCount').textContent = selectedPosts.length;
        document.getElementById('bulkRejectReason').value = '';
        const modal = new bootstrap.Modal(document.getElementById('bulkRejectModal'));
        modal.show();
    }

    function confirmBulkReject() {
        const rejectReason = document.getElementById('bulkRejectReason').value.trim();
        
        if (!rejectReason) {
            showAlert('warning', 'Vui lòng nhập lý do từ chối');
            return;
        }
        
        const modal = bootstrap.Modal.getInstance(document.getElementById('bulkRejectModal'));
        modal.hide();
        
        bulkUpdateStatus('rejected', rejectReason);
    }

    function bulkUpdateStatus(status, rejectReason = null) {
        if (selectedPosts.length === 0) {
            showAlert('warning', 'Vui lòng chọn ít nhất một bài viết');
            return;
        }
        
        const data = {
            post_ids: selectedPosts,
            status: status
        };
        
        if (rejectReason) {
            data.reject_reason = rejectReason;
        }
        
        fetch('{{ route("admin.forum.posts.bulk-update-status") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showAlert('danger', data.message || 'Có lỗi xảy ra');
            }
        })
        .catch(error => {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
        });
    }

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show mb-3">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        const cardBody = document.querySelector('.card-body');
        cardBody.insertAdjacentHTML('afterbegin', alertHtml);
        
        setTimeout(() => {
            const alert = cardBody.querySelector('.alert');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
</script>
@endsection

<style>
    .table tbody tr:has(.post-checkbox:checked) {
        background-color: #f8f9fa !important;
    }

    .bulk-actions {
        background-color: #f0f0f0;
        padding: 10px 15px;
        border-radius: 5px;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-check-input {
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .bulk-actions button {
        transition: all 0.3s ease;
    }

    .bulk-actions button:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    @media (max-width: 768px) {
        .bulk-actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .bulk-actions button {
            width: 100%;
        }
    }
</style>