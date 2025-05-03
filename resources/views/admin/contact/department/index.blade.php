@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý đơn vị</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Đơn vị</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
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
                                        <th>Tên đơn vị</th>
                                        <th>Mã đơn vị</th>
                                        <th>Trưởng đơn vị</th>
                                        <th>Thông tin liên hệ</th>
                                        <th>Đơn vị cha</th>
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
                                                        {{ $department->name }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td><span class="badge bg-light text-dark">{{ $department->code }}</span></td>
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
                                                        <span>{{ $department->manager->name }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Chưa phân công</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="small">
                                                    @if($department->phone)
                                                        <div><i class="bi bi-telephone-fill text-primary me-1"></i> {{ $department->phone }}</div>
                                                    @endif
                                                    @if($department->email)
                                                        <div><i class="bi bi-envelope-fill text-primary me-1"></i> {{ $department->email }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if($department->parent)
                                                    {{ $department->parent->name }}
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <!-- Edit Department -->
                                                    <a href="{{ route('admin.department.edit', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    
                                                    <!-- View Department Info -->
                                                    <a href="{{ route('admin.department.detail', $department->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    
                                                    <!-- Delete Department -->
                                                    <a href="#" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteConfirmModal"
                                                        data-department-id="{{ $department->id }}"
                                                        data-department-name="{{ $department->name }}"
                                                        data-delete-url="{{ route('admin.department.destroy', $department->id) }}"
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
                </div>
            </div>
            @if ($departments->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        {{-- Liên kết trang trước --}}
                        @if ($departments->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $departments->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        {{-- Các phần tử phân trang --}}
                        @foreach ($departments->getUrlRange(1, $departments->lastPage()) as $page => $url)
                            @if ($page == $departments->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Liên kết trang tiếp theo --}}
                        @if ($departments->hasMorePages())
                            <li><a href="{{ $departments->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
                        @else
                            <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Modal Xác nhận xóa đơn vị -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa đơn vị</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa đơn vị <strong id="deleteDepartmentName"></strong>?</p>
                <p class="text-danger">Lưu ý: Không thể xóa đơn vị có đơn vị con và tài khoản quản lý của đơn vị này cũng sẽ bị xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteDepartmentForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE') <!-- Đây là dòng quan trọng -->
                    <button type="submit" class="btn btn-danger">Xóa đơn vị</button>
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
    });
</script>
@endsection