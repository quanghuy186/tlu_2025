<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang lỗi đẹp với Bootstrap 5</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .error-page {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .error-card:hover {
            transform: translateY(-5px);
        }
        .error-header {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .error-code {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .error-bg-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-size: 20px 20px;
            background-image: radial-gradient(circle, #fff 1px, transparent 1px);
        }
        .error-body {
            padding: 2.5rem;
            text-align: center;
        }
        .error-title {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .error-text {
            color: #6c757d;
            margin-bottom: 2rem;
        }
        .back-home {
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .back-home:hover {
            transform: scale(1.05);
        }
        .error-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        /* 404 Theme */
        .error-404 .error-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
        }
        .error-404 .error-icon {
            color: #2575fc;
        }
        .error-404 .back-home {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
        }
        /* 403 Theme */
        .error-403 .error-header {
            background: linear-gradient(135deg, #f83600, #fe8c00);
        }
        .error-403 .error-icon {
            color: #fe8c00;
        }
        .error-403 .back-home {
            background: linear-gradient(135deg, #f83600, #fe8c00);
            color: white;
        }
        /* Switch Button */
        .switch-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .btn-switch {
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Switch Button -->
    <div class="switch-container">
        <button class="btn btn-primary btn-switch" onclick="toggleErrorPage()">
            Chuyển trang lỗi
        </button>
    </div>

    <!-- 404 Error Page -->
    <div id="error404" class="error-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="error-card error-404">
                        <div class="error-header">
                            <div class="error-code">404</div>
                            <div class="error-bg-pattern"></div>
                        </div>
                        <div class="error-body">
                            <i class="fas fa-search error-icon"></i>
                            <h2 class="error-title">Không tìm thấy trang</h2>
                            <p class="error-text">
                                Trang bạn đang tìm kiếm có thể đã bị xóa, đổi tên hoặc tạm thời không khả dụng.
                            </p>
                            <div class="d-flex flex-column gap-3">
                                <a href="#" class="btn back-home">
                                    <i class="fas fa-home me-2"></i>Trở về trang chủ
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    <i class="fas fa-headset me-2"></i>Liên hệ hỗ trợ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 403 Error Page -->
    <div id="error403" class="error-page" style="display: none;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="error-card error-403">
                        <div class="error-header">
                            <div class="error-code">403</div>
                            <div class="error-bg-pattern"></div>
                        </div>
                        <div class="error-body">
                            <i class="fas fa-ban error-icon"></i>
                            <h2 class="error-title">Truy cập bị từ chối</h2>
                            <p class="error-text">
                                Bạn không có quyền truy cập vào trang này. Vui lòng liên hệ quản trị viên nếu bạn cho rằng đây là lỗi.
                            </p>
                            <div class="d-flex flex-column gap-3">
                                <a href="#" class="btn back-home">
                                    <i class="fas fa-home me-2"></i>Trở về trang chủ
                                </a>
                                <a href="#" class="btn btn-outline-secondary">
                                    <i class="fas fa-lock me-2"></i>Đăng nhập lại
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle between error pages
        function toggleErrorPage() {
            const error404 = document.getElementById('error404');
            const error403 = document.getElementById('error403');
            
            if (error404.style.display === 'none') {
                error404.style.display = 'flex';
                error403.style.display = 'none';
            } else {
                error404.style.display = 'none';
                error403.style.display = 'flex';
            }
        }
    </script>
</body>
</html>