@extends('layouts.app')

@section('title')
    Danh sách các loại danh bạ
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Danh bạ điện tử Trường Đại học Thủy Lợi</h1>
            <p>Kết nối thông tin - Chia sẻ tri thức - Xây dựng cộng đồng</p>

                {{-- <div class="search-box">
                    <select class="form-select">
                        <option selected>Tất cả</option>
                        <option>Đơn vị</option>
                        <option>Giảng viên</option>
                        <option>Sinh viên</option>
                    </select>
                    <input type="text" class="form-control" placeholder="Nhập tên, mã, chức vụ cần tìm...">
                    <button type="button">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div> --}}
        </div>
    </section>


     <!-- Directory Section -->
     <section class="directory-section">
        <div class="container">
            <div class="section-title text-center">
                <h2>Danh mục tra cứu</h2>
                <p>Tra cứu thông tin liên lạc của đơn vị, giảng viên và sinh viên một cách nhanh chóng và chính xác</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" alt="Faculty" class="card-img">
                        <div class="card-header">
                            <i class="fas fa-building me-2"></i> Danh bạ đơn vị
                        </div>
                        <div class="card-body">
                            <p>Thông tin liên lạc của các khoa, phòng ban, trung tâm và các đơn vị trực thuộc trường Đại học Thủy Lợi.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('contact.department') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem danh bạ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" alt="Staff" class="card-img">
                        <div class="card-header">
                            <i class="fas fa-user-tie me-2"></i> Danh bạ giảng viên
                        </div>
                        <div class="card-body">
                            <p>Thông tin liên lạc của cán bộ, giảng viên đang công tác và giảng dạy tại trường Đại học Thủy Lợi.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('contact.teacher') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem danh bạ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="directory-card">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png" alt="Student" class="card-img">
                        <div class="card-header">
                            <i class="fas fa-user-graduate me-2"></i> Danh bạ sinh viên
                        </div>
                        <div class="card-body">
                            <p>Thông tin liên lạc của sinh viên đang theo học tại trường Đại học Thủy Lợi (phù hợp với quyền truy cập).</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('contact.student') }}" class="btn btn-outline-primary w-100">
                                <i class="fas fa-arrow-right me-2"></i> Xem danh bạ
                            </a>
                        </div>
                    </div>
                </div>

                <section class="announcement-section">
                    <div class="container">
                        <div class="section-title text-center">
                            <h2>Thông báo mới nhất</h2>
                            <p>Cập nhật những thông tin mới nhất từ hệ thống danh bạ điện tử Đại học Thủy Lợi</p>
                        </div>

                        <div class="row">
                            @if(count($notification_latests) > 0)
                                @foreach ($notification_latests as $item)
                                    <div class="col-lg-6 my-1">
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
                    </div>
                </div>

            <div class="text-center mt-4">
                <a href="{{ route('notification.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-bell me-2"></i> Xem tất cả thông báo
                </a>
            </div>
        </div>
    </section>

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
                        <div class="title">Lượt tra cứu/tháng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
 
