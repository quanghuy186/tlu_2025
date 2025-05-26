@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Danh sách người dùng</div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush user-list">
                            @foreach($users as $user)
                                <li class="list-group-item user-item" data-id="{{ $user->id }}">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3">
                                            <!-- Avatar hoặc icon người dùng -->
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('user_default.jpg') }}" >
                                                {{-- {{ $user->avatar ? $user->avatar : asset('user_default.jpg') }} --}}
                                            </div>
                                        </div>
                                        {{-- <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted last-seen"> {{ $user->isOnline ? 'Trực tuyến' : 'Hoạt động x phút trước'}}</small>
                                        </div> --}}

                                        <small class="text-muted last-seen">
                                            @foreach ($user->roles as $role)
                                                @if($role->role_id == 3)
                                                    <h6 class="mb-0">{{ $user->managedDepartment->name }}</h6>
                                                @else
                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                @endif
                                            @endforeach


                                            @if($user->isOnline())
                                                Trực tuyến
                                            @elseif($user->last_seen_at)
                                                Hoạt động {{ $user->last_seen_at->diffInMinutes(now()) }} phút trước
                                            @else
                                                Không hoạt động
                                            @endif
                                        </small>


                                        <div class="ms-auto unread-badge d-none">
                                            <span class="badge bg-danger rounded-pill">0</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <div id="chat-with">Chọn người dùng để bắt đầu trò chuyện</div>
                    </div>
                    <div class="card-body">
                        <div id="messages-container" class="mb-3" style="height: 400px; overflow-y: auto;">
                            <!-- Tin nhắn sẽ được hiển thị ở đây -->
                            <div class="text-center py-5 text-muted" id="no-messages">
                                <i class="bi bi-chat"></i>
                                <p>Chọn người dùng để bắt đầu trò chuyện</p>
                            </div>
                        </div>
                        <form id="message-form" class="d-none">
                            <div class="input-group">
                                <input type="hidden" id="recipient-id" name="recipient_id">
                                <input type="text" id="message-input" name="content" class="form-control" placeholder="Nhập tin nhắn...">
                                <button id="attach-btn" type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-paperclip"></i>
                                </button>
                                <input type="file" id="file-input" name="file" style="display: none;">
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </div>
                            <div id="file-preview" class="mt-2 d-none">
                                <div class="alert alert-info d-flex align-items-center">
                                    <i class="bi bi-file-earmark me-2"></i>
                                    <span id="file-name"></span>
                                    <button type="button" id="remove-file" class="btn-close ms-auto"></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {
            // Kiểm tra xem có tham số new_user_id trên URL không
            const urlParams = new URLSearchParams(window.location.search);
            const newUserId = urlParams.get('new_user_id');
            
            if (newUserId) {
                // Tự động chọn người dùng mới
                $(`.user-item[data-id="${newUserId}"]`).click();
                
                // Xóa tham số khỏi URL để tránh chọn lại khi tải lại trang
                const url = new URL(window.location);
                url.searchParams.delete('new_user_id');
                window.history.replaceState({}, '', url);
            }
        });

        let currentRecipientId = null;
        
        // Xử lý khi chọn người dùng
        $('.user-item').on('click', function() {
            const userId = $(this).data('id');
            const userName = $(this).find('h6').text();
            currentRecipientId = userId;
            
            // Hiển thị tên người được chọn
            $('#chat-with').text(`Đang trò chuyện với ${userName}`);
            
            // Hiển thị form nhắn tin
            $('#message-form').removeClass('d-none');
            $('#recipient-id').val(userId);
            
            // Hiển thị loading
            $('#messages-container').html('<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
            // Tải tin nhắn
            loadMessages(userId);
            
            // Đánh dấu là đã chọn
            $('.user-item').removeClass('active');
            $(this).addClass('active');
            
            // Ẩn badge thông báo
            $(this).find('.unread-badge').addClass('d-none').find('.badge').text('0');
        });
        
        // Tải tin nhắn
        function loadMessages(userId) {
            $.ajax({
                url: `/messages/${userId}`,
                method: 'GET',
                success: function(response) {
                    displayMessages(response.messages);
                    scrollToBottom();
                    markMessagesAsRead(response.messages);
                }
            });
        }
        
        // Hiển thị tin nhắn
        function displayMessages(messages) {
            const container = $('#messages-container');
            container.empty();
            
            if (messages.length === 0) {
                container.html('<div class="text-center py-5 text-muted"><p>Chưa có tin nhắn nào. Hãy bắt đầu cuộc trò chuyện!</p></div>');
                return;
            }
            
            messages.forEach(function(message) {
                const isOwnMessage = message.sender_user_id == '{{ Auth::id() }}';
                const messageClass = isOwnMessage ? 'bg-primary text-white' : 'bg-light';
                const messageAlign = isOwnMessage ? 'align-self-end' : 'align-self-start';
                
                let messageContent = '';
                
                if (message.message_type === 'file') {
                    if (isImageFile(message.file_url)) {
                        messageContent = `<div><img src="${message.file_url}" class="img-fluid rounded" style="max-width: 200px;"></div>`;
                    } else {
                        messageContent = `<div><a href="${message.file_url}" target="_blank" class="d-flex align-items-center">
                            <i class="bi bi-file-earmark me-2"></i> Tập tin đính kèm
                        </a></div>`;
                    }
                    
                    if (message.content) {
                        messageContent += `<div>${message.content}</div>`;
                    }
                } else {
                    messageContent = `<div>${message.content}</div>`;
                }
                
                const messageHtml = `
                    <div class="message ${messageAlign} mb-2" data-id="${message.id}">
                        <div class="message-bubble ${messageClass} p-2 rounded">
                            ${messageContent}
                            <div class="message-meta text-end">
                                <small class="${isOwnMessage ? 'text-white-50' : 'text-muted'}">
                                    ${formatTime(message.sent_at)}
                                    ${isOwnMessage ? `<i class="bi ${message.is_read ? 'bi-check-all' : 'bi-check'}"></i>` : ''}
                                </small>
                            </div>
                        </div>
                    </div>
                `;
                
                container.append(messageHtml);
            });
        }
        
        // Kiểm tra file có phải là hình ảnh
        function isImageFile(url) {
            const extensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];
            return extensions.some(ext => url.toLowerCase().endsWith(ext));
        }
        
        // Format thời gian
        function formatTime(dateTime) {
            const date = new Date(dateTime);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
        
        // Cuộn xuống cuối cùng
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }
        
        // Đánh dấu tin nhắn đã đọc
        function markMessagesAsRead(messages) {
            const unreadMessages = messages.filter(msg => 
                !msg.is_read && msg.recipient_user_id == '{{ Auth::id() }}'
            );
            
            unreadMessages.forEach(function(message) {
                $.ajax({
                    url: `/messages/${message.id}/read`,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        }
        
        // Gửi tin nhắn
        $('#message-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const formData = new FormData(form[0]);
            
            if (!formData.get('content') && !formData.get('file').name) {
                return;
            }
            
            $.ajax({
                url: '/messages',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Thêm tin nhắn vào giao diện
                    const message = response.message;
                    const messageContent = formData.get('content') || '';
                    
                    // Reset form
                    $('#message-input').val('');
                    $('#file-input').val('');
                    $('#file-preview').addClass('d-none');
                    
                    // Tải lại tin nhắn
                    loadMessages(currentRecipientId);
                }
            });
        });
        
        // Xử lý chọn file
        $('#attach-btn').on('click', function() {
            $('#file-input').click();
        });
        
        $('#file-input').on('change', function() {
            const file = this.files[0];
            if (file) {
                $('#file-name').text(file.name);
                $('#file-preview').removeClass('d-none');
            } else {
                $('#file-preview').addClass('d-none');
            }
        });
        
        $('#remove-file').on('click', function() {
            $('#file-input').val('');
            $('#file-preview').addClass('d-none');
        });
        
        // Kiểm tra và thiết lập Echo để lắng nghe sự kiện
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra xem Echo đã được khởi tạo chưa
            if (typeof window.Echo === 'undefined') {
                console.error('Laravel Echo chưa được khởi tạo. Hãy kiểm tra file bootstrap.js');
                
                // Khởi tạo Pusher trực tiếp nếu Echo không tồn tại
                if (typeof Pusher !== 'undefined') {
                    console.log('Đang khởi tạo kết nối Pusher trực tiếp...');
                    
                    // Khởi tạo Pusher
                    Pusher.logToConsole = true;
                    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                        encrypted: true
                    });
                    
                    // Đăng ký kênh private
                    const channel = pusher.subscribe('private-chat.{{ Auth::id() }}');
                    
                    // Lắng nghe sự kiện
                    channel.bind('message.sent', function(data) {
                        console.log('Nhận được tin nhắn:', data);
                        const message = data.message;
                        
                        // Nếu đang trò chuyện với người gửi tin nhắn
                        if (currentRecipientId && currentRecipientId == message.sender_user_id) {
                            // Tải lại tin nhắn
                            loadMessages(currentRecipientId);
                            
                            // Đánh dấu đã đọc
                            $.ajax({
                                url: `/messages/${message.id}/read`,
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        } else {
                            // Hiển thị thông báo có tin nhắn mới
                            const userItem = $(`.user-item[data-id="${message.sender_user_id}"]`);
                            const unreadBadge = userItem.find('.unread-badge');
                            const badge = unreadBadge.find('.badge');
                            
                            unreadBadge.removeClass('d-none');
                            badge.text(parseInt(badge.text() || 0) + 1);
                            
                            // Thông báo âm thanh
                            const audio = new Audio('/notification.mp3');
                            audio.play();
                            
                            // Hiển thị notification nếu được cho phép
                            if (Notification.permission === 'granted') {
                                const sender = userItem.find('h6').text();
                                const notification = new Notification('Tin nhắn mới', {
                                    body: `${sender}: ${message.content}`,
                                    icon: '/favicon.ico'
                                });
                                
                                notification.onclick = function() {
                                    window.focus();
                                    userItem.click();
                                };
                            }
                        }
                    });
                } else {
                    console.error('Cả Laravel Echo và Pusher JS đều không được tải!');
                }
            } else {
                console.log('Echo đã được khởi tạo, đang lắng nghe sự kiện...');
                
                // Sử dụng Echo bình thường
                window.Echo.private('chat.{{ Auth::id() }}')
                    .listen('.message.sent', (e) => {
                        console.log('Nhận được tin nhắn từ Echo:', e);
                        const message = e.message;
                        
                        // Nếu đang trò chuyện với người gửi tin nhắn
                        if (currentRecipientId && currentRecipientId == message.sender_user_id) {
                            // Tải lại tin nhắn
                            loadMessages(currentRecipientId);
                            
                            // Đánh dấu đã đọc
                            $.ajax({
                                url: `/messages/${message.id}/read`,
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        } else {
                            // Hiển thị thông báo có tin nhắn mới
                            const userItem = $(`.user-item[data-id="${message.sender_user_id}"]`);
                            const unreadBadge = userItem.find('.unread-badge');
                            const badge = unreadBadge.find('.badge');
                            
                            unreadBadge.removeClass('d-none');
                            badge.text(parseInt(badge.text() || 0) + 1);
                            
                            // Thông báo âm thanh
                            const audio = new Audio('/notification.mp3');
                            audio.play();
                            
                            // Hiển thị notification nếu được cho phép
                            if (Notification.permission === 'granted') {
                                const sender = userItem.find('h6').text();
                                const notification = new Notification('Tin nhắn mới', {
                                    body: `${sender}: ${message.content}`,
                                    icon: '/favicon.ico'
                                });
                                
                                notification.onclick = function() {
                                    window.focus();
                                    userItem.click();
                                };
                            }
                        }
                    });
            }
        });
    </script>
@endsection