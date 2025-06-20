{{-- resources/views/admin/contact/teacher/index.blade.php --}}
@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý giảng viên</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý danh bạ</li>
            <li class="breadcrumb-item active">Cán bộ giảng viên</li>
        </ol>
    </nav>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xxl-3 col-md-6">
        <div class="card info-card sales-card">
            <div class="card-body">
                <h5 class="card-title">Tổng số giảng viên</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $stats['total'] }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card info-card revenue-card">
            <div class="card-body">
                <h5 class="card-title">Đã phân công</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $stats['with_department'] }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card info-card customers-card">
            <div class="card-body">
                <h5 class="card-title">Chưa phân công</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $stats['without_department'] }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xxl-3 col-md-6">
        <div class="card info-card">
            <div class="card-body">
                <h5 class="card-title">Mới trong tháng</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="ps-3">
                        <h6>{{ $stats['recent'] }}</h6>
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
                    <div class="card-header bg-white py-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="card-title m-0 fw-bold text-primary">
                                    <i class="bi bi-list-ul me-2"></i>Danh sách giảng viên
                                </h5>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="d-flex gap-2 justify-content-end flex-wrap">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                            <i class="bi bi-file-earmark-excel me-2"></i>Excel
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.teacher.import.form') }}">
                                                    <i class="bi bi-upload me-2"></i>Import từ Excel
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#" onclick="exportTeachers()">
                                                    <i class="bi bi-download me-2"></i>Export ra Excel
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.teacher.download-template') }}">
                                                    <i class="bi bi-file-earmark-arrow-down me-2"></i>Tải file mẫu
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Department Management -->
                                    <a href="{{ route('admin.department.index') }}" 
                                       class="btn btn-info btn-sm d-flex align-items-center">
                                        <i class="bi bi-building me-2"></i>QL đơn vị
                                    </a>
                                    
                                    <!-- Add New Teacher -->
                                    <a href="{{ route('admin.teacher.create') }}" 
                                       class="btn btn-success btn-sm d-flex align-items-center">
                                        <i class="bi bi-plus-circle me-2"></i>Thêm giảng viên
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Advanced Search and Filter Section -->
                        <form method="GET" action="{{ route('admin.teacher.index') }}" class="mt-4" id="filterForm">
                            <div class="row g-3">
                                <!-- Search Input -->
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Tìm kiếm</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" 
                                               class="form-control" 
                                               name="search" 
                                               placeholder="Tên, email, mã GV, chuyên ngành..." 
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                
                                <!-- Department Filter -->
                                <div class="col-md-3">
                                    <label class="form-label small text-muted">Khoa/Bộ môn</label>
                                    <select class="form-select" name="department_id">
                                        <option value="">-- Tất cả khoa/bộ môn --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" 
                                                    {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Academic Rank Filter -->
                                <div class="col-md-2">
                                    <label class="form-label small text-muted">Học hàm/Học vị</label>
                                    <select class="form-select" name="academic_rank">
                                        <option value="">-- Tất cả học hàm --</option>
                                        @foreach($academicRanks as $rank)
                                            <option value="{{ $rank }}" 
                                                    {{ request('academic_rank') == $rank ? 'selected' : '' }}>
                                                {{ $rank }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Status Filter -->
                                <div class="col-md-2">
                                    <label class="form-label small text-muted">Trạng thái</label>
                                    <select class="form-select" name="status">
                                        <option value="">-- Tất cả --</option>
                                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>
                                
                                <!-- Per Page -->
                                <div class="col-md-1">
                                    <label class="form-label small text-muted">Hiển thị</label>
                                    <select class="form-select" name="per_page" onchange="this.form.submit()">
                                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Date Range Filter -->
                            <div class="row g-3 mt-2">
                                {{-- <div class="col-md-2">
                                    <label class="form-label small text-muted">Từ ngày</label>
                                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small text-muted">Đến ngày</label>
                                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                                </div> --}}
                                <div class="col-md-8 d-flex align-items-end">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tìm kiếm
                                        </button>
                                        <a href="{{ route('admin.teacher.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Làm mới
                                        </a>
                                        {{-- <button type="button" class="btn btn-info" onclick="toggleAdvancedFilters()">
                                            <i class="bi bi-funnel"></i> Bộ lọc nâng cao
                                        </button> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="card-body p-0">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <!-- Results Info and Bulk Actions -->
                        <div class="px-3 py-3 bg-light border-bottom">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Hiển thị {{ $teachers->firstItem() ?? 0 }} - {{ $teachers->lastItem() ?? 0 }} 
                                        trong tổng số {{ $teachers->total() }} giảng viên
                                        @if(request('search') || request('department_id') || request('academic_rank'))
                                            (đã lọc)
                                        @endif
                                    </small>
                                </div>
                                
                                <div class="col-md-6 text-end">
                                    <!-- Bulk Actions -->
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <input type="checkbox" id="selectAll" class="form-check-input">
                                        <label for="selectAll" class="form-check-label small">Chọn tất cả</label>
                                        
                                        <button id="bulkDeleteBtn" class="btn btn-danger btn-sm" onclick="bulkAction('delete')">
                                            <i class="bi bi-trash me-2"></i>Xóa đã chọn
                                        </button>   
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50px">
                                            <input type="checkbox" id="selectAllTable" class="form-check-input">
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'teacher_code', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Mã GV
                                                @if(request('sort') == 'teacher_code')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Họ tên
                                                @if(request('sort') == 'name')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Email
                                                @if(request('sort') == 'email')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'department', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Khoa/Bộ môn
                                                @if(request('sort') == 'department')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'academic_rank', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Học hàm/Học vị
                                                @if(request('sort') == 'academic_rank')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ route('admin.teacher.index', array_merge(request()->all(), ['sort' => 'specialization', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="text-decoration-none text-dark">
                                                Chuyên ngành
                                                @if(request('sort') == 'specialization')
                                                    <i class="bi bi-arrow-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input teacher-checkbox" 
                                                   value="{{ $teacher->id }}" name="teacher_ids[]">
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $teacher->teacher_code ?? 'Chưa cập nhật' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($teacher->user->avatar)
                                                    <img src="{{ asset('storage/avatars/'.$teacher->user->avatar) }}"
                                                        alt="{{ $teacher->user->name }}"
                                                        class="rounded-circle me-2"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" 
                                                          style="width: 40px; height: 40px; font-size: 16px;">
                                                        {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $teacher->user->name }}</div>
                                                    @if($teacher->position)
                                                        <small class="text-muted">{{ $teacher->position }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $teacher->user->email }}" class="text-decoration-none">
                                                {{ $teacher->user->email }}
                                            </a>
                                            @if($teacher->user->phone)
                                                <br><small class="text-muted">{{ $teacher->user->phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($teacher->department)
                                                <span class="badge bg-info">{{ $teacher->department->name }}</span>
                                            @else
                                                <span class="badge bg-warning">Chưa phân công</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($teacher->academic_rank)
                                                <span class="badge bg-success">{{ $teacher->academic_rank }}</span>
                                            @else
                                                <span class="text-muted">Chưa cập nhật</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>{{ $teacher->specialization ?? 'Chưa cập nhật' }}</div>
                                            @if($teacher->office_location)
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i> {{ $teacher->office_location }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('admin.teacher.show', $teacher->id) }}" 
                                                   data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <a href="{{ route('admin.teacher.edit', $teacher->id) }}" 
                                                   data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteConfirmModal"
                                                        data-teacher-id="{{ $teacher->id }}"
                                                        data-teacher-name="{{ $teacher->user->name }}"
                                                        data-delete-url="{{ route('admin.teacher.destroy', $teacher->id) }}"
                                                        data-bs-toggle="tooltip" 
                                                        data-bs-title="Xóa">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                                <h5 class="mt-3">Không tìm thấy giảng viên nào</h5>
                                                <p>Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
                                                <a href="{{ route('admin.teacher.create') }}" class="btn btn-success">
                                                    <i class="bi bi-plus-circle me-2"></i>Thêm giảng viên đầu tiên
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="Pagination" class="my-5">
                            <ul class="pagination mb-0">
                                @if ($teachers->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $teachers->previousPageUrl() }}">‹</a></li>
                                @endif

                                @foreach ($teachers->links()->elements as $element)
                                    @if (is_string($element))
                                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $teachers->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                        @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                    @endif
                                @endforeach

                                @if ($teachers->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $teachers->nextPageUrl() }}">›</a></li>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa giảng viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa giảng viên <strong id="deleteTeacherName"></strong>?</p>
                <p class="text-danger"><i class="bi bi-exclamation-triangle me-2"></i>
                    Lưu ý: Tài khoản người dùng liên kết với giảng viên này cũng sẽ bị xóa vĩnh viễn.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteTeacherForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Xóa giảng viên
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Assign Department Modal -->
<div class="modal fade" id="bulkAssignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Phân công khoa/bộ môn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bulkAssignForm" method="POST" action="{{ route('admin.teacher.bulk-action') }}">
                @csrf
                <input type="hidden" name="action" value="assign_department">
                <div class="modal-body">
                    <p>Chọn khoa/bộ môn để phân công cho các giảng viên đã chọn:</p>
                    <select class="form-select" name="department_id" required>
                        <option value="">-- Chọn khoa/bộ môn --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-2"></i>Phân công
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Delete modal functionality
    const deleteModal = document.getElementById('deleteConfirmModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const teacherId = button.getAttribute('data-teacher-id');
            const teacherName = button.getAttribute('data-teacher-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const teacherNameElement = deleteModal.querySelector('#deleteTeacherName');
            if (teacherNameElement) {
                teacherNameElement.textContent = teacherName;
            }
            
            const deleteForm = deleteModal.querySelector('#deleteTeacherForm');
            if (deleteForm) {
                deleteForm.action = deleteUrl;
            }
        });
    }
    
    // Checkbox functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const selectAllTableCheckbox = document.getElementById('selectAllTable');
    const teacherCheckboxes = document.querySelectorAll('.teacher-checkbox');
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    
    // Select all functionality
    if (selectAllCheckbox && selectAllTableCheckbox) {
        [selectAllCheckbox, selectAllTableCheckbox].forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const isChecked = this.checked;
                teacherCheckboxes.forEach(cb => cb.checked = isChecked);
                updateBulkActionButton();
                
                // Sync both select all checkboxes
                selectAllCheckbox.checked = isChecked;
                selectAllTableCheckbox.checked = isChecked;
            });
        });
    }
    
    // Individual checkbox change
    teacherCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionButton();
            updateSelectAllCheckboxes();
        });
    });
    
    function updateBulkActionButton() {
        const checkedCount = document.querySelectorAll('.teacher-checkbox:checked').length;
        if (bulkActionBtn) {
            bulkActionBtn.disabled = checkedCount === 0;
            bulkActionBtn.textContent = checkedCount > 0 ? 
                `Hành động hàng loạt (${checkedCount})` : 
                'Hành động hàng loạt';
        }
    }
    
    function updateSelectAllCheckboxes() {
        const totalCheckboxes = teacherCheckboxes.length;
        const checkedCheckboxes = document.querySelectorAll('.teacher-checkbox:checked').length;
        
        const allChecked = totalCheckboxes > 0 && checkedCheckboxes === totalCheckboxes;
        
        if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
        if (selectAllTableCheckbox) selectAllTableCheckbox.checked = allChecked;
    }
    
    // Live search functionality
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
    }
    
    // Auto-submit when filters change
    const filterSelects = document.querySelectorAll('select[name="department_id"], select[name="academic_rank"], select[name="status"]');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
});

