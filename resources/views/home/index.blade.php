@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Hệ thống tra cứu và trao đổi thông tin nội bộ TLU</h1>
            <p>Kết nối thông tin - Chia sẻ tri thức - Xây dựng cộng đồng</p>

            <div class="hero-actions">
                <a href="{{ route('contact.index') }}" class="btn bg-white" style="color:#005baa">Bắt đầu ngay</a>
                <a href="#" class="btn btn-outline" style="color: #ffffff; border-color: #ffffff">Tìm hiểu thêm</a>
            </div>
        </div>
    </section>

    <!-- Directory Section -->
    <section class="directory-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Tính năng chính</h2>
                <p>Tra cứu thông tin liên lạc của đơn vị, giảng viên, sinh viên và trao đổi thông tin một cách nhanh chóng và dễ dàng</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-building me-2"></i> Danh Bạ Điện Tử
                        </div>
                        <div class="card-body">
                            <p>Tra cứu thông tin liên lạc của các đơn vị, cán bộ giảng viên và sinh viên một cách nhanh chóng, chính xác</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('contact.index')}}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem danh bạ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-user-tie me-2"></i> Tin nhắn
                        </div>
                        <div class="card-body">
                            <p>Nhắn tin trực tiếp với các người dùng khác để có thể trao đổi thông tin</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('chat.index')}}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem tin nhắn
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <div class="card-header">
                            <i class="fas fa-user-graduate me-2"></i> Diễn đàn
                        </div>
                        <div class="card-body">
                            <p>Hỏi và giải đáp thắc mắc nơi mà cộng đồng TLU có thể trao đổi thông tin trực tiếp với nhau</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{route('forum.index')}}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem diễn đàn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    <section class="announcement-section mt-3">
        <div class="container">
            <div class="section-title text-center">
                <h2>Thông báo mới nhất</h2>
                <p>Cập nhật những thông tin mới nhất từ hệ thống tra cứu và trao đổi thông tin nội bộ TLU</p>
            </div>

            <div class="row">
                @if(count($notification_latests) > 0)
                    @foreach ($notification_latests as $item)
                        <div class="col-lg-6">
                            <div class="announcement-card">
                                <div class="card-body">
                                    <div class="date">
                                        <div class="day">{{ date('d', strtotime($item->created_at ?? now())) }}</div>
                                        <div class="month">{{ strtoupper(date('M', strtotime($item->created_at ?? now()))) }}</div>
                                    </div>
                                    <h5>{{ $item->title ?? 'Thông báo cập nhật hệ thống danh bạ điện tử' }}</h5>
                                    <p>{{ $item->content ?? 'Hệ thống danh bạ điện tử Trường Đại học Thủy Lợi sẽ được nâng cấp vào ngày 10/03/2025. Trong thời gian cập nhật, hệ thống sẽ tạm ngưng hoạt động từ 22:00 đến 23:59.' }}</p>
                                    <div class="meta">
                                        <i class="fas fa-user me-1"></i> {{ $item->author ?? 'Ban Quản trị' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="empty-state-card">
                            <div class="card-body text-center py-5">
                                <div class="empty-icon mb-3">
                                    <i class="bi bi-bell-slash" style="font-size: 3rem; color: #6c757d;"></i>
                                </div>
                                <h5 class="text-muted">Chưa có thông báo nào</h5>
                                <p class="text-muted mb-0">Hiện tại chưa có thông báo mới nào được đăng tải.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="text-center mt-4">
                <a href="{{route('notification.index')}}" class="btn btn-outline-primary">
                    <i class="fas fa-bell me-2"></i> Xem tất cả thông báo
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="count">25+</div>
                        <div class="title">Đơn vị</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="count">500+</div>
                        <div class="title">Giảng viên</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="count">15,000+</div>
                        <div class="title">Sinh viên</div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <div class="stat-item">
                        <div class="icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="count">10,000+</div>
                        <div class="title">Lượt truy cập</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @endsection

