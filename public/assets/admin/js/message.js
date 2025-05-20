// File: public/js/message.js (tạo mới hoàn toàn)

// Đặt ngay sau khi khởi tạo Echo
if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
    console.log("Pusher key:", window.Echo.options.key);
    console.log("Pusher cluster:", window.Echo.options.cluster);
    
    window.Echo.connector.pusher.connection.bind('connected', function() {
        console.log('Successfully connected to Pusher!');
    });
    
    window.Echo.connector.pusher.connection.bind('connecting', function() {
        console.log('Connecting to Pusher...');
    });
    
    window.Echo.connector.pusher.connection.bind('disconnected', function() {
        console.log('Disconnected from Pusher!');
    });
    
    window.Echo.connector.pusher.connection.bind('failed', function(error) {
        console.error('Connection to Pusher failed:', error);
    });
    
    window.Echo.connector.pusher.connection.bind('error', function(error) {
        console.error('Pusher connection error:', error);
    });
}
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
    
    // Phát hiện vấn đề thiếu JQuery
    if (typeof $ === 'undefined') {
        console.error("jQuery is not loaded! Make sure jQuery is loaded before this script.");
        alert("Error: jQuery is not loaded. Please check the console for more details.");
        return;
    }
    
    // Kiểm tra Echo và Pusher
    if (typeof window.Echo === 'undefined') {
        console.error("Laravel Echo is not initialized. Make sure app.js is loaded before this script.");
        // Vẫn tiếp tục vì chức năng chat cơ bản vẫn có thể hoạt động mà không cần real-time
    } else {
        console.log("Echo is available");
    }
    
    // Biến và hàm cơ bản
    let userId = null;
    let csrfToken = null;
    let currentRecipientId = null;
    const defaultAvatar = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBmaWxsPSIjZTBlMGUwIiBkPSJNMCAwaDUxMnY1MTJIMHoiLz48cGF0aCBmaWxsPSIjYWFhIiBkPSJNMjU2IDI1NmMtNTIuOCAwLTk2LTQzLjItOTYtOTZzNDMuMi05NiA5Ni05NiA5NiA0My4yIDk2IDk2LTQzLjIgOTYtOTYgOTZ6bTEyOCA0OGMwLTUyLjgtNDMuMi05Ni05Ni05NmgtNjRjLTUyLjggMC05NiA0My4yLTk2IDk2djE2MGgyNTZ2LTE2MHoiLz48L3N2Zz4=';
    let typingTimer = null;
    const typingTimeout = 3000;
    
    // Trước tiên lấy thông tin user từ meta tags
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    
    if (userIdMeta) {
        userId = userIdMeta.getAttribute('content');
        console.log("User ID found:", userId);
    } else {
        console.error("Meta tag for user-id not found");
    }
    
    if (csrfTokenMeta) {
        csrfToken = csrfTokenMeta.getAttribute('content');
        console.log("CSRF token found");
        
        // Setup AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    } else {
        console.error("Meta tag for csrf-token not found");
    }
    
    // Safety utility function to get elements
    function getElement(selector) {
        const element = document.querySelector(selector);
        if (!element) {
            console.error(`Element not found: ${selector}`);
            return null;
        }
        return element;
    }
    
    // Safe event listener
    function addSafeEventListener(selector, eventType, callback) {
        const element = getElement(selector);
        if (element) {
            element.addEventListener(eventType, callback);
            return true;
        }
        return false;
    }
    
    // Helper function to format time
    function formatTime(dateString) {
        if (!dateString) return '';
        
        try {
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
        } catch (error) {
            console.error("Error formatting date:", error);
            return dateString;
        }
    }
    
    // Initialize real-time connections
    function initializeRealtime() {
        if (!userId || !window.Echo) return false;
        
        try {
            // Subscribe to private channel
            const channel = window.Echo.private(`messages.${userId}`);
            
            // Listen for new messages
            channel.listen('.new.message', function(data) {
                console.log('New message received:', data);
                
                if (data.message && data.message.sender_user_id == currentRecipientId) {
                    appendMessage(data.message, false);
                    
                    // Mark as read
                    $.ajax({
                        url: '/mark-as-read',
                        type: 'POST',
                        data: { message_id: data.message.id }
                    });
                }
                
                loadContacts();
            });
            
            // Listen for typing status
            channel.listen('.user.typing', function(data) {
                if (data.sender_id == currentRecipientId) {
                    if (data.is_typing) {
                        showTypingIndicator();
                    } else {
                        hideTypingIndicator();
                    }
                }
            });
            
            console.log("Real-time connections initialized");
            return true;
        } catch (error) {
            console.error("Error initializing real-time:", error);
            return false;
        }
    }
    
    // Load contacts
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
    
    // Render contacts
    function renderContacts(contacts) {
        const contactsList = document.querySelector('.contacts-list');
        if (!contactsList) {
            console.error("Contacts list element not found");
            return;
        }
        
        // Remove existing contacts
        const existingContacts = contactsList.querySelectorAll('.contact-item');
        existingContacts.forEach(item => item.remove());
        
        // Empty state handling
        const emptyState = document.querySelector('.empty-state');
        const messagesContainer = document.querySelector('.messages-container');
        
        if (!contacts || contacts.length === 0) {
            if (emptyState) emptyState.classList.remove('d-none');
            if (messagesContainer) messagesContainer.classList.add('d-none');
            return;
        }
        
        if (emptyState) emptyState.classList.add('d-none');
        if (messagesContainer) messagesContainer.classList.remove('d-none');
        
        // Create new contact items
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
            
            const contactItem = document.createElement('div');
            contactItem.className = `contact-item ${contact.id == currentRecipientId ? 'active' : ''}`;
            contactItem.setAttribute('data-id', contact.id);
            contactItem.innerHTML = `
                <div class="contact-avatar">
                    <img src="${contact.avatar || defaultAvatar}" alt="${contact.name}" onerror="this.src='${defaultAvatar}'">
                </div>
                <div class="contact-info">
                    <h6>${contact.name}</h6>
                    <p class="last-message">${lastMessage}</p>
                </div>
                <div class="contact-meta">
                    <span class="time">${time}</span>
                    ${unreadBadge}
                </div>
            `;
            
            contactItem.addEventListener('click', function() {
                const contactId = this.getAttribute('data-id');
                currentRecipientId = contactId;
                loadMessages(contactId);
                
                // Update UI
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
                
                // Remove unread badge
                const badge = this.querySelector('.badge');
                if (badge) badge.remove();
            });
            
            contactsList.appendChild(contactItem);
        });
    }
    
    // Load messages
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
    
    // Render messages
    function renderMessages(messages, recipient) {
        const chatMessages = document.querySelector('.chat-messages');
        const chatHeader = document.querySelector('.chat-header .chat-user');
        const chatInput = document.querySelector('.chat-input');
        
        if (!chatMessages || !chatHeader) {
            console.error("Chat elements not found");
            return;
        }
        
        // Clear existing messages
        chatMessages.innerHTML = '';
        
        // Update header
        chatHeader.innerHTML = `
            <div class="user-avatar">
                <img src="${recipient.avatar || defaultAvatar}" alt="${recipient.name}" onerror="this.src='${defaultAvatar}'">
            </div>
            <div class="user-info">
                <h6>${recipient.name}</h6>
                <span class="status">Online</span>
            </div>
        `;
        
        // Add messages
        messages.forEach(message => {
            appendMessage(message, true);
        });
        
        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;
        
        // Enable input
        if (chatInput) {
            chatInput.classList.remove('disabled');
            const textarea = chatInput.querySelector('textarea');
            if (textarea) {
                textarea.setAttribute('data-recipient', recipient.id);
            }
        }
    }
    
    // Append a single message
    function appendMessage(message, initialLoad = false) {
        const chatMessages = document.querySelector('.chat-messages');
        if (!chatMessages) return;
        
        const isMyMessage = message.sender_user_id == userId;
        const messageClass = isMyMessage ? 'my-message' : 'other-message';
        
        let messageContent = '';
        
        if (message.message_type === 'text') {
            messageContent = `<p>${message.content}</p>`;
        } else if (message.message_type === 'image') {
            messageContent = `<img src="${message.file_url}" alt="Image" class="message-image">`;
        } else if (message.message_type === 'video') {
            messageContent = `
                <video controls class="message-video">
                    <source src="${message.file_url}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `;
        } else if (message.message_type === 'audio') {
            messageContent = `
                <audio controls class="message-audio">
                    <source src="${message.file_url}" type="audio/mpeg">
                    Your browser does not support the audio tag.
                </audio>
            `;
        } else if (message.message_type === 'file') {
            messageContent = `
                <div class="file-attachment">
                    <i class="fas fa-file"></i>
                    <a href="${message.file_url}" target="_blank" download>Tải xuống tệp</a>
                </div>
            `;
        }
        
        const messageElement = document.createElement('div');
        messageElement.className = `message ${messageClass}`;
        messageElement.innerHTML = `
            ${!isMyMessage ? `<div class="message-avatar">
                <img src="${message.sender?.avatar || defaultAvatar}" alt="${message.sender?.name || 'User'}" onerror="this.src='${defaultAvatar}'">
            </div>` : ''}
            <div class="message-content">
                ${messageContent}
                <span class="message-time">${formatTime(message.sent_at)}</span>
            </div>
        `;
        
        chatMessages.appendChild(messageElement);
        
        // Scroll if needed
        if (!initialLoad || isNearBottom(chatMessages)) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Check if scrolled near bottom
    function isNearBottom(element) {
        return element.scrollTop + element.clientHeight >= element.scrollHeight - 150;
    }
    
    // Show typing indicator
    function showTypingIndicator() {
        const chatMessages = document.querySelector('.chat-messages');
        if (!chatMessages) return;
        
        // Remove existing indicator
        hideTypingIndicator();
        
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'typing-indicator';
        typingIndicator.innerHTML = '<span></span><span></span><span></span>';
        
        chatMessages.appendChild(typingIndicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    
    // Hide typing indicator
    function hideTypingIndicator() {
        const existingIndicator = document.querySelector('.typing-indicator');
        if (existingIndicator) {
            existingIndicator.remove();
        }
    }
    
    // Send message function
    function sendMessage() {
        const textarea = document.querySelector('.chat-input textarea');
        const fileInput = document.getElementById('file-upload');
        
        if (!textarea) return;
        
        const content = textarea.value.trim();
        const recipientId = textarea.getAttribute('data-recipient');
        const hasFile = fileInput && fileInput.files.length > 0;
        
        if ((!content && !hasFile) || !recipientId) return;
        
        // Clear typing indicator
        clearTimeout(typingTimer);
        
        // Send typing status off
        $.ajax({
            url: '/typing-status',
            type: 'POST',
            data: {
                recipient_id: recipientId,
                is_typing: false
            }
        });
        
        // Prepare form data
        const formData = new FormData();
        formData.append('recipient_id', recipientId);
        formData.append('content', content);
        
        if (hasFile) {
            formData.append('file', fileInput.files[0]);
        }
        
        // Send message
        $.ajax({
            url: '/send-message',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(message) {
                // Clear form
                textarea.value = '';
                
                const fileInfo = document.querySelector('.file-info');
                if (fileInfo) {
                    fileInfo.classList.add('d-none');
                    fileInfo.textContent = '';
                }
                
                if (fileInput) {
                    fileInput.value = '';
                }
                
                // Append message
                appendMessage(message);
                
                // Refresh contacts
                loadContacts();
            },
            error: function(error) {
                console.error('Error sending message:', error);
                alert('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.');
            }
        });
    }
    
    // Setup event handlers
    function setupEventHandlers() {
        // Send button
        const sendBtn = document.querySelector('.send-btn');
        if (sendBtn) {
            sendBtn.addEventListener('click', sendMessage);
        }
        
        // Enter key in textarea
        const textarea = document.querySelector('.chat-input textarea');
        if (textarea) {
            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
                
                // Typing indicator
                const recipientId = this.getAttribute('data-recipient');
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
        }
        
        // Attachment button
        const attachmentBtn = document.querySelector('.attachment-btn');
        const fileUpload = document.getElementById('file-upload');
        
        if (attachmentBtn && fileUpload) {
            attachmentBtn.addEventListener('click', function() {
                fileUpload.click();
            });
            
            fileUpload.addEventListener('change', function() {
                const fileInfo = document.querySelector('.file-info');
                if (!fileInfo) return;
                
                if (this.files.length > 0) {
                    fileInfo.classList.remove('d-none');
                    fileInfo.textContent = this.files[0].name;
                } else {
                    fileInfo.classList.add('d-none');
                    fileInfo.textContent = '';
                }
            });
        }
        
        // New conversation button
        const newConversationBtns = document.querySelectorAll('.new-conversation-btn, .new-message-btn');
        newConversationBtns.forEach(btn => {
            btn.addEventListener('click', showNewConversationModal);
        });
        
        // Search input
        const searchInput = document.querySelector('.search-contact input');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.trim();
                if (query.length > 0) {
                    searchUsers(query);
                } else {
                    loadContacts();
                }
            });
        }
    }
    
    // Show new conversation modal
    function showNewConversationModal() {
        if (!document.getElementById('new-conversation-modal')) {
            // Create modal
            const modalHTML = `
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
            
            const modalDiv = document.createElement('div');
            modalDiv.innerHTML = modalHTML;
            document.body.appendChild(modalDiv.firstChild);
            
            // Initialize Bootstrap modal
            try {
                const modal = new bootstrap.Modal(document.getElementById('new-conversation-modal'));
                modal.show();
                
                // Setup search
                const searchInput = document.getElementById('search-user');
                if (searchInput) {
                    searchInput.addEventListener('keyup', function() {
                        const query = this.value.trim();
                        const searchResults = document.querySelector('.search-results');
                        
                        if (!searchResults) return;
                        
                        if (query.length > 0) {
                            $.ajax({
                                url: '/search-users',
                                type: 'GET',
                                data: { query: query },
                                success: function(users) {
                                    let resultsHTML = '';
                                    
                                    users.forEach(user => {
                                        resultsHTML += `
                                            <div class="search-user-item" data-id="${user.id}">
                                                <div class="d-flex align-items-center p-2 border-bottom">
                                                    <div class="user-avatar me-3">
                                                        <img src="${user.avatar || defaultAvatar}" alt="${user.name}" class="rounded-circle" width="40" onerror="this.src='${defaultAvatar}'">
                                                    </div>
                                                    <div class="user-info">
                                                        <h6 class="mb-0">${user.name}</h6>
                                                        <small>${user.email}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    });
                                    
                                    searchResults.innerHTML = resultsHTML || '<p>Không tìm thấy kết quả</p>';
                                    
                                    // Add click handlers
                                    document.querySelectorAll('.search-user-item').forEach(item => {
                                        item.addEventListener('click', function() {
                                            const userId = this.getAttribute('data-id');
                                            currentRecipientId = userId;
                                            modal.hide();
                                            loadMessages(userId);
                                        });
                                    });
                                }
                            });
                        } else {
                            searchResults.innerHTML = '';
                        }
                    });
                }
            } catch (error) {
                console.error("Error initializing Bootstrap modal:", error);
            }
        } else {
            // Show existing modal
            try {
                const modal = new bootstrap.Modal(document.getElementById('new-conversation-modal'));
                modal.show();
            } catch (error) {
                console.error("Error showing Bootstrap modal:", error);
            }
        }
    }
    
    // Search users
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
    
    // Render search results
    function renderSearchResults(users) {
        const contactsList = document.querySelector('.contacts-list');
        if (!contactsList) return;
        
        // Remove existing contacts
        const existingContacts = contactsList.querySelectorAll('.contact-item');
        existingContacts.forEach(item => item.remove());
        
        // Add search results
        users.forEach(user => {
            const contactItem = document.createElement('div');
            contactItem.className = 'contact-item search-result';
            contactItem.setAttribute('data-id', user.id);
            contactItem.innerHTML = `
                <div class="contact-avatar">
                    <img src="${user.avatar || defaultAvatar}" alt="${user.name}" onerror="this.src='${defaultAvatar}'">
                </div>
                <div class="contact-info">
                    <h6>${user.name}</h6>
                    <p class="last-message">${user.email}</p>
                </div>
            `;
            
            contactItem.addEventListener('click', function() {
                const contactId = this.getAttribute('data-id');
                currentRecipientId = contactId;
                loadMessages(contactId);
                
                // Update UI
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.classList.remove('active');
                });
                this.classList.add('active');
            });
            
            contactsList.appendChild(contactItem);
        });
    }
    
    // Initialize everything
    initializeRealtime();
    setupEventHandlers();
    loadContacts();
});