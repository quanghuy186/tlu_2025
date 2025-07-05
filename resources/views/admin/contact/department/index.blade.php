@extends('layouts/admin')

@section('title')
    Quản lý danh bạ đơn vị
@endsection

@section('content')

<div class="pagetitle">
    <h1>Quản lý đơn vị</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
            <li class="breadcrumb-item">Quản lý đơn vị</li>
            <li class="breadcrumb-item active">Đơn vị</li>
        </ol>
    </nav>
</div>

<section class="section py-4">
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số đơn vị</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $stats['total'] }}</h6>
                                <span class="text-muted small">đơn vị</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Có người quản lý</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $stats['with_manager'] }}</h6>
                                <span class="text-success small">
                                    {{ $stats['total'] > 0 ? round(($stats['with_manager'] / $stats['total']) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card customers-card">
                    <div class="card-body">
                        <h5 class="card-title">Chưa có người quản lý</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $stats['without_manager'] }}</h6>
                                <span class="text-warning small">
                                    {{ $stats['total'] > 0 ? round(($stats['without_manager'] / $stats['total']) * 100, 1) : 0 }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Đơn vị gốc</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-diagram-3"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $stats['root_departments'] }}</h6>
                                <span class="text-muted small">cấp cao nhất</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách đơn vị</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.user.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-person-circle me-2"></i>QL tài khoản
                            </a>
                            <a href="{{ route('admin.department.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm đơn vị
                            </a>
                        </div>
                    </div>

                    <div class="card-body border-bottom mt-3">
                        <form method="GET" action="{{ route('admin.department.index') }}" id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control" 
                                               placeholder="Tìm kiếm đơn vị, mã, người quản lý..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <select name="parent_filter" class="form-select">
                                        <option value="all" {{ request('parent_filter') == 'all' ? 'selected' : '' }}>Tất cả cấp độ</option>
                                        <option value="root" {{ request('parent_filter') == 'root' ? 'selected' : '' }}>Đơn vị gốc</option>
                                        @foreach($parentDepartments as $parent)
                                            <option value="{{ $parent->id }}" {{ request('parent_filter') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="level_filter" class="form-select">
                                        <option value="all" {{ request('level_filter') == 'all' ? 'selected' : '' }}>Tất cả level</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level }}" {{ request('level_filter') == $level ? 'selected' : '' }}>
                                                Cấp {{ $level }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select name="manager_filter" class="form-select">
                                        <option value="all" {{ request('manager_filter') == 'all' ? 'selected' : '' }}>Tất cả</option>
                                        <option value="has_manager" {{ request('manager_filter') == 'has_manager' ? 'selected' : '' }}>Có người quản lý</option>
                                        <option value="no_manager" {{ request('manager_filter') == 'no_manager' ? 'selected' : '' }}>Chưa có người quản lý</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="bi bi-funnel"></i>
                                        </button>
                                        <a href="{{ route('admin.department.index') }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <label class="form-label me-2 mb-0 text-nowrap">Sắp xếp:</label>
                                        <select name="sort_by" class="form-select form-select-sm">
                                            <option value="level" {{ request('sort_by') == 'level' ? 'selected' : '' }}>Theo cấp độ</option>
                                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Theo tên</option>
                                            <option value="code" {{ request('sort_by') == 'code' ? 'selected' : '' }}>Theo mã</option>
                                            <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Theo ngày tạo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select name="sort_order" class="form-select form-select-sm">
                                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Giảm dần</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <label class="form-label me-2 mb-0 text-nowrap">Hiển thị:</label>
                                        <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        </select>
                                        <span class="ms-2 text-muted small">Trang</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <small class="text-muted">
                                            Hiển thị {{ $departments->firstItem() ?? 0 }} - {{ $departments->lastItem() ?? 0 }} 
                                            trong tổng số {{ $departments->total() }} kết quả
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </form>
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

                        @if($departments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'name', 'sort_order' => request('sort_by') == 'name' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                                   class="text-decoration-none text-dark">
                                                    Tên đơn vị
                                                    @if(request('sort_by') == 'name')
                                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>
                                                <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'code', 'sort_order' => request('sort_by') == 'code' && request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                                                   class="text-decoration-none text-dark">
                                                    Mã đơn vị
                                                    @if(request('sort_by') == 'code')
                                                        <i class="bi bi-arrow-{{ request('sort_order') == 'asc' ? 'up' : 'down' }}"></i>
                                                    @endif
                                                </a>
                                            </th>
                                            <th>Mô tả</th>
                                            <th>Trưởng đơn vị</th>
                                            <th>Thông tin liên hệ</th>
                                            <th>Đơn vị cha</th>
                                            <th>Cấp độ</th>
                                            <th class="text-center" width="15%">Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="ms-{{ $department->level * 3 }}">
                                                            @if($department->children->count() > 0)
                                                                <i class="bi bi-diagram-3 text-primary me-2"></i>
                                                            @else
                                                                <i class="bi bi-building text-secondary me-2"></i>
                                                            @endif
                                                            <span class="fw-medium">{{ $department->name }}</span>
                                                        </span>
                                                    </div>
                                                   
                                                </td>
                                                
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ $department->code }}</span>
                                                </td>

                                                <td>
                                                     @if($department->description)
                                                        <small class="text-muted d-block ms-{{ ($department->level * 3) + 4 }}">
                                                            {{ Str::limit($department->description, 80) }}
                                                        </small>
                                                    @endif
                                                </td>
                                                
                                                <td>
                                                    @if($department->manager)
                                                        <div class="d-flex align-items-center">
                                                            @if($department->manager->avatar)
                                                                <img src="{{ asset('storage/avatars/'.$department->manager->avatar) }}" 
                                                                    alt="{{ $department->manager->name }}" 
                                                                    class="rounded-circle me-2"
                                                                    style="width: 38px; height: 38px; object-fit: cover;">
                                                            @else
                                                                <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                                    {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                                                                </span>
                                                            @endif
                                                            <div>
                                                                <div class="fw-medium">{{ $department->manager->name }}</div>
                                                                <small class="text-muted">{{ $department->manager->email }}</small>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">
                                                            <i class="bi bi-person-dash me-1"></i>Chưa phân công
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="small">
                                                        @if($department->phone)
                                                            <div class="mb-1">
                                                                <i class="bi bi-telephone-fill text-primary me-1"></i> 
                                                                {{ $department->phone }}
                                                            </div>
                                                        @endif
                                                        @if($department->email)
                                                            <div class="mb-1">
                                                                <i class="bi bi-envelope-fill text-primary me-1"></i> 
                                                                {{ $department->email }}
                                                            </div>
                                                        @endif
                                                        @if($department->address)
                                                            <div class="text-muted">
                                                                <i class="bi bi-geo-alt-fill me-1"></i>
                                                                {{ Str::limit($department->address, 30) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($department->parent)
                                                        <span class="badge bg-secondary">{{ $department->parent->name }}</span>
                                                    @else
                                                        <span class="badge bg-success">Đơn vị gốc</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">Cấp {{ $department->level }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('admin.department.edit', $department->id) }}" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-title="Chỉnh sửa" 
                                                           class="btn btn-sm btn-primary">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('admin.department.detail', $department->id) }}" 
                                                           data-bs-toggle="tooltip" 
                                                           data-bs-title="Xem chi tiết" 
                                                           class="btn btn-sm btn-success">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        
                                                        <button type="button"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteConfirmModal"
                                                                data-department-id="{{ $department->id }}"
                                                                data-department-name="{{ $department->name }}"
                                                                data-delete-url="{{ route('admin.department.destroy', $department->id) }}"
                                                                data-bs-toggle-tooltip
                                                                data-bs-title="Xóa đơn vị"
                                                                class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($departments->hasPages())
                                <div class="d-flex justify-content-between align-items-center p-3">
                                    <div class="text-muted small">
                                        Hiển thị {{ $departments->firstItem() }} - {{ $departments->lastItem() }} 
                                        trong tổng số {{ $departments->total() }} kết quả
                                    </div>
                                    
                                    <nav aria-label="Department pagination">
                                        <ul class="pagination pagination-sm mb-0">
                                            @if ($departments->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $departments->previousPageUrl() }}">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            @foreach ($departments->getUrlRange(max(1, $departments->currentPage() - 2), min($departments->lastPage(), $departments->currentPage() + 2)) as $page => $url)
                                                @if ($page == $departments->currentPage())
                                                    <li class="page-item active">
                                                        <span class="page-link">{{ $page }}</span>
                                                    </li>
                                                @else
                                                    <li class="page-item">
                                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                    </li>
                                                @endif
                                            @endforeach

                                            @if ($departments->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $departments->nextPageUrl() }}">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted">Không tìm thấy đơn vị nào</h5>
                                <p class="text-muted">
                                    @if(request()->hasAny(['search', 'parent_filter', 'level_filter', 'manager_filter']))
                                        Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm
                                    @else
                                        Hãy tạo đơn vị đầu tiên
                                    @endif
                                </p>
                                @if(request()->hasAny(['search', 'parent_filter', 'level_filter', 'manager_filter']))
                                    <a href="{{ route('admin.department.index') }}" class="btn btn-outline-primary">
                                        <i class="bi bi-arrow-clockwise me-1"></i>Xóa bộ lọc
                                    </a>
                                @else
                                    <a href="{{ route('admin.department.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Tạo đơn vị đầu tiên
                                    </a>
                                @endif
                            </div>
                        @endif
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
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa đơn vị</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <i class="bi bi-exclamation-triangle-fill text-warning" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-2">Bạn có chắc chắn muốn xóa đơn vị <strong id="deleteDepartmentName"></strong>?</p>
                        <div class="alert alert-warning mb-0">
                            <small>
                                <strong>Lưu ý:</strong> Không thể xóa đơn vị có đơn vị con và tài khoản quản lý của đơn vị này cũng sẽ bị xóa.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Hủy
                </button>
                <form id="deleteDepartmentForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i>Xóa đơn vị
                    </button>
                </form>
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
            const departmentId = button.getAttribute('data-department-id');
            const departmentName = button.getAttribute('data-department-name');
            const deleteUrl = button.getAttribute('data-delete-url');
            
            const departmentNameElement = deleteModal.querySelector('#deleteDepartmentName');
            if (departmentNameElement) {
                departmentNameElement.textContent = departmentName;
            }
            
            const deleteForm = deleteModal.querySelector('#deleteDepartmentForm');
            if (deleteForm) {
                deleteForm.action = deleteUrl;
            }
        });
    }

    const perPageSelect = document.querySelector('select[name="per_page"]');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    const filterSelects = document.querySelectorAll('#filterForm select:not([name="per_page"]):not([name="sort_by"]):not([name="sort_order"])');
    filterSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });

    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length >= 2 || this.value.length === 0) {
                    document.getElementById('filterForm').submit();
                }
            }, 5000);
        });
    }

   const searchTerm = '{{ request("search") }}';

    if (searchTerm) {
        const escapedTerm = searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp('(' + escapedTerm + ')', 'gi');
        const textNodes = document.querySelectorAll('tbody td');

        textNodes.forEach(function(node) {
            if (node.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                node.innerHTML = node.innerHTML.replace(regex, '<mark class="bg-warning">$1</mark>');
            }
        });
    }


    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            document.querySelector('.table-responsive').scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        });
    });
});

function resetFilters() {
    window.location.href = '{{ route("admin.department.index") }}';
}

function exportData() {
    console.log('Export data functionality');
}
</script>

<style>
.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
    white-space: nowrap;
}

.table th a {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.table td {
    vertical-align: middle;
    border-color: #e9ecef;
}

.badge {
    font-size: 0.75em;
}

.avatar {
    font-size: 0.875rem;
    font-weight: 600;
}

mark {
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
}

/* Responsive table */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .d-none-mobile {
        display: none !important;
    }
}

/* Loading state */
.btn:disabled {
    cursor: not-allowed;
}

/* Custom pagination */
.pagination-sm .page-link {
    padding: 0.375rem 0.75rem;
}

/* Stats cards */
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
</style>
@endsection