// Bulk actions
function bulkAction(action) {
    const checkedIds = Array.from(document.querySelectorAll('.teacher-checkbox:checked'))
                           .map(cb => cb.value);
    
    if (checkedIds.length === 0) {
        alert('Vui lòng chọn ít nhất một giảng viên');
        return;
    }
    
    if (action === 'delete') {
        if (confirm(`Bạn có chắc chắn muốn xóa ${checkedIds.length} giảng viên đã chọn?`)) {
            submitBulkAction('delete', checkedIds);
        }
    } else if (action === 'export') {
        submitBulkAction('export', checkedIds);
    }
}

function submitBulkAction(action, teacherIds) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.teacher.bulk-action") }}';
    
    // CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Action
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = action;
    form.appendChild(actionInput);
    
    // Teacher IDs
    teacherIds.forEach(id => {
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = 'teacher_ids[]';
        idInput.value = id;
        form.appendChild(idInput);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Bulk assign form submission
document.getElementById('bulkAssignForm')?.addEventListener('submit', function(e) {
    const checkedIds = Array.from(document.querySelectorAll('.teacher-checkbox:checked'))
                           .map(cb => cb.value);
    
    if (checkedIds.length === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất một giảng viên');
        return;
    }
    
    // Add checked IDs to form
    checkedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'teacher_ids[]';
        input.value = id;
        this.appendChild(input);
    });
});

// Advanced filters toggle
function toggleAdvancedFilters() {
    // Implementation for showing/hiding advanced filters
    console.log('Toggle advanced filters');
}
</script>
@endsection