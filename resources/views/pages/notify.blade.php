@extends('layouts.app')

@section('content')

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item">Thông báo</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Announcement Section -->
<section class="announcement-section">
    <div class="container">
        <!-- Search and Filter -->
        <div class="search-filter-container">
            <!-- Search Form -->
            <form method="GET" action="{{ route('notification.index') }}" id="filterForm">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="search-box">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Tìm kiếm thông báo..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="filter-options">
                    <div class="filter-group">
                        <span class="filter-label">Sắp xếp theo:</span>
                        <select class="filter-select" name="sort" onchange="submitFilter()">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>A-Z</option>
                            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>Z-A</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <span class="filter-label">Danh mục:</span>
                        <select class="filter-select" name="category" onchange="submitFilter()">
                            <option value="all" {{ request('category') == 'all' || !request('category') ? 'selected' : '' }}>Tất cả danh mục</option>
                            @foreach($notification_categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- <div class="filter-group">
                        <span class="filter-label">Nguồn:</span>
                        <select class="filter-select" name="source" onchange="submitFilter()">
                            <option value="all" {{ request('source') == 'all' || !request('source') ? 'selected' : '' }}>Tất cả nguồn</option>
                            <option value="admin" {{ request('source') == 'admin' ? 'selected' : '' }}>Ban quản trị</option>
                            <option value="faculties" {{ request('source') == 'faculties' ? 'selected' : '' }}>Các khoa</option>
                            <option value="departments" {{ request('source') == 'departments' ? 'selected' : '' }}>Các phòng ban</option>
                            <option value="student-affairs" {{ request('source') == 'student-affairs' ? 'selected' : '' }}>Phòng Công tác Sinh viên</option>
                        </select>
                    </div> --}}

                    <div class="col-md-6">
                        <button type="button" class="btn btn-outline-secondary px-5" onclick="clearFilters()">
                            <i class="fas fa-undo me-1"></i>Xóa bộ lọc
                        </button>
                    </div>
                </div>

                
            </form>
        </div>

        <!-- Results Info -->
        <div class="results-info mb-3">
            <p class="text-muted">
                Tìm thấy {{ $notifications->total() }} thông báo
                @if(request('search'))
                    cho từ khóa "<strong>{{ request('search') }}</strong>"
                @endif
                @if(request('category') && request('category') != 'all')
                    @php
                        $selectedCategory = $notification_categories->find(request('category'));
                    @endphp
                    trong danh mục "<strong>{{ $selectedCategory->name ?? '' }}</strong>"
                @endif
            </p>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                @if($notifications->count() > 0)
                    <!-- Featured Announcement (First item if exists) -->
                    @if($notifications->currentPage() == 1 && $notifications->first())
                        <div class="featured-announcement mb-4">
                            <div class="featured-announcement-badge">
                                <i class="fas fa-star me-1"></i> Nổi bật
                            </div>
                            <div class="featured-announcement-image">
                                @if($notifications->first()->images)
                                    <img src="{{ asset('storage/' . explode(',', $notifications->first()->images)[0]) }}" alt="Featured Announcement">
                                @else
                                    <img src="https://images2.thanhnien.vn/528068263637045248/2024/1/25/3b690baedbd9a609207c76684a3413d0-65a11b0a7e79d880-17061562931311973368410.jpg" alt="Featured Announcement">
                                @endif
                                <div class="featured-announcement-overlay">
                                    <div class="featured-announcement-date">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $notifications->first()->created_at->format('d/m/Y') }}
                                    </div>
                                    <h2 class="featured-announcement-title">
                                        <a href="{{ route('notification.show', $notifications->first()->id) }}">{{ $notifications->first()->title }}</a>
                                    </h2>
                                    <div class="featured-announcement-excerpt">
                                        {{ Str::limit($notifications->first()->content, 200) }}
                                    </div>
                                    <a href="{{ route('notification.show', $notifications->first()->id) }}" class="featured-announcement-button">
                                        <i class="fas fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Announcements Grid -->
                    <div class="row">
                        @foreach ($notifications->skip($notifications->currentPage() == 1 ? 1 : 0) as $notification)
                            <div class="col-md-6 mb-4">
                                <div class="announcement-card">
                                    <div class="announcement-header">
                                        @if($notification->images)
                                            @php
                                                $images = explode(',', $notification->images);
                                            @endphp
                                            <img src="{{ asset('storage/' . $images[0]) }}" alt="Announcement Image">
                                        @endif
                                        <span class="announcement-category">
                                            @if ($notification->category)
                                                {{ $notification->category->name }}
                                            @else
                                                Chưa phân loại
                                            @endif
                                        </span>
                                    </div>

                                    <div class="announcement-body">
                                        <div class="announcement-date">
                                            <i class="far fa-calendar-alt"></i> {{ $notification->created_at->format('d/m/Y') }}
                                        </div>
                                        <h3 class="announcement-title">
                                            <a href="{{ route('notification.show', $notification->id) }}">{{ $notification->title }}</a>
                                        </h3>
                                        <div class="announcement-excerpt">
                                            {{ Str::limit($notification->content, 120) }}
                                        </div>
                                        <div class="announcement-footer">
                                            <div class="announcement-author">
                                                <img src="{{ $notification->user && $notification->user->avatar ? asset('storage/avatars/'.$notification->user->avatar) : asset('user_default.jpg') }}" alt="Author">
                                                <span>
                                                    @if($notification->user && $notification->user->managedDepartment)
                                                        {{ $notification->user->managedDepartment->name }}
                                                    @else
                                                        Không xác định
                                                    @endif
                                                </span>
                                            </div>
                                            <a href="{{ route('notification.show', $notification->id) }}" class="read-more">
                                                Xem thêm <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container">
                        {{ $notifications->appends(request()->query())->links('partials.pagination') }}
                    </div>
                @else
                    <!-- No Results -->
                    <div class="no-results text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4>Không tìm thấy thông báo nào</h4>
                        <p class="text-muted">Hãy thử thay đổi từ khóa tìm kiếm hoặc bộ lọc</p>
                        <button type="button" class="btn btn-primary" onclick="clearFilters()">
                            <i class="fas fa-undo me-1"></i>Xóa bộ lọc
                        </button>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                @can('create-notification', $notifications)
                    <div class="create-notification-btn mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNotificationModal">
                            <i class="fas fa-plus me-2"></i>Tạo thông báo mới
                        </button>
                    </div>
                @endcan

                <!-- Categories -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Danh mục thông báo</h3>
                    <ul class="categories-list">
                        <li>
                            <a href="{{ route('notification.index') }}" class="{{ !request('category') || request('category') == 'all' ? 'active' : '' }}">
                                Tất cả <span class="badge">{{ $total_notifications }}</span>
                            </a>
                        </li>
                        @foreach ($notification_categories as $category)
                            <li>
                                <a href="{{ route('notification.category', $category->id) }}" 
                                   class="{{ request('category') == $category->id ? 'active' : '' }}">
                                    {{ $category->name }}
                                    <span class="badge">{{ $category_counts[$category->id] ?? 0 }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Announcements -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Thông báo gần đây</h3>
                    <ul class="recent-posts">
                        @foreach ($notification_latests as $notification)
                            <li class="recent-post-item">
                                <div class="recent-post-image">
                                    @if($notification->images)
                                        @php
                                            $images = explode(',', $notification->images);
                                        @endphp
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="Recent Post">
                                    @endif
                                </div>
                                <div class="recent-post-content">
                                    <h5><a href="{{ route('notification.show', $notification->id) }}">{{ Str::limit($notification->title, 50) }}</a></h5>
                                    <div class="recent-post-date">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $notification->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Modal Tạo Thông Báo -->
                <div class="modal fade" id="createNotificationModal" tabindex="-1" aria-labelledby="createNotificationModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createNotificationModalLabel">
                                    <i class="fas fa-bell me-2"></i>Tạo thông báo mới
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="createNotificationForm" action="{{ route('notification.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">
                                            Tiêu đề thông báo <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="title" name="title">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">Danh mục</label>
                                        <select class="form-select" id="category_id" name="category_id">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($notification_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label fw-bold">
                                            Nội dung <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="images" class="form-label fw-bold">Hình ảnh</label>
                                        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                        <div class="form-text">Có thể chọn nhiều hình ảnh. Định dạng: jpeg, png, jpg, gif (Tối đa 2MB)</div>
                                        <div class="invalid-feedback"></div>
                                        
                                        <!-- Preview container -->
                                        <div id="imagePreviewContainer" class="mt-3 d-none">
                                            <label class="form-label">Xem trước:</label>
                                            <div id="imagePreview" class="d-flex gap-2 flex-wrap"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Hủy
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-1"></i>Tạo thông báo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function submitFilter() {
    document.getElementById('filterForm').submit();
}

function clearFilters() {
    window.location.href = '{{ route("notification.index") }}';
}

// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const files = e.target.files;
    const previewContainer = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    
    preview.innerHTML = '';
    
    if (files.length > 0) {
        previewContainer.classList.remove('d-none');
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.className = 'rounded border';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.classList.add('d-none');
    }
});

