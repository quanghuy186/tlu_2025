@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý bài viết diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.posts.index') }}">Bài viết diễn đàn</a></li>
        <li class="breadcrumb-item active">Chi tiết bài viết</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chi tiết bài viết</h5>
                        <div class="d-flex gap-2">
                            {{-- @if(auth()->id() == $post->user_id || auth()->user()->hasRole('admin')) --}}
                                <a href="{{ route('admin.forum.posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                                </a>
                            {{-- @endif --}}
                            
                            {{-- @if(auth()->user()->hasRole('admin')) --}}
                                @if($post->isPending())
                                    <a href="{{ route('admin.forum.posts.approve', $post->id) }}" 
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Bạn có chắc chắn muốn phê duyệt bài viết này?')">
                                        <i class="bi bi-check-circle me-1"></i> Phê duyệt
                                    </a>
                                    
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="bi bi-x-circle me-1"></i> Từ chối
                                    </button>
                                @endif
                                
                                <button type="button" class="btn btn-{{ $post->is_pinned ? 'warning' : 'outline-warning' }} btn-sm" 
                                    onclick="window.location.href='{{ route('admin.forum.posts.toggle-pin', $post->id) }}'">
                                    <i class="bi bi-pin-angle{{ $post->is_pinned ? '-fill' : '' }} me-1"></i> 
                                    {{ $post->is_pinned ? 'Bỏ ghim' : 'Ghim' }}
                                </button>
                                
                                <button type="button" class="btn btn-{{ $post->is_locked ? 'secondary' : 'outline-secondary' }} btn-sm" 
                                    onclick="window.location.href='{{ route('admin.forum.posts.toggle-lock', $post->id) }}'">
                                    <i class="bi bi-lock{{ $post->is_locked ? '-fill' : '' }} me-1"></i> 
                                    {{ $post->is_locked ? 'Mở khóa' : 'Khóa' }}
                                </button>
                            {{-- @endif --}}
                            
                            <a href="{{ route('admin.forum.posts.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="post-header mb-4">
                            <h2 class="mb-3">{{ $post->title }}</h2>
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-{{ $post->status == 'pending' ? 'warning' : ($post->status == 'approved' ? 'success' : 'danger') }} me-2">
                                        {{ $post->status == 'pending' ? 'Chờ duyệt' : ($post->status == 'approved' ? 'Đã duyệt' : 'Đã từ chối') }}
                                    </span>
                                    
                                    @if($post->category)
                                        <span class="badge bg-info me-2">{{ $post->category->name }}</span>
                                    @endif
                                    
                                    @if($post->is_pinned)
                                        <span class="badge bg-warning me-2" title="Đã ghim">
                                            <i class="bi bi-pin-angle-fill"></i> Ghim
                                        </span>
                                    @endif
                                    
                                    @if($post->is_locked)
                                        <span class="badge bg-secondary me-2" title="Đã khóa">
                                            <i class="bi bi-lock-fill"></i> Khóa
                                        </span>
                                    @endif
                                    
                                    {{-- @if($post->is_anonymous && !auth()->user()->hasRole('admin')) --}}
                                        <span class="badge bg-dark me-2" title="Ẩn danh">
                                            <i class="bi bi-incognito"></i> Ẩn danh
                                        </span>
                                    {{-- @endif --}}
                                </div>
                                
                                <div class="text-muted small">
                                    <span><i class="bi bi-eye me-1"></i> {{ $post->view_count }} lượt xem</span>
                                    <span class="ms-3"><i class="bi bi-calendar me-1"></i> {{ $post->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        @if($post->isRejected() && $post->reject_reason)
                            <div class="alert alert-danger mb-4">
                                <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Lý do từ chối:</h6>
                                <p class="mb-0">{{ $post->reject_reason }}</p>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Nội dung bài viết -->
                                <div class="post-content mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Nội dung bài viết</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="post-text mb-4">
                                                {!! nl2br(e($post->content)) !!}
                                            </div>
                                            
                                            @if(!empty($post->images_array))
                                                <div class="post-images mt-4">
                                                    <h6 class="fw-bold mb-3">Hình ảnh đính kèm:</h6>
                                                    <div class="row g-3">
                                                        @foreach($post->images_array as $image)
                                                            <div class="col-md-4 col-6">
                                                                <a href="{{ asset('storage/' . $image) }}" target="_blank" data-lightbox="post-images">
                                                                    <img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" alt="Hình ảnh bài viết">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Thông tin bài viết -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Thông tin bài viết</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-sm">
                                            <tr>
                                                <th>ID:</th>
                                                <td>{{ $post->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tác giả:</th>
                                                <td>
                                                    {{-- @if($post->is_anonymous && !auth()->user()->hasRole('admin')) --}}
                                                        <span class="text-muted">Ẩn danh</span>
                                                    {{-- @else
                                                        {{ $post->author->name ?? 'Không xác định' }}
                                                    @endif --}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Danh mục:</th>
                                                <td>{{ $post->category->name ?? 'Không có' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ngày tạo:</th>
                                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cập nhật:</th>
                                                <td>{{ $post->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Trạng thái:</th>
                                                <td>
                                                    <span class="badge bg-{{ $post->status == 'pending' ? 'warning' : ($post->status == 'approved' ? 'success' : 'danger') }}">
                                                        {{ $post->status == 'pending' ? 'Chờ duyệt' : ($post->status == 'approved' ? 'Đã duyệt' : 'Đã từ chối') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if($post->isApproved())
                                                <tr>
                                                    <th>Người duyệt:</th>
                                                    <td>{{ $post->approver->name ?? 'Không xác định' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Ngày duyệt:</th>
                                                    <td>{{ $post->approved_at ? $post->approved_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Lượt xem:</th>
                                                <td>{{ $post->view_count }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ghim:</th>
                                                <td>{{ $post->is_pinned ? 'Có' : 'Không' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Khóa:</th>
                                                <td>{{ $post->is_locked ? 'Có' : 'Không' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Ẩn danh:</th>
                                                <td>{{ $post->is_anonymous ? 'Có' : 'Không' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Xác nhận từ chối bài viết -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Từ chối bài viết</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.forum.posts.reject', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reject_reason" class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reject_reason" name="reject_reason" rows="4" required></textarea>
                        <small class="text-muted">Lý do từ chối sẽ được hiển thị cho tác giả bài viết</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Từ chối bài viết</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lightbox for images (if you use lightbox)
        // lightbox.option({
        //     'resizeDuration': 200,
        //     'wrapAround': true
        // });
    });
</script>
@endsection