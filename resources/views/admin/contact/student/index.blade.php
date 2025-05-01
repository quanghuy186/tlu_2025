@extends('layouts/admin')

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
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Danh sách sinh viên</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.class.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-mortarboard-fill me-2"></i>QL lớp học
                            </a>
                            <a href="{{ route('admin.teacher.index') }}" class="btn btn-info btn-sm d-flex align-items-center">
                                <i class="bi bi-person-badge me-2"></i>QL giảng viên
                            </a>
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
                                        <th>Mã SV</th>
                                        <th>Họ tên</th>
                                        <th>Email</th>
                                        <th>Lớp</th>
                                        <th>Năm nhập học</th>
                                        <th>Chương trình</th>
                                        <th>Trạng thái</th>
                                        <th class="text-center" width="15%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $student)
                                    <tr>
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
                                        <td>{{ $student->getProgramName() }}</td>
                                        <td>
                                            @php
                                                $statusClass = 'bg-secondary';
                                                if($student->graduation_status == 'studying') $statusClass = 'bg-info';
                                                elseif($student->graduation_status == 'graduated') $statusClass = 'bg-success';
                                                elseif($student->graduation_status == 'suspended') $statusClass = 'bg-warning';
                                                elseif($student->graduation_status == 'dropped') $statusClass = 'bg-danger';
                                            @endphp
                                            <span class="badge {{ $statusClass }} text-white">{{ $student->getGraduationStatusName() }}</span>
                                        </td>
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
                                        <td colspan="8" class="text-center py-4">Không có dữ liệu sinh viên</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4 mb-4">
                            {{ $students->links() }}
                        </div>
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
    });
</script>
@endsection