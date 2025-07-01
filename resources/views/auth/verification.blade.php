<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực Email - Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo_TLU.png') }}">

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
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            line-height: 1.6;
        }

        .verify-container {
            max-width: 700px;
            margin: 30px auto;
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

        .verify-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .verify-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .verify-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
            transform: translateX(-50%);
        }

        .email-icon {
            text-align: center;
            font-size: 60px;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .verify-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 91, 170, 0.25);
        }

        .resend-btn {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .resend-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .login-link a:hover {
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
    </style>
</head>
<body>
    <div class="container verify-container">
        <div class="logo-header">
            <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU" class="img-fluid">
            <h5>Hệ thống tra cứu và trao đổi thông tin nội bộ</h5>
            <p>TRƯỜNG ĐẠI HỌC THỦY LỢI</p>
        </div>

        <div class="verify-card">
            <div class="email-icon">
                <i class="fas fa-envelope-open-text"></i>
            </div>

            <h3 class="verify-title">Xác thực địa chỉ email</h3>

            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning" role="alert">
                    {{ session('warning') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="verify-message">
                <p>Một liên kết xác thực đã được gửi đến địa chỉ email của bạn. Vui lòng kiểm tra hộp thư đến (và thư mục spam) để hoàn tất quá trình đăng ký.</p>
                <p>Nếu bạn không nhận được email, bạn có thể yêu cầu gửi lại bằng cách điền email đăng ký dưới đây.</p>
            </div>

            <form action="{{ route('verification.resend') }}" method="POST" class="resend-form">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email đăng ký</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="nhập email của bạn" pattern="[a-z0-9._%+-]+@tlu\.edu\.vn$" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Nhập email bạn đã sử dụng để đăng ký.</div>
                </div>

                <button type="submit" class="btn btn-primary w-100 resend-btn">
                    <i class="fas fa-paper-plane me-2"></i> Gửi lại email xác thực
                </button>
            </form>

            <div class="login-link">
                <p>Đã xác thực tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
            </div>
        </div>

        <div class="back-to-home">
            <a href="/"><i class="fas fa-arrow-left me-2"></i> Quay lại trang chủ</a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
