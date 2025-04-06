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
                        <li class="breadcrumb-item active" aria-current="page">Thông báo</li>
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
            <div class="search-box">
                <i class="fas fa-search me-2"></i>
                <input type="text" placeholder="Tìm kiếm thông báo...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div>
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
                        <img src="https://via.placeholder.com/800x400?text=Featured+Announcement" alt="Featured Announcement">
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
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+1" alt="Announcement">
                                <span class="announcement-category">Học tập</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 02/03/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Yêu cầu cập nhật thông tin cá nhân</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Nhằm đảm bảo tính chính xác và cập nhật của thông tin, đề nghị tất cả cán bộ, giảng viên và sinh viên kiểm tra và cập nhật thông tin cá nhân trước ngày 15/03/2025.
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

                    <!-- Announcement 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+2" alt="Announcement">
                                <span class="announcement-category">Hệ thống</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 28/02/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Hướng dẫn sử dụng danh bạ điện tử</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Phòng Công nghệ thông tin đã cập nhật tài liệu hướng dẫn sử dụng hệ thống danh bạ điện tử mới. Mời các bạn sinh viên và cán bộ giảng viên tham khảo.
                                </div>
                                <div class="announcement-footer">
                                    <div class="announcement-author">
                                        <img src="https://via.placeholder.com/100x100?text=IT" alt="Author">
                                        <span>Phòng CNTT</span>
                                    </div>
                                    <a href="#" class="read-more">
                                        Xem thêm <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Announcement 3 -->
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+3" alt="Announcement">
                                <span class="announcement-category">Khẩn cấp</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 25/02/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Cảnh báo bảo mật thông tin cá nhân</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Gần đây xuất hiện một số trường hợp lừa đảo qua điện thoại. Nhà trường khuyến cáo cán bộ, giảng viên và sinh viên cẩn trọng khi chia sẻ thông tin cá nhân.
                                </div>
                                <div class="announcement-footer">
                                    <div class="announcement-author">
                                        <img src="https://via.placeholder.com/100x100?text=BGH" alt="Author">
                                        <span>Ban Giám hiệu</span>
                                    </div>
                                    <a href="#" class="read-more">
                                        Xem thêm <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Announcement 4 -->
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+4" alt="Announcement">
                                <span class="announcement-category">Sự kiện</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 20/02/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Hội thảo giới thiệu các công ty tuyển dụng 2025</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Trường Đại học Thủy Lợi tổ chức Hội thảo giới thiệu việc làm và các công ty tuyển dụng dành cho sinh viên chuẩn bị tốt nghiệp vào ngày 15/03/2025 tại Hội trường C2.
                                </div>
                                <div class="announcement-footer">
                                    <div class="announcement-author">
                                        <img src="https://via.placeholder.com/100x100?text=DTN" alt="Author">
                                        <span>Đoàn Thanh niên</span>
                                    </div>
                                    <a href="#" class="read-more">
                                        Xem thêm <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Announcement 5 -->
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+5" alt="Announcement">
                                <span class="announcement-category">Học tập</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 15/02/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Thông báo lịch thi học kỳ II năm học 2024-2025</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Phòng Đào tạo thông báo lịch thi kết thúc học phần học kỳ II năm học 2024-2025. Sinh viên truy cập hệ thống để xem lịch thi chi tiết.
                                </div>
                                <div class="announcement-footer">
                                    <div class="announcement-author">
                                        <img src="https://via.placeholder.com/100x100?text=PDT" alt="Author">
                                        <span>Phòng Đào tạo</span>
                                    </div>
                                    <a href="#" class="read-more">
                                        Xem thêm <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Announcement 6 -->
                    <div class="col-md-6 mb-4">
                        <div class="announcement-card">
                            <div class="announcement-header">
                                <img src="https://via.placeholder.com/600x300?text=Announcement+6" alt="Announcement">
                                <span class="announcement-category">Tuyển sinh</span>
                            </div>
                            <div class="announcement-body">
                                <div class="announcement-date">
                                    <i class="far fa-calendar-alt"></i> 10/02/2025
                                </div>
                                <h3 class="announcement-title">
                                    <a href="#">Thông tin tuyển sinh đại học năm 2025</a>
                                </h3>
                                <div class="announcement-excerpt">
                                    Trường Đại học Thủy Lợi công bố kế hoạch tuyển sinh đại học chính quy năm 2025. Các thông tin về ngành tuyển sinh, chỉ tiêu và phương thức xét tuyển.
                                </div>
                                <div class="announcement-footer">
                                    <div class="announcement-author">
                                        <img src="https://via.placeholder.com/100x100?text=TS" alt="Author">
                                        <span>Ban Tuyển sinh</span>
                                    </div>
                                    <a href="#" class="read-more">
                                        Xem thêm <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <li><a href="#">Hệ thống <span class="badge">12</span></a></li>
                        <li><a href="#">Học tập <span class="badge">15</span></a></li>
                        <li><a href="#">Sự kiện <span class="badge">9</span></a></li>
                        <li><a href="#">Tuyển sinh <span class="badge">7</span></a></li>
                        <li><a href="#">Khẩn cấp <span class="badge">5</span></a></li>
                    </ul>
                </div>

                <!-- Recent Announcements -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Thông báo gần đây</h3>
                    <ul class="recent-posts">
                        <li class="recent-post-item">
                            <div class="recent-post-image">
                                <img src="https://via.placeholder.com/100x100?text=Recent+1" alt="Recent Announcement">
                            </div>
                            <div class="recent-post-content">
                                <h5><a href="#">Thông báo cập nhật hệ thống danh bạ điện tử</a></h5>
                                <div class="recent-post-date">
                                    <i class="far fa-calendar-alt me-1"></i> 05/03/2025
                                </div>
                            </div>
                        </li>
                        <li class="recent-post-item">
                            <div class="recent-post-image">
                                <img src="https://via.placeholder.com/100x100?text=Recent+2" alt="Recent Announcement">
                            </div>
                            <div class="recent-post-content">
                                <h5><a href="#">Yêu cầu cập nhật thông tin cá nhân</a></h5>
                                <div class="recent-post-date">
                                    <i class="far fa-calendar-alt me-1"></i> 02/03/2025
                                </div>
                            </div>
                        </li>
                        <li class="recent-post-item">
                            <div class="recent-post-image">
                                <img src="https://via.placeholder.com/100x100?text=Recent+3" alt="Recent Announcement">
                            </div>
                            <div class="recent-post-content">
                                <h5><a href="#">Hướng dẫn sử dụng danh bạ điện tử</a></h5>
                                <div class="recent-post-date">
                                    <i class="far fa-calendar-alt me-1"></i> 28/02/2025
                                </div>
                            </div>
                        </li>
                        <li class="recent-post-item">
                            <div class="recent-post-image">
                                <img src="https://via.placeholder.com/100x100?text=Recent+4" alt="Recent Announcement">
                            </div>
                            <div class="recent-post-content">
                                <h5><a href="#">Cảnh báo bảo mật thông tin cá nhân</a></h5>
                                <div class="recent-post-date">
                                    <i class="far fa-calendar-alt me-1"></i> 25/02/2025
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Subscribe -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Đăng ký nhận thông báo</h3>
                    <p>Đăng ký nhận thông báo mới nhất qua email.</p>
                    <form class="subscribe-form">
                        <input type="email" placeholder="Nhập email của bạn">
                        <button type="submit"><i class="fas fa-paper-plane"></i></button>
                    </form>
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