// Auto-submit search form when Enter is pressed
document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('filterForm').submit();
    }
});
</script>

@endsection

<style>
    /* Search and Filter Styles */
.search-filter-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.search-box {
    position: relative;
    display: flex;
}

.search-box input {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-right: none;
    padding-right: 50px;
}

.search-box button {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    min-width: 50px;
}

.filter-options {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: center;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-label {
    font-weight: 500;
    color: #6c757d;
    white-space: nowrap;
}

.filter-select {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 14px;
    min-width: 150px;
    background: white;
    transition: all 0.3s ease;
}

.filter-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    outline: none;
}

/* Results Info */
.results-info {
    padding: 15px;
    background: #e7f3ff;
    border-left: 4px solid #0d6efd;
    border-radius: 4px;
}

/* No Results */
.no-results {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 40px 20px;
}

.no-results i {
    opacity: 0.5;
}

/* Announcement Cards */
.announcement-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    overflow: hidden;
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.announcement-header {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.announcement-header img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.announcement-card:hover .announcement-header img {
    transform: scale(1.05);
}

.announcement-category {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(13, 110, 253, 0.9);
    color: white;
    padding: 4px 8px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
}

.announcement-body {
    padding: 20px;
}

.announcement-date {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 10px;
}

.announcement-title {
    margin-bottom: 15px;
    font-size: 18px;
    line-height: 1.4;
}

.announcement-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.announcement-title a:hover {
    color: #0d6efd;
}

.announcement-excerpt {
    color: #6c757d;
    margin-bottom: 20px;
    line-height: 1.6;
}

.announcement-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 15px;
    border-top: 1px solid #eee;
}

