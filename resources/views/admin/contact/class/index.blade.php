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
                                        <th>Mã lớp</th>
                                        <th>Tên lớp</th>
                                        <th>Giảng viên phụ trách</th>
                                        <th>Khoa/Bộ môn</th>
                                        <th>Năm học</th>
                                        <th>Học kỳ</th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($classes as $class)
                                    <tr>
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
                                        <td>{{ $class->semester ?? 'Chưa xác định' }}</td>
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
                                        <td colspan="7" class="text-center py-4">Không có dữ liệu lớp học</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- <div class="d-flex justify-content-center mt-4 mb-4">
                            {{ $classes->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
            @if ($classes->hasPages())
                <div class="pagination-container">
                    <ul class="pagination">
                        {{-- Liên kết trang trước --}}
                        @if ($classes->onFirstPage())
                            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                        @else
                            <li><a href="{{ $classes->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                        @endif

                        {{-- Các phần tử phân trang --}}
                        @foreach ($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                            @if ($page == $classes->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Liên kết trang tiếp theo --}}
                        @if ($classes->hasMorePages())
                            <li><a href="{{ $classes->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
                        @else
                            <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            @endif
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
    });
</script>
@endsection