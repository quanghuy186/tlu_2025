// resources/js/message.js
import './bootstrap';

$(document).ready(function() {
    console.log("Document ready!");
    
    if (window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
        console.log("Pusher exists, setting up connection monitoring");
        
        window.Echo.connector.pusher.connection.bind('state_change', function(states) {
            console.log('Pusher connection state:', states);
        });
        
        window.Echo.connector.pusher.connection.bind('connected', function() {
            console.log('Successfully connected to Pusher!');
        });
        
        window.Echo.connector.pusher.connection.bind('disconnected', function() {
            console.error('Disconnected from Pusher!');
        });
        
        window.Echo.connector.pusher.connection.bind('error', function(error) {
            console.error('Pusher connection error:', error);
        });
    } else {
        console.error('Echo hoặc Pusher chưa được khởi tạo đúng cách');
    }

    const userIdMeta = $('meta[name="user-id"]');
    const csrfTokenMeta = $('meta[name="csrf-token"]');
    
    if (!userIdMeta.length || !csrfTokenMeta.length) {
        console.error('Meta tags for user-id or csrf-token not found. Check your HTML.');
        return;
    }
    
    const userId = userIdMeta.attr('content');
    const csrfToken = csrfTokenMeta.attr('content');
    let currentRecipientId = null;

    if (!userId) {
        console.error('User ID không tìm thấy hoặc không hợp lệ');
        return;
    }
    
    console.log('Listening for messages on channel:', `messages.${userId}`);
    
    if (csrfToken) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    } else {
        console.error('CSRF token không tìm thấy hoặc không hợp lệ');
        return;
    }
    
    const defaultAvatar = 'https://via.placeholder.com/50';
    
    // Fix references to images
    function getAvatarUrl(avatarPath) {
        if (!avatarPath) return defaultAvatar;
        return avatarPath;
    }
    
    function initializeEventHandlers() {
        console.log("Initializing event handlers");
        
        const sendBtn = $('.send-btn');
        if (sendBtn.length) {
            sendBtn.on('click', function() {
                sendMessage();
            });
            console.log("Send button handler initialized");
        } else {
            console.error("Send button not found");
        }
        
        const chatTextarea = $('.chat-input textarea');
        if (chatTextarea.length) {
            chatTextarea.on('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            console.log("Chat textarea handler initialized");
        } else {
            console.error("Chat textarea not found");
        }
        
        // Handle file attachment
        const attachmentBtn = $('.attachment-btn');
        if (attachmentBtn.length) {
            attachmentBtn.on('click', function() {
                const fileUpload = $('#file-upload');
                if (fileUpload.length) {
                    fileUpload.click();
                } else {
                    console.error("File upload input not found");
                }
            });
            console.log("Attachment button handler initialized");
        } else {
            console.error("Attachment button not found");
        }
        
        const fileUpload = $('#file-upload');
        if (fileUpload.length) {
            fileUpload.on('change', function() {
                const file = this.files[0];
                const fileInfo = $('.file-info');
                
                if (fileInfo.length) {
                    if (file) {
                        fileInfo.removeClass('d-none').text(file.name);
                    } else {
                        fileInfo.addClass('d-none').empty();
                    }
                } else {
                    console.error("File info element not found");
                }
            });
            console.log("File upload handler initialized");
        } else {
            console.error("File upload input not found");
        }
        
        // Handle new conversation button
        const newConversationBtns = $('.new-conversation-btn, .new-message-btn');
        if (newConversationBtns.length) {
            newConversationBtns.on('click', function() {
                showNewConversationModal();
            });
            console.log("New conversation buttons handler initialized");
        } else {
            console.error("New conversation buttons not found");
        }
        
        const searchInput = $('.search-contact input');
        if (searchInput.length) {
            searchInput.on('keyup', function() {
                const query = $(this).val().trim();
                if (query.length > 0) {
                    searchUsers(query);
                } else {
                    loadContacts();
                }
            });
            console.log("Search input handler initialized");
        } else {
            console.error("Search input not found");
        }
        
        const typingInput = $('.chat-input textarea');
        if (typingInput.length) {
            typingInput.on('keydown', function() {
                const recipientId = $(this).attr('data-recipient');
                if (!recipientId) return;
                
                clearTimeout(typingTimer);
                
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
            console.log("Typing indicator handler initialized");
        } else {
            console.error("Typing input not found");
        }
    }
    
    let userChannel;
    try {
        if (window.Echo) {
            userChannel = window.Echo.private(`messages.${userId}`);
            
            userChannel.listen('.new.message', (data) => {
                console.log('New message received:', data);
                
                const message = data.message;
                
                if (message.sender_user_id == currentRecipientId) {
                    appendMessage(message, false);
                    
                    $.ajax({
                        url: '/mark-as-read',
                        type: 'POST',
                        data: {
                            message_id: message.id
                        }
                    });
                }
                
                loadContacts();
            })
            .error((error) => {
                console.error('Echo error:', error);
            });
            
            userChannel.listen('.user.typing', (data) => {
                console.log('Typing status update:', data);
                
                if (data.sender_id == currentRecipientId) {
                    if (data.is_typing) {
                        showTypingIndicator();
                    } else {
                        hideTypingIndicator();
                    }
                }
            });
            
            console.log("Subscribed to private channel:", `messages.${userId}`);
        } else {
            console.error("Echo not available for channel subscription");
        }
    } catch (error) {
        console.error("Error subscribing to private channel:", error);
    }
    
    function showTypingIndicator() {
        const chatMessages = $('.chat-messages');
        if (!chatMessages.length) {
            console.error("Chat messages container not found");
            return;
        }
        
        const typingIndicator = $(`
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        `);
        
        $('.typing-indicator').remove();
        
        chatMessages.append(typingIndicator);
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
    
    function hideTypingIndicator() {
        $('.typing-indicator').remove();
    }
    
    function loadContacts() {
        console.log("Loading contacts...");
        
        $.ajax({
            url: '/get-contacts',
            type: 'GET',
            success: function(contacts) {
                console.log("Contacts loaded:", contacts.length);
                renderContacts(contacts);
            },
            error: function(error) {
                console.error('Error loading contacts:', error);
            }
        });
    }
    
    function renderContacts(contacts) {
        const contactsList = $('.contacts-list');
        if (!contactsList.length) {
            console.error("Contacts list container not found");
            return;
        }
        
        contactsList.find('.contact-item').remove();
        
        const emptyState = $('.empty-state');
        const messagesContainer = $('.messages-container');
        
        if (!contacts || contacts.length === 0) {
            if (emptyState.length) emptyState.removeClass('d-none');
            if (messagesContainer.length) messagesContainer.addClass('d-none');
        } else {
            if (emptyState.length) emptyState.addClass('d-none');
            if (messagesContainer.length) messagesContainer.removeClass('d-none');
            
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
                    <div class="contact-item ${contact.id == currentRecipientId ? 'active' : ''}" data-id="${contact.id}">
                        <div class="contact-avatar">
                            <img src="${getAvatarUrl(contact.avatar)}" alt="${contact.name}" onerror="this.src='${defaultAvatar}'">
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
            const contactItems = $('.contact-item');
            if (contactItems.length) {
                contactItems.on('click', function() {
                    const contactId = $(this).data('id');
                    currentRecipientId = contactId;
                    loadMessages(contactId);
                    
                    // Update UI
                    $('.contact-item').removeClass('active');
                    $(this).addClass('active');
                    $(this).find('.badge').remove(); // Remove unread badge
                });
                console.log("Contact items click handlers initialized");
            } else {
                console.error("No contact items found after rendering");
            }
        }
    }
    
    function loadMessages(contactId) {
        console.log(`Loading messages for contact ${contactId}...`);
        
        $.ajax({
            url: `/get-messages/${contactId}`,
            type: 'GET',
            success: function(response) {
                console.log(`Messages loaded: ${response.messages.length}`);
                renderMessages(response.messages, response.recipient);
            },
            error: function(error) {
                console.error('Error loading messages:', error);
            }
        });
    }
    
    function renderMessages(messages, recipient) {
        const chatMessages = $('.chat-messages');
        if (!chatMessages.length) {
            console.error("Chat messages container not found");
            return;
        }
        
        chatMessages.empty();
        
        const chatUser = $('.chat-header .chat-user');
        if (chatUser.length) {
            chatUser.html(`
                <div class="user-avatar">
                    <img src="${getAvatarUrl(recipient.avatar)}" alt="${recipient.name}" onerror="this.src='${defaultAvatar}'">
                </div>
                <div class="user-info">
                    <h6>${recipient.name}</h6>
                    <span class="status">Online</span>
                </div>
            `);
        } else {
            console.error("Chat user header not found");
        }
        
        messages.forEach(message => {
            appendMessage(message, true);
        });
        
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
        
        const chatInput = $('.chat-input');
        if (chatInput.length) {
            chatInput.removeClass('disabled');
            
            const textarea = chatInput.find('textarea');
            if (textarea.length) {
                textarea.attr('data-recipient', recipient.id);
            } else {
                console.error("Chat textarea not found");
            }
        } else {
            console.error("Chat input container not found");
        }
        
        currentRecipientId = recipient.id;
    }
    
    function appendMessage(message, initialLoad = false) {
        const chatMessages = $('.chat-messages');
        if (!chatMessages.length) {
            console.error("Chat messages container not found");
            return;
        }
        
        const isMyMessage = message.sender_user_id == userId;
        const messageClass = isMyMessage ? 'my-message' : 'other-message';
        
        let messageContent = '';
        
        if (message.message_type === 'text') {
            messageContent = `<p>${message.content}</p>`;
        } else if (message.message_type === 'image') {
            messageContent = `<img src="${message.file_url}" alt="Image" class="message-image" onerror="this.src='${defaultAvatar}'">`;
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
        
        const messageHtml = `
            <div class="message ${messageClass}">
                ${!isMyMessage ? `<div class="message-avatar">
                    <img src="${getAvatarUrl(message.sender?.avatar)}" alt="${message.sender?.name || 'User'}" onerror="this.src='${defaultAvatar}'">
                </div>` : ''}
                <div class="message-content">
                    ${messageContent}
                    <span class="message-time">${formatTime(message.sent_at)}</span>
                </div>
            </div>
        `;
        
        chatMessages.append(messageHtml);
        
        if (!initialLoad || isNearBottom()) {
            chatMessages.scrollTop(chatMessages[0].scrollHeight);
        }
    }
    
    function isNearBottom() {
        const chatMessages = $('.chat-messages');
        if (!chatMessages.length) return true;
        
        const scrollTop = chatMessages.scrollTop();
        const scrollHeight = chatMessages[0].scrollHeight;
        const clientHeight = chatMessages[0].clientHeight;
        
        return scrollTop + clientHeight >= scrollHeight - 150;
    }
    
    function sendMessage() {
        const textarea = $('.chat-input textarea');
        if (!textarea.length) {
            console.error("Chat textarea not found");
            return;
        }
        
        const content = textarea.val().trim();
        const recipientId = textarea.attr('data-recipient');
        
        const fileInput = $('#file-upload');
        const hasFile = fileInput.length && fileInput[0].files.length > 0;
        
        if ((!content && !hasFile) || !recipientId) {
            console.log("No content to send or no recipient selected");
            return;
        }
        
        clearTimeout(typingTimer);
        
        $.ajax({
            url: '/typing-status',
            type: 'POST',
            data: {
                recipient_id: recipientId,
                is_typing: false
            }
        });
        
        const formData = new FormData();
        formData.append('recipient_id', recipientId);
        formData.append('content', content);
        
        if (hasFile) {
            formData.append('file', fileInput[0].files[0]);
        }
        
        $.ajax({
            url: '/send-message',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(message) {
                console.log("Message sent successfully:", message);
                
                textarea.val('');
                
                const fileInfo = $('.file-info');
                if (fileInfo.length) {
                    fileInfo.addClass('d-none').empty();
                }
                
                if (fileInput.length) {
                    fileInput[0].value = '';
                }
                
                appendMessage(message);
                loadContacts();
            },
            error: function(error) {
                console.error('Error sending message:', error);
                alert('Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.');
            }
        });
    }
    
    function searchUsers(query) {
        console.log(`Searching users with query: "${query}"`);
        $.ajax({
            url: '/search-users',
            type: 'GET',
            data: { query: query },
            success: function(users) {
                console.log(`Search results: ${users.length} users found`);
                renderSearchResults(users);
            },
            error: function(error) {
                console.error('Error searching users:', error);
            }
        });
    }
    
    function renderSearchResults(users) {
        const contactsList = $('.contacts-list');
        if (!contactsList.length) {
            console.error("Contacts list container not found");
            return;
        }
        
        contactsList.find('.contact-item').remove();
        
        users.forEach(user => {
            const contactItem = `
                <div class="contact-item search-result" data-id="${user.id}">
                    <div class="contact-avatar">
                        <img src="${getAvatarUrl(user.avatar)}" alt="${user.name}" onerror="this.src='${defaultAvatar}'">
                    </div>
                    <div class="contact-info">
                        <h6>${user.name}</h6>
                        <p class="last-message">${user.email}</p>
                    </div>
                </div>
            `;
            
            contactsList.append(contactItem);
        });
        
        const searchResults = $('.search-result');
        if (searchResults.length) {
            searchResults.on('click', function() {
                const contactId = $(this).data('id');
                currentRecipientId = contactId;
                loadMessages(contactId);
                
                $('.contact-item').removeClass('active');
                $(this).addClass('active');
            });
            console.log("Search result click handlers initialized");
        } else {
            console.log("No search results found");
        }
    }
    
    function showNewConversationModal() {
        console.log("Showing new conversation modal");
        
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
            
            try {
                const modalElement = document.getElementById('new-conversation-modal');
                if (modalElement) {
                    const bsModal = new bootstrap.Modal(modalElement);
                    bsModal.show();
                    
                    const searchUser = $('#search-user');
                    if (searchUser.length) {
                        searchUser.on('keyup', function() {
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
                                                            <img src="${getAvatarUrl(user.avatar)}" alt="${user.name}" class="rounded-circle" width="40" onerror="this.src='${defaultAvatar}'">
                                                        </div>
                                                        <div class="user-info">
                                                            <h6 class="mb-0">${user.name}</h6>
                                                            <small>${user.email}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                        
                                        const searchResults = $('.search-results');
                                        if (searchResults.length) {
                                            searchResults.html(resultsHtml || '<p>Không tìm thấy kết quả</p>');
                                            
                                            // Add click handler for search results
                                            const searchUserItems = $('.search-user-item');
                                            if (searchUserItems.length) {
                                                searchUserItems.on('click', function() {
                                                    const userId = $(this).data('id');
                                                    currentRecipientId = userId;
                                                    bsModal.hide();
                                                    loadMessages(userId);
                                                });
                                            }
                                        } else {
                                            console.error("Search results container not found");
                                        }
                                    },
                                    error: function(error) {
                                        console.error('Error searching users in modal:', error);
                                    }
                                });
                            } else {
                                $('.search-results').empty();
                            }
                        });
                    } else {
                        console.error("Search user input in modal not found");
                    }
                } else {
                    console.error("New conversation modal element not found");
                }
            } catch (error) {
                console.error("Error initializing Bootstrap modal:", error);
            }
        } else {
            try {
                const modalElement = document.getElementById('new-conversation-modal');
                if (modalElement) {
                    const bsModal = new bootstrap.Modal(modalElement);
                    bsModal.show();
                } else {
                    console.error("Existing conversation modal element not found");
                }
            } catch (error) {
                console.error("Error showing existing Bootstrap modal:", error);
            }
        }
    }
    
    const typingTimeout = 3000;
    let typingTimer = null;
    
    function formatTime(dateString) {
        try {
            const date = new Date(dateString);
            const now = new Date();
            const yesterday = new Date(now);
            yesterday.setDate(yesterday.getDate() - 1);
            
            if (date.toDateString() === now.toDateString()) {
                return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            }
            else if (date.toDateString() === yesterday.toDateString()) {
                return 'Hôm qua';
            }
            else if (now - date < 7 * 24 * 60 * 60 * 1000) {
                const days = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
                return days[date.getDay()];
            }
            else {
                return `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;
            }
        } catch (error) {
            console.error("Error formatting date:", error, dateString);
            return dateString || '';
        }
    }
    
    // Initialize event handlers
    initializeEventHandlers();
    
    // Load contacts to start the application
    loadContacts();
    
    console.log("Message application initialized");
});