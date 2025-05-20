<!-- resources/views/test-pusher.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Kiểm tra Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Kiểm tra Pusher</h1>
    
    <button id="test-btn">Gửi sự kiện thử nghiệm</button>
    
    <div id="messages"></div>
    
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Bật chế độ debug
        Pusher.logToConsole = true;
        
        // Khởi tạo Pusher
        var pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            encrypted: true
        });
        
        // Đăng ký kênh
        var channel = pusher.subscribe('test-channel');
        
        // Lắng nghe sự kiện
        channel.bind('App\\Events\\TestEvent', function(data) {
            console.log('Nhận được sự kiện:', data);
            $('#messages').append('<p>Nhận được: ' + data.message + '</p>');
        });
        
        // Gửi sự kiện thử nghiệm khi nhấn nút
        $('#test-btn').click(function() {
            $.ajax({
                url: '/test-event',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Đã gửi sự kiện thử nghiệm');
                }
            });
        });
        
        // Log trạng thái kết nối
        pusher.connection.bind('connected', function() {
            console.log('Đã kết nối thành công đến Pusher!');
            $('#messages').append('<p class="success">Đã kết nối Pusher!</p>');
        });
        
        pusher.connection.bind('error', function(err) {
            console.error('Lỗi kết nối Pusher:', err);
            $('#messages').append('<p class="error">Lỗi kết nối: ' + JSON.stringify(err) + '</p>');
        });
    </script>
</body>
</html>