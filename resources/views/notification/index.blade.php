<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo - Đại học Thủy Lợi</title>
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

        /* Announcement Section */
        .announcement-section {
            padding: 30px 0 60px;
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

        /* Announcement Cards */
        .announcement-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .announcement-header {
            position: relative;
            overflow: hidden;
        }

        .announcement-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: all 0.3s;
        }

        .announcement-card:hover .announcement-header img {
            transform: scale(1.05);
        }

        .announcement-category {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }

        .announcement-body {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .announcement-date {
            color: var(--primary-color);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .announcement-date i {
            margin-right: 8px;
        }

        .announcement-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .announcement-title a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .announcement-title a:hover {
            color: var(--primary-color);
        }

        .announcement-excerpt {
            color: #6c757d;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .announcement-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .announcement-author {
            display: flex;
            align-items: center;
        }

        .announcement-author img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        .announcement-author span {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .read-more {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .read-more i {
            margin-left: 5px;
            transition: all 0.3s;
        }

        .read-more:hover {
            color: var(--secondary-color);
        }

        .read-more:hover i {
            transform: translateX(3px);
        }

        /* Featured Announcement */
        .featured-announcement {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            position: relative;
        }

        .featured-announcement-badge {
            position: absolute;
            top: 20px;
            left: 0;
            background-color: var(--accent-color);
            color: white;
            padding: 8px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            z-index: 2;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .featured-announcement-image {
            height: 400px;
            position: relative;
            overflow: hidden;
        }

        .featured-announcement-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s;
        }

        .featured-announcement:hover .featured-announcement-image img {
            transform: scale(1.05);
        }

        .featured-announcement-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            color: white;
        }

        .featured-announcement-date {
            display: inline-block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 5px 15px;
            border-radius: 20px;
        }

        .featured-announcement-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .featured-announcement-title a {
            color: white;
            text-decoration: none;
        }

        .featured-announcement-excerpt {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 20px;
        }

        .featured-announcement-button {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .featured-announcement-button:hover {
            background-color: white;
            color: var(--accent-color);
            transform: translateY(-2px);
        }

        /* Sidebar */
        .sidebar-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }

        .categories-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .categories-list li {
            margin-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
        }

        .categories-list li:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }

        .categories-list a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s;
        }

        .categories-list a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        .categories-list .badge {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            border-radius: 20px;
            padding: 5px 10px;
        }

        .recent-posts {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .recent-post-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .recent-post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .recent-post-image {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            overflow: hidden;
            margin-right: 15px;
        }

        .recent-post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recent-post-content h5 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .recent-post-content h5 a {
            color: var(--dark-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .recent-post-content h5 a:hover {
            color: var(--primary-color);
        }

        .recent-post-date {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
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

        /* Subscribe Form */
        .subscribe-form {
            display: flex;
            margin-top: 15px;
        }

        .subscribe-form input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 25px 0 0 25px;
            outline: none;
        }

        .subscribe-form button {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0 25px 25px 0;
            cursor: pointer;
            transition: all 0.3s;
        }

        .subscribe-form button:hover {
            background-color: var(--secondary-color);
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 70px 0 0;
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

        .social-icons {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 10px;
        }

        .social-icons li a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-icons li a:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .featured-announcement-image {
                height: 300px;
            }

            .featured-announcement-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .featured-announcement-image {
                height: 250px;
            }

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
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
            }

            .featured-announcement-badge {
                font-size: 0.8rem;
                padding: 5px 15px;
            }

            .featured-announcement-overlay {
                padding: 20px;
            }

            .featured-announcement-title {
                font-size: 1.2rem;
                margin-bottom: 10px;
            }

            .featured-announcement-excerpt {
                display: none;
            }

            .announcement-card {
                margin-bottom: 20px;
            }

            .announcement-header img {
                height: 160px;
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

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="footer-about">
                        <img src="https://via.placeholder.com/200x50?text=TLU+Logo" alt="Logo TLU" class="img-fluid">
                        <p>Danh bạ điện tử Trường Đại học Thủy Lợi cung cấp thông tin liên lạc chính thức của các đơn vị, cán bộ, giảng viên và sinh viên trong trường, đảm bảo tính bảo mật và chính xác.</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
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
            // Search functionality
            const searchBox = document.querySelector('.search-box input');
            const searchBtn = document.querySelector('.search-box button');

            searchBtn.addEventListener('click', function() {
                performSearch();
            });

            searchBox.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });

            function performSearch() {
                const searchTerm = searchBox.value.trim();
                if (searchTerm !== '') {
                    // In a real application, this would redirect to a search results page
                    console.log('Searching for:', searchTerm);
                    alert('Đang tìm kiếm: ' + searchTerm);
                    // window.location.href = 'search-results.html?q=' + encodeURIComponent(searchTerm);
                }
            }

            // Filter functionality
            const filterSelects = document.querySelectorAll('.filter-select');
            filterSelects.forEach(select => {
                select.addEventListener('change', function() {
                    applyFilters();
                });
            });

            function applyFilters() {
                // In a real application, this would apply filters to the announcements list
                const sortBy = document.querySelector('.filter-select:nth-child(1)').value;
                const category = document.querySelector('.filter-select:nth-child(2)').value;
                const source = document.querySelector('.filter-select:nth-child(3)').value;

                console.log('Filters applied:', { sortBy, category, source });
                // Here you would make an AJAX request or redirect to a filtered page
            }

            // Subscribe form
            const subscribeForm = document.querySelector('.subscribe-form');
            if (subscribeForm) {
                subscribeForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const email = this.querySelector('input').value.trim();
                    if (email === '') {
                        alert('Vui lòng nhập địa chỉ email của bạn.');
                        return;
                    }

                    // Email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        alert('Vui lòng nhập một địa chỉ email hợp lệ.');
                        return;
                    }

                    // Simulate subscription success
                    alert('Cảm ơn bạn đã đăng ký! Bạn sẽ nhận được thông báo qua email.');
                    this.reset();
                });
            }
        });
    </script>
</body>
</html>
