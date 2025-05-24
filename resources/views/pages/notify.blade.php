@extends('layouts.app')

@section('content')

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Thông báo</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item">Thông báo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Announcement Section -->
<section class="announcement-section">
    <div class="container">
        <!-- Search and Filter -->
        <div class="search-filter-container">
            {{-- <div class="search-box">
                <i class="fas fa-search me-2"></i>
                <input type="text" placeholder="Tìm kiếm thông báo...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div> --}}
            <div class="filter-options">
                <div class="filter-group">
                    <span class="filter-label">Sắp xếp theo:</span>
                    <select class="filter-select">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="az">A-Z</option>
                        <option value="za">Z-A</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Danh mục:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả danh mục</option>
                        <option value="system">Hệ thống</option>
                        <option value="academic">Học tập</option>
                        <option value="events">Sự kiện</option>
                        <option value="admissions">Tuyển sinh</option>
                        <option value="urgent">Khẩn cấp</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Nguồn:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả nguồn</option>
                        <option value="admin">Ban quản trị</option>
                        <option value="faculties">Các khoa</option>
                        <option value="departments">Các phòng ban</option>
                        <option value="student-affairs">Phòng Công tác Sinh viên</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <!-- Featured Announcement -->
                <div class="featured-announcement">
                    <div class="featured-announcement-badge">
                        <i class="fas fa-star me-1"></i> Nổi bật
                    </div>
                    <div class="featured-announcement-image">
                        <img src="https://images2.thanhnien.vn/528068263637045248/2024/1/25/3b690baedbd9a609207c76684a3413d0-65a11b0a7e79d880-17061562931311973368410.jpg" alt="Featured Announcement">
                        <div class="featured-announcement-overlay">
                            <div class="featured-announcement-date">
                                <i class="far fa-calendar-alt me-1"></i> 05/03/2025
                            </div>
                            <h2 class="featured-announcement-title">
                                <a href="#">Thông báo cập nhật hệ thống danh bạ điện tử đợt 1 năm 2025</a>
                            </h2>
                            <div class="featured-announcement-excerpt">
                                Hệ thống danh bạ điện tử Trường Đại học Thủy Lợi sẽ được nâng cấp vào ngày 10/03/2025. Trong thời gian cập nhật, hệ thống sẽ tạm ngưng hoạt động từ 22:00 đến 23:59.
                            </div>
                            <a href="#" class="featured-announcement-button">
                                <i class="fas fa-eye me-1"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Announcements Grid -->
                <div class="row">
                    <!-- Announcement 1 -->
                    @foreach ($notifications as $notification)
                        <div class="col-md-6 mb-4">
                            <div class="announcement-card">
                                <div class="announcement-header">
                                    @if($notification->images)
                                        <img src="{{ asset('storage/' . $notification->images_array[0]) }}" alt="Author">
                                    @else
                                        {{-- <img src="{{ asset('path/to/default-image.jpg') }}" alt="Author"> --}}
                                    @endif
                                    <span class="announcement-category">
                                        @if ($notification->category)
                                            {{ $notification->category->name }}
                                        @else
                                            Chưa phân loại
                                        @endif
                                    </span>
                                </div>

                                <div class="announcement-body">
                                    <div class="announcement-date">
                                        <i class="far fa-calendar-alt"></i> 02/03/2025
                                    </div>
                                    <h3 class="announcement-title">
                                        <a href="#">{{ $notification->title }}</a>
                                    </h3>
                                    <div class="announcement-excerpt">
                                        {{$notification->content}}
                                    </div>
                                    <div class="announcement-footer">
                                        <div class="announcement-author">
                                            <img src="https://via.placeholder.com/100x100?text=PB" alt="Author">
                                            <span>Phòng Công tác Sinh viên</span>
                                        </div>
                                        <a href="#" class="read-more">
                                            Xem thêm <i class="fas fa-arrow-right"></i>
                                        </a>
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

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Danh mục thông báo</h3>
                    <ul class="categories-list">
                        <li><a href="#">Tất cả <span class="badge">48</span></a></li>
                        @foreach ($notification_categories as $category)
                             <li><a href="#">{{ $category->name }}<span class="badge">{{ $category->notifications->count() }}</span></a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Announcements -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Thông báo gần đây</h3>
                    <ul class="recent-posts">
                        @foreach ($notification_latests as $notification)
                            <li class="recent-post-item">
                                <div class="recent-post-image">
                                    @if($notification->images)
                                        <img src="{{ asset('storage/' . $notification->images_array[0]) }}" alt="Author">
                                    @else
                                        {{-- <img src="{{ asset('path/to/default-image.jpg') }}" alt="Author"> --}}
                                    @endif
                                </div>
                                <div class="recent-post-content">
                                    <h5><a href="#">{{ $notification->title }}</a></h5>
                                    <div class="recent-post-date">
                                        <i class="far fa-calendar-alt me-1"></i> {{$notification->created_at}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tags -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Từ khóa phổ biến</h3>
                    <div class="tags">
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Danh bạ</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Cập nhật</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Học phí</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Thi</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Lịch học</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Việc làm</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Hội thảo</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Đào tạo</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Khoa CNTT</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Sinh viên</a>
                        <a href="#" class="badge bg-light text-dark m-1 p-2">Giảng viên</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
