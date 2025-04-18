<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh bạ Sinh viên - Đại học Thủy Lợi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @section('custom-css')
    
    @endsection
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

        /* Student List */
        .student-list-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .student-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 20px;
        }

        .student-count {
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

        .student-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s;
        }

        .student-item:hover {
            background-color: var(--light-color);
        }

        .student-item:last-child {
            border-bottom: none;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .student-info {
            flex: 1;
        }

        .student-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .student-id {
            color: var(--accent-color);
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .student-class {
            color: var(--dark-color);
            font-size: 0.9rem;
        }

        .student-class a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .student-class a:hover {
            text-decoration: underline;
        }

        .student-actions {
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

        /* Grid View */
        .student-list.grid-view {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .student-list.grid-view .student-item {
            flex-direction: column;
            text-align: center;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
        }

        .student-list.grid-view .student-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
        }

        .student-list.grid-view .student-actions {
            margin-top: 15px;
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

        .student-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .student-detail-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .student-detail-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
            text-align: center;
        }

        .student-detail-id {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--accent-color);
            margin-bottom: 20px;
            text-align: center;
        }

        .student-detail-info {
            width: 100%;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .student-detail-info li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
        }

        .student-detail-info li:last-child {
            border-bottom: none;
        }

        .student-detail-info i {
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

        /* Access Restricted */
        .access-restricted {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin: 30px 0;
        }

        .access-restricted i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .access-restricted h3 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .access-restricted p {
            color: #6c757d;
            margin-bottom: 15px;
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
            .student-list.grid-view {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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

            .student-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: center;
            }

            .student-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .student-actions {
                margin-top: 15px;
            }

            .student-list.grid-view {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
            }

            .page-title h1 {
                font-size: 1.8rem;
            }

            .student-list-header {
                flex-direction: column;
                gap: 10px;
            }

            .view-options {
                align-self: flex-end;
            }
        }
    </style>
</head>
@include('components.nav')
    <!-- Page Title -->
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
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV1" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Nguyễn Văn A</div>
                        <div class="student-id">62CNTT1 - 1951060001</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 2 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV2" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Trần Thị B</div>
                        <div class="student-id">62CNTT1 - 1951060002</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 3 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV3" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Lê Văn C</div>
                        <div class="student-id">62CNTT1 - 1951060003</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal3">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 4 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV4" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Phạm Thị D</div>
                        <div class="student-id">62CNTT1 - 1951060004</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 7 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV7" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Đặng Quốc G</div>
                        <div class="student-id">62CNTT2 - 1951060007</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT2</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 8 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV8" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Ngô Thị H</div>
                        <div class="student-id">62CNTT2 - 1951060008</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT2</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- More student items can be added here -->
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

    <!-- Main Content - For Student Access (Only classmates) -->
    <div class="container mb-5" id="student-access" style="display: none;">
        <!-- Access Information -->
        <div class="alert alert-info mb-4">
            <i class="fas fa-info-circle me-2"></i> Bạn chỉ có quyền xem thông tin sinh viên trong lớp <strong>62CNTT1</strong>
        </div>

        <!-- Search and Filter Section (Limited) -->
        <div class="search-filter-container">
            <div class="search-box">
                <i class="fas fa-search me-2"></i>
                <input type="text" placeholder="Tìm kiếm theo tên hoặc mã sinh viên...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="filter-options">
                <div class="filter-group">
                    <span class="filter-label">Sắp xếp theo:</span>
                    <select class="filter-select">
                        <option value="name">Tên (A-Z)</option>
                        <option value="name-desc">Tên (Z-A)</option>
                        <option value="id">Mã sinh viên</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Student List (Classmates Only) -->
        <div class="student-list-container">
            <div class="student-list-header">
                <div class="student-count">
                    Hiển thị <span class="text-primary">35</span> sinh viên lớp <span class="text-primary">62CNTT1</span>
                </div>
                <div class="view-options">
                    <button type="button" class="active"><i class="fas fa-list"></i></button>
                    <button type="button"><i class="fas fa-th-large"></i></button>
                </div>
            </div>

            <!-- Student List Items (Only classmates) -->
            <div class="student-list">
                <!-- Student Item 1 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV1" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Nguyễn Văn A</div>
                        <div class="student-id">62CNTT1 - 1951060001</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 2 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV2" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Trần Thị B</div>
                        <div class="student-id">62CNTT1 - 1951060002</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal2">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- Student Item 3 -->
                <div class="student-item">
                    <img src="https://via.placeholder.com/150x150?text=SV3" alt="Sinh viên" class="student-avatar">
                    <div class="student-info">
                        <div class="student-name">Lê Văn C</div>
                        <div class="student-id">62CNTT1 - 1951060003</div>
                        <div class="student-class">Lớp: <a href="#">62CNTT1</a> - Khoa Công nghệ thông tin</div>
                    </div>
                    <div class="student-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal3">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <!-- More classmates can be added here -->
            </div>
        </div>

        <!-- Access Restricted Message -->
        <div class="access-restricted">
            <i class="fas fa-lock"></i>
            <h3>Quyền truy cập bị hạn chế</h3>
            <p>Bạn chỉ có thể xem thông tin sinh viên cùng lớp. Để xem thông tin sinh viên khác lớp, vui lòng liên hệ với quản trị viên hoặc giáo viên chủ nhiệm.</p>
        </div>
    </div>

    <!-- Student Detail Modal 1 -->
    <div class="modal fade" id="studentDetailModal1" tabindex="-1" aria-labelledby="studentDetailModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailModalLabel1">Thông tin Sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="student-detail">
                        <img src="https://via.placeholder.com/250x250?text=SV1" alt="Sinh viên" class="student-detail-avatar">
                        <div class="student-detail-name">Nguyễn Văn A</div>
                        <div class="student-detail-id">1951060001</div>

                        <ul class="student-detail-info">
                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                <span class="detail-label">Lớp:</span>
                                <span class="detail-value">62CNTT1</span>
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

    <!-- Student Detail Modal 2 -->
    <div class="modal fade" id="studentDetailModal2" tabindex="-1" aria-labelledby="studentDetailModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailModalLabel2">Thông tin Sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="student-detail">
                        <img src="https://via.placeholder.com/250x250?text=SV2" alt="Sinh viên" class="student-detail-avatar">
                        <div class="student-detail-name">Trần Thị B</div>
                        <div class="student-detail-id">1951060002</div>

                        <ul class="student-detail-info">
                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                <span class="detail-label">Lớp:</span>
                                <span class="detail-value">62CNTT1</span>
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
                                <span class="detail-value">b.tt195106002@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">0987.123.456</span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Số 456 Đường XYZ, Quận Cầu Giấy, Hà Nội</span>
                            </li>
                            <li>
                                <i class="fas fa-calendar-alt"></i>
                                <span class="detail-label">Ngày sinh:</span>
                                <span class="detail-value">20/06/2004</span>
                            </li>
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">CCCD:</span>
                                <span class="detail-value">001204567891</span>
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

    <!-- Student Detail Modal 3 -->
    <div class="modal fade" id="studentDetailModal3" tabindex="-1" aria-labelledby="studentDetailModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailModalLabel3">Thông tin Sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="student-detail">
                        <img src="https://via.placeholder.com/250x250?text=SV3" alt="Sinh viên" class="student-detail-avatar">
                        <div class="student-detail-name">Lê Văn C</div>
                        <div class="student-detail-id">1951060003</div>

                        <ul class="student-detail-info">
                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                <span class="detail-label">Lớp:</span>
                                <span class="detail-value">62CNTT1</span>
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
                                <span class="detail-value">c.lv195106003@tlu.edu.vn</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">0912.345.678</span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">Số 789 Đường DEF, Quận Long Biên, Hà Nội</span>
                            </li>
                            <li>
                                <i class="fas fa-calendar-alt"></i>
                                <span class="detail-label">Ngày sinh:</span>
                                <span class="detail-value">05/11/2004</span>
                            </li>
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">CCCD:</span>
                                <span class="detail-value">001204567892</span>
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

  @include('components.footer')

    <!-- Bootstrap & JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Thiết lập phân quyền truy cập dựa trên vai trò người dùng
            const userRole = 'cbgv'; // Có thể là 'cbgv' hoặc 'student'
            const studentClass = '62CNTT1'; // Lớp của sinh viên hiện tại

            // Hiển thị phù hợp dựa trên vai trò
            if (userRole === 'cbgv') {
                // CBGV có thể xem tất cả thông tin
                document.getElementById('cbgv-access').style.display = 'block';
                document.getElementById('student-access').style.display = 'none';
            } else if (userRole === 'student') {
                // Sinh viên chỉ xem được danh sách sinh viên cùng lớp
                document.getElementById('cbgv-access').style.display = 'none';
                document.getElementById('student-access').style.display = 'block';
            }

            // Xử lý chuyển đổi kiểu xem
            const viewOptionButtons = document.querySelectorAll('.view-options button');
            const studentLists = document.querySelectorAll('.student-list');

            viewOptionButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Cập nhật trạng thái active
                    viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Thay đổi kiểu xem
                    const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                    studentLists.forEach(list => {
                        if (isGridView) {
                            list.classList.add('grid-view');
                        } else {
                            list.classList.remove('grid-view');
                        }
                    });
                });
            });

            // Xử lý tìm kiếm
            const searchInputs = document.querySelectorAll('.search-box input');
            const searchButtons = document.querySelectorAll('.search-box button');

            searchInputs.forEach((input, index) => {
                const button = searchButtons[index];

                input.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        performSearch(input.value);
                    }
                });

                button.addEventListener('click', function() {
                    performSearch(input.value);
                });
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
