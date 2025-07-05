@extends('layouts.app')

@section('title')
   Tin nhắn
@endsection

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
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <img src="{{ $user->avatar ? asset('storage/avatars/'.$user->avatar) : asset('user_default.jpg') }}" >
                                            </div>
                                        </div>

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
                    {{-- <div class="card-header d-flex align-items-center">
                        <div id="chat-with">Chọn người dùng để bắt đầu trò chuyện</div>
                    </div> --}}

                    <div class="card-header d-flex align-items-center">
                        <div id="chat-with">Chọn người dùng để bắt đầu trò chuyện</div>
                        <div class="ms-auto">
                            <div class="dropdown" id="chat-actions" style="display: none;">
                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item text-danger" href="#" id="delete-conversation">
                                        <i class="bi bi-trash me-2"></i>Xóa cuộc trò chuyện
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <div id="messages-container" class="mb-3" style="height: 400px; overflow-y: auto;">
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
            const urlParams = new URLSearchParams(window.location.search);
            const newUserId = urlParams.get('new_user_id');
            
            if (newUserId) {
                $(`.user-item[data-id="${newUserId}"]`).click();
                
                const url = new URL(window.location);
                url.searchParams.delete('new_user_id');
                window.history.replaceState({}, '', url);
            }
        });

        let currentRecipientId = null;
        
        $('.user-item').on('click', function() {
            const userId = $(this).data('id');
            const userName = $(this).find('h6').text();
            currentRecipientId = userId;
            
            $('#chat-with').text(`Đang trò chuyện với ${userName}`);
            
            $('#message-form').removeClass('d-none');
            $('#recipient-id').val(userId);
            
            $('#messages-container').html('<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
            loadMessages(userId);
            
            $('.user-item').removeClass('active');
            $(this).addClass('active');
            
            $(this).find('.unread-badge').addClass('d-none').find('.badge').text('0');
        });
        
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
                        messageContent = `<div><a href="${message.file_url}" target="_blank" class="d-flex align-items-center text-black">
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
        
        function isImageFile(url) {
            const extensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];
            return extensions.some(ext => url.toLowerCase().endsWith(ext));
        }
        
        function formatTime(dateTime) {
            const date = new Date(dateTime);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
        
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }
        
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
                    const message = response.message;
                    const messageContent = formData.get('content') || '';
                    
                    $('#message-input').val('');
                    $('#file-input').val('');
                    $('#file-preview').addClass('d-none');
                    
                    loadMessages(currentRecipientId);
                }
            });
        });
        
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
        
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.Echo === 'undefined') {
                
                if (typeof Pusher !== 'undefined') {
                    
                    Pusher.logToConsole = true;
                    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
                        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
                        encrypted: true
                    });
                    
                    const channel = pusher.subscribe('private-chat.{{ Auth::id() }}');
                    
                    channel.bind('message.sent', function(data) {
                        const message = data.message;
                        
                        if (currentRecipientId && currentRecipientId == message.sender_user_id) {
                            loadMessages(currentRecipientId);
                            
                            $.ajax({
                                url: `/messages/${message.id}/read`,
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        } else {
                            const userItem = $(`.user-item[data-id="${message.sender_user_id}"]`);
                            const unreadBadge = userItem.find('.unread-badge');
                            const badge = unreadBadge.find('.badge');
                            
                            unreadBadge.removeClass('d-none');
                            badge.text(parseInt(badge.text() || 0) + 1);
                            
                            const audio = new Audio('/notification.mp3');
                            audio.play();
                            
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
                window.Echo.private('chat.{{ Auth::id() }}')
                    .listen('.message.sent', (e) => {
                        const message = e.message;
                        if (currentRecipientId && currentRecipientId == message.sender_user_id) {
                            loadMessages(currentRecipientId);
                            $.ajax({
                                url: `/messages/${message.id}/read`,
                                method: 'PUT',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                        } else {
                            const userItem = $(`.user-item[data-id="${message.sender_user_id}"]`);
                            const unreadBadge = userItem.find('.unread-badge');
                            const badge = unreadBadge.find('.badge');
                            
                            unreadBadge.removeClass('d-none');
                            badge.text(parseInt(badge.text() || 0) + 1);
                            const audio = new Audio('/notification.mp3');
                            audio.play();
                            
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

    function showChatActions() {
        $('#chat-actions').show();
    }

    function hideChatActions() {
        $('#chat-actions').hide();
    }

    $('#delete-conversation').on('click', function(e) {
        e.preventDefault();
        
        if (!currentRecipientId) return;
        
        if (confirm('Bạn có chắc chắn muốn xóa toàn bộ cuộc trò chuyện này không? Hành động này không thể hoàn tác.')) {
            $.ajax({
                url: `/conversations/${currentRecipientId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#messages-container').html('<div class="text-center py-5 text-muted"><p>Cuộc trò chuyện đã được xóa</p></div>');
                    
                    $('#chat-with').text('Chọn người dùng để bắt đầu trò chuyện');
                    $('#message-form').addClass('d-none');
                    hideChatActions();
                    currentRecipientId = null;
                    
                    alert('Cuộc trò chuyện đã được xóa thành công.');
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi xóa cuộc trò chuyện. Vui lòng thử lại sau.');
                }
            });
        }
    });

    $('.user-item').on('click', function() {
        const userId = $(this).data('id');
        const userName = $(this).find('h6').text();
        currentRecipientId = userId;
        
        $('#chat-with').text(`Đang trò chuyện với ${userName}`);
        $('#message-form').removeClass('d-none');
        $('#recipient-id').val(userId);
        
        $('#messages-container').html('<div class="text-center py-5"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        loadMessages(userId);
        $('.user-item').removeClass('active');
        $(this).addClass('active');
        $(this).find('.unread-badge').addClass('d-none').find('.badge').text('0');
    });

    $('.user-item').on('click', function() {
        $(this).find('.unread-badge').addClass('d-none').find('.badge').text('0');
        showChatActions();
    });
    </script>
@endsection