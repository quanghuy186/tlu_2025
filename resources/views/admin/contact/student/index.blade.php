@extends('layouts/admin')

@section('title')
    Quản lý danh bạ sinh viên
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý sinh viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Sinh viên</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sinh viên</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6 class="text-success">{{ $stats['total'] }}</h6>
                                <span class="text-muted small">Sinh viên</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-2 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sinh viên k63</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                {{-- <i class="bi bi-people-fill"></i> --}} K63
                            </div>
                            <div class="ps-3">
                                <h6 class="text-success">{{ $stats['student_k63'] }}</h6>
                                <span class="small">Sinh viên
                                    {{-- {{ $stats['total'] > 0 ? round(($stats['with_manager'] / $stats['total']) * 100, 1) : 0 }}% --}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xxl-2 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sinh viên k64</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                {{-- <i class="bi bi-person-fill"></i> --}} K64
                            </div>
                            <div class="ps-3">
                                <h6 class="text-success">{{ $stats['student_k64'] }}</h6>
                                <span class="text-muted small">Sinh viên</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-2 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sinh viên k65</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                K65
                                {{-- <i class="bi bi-person-fill"></i> --}}
                            </div>
                            <div class="ps-3">
                                <h6 class="text-success">{{ $stats['student_k65'] }}</h6>
                                <span class="text-muted small">Sinh viên</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xxl-2 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số sinh viên k66</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                {{-- <i class="bi bi-person-fill"></i> --}} K66
                            </div>
                            <div class="ps-3">
                                <h6 class="text-success">{{ $stats['student_k66'] }}</h6>
                                <span class="text-muted small">Sinh viên</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-12">
                <!-- Card Tìm kiếm và Lọc -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body mt-3">
                        <form method="GET" action="{{ route('admin.student.index') }}" id="filterForm">
                            <div class="row g-3">
                                <!-- Tìm kiếm -->
                                <div class="col-md-4">
                                    <label for="search" class="form-label">Tìm kiếm</label>
                                    <div class="input-group">
                                        <input type="text" 
                                               class="form-control" 
                                               id="search" 
                                               name="search" 
                                               value="{{ request('search') }}"
                                               placeholder="Mã SV, họ tên, email...">
                                        <button class="btn btn-outline-secondary" type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Lọc theo lớp -->
                                <div class="col-md-2">
                                    <label for="class_id" class="form-label">Lớp</label>
                                    <select class="form-select" id="class_id" name="class_id" onchange="this.form.submit()">
                                        <option value="">Tất cả lớp</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Lọc theo năm nhập học -->
                                <div class="col-md-2">
                                    <label for="enrollment_year" class="form-label">Năm nhập học</label>
                                    <select class="form-select" id="enrollment_year" name="enrollment_year" onchange="this.form.submit()">
                                        <option value="">Tất cả năm</option>
                                        @foreach($enrollmentYears as $year)
                                            <option value="{{ $year }}" {{ request('enrollment_year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Nút reset -->
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('admin.student.index') }}" class="btn btn-secondary btn-sm">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Đặt lại bộ lọc
                                            </a>
                                            <span class="text-muted ms-3">
                                                Tìm thấy {{ $students->total() }} sinh viên
                                            </span>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <!-- Số items mỗi trang -->
                                            <select class="form-select form-select-sm" name="per_page" onchange="this.form.submit()" style="width: auto;">
                                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                            <span class="text-muted align-self-center">Trang</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card Danh sách sinh viên -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách sinh viên</h5>
                        <div class="d-flex gap-2">
                            <button id="bulkDeleteBtn" class="btn btn-danger btn-sm d-none" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                                <i class="bi bi-trash me-2"></i>Xóa đã chọn (<span id="selectedCount">0</span>)
                            </button>
                            <a href="{{ route('admin.class.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-mortarboard-fill me-2"></i>QL lớp học
                            </a>
                            <a href="{{ route('admin.teacher.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-person-badge me-2"></i>QL giảng viên
                            </a>

                             <!-- Dropdown cho Import/Export -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Thêm từ file Excel
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.student.import.form') }}">
                                            <i class="bi bi-upload me-2"></i>Nhập từ Excel
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.student.download-template') }}">
                                            <i class="bi bi-file-earmark-arrow-down me-2"></i>Tải file mẫu
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="{{ route('admin.student.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm sinh viên
                            </a>
                        
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
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50" class="text-center">
                                            <input type="checkbox" class="form-check-input" id="selectAll">
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'student_code', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Mã SV
                                                @if(request('sort_by') == 'student_code')
                                                    <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Họ tên
                                                @if(request('sort_by') == 'name')
                                                    <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Email</th>
                                        <th>Lớp</th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'enrollment_year', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                               class="text-decoration-none text-dark">
                                                Năm nhập học
                                                @if(request('sort_by') == 'enrollment_year')
                                                    <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input student-checkbox" 
                                                   value="{{ $student->id }}" 
                                                   data-student-name="{{ $student->user->name }}"
                                                   data-student-code="{{ $student->student_code ?? 'N/A' }}">
                                        </td>
                                        <td><span class="badge bg-light text-dark">{{ $student->student_code ?? 'Chưa cập nhật' }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($student->user->avatar)
                                                    <img src="{{ asset('storage/avatars/'.$student->user->avatar) }}"
                                                        alt="{{ $student->user->name }}"
                                                        class="rounded-circle me-2"
                                                        style="width: 38px; height: 38px; object-fit: cover;">
                                                @else
                                                    <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                        {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                                <span>{{ $student->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $student->user->email }}</td>
                                        <td>
                                            @if($student->class)
                                                <a href="{{ route('admin.class.show', $student->class_id) }}" data-bs-toggle="tooltip" data-bs-title="Xem lớp" class="text-decoration-none">
                                                    {{ $student->class->class_name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Chưa phân lớp</span>
                                            @endif
                                        </td>
                                        <td>{{ $student->enrollment_year ?? 'Chưa cập nhật' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Edit Student -->
                                                <a href="{{ route('admin.student.edit', $student->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                <!-- View Student Info -->
                                                <a href="{{ route('admin.student.show', $student->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <!-- Delete Student -->
                                                <a href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteConfirmModal"
                                                    data-student-id="{{ $student->id }}"
                                                    data-student-name="{{ $student->user->name }}"
                                                    data-delete-url="{{ route('admin.student.destroy', $student->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-2">Không có dữ liệu sinh viên</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Custom Pagination -->
                        @if ($students->hasPages())
                            <div class="d-flex justify-content-between align-items-center px-3 py-3">
                                <div class="text-muted">
                                    Hiển thị {{ $students->firstItem() }} - {{ $students->lastItem() }} trên tổng {{ $students->total() }} kết quả
                                </div>
                                <nav>
                                    <ul class="pagination mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($students->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">‹</span></li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $students->previousPageUrl() }}" rel="prev">‹</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @foreach ($students->getUrlRange(
                                            max($students->currentPage() - 2, 1),
                                            min($students->currentPage() + 2, $students->lastPage())
                                        ) as $page => $url)
                                            @if ($page == $students->currentPage())
                                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                            @else
                                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach

                                        {{-- Next Page Link --}}
                                        @if ($students->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $students->nextPageUrl() }}" rel="next">›</a>
                                            </li>
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

<!-- Modal Xác nhận xóa sinh viên -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa sinh viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa sinh viên <strong id="deleteStudentName"></strong>?</p>
                <p class="text-danger">Lưu ý: Tài khoản người dùng liên kết với sinh viên này cũng sẽ bị xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteStudentForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa sinh viên</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xác nhận xóa nhiều sinh viên -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkDeleteModalLabel">Xác nhận xóa nhiều sinh viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa <strong id="bulkDeleteCount">0</strong> sinh viên đã chọn?</p>
                <div id="selectedStudentsList" class="mb-3 table-responsive">
                    <!-- Danh sách sinh viên được chọn sẽ được hiển thị ở đây -->
                </div>
                <p class="text-danger">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <strong>Lưu ý:</strong> Hành động này sẽ xóa vĩnh viễn tất cả sinh viên đã chọn và tài khoản người dùng liên kết. Hành động này không thể hoàn tác.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="bulkDeleteForm" action="{{ route('admin.student.bulk-delete') }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <input type="hidden" name="student_ids" id="studentIdsInput">
    <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash me-1"></i>Xóa sinh viên
    </button>
</form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
    // Add this to your JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Delete modal
    const deleteModal = document.getElementById('deleteConfirmModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const studentId = button.getAttribute('data-student-id');
            const studentName = button.getAttribute('data-student-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const studentNameElement = deleteModal.querySelector('#deleteStudentName');
            if (studentNameElement) {
                studentNameElement.textContent = studentName;
            }
            
            const deleteForm = deleteModal.querySelector('#deleteStudentForm');
            if (deleteForm) {
                deleteForm.action = deleteUrl;
            }
        });
    }

    // Xử lý chọn nhiều sinh viên
    const selectAllCheckbox = document.getElementById('selectAll');
    const studentCheckboxes = document.querySelectorAll('.student-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const selectedCountSpan = document.getElementById('selectedCount');
    const bulkDeleteCountSpan = document.getElementById('bulkDeleteCount');
    const selectedStudentsList = document.getElementById('selectedStudentsList');
    const studentIdsInput = document.getElementById('studentIdsInput');

    // Cập nhật trạng thái nút xóa nhiều
    function updateBulkDeleteButton() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (count > 0) {
            bulkDeleteBtn.classList.remove('d-none');
            selectedCountSpan.textContent = count;
            bulkDeleteCountSpan.textContent = count;
            
            // Define studentIds array first
            const studentIds = [];
            
            // Cập nhật danh sách sinh viên được chọn
            let studentsList = '<table class="table table-sm mb-0"><thead><tr><th>Mã SV</th><th>Họ tên</th></tr></thead><tbody>';
            
            checkedBoxes.forEach(function(checkbox) {
                const studentName = checkbox.getAttribute('data-student-name');
                const studentCode = checkbox.getAttribute('data-student-code');
                studentsList += `<tr><td>${studentCode}</td><td>${studentName}</td></tr>`;
                studentIds.push(checkbox.value);
            });
            
            studentsList += '</tbody></table>';
            selectedStudentsList.innerHTML = studentsList;
            
            // Set the input value
            studentIdsInput.value = studentIds.join(',');
        } else {
            bulkDeleteBtn.classList.add('d-none');
        }
    }

    // Chọn/bỏ chọn tất cả
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            studentCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateBulkDeleteButton();
        });
    }

    // Xử lý khi chọn/bỏ chọn từng checkbox
    studentCheckboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Cập nhật trạng thái của checkbox "select all"
            const allChecked = Array.from(studentCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(studentCheckboxes).some(cb => cb.checked);
            
            selectAllCheckbox.checked = allChecked;
            selectAllCheckbox.indeterminate = someChecked && !allChecked;
            
            updateBulkDeleteButton();
        });
    });
    
    // Add form submission handler
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');
    if (bulkDeleteForm) {
        bulkDeleteForm.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Đang xử lý...';
        });
    }
});

    // Auto-submit form on Enter key in search field
    document.getElementById('search').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterForm').submit();
        }
    });
</script>

<style>
    /* Custom styles cho search và filter */
    .form-select:focus,
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    
    .table th a {
        transition: all 0.3s ease;
    }
    
    .table th a:hover {
        color: #0d6efd !important;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .avatar {
        font-weight: 600;
        font-size: 14px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .table-responsive table {
            font-size: 0.875rem;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }

    .info-card .card-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(90deg, #4154f1 0%, #2c7be5 100%);
        color: white;
        font-size: 28px;
    }

    .info-card.revenue-card .card-icon {
        background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    }

    .info-card.customers-card .card-icon {
        background: linear-gradient(90deg, #ffc107 0%, #fd7e14 100%);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
    }

    .form-select:focus,
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(65, 84, 241, 0.25);
        border-color: #4154f1;
    }

    .form-check-input {
        cursor: pointer;
    }

    #selectAll {
        margin-top: 0;
    }

    #selectedStudentsList table {
        font-size: 0.875rem;
    }

    #bulkDeleteModal .modal-body {
        max-height: 500px;
        overflow-y: auto;
    }
</style>
@endsection