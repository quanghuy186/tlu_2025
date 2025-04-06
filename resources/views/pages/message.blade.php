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
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin nhắn</li>
            </ol>
        </nav>
    </div>
</div>

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
            <div class="contact-item active">
                <img src="https://via.placeholder.com/200x200?text=User1" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-online"></span>
                        Trần Thị B
                    </div>
                    <div class="contact-preview">Bạn: OK, tôi sẽ gửi cho bạn vào chiều nay</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">12:30</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User2" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-offline"></span>
                        Phòng Đào tạo
                    </div>
                    <div class="contact-preview">Vui lòng xác nhận lịch học bổ sung...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">Hôm qua</div>
                    <div class="contact-badge">2</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User3" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-away"></span>
                        TS. Nguyễn Văn C
                    </div>
                    <div class="contact-preview">Sinh viên cần chuẩn bị báo cáo cho buổi...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">T2</div>
                    <div class="contact-badge">1</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User4" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-online"></span>
                        Lê Văn D
                    </div>
                    <div class="contact-preview">Anh ơi, cho em hỏi về bài tập số 5...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">T2</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User5" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-offline"></span>
                        Phòng CTSV
                    </div>
                    <div class="contact-preview">Thông báo về việc đóng học phí học kỳ...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">21/03</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User6" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-offline"></span>
                        Nhóm Đồ án CNTT
                    </div>
                    <div class="contact-preview">Hoàng: Các bạn nhớ họp nhóm vào tối nay...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">20/03</div>
                </div>
            </div>
            <div class="contact-item">
                <img src="https://via.placeholder.com/200x200?text=User7" alt="Contact Avatar" class="contact-avatar">
                <div class="contact-info">
                    <div class="contact-name">
                        <span class="contact-status status-away"></span>
                        Phạm Thị E
                    </div>
                    <div class="contact-preview">Bạn có ghi chép bài hôm thứ 4 không?...</div>
                </div>
                <div class="contact-meta">
                    <div class="contact-time">18/03</div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <div class="chat-header">
                <div class="chat-user">
                    <img src="https://via.placeholder.com/200x200?text=User1" alt="Chat User Avatar">
                    <div class="chat-user-info">
                        <h5>Trần Thị B</h5>
                        <p><span class="contact-status status-online"></span> Đang hoạt động</p>
                    </div>
                </div>
                <div class="chat-actions">
                    <a href="#" title="Tìm kiếm"><i class="fas fa-search"></i></a>
                    <a href="#" title="Gọi video"><i class="fas fa-video"></i></a>
                    <a href="#" title="Gọi thoại"><i class="fas fa-phone-alt"></i></a>
                    <a href="#" title="Thông tin"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>

            <div class="chat-messages">
                <div class="date-divider">
                    <span>Hôm nay</span>
                </div>

                <div class="message incoming">
                    <div class="message-content">
                        Chào bạn, tôi muốn hỏi về tài liệu môn Mạng máy tính, bạn có thể chia sẻ cho tôi được không?
                    </div>
                    <div class="message-time">09:15</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        Chào bạn, tôi có đây. Bạn cần tài liệu nào ạ?
                    </div>
                    <div class="message-time">09:17</div>
                </div>

                <div class="message incoming">
                    <div class="message-content">
                        Mình cần slide bài giảng tuần 5 và tài liệu thực hành lab 3 ạ. Hôm đó mình nghỉ ốm nên không có ghi chép.
                    </div>
                    <div class="message-time">09:20</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        OK, tôi sẽ gửi cho bạn vào chiều nay. Để tôi tổng hợp lại tài liệu đã.
                    </div>
                    <div class="message-time">09:22</div>
                </div>

                <div class="message incoming">
                    <div class="message-content">
                        Cảm ơn bạn nhiều, bạn có thể gửi qua email cũng được. Email của mình là b.tt123456@tlu.edu.vn
                    </div>
                    <div class="message-time">09:25</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        Đã ghi lại. Tôi sẽ gửi qua cả email và tin nhắn ở đây để bạn tiện theo dõi.
                    </div>
                    <div class="message-time">09:27</div>
                </div>

                <div class="message incoming">
                    <div class="message-content">
                        Tuyệt vời! Tiện đây cho mình hỏi luôn, bài tập lab 3 đến khi nào phải nộp vậy?
                    </div>
                    <div class="message-time">10:05</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        Thầy yêu cầu nộp vào buổi học tới, tức là thứ 5 tuần sau (11/04) đó bạn.
                    </div>
                    <div class="message-time">10:10</div>
                </div>

                <div class="message incoming message-with-image">
                    <div class="message-content">
                        Mình có chụp lại trang bìa bài tập như này, bạn xem có đúng form không nhé?
                        <img src="https://via.placeholder.com/400x300?text=Assignment+Cover" alt="Assignment Cover" class="message-image">
                    </div>
                    <div class="message-time">10:32</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        Đúng rồi bạn, form như vậy là chuẩn. Nhớ ghi rõ họ tên, mã SV và lớp ở bên trên góc phải nữa nhé.
                    </div>
                    <div class="message-time">10:37</div>
                </div>

                <div class="message incoming">
                    <div class="message-content">
                        OK, cảm ơn bạn rất nhiều!
                    </div>
                    <div class="message-time">10:40</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        Không có gì đâu, có thắc mắc gì cứ hỏi mình nhé.
                    </div>
                    <div class="message-time">10:41</div>
                </div>

                <div class="message outgoing">
                    <div class="message-content">
                        À quên, nhớ kiểm tra email nhé, tôi sẽ gửi cho bạn vào chiều nay.
                    </div>
                    <div class="message-time">12:30</div>
                </div>
            </div>

            <div class="chat-input">
                <button class="attachment-btn">
                    <i class="fas fa-paperclip"></i>
                </button>
                <textarea class="form-control" placeholder="Nhập tin nhắn..."></textarea>
                <button class="send-btn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Empty State (Initially Hidden) -->
    <div class="empty-state d-none">
        <i class="far fa-comment-dots"></i>
        <h4>Chưa có cuộc trò chuyện nào</h4>
        <p>Bắt đầu một cuộc trò chuyện mới với các thành viên trong trường.</p>
        <button class="btn btn-primary rounded-pill px-4 py-2">
            <i class="fas fa-plus me-2"></i> Tạo cuộc trò chuyện mới
        </button>
    </div>
</div>

<!-- New Message Button -->
<a href="#" class="new-message-btn">
    <i class="fas fa-pen"></i>
</a>

@endsection
