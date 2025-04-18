<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Đơn vị - Đại học Thủy Lợi</title>
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

        /* Unit Card Styles */
        .unit-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .unit-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .unit-count {
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

        /* Unit List View */
        .unit-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .unit-item:hover {
            background-color: var(--light-color);
        }

        .unit-item:last-child {
            border-bottom: none;
        }

        .unit-logo {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 20px;
            border: 1px solid var(--border-color);
            padding: 5px;
            background-color: white;
        }

        .unit-info {
            flex: 1;
        }

        .unit-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .unit-type {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .unit-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            color: var(--dark-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .unit-meta-item {
            display: flex;
            align-items: center;
        }

        .unit-meta-item i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .unit-actions {
            display: flex;
            gap: 10px;
            align-self: center;
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

        /* Grid View */
        .unit-list.grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .unit-list.grid-view .unit-item {
            flex-direction: column;
            border: 1px solid var(--border-color);
            border-radius: 10px;
        }

        .unit-list.grid-view .unit-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .unit-list.grid-view .unit-info {
            text-align: center;
        }

        .unit-list.grid-view .unit-meta {
            justify-content: center;
        }

        .unit-list.grid-view .unit-actions {
            margin-top: 15px;
            justify-content: center;
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

        .unit-detail {
            display: flex;
            flex-direction: column;
        }

        .unit-detail-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .unit-detail-logo {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 30px;
            border: 3px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 5px;
            background-color: white;
        }

        .unit-detail-title {
            flex: 1;
        }

        .unit-detail-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 5px;
        }

        .unit-detail-type {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .unit-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            font-size: 0.95rem;
        }

        .unit-detail-meta-item {
            display: flex;
            align-items: center;
        }

        .unit-detail-meta-item i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .unit-detail-info {
            margin-bottom: 30px;
        }

        .unit-detail-section {
            margin-bottom: 25px;
        }

        .unit-detail-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
        }

        .unit-detail-description {
            margin-bottom: 20px;
            text-align: justify;
        }

        .leader-list, .staff-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 15px;
        }

        .leader-item, .staff-item {
            display: flex;
            align-items: center;
            width: calc(50% - 10px);
            padding: 10px;
            border-radius: 5px;
            background-color: var(--light-color);
        }

        .leader-avatar, .staff-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid white;
        }

        .leader-info, .staff-info {
            flex: 1;
        }

        .leader-name, .staff-name {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 3px;
        }

        .leader-position, .staff-position {
            font-size: 0.9rem;
            color: var(--accent-color);
        }

        .contact-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-info-item {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .contact-info-item:last-child {
            border-bottom: none;
        }

        .contact-info-item i {
            color: var(--primary-color);
            width: 30px;
            font-size: 1.1rem;
        }

        .contact-label {
            font-weight: 600;
            width: 120px;
            color: var(--dark-color);
        }

        .contact-value {
            flex: 1;
        }

        .contact-value a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .contact-value a:hover {
            text-decoration: underline;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 30px 30px;
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 70px 0 0;
            margin-top: 50px;
        }

        .footer-about img {
            width: 200px;
            margin-bottom: 20px;
        }

        .footer-about p {
            opacity: 0.8;
            margin-bottom: 20px;
        }

        .footer-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 30px;
            height: 2px;
            background-color: var(--accent-color);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-contact i {
            width: 30px;
            color: var(--accent-color);
        }

        .footer-bottom {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
            margin-top: 50px;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .unit-list.grid-view {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
            .leader-item, .staff-item {
                width: 100%;
            }
        }

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

            .unit-item {
                flex-direction: column;
            }

            .unit-logo {
                margin: 0 0 15px 0;
            }

            .unit-detail-header {
                flex-direction: column;
                text-align: center;
            }

            .unit-detail-logo {
                margin: 0 0 15px 0;
            }

            .unit-detail-meta {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
            }

            .page-title h1 {
                font-size: 1.8rem;
            }

            .unit-list-header {
                flex-direction: column;
                gap: 10px;
            }

            .view-options {
                align-self: flex-end;
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
                    <h1>Danh sách Đơn vị</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Đơn vị</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mb-5">
        <!-- Search and Filter Section -->
        <div class="search-filter-container">
            <div class="search-box">
                <i class="fas fa-search me-2"></i>
                <input type="text" placeholder="Tìm kiếm tên đơn vị, phòng ban...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="filter-options">
                <div class="filter-group">
                    <span class="filter-label">Sắp xếp theo:</span>
                    <select class="filter-select">
                        <option value="name">Tên (A-Z)</option>
                        <option value="name-desc">Tên (Z-A)</option>
                        <option value="type">Loại đơn vị</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Loại đơn vị:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả</option>
                        <option value="academic">Đơn vị đào tạo</option>
                        <option value="research">Đơn vị nghiên cứu</option>
                        <option value="administrative">Đơn vị hành chính</option>
                        <option value="service">Đơn vị dịch vụ</option>
                    </select>
                </div>
                <div class="filter-group">
                    <span class="filter-label">Cơ sở:</span>
                    <select class="filter-select">
                        <option value="all">Tất cả</option>
                        <option value="hanoi">Hà Nội</option>
                        <option value="phuly">Phủ Lý</option>
                        <option value="tphcm">TP. Hồ Chí Minh</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Unit List -->
        <div class="unit-list-container">
            <div class="unit-list-header">
                <div class="unit-count">
                    Hiển thị <span class="text-primary">1-10</span> trong tổng số <span class="text-primary">25</span> Đơn vị
                </div>
                <div class="view-options">
                    <button type="button" class="active"><i class="fas fa-list"></i></button>
                    <button type="button"><i class="fas fa-th-large"></i></button>
                </div>
            </div>

            <!-- Unit List Items -->
            <div class="unit-list">
                <!-- Unit Item 1 - Faculty -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=CNTT" alt="Khoa CNTT" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Khoa Công nghệ thông tin</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: TS. Nguyễn Thanh Tùng</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 45</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#unitDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 2 - Faculty -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=KT" alt="Khoa Kinh tế" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Khoa Kinh tế và Quản lý</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: PGS.TS. Trần Thị Lan</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 38</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#unitDetailModal2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 3 - Faculty -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=XD" alt="Khoa Xây dựng" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Khoa Xây dựng</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: GS.TS. Phạm Văn Hùng</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 52</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 4 - Faculty -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=MT" alt="Khoa Môi trường" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Khoa Môi trường</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: PGS.TS. Lê Thị Hương</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 35</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 5 - Department -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=TCHC" alt="Phòng Tổ chức" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Phòng Tổ chức Hành chính</div>
                        <div class="unit-type">Đơn vị hành chính</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: ThS. Vũ Minh Hiển</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 18</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 6 - Department -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=ĐTĐH" alt="Phòng Đào tạo" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Phòng Đào tạo Đại học</div>
                        <div class="unit-type">Đơn vị hành chính</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Trưởng đơn vị: TS. Nguyễn Văn Lâm</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 15</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Unit Item 7 - Research Center -->
                <div class="unit-item">
                    <img src="https://via.placeholder.com/150x150?text=NCPT" alt="Trung tâm nghiên cứu" class="unit-logo">
                    <div class="unit-info">
                        <div class="unit-name">Trung tâm Nghiên cứu và Phát triển</div>
                        <div class="unit-type">Đơn vị nghiên cứu</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>Giám đốc: PGS.TS. Đỗ Xuân Thành</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 28</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- More units can be added here -->
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                <ul class="pagination">
                    <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Unit Detail Modal 1 -->
    <div class="modal fade" id="unitDetailModal1" tabindex="-1" aria-labelledby="unitDetailModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitDetailModalLabel1">Thông tin Chi tiết Đơn vị</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="unit-detail">
                        <!-- Unit Header -->
                        <div class="unit-detail-header">
                            <img src="https://via.placeholder.com/150x150?text=CNTT" alt="Khoa CNTT" class="unit-detail-logo">
                            <div class="unit-detail-title">
                                <div class="unit-detail-name">Khoa Công nghệ thông tin</div>
                                <div class="unit-detail-type">Đơn vị đào tạo</div>
                                <div class="unit-detail-meta">
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Thành lập: 1999</span>
                                    </div>
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>Số cán bộ: 45</span>
                                    </div>
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Cơ sở: Hà Nội</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Description -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Giới thiệu</div>
                            <div class="unit-detail-description">
                                <p>Khoa Công nghệ thông tin được thành lập vào năm 1999, là một trong những khoa đầu tiên của Trường Đại học Thủy Lợi. Sau hơn 20 năm phát triển, Khoa đã khẳng định được vị thế là một trong những đơn vị đào tạo hàng đầu về Công nghệ thông tin tại Việt Nam.</p>
                                <p>Hiện nay, Khoa Công nghệ thông tin đào tạo các chuyên ngành: Công nghệ thông tin, Kỹ thuật phần mềm, Hệ thống thông tin, An toàn thông tin, Khoa học dữ liệu và Trí tuệ nhân tạo. Khoa cũng đào tạo ở các bậc: đại học, thạc sĩ và tiến sĩ.</p>
                                <p>Với đội ngũ giảng viên có trình độ cao, cơ sở vật chất hiện đại, Khoa Công nghệ thông tin cam kết đào tạo nguồn nhân lực chất lượng cao, đáp ứng nhu cầu của xã hội trong kỷ nguyên số.</p>
                            </div>
                        </div>

                        <!-- Leadership -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Ban lãnh đạo</div>
                            <div class="leader-list">
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader1" alt="Trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">TS. Nguyễn Thanh Tùng</div>
                                        <div class="leader-position">Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader2" alt="Phó trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">TS. Phạm Tuấn Minh</div>
                                        <div class="leader-position">Phó Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader3" alt="Phó trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">PGS.TS. Hoàng Xuân Dậu</div>
                                        <div class="leader-position">Phó Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader4" alt="Trợ lý khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">ThS. Lê Thị Hương</div>
                                        <div class="leader-position">Trợ lý Khoa</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Staff List -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Bộ môn trực thuộc</div>
                            <div class="staff-list">
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM1" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Khoa học máy tính</div>
                                        <div class="staff-position">Trưởng BM: TS. Lê Văn Thịnh</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM2" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Công nghệ phần mềm</div>
                                        <div class="staff-position">Trưởng BM: TS. Trần Thu Hà</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM3" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Hệ thống thông tin</div>
                                        <div class="staff-position">Trưởng BM: PGS.TS. Nguyễn Hữu Quỳnh</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM4" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Mạng và An toàn thông tin</div>
                                        <div class="staff-position">Trưởng BM: TS. Đoàn Văn Ban</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=PTN" alt="Phòng thí nghiệm" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Phòng thí nghiệm CNTT</div>
                                        <div class="staff-position">Quản lý: ThS. Vũ Văn Thắng</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=VP" alt="Văn phòng" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Văn phòng Khoa</div>
                                        <div class="staff-position">Nhân viên: 3 người</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Thông tin liên hệ</div>
                            <ul class="contact-info-list">
                                <li class="contact-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="contact-label">Địa chỉ:</span>
                                    <span class="contact-value">Tầng 3, Nhà C5, Trường ĐH Thủy Lợi, 175 Tây Sơn, Đống Đa, Hà Nội</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="contact-label">Điện thoại:</span>
                                    <span class="contact-value">(024) 3563 2211</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span class="contact-label">Email:</span>
                                    <span class="contact-value">cntt@tlu.edu.vn</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-globe"></i>
                                    <span class="contact-label">Website:</span>
                                    <span class="contact-value"><a href="#" target="_blank">cse.tlu.edu.vn</a></span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fab fa-facebook"></i>
                                    <span class="contact-label">Facebook:</span>
                                    <span class="contact-value"><a href="#" target="_blank">facebook.com/cse.tlu</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" class="btn btn-primary">Xem trang Khoa CNTT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Unit Detail Modal 2 -->
    <div class="modal fade" id="unitDetailModal2" tabindex="-1" aria-labelledby="unitDetailModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitDetailModalLabel2">Thông tin Chi tiết Đơn vị</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="unit-detail">
                        <!-- Unit Header -->
                        <div class="unit-detail-header">
                            <img src="https://via.placeholder.com/150x150?text=KT" alt="Khoa Kinh tế" class="unit-detail-logo">
                            <div class="unit-detail-title">
                                <div class="unit-detail-name">Khoa Kinh tế và Quản lý</div>
                                <div class="unit-detail-type">Đơn vị đào tạo</div>
                                <div class="unit-detail-meta">
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Thành lập: 2001</span>
                                    </div>
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>Số cán bộ: 38</span>
                                    </div>
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Cơ sở: Hà Nội</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Unit Description -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Giới thiệu</div>
                            <div class="unit-detail-description">
                                <p>Khoa Kinh tế và Quản lý được thành lập vào năm 2001, là đơn vị đào tạo về các lĩnh vực kinh tế, quản trị kinh doanh và tài chính của Trường Đại học Thủy Lợi. Khoa đã và đang khẳng định vị thế là một trong những đơn vị đào tạo kinh tế có uy tín tại Việt Nam.</p>
                                <p>Hiện nay, Khoa Kinh tế và Quản lý đào tạo các chuyên ngành: Quản trị kinh doanh, Kế toán, Kinh tế, Tài chính - Ngân hàng, và Quản lý dự án. Khoa cũng đào tạo ở các bậc: đại học và thạc sĩ.</p>
                                <p>Với đội ngũ giảng viên có trình độ cao, kinh nghiệm thực tiễn phong phú, Khoa Kinh tế và Quản lý cam kết đào tạo nguồn nhân lực chất lượng cao, đáp ứng nhu cầu của doanh nghiệp và xã hội.</p>
                            </div>
                        </div>

                        <!-- Leadership -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Ban lãnh đạo</div>
                            <div class="leader-list">
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader1" alt="Trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">PGS.TS. Trần Thị Lan</div>
                                        <div class="leader-position">Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader2" alt="Phó trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">TS. Đỗ Văn Bình</div>
                                        <div class="leader-position">Phó Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader3" alt="Phó trưởng khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">TS. Nguyễn Thị Hương</div>
                                        <div class="leader-position">Phó Trưởng khoa</div>
                                    </div>
                                </div>
                                <div class="leader-item">
                                    <img src="https://via.placeholder.com/150x150?text=Leader4" alt="Trợ lý khoa" class="leader-avatar">
                                    <div class="leader-info">
                                        <div class="leader-name">ThS. Vũ Thị Mai</div>
                                        <div class="leader-position">Trợ lý Khoa</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Staff List -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Bộ môn trực thuộc</div>
                            <div class="staff-list">
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM1" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Quản trị kinh doanh</div>
                                        <div class="staff-position">Trưởng BM: TS. Nguyễn Thị Hồng</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM2" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Kế toán</div>
                                        <div class="staff-position">Trưởng BM: TS. Lê Văn Quang</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM3" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Kinh tế</div>
                                        <div class="staff-position">Trưởng BM: PGS.TS. Trịnh Quốc Trung</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=BM4" alt="Bộ môn" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Bộ môn Tài chính - Ngân hàng</div>
                                        <div class="staff-position">Trưởng BM: TS. Phạm Thị Minh</div>
                                    </div>
                                </div>
                                <div class="staff-item">
                                    <img src="https://via.placeholder.com/150x150?text=VP" alt="Văn phòng" class="staff-avatar">
                                    <div class="staff-info">
                                        <div class="staff-name">Văn phòng Khoa</div>
                                        <div class="staff-position">Nhân viên: 4 người</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Thông tin liên hệ</div>
                            <ul class="contact-info-list">
                                <li class="contact-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="contact-label">Địa chỉ:</span>
                                    <span class="contact-value">Tầng 2, Nhà A5, Trường ĐH Thủy Lợi, 175 Tây Sơn, Đống Đa, Hà Nội</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="contact-label">Điện thoại:</span>
                                    <span class="contact-value">(024) 3563 2345</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span class="contact-label">Email:</span>
                                    <span class="contact-value">ktql@tlu.edu.vn</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-globe"></i>
                                    <span class="contact-label">Website:</span>
                                    <span class="contact-value"><a href="#" target="_blank">fem.tlu.edu.vn</a></span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fab fa-facebook"></i>
                                    <span class="contact-label">Facebook:</span>
                                    <span class="contact-value"><a href="#" target="_blank">facebook.com/fem.tlu</a></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" class="btn btn-primary">Xem trang Khoa Kinh tế</a>
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
            // Xử lý chuyển đổi kiểu xem
            const viewOptionButtons = document.querySelectorAll('.view-options button');
            const unitList = document.querySelector('.unit-list');

            viewOptionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Cập nhật trạng thái active
                    viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Thay đổi kiểu xem
                    const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                    if (isGridView) {
                        unitList.classList.add('grid-view');
                    } else {
                        unitList.classList.remove('grid-view');
                    }
                });
            });

            // Xử lý tìm kiếm
            const searchInput = document.querySelector('.search-box input');
            const searchButton = document.querySelector('.search-box button');

            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch(searchInput.value);
                }
            });

            searchButton.addEventListener('click', function() {
                performSearch(searchInput.value);
            });

            function performSearch(query) {
                query = query.trim().toLowerCase();
                console.log('Đang tìm kiếm: ' + query);
                // Thực hiện tìm kiếm tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
            }

            // Xử lý bộ lọc
            const filterSelects = document.querySelectorAll('.filter-select');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    applyFilters();
                });
            });

            function applyFilters() {
                // Thu thập tất cả các giá trị bộ lọc
                const filters = {};
                filterSelects.forEach(select => {
                    const filterName = select.previousElementSibling.textContent.trim().replace(':', '').toLowerCase();
                    filters[filterName] = select.value;
                });

                console.log('Đang áp dụng bộ lọc:', filters);
                // Áp dụng bộ lọc tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
            }
        });
    </script>
</body>
</html>
