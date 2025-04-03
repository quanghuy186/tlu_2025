<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</title>
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

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x1080') center/cover no-repeat;
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 50px;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            opacity: 0.9;
        }

        /* Improved Search Box */
        .search-box {
            background-color: white;
            border-radius: 50px;
            padding: 12px 20px;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box select {
            border: none;
            background-color: var(--light-color);
            padding: 12px 20px;
            border-radius: 25px;
            outline: none;
            width: 150px;
            font-weight: 500;
            color: var(--dark-color);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-box input {
            flex-grow: 1;
            border: none;
            background-color: var(--light-color);
            padding: 12px 20px;
            outline: none;
            border-radius: 25px;
            font-size: 1rem;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .search-box button {
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            min-width: 140px;
        }

        .search-box button:hover {
            background-color: #e64a19;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Directory Section */
        .section-title {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
        }

        .section-title h2 {
            font-weight: 700;
            color: var(--primary-color);
            display: inline-block;
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .section-title p {
            max-width: 700px;
            margin: 0 auto;
            color: #6c757d;
        }

        .directory-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .directory-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .directory-card .card-img {
            height: 160px;
            width: 100%;
            object-fit: cover;
        }

        .directory-card .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            font-size: 1.2rem;
        }

        .directory-card .card-body {
            padding: 20px;
            flex-grow: 1;
        }

        .directory-card .card-body p {
            color: #6c757d;
        }

        .directory-card .card-footer {
            background-color: white;
            border-top: 1px solid #f1f1f1;
            padding: 15px 20px;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Statistics Section */
        .stats-section {
            background-color: var(--primary-color);
            color: white;
            padding: 80px 0;
            margin: 80px 0;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item .icon {
            font-size: 3rem;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.8);
        }

        .stat-item .count {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-item .title {
            font-size: 1.2rem;
            opacity: 0.8;
        }

        /* Latest Announcements */
        .announcement-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .announcement-card .card-body {
            padding: 20px;
        }

        .announcement-card .date {
            background-color: var(--accent-color);
            color: white;
            width: 50px;
            height: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            border-radius: 5px;
            float: left;
            margin-right: 15px;
        }

        .announcement-card .date .day {
            font-size: 1.5rem;
            line-height: 1;
        }

        .announcement-card .date .month {
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .announcement-card h5 {
            font-weight: 600;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .announcement-card p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .announcement-card .meta {
            font-size: 0.85rem;
            color: #adb5bd;
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

        /* Dropdown Menu */
        .dropdown-menu {
            min-width: 220px;
            padding: 0;
            border: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }

        .dropdown-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            font-weight: 600;
        }

        .dropdown-item {
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background-color: var(--light-color);
            padding-left: 20px;
        }

        .dropdown-item i {
            width: 25px;
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 0;
        }

        /* User Profile Info */
        .user-info-modal .modal-header {
            background-color: var(--primary-color);
            color: white;
        }

        .user-info-modal .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto 20px;
            display: block;
        }

        .user-info-modal .user-details {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-info-modal .user-details h4 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .user-info-modal .user-details .badge {
            background-color: var(--primary-color);
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .user-info-modal .info-list {
            list-style: none;
            padding: 0;
        }

        .user-info-modal .info-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .user-info-modal .info-list li:last-child {
            border-bottom: none;
        }

        .user-info-modal .info-list i {
            color: var(--primary-color);
            width: 25px;
            text-align: center;
            margin-right: 10px;
        }

        /* Hero actions */
        .hero-actions {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .hero-actions .btn {
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .hero-actions .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            border: 2px solid;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-section {
                padding: 80px 0;
            }

            .hero-section h1 {
                font-size: 2.5rem;
            }

            .search-box {
                flex-direction: column;
                border-radius: 10px;
                padding: 15px;
            }

            .search-box select,
            .search-box input,
            .search-box button {
                width: 100%;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .stat-item {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
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
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU">
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
                    <a href="#" class="user-menu dropdown-toggle" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://static.vecteezy.com/system/resources/previews/019/879/186/non_2x/user-icon-on-transparent-background-free-png.png" alt="User Avatar" class="user-avatar">
                        <span>Nguyễn Văn A</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                        <li class="dropdown-header">Thông tin tài khoản</li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#userInfoModal"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Cài đặt tài khoản</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> Thông báo</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.html"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Information Modal -->
    <div class="modal fade user-info-modal" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel">Thông tin cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="https://via.placeholder.com/200x200?text=User" alt="User Profile" class="avatar">
                    <div class="user-details">
                        <h4>Nguyễn Văn A</h4>
                        <span class="badge rounded-pill">Sinh viên</span>
                    </div>
                    <ul class="info-list">
                        <li><i class="fas fa-id-card"></i> Mã số: SV12345678</li>
                        <li><i class="fas fa-building"></i> Khoa Công nghệ thông tin</li>
                        <li><i class="fas fa-envelope"></i> a.nv123456@tlu.edu.vn</li>
                        <li><i class="fas fa-phone"></i> 0987654321</li>
                        <li><i class="fas fa-map-marker-alt"></i> Hà Nội, Việt Nam</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Cập nhật thông tin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</h1>
            <p>Kết nối thông tin - Chia sẻ tri thức - Xây dựng cộng đồng</p>

            <div class="hero-actions">
                <a href="{{ route('contact.index') }}" class="btn bg-white" style="color:#005baa">Bắt đầu ngay</a>
                <a href="#" class="btn btn-outline" style="color: #ffffff; border-color: #ffffff">Tìm hiểu thêm</a>
            </div>
        </div>
    </section>

    <!-- Directory Section -->
    <section class="directory-section">
        <div class="container">
            <div class="section-title">
                <h2>Tính năng chính</h2>
                <p>Tra cứu thông tin liên lạc của đơn vị, giảng viên, sinh viên và trao đổi thông tin một cách nhanh chóng và dễ dàng</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-building me-2"></i> Danh Bạ Điện Tử
                        </div>
                        <div class="card-body">
                            <p>Tra cứu thông tin liên lạc của các đơn vị, cán bộ giảng viên và sinh viên một cách nhanh chóng, chính xác</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem danh bạ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-user-tie me-2"></i> Tin nhắn
                        </div>
                        <div class="card-body">
                            <p>Nhắn tin trực tiếp với các người dùng khác để có thể trao đổi thông tin</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem tin nhắn
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-user-graduate me-2"></i> Diễn đàn
                        </div>
                        <div class="card-body">
                            <p>Hỏi và giải đáp thắc mắc nơi mà cộng đồng TLU có thể trao đổi thông tin trực tiếp với nhau</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem diễn đàn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    <section class="announcement-section">
        <div class="container">
            <div class="section-title">
                <h2>Thông báo mới nhất</h2>
                <p>Cập nhật những thông tin mới nhất từ hệ thống danh bạ điện tử Đại học Thủy Lợi</p>
            </div>

            <div class="row">


                <div class="col-lg-6">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="date">
                                <div class="day">05</div>
                                <div class="month">MAR</div>
                            </div>
                            <h5>Thông báo cập nhật hệ thống danh bạ điện tử</h5>
                            <p>Hệ thống danh bạ điện tử Trường Đại học Thủy Lợi sẽ được nâng cấp vào ngày 10/03/2025. Trong thời gian cập nhật, hệ thống sẽ tạm ngưng hoạt động từ 22:00 đến 23:59.</p>
                            <div class="meta">
                                <i class="fas fa-user me-1"></i> Ban Quản trị
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
					<div class="announcement-card">
                        <div class="card-body">
                            <div class="date">
                                <div class="day">05</div>
                                <div class="month">MAR</div>
                            </div>
                            <h5>Thông báo cập nhật hệ thống danh bạ điện tử</h5>
                            <p>Hệ thống danh bạ điện tử Trường Đại học Thủy Lợi sẽ được nâng cấp vào ngày 10/03/2025. Trong thời gian cập nhật, hệ thống sẽ tạm ngưng hoạt động từ 22:00 đến 23:59.</p>
                            <div class="meta">
                                <i class="fas fa-user me-1"></i> Ban Quản trị
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="date">
                                <div class="day">25</div>
                                <div class="month">FEB</div>
                            </div>
                            <h5>Cảnh báo bảo mật thông tin cá nhân</h5>
                            <p>Gần đây xuất hiện một số trường hợp lừa đảo qua điện thoại. Nhà trường khuyến cáo cán bộ, giảng viên và sinh viên cẩn trọng khi chia sẻ thông tin cá nhân.</p>
                            <div class="meta">
                                <i class="fas fa-user me-1"></i> Ban Giám hiệu
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="announcement-card">
                        <div class="card-body">
                            <div class="date">
                                <div class="day">28</div>
                                <div class="month">FEB</div>
                            </div>
                            <h5>Hướng dẫn sử dụng danh bạ điện tử</h5>
                            <p>Phòng Công nghệ thông tin đã cập nhật tài liệu hướng dẫn sử dụng hệ thống danh bạ điện tử mới. Mời các bạn sinh viên và cán bộ giảng viên tham khảo.</p>
                            <div class="meta">
                                <i class="fas fa-user me-1"></i> Phòng CNTT
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-primary">
                    <i class="fas fa-bell me-2"></i> Xem tất cả thông báo
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="count">25+</div>
                        <div class="title">Đơn vị</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="count">500+</div>
                        <div class="title">Giảng viên</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="count">15,000+</div>
                        <div class="title">Sinh viên</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="count">10,000+</div>
                        <div class="title">Lượt truy cập</div>
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
                        <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU" class="img-fluid">
                        <p>Hệ thống tra cứu và trao đổi thông tin của Trường Đại học Thủy Lợi cung cấp thông tin liên lạc chính thức của các đơn vị, cán bộ, giảng viên, sinh viên trong trường và trao đổi thông tin nội bộ với nhau đảm bảo tính bảo mật và chính xác.</p>
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
        // Script to initialize tooltips and popovers if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
