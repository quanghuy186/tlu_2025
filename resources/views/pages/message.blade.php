{{-- resources/views/pages/message.blade.php --}}
@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

{{-- @section('head')
<!-- Meta data -->
<meta name="user-id" content="{{ Auth::id() }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection --}}

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
                <li class="breadcrumb-item"><a href="{{ route('home.index') }}" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin nhắn</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="messages-container">
        <!-- Contacts List -->
        {{-- <div class="contacts-list">
            <div class="contacts-header">
                <div class="search-contact">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Tìm kiếm liên hệ...">
                </div>
            </div>
        </div> --}}

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

            <div class="chat-input disabled">
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

@push('scripts')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

<!-- Load một file JS nhỏ để khởi tạo Echo trước -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Load file message.js mới của chúng ta -->
    <script src="{{ asset('js/message.js') }}"></script>
@endpush