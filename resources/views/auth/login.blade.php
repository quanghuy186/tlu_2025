<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Đăng nhập - Danh bạ điện tử Đại học Thủy Lợi</title> --}}
    <title>{{ SEO::getTitle() }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- toastr.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- toastr.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            line-height: 1.6;
        }

        .login-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 15px;
        }

        .logo-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .logo-header h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 5px;
        }

        .logo-header p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .login-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-card .row {
            min-height: 500px;
        }

        .left-panel {
            background: linear-gradient(rgba(0, 91, 170, 0.9), rgba(0, 91, 170, 0.8)), url('https://via.placeholder.com/800x1000') center/cover no-repeat;
            color: white;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }

        .left-panel .decoration {
            position: absolute;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .left-panel .decoration-1 {
            top: -75px;
            left: -75px;
        }

        .left-panel .decoration-2 {
            bottom: -75px;
            right: -75px;
        }

        .left-panel h3 {
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 15px;
        }

        .left-panel h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            /* width: 500px;
             */
             width: 100%;
            height: 3px;
            background-color: var(--accent-color);
        }

        .left-panel p {
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .feature-list li i {
            color: var(--accent-color);
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .right-panel {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h4 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-floating {
            margin-bottom: 20px;
        }

        .form-floating label {
            color: #6c757d;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 91, 170, 0.25);
        }

        .password-field {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
        }

        .password-toggle:focus {
            outline: none;
        }

        .form-check {
            margin-bottom: 20px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .login-btn {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .login-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .forgot-link {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-link a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s;
        }

        .forgot-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .register-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .register-link a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-to-home a {
            color: #6c757d;
            text-decoration: none;
            transition: all 0.3s;
        }

        .back-to-home a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="logo-header">
            <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU" class="img-fluid">
            <h5>Hệ thống tra cứu và trao đổi thông tin nội bộ</h5>
            <p>TRƯỜNG ĐẠI HỌC THỦY LỢI</p>
        </div>

        <div class="login-card">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="left-panel">
                        <div class="decoration decoration-1"></div>
                        <div class="decoration decoration-2"></div>

                        <h3>Kết nối với cộng đồng TLU</h3>
                        <p>Hệ thống tra cứu và trao đổi thông tin của Trường Đại học Thủy Lợi giúp bạn dễ dàng tra cứu vào trao đổi thông tin với những người dùng khác thuộc Đại Học Thủy Lợi.</p>

                        <ul class="feature-list">
                            <li><i class="fas fa-check-circle"></i> Tra cứu thông tin nhanh chóng</li>
                            <li><i class="fas fa-check-circle"></i> Dữ liệu chính xác và cập nhật</li>
                            <li><i class="fas fa-check-circle"></i> Bảo mật thông tin cá nhân</li>
                            <li><i class="fas fa-check-circle"></i> Giao diện thân thiện người dùng</li>
                            <li><i class="fas fa-check-circle"></i> Hỗ trợ trên nhiều thiết bị</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="right-panel">
                        <h4>Đăng nhập</h4>

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                            </div>

                            <div class="form-floating password-field">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Mật khẩu</label>
                                <button type="button" class="password-toggle" id="passwordToggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 login-btn">
                                <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                            </button>
                        </form>

                        <script>
                            @if (session('error'))
                                toastr.error("{{ session('error') }}");
                            @endif
                        </script>

                        <div class="forgot-link">
                            <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                        </div>

                        <div class="register-link">
                            <p>Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{--
        <div class="back-to-home">
            <a href="#"><i class="fas fa-arrow-left me-2"></i> Quay lại trang chủ</a>
        </div> --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle eye icon
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
