<!-- resources/views/forum/category.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-container">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ route('forum.index') }}" class="text-decoration-none">Diễn đàn</a></li>
                @if($category->parent_id)
                    <li class="breadcrumb-item">
                        <a href="{{ route('forum.category', $category->parent->slug) }}" class="text-decoration-none">
                            {{ $category->parent->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-4">
    <div class="row">
        <!-- Main Content - Posts List -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0"><i class="fas fa-folder me-2"></i> {{ $category->name }}</h4>
                        @if($category->description)
                            <p class="text-muted mb-0 mt-1">{{ $category->description }}</p>
                        @endif
                    </div>
                    {{-- <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                            <i class="fas fa-plus-circle me-1"></i> Tạo bài viết mới
                        </button>
                    </div> --}}
                </div>
                
                <!-- Subcategories Display (if any) -->
                @if($category->childCategories && $category->childCategories->count() > 0)
                    <div class="card-body pb-0">
                        <h5 class="mb-3">Chuyên mục con</h5>
                        <div class="row row-cols-1 row-cols-md-2 g-3 mb-4">
                            @foreach($category->childCategories as $childCategory)
                                <div class="col">
                                    <div class="card h-100 subcategory-card">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <a href="{{ route('forum.category', $childCategory->slug) }}" class="text-decoration-none">
                                                    <i class="fas fa-folder me-2"></i> {{ $childCategory->name }}
                                                </a>
                                            </h6>
                                            @if($childCategory->description)
                                                <p class="card-text small text-muted">{{ Str::limit($childCategory->description, 100) }}</p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <small class="text-muted">
                                                    <i class="far fa-file-alt me-1"></i> {{ $childCategory->posts->count() }} bài viết
                                                </small>
                                                <a href="{{ route('forum.category', $childCategory->slug) }}" class="btn btn-sm btn-outline-primary">
                                                    Xem <i class="fas fa-angle-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Posts List -->
                <div class="card-body">
                    
                    <!-- Posts Filter & Sorting -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-3">Bài viết</h5>
                        
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sort me-1"></i> Sắp xếp
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item active" href="#">Mới nhất</a></li>
                                <li><a class="dropdown-item" href="#">Nhiều lượt xem</a></li>
                                <li><a class="dropdown-item" href="#">Nhiều bình luận</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Cũ nhất</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    @if(count($posts) > 0)
                        <div class="posts-container">
                            @foreach($posts as $post)
                                <div class="post-preview mt-5">
                                    <div class="d-flex">
                                        <!-- Author Avatar -->
                                        <div class="me-3">
                                            @if($post->is_anonymous)
                                                <span class="avatar avatar-sm bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            @else
                                                @if($post->author->avatar)
                                                    <img src="{{ asset('storage/avatars/'.$post->author->avatar) }}" 
                                                        alt="{{ $post->author->name }}" class="rounded-circle" 
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <span class="avatar avatar-sm bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center">
                                                        <img src="{{ asset('user_default.jpg') }}" 
                                                        alt="" class="rounded-circle" 
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                        {{-- {{ strtoupper(substr($post->author->name, 0, 1)) }} --}}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        
                                        <!-- Post Content Preview -->
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="fw-bold mb-0">
                                                    <a href="{{ route('forum.post.show', $post->id) }}" class="text-decoration-none post-title">
                                                        {{ $post->title }}
                                                    </a>
                                                </h5>
                                                
                                                @if($post->created_at->isToday())
                                                    <span class="badge bg-success">Mới</span>
                                                @endif
                                            </div>
                                            
                                            <div class="d-flex post-meta text-muted mb-2">
                                                <small class="me-3">
                                                    <i class="fas fa-user me-1"></i> 
                                                    {{ $post->is_anonymous ? 'Ẩn danh' : $post->author->name }}
                                                </small>
                                                <small class="me-3">
                                                    <i class="far fa-clock me-1"></i> 
                                                    {{ $post->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            
                                            <p class="post-text mb-2">{{ Str::limit($post->content, 150) }}</p>
                                            
                                            <!-- Post Tags -->
                                            @if($post->tags && count($post->tags) > 0)
                                                <div class="post-tags mb-2">
                                                    @foreach($post->tags as $tag)
                                                        <a href="{{ route('forum.tag', $tag->slug) }}" class="badge bg-light text-dark text-decoration-none me-1">
                                                            #{{ $tag->name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="post-stats">
                                                    <span class="me-3"><i class="far fa-comment me-1"></i> {{ count($post->comments) }}</span>
                                                    <span><i class="far fa-eye me-1"></i> {{ $post->view_count }}</span>
                                                </div>
                                                
                                                <a href="{{ route('forum.post.show', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Đọc tiếp <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i> Chưa có bài viết nào trong chuyên mục này.
                            <button class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                <i class="fas fa-plus-circle me-1"></i> Tạo bài viết đầu tiên
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Category Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i> Thông tin chuyên mục
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $category->name }}</h5>
                    
                    @if($category->description)
                        <p class="card-text">{{ $category->description }}</p>
                    @endif
                    
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="far fa-file-alt me-1"></i> Tổng số bài viết</span>
                            <span class="badge bg-primary rounded-pill">{{ count($posts) }}</span>
                        </li>
                        
                        @if($category->childCategories && $category->childCategories->count() > 0)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-folder me-1"></i> Chuyên mục con</span>
                                <span class="badge bg-primary rounded-pill">{{ $category->childCategories->count() }}</span>
                            </li>
                        @endif
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="far fa-comment me-1"></i> Tổng số bình luận</span>
                            <span class="badge bg-primary rounded-pill">
                                {{ $posts->sum(function($post) { return count($post->comments); }) }}
                            </span>
                        </li>
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="far fa-clock me-1"></i> Bài viết mới nhất</span>
                            <span class="text-muted small">
                                {{ $posts->count() > 0 ? $posts->first()->created_at->diffForHumans() : 'Chưa có bài viết nào' }}
                            </span>
                        </li>
                    </ul>
                    
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createPostModal">
                            <i class="fas fa-plus-circle me-2"></i> Tạo bài viết mới
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Popular Tags -->
            @if(isset($popularTags) && count($popularTags) > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-tags me-2"></i> Thẻ phổ biến
                    </div>
                    <div class="card-body">
                        <div class="popular-tags">
                            @foreach($popularTags as $tag)
                                <a href="{{ route('forum.tag', $tag->slug) }}" class="badge bg-light text-dark text-decoration-none me-2 mb-2 p-2">
                                    #{{ $tag->name }} <span class="badge bg-secondary ms-1">{{ $tag->posts_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Other Categories -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-folder me-2"></i> Chuyên mục khác
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $otherCategory)
                        <a href="{{ route('forum.category', $otherCategory->slug) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center 
                                  {{ $otherCategory->id == $category->id ? 'active' : '' }}">
                            <span>{{ $otherCategory->name }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $otherCategory->posts->count() }}</span>
                        </a>
                        
                        @if($otherCategory->childCategories && count($otherCategory->childCategories) > 0)
                            @foreach($otherCategory->childCategories as $childCategory)
                                <a href="{{ route('forum.category', $childCategory->slug) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ps-4
                                          {{ $childCategory->id == $category->id ? 'active' : '' }}">
                                    <span><i class="fas fa-angle-right me-1"></i> {{ $childCategory->name }}</span>
                                    <span class="badge bg-secondary rounded-pill">{{ $childCategory->posts->count() }}</span>
                                </a>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>      
</div>

<!-- Modal: Create Post -->
@include('partials.create_post_modal')

@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle view switching (list/grid)
        const viewButtons = document.querySelectorAll('.btn-group .btn');
        const postsContainer = document.querySelector('.posts-container');
        
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.querySelector('.fa-th-large')) {
                    postsContainer.classList.add('posts-grid');
                } else {
                    postsContainer.classList.remove('posts-grid');
                }
            });
        });
        
        // Handle sorting dropdown
        document.querySelectorAll('#sortDropdown + .dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all items
                document.querySelectorAll('#sortDropdown + .dropdown-menu .dropdown-item').forEach(el => {
                    el.classList.remove('active');
                });
                
                // Add active class to clicked item
                this.classList.add('active');
                
                // Update dropdown button text
                document.querySelector('#sortDropdown').innerHTML = `<i class="fas fa-sort me-1"></i> ${this.textContent}`;
                
                // Here you would add logic to sort the posts based on the selected option
                // For example, you could reload the page with a sort parameter
                // window.location.href = `{{ route('forum.category', $category->slug) }}?sort=${sortOption}`;
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
/* Grid view for posts */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
}

.posts-grid .post-preview {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.posts-grid .post-preview .flex-grow-1 {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
}

/* Subcategory cards */
.subcategory-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.subcategory-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

/* Popular tags */
.popular-tags .badge {
    display: inline-block;
    font-size: 0.85rem;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    padding: 0.5rem 0.75rem;
    border-radius: 50px;
    transition: all 0.2s ease;
}

.popular-tags .badge:hover {
    background-color: #e9ecef;
}
</style>
@endsection