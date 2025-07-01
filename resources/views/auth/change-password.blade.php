<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi Mật Khẩu</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Logo_TLU.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .password-card {
            max-width: 500px;
            margin: 100px auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #005b96 0%, #03396c 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-bottom: none;
        }
        .header-icon {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .header-icon i {
            font-size: 36px;
            color: #005b96;
        }
        .form-floating {
            margin-bottom: 20px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #005b96 0%, #03396c 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #00487a 0%, #022b56 100%);
        }
        .btn-back {
            background-color: #6c757d;
            border: none;
            color: white;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        .password-feedback {
            margin-top: 5px;
            font-size: 0.85rem;
        }
        .form-control:focus {
            border-color: #005b96;
            box-shadow: 0 0 0 0.25rem rgba(0, 91, 150, 0.25);
        }
        .password-strength-meter {
            height: 5px;
            background-color: #e9ecef;
            margin-bottom: 15px;
            border-radius: 3px;
            overflow: hidden;
        }
        .password-strength-meter div {
            height: 100%;
            border-radius: 3px;
            transition: width 0.5s;
        }
        .toggle-password {
            cursor: pointer;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card password-card">
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h3>Đổi Mật Khẩu</h3>
                <p class="mb-0">Cập nhật mật khẩu để bảo vệ tài khoản của bạn</p>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form id="passwordChangeForm" action="{{ route('password.change') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại">
                        <label for="current_password">Mật khẩu hiện tại</label>
                        <span class="toggle-password" onclick="togglePassword('current_password')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    
                    <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Mật khẩu mới" oninput="checkPasswordStrength()">
                        <label for="new_password">Mật khẩu mới</label>
                        <span class="toggle-password" onclick="togglePassword('new_password')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    
                    <div class="password-strength-meter">
                        <div id="strengthMeter" style="width: 0%; background-color: #dc3545;"></div>
                    </div>
                    
                    <div id="passwordFeedback" class="password-feedback text-muted mb-3">
                        Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.
                    </div>
                    
                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Xác nhận mật khẩu mới" oninput="checkPasswordMatch()">
                        <label for="new_password_confirmation">Xác nhận mật khẩu mới</label>
                        <span class="toggle-password" onclick="togglePassword('new_password_confirmation')">
                            <i class="far fa-eye"></i>
                        </span>
                    </div>
                    
                    <div id="passwordMatchFeedback" class="password-feedback mb-4"></div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home.index') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại trang chủ
                        </a>
                        <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // Hiển thị thông báo thành công nếu có
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        
        // Hiển thị thông báo lỗi nếu có
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
        
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = passwordInput.nextElementSibling.nextElementSibling.querySelector('i');
            
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
        
        function checkPasswordStrength() {
            const password = document.getElementById("new_password").value;
            const meter = document.getElementById("strengthMeter");
            const feedback = document.getElementById("passwordFeedback");
            
            // Reset
            meter.style.width = "0%";
            meter.style.backgroundColor = "#dc3545";
            
            if (password === "") {
                feedback.innerHTML = "Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.";
                return;
            }
            
            // Kiểm tra độ mạnh
            let strength = 0;
            const patterns = [
                /.{8,}/, // Ít nhất 8 ký tự
                /[A-Z]/, // Ít nhất 1 chữ hoa
                /[a-z]/, // Ít nhất 1 chữ thường
                /[0-9]/, // Ít nhất 1 số
                /[^A-Za-z0-9]/ // Ít nhất 1 ký tự đặc biệt
            ];
            
            patterns.forEach(pattern => {
                if (pattern.test(password)) strength++;
            });
            
            // Cập nhật meter và feedback
            let meterWidth = (strength / patterns.length) * 100;
            meter.style.width = meterWidth + "%";
            
            let message = "";
            
            if (strength < 2) {
                meter.style.backgroundColor = "#dc3545"; // Đỏ - yếu
                message = "Mật khẩu quá yếu! Cần thêm các yếu tố bảo mật.";
            } else if (strength < 4) {
                meter.style.backgroundColor = "#ffc107"; // Vàng - trung bình
                message = "Mật khẩu trung bình. Có thể cải thiện thêm.";
            } else {
                meter.style.backgroundColor = "#198754"; // Xanh - mạnh
                message = "Mật khẩu mạnh. Rất tốt!";
            }
            
            feedback.innerHTML = message;
        }
        
        function checkPasswordMatch() {
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("new_password_confirmation").value;
            const feedback = document.getElementById("passwordMatchFeedback");
            
            if (confirmPassword === "") {
                feedback.innerHTML = "";
                feedback.className = "password-feedback mb-4";
                return;
            }
            
            if (newPassword === confirmPassword) {
                feedback.innerHTML = "Mật khẩu khớp!";
                feedback.className = "password-feedback text-success mb-4";
            } else {
                feedback.innerHTML = "Mật khẩu không khớp!";
                feedback.className = "password-feedback text-danger mb-4";
            }
        }
    </script>
</body>
</html>
