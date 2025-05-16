@extends('layouts.app')

@section('content')
<section class="messages-header">
    <div class="container text-center">
        <h1>Tin nhắn nội bộ TLU</h1>
        <p>Trao đổi thông tin trực tiếp với giảng viên, sinh viên và các phòng ban trong trường</p>
    </div>
</section>

<!-- Breadcrumb -->
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin nhắn</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Meta data -->
<meta name="user-id" content="{{ Auth::id() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Main Content -->
<div class="container">
    <div class="messages-container">
        <!-- Contacts List -->
        <div class="contacts-list">
            <div class="contacts-header">
                <div class="search-contact">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Tìm kiếm liên hệ...">
                </div>
            </div>
            <!-- Contacts will be loaded dynamically via JS -->
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <div class="chat-header">
                <!-- Will be dynamically updated when a contact is selected -->
                <div class="chat-user">
                    <div class="select-contact-prompt">
                        <h5>Chọn một cuộc trò chuyện hoặc bắt đầu một cuộc trò chuyện mới</h5>
                    </div>
                </div>
            </div>

                <div class="chat-messages">
                <!-- Messages will be loaded here -->
                </div>
            

            <div class="chat-input">
                <button class="attachment-btn">
                    <i class="fas fa-paperclip"></i>
                </button>
                <textarea class="form-control" placeholder="Nhập tin nhắn..."></textarea>
                <button class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
                <input type="file" id="file-upload" style="display: none">
                <div class="file-info d-none"></div>
            </div>
        </div>
    </div>

    <!-- Empty State (Initially Hidden) -->
    <div class="empty-state d-none">
        <i class="far fa-comment-dots"></i>
        <h4>Chưa có cuộc trò chuyện nào</h4>
        <p>Bắt đầu một cuộc trò chuyện mới với các thành viên trong trường.</p>
        <button class="btn btn-primary rounded-pill px-4 py-2 new-conversation-btn">
            <i class="fas fa-plus me-2"></i> Tạo cuộc trò chuyện mới
        </button>
    </div>
</div>

<!-- New Message Button -->
<a href="#" class="new-message-btn">
    <i class="fas fa-pen"></i>
</a>
@endsection

{{-- @push('scripts') --}}
<!-- Ensure Alpine.js and Bootstrap's JS are loaded correctly -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS for messaging functionality -->
<script>
    // Add this script to your Blade template or in a separate JS file
$(document).ready(function() {
    const userId = $('meta[name="user-id"]').attr('content');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    
    // Set up CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });
    
    // Load contacts initially
    loadContacts();
    
    // Function to load contacts
    function loadContacts() {
        $.ajax({
            url: '/get-contacts',
            type: 'GET',
            success: function(contacts) {
                renderContacts(contacts);
            },
            error: function(error) {
                console.error('Error loading contacts:', error);
            }
        });
    }
    
    // Function to render contacts
    function renderContacts(contacts) {
        const contactsList = $('.contacts-list');
        contactsList.find('.contact-item').remove();
        
        if (contacts.length === 0) {
            $('.empty-state').removeClass('d-none');
            $('.messages-container').addClass('d-none');
        } else {
            $('.empty-state').addClass('d-none');
            $('.messages-container').removeClass('d-none');
            
            contacts.forEach(contact => {
                const lastMessage = contact.last_message ? 
                    (contact.last_message.content.length > 25 ? 
                        contact.last_message.content.substring(0, 25) + '...' : 
                        contact.last_message.content) : 
                    'Bắt đầu cuộc trò chuyện';
                
                const time = contact.last_message ? 
                    formatTime(contact.last_message.sent_at) : '';
                    
                const unreadBadge = contact.unread_messages_count > 0 ? 
                    `<span class="badge bg-primary">${contact.unread_messages_count}</span>` : '';
                
                const contactItem = `
                    <div class="contact-item" data-id="${contact.id}">
                        <div class="contact-avatar">
                            <img src="${contact.avatar || '/images/default-avatar.png'}" alt="${contact.name}">
                        </div>
                        <div class="contact-info">
                            <h6>${contact.name}</h6>
                            <p class="last-message">${lastMessage}</p>
                        </div>
                        <div class="contact-meta">
                            <span class="time">${time}</span>
                            ${unreadBadge}
                        </div>
                    </div>
                `;
                
                contactsList.append(contactItem);
            });
            
            // Add click handler for contacts
            $('.contact-item').on('click', function() {
                const contactId = $(this).data('id');
                loadMessages(contactId);
                
                // Update UI
                $('.contact-item').removeClass('active');
                $(this).addClass('active');
                $(this).find('.badge').remove(); // Remove unread badge
            });
        }
    }
    
    // Function to load messages for a selected contact
    function loadMessages(contactId) {
        $.ajax({
            url: `/get-messages/${contactId}`,
            type: 'GET',
            success: function(response) {
                renderMessages(response.messages, response.recipient);
            },
            error: function(error) {
                console.error('Error loading messages:', error);
            }
        });
    }
    
    // Function to render messages
    function renderMessages(messages, recipient) {
        const chatMessages = $('.chat-messages');
        chatMessages.empty();
        
        // Update chat header
        $('.chat-header .chat-user').html(`
            <div class="user-avatar">
                <img src="${recipient.avatar || '/images/default-avatar.png'}" alt="${recipient.name}">
            </div>
            <div class="user-info">
                <h6>${recipient.name}</h6>
                <span class="status">Online</span>
            </div>
        `);
        
        // Add messages
        messages.forEach(message => {
            const isMyMessage = message.sender_user_id == userId;
            const messageClass = isMyMessage ? 'my-message' : 'other-message';
            
            let messageContent = '';
            
            if (message.message_type === 'text') {
                messageContent = `<p>${message.content}</p>`;
            } else if (message.message_type === 'image') {
                messageContent = `<img src="${message.file_url}" alt="Image" class="message-image">`;
            } else if (message.message_type === 'file') {
                messageContent = `
                    <div class="file-attachment">
                        <i class="fas fa-file"></i>
                        <a href="${message.file_url}" target="_blank">Tải xuống tệp</a>
                    </div>
                `;
            }
            
            const messageHtml = `
                <div class="message ${messageClass}">
                    ${!isMyMessage ? `<div class="message-avatar">
                        <img src="${message.sender.avatar || '/images/default-avatar.png'}" alt="${message.sender.name}">
                    </div>` : ''}
                    <div class="message-content">
                        ${messageContent}
                        <span class="message-time">${formatTime(message.sent_at)}</span>
                    </div>
                </div>
            `;
            
            chatMessages.append(messageHtml);
        });
        
        // Scroll to bottom
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
        
        // Enable the chat input
        $('.chat-input').removeClass('disabled');
        $('.chat-input textarea').attr('data-recipient', recipient.id);
    }
    
    // Send message when clicking send button
    $('.send-btn').on('click', function() {
        sendMessage();
    });
    
    // Send message when pressing Enter (but Shift+Enter for new line)
    $('.chat-input textarea').on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    
    // Function to send a message
    function sendMessage() {
        const textarea = $('.chat-input textarea');
        const content = textarea.val().trim();
        const recipientId = textarea.attr('data-recipient');
        const fileInput = $('#file-upload')[0];
        
        if ((!content && !fileInput.files.length) || !recipientId) return;
        
        const formData = new FormData();
        formData.append('recipient_id', recipientId);
        formData.append('content', content);
        
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }
        
        $.ajax({
            url: '/send-message',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(message) {
                textarea.val('');
                $('.file-info').addClass('d-none').empty();
                fileInput.value = '';
                
                // Append the new message to the chat
                const messageHtml = `
                    <div class="message my-message">
                        <div class="message-content">
                            ${message.message_type === 'text' ? 
                                `<p>${message.content}</p>` : 
                                message.message_type === 'image' ? 
                                `<img src="${message.file_url}" alt="Image" class="message-image">` : 
                                `<div class="file-attachment">
                                    <i class="fas fa-file"></i>
                                    <a href="${message.file_url}" target="_blank">Tải xuống tệp</a>
                                </div>`
                            }
                            <span class="message-time">${formatTime(message.sent_at)}</span>
                        </div>
                    </div>
                `;
                
                $('.chat-messages').append(messageHtml);
                $('.chat-messages').scrollTop($('.chat-messages')[0].scrollHeight);
                
                // Refresh the contacts list to update last message
                loadContacts();
            },
            error: function(error) {
                console.error('Error sending message:', error);
                alert('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.');
            }
        });
    }
    
    // Handle file attachment
    $('.attachment-btn').on('click', function() {
        $('#file-upload').click();
    });
    
    $('#file-upload').on('change', function() {
        const file = this.files[0];
        if (file) {
            $('.file-info').removeClass('d-none').text(file.name);
        } else {
            $('.file-info').addClass('d-none').empty();
        }
    });
    
    // Handle new conversation button
    $('.new-conversation-btn, .new-message-btn').on('click', function() {
        showNewConversationModal();
    });
    
    // Search contacts
    $('.search-contact input').on('keyup', function() {
        const query = $(this).val().trim();
        if (query.length > 0) {
            searchUsers(query);
        } else {
            loadContacts();
        }
    });
    
    // Function to search users
    function searchUsers(query) {
        $.ajax({
            url: '/search-users',
            type: 'GET',
            data: { query: query },
            success: function(users) {
                renderSearchResults(users);
            },
            error: function(error) {
                console.error('Error searching users:', error);
            }
        });
    }
    
    // Function to render search results
    function renderSearchResults(users) {
        const contactsList = $('.contacts-list');
        contactsList.find('.contact-item').remove();
        
        users.forEach(user => {
            const contactItem = `
                <div class="contact-item search-result" data-id="${user.id}">
                    <div class="contact-avatar">
                        <img src="${user.avatar || '/images/default-avatar.png'}" alt="${user.name}">
                    </div>
                    <div class="contact-info">
                        <h6>${user.name}</h6>
                        <p class="last-message">${user.email}</p>
                    </div>
                </div>
            `;
            
            contactsList.append(contactItem);
        });
        
        // Add click handler for search results
        $('.search-result').on('click', function() {
            const contactId = $(this).data('id');
            loadMessages(contactId);
            
            // Update UI
            $('.contact-item').removeClass('active');
            $(this).addClass('active');
        });
    }
    
    // Function to show new conversation modal
    function showNewConversationModal() {
        // You can implement a modal to search and select users
        // This is a simplified version
        if (!$('#new-conversation-modal').length) {
            const modal = `
                <div class="modal fade" id="new-conversation-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tạo cuộc trò chuyện mới</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="search-user">Tìm kiếm người dùng</label>
                                    <input type="text" id="search-user" class="form-control" placeholder="Nhập tên hoặc email...">
                                </div>
                                <div class="search-results mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modal);
            
            // Initialize Bootstrap modal
            const bsModal = new bootstrap.Modal(document.getElementById('new-conversation-modal'));
            bsModal.show();
            
            // Handle search in modal
            $('#search-user').on('keyup', function() {
                const query = $(this).val().trim();
                if (query.length > 0) {
                    $.ajax({
                        url: '/search-users',
                        type: 'GET',
                        data: { query: query },
                        success: function(users) {
                            let resultsHtml = '';
                            
                            users.forEach(user => {
                                resultsHtml += `
                                    <div class="search-user-item" data-id="${user.id}">
                                        <div class="d-flex align-items-center p-2 border-bottom">
                                            <div class="user-avatar me-3">
                                                <img src="${user.avatar || '/images/default-avatar.png'}" alt="${user.name}" class="rounded-circle" width="40">
                                            </div>
                                            <div class="user-info">
                                                <h6 class="mb-0">${user.name}</h6>
                                                <small>${user.email}</small>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
                            
                            $('.search-results').html(resultsHtml || '<p>Không tìm thấy kết quả</p>');
                            
                            // Add click handler for search results
                            $('.search-user-item').on('click', function() {
                                const userId = $(this).data('id');
                                bsModal.hide();
                                loadMessages(userId);
                            });
                        }
                    });
                } else {
                    $('.search-results').empty();
                }
            });
        } else {
            const bsModal = new bootstrap.Modal(document.getElementById('new-conversation-modal'));
            bsModal.show();
        }
    }
    
    // Helper function to format time
    function formatTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const yesterday = new Date(now);
        yesterday.setDate(yesterday.getDate() - 1);
        
        // Today
        if (date.toDateString() === now.toDateString()) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
        // Yesterday
        else if (date.toDateString() === yesterday.toDateString()) {
            return 'Hôm qua';
        }
        // This week
        else if (now - date < 7 * 24 * 60 * 60 * 1000) {
            const days = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
            return days[date.getDay()];
        }
        // Older
        else {
            return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
        }
    }
    
    // Setup typing indicator
    const typingTimeout = 3000;
    let typingTimer = null;
    
    $('.chat-input textarea').on('keydown', function() {
        const recipientId = $(this).attr('data-recipient');
        if (!recipientId) return;
        
        clearTimeout(typingTimer);
        
        // Send typing notification
        $.ajax({
            url: '/typing-status',
            type: 'POST',
            data: {
                recipient_id: recipientId,
                is_typing: true
            }
        });
        
        typingTimer = setTimeout(() => {
            // Send stopped typing notification
            $.ajax({
                url: '/typing-status',
                type: 'POST',
                data: {
                    recipient_id: recipientId,
                    is_typing: false
                }
            });
        }, typingTimeout);
    });
});
</script>
{{-- @endpush --}}