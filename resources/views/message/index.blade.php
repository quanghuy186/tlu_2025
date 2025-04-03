<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin nhắn - Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</title>
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

        /* Messages Page Specific Styles */
        .messages-header {
            background: linear-gradient(rgba(0, 91, 170, 0.8), rgba(0, 91, 170, 0.9)), url('https://via.placeholder.com/1920x500?text=Messages') center/cover no-repeat;
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }

        .messages-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .messages-header p {
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

        /* Messages Container */
        .messages-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
            height: calc(100vh - 300px);
            min-height: 500px;
            display: flex;
        }

        /* Contacts List */
        .contacts-list {
            width: 300px;
            border-right: 1px solid #eee;
            overflow-y: auto;
            height: 100%;
        }

        .contacts-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .search-contact {
            position: relative;
        }

        .search-contact input {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .search-contact i {
            position: absolute;
            left: 12px;
            top: 12px;
            color: #777;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f1f1f1;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .contact-item:hover {
            background-color: #f5f7fa;
        }

        .contact-item.active {
            background-color: #e6f3ff;
            border-left: 3px solid var(--primary-color);
        }

        .contact-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .contact-info {
            flex-grow: 1;
            overflow: hidden;
        }

        .contact-name {
            font-weight: 600;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-preview {
            font-size: 0.85rem;
            color: #777;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-meta {
            text-align: right;
            min-width: 55px;
        }

        .contact-time {
            font-size: 0.75rem;
            color: #999;
            margin-bottom: 5px;
        }

        .contact-badge {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            text-align: center;
            line-height: 18px;
        }

        .contact-status {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .status-online {
            background-color: #4CAF50;
        }

        .status-offline {
            background-color: #9e9e9e;
        }

        .status-away {
            background-color: #FFC107;
        }

        /* Chat Area */
        .chat-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-user {
            display: flex;
            align-items: center;
        }

        .chat-user img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .chat-user-info h5 {
            margin-bottom: 0;
            font-weight: 600;
        }

        .chat-user-info p {
            margin-bottom: 0;
            font-size: 0.85rem;
            color: #777;
        }

        .chat-actions a {
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-left: 15px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .chat-actions a:hover {
            color: var(--secondary-color);
        }

        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f5f7fa;
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }

        .message.outgoing {
            align-items: flex-end;
        }

        .message.incoming {
            align-items: flex-start;
        }

        .message-content {
            max-width: 75%;
            padding: 12px 15px;
            border-radius: 18px;
            margin-bottom: 5px;
            position: relative;
        }

        .message.outgoing .message-content {
            background-color: var(--primary-color);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message.incoming .message-content {
            background-color: white;
            border-bottom-left-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .message-time {
            font-size: 0.75rem;
            color: #999;
            margin-top: 3px;
        }

        .chat-input {
            padding: 15px;
            border-top: 1px solid #eee;
            background-color: white;
            display: flex;
            align-items: center;
        }

        .chat-input textarea {
            flex-grow: 1;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 15px;
            resize: none;
            outline: none;
            max-height: 100px;
        }

        .chat-input button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50%;
            width: 42px;
            height: 42px;
            margin-left: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .chat-input button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .chat-input .attachment-btn {
            background-color: transparent;
            color: #777;
            margin-right: 10px;
            width: 34px;
            height: 34px;
        }

        .chat-input .attachment-btn:hover {
            color: var(--primary-color);
            background-color: #f1f1f1;
            transform: none;
        }

        /* Empty State */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 20px;
            text-align: center;
            color: #777;
        }

        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            margin-bottom: 10px;
            color: #555;
        }

        .empty-state p {
            max-width: 300px;
            margin-bottom: 20px;
        }

        /* New Message Button */
        .new-message-btn {
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
            text-decoration: none;
        }

        .new-message-btn:hover {
            transform: translateY(-5px);
            background-color: #e64a19;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            color: white;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .messages-container {
                height: calc(100vh - 250px);
            }
        }

        @media (max-width: 768px) {
            .contacts-list {
                width: 75px;
                border-right: 1px solid #eee;
            }

            .contact-info, .contact-meta {
                display: none;
            }

            .contact-item {
                padding: 10px;
                display: flex;
                justify-content: center;
            }

            .contact-avatar {
                margin-right: 0;
            }

            .contacts-header {
                display: none;
            }

            .chat-header {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .top-bar {
                display: none;
            }

            .messages-header {
                padding: 30px 0;
            }

            .messages-header h1 {
                font-size: 1.8rem;
            }

            .messages-container {
                height: calc(100vh - 220px);
            }
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

        /* Date Divider */
        .date-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .date-divider span {
            background-color: #f5f7fa;
            padding: 0 15px;
            font-size: 0.85rem;
            color: #777;
            position: relative;
            z-index: 1;
        }

        .date-divider:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #ddd;
            z-index: 0;
        }

        /* Message with Image */
        .message-with-image .message-content {
            padding-bottom: 0;
            overflow: hidden;
        }

        .message-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .message-image:hover {
            opacity: 0.9;
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
                        <a class="nav-link active" href="{{ route('message.index') }}">Tin nhắn</a>
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

    <!-- Messages Header -->
    <section class="messages-header">
        <div class="container text-center">
            <h1>Tin nhắn nội bộ TLU</h1>
            <p>Trao đổi thông tin trực tiếp với giảng viên, sinh viên và các phòng ban trong trường</p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <div class="breadcrumb-container">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tin nhắn</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="messages-container">
            <!-- Contacts List -->
            <div class="contacts-list">
                <div class="contacts-header">
                    <div class="search-contact">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Tìm kiếm liên hệ...">
                    </div>
                </div>
                <div class="contact-item active">
                    <img src="https://via.placeholder.com/200x200?text=User1" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-online"></span>
                            Trần Thị B
                        </div>
                        <div class="contact-preview">Bạn: OK, tôi sẽ gửi cho bạn vào chiều nay</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">12:30</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User2" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-offline"></span>
                            Phòng Đào tạo
                        </div>
                        <div class="contact-preview">Vui lòng xác nhận lịch học bổ sung...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">Hôm qua</div>
                        <div class="contact-badge">2</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User3" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-away"></span>
                            TS. Nguyễn Văn C
                        </div>
                        <div class="contact-preview">Sinh viên cần chuẩn bị báo cáo cho buổi...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">T2</div>
                        <div class="contact-badge">1</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User4" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-online"></span>
                            Lê Văn D
                        </div>
                        <div class="contact-preview">Anh ơi, cho em hỏi về bài tập số 5...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">T2</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User5" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-offline"></span>
                            Phòng CTSV
                        </div>
                        <div class="contact-preview">Thông báo về việc đóng học phí học kỳ...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">21/03</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User6" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-offline"></span>
                            Nhóm Đồ án CNTT
                        </div>
                        <div class="contact-preview">Hoàng: Các bạn nhớ họp nhóm vào tối nay...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">20/03</div>
                    </div>
                </div>
                <div class="contact-item">
                    <img src="https://via.placeholder.com/200x200?text=User7" alt="Contact Avatar" class="contact-avatar">
                    <div class="contact-info">
                        <div class="contact-name">
                            <span class="contact-status status-away"></span>
                            Phạm Thị E
                        </div>
                        <div class="contact-preview">Bạn có ghi chép bài hôm thứ 4 không?...</div>
                    </div>
                    <div class="contact-meta">
                        <div class="contact-time">18/03</div>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="chat-area">
                <div class="chat-header">
                    <div class="chat-user">
                        <img src="https://via.placeholder.com/200x200?text=User1" alt="Chat User Avatar">
                        <div class="chat-user-info">
                            <h5>Trần Thị B</h5>
                            <p><span class="contact-status status-online"></span> Đang hoạt động</p>
                        </div>
                    </div>
                    <div class="chat-actions">
                        <a href="#" title="Tìm kiếm"><i class="fas fa-search"></i></a>
                        <a href="#" title="Gọi video"><i class="fas fa-video"></i></a>
                        <a href="#" title="Gọi thoại"><i class="fas fa-phone-alt"></i></a>
                        <a href="#" title="Thông tin"><i class="fas fa-info-circle"></i></a>
                    </div>
                </div>

                <div class="chat-messages">
                    <div class="date-divider">
                        <span>Hôm nay</span>
                    </div>

                    <div class="message incoming">
                        <div class="message-content">
                            Chào bạn, tôi muốn hỏi về tài liệu môn Mạng máy tính, bạn có thể chia sẻ cho tôi được không?
                        </div>
                        <div class="message-time">09:15</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            Chào bạn, tôi có đây. Bạn cần tài liệu nào ạ?
                        </div>
                        <div class="message-time">09:17</div>
                    </div>

                    <div class="message incoming">
                        <div class="message-content">
                            Mình cần slide bài giảng tuần 5 và tài liệu thực hành lab 3 ạ. Hôm đó mình nghỉ ốm nên không có ghi chép.
                        </div>
                        <div class="message-time">09:20</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            OK, tôi sẽ gửi cho bạn vào chiều nay. Để tôi tổng hợp lại tài liệu đã.
                        </div>
                        <div class="message-time">09:22</div>
                    </div>

                    <div class="message incoming">
                        <div class="message-content">
                            Cảm ơn bạn nhiều, bạn có thể gửi qua email cũng được. Email của mình là b.tt123456@tlu.edu.vn
                        </div>
                        <div class="message-time">09:25</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            Đã ghi lại. Tôi sẽ gửi qua cả email và tin nhắn ở đây để bạn tiện theo dõi.
                        </div>
                        <div class="message-time">09:27</div>
                    </div>

                    <div class="message incoming">
                        <div class="message-content">
                            Tuyệt vời! Tiện đây cho mình hỏi luôn, bài tập lab 3 đến khi nào phải nộp vậy?
                        </div>
                        <div class="message-time">10:05</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            Thầy yêu cầu nộp vào buổi học tới, tức là thứ 5 tuần sau (11/04) đó bạn.
                        </div>
                        <div class="message-time">10:10</div>
                    </div>

                    <div class="message incoming message-with-image">
                        <div class="message-content">
                            Mình có chụp lại trang bìa bài tập như này, bạn xem có đúng form không nhé?
                            <img src="https://via.placeholder.com/400x300?text=Assignment+Cover" alt="Assignment Cover" class="message-image">
                        </div>
                        <div class="message-time">10:32</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            Đúng rồi bạn, form như vậy là chuẩn. Nhớ ghi rõ họ tên, mã SV và lớp ở bên trên góc phải nữa nhé.
                        </div>
                        <div class="message-time">10:37</div>
                    </div>

                    <div class="message incoming">
                        <div class="message-content">
                            OK, cảm ơn bạn rất nhiều!
                        </div>
                        <div class="message-time">10:40</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            Không có gì đâu, có thắc mắc gì cứ hỏi mình nhé.
                        </div>
                        <div class="message-time">10:41</div>
                    </div>

                    <div class="message outgoing">
                        <div class="message-content">
                            À quên, nhớ kiểm tra email nhé, tôi sẽ gửi cho bạn vào chiều nay.
                        </div>
                        <div class="message-time">12:30</div>
                    </div>
                </div>

                <div class="chat-input">
                    <button class="attachment-btn">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <textarea class="form-control" placeholder="Nhập tin nhắn..."></textarea>
                    <button class="send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Empty State (Initially Hidden) -->
        <div class="empty-state d-none">
            <i class="far fa-comment-dots"></i>
            <h4>Chưa có cuộc trò chuyện nào</h4>
            <p>Bắt đầu một cuộc trò chuyện mới với các thành viên trong trường.</p>
            <button class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fas fa-plus me-2"></i> Tạo cuộc trò chuyện mới
            </button>
        </div>
    </div>

    <!-- New Message Button -->
    <a href="#" class="new-message-btn">
        <i class="fas fa-pen"></i>
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

    <!-- New Message Modal -->
    <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newMessageModalLabel">Tin nhắn mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="recipientInput" class="form-label">Gửi đến:</label>
                        <input type="text" class="form-control" id="recipientInput" placeholder="Nhập tên hoặc mã số">
                    </div>
                    <div class="mb-3">
                        <label for="messageInput" class="form-label">Nội dung tin nhắn:</label>
                        <textarea class="form-control" id="messageInput" rows="5" placeholder="Nhập nội dung tin nhắn..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary">Gửi tin nhắn</button>
                </div>
            </div>
        </div>
    </div>

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

            // New message button opens modal
            document.querySelector('.new-message-btn').addEventListener('click', function(e) {
                e.preventDefault();
                var newMessageModal = new bootstrap.Modal(document.getElementById('newMessageModal'));
                newMessageModal.show();
            });

            // Auto-resize textarea
            document.querySelector('.chat-input textarea').addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });
    </script>
</body>
</html>
