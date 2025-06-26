<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bài viết đã được phê duyệt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e9ecef;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 0.8em;
            color: #6c757d;
            border-radius: 0 0 5px 5px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .post-info {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Thông báo phê duyệt bài viết</h2>
    </div>
    
    <div class="content">
        <p>Xin chào {{ $post->author->name }},</p>
        
        <p>Chúng tôi vui mừng thông báo rằng bài viết của bạn đã được phê duyệt và đã được xuất bản trên diễn đàn.</p>
        
        <div class="post-info">
            <h3>{{ $post->title }}</h3>
            <p><strong>Thời gian phê duyệt:</strong> {{ $post->approved_at->format('d/m/Y H:i') }}</p>
        </div>
        
        <p>Bài viết của bạn hiện đã có thể được xem bởi tất cả người dùng trên diễn đàn. Cảm ơn bạn đã đóng góp!</p>
        
        <a href="{{ route('forum.posts.show', $post->id) }}" class="button">Xem bài viết</a>
        
        <p>Nếu bạn có bất kỳ câu hỏi hoặc cần hỗ trợ gì, đừng ngần ngại liên hệ với chúng tôi.</p>
        
        <p>Trân trọng,<br>
        {{ config('app.name') }}</p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. Tất cả các quyền được bảo lưu.</p>
    </div>
</body>
</html>