.announcement-author {
    display: flex;
    align-items: center;
    gap: 8px;
}

.announcement-author img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    object-fit: cover;
}

.announcement-author span {
    font-size: 14px;
    color: #6c757d;
}

.read-more {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 500;
    font-size: 14px;
    transition: color 0.3s ease;
}

.read-more:hover {
    color: #0851d4;
}

/* Featured Announcement */
.featured-announcement {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    margin-bottom: 30px;
}

.featured-announcement-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: linear-gradient(45deg, #ff6b6b, #ffa500);
    color: white;
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 500;
    z-index: 2;
    font-size: 14px;
}

.featured-announcement-image {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.featured-announcement-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-announcement-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 40px 30px 30px;
}

.featured-announcement-date {
    margin-bottom: 10px;
    opacity: 0.9;
}

.featured-announcement-title {
    font-size: 24px;
    margin-bottom: 15px;
    line-height: 1.3;
}

.featured-announcement-title a {
    color: white;
    text-decoration: none;
}

.featured-announcement-excerpt {
    margin-bottom: 20px;
    opacity: 0.9;
    line-height: 1.6;
}

.featured-announcement-button {
    display: inline-block;
    background: #0d6efd;
    color: white;
    padding: 10px 20px;
    border-radius: 25px;
    text-decoration: none;
    transition: background 0.3s ease;
    font-weight: 500;
}

.featured-announcement-button:hover {
    background: #0851d4;
    color: white;
}

/* Sidebar */
.sidebar-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 25px;
    margin-bottom: 25px;
}

.sidebar-title {
    font-size: 18px;
    margin-bottom: 20px;
    color: #333;
    border-bottom: 2px solid #0d6efd;
    padding-bottom: 10px;
}

.categories-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.categories-list li {
    margin-bottom: 10px;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    color: #333;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.categories-list a:hover,
.categories-list a.active {
    background: #0d6efd;
    color: white;
}

.categories-list .badge {
    background: #e9ecef;
    color: #6c757d;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
}

.categories-list a:hover .badge,
.categories-list a.active .badge {
    background: rgba(255,255,255,0.2);
    color: white;
}

.recent-posts {
    list-style: none;
    padding: 0;
    margin: 0;
}

.recent-post-item {
    display: flex;
    gap: 12px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.recent-post-item:last-child {
    border-bottom: none;
}

.recent-post-image {
    flex-shrink: 0;
}

.recent-post-image img {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}

.recent-post-content h5 {
    font-size: 14px;
    margin-bottom: 8px;
    line-height: 1.4;
}

.recent-post-content a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.recent-post-content a:hover {
    color: #0d6efd;
}

.recent-post-date {
    font-size: 12px;
    color: #6c757d;
}

/* Pagination */
.pagination-container {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #eee;
}

.pagination .page-link {
    border: none;
    padding: 10px 15px;
    margin: 0 2px;
    border-radius: 8px;
    color: #6c757d;
    transition: all 0.3s ease;
}

.pagination .page-item.active .page-link {
    background: #0d6efd;
    color: white;
}

.pagination .page-link:hover {
    background: #e9ecef;
    color: #333;
}

.pagination .page-item.disabled .page-link {
    background: transparent;
    color: #d6d8db;
}

/* Create Notification Button */
.create-notification-btn .btn {
    width: 100%;
    padding: 12px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.create-notification-btn .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .filter-options {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .filter-group {
        flex-direction: column;
        align-items: stretch;
        gap: 5px;
    }
    
    .filter-select {
        min-width: auto;
    }
    
    .featured-announcement-overlay {
        padding: 20px 15px 15px;
    }
    
    .featured-announcement-title {
        font-size: 20px;
    }
    
    .announcement-card {
        margin-bottom: 20px;
    }
}
</style>