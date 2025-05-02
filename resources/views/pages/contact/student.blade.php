@extends('layouts.app')

@section('content')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Danh bạ Sinh viên</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh bạ Sinh viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content - For CBGV Access -->
<div class="container mb-5" id="cbgv-access">
    <!-- Search and Filter Section -->
    <div class="search-filter-container">
        <div class="search-box">
            <i class="fas fa-search me-2"></i>
            <input type="text" placeholder="Tìm kiếm theo tên, mã sinh viên hoặc lớp...">
            <button type="button"><i class="fas fa-arrow-right"></i></button>
        </div>
        <div class="filter-options">
            <div class="filter-group">
                <span class="filter-label">Sắp xếp theo:</span>
                <select class="filter-select">
                    <option value="name">Tên (A-Z)</option>
                    <option value="name-desc">Tên (Z-A)</option>
                    <option value="id">Mã sinh viên</option>
                    <option value="class">Lớp</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Khoa:</span>
                <select class="filter-select">
                    <option value="all">Tất cả khoa</option>
                    <option value="cntt">Khoa Công nghệ thông tin</option>
                    <option value="kinhte">Khoa Kinh tế và Quản lý</option>
                    <option value="xaydung">Khoa Xây dựng</option>
                    <option value="moitruong">Khoa Môi trường</option>
                    <option value="dientapthu">Khoa Điện - Tự động hóa</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Khóa:</span>
                <select class="filter-select">
                    <option value="all">Tất cả khóa</option>
                    <option value="k60">K60 (2021-2025)</option>
                    <option value="k61">K61 (2022-2026)</option>
                    <option value="k62">K62 (2023-2027)</option>
                    <option value="k63">K63 (2024-2028)</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Lớp:</span>
                <select class="filter-select">
                    <option value="all">Tất cả lớp</option>
                    <option value="60cntt1">60CNTT1</option>
                    <option value="60cntt2">60CNTT2</option>
                    <option value="60cntt3">60CNTT3</option>
                    <option value="60kt1">60KT1</option>
                    <option value="60kt2">60KT2</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Student List -->
    <div class="student-list-container">
        <div class="student-list-header">
            <div class="student-count">
                Hiển thị <span class="text-primary">1-10</span> trong tổng số <span class="text-primary">235</span> Sinh viên
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Student List Items -->
        <div class="student-list">
            <!-- Student Item 1 -->
            @foreach ($students as $student)
                <div class="student-item">
                    <img src="{{ $student->user && $student->user->avatar ? asset('storage/avatars/'.$student->user->avatar) : 'https://via.placeholder.com/150x150?text=SV' }}" 
                        alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">{{ $student->user->name ?? 'Chưa cập nhật' }}</div>
                        <div class="student-id">
                            {{ $student->class ? $student->class->name : 'Chưa cập nhật' }} - 
                            {{ $student->student_code ?? 'Chưa cập nhật' }}
                        </div>
                        <div class="student-class">
                            Lớp: 
                            @if($student->class)
                                <a href="#">{{ $student->student_code ?? 'Chưa cập nhật' }}</a>
                            @else
                                <span>Chưa cập nhật</span>
                            @endif
                            - 
                            @if($student->department)
                                {{ $student->department->name }}
                            @else
                                Chưa cập nhật
                            @endif
                        </div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal{{ $student->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>


                <!-- Student Detail Modal 1 -->
                <div class="modal fade" id="studentDetailModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentDetailModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="studentDetailModalLabel1">Thông tin Sinh viên</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="student-detail">
                                    <img src="{{ $student->user && $student->user->avatar ? asset('storage/avatars/'.$student->user->avatar) : 'https://via.placeholder.com/150x150?text=SV' }}" alt="Sinh viên" class="student-detail-avatar">
                                    <div class="student-detail-name">{{$student->user->name}}</div>
                                    <div class="student-detail-id">{{$student->student_code ?? 'Chưa cập nhật' }} </div>

                                    <ul class="student-detail-info">
                                        <li>
                                            <i class="fas fa-graduation-cap"></i>
                                            <span class="detail-label">Lớp:</span>
                                            <span class="detail-value">{{ $student->class ? $student->class->name : 'Chưa cập nhật' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-user-graduate"></i>
                                            <span class="detail-label">Khóa:</span>
                                            <span class="detail-value">K62 (2023-2027)</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-building"></i>
                                            <span class="detail-label">Khoa:</span>
                                            <span class="detail-value"><a href="#">Công nghệ thông tin</a></span>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i>
                                            <span class="detail-label">Email:</span>
                                            <span class="detail-value">a.nv195106001@tlu.edu.vn</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-phone"></i>
                                            <span class="detail-label">Điện thoại:</span>
                                            <span class="detail-value">0987.654.321</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span class="detail-label">Địa chỉ:</span>
                                            <span class="detail-value">Số 123 Đường ABC, Quận Đống Đa, Hà Nội</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-calendar-alt"></i>
                                            <span class="detail-label">Ngày sinh:</span>
                                            <span class="detail-value">15/03/2004</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-id-card"></i>
                                            <span class="detail-label">CCCD:</span>
                                            <span class="detail-value">001204567890</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <ul class="pagination">
                <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                <li><a href="#" class="active">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
            </ul>
        </div>
    </div>
</div>


@endsection