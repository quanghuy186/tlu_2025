
{{-- resources/views/emails/verification.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Xác thực tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Xác thực tài khoản của bạn</h2>
        </div>

        <p>Xin chào {{ $user->full_name }},</p>

        <p>Cảm ơn bạn đã đăng ký tài khoản! Vui lòng nhấp vào nút bên dưới để xác thực địa chỉ email của bạn:</p>

        <div style="text-align: center;">
            <a href="{{ route('verification.verify', $user->verification_token) }}" class="btn">Xác thực tài khoản</a>
        </div>

        <p>Nếu bạn không thể nhấp vào nút, vui lòng sao chép và dán liên kết sau vào trình duyệt của bạn:</p>

        <p>{{ route('verification.verify', $user->verification_token) }}</p>

        <p>Liên kết này sẽ hết hạn sau 3 ngày.</p>

        <p>Nếu bạn không tạo tài khoản này, vui lòng bỏ qua email này.</p>

        <div class="footer">
            <p>Trân trọng,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
