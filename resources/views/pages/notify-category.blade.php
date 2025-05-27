@extends('layouts.app')

@section('content')

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Thông báo - {{ $current_category->name }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notification.index') }}">Thông báo</a></li>
                        <li class="breadcrumb-item ">{{ $current_category->name }}</li>
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
            <div class="filter-options">
                <div class="filter-group">
                    <span class="filter-label">Sắp xếp theo:</span>
                    <select class="filter-select" onchange="sortNotifications(this.value)">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="az">A-Z</option>
                        <option value="za">Z-A</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <div class="category-header mb-4">
                    <h2 class="category-title">
                        <i class="fas fa-folder-open me-2"></i>{{ $current_category->name }}
                    </h2>
                    <p class="category-description">
                        Hiển thị {{ $notifications->count() }} trong tổng số {{ $notifications->total() }} thông báo
                    </p>
                </div>

                <!-- Announcements Grid -->
                <div class="row">
                    @forelse ($notifications as $notification)
                        <div class="col-md-6 mb-4">
                            <div class="announcement-card">
                                <div class="announcement-header">
                                    @if($notification->images)
                                        <img src="{{ asset('storage/' . $notification->images_array[0]) }}" alt="Announcement Image">
                                    @else
                                        {{-- <img src="https://via.placeholder.com/400x200?text=No+Image" alt="No Image"> --}}
                                    @endif
                                    <span class="announcement-category">
                                        {{ $current_category->name }}
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
                                        {{ Str::limit($notification->content, 150) }}
                                    </div>
                                    <div class="announcement-footer">
                                        <div class="announcement-author">
                                            @if($notification->user)
                                                <img src="{{ $notification->user->avatar ?? asset('user_default.jpg') }}" alt="Author">
                                                <span>{{ $notification->user->name }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('notification.show', $notification->id) }}" class="read-more">
                                            Xem thêm <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>Không có thông báo nào trong danh mục này.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($notifications->hasPages())
                    <div class="pagination-container">
                        {{ $notifications->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Danh mục thông báo</h3>
                    <ul class="categories-list">
                        <li class="{{ !request()->segment(3) ? 'active' : '' }}">
                            <a href="{{ route('notification.index') }}">Tất cả <span class="badge">{{ App\Models\Notification::count() }}</span></a>
                        </li>
                        @foreach ($notification_categories as $category)
                            <li class="{{ $current_category->id == $category->id ? 'active' : '' }}">
                                <a href="{{ route('notification.category', $category->id) }}">
                                    {{ $category->name }}
                                    <span class="badge">{{ $category->notifications->count() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Announcements -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Thông báo gần đây</h3>
                    <ul class="recent-posts">
                        @foreach ($notification_latests as $latest)
                            <li class="recent-post-item">
                                <div class="recent-post-image">
                                    @if($latest->images)
                                        <img src="{{ asset('storage/' . $latest->images_array[0]) }}" alt="Recent">
                                    @else
                                        {{-- <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image"> --}}
                                    @endif  
                                </div>
                                <div class="recent-post-content">
                                    <h5><a href="{{ route('notification.show', $latest->id) }}">{{ Str::limit($latest->title, 50) }}</a></h5>
                                    <div class="recent-post-date">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $latest->created_at->format('d/m/Y') }}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.category-header {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.category-title {
    color: #333;
    font-size: 24px;
    margin-bottom: 10px;
}

.category-description {
    color: #666;
    margin: 0;
}

.categories-list li.active a {
    color: #007bff;
    font-weight: bold;
}
</style>

<script>
function sortNotifications(sortBy) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('sort', sortBy);
    window.location.href = currentUrl.toString();
}
</script>

@endsection