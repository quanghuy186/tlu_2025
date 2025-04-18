<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh bạ Cán bộ Giảng viên - Đại học Thủy Lợi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005baa;
            --secondary-color: #00a8e8;
            --accent-color: #ff5722;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --text-color: #333;
            --bg-color: #f5f7fa;
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: var(--bg-color);
            line-height: 1.6;
        }

        /* Header Styles */
        .top-bar {
            background-color: var(--primary-color);
            color: white;
            padding: 8px 0;
            font-size: 0.9rem;
        }

        .top-bar a {
            color: white;
            text-decoration: none;
        }

        .top-bar a:hover {
            text-decoration: underline;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
        }

        .navbar-brand img {
            height: 50px;
        }

        .navbar .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .navbar .nav-link:hover, .navbar .nav-link.active {
            color: var(--primary-color);
        }

        .navbar .user-menu {
            background-color: var(--primary-color);
            color: white;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar .user-menu:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        /* Page Title */
        .page-title {
            background-color: var(--primary-color);
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
        }

        .page-title h1 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-title .breadcrumb {
            background: transparent;
            margin-bottom: 0;
            padding: 0;
        }

        .page-title .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .page-title .breadcrumb-item a:hover {
            color: white;
        }

        .page-title .breadcrumb-item.active {
            color: white;
        }

        .page-title .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Search and Filter Section */
        .search-filter-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            display: flex;
            align-items: center;
            background-color: var(--light-color);
            border-radius: 50px;
            padding: 5px 20px;
            margin-bottom: 20px;
        }

        .search-box input {
            flex: 1;
            border: none;
            padding: 10px;
            outline: none;
            background-color: transparent;
        }

        .search-box button {
            background: none;
            border: none;
            color: var(--primary-color);
            cursor: pointer;
            padding: 10px;
        }

        .filter-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
        }

        .filter-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-right: 5px;
        }

        .filter-select {
            padding: 8px 15px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            background-color: white;
            color: var(--text-color);
            font-size: 0.9rem;
            min-width: 150px;
        }

        /* Teacher List */
        .teacher-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .teacher-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .teacher-count {
            font-weight: 600;
            color: var(--dark-color);
        }

        .view-options button {
            background-color: var(--light-color);
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            margin-left: 10px;
            color: var(--dark-color);
            cursor: pointer;
            transition: all 0.3s;
        }

        .view-options button.active, .view-options button:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .teacher-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .teacher-item:hover {
            background-color: var(--light-color);
        }

        .teacher-item:last-child {
            border-bottom: none;
        }

        .teacher-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .teacher-info {
            flex: 1;
        }

        .teacher-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .teacher-position {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .teacher-department {
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .teacher-department a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .teacher-department a:hover {
            text-decoration: underline;
        }

        .teacher-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            background-color: var(--primary-color);
            transition: all 0.3s;
            text-decoration: none;
        }

        .action-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .pagination a:hover, .pagination a.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        /* Modal styles */
        .modal-content {
            border-radius: 10px;
            overflow: hidden;
            border: none;
        }

        .modal-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 30px;
        }

        .teacher-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .teacher-detail-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .teacher-detail-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            text-align: center;
        }

        .teacher-detail-position {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .teacher-detail-info {
            width: 100%;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .teacher-detail-info li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .teacher-detail-info li:last-child {
            border-bottom: none;
        }

        .teacher-detail-info i {
            color: var(--primary-color);
            width: 30px;
            font-size: 1.1rem;
        }

        .detail-label {
            font-weight: 600;
            width: 120px;
            color: var(--dark-color);
        }

        .detail-value {
            flex: 1;
        }

        .detail-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .detail-value a:hover {
            text-decoration: underline;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 30px 30px;
        }

        /* Access Denied */
        .access-denied {
            background-color: white;
            border-radius: 10px;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 30px 0;
        }

        .access-denied i {
            font-size: 5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
        }

        .access-denied h2 {
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .access-denied p {
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filter-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-group {
                width: 100%;
                margin-bottom: 10px;
            }

            .filter-select {
                width: 100%;
            }

            .teacher-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .teacher-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .teacher-actions {
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span><i class="fas fa-envelope me-2"></i> info@tlu.edu.vn</span>
                    <span class="ms-3"><i class="fas fa-phone me-2"></i> (024) 3852 2201</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="me-3"><i class="fas fa-globe me-1"></i> tlu.edu.vn</a>
                    <a href="#"><i class="fas fa-map-marker-alt me-1"></i> 175 Tây Sơn, Đống Đa, Hà Nội</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://via.placeholder.com/200x50?text=TLU+Logo" alt="Logo TLU">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Danh bạ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('message.index') }}">Tin nhắn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('forum.index') }}">Diễn đàn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notification.index') }}">Thông báo</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://via.placeholder.com/100x100?text=User" alt="User Avatar" class="user-avatar">
                        <span>Nguyễn Văn A</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">Thông tin tài khoản</li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Cài đặt tài khoản</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> Thông báo</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Title -->
    <section class="page-title">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Danh bạ Cán bộ Giảng viên</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh bạ Cán bộ Giảng viên</li>
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
                <input type="text" placeholder="Tìm kiếm theo tên, chức vụ hoặc mã cán bộ...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="filter-options">
                <div class="filter-group">
                    <span class="filter-label">Sắp xếp theo:</span>
                    <select class="filter-select">
                        <option value="name">Tên (A-Z)</option>
                        <option value="name-desc">Tên (Z-A)</option>
                        <option value="position">Chức vụ</option>
                        <option value="department">Đơn vị</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Đơn vị:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả đơn vị</option>
                        <option value="cntt">Khoa Công nghệ thông tin</option>
                        <option value="kinhte">Khoa Kinh tế và Quản lý</option>
                        <option value="xaydung">Khoa Xây dựng</option>
                        <option value="moitruong">Khoa Môi trường</option>
                        <option value="dientapthu">Khoa Điện - Tự động hóa</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Chức vụ:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả chức vụ</option>
                        <option value="truongkhoa">Trưởng khoa</option>
                        <option value="phongkhoa">Phó trưởng khoa</option>
                        <option value="truongbomon">Trưởng bộ môn</option>
                        <option value="giangvien">Giảng viên</option>
                        <option value="trogiang">Trợ giảng</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Teacher List -->
        <div class="teacher-list-container">
            <div class="teacher-list-header">
                <div class="teacher-count">
                    Hiển thị <span class="text-primary">1-10</span> trong tổng số <span class="text-primary">153</span> Cán bộ Giảng viên
                </div>
                <div class="view-options">
                    <button type="button" class="active"><i class="fas fa-list"></i></button>
                    <button type="button"><i class="fas fa-th-large"></i></button>
                </div>
            </div>

            <!-- Teacher List Items -->
            <div class="teacher-list">
                <!-- Teacher Item 1 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV1" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">PGS.TS. Nguyễn Văn An</div>
                        <div class="teacher-position">Trưởng khoa</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 2 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV2" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">TS. Trần Thị Bình</div>
                        <div class="teacher-position">Phó Trưởng khoa</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 3 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV3" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">TS. Lê Văn Cường</div>
                        <div class="teacher-position">Trưởng Bộ môn Công nghệ phần mềm</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal3">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 4 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV4" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">ThS. Phạm Thị Dung</div>
                        <div class="teacher-position">Giảng viên</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal4">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 5 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV5" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">TS. Hoàng Văn Em</div>
                        <div class="teacher-position">Trưởng Bộ môn Hệ thống thông tin</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal5">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 6 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV6" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">TS. Vũ Thị Phương</div>
                        <div class="teacher-position">Giảng viên</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Teacher Item 7 -->
                <div class="teacher-item">
                    <img src="https://via.placeholder.com/150x150?text=GV7" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">ThS. Đặng Quốc Minh</div>
                        <div class="teacher-position">Giảng viên</div>
                        <div class="teacher-department">Đơn vị: <a href="#">Khoa Công nghệ thông tin</a></div>
                    </div>
                    <div class="teacher-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- More teacher items can be added here -->
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

    <!-- Access Denied - For Student Access (Hidden by default) -->
    <div class="container mb-5" id="student-access" style="display: none;">
        <div class="access-denied">
            <i class="fas fa-lock"></i>
            <h2>Quyền truy cập bị hạn chế</h2>
            <p>Bạn không có quyền truy cập vào danh bạ Cán bộ Giảng viên. Chỉ Cán bộ Giảng viên mới có thể truy cập vào phần này.</p>
            <a href="#" class="btn btn-primary">Quay lại trang chủ</a>
        </div>
    </div>

    <!-- Teacher Detail Modal 1 -->
    <div class="modal fade" id="teacherDetailModal1" tabindex="-1" aria-labelledby="teacherDetailModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherDetailModalLabel1">Thông tin Cán bộ Giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="teacher-detail">
                        <img src="https://via.placeholder.com/250x250?text=GV1" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">PGS.TS. Nguyễn Văn An</div>
                        <div class="teacher-detail-position">Trưởng khoa</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">CB12345678</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">nguyenvanan@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">024.3852.2201 (máy lẻ: 123)</span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Đơn vị:</span>
                                <span class="detail-value"><a href="#">Khoa Công nghệ thông tin</a></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Phòng 305, Tầng 3, Nhà C1, TLU</span>
                            </li>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <span class="detail-label">Chuyên môn:</span>
                                <span class="detail-value">Trí tuệ nhân tạo, Khoa học dữ liệu</span>
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

    <!-- Teacher Detail Modal 2 -->
    <div class="modal fade" id="teacherDetailModal2" tabindex="-1" aria-labelledby="teacherDetailModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherDetailModalLabel2">Thông tin Cán bộ Giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="teacher-detail">
                        <img src="https://via.placeholder.com/250x250?text=GV2" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">TS. Trần Thị Bình</div>
                        <div class="teacher-detail-position">Phó Trưởng khoa</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">CB12345679</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">tranthib@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">024.3852.2201 (máy lẻ: 124)</span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Đơn vị:</span>
                                <span class="detail-value"><a href="#">Khoa Công nghệ thông tin</a></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Phòng 306, Tầng 3, Nhà C1, TLU</span>
                            </li>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <span class="detail-label">Chuyên môn:</span>
                                <span class="detail-value">Công nghệ phần mềm, Học máy</span>
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

    <!-- Teacher Detail Modal 3 -->
    <div class="modal fade" id="teacherDetailModal3" tabindex="-1" aria-labelledby="teacherDetailModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherDetailModalLabel3">Thông tin Cán bộ Giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="teacher-detail">
                        <img src="https://via.placeholder.com/250x250?text=GV3" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">TS. Lê Văn Cường</div>
                        <div class="teacher-detail-position">Trưởng Bộ môn Công nghệ phần mềm</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">CB12345680</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">levanc@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">024.3852.2201 (máy lẻ: 125)</span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Đơn vị:</span>
                                <span class="detail-value"><a href="#">Khoa Công nghệ thông tin</a></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Phòng 308, Tầng 3, Nhà C1, TLU</span>
                            </li>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <span class="detail-label">Chuyên môn:</span>
                                <span class="detail-value">Công nghệ phần mềm, Kiểm thử phần mềm</span>
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

    <!-- Teacher Detail Modal 4 -->
    <div class="modal fade" id="teacherDetailModal4" tabindex="-1" aria-labelledby="teacherDetailModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherDetailModalLabel4">Thông tin Cán bộ Giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="teacher-detail">
                        <img src="https://via.placeholder.com/250x250?text=GV4" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">ThS. Phạm Thị Dung</div>
                        <div class="teacher-detail-position">Giảng viên</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">CB12345681</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">phamthid@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">024.3852.2201 (máy lẻ: 126)</span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Đơn vị:</span>
                                <span class="detail-value"><a href="#">Khoa Công nghệ thông tin</a></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Phòng 310, Tầng 3, Nhà C1, TLU</span>
                            </li>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <span class="detail-label">Chuyên môn:</span>
                                <span class="detail-value">Lập trình web, Cơ sở dữ liệu</span>
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

    <!-- Teacher Detail Modal 5 -->
    <div class="modal fade" id="teacherDetailModal5" tabindex="-1" aria-labelledby="teacherDetailModalLabel5" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teacherDetailModalLabel5">Thông tin Cán bộ Giảng viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="teacher-detail">
                        <img src="https://via.placeholder.com/250x250?text=GV5" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">TS. Hoàng Văn Em</div>
                        <div class="teacher-detail-position">Trưởng Bộ môn Hệ thống thông tin</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">CB12345682</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">hoangvane@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">024.3852.2201 (máy lẻ: 127)</span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Đơn vị:</span>
                                <span class="detail-value"><a href="#">Khoa Công nghệ thông tin</a></span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Phòng 309, Tầng 3, Nhà C1, TLU</span>
                            </li>
                            <li>
                                <i class="fas fa-briefcase"></i>
                                <span class="detail-label">Chuyên môn:</span>
                                <span class="detail-value">Hệ thống thông tin, Phân tích dữ liệu</span>
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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-about">
                        <img src="https://via.placeholder.com/200x50?text=TLU+Logo" alt="Logo TLU" class="img-fluid">
                        <p>Danh bạ điện tử Trường Đại học Thủy Lợi cung cấp thông tin liên lạc chính thức của các đơn vị, cán bộ, giảng viên và sinh viên trong trường, đảm bảo tính bảo mật và chính xác.</p>
                        <div class="social-links">
                            <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="me-2"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <div class="footer-links">
                        <h5 class="footer-title">Liên kết nhanh</h5>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Trang chủ</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Đơn vị</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Giảng viên</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Sinh viên</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Thông báo</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Liên hệ</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-2">
                    <div class="footer-links">
                        <h5 class="footer-title">Người dùng</h5>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Tài khoản</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Đổi mật khẩu</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Quản lý thông tin</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Cập nhật liên hệ</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Trợ giúp</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Chính sách bảo mật</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="footer-contact">
                        <h5 class="footer-title">Liên hệ</h5>
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>175 Tây Sơn, Đống Đa, Hà Nội</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-phone-alt"></i>
                            <span>(024) 3852 2201</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-envelope"></i>
                            <span>info@tlu.edu.vn</span>
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-globe"></i>
                            <span>www.tlu.edu.vn</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="mb-0">© 2025 Trường Đại học Thủy Lợi. Bản quyền thuộc về Đại học Thủy Lợi.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap & JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Đây là nơi để thiết lập logic hiển thị quyền truy cập phù hợp
            // Đoạn code bên dưới có thể được sửa đổi dựa trên logic xác thực thực tế

            // Ví dụ: Kiểm tra vai trò người dùng
            const userRole = 'cbgv'; // Giả sử vai trò là 'cbgv' hoặc 'student'

            // Hiển thị nội dung phù hợp dựa trên vai trò
            if (userRole === 'cbgv') {
                document.getElementById('cbgv-access').style.display = 'block';
                document.getElementById('student-access').style.display = 'none';
            } else if (userRole === 'student') {
                document.getElementById('cbgv-access').style.display = 'none';
                document.getElementById('student-access').style.display = 'block';
            }

            // Khởi tạo tooltips nếu cần
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Xử lý sự kiện tìm kiếm
            const searchInput = document.querySelector('.search-box input');
            const searchButton = document.querySelector('.search-box button');

            searchButton.addEventListener('click', function() {
                const searchValue = searchInput.value.trim().toLowerCase();
                searchTeachers(searchValue);
            });

            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    const searchValue = searchInput.value.trim().toLowerCase();
                    searchTeachers(searchValue);
                }
            });

            // Hàm tìm kiếm giảng viên (mô phỏng)
            function searchTeachers(query) {
                console.log('Tìm kiếm giảng viên với từ khóa:', query);
                // Thực hiện logic tìm kiếm thực tế ở đây
                // Ví dụ: gửi AJAX request đến server
            }

            // Xử lý sự kiện thay đổi bộ lọc
            const filterSelects = document.querySelectorAll('.filter-select');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    applyFilters();
                });
            });

            // Hàm áp dụng bộ lọc (mô phỏng)
            function applyFilters() {
                const sortBy = document.querySelector('select[class="filter-select"]:nth-child(1)').value;
                const department = document.querySelector('select[class="filter-select"]:nth-child(2)').value;
                const position = document.querySelector('select[class="filter-select"]:nth-child(3)').value;

                console.log('Áp dụng bộ lọc:', { sortBy, department, position });
                // Thực hiện logic lọc thực tế ở đây
            }

            // Xử lý chuyển đổi kiểu xem
            const viewButtons = document.querySelectorAll('.view-options button');
            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    viewButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Thay đổi kiểu xem (danh sách hoặc lưới)
                    const isList = this.querySelector('i').classList.contains('fa-list');
                    if (isList) {
                        document.querySelector('.teacher-list').classList.remove('grid-view');
                    } else {
                        document.querySelector('.teacher-list').classList.add('grid-view');
                    }
                });
            });
        });
    </script>
</body>
</html>
