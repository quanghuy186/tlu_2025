@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý giảng viên</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item active">Giảng viên</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách giảng viên</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.department.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-building me-2"></i>QL đơn vị
                            </a>
                            <a href="{{ route('admin.teacher.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>Thêm giảng viên
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
                                        <th>Mã GV</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Khoa/Bộ môn</th>
                                        <th>Học hàm/Học vị</th>
                                        <th>Chuyên ngành</th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($teachers as $teacher)
                                    <tr>
                                        <td><span class="badge bg-light text-dark">{{ $teacher->teacher_code ?? 'Chưa cập nhật' }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($teacher->user->avatar)
                                                    <img src="{{ asset('storage/avatars/'.$teacher->user->avatar) }}"
                                                        alt="{{ $teacher->user->name }}"
                                                        class="rounded-circle me-2"
                                                        style="width: 38px; height: 38px; object-fit: cover;">
                                                @else
                                                    <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                                        {{ strtoupper(substr($teacher->user->name, 0, 1)) }}
                                                    </span>
                                                @endif
                                                <span>{{ $teacher->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $teacher->user->email }}</td>
                                        <td>
                                            @if($teacher->department)
                                                {{ $teacher->department->name }}
                                            @else
                                                <span class="text-muted">Chưa phân công</span>
                                            @endif
                                        </td>
                                        <td>{{ $teacher->academic_rank ?? 'Chưa cập nhật' }}</td>
                                        <td>{{ $teacher->specialization ?? 'Chưa cập nhật' }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Edit Teacher -->
                                                <a href="{{ route('admin.teacher.edit', $teacher->id) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                
                                                <!-- View Teacher Info -->
                                                <a href="{{ route('admin.teacher.show', $teacher->id) }}" data-bs-toggle="tooltip" data-bs-title="Xem thông tin" class="btn btn-sm btn-success">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                
                                                <!-- Delete Teacher -->
                                                <a href="#" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteConfirmModal"
                                                    data-teacher-id="{{ $teacher->id }}"
                                                    data-teacher-name="{{ $teacher->user->name }}"
                                                    data-delete-url="{{ route('admin.teacher.destroy', $teacher->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">Không có dữ liệu giảng viên</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4 mb-4">
                            {{ $teachers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Xác nhận xóa giảng viên -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmModalLabel">Xác nhận xóa giảng viên</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa giảng viên <strong id="deleteTeacherName"></strong>?</p>
                <p class="text-danger">Lưu ý: Tài khoản người dùng liên kết với giảng viên này cũng sẽ bị xóa.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteTeacherForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa giảng viên</button>
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
    });
</script>
@endsection