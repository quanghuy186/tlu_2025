<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diễn đàn - Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</title>
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

        /* Forum Page Header */
        .forum-header {
            background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x500?text=Forum') center/cover no-repeat;
            color: white;
            padding: 50px 0;
            margin-bottom: 30px;
        }

        .forum-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .forum-header p {
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 20px;
            opacity: 0.9;
        }

        /* Breadcrumb */
        .breadcrumb-container {
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .breadcrumb {
            margin-bottom: 0;
        }

        .breadcrumb .breadcrumb-item {
            font-size: 0.9rem;
        }

        .breadcrumb .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Forum Categories */
        .forum-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
            overflow: hidden;
        }

        .forum-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .forum-card .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .forum-card .category-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            width: 30px;
            text-align: center;
        }

        .forum-card .topic-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f1f1;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .forum-card .topic-item:last-child {
            border-bottom: none;
        }

        .forum-card .topic-item:hover {
            background-color: #f8f9fa;
        }

        .forum-card .topic-icon {
            background-color: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .forum-card .topic-content {
            flex-grow: 1;
        }

        .forum-card .topic-title {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            display: block;
            text-decoration: none;
        }

        .forum-card .topic-info {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .forum-card .topic-stats {
            display: flex;
            align-items: center;
            margin-left: 15px;
            flex-shrink: 0;
        }

        .forum-card .stat-item {
            margin-left: 15px;
            text-align: center;
        }

        .forum-card .stat-count {
            font-weight: 600;
            color: var(--primary-color);
        }

        .forum-card .stat-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Latest Posts */
        .latest-posts {
            margin-bottom: 40px;
        }

        .section-title {
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
            color: var(--primary-color);
            font-weight: 700;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .post-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 20px;
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .post-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .post-author {
            font-weight: 600;
            margin-bottom: 0;
        }

        .post-time {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .post-body {
            padding: 20px;
        }

        .post-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .post-text {
            color: #555;
            margin-bottom: 15px;
        }

        .post-footer {
            padding: 10px 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .post-actions a {
            color: #6c757d;
            margin-right: 15px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .post-actions a:hover {
            color: var(--primary-color);
        }

        .post-actions i {
            margin-right: 5px;
        }

        .post-meta {
            font-size: 0.85rem;
            color: #6c757d;
        }

        /* Forum Sidebar */
        .forum-sidebar .card {
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .forum-sidebar .card-header {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 15px 20px;
        }

        .forum-sidebar .list-group-item {
            padding: 12px 20px;
            border-color: #f1f1f1;
            transition: all 0.3s;
        }

        .forum-sidebar .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .forum-sidebar .list-group-item i {
            color: var(--primary-color);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .forum-sidebar .badge {
            background-color: var(--accent-color);
            font-weight: 500;
        }

        .forum-sidebar .user-item {
            display: flex;
            align-items: center;
        }

        .forum-sidebar .user-item img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .forum-sidebar .card-footer {
            background-color: white;
            border-top: 1px solid #f1f1f1;
            padding: 12px 20px;
            text-align: center;
        }

        .forum-sidebar .btn-sm {
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* New Topic Button */
        .new-topic-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--accent-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .new-topic-btn:hover {
            transform: translateY(-5px) rotate(90deg);
            background-color: #e64a19;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            margin-bottom: 40px;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            color: var(--primary-color);
            transition: all 0.3s;
            border-radius: 5px;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-item .page-link:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
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
            .stat-item {
                display: none;
            }

            .forum-card .topic-stats {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .forum-header {
                padding: 40px 0;
            }

            .forum-header h1 {
                font-size: 2rem;
            }

            .post-card {
                margin-bottom: 15px;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
            }

            .post-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .post-meta {
                margin-top: 10px;
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
                        <a class="nav-link" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact.index') }}">Danh bạ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('message.index') }}">Tin nhắn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('forum.index') }}">Diễn đàn</a>
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

    <!-- Forum Header -->
    <section class="forum-header">
        <div class="container text-center">
            <h1>Diễn đàn trao đổi TLU</h1>
            <p>Nơi trao đổi, chia sẻ kiến thức, thông tin và giải đáp thắc mắc trong cộng đồng Đại học Thủy Lợi</p>
            <div class="search-box bg-white p-2 rounded-pill d-flex align-items-center justify-content-between mt-4 mx-auto" style="max-width: 600px;">
                <input type="text" class="border-0 flex-grow-1 p-2 ms-3" placeholder="Tìm kiếm chủ đề, bài viết...">
                <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold"><i class="fas fa-search me-2"></i> Tìm kiếm</button>
            </div>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Diễn đàn</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Left Column - Categories and Posts -->
            <div class="col-lg-8">
                <!-- Forum Categories -->
                <div class="forum-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-graduation-cap category-icon"></i>
                            Học tập & Nghiên cứu
                        </div>
                        <span class="badge rounded-pill bg-light text-dark">4 chủ đề mới</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Hỏi đáp về môn Toán cao cấp</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user me-1"></i> Nguyễn Văn A</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 2 giờ trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">24</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">142</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>

                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-flask"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Chia sẻ đề tài nghiên cứu khoa học sinh viên năm 2025</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user me-1"></i> Trần Thị B</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 1 ngày trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">18</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">203</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>

                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Khó khăn khi học lập trình Java và cách khắc phục</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user me-1"></i> Lê Văn C</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 3 ngày trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">36</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">310</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="forum-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-bullhorn category-icon"></i>
                            Thông báo & Sự kiện
                        </div>
                        <span class="badge rounded-pill bg-light text-dark">2 chủ đề mới</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Thông báo lịch thi học kỳ II năm học 2024-2025</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user-tie me-1"></i> Phòng Đào tạo</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 3 giờ trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">12</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">578</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>

                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Hội thảo cơ hội việc làm cho sinh viên CNTT 2025</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user-tie me-1"></i> Khoa CNTT</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">8</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">425</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="forum-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-users category-icon"></i>
                            Đời sống sinh viên
                        </div>
                        <span class="badge rounded-pill bg-light text-dark">5 chủ đề mới</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user me-1"></i> Phạm Thị D</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 5 giờ trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">45</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">389</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>

                        <div class="topic-item">
                            <div class="topic-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="topic-content">
                                <a href="#" class="topic-title">Top 10 quán ăn ngon bổ rẻ gần trường TLU</a>
                                <div class="topic-info">
                                    <span><i class="fas fa-user me-1"></i> Trần Văn E</span>
                                    <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                                </div>
                            </div>
                            <div class="topic-stats">
                                <div class="stat-item">
                                    <div class="stat-count">67</div>
                                    <div class="stat-label">Trả lời</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-count">520</div>
                                    <div class="stat-label">Lượt xem</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest Posts -->
                <div class="latest-posts">
                    <h4 class="section-title">Bài viết mới nhất</h4>

                    <div class="post-card">
                        <div class="post-header">
                            <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                            <div>
                                <h6 class="post-author">Nguyễn Văn A</h6>
                                <span class="post-time">Đăng 2 giờ trước</span>
                            </div>
                        </div>
                        <div class="post-body">
                            <h5 class="post-title">Cách giải bài tập Toán cao cấp phần đạo hàm</h5>
                            <p class="post-text">Chào các bạn, mình đang gặp khó khăn với bài tập đạo hàm hàm số nhiều biến trong môn Toán cao cấp. Mình đã thử giải theo phương pháp...</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <div class="post-footer">
                            <div class="post-actions">
                                <a href="#"><i class="far fa-comment"></i> 8 bình luận</a>
                                <a href="#"><i class="far fa-heart"></i> 15 thích</a>
                                <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                            </div>
                            <div class="post-meta">
                                <span><i class="fas fa-folder me-1"></i> Học tập & Nghiên cứu</span>
                            </div>
                        </div>
                    </div>

                    <div class="post-card">
                        <div class="post-header">
                            <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                            <div>
                                <h6 class="post-author">Phòng Đào tạo</h6>
                                <span class="post-time">Đăng 3 giờ trước</span>
                            </div>
                        </div>
                        <div class="post-body">
                            <h5 class="post-title">Thông báo lịch thi học kỳ II năm học 2024-2025</h5>
                            <p class="post-text">Phòng Đào tạo thông báo lịch thi học kỳ II năm học 2024-2025 dành cho các khoa như sau: 1. Khoa Công nghệ thông tin: từ ngày 15/06 đến 30/06/2025...</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                        <div class="post-footer">
                            <div class="post-actions">
                                <a href="#"><i class="far fa-comment"></i> 12 bình luận</a>
                                <a href="#"><i class="far fa-heart"></i> 34 thích</a>
                                <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                            </div>
                            <div class="post-meta">
                                <span><i class="fas fa-folder me-1"></i> Thông báo & Sự kiện</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <nav aria-label="Forum pagination">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4">
                <div class="forum-sidebar">
                    <!-- Statistics Card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-2"></i> Thống kê diễn đàn
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-users"></i> Thành viên</span>
                                <span class="fw-bold">15,243</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-comments"></i> Chủ đề</span>
                                <span class="fw-bold">2,456</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-reply"></i> Bài viết</span>
                                <span class="fw-bold">18,789</span>
                            </div>

                        </div>
                    </div>

                    <!-- Active Topics Card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-fire me-2"></i> Chủ đề nổi bật
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</span>
                                    <span class="badge rounded-pill bg-primary">45</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">Top 10 quán ăn ngon bổ rẻ gần trường TLU</span>
                                    <span class="badge rounded-pill bg-primary">67</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">Khó khăn khi học lập trình Java và cách khắc phục</span>
                                    <span class="badge rounded-pill bg-primary">36</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">Thông báo lịch thi học kỳ II năm học 2024-2025</span>
                                    <span class="badge rounded-pill bg-primary">12</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-truncate">Hỏi đáp về môn Toán cao cấp</span>
                                    <span class="badge rounded-pill bg-primary">24</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Active Members Card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-medal me-2"></i> Thành viên tích cực
                        </div>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item user-item">
                                <img src="https://via.placeholder.com/200x200?text=User1" alt="User Avatar">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                    <span>Nguyễn Văn A</span>
                                    <span class="badge bg-primary">148 bài viết</span>
                                </div>
                            </div>
                            <div class="list-group-item user-item">
                                <img src="https://via.placeholder.com/200x200?text=User2" alt="User Avatar">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                    <span>Trần Thị B</span>
                                    <span class="badge bg-primary">126 bài viết</span>
                                </div>
                            </div>
                            <div class="list-group-item user-item">
                                <img src="https://via.placeholder.com/200x200?text=User3" alt="User Avatar">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                    <span>Lê Văn C</span>
                                    <span class="badge bg-primary">94 bài viết</span>
                                </div>
                            </div>
                            <div class="list-group-item user-item">
                                <img src="https://via.placeholder.com/200x200?text=User4" alt="User Avatar">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                    <span>Phạm Thị D</span>
                                    <span class="badge bg-primary">87 bài viết</span>
                                </div>
                            </div>
                            <div class="list-group-item user-item">
                                <img src="https://via.placeholder.com/200x200?text=User5" alt="User Avatar">
                                <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                    <span>Trần Văn E</span>
                                    <span class="badge bg-primary">75 bài viết</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Card -->
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-folder me-2"></i> Chuyên mục
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-graduation-cap me-2"></i> Học tập & Nghiên cứu</span>
                                <span class="badge rounded-pill bg-primary">324</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-bullhorn me-2"></i> Thông báo & Sự kiện</span>
                                <span class="badge rounded-pill bg-primary">156</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-users me-2"></i> Đời sống sinh viên</span>
                                <span class="badge rounded-pill bg-primary">289</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-briefcase me-2"></i> Việc làm & Thực tập</span>
                                <span class="badge rounded-pill bg-primary">127</span>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-lightbulb me-2"></i> Ý tưởng & Sáng tạo</span>
                                <span class="badge rounded-pill bg-primary">98</span>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- New Topic Button -->
    <a href="#" class="new-topic-btn">
        <i class="fas fa-plus"></i>
    </a>

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
