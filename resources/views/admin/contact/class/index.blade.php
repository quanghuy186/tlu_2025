@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý lớp học</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Lớp học</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <!-- Search and Filter Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Tìm kiếm & Lọc</h5>
                    </div>
                    <div class="card-body my-3">
                        <form action="{{ route('admin.class.index') }}" method="GET" id="search-form">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Tìm kiếm..." name="search" value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- <div class="col-md-2">
                                    <select class="form-select" name="academic_year" onchange="this.form.submit()">
                                        <option value="">-- Năm học --</option>
                                        @foreach($academicYears as $key => $year)
                                            <option value="{{ $key }}" {{ request('academic_year') == $key ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <select class="form-select" name="semester" onchange="this.form.submit()">
                                        <option value="">-- Học kỳ --</option>
                                        @foreach($semesters as $key => $semester)
                                            <option value="{{ $key }}" {{ request('semester') == $key ? 'selected' : '' }}>
                                                {{ $semester }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                
                                <div class="col-md-4">
                                    <select class="form-select" name="department_id" onchange="this.form.submit()">
                                        <option value="">-- Khoa/Bộ môn --</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <select class="form-select" name="teacher_id" onchange="this.form.submit()">
                                        <option value="">-- Giảng viên --</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                                {{ $teacher->user->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            @if(request()->anyFilled(['search', 'academic_year', 'semester', 'department_id', 'teacher_id']))
                                <div class="mt-3">
                                    <a href="{{ route('admin.class.index') }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-x-circle me-1"></i>Xóa bộ lọc
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                
                <!-- Classes List Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách lớp học</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.teacher.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-person-badge me-2"></i>QL giảng viên
                            </a>
                            <a href="{{ route('admin.department.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-building me-2"></i>QL đơn vị
                            </a>
                            <a href="{{ route('admin.class.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm lớp học
                            </a>
                            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm d-flex align-items-center" disabled>
                                <i class="bi bi-trash me-2"></i>Xóa đã chọn
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <form id="bulk-delete-form" action="{{ route('admin.class.bulk-destroy') }}" method="POST">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="select-all">
                                                </div>
                                            </th>
                                            <th>Mã lớp</th>
                                            <th>Tên lớp</th>
                                            <th>Giảng viên phụ trách</th>
                                            <th>Khoa/Bộ môn</th>
                                            <th>Năm học</th>
                                            <th class="text-center" width="15%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($classes as $class)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input class-checkbox" type="checkbox" name="class_ids[]" value="{{ $class->id }}">
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark">{{ $class->class_code }}</span></td>
                                            <td>{{ $class->class_name }}</td>
                                            <td>
                                                @if($class->teacherWithUser && $class->teacherWithUser->user)
                                                    <div class="d-flex align-items-center">
                                                        @if($class->teacherWithUser->user->avatar)
                                                            <img src="{{ asset('storage/avatars/'.$class->teacherWithUser->user->avatar) }}"
                                                                alt="{{ $class->teacherWithUser->user->name }}"
                                                                class="rounded-circle me-2"
                                                                style="width: 38px; height: 38px; object-fit: cover;">
                                                        @else
                                                            <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                                {{ strtoupper(substr($class->teacherWithUser->user->name, 0, 1)) }}
                                                            </span>
                                                        @endif
                                                        <span>{{ $class->teacherWithUser->user->name }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Chưa phân công</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($class->department)
                                                    {{ $class->department->name }}
                                                @else
                                                    <span class="text-muted">Chưa phân công</span>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-info text-white">{{ $class->academic_year }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit Class -->
                                                    <a href="{{ route('admin.class.edit', $class->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    
                                                    <!-- View Class Info -->
                                                    <a href="{{ route('admin.class.show', $class->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Delete Class -->
                                                    <a href="#" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteConfirmModal"
                                                        data-class-id="{{ $class->id }}"
                                                        data-class-name="{{ $class->class_name }}"
                                                        data-delete-url="{{ route('admin.class.destroy', $class->id) }}"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">Không có dữ liệu lớp học</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>
                        
                        <nav aria-label="Pagination" class="my-5">
                            <ul class="pagination mb-0">
                                @if ($classes->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $classes->previousPageUrl() }}">‹</a></li>
                                @endif

                                @foreach ($classes->links()->elements as $element)
                                    @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $classes->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                    @endif
                                @endforeach

                                @if ($classes->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $classes->nextPageUrl() }}">›</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">›</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Xác nhận xóa lớp học -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa lớp học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa lớp học <strong id="deleteClassName"></strong>?</p>
                <p class="text-danger">Lưu ý: Việc xóa lớp học có thể ảnh hưởng đến dữ liệu liên quan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteClassForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa lớp học</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa nhiều lớp học -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa nhiều lớp học</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <strong id="selectedClassCount"></strong> lớp học đã chọn?</p>
                <p class="text-danger">Lưu ý: Việc xóa lớp học có thể ảnh hưởng đến dữ liệu liên quan và không thể khôi phục.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" id="confirm-bulk-delete" class="btn btn-danger">Xóa lớp học</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Xóa đơn lẻ
        const deleteModal = document.getElementById('deleteConfirmModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const classId = button.getAttribute('data-class-id');
                const className = button.getAttribute('data-class-name');
                const deleteUrl = button.getAttribute('data-delete-url');
                
                const classNameElement = deleteModal.querySelector('#deleteClassName');
                if (classNameElement) {
                    classNameElement.textContent = className;
                }
                
                const deleteForm = deleteModal.querySelector('#deleteClassForm');
                if (deleteForm) {
                    deleteForm.action = deleteUrl;
                }
            });
        }
        
        // Xử lý checkbox và xóa hàng loạt
        const selectAll = document.getElementById('select-all');
        const classCheckboxes = document.querySelectorAll('.class-checkbox');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
        const bulkDeleteForm = document.getElementById('bulk-delete-form');
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        const confirmBulkDeleteBtn = document.getElementById('confirm-bulk-delete');
        const selectedClassCountElement = document.getElementById('selectedClassCount');
        
        // Chọn tất cả
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const isChecked = this.checked;
                
                classCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                
                updateBulkDeleteButton();
            });
        }
        
        // Cập nhật trạng thái của nút xóa hàng loạt
        function updateBulkDeleteButton() {
            const checkedCount = document.querySelectorAll('.class-checkbox:checked').length;
            
            if (bulkDeleteBtn) {
                bulkDeleteBtn.disabled = checkedCount === 0;
                bulkDeleteBtn.innerHTML = `<i class="bi bi-trash me-2"></i>Xóa đã chọn (${checkedCount})`;
            }
        }
        
        // Bắt sự kiện thay đổi của các checkbox đơn lẻ
        classCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkDeleteButton();
                
                // Cập nhật trạng thái của checkbox "Chọn tất cả"
                if (selectAll) {
                    const allChecked = document.querySelectorAll('.class-checkbox:checked').length === classCheckboxes.length;
                    selectAll.checked = allChecked;
                }
            });
        });
        
        // Hiển thị modal xác nhận xóa hàng loạt
        if (bulkDeleteBtn) {
            bulkDeleteBtn.addEventListener('click', function() {
                const checkedCount = document.querySelectorAll('.class-checkbox:checked').length;
                
                if (checkedCount > 0 && selectedClassCountElement) {
                    selectedClassCountElement.textContent = checkedCount;
                    
                    // Hiển thị modal xác nhận
                    const modal = new bootstrap.Modal(bulkDeleteModal);
                    modal.show();
                }
            });
        }
        
        // Xác nhận xóa hàng loạt
        if (confirmBulkDeleteBtn && bulkDeleteForm) {
            confirmBulkDeleteBtn.addEventListener('click', function() {
                bulkDeleteForm.submit();
            });
        }
        
        // Khởi tạo ban đầu
        updateBulkDeleteButton();
    });
</script>
@endsection