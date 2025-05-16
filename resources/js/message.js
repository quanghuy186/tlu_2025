
document.addEventListener('DOMContentLoaded', function() {
    // Khởi tạo biến để theo dõi trạng thái typing
    let typingTimer;
    const typingDelay = 1000;
    let isTyping = false;

    // Lắng nghe sự kiện typing
    document.querySelector('.chat-input textarea').addEventListener('input', function() {
        if (!currentRecipientId) return;
        
        if (!isTyping) {
            isTyping = true;
            sendTypingStatus(true);
        }
        
        clearTimeout(typingTimer);
        typingTimer = setTimeout(() => {
            isTyping = false;
            sendTypingStatus(false);
        }, typingDelay);
    });

    // Lắng nghe sự kiện user.typing từ Echo
    window.Echo.private(`typing.${userId}`)
        .listen('.user.typing', (e) => {
            if (currentRecipientId && e.userId == currentRecipientId) {
                const typingIndicator = document.querySelector('.typing-indicator');
                
                if (e.isTyping) {
                    if (!typingIndicator) {
                        const indicatorHtml = `
                            <div class="typing-indicator">
                                <span class="typing-indicator-dot"></span>
                                <span class="typing-indicator-dot"></span>
                                <span class="typing-indicator-dot"></span>
                            </div>
                        `;
                        document.querySelector('.chat-messages').insertAdjacentHTML('beforeend', indicatorHtml);
                        document.querySelector('.chat-messages').scrollTop = document.querySelector('.chat-messages').scrollHeight;
                    }
                } else {
                    if (typingIndicator) {
                        typingIndicator.remove();
                    }
                }
            }
        });

    // Hàm gửi trạng thái typing
    function sendTypingStatus(isTyping) {
        if (!currentRecipientId) return;
        
        fetch('/messages/typing', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                recipient_id: currentRecipientId,
                is_typing: isTyping
            })
        });
    }


    const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');
    let currentRecipientId = null;
    
    // Khởi tạo kết nối realtime
    window.Echo.private(`messages.${userId}`)
        .listen('.new.message', (e) => {
            // Nếu tin nhắn từ người đang chat hiện tại
            if (currentRecipientId && e.message.sender_user_id == currentRecipientId) {
                appendMessage(e.message, false);
                markMessageAsRead(e.message.id);
            } 
            // Cập nhật danh sách contacts
            updateContactsList();
        });
    
    // Xử lý khi chọn một contact
    document.querySelectorAll('.contact-item').forEach(item => {
        item.addEventListener('click', function() {
            const recipientId = this.dataset.userId;
            currentRecipientId = recipientId;
            loadConversation(recipientId);
            
            // Cập nhật UI chọn contact
            document.querySelectorAll('.contact-item').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Xử lý gửi tin nhắn
    document.querySelector('.send-btn').addEventListener('click', sendMessage);
    document.querySelector('.chat-input textarea').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });
    
    // Xử lý upload file
    document.querySelector('.attachment-btn').addEventListener('click', function() {
        document.getElementById('file-upload').click();
    });
    
    document.getElementById('file-upload').addEventListener('change', function() {
        const fileInfo = document.querySelector('.file-info');
        if (this.files.length > 0) {
            fileInfo.textContent = this.files[0].name;
            fileInfo.classList.remove('d-none');
        }
    });
    
    // Hàm gửi tin nhắn
    function sendMessage() {
        if (!currentRecipientId) return;
        
        const textarea = document.querySelector('.chat-input textarea');
        const content = textarea.value.trim();
        const fileInput = document.getElementById('file-upload');
        
        if (!content && fileInput.files.length === 0) return;
        
        const formData = new FormData();
        formData.append('recipient_id', currentRecipientId);
        formData.append('content', content);
        
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }
        
        fetch('/messages', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData
        })
        .then(response => response.json())
        .then(message => {
            appendMessage(message, true);
            textarea.value = '';
            
            // Reset file input
            fileInput.value = '';
            document.querySelector('.file-info').classList.add('d-none');
            
            // Update contact list to show latest message
            updateContactsList();
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Hàm load cuộc trò chuyện
    function loadConversation(recipientId) {
        fetch(`/messages/${recipientId}`)
            .then(response => response.json())
            .then(data => {
                // Cập nhật header chat
                updateChatHeader(data.recipient);
                
                // Hiển thị tin nhắn
                const chatMessages = document.querySelector('.chat-messages');
                chatMessages.innerHTML = '';
                
                // Nhóm tin nhắn theo ngày
                const messagesByDate = groupMessagesByDate(data.messages);
                
                for (const [date, messages] of Object.entries(messagesByDate)) {
                    // Thêm date divider
                    chatMessages.innerHTML += `
                        <div class="date-divider">
                            <span>${formatDate(date)}</span>
                        </div>
                    `;
                    
                    // Thêm các tin nhắn
                    messages.forEach(message => {
                        const isOutgoing = message.sender_user_id == userId;
                        appendMessage(message, isOutgoing);
                    });
                }
                
                // Cuộn xuống cuối
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Hàm nhóm tin nhắn theo ngày
    function groupMessagesByDate(messages) {
        const groups = {};
        
        messages.forEach(message => {
            const date = new Date(message.sent_at).toISOString().split('T')[0];
            if (!groups[date]) {
                groups[date] = [];
            }
            groups[date].push(message);
        });
        
        return groups;
    }
    
    // Hàm định dạng ngày
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        if (date.toDateString() === today.toDateString()) {
            return 'Hôm nay';
        } else if (date.toDateString() === yesterday.toDateString()) {
            return 'Hôm qua';
        } else {
            return new Intl.DateTimeFormat('vi-VN').format(date);
        }
    }
    
    // Hàm định dạng thời gian
    function formatTime(dateTimeStr) {
        const date = new Date(dateTimeStr);
        return date.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
    }
    
    // Hàm thêm tin nhắn vào khung chat
    function appendMessage(message, isOutgoing) {
        const chatMessages = document.querySelector('.chat-messages');
        const messageType = isOutgoing ? 'outgoing' : 'incoming';
        
        let messageContent = '';
        
        // Kiểm tra loại tin nhắn
        if (message.message_type === 'text') {
            messageContent = `<div class="message-content">${escapeHtml(message.content)}</div>`;
        } else if (message.message_type === 'image') {
            messageContent = `
                <div class="message-content">
                    ${message.content ? escapeHtml(message.content) + '<br>' : ''}
                    <img src="${message.file_url}" alt="Image" class="message-image">
                </div>
            `;
        } else if (message.message_type === 'video') {
            messageContent = `
                <div class="message-content">
                    ${message.content ? escapeHtml(message.content) + '<br>' : ''}
                    <video controls class="message-video">
                        <source src="${message.file_url}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            `;
        } else if (message.message_type === 'file') {
            const fileName = message.file_url.split('/').pop();
            messageContent = `
                <div class="message-content">
                    ${message.content ? escapeHtml(message.content) + '<br>' : ''}
                    <div class="message-file">
                        <i class="fas fa-file"></i>
                        <a href="${message.file_url}" target="_blank">${escapeHtml(fileName)}</a>
                    </div>
                </div>
            `;
        }
        
        const messageHtml = `
            <div class="message ${messageType}">
                ${messageContent}
                <div class="message-time">${formatTime(message.sent_at)}</div>
            </div>
        `;
        
        chatMessages.insertAdjacentHTML('beforeend', messageHtml);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Hàm cập nhật header chat
    function updateChatHeader(recipient) {
        const chatHeader = document.querySelector('.chat-header');
        chatHeader.innerHTML = `
            <div class="chat-user">
                <img src="${recipient.avatar || 'https://via.placeholder.com/200x200?text=' + recipient.name.charAt(0)}" alt="Chat User Avatar">
                <div class="chat-user-info">
                    <h5>${escapeHtml(recipient.name)}</h5>
                    <p><span class="contact-status status-online"></span> Đang hoạt động</p>
                </div>
            </div>
            <div class="chat-actions">
                <a href="#" title="Tìm kiếm"><i class="fas fa-search"></i></a>
                <a href="#" title="Gọi video"><i class="fas fa-video"></i></a>
                <a href="#" title="Gọi thoại"><i class="fas fa-phone-alt"></i></a>
                <a href="#" title="Thông tin"><i class="fas fa-info-circle"></i></a>
            </div>
        `;
    }
    
    // Hàm cập nhật danh sách liên hệ
    function updateContactsList() {
        fetch('/contacts')
            .then(response => response.json())
            .then(contacts => {
                const contactsList = document.querySelector('.contacts-list');
                // Lưu lại scroll position
                const scrollPosition = contactsList.scrollTop;
                
                // Xóa tất cả các contact hiện tại ngoại trừ header
                const contactsHeader = contactsList.querySelector('.contacts-header');
                contactsList.innerHTML = '';
                contactsList.appendChild(contactsHeader);
                
                // Thêm lại các contact
                contacts.forEach(contact => {
                    const isActive = currentRecipientId && currentRecipientId == contact.id;
                    const hasUnread = contact.unread_messages_count > 0;
                    
                    // Xác định tin nhắn gần nhất để hiển thị
                    let previewText = '';
                    if (contact.last_message) {
                        if (contact.last_message.sender_user_id == userId) {
                            previewText = 'Bạn: ';
                        }
                        
                        if (contact.last_message.message_type === 'text') {
                            previewText += contact.last_message.content;
                        } else if (contact.last_message.message_type === 'image') {
                            previewText += '[Hình ảnh]';
                        } else if (contact.last_message.message_type === 'video') {
                            previewText += '[Video]';
                        } else if (contact.last_message.message_type === 'file') {
                            previewText += '[Tệp đính kèm]';
                        }
                    }
                    
                    // Định dạng thời gian
                    let timeText = '';
                    if (contact.last_message) {
                        const messageDate = new Date(contact.last_message.sent_at);
                        const today = new Date();
                        
                        if (messageDate.toDateString() === today.toDateString()) {
                            timeText = formatTime(contact.last_message.sent_at);
                        } else {
                            const yesterday = new Date(today);
                            yesterday.setDate(yesterday.getDate() - 1);
                            
                            if (messageDate.toDateString() === yesterday.toDateString()) {
                                timeText = 'Hôm qua';
                            } else {
                                // Hiển thị ngày trong tuần hoặc ngày/tháng
                                const diffDays = Math.round((today - messageDate) / (1000 * 60 * 60 * 24));
                                
                                if (diffDays < 7) {
                                    const days = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
                                    timeText = days[messageDate.getDay()];
                                } else {
                                    timeText = messageDate.getDate() + '/' + (messageDate.getMonth() + 1);
                                }
                            }
                        }
                    }
                    
                    const contactHtml = `
                        <div class="contact-item ${isActive ? 'active' : ''}" data-user-id="${contact.id}">
                            <img src="${contact.avatar || 'https://via.placeholder.com/200x200?text=' + contact.name.charAt(0)}" alt="Contact Avatar" class="contact-avatar">
                            <div class="contact-info">
                                <div class="contact-name">
                                    <span class="contact-status status-online"></span>
                                    ${escapeHtml(contact.name)}
                                </div>
                                <div class="contact-preview">${escapeHtml(previewText)}</div>
                            </div>
                            <div class="contact-meta">
                                <div class="contact-time">${escapeHtml(timeText)}</div>
                                ${hasUnread ? `<div class="contact-badge">${contact.unread_messages_count}</div>` : ''}
                            </div>
                        </div>
                    `;
                    
                    contactsList.insertAdjacentHTML('beforeend', contactHtml);
                });
                
                // Thêm lại event listeners cho contacts
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.addEventListener('click', function() {
                        const recipientId = this.dataset.userId;
                        currentRecipientId = recipientId;
                        loadConversation(recipientId);
                        
                        // Cập nhật UI chọn contact
                        document.querySelectorAll('.contact-item').forEach(el => el.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
                
                // Khôi phục scroll position
                contactsList.scrollTop = scrollPosition;
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Hàm đánh dấu tin nhắn đã đọc
    function markMessageAsRead(messageId) {
        fetch('/messages/read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ message_id: messageId })
        });
    }
    
    // Tìm kiếm liên hệ
    const searchInput = document.querySelector('.search-contact input');
    searchInput.addEventListener('input', function() {
        const query = this.value.trim().toLowerCase();
        
        if (query.length > 0) {
            document.querySelectorAll('.contact-item').forEach(item => {
                const name = item.querySelector('.contact-name').textContent.trim().toLowerCase();
                if (name.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        } else {
            document.querySelectorAll('.contact-item').forEach(item => {
                item.style.display = '';
            });
        }
    });
    
    // Xử lý nút tạo cuộc trò chuyện mới
    document.querySelector('.new-message-btn').addEventListener('click', function(e) {
        e.preventDefault();
        showNewMessageModal();
    });
    
    // Hàm hiển thị modal tạo cuộc trò chuyện mới
    function showNewMessageModal() {
        // Tạo modal nếu chưa có
        if (!document.getElementById('newMessageModal')) {
            const modalHtml = `
                <div class="modal fade" id="newMessageModal" tabindex="-1" aria-labelledby="newMessageModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newMessageModalLabel">Tạo cuộc trò chuyện mới</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="searchUser" class="form-label">Tìm kiếm người dùng:</label>
                                    <input type="text" class="form-control" id="searchUser" placeholder="Nhập tên hoặc email...">
                                </div>
                                <div class="search-results mt-3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            
            // Xử lý tìm kiếm người dùng
            let searchTimeout;
            document.getElementById('searchUser').addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchTimeout);
                
                if (query.length >= 2) {
                    searchTimeout = setTimeout(() => {
                        fetch(`/users/search?query=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(users => {
                                const resultsContainer = document.querySelector('.search-results');
                                resultsContainer.innerHTML = '';
                                
                                if (users.length === 0) {
                                    resultsContainer.innerHTML = '<p class="text-center">Không tìm thấy người dùng nào</p>';
                                    return;
                                }
                                
                                users.forEach(user => {
                                    const userHtml = `
                                        <div class="user-item d-flex align-items-center p-2 border-bottom" data-user-id="${user.id}">
                                            <img src="${user.avatar || 'https://via.placeholder.com/40x40?text=' + user.name.charAt(0)}" alt="${user.name}" class="rounded-circle me-2" width="40" height="40">
                                            <div>
                                                <div class="fw-bold">${escapeHtml(user.name)}</div>
                                                <div class="text-muted small">${escapeHtml(user.email)}</div>
                                            </div>
                                        </div>
                                    `;
                                    
                                    resultsContainer.insertAdjacentHTML('beforeend', userHtml);
                                });

                                // Thêm event listener cho các user-item
                                document.querySelectorAll('.user-item').forEach(item => {
                                    item.addEventListener('click', function() {
                                        const userId = this.dataset.userId;
                                        
                                        // Đóng modal
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('newMessageModal'));
                                        modal.hide();
                                        
                                        // Kiểm tra xem đã có cuộc trò chuyện với user này chưa
                                        const existingContact = document.querySelector(`.contact-item[data-user-id="${userId}"]`);
                                        if (existingContact) {
                                            existingContact.click();
                                        } else {
                                            // Load cuộc trò chuyện mới
                                            currentRecipientId = userId;
                                            loadConversation(userId);
                                            
                                            // Cập nhật lại danh sách liên hệ
                                            updateContactsList();
                                        }
                                    });
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    }, 300);
                }
            });
        }
        
        // Hiển thị modal
        const modal = new bootstrap.Modal(document.getElementById('newMessageModal'));
        modal.show();
    }
    
    // Hàm escape HTML để tránh XSS
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
    
    // Khởi tạo ban đầu
    updateContactsList();
    
    // Nếu có contact active từ đầu, load conversation
    const activeContact = document.querySelector('.contact-item.active');
    if (activeContact) {
        currentRecipientId = activeContact.dataset.userId;
        loadConversation(currentRecipientId);
    }
});