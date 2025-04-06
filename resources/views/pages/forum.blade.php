@extends('layouts.app')

@section('content')

<section class="forum-header">
    <div class="container text-center">
        <h1>Diễn đàn trao đổi TLU</h1>
        <p>Nơi trao đổi, chia sẻ kiến thức, thông tin và giải đáp thắc mắc trong cộng đồng Đại học Thủy Lợi</p>
        <div class="search-box bg-white p-2 rounded-pill d-flex align-items-center justify-content-between mt-4 mx-auto" style="max-width: 600px;">
            <input type="text" class="border-0 flex-grow-1 p-2 ms-3" placeholder="Tìm kiếm chủ đề, bài viết...">
            <button class="btn btn-primary rounded-pill px-4 py-2 fw-semibold"><i class="fas fa-search me-2"></i> Tìm kiếm</button>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Diễn đàn</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <!-- Left Column - Categories and Posts -->
        <div class="col-lg-8">
            <!-- Forum Categories -->
            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-graduation-cap category-icon"></i>
                        Học tập & Nghiên cứu
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">4 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Hỏi đáp về môn Toán cao cấp</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Nguyễn Văn A</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">24</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">142</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Chia sẻ đề tài nghiên cứu khoa học sinh viên năm 2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Trần Thị B</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 1 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">18</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">203</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Khó khăn khi học lập trình Java và cách khắc phục</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Lê Văn C</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 3 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">36</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">310</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-bullhorn category-icon"></i>
                        Thông báo & Sự kiện
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">2 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Thông báo lịch thi học kỳ II năm học 2024-2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user-tie me-1"></i> Phòng Đào tạo</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 3 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">12</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">578</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Hội thảo cơ hội việc làm cho sinh viên CNTT 2025</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user-tie me-1"></i> Khoa CNTT</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">8</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">425</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="forum-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users category-icon"></i>
                        Đời sống sinh viên
                    </div>
                    <span class="badge rounded-pill bg-light text-dark">5 chủ đề mới</span>
                </div>
                <div class="card-body p-0">
                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Phạm Thị D</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 5 giờ trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">45</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">389</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>

                    <div class="topic-item">
                        <div class="topic-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="topic-content">
                            <a href="#" class="topic-title">Top 10 quán ăn ngon bổ rẻ gần trường TLU</a>
                            <div class="topic-info">
                                <span><i class="fas fa-user me-1"></i> Trần Văn E</span>
                                <span class="ms-3"><i class="far fa-clock me-1"></i> 2 ngày trước</span>
                            </div>
                        </div>
                        <div class="topic-stats">
                            <div class="stat-item">
                                <div class="stat-count">67</div>
                                <div class="stat-label">Trả lời</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-count">520</div>
                                <div class="stat-label">Lượt xem</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Posts -->
            <div class="latest-posts">
                <h4 class="section-title">Bài viết mới nhất</h4>

                <div class="post-card">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                        <div>
                            <h6 class="post-author">Nguyễn Văn A</h6>
                            <span class="post-time">Đăng 2 giờ trước</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <h5 class="post-title">Cách giải bài tập Toán cao cấp phần đạo hàm</h5>
                        <p class="post-text">Chào các bạn, mình đang gặp khó khăn với bài tập đạo hàm hàm số nhiều biến trong môn Toán cao cấp. Mình đã thử giải theo phương pháp...</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="post-footer">
                        <div class="post-actions">
                            <a href="#"><i class="far fa-comment"></i> 8 bình luận</a>
                            <a href="#"><i class="far fa-heart"></i> 15 thích</a>
                            <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                        </div>
                        <div class="post-meta">
                            <span><i class="fas fa-folder me-1"></i> Học tập & Nghiên cứu</span>
                        </div>
                    </div>
                </div>

                <div class="post-card">
                    <div class="post-header">
                        <img src="https://via.placeholder.com/200x200?text=User" alt="User Avatar" class="post-avatar">
                        <div>
                            <h6 class="post-author">Phòng Đào tạo</h6>
                            <span class="post-time">Đăng 3 giờ trước</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <h5 class="post-title">Thông báo lịch thi học kỳ II năm học 2024-2025</h5>
                        <p class="post-text">Phòng Đào tạo thông báo lịch thi học kỳ II năm học 2024-2025 dành cho các khoa như sau: 1. Khoa Công nghệ thông tin: từ ngày 15/06 đến 30/06/2025...</p>
                        <a href="#" class="btn btn-sm btn-outline-primary">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                    <div class="post-footer">
                        <div class="post-actions">
                            <a href="#"><i class="far fa-comment"></i> 12 bình luận</a>
                            <a href="#"><i class="far fa-heart"></i> 34 thích</a>
                            <a href="#"><i class="far fa-bookmark"></i> Lưu</a>
                        </div>
                        <div class="post-meta">
                            <span><i class="fas fa-folder me-1"></i> Thông báo & Sự kiện</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <nav aria-label="Forum pagination">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <div class="forum-sidebar">
                <!-- Statistics Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-2"></i> Thống kê diễn đàn
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users"></i> Thành viên</span>
                            <span class="fw-bold">15,243</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-comments"></i> Chủ đề</span>
                            <span class="fw-bold">2,456</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-reply"></i> Bài viết</span>
                            <span class="fw-bold">18,789</span>
                        </div>

                    </div>
                </div>

                <!-- Active Topics Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-fire me-2"></i> Chủ đề nổi bật
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Chia sẻ kinh nghiệm tìm nhà trọ khu vực Đống Đa</span>
                                <span class="badge rounded-pill bg-primary">45</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Top 10 quán ăn ngon bổ rẻ gần trường TLU</span>
                                <span class="badge rounded-pill bg-primary">67</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Khó khăn khi học lập trình Java và cách khắc phục</span>
                                <span class="badge rounded-pill bg-primary">36</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Thông báo lịch thi học kỳ II năm học 2024-2025</span>
                                <span class="badge rounded-pill bg-primary">12</span>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-truncate">Hỏi đáp về môn Toán cao cấp</span>
                                <span class="badge rounded-pill bg-primary">24</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Active Members Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-medal me-2"></i> Thành viên tích cực
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item user-item">
                            <img src="https://via.placeholder.com/200x200?text=User1" alt="User Avatar">
                            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                <span>Nguyễn Văn A</span>
                                <span class="badge bg-primary">148 bài viết</span>
                            </div>
                        </div>
                        <div class="list-group-item user-item">
                            <img src="https://via.placeholder.com/200x200?text=User2" alt="User Avatar">
                            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                <span>Trần Thị B</span>
                                <span class="badge bg-primary">126 bài viết</span>
                            </div>
                        </div>
                        <div class="list-group-item user-item">
                            <img src="https://via.placeholder.com/200x200?text=User3" alt="User Avatar">
                            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                <span>Lê Văn C</span>
                                <span class="badge bg-primary">94 bài viết</span>
                            </div>
                        </div>
                        <div class="list-group-item user-item">
                            <img src="https://via.placeholder.com/200x200?text=User4" alt="User Avatar">
                            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                <span>Phạm Thị D</span>
                                <span class="badge bg-primary">87 bài viết</span>
                            </div>
                        </div>
                        <div class="list-group-item user-item">
                            <img src="https://via.placeholder.com/200x200?text=User5" alt="User Avatar">
                            <div class="d-flex justify-content-between align-items-center flex-grow-1">
                                <span>Trần Văn E</span>
                                <span class="badge bg-primary">75 bài viết</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Card -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-folder me-2"></i> Chuyên mục
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-graduation-cap me-2"></i> Học tập & Nghiên cứu</span>
                            <span class="badge rounded-pill bg-primary">324</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-bullhorn me-2"></i> Thông báo & Sự kiện</span>
                            <span class="badge rounded-pill bg-primary">156</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i> Đời sống sinh viên</span>
                            <span class="badge rounded-pill bg-primary">289</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-briefcase me-2"></i> Việc làm & Thực tập</span>
                            <span class="badge rounded-pill bg-primary">127</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-lightbulb me-2"></i> Ý tưởng & Sáng tạo</span>
                            <span class="badge rounded-pill bg-primary">98</span>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- New Topic Button -->
<a href="#" class="new-topic-btn">
    <i class="fas fa-plus"></i>
</a>


@endsection
