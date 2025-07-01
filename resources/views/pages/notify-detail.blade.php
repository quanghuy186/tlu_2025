@extends('layouts.app')

@section('title')
    Xem chi tiết thông báo
@endsection

@section('content')

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Chi tiết thông báo</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('notification.index') }}">Thông báo</a></li>
                        @if($notification->category)
                            <li class="breadcrumb-item"><a href="{{ route('notification.category', $notification->category->id) }}">{{ $notification->category->name }}</a></li>
                        @endif
                        <li class="breadcrumb-item">{{ Str::limit($notification->title, 50) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="notification-detail-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mb-4">
                <article class="notification-detail">
                    <!-- Header -->
                    <div class="notification-detail-header">
                        <h1 class="notification-detail-title">{{ $notification->title }}</h1>
                        
                        <div class="notification-meta">
                            <div class="meta-item">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($notification->category)
                                <div class="meta-item">
                                    <i class="fas fa-folder"></i>
                                    <a href="{{ route('notification.category', $notification->category->id) }}">{{ $notification->category->name }}</a>
                                </div>
                            @endif
                            @if($notification->user)
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $notification->user->name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($notification->images)
                        <div class="notification-images">
                            @php
                                $images = explode(',', $notification->images);
                            @endphp
                            
                            @if(count($images) == 1)
                                <div class="single-image">
                                    <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $notification->title }}" class="img-fluid rounded">
                                </div>
                            @else
                                <div id="notificationCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach($images as $index => $image)
                                            <button type="button" data-bs-target="#notificationCarousel" data-bs-slide-to="{{ $index }}" 
                                                class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}"></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach($images as $index => $image)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset('storage/' . trim($image)) }}" class="d-block w-100 rounded" alt="Image {{ $index + 1 }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#notificationCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#notificationCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="notification-content">
                        {!! nl2br(e($notification->content)) !!}
                    </div>

                    <div class="share-section">
                        <h5>Chia sẻ thông báo:</h5>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($notification->title) }}" 
                               target="_blank" class="btn btn-twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="mailto:?subject={{ urlencode($notification->title) }}&body={{ urlencode(request()->url()) }}" 
                               class="btn btn-email">
                                <i class="far fa-envelope"></i> Email
                            </a>
                            <button onclick="copyToClipboard('{{ request()->url() }}')" class="btn btn-copy">
                                <i class="far fa-copy"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Related Notifications -->
                @if($related_notifications->count() > 0)
                    <div class="related-section">
                        <h3 class="related-title">Thông báo liên quan</h3>
                        <div class="row">
                            @foreach($related_notifications as $related)
                                <div class="col-md-6 mb-3">
                                    <div class="related-card">
                                        <div class="related-image">
                                            @if($related->images)
                                                @php
                                                    $relatedImages = explode(',', $related->images);
                                                @endphp
                                                {{-- <img src="{{ asset('storage/' . trim($relatedImages[0])) }}" alt="{{ $related->title }}" class="img-fluid"> --}}
                                            {{-- @else
                                                <img src="{{ asset('images/placeholder-notification.jpg') }}" alt="Placeholder" class="img-fluid"> --}}
                                            @endif
                                            @if($related->category)
                                                <div class="category-badge text-success text-border">{{ $related->category->name }}</div>
                                            @endif
                                        </div>
                                        <div class="related-card-body mt-1">
                                            <h5 class="related-card-title">
                                                <a href="{{ route('notification.show', $related->id) }}">{{ Str::limit($related->title, 60) }}</a>
                                            </h5>
                                            <div class="related-card-meta">
                                                <span class="related-date">
                                                    <i class="far fa-calendar-alt"></i> {{ $related->created_at->format('d/m/Y') }}
                                                </span>
                                                @if($related->user->managedDepartment)
                                                    <span class="related-author">
                                                        <i class="fas fa-user" data-bs-title="{{ $related->user->managedDepartment->name }}"></i> {{ $related->user->managedDepartment->name }}
                                                    </span>
                                                @elseif($related->user->name)
                                                    <span class="related-author">
                                                        <i class="fas fa-user" data-bs-title="{{ $related->user->name }}"></i> {{ $related->user->name }} 
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="related-excerpt">
                                                {{ Str::limit(strip_tags($related->content), 80) }}
                                            </p>
                                            <a href="{{ route('notification.show', $related->id) }}" class="read-more-link">
                                                Xem chi tiết <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Action Buttons -->
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Hành động</h3>
                    <div class="action-buttons">
                        <a href="{{ route('notification.index') }}" class="btn btn-outline-primary btn-block mb-2">
                            <i class="fas fa-list me-2"></i>Danh sách thông báo
                        </a>
                        @if($notification->category)
                            <a href="{{ route('notification.category', $notification->category->id) }}" class="btn btn-outline-secondary btn-block mb-2">
                                <i class="fas fa-folder me-2"></i>{{ $notification->category->name }}
                            </a>
                        @endif
                        {{-- <button onclick="window.print()" class="btn btn-outline-dark btn-block">
                            <i class="fas fa-print me-2"></i>In thông báo
                        </button> --}}
                    </div>
                </div>

                <div class="sidebar-card">
                    <h3 class="sidebar-title">Danh mục thông báo</h3>
                    <ul class="categories-list">
                        <li><a href="{{ route('notification.index') }}">Tất cả <span class="badge">{{ App\Models\Notification::count() }}</span></a></li>
                        @foreach ($notification_categories as $category)
                            <li class="{{ $notification->category_id == $category->id ? 'active' : '' }}">
                                <a href="{{ route('notification.category', $category->id) }}">
                                    {{ $category->name }}
                                    <span class="badge">{{ $category->notifications->count() }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="sidebar-card">
                    <h3 class="sidebar-title">Thông báo gần đây</h3>
                    <ul class="recent-posts">
                        @foreach ($notification_latests as $latest)
                            <li class="recent-post-item">
                                <div class="recent-post-image">
                                    @if($latest->images)
                                        <img src="{{ asset('storage/' . $latest->images_array[0]) }}" alt="Recent">
                                    @else
                                        <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image">
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
.notification-detail {
    background: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.notification-detail-title {
    font-size: 32px;
    color: #333;
    margin-bottom: 20px;
    line-height: 1.4;
}

.notification-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
    margin-bottom: 30px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 14px;
}

.meta-item i {
    color: #007bff;
}

.meta-item a {
    color: #666;
    text-decoration: none;
}

.meta-item a:hover {
    color: #007bff;
}

.notification-images {
    margin-bottom: 30px;
}

.notification-images .carousel {
    max-height: 500px;
    overflow: hidden;
}

.notification-content {
    font-size: 16px;
    line-height: 1.8;
    color: #444;
    margin-bottom: 30px;
}

.share-section {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-top: 30px;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 15px;
}

.share-buttons .btn {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.related-section {
    margin-top: 50px;
}

.related-title {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.related-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 15px;
    height: 100%;
    transition: all 0.3s ease;
}

.related-card:hover {
    background: #e9ecef;
}

.related-card-title {
    font-size: 16px;
    margin-bottom: 10px;
}

.related-card-title a {
    color: #333;
    text-decoration: none;
}

.related-card-title a:hover {
    color: #007bff;
}

.related-card-date {
    font-size: 13px;
    color: #666;
    margin: 0;
}

.action-buttons .btn-block {
    width: 100%;
    text-align: left;
}

@media print {
    .sidebar-card, .share-section, .related-section, .page-title {
        display: none;
    }
}
</style>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link đã được sao chép!');
    }, function(err) {
        console.error('Không thể sao chép: ', err);
    });
}
</script>

@endsection