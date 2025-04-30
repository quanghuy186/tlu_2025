<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ SEO::getTitle() }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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

        .register-container {
            max-width: 900px;
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

        .register-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .register-card .row {
            min-height: 550px;
        }

        .left-panel {
            background: linear-gradient(rgba(0, 91, 170, 0.9), rgba(0, 91, 170, 0.8)), url('/api/placeholder/800/1000') center/cover no-repeat;
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
            width: 50px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .left-panel p {
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .steps-list {
            list-style: none;
            padding: 0;
            margin: 0;
            counter-reset: step-counter;
        }

        .steps-list li {
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            counter-increment: step-counter;
        }

        .steps-list li::before {
            content: counter(step-counter);
            min-width: 28px;
            height: 28px;
            background-color: var(--accent-color);
            color: white;
            font-weight: 600;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            margin-top: 2px;
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

        .register-btn {
            background-color: var(--primary-color);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .register-btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .alert-info {
            background-color: rgba(0, 91, 170, 0.1);
            color: var(--primary-color);
            border: none;
            border-left: 4px solid var(--primary-color);
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

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container register-container">
        <div class="logo-header">
            <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU" class="img-fluid">
            <h5>Hệ thống tra cứu và  trao đổi thông tin nội bộ</h5>
            <p>TRƯỜNG ĐẠI HỌC THỦY LỢI</p>
        </div>

        <div class="register-card">
            <div class="row g-0">
                <div class="col-md-5">
                    <div class="left-panel">
                        <div class="decoration decoration-1"></div>
                        <div class="decoration decoration-2"></div>

                        <h3>Tham gia cộng đồng TLU</h3>
                        <p>Hãy đăng ký tài khoản để truy cập vào hệ thống tra cứu và trao đổi thông tin để kết nối với cộng đồng Đại học Thủy Lợi.</p>

                        <ul class="steps-list">
                            <li>Sử dụng email trường cấp để đăng ký tài khoản.</li>
                            <li>Điền đầy đủ thông tin cá nhân cần thiết.</li>
                            <li>Xác minh tài khoản qua email được gửi đến bạn.</li>
                            <li>Đăng nhập và cập nhật thông tin cá nhân của bạn.</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="right-panel">
                        <h4>Đăng ký tài khoản</h4>

                        {{-- <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i> Chỉ tài khoản email của trường mới được đăng ký.
                        </div> --}}
                        @if(session('duplicate_email'))
                            <div class="alert alert-warning">
                                <p>Email này đã được đăng ký trước đó nhưng chưa xác thực.</p>
                                <p>Bạn có muốn:</p>
                                <a href="{{ route('verification.resend.form') }}" class="btn btn-primary">Gửi lại email xác thực</a>
                                <a href="{{ route('account.refresh.form') }}" class="btn btn-secondary">Đăng ký lại với email này</a>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-floating">
                                <input type="name" class="form-control" id="name" name="name" placeholder="Full name" >
                                <label for="name"><i class="fas fa-envelope me-2"></i>Full name</label>
                                <div class="form-text">Sử dụng tên thật của bản thân để đăng ký.</div>
                            </div>

                            @if ($errors->has('name'))
                                <div class="text-danger alert alert-danger">{{ $errors->first('name') }}</div>
                            @endif


                            <div class="form-floating">
                                {{-- <input type="email" class="form-control" id="email" name="email" placeholder="Email" pattern="[a-z0-9._%+-]+@e\.tlu\.edu\.vn$"> --}}
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                <div class="form-text">Sử dụng email do trường cấp để đăng ký.</div>
                            </div>

                            <div class="d-flex flex-column flex-md-row gap-md-3">
                                <div class="flex-grow-1 mb-3 mb-md-0">
                                    <div class="form-floating password-field">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu" minlength="8">
                                        <label for="password"><i class="fas fa-lock me-2"></i>Mật khẩu</label>
                                        <button type="button" class="password-toggle" id="passwordToggle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="form-floating password-field">
                                        <input type="password" class="form-control" id="passwordConfirm" name="password_confirmation" placeholder="Xác nhận mật khẩu" minlength="8">
                                        <label for="passwordConfirm"><i class="fas fa-lock me-2"></i>Xác nhận mật khẩu</label>
                                        <button type="button" class="password-toggle" id="passwordConfirmToggle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-text mb-3">Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.</div>
                            @if ($errors->has('password'))
								<div class="text-danger alert alert-danger">{{ $errors->first('password') }}</div>
							@endif

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms">
                                <label class="form-check-label" for="terms">
                                    Tôi đồng ý với <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Điều khoản sử dụng</a> và <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">Chính sách bảo mật</a>
                                </label>
                            </div>

                            @if ($errors->has('terms'))
								<div class="text-danger alert alert-danger">{{ $errors->first('terms') }}</div>
							@endif

                            <button type="submit" class="btn btn-primary w-100 register-btn">
                                <i class="fas fa-user-plus me-2"></i> Đăng ký
                            </button>
                        </form>

                        <div class="login-link">
                            <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="back-to-home">
            <a href="/"><i class="fas fa-arrow-left me-2"></i> Quay lại đăng nhập</a>
        </div>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Điều khoản sử dụng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Khi sử dụng hệ thống danh bạ điện tử Trường Đại học Thủy Lợi, bạn đồng ý tuân thủ các điều khoản sau:</p>
                    <ul>
                        <li>Không chia sẻ thông tin đăng nhập với người khác</li>
                        <li>Không sử dụng thông tin trong hệ thống vào mục đích cá nhân, thương mại hoặc bất kỳ mục đích nào khác ngoài phạm vi học tập và công tác tại Trường</li>
                        <li>Không cung cấp thông tin sai lệch hoặc gây hiểu nhầm</li>
                        <li>Chịu trách nhiệm về các hoạt động được thực hiện thông qua tài khoản của bạn</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Chính sách bảo mật</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Hệ thống danh bạ điện tử Trường Đại học Thủy Lợi cam kết bảo vệ thông tin cá nhân của người dùng:</p>
                    <ul>
                        <li>Thông tin cá nhân chỉ được sử dụng cho mục đích liên lạc trong phạm vi hoạt động của Trường</li>
                        <li>Hệ thống áp dụng các biện pháp bảo mật để bảo vệ thông tin cá nhân</li>
                        <li>Thông tin được phân quyền truy cập theo đúng vai trò và chức năng của từng đối tượng người dùng</li>
                        <li>Không cung cấp thông tin cá nhân cho bên thứ ba khi không có sự đồng ý của chủ sở hữu</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @elseif(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @elseif(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const passwordToggle = document.getElementById('passwordToggle');
        const passwordInput = document.getElementById('password');

        passwordToggle.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        const passwordConfirmToggle = document.getElementById('passwordConfirmToggle');
        const passwordConfirmInput = document.getElementById('passwordConfirm');

        passwordConfirmToggle.addEventListener('click', function() {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // passwordConfirmInput.addEventListener('input', function() {
        //     if (this.value !== passwordInput.value) {
        //         this.setCustomValidity('Mật khẩu không khớp');
        //     } else {
        //         this.setCustomValidity('');
        //     }
        // });

        // Validate email format
        // const emailInput = document.getElementById('email');
        // emailInput.addEventListener('input', function() {
        //     const isValid = /[a-z0-9._%+-]+@e\.tlu\.edu\.vn$/.test(this.value);
        //     if (!isValid) {
        //         this.setCustomValidity('Email phải có định dạng @tlu.edu.vn');
        //     } else {
        //         this.setCustomValidity('');
        //     }
        // });
    </script>
</body>
</html>
