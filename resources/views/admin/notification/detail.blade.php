@extends('layouts/admin')

@section('title')
   Xem chi tiết thông tin thông báo
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chi tiết thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">Thông báo</a></li>
        <li class="breadcrumb-item active">Chi tiết</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chi tiết thông báo</h5>
                        <div>
                             <button type="button" class="btn btn-{{ $notification->is_pinned ? 'warning' : 'outline-warning' }} btn-sm" 
                                    onclick="window.location.href='{{ route('admin.notification.toggle-pin', $notification->id) }}'">
                                    <i class="bi bi-pin-angle{{ $notification->is_pinned ? '-fill' : '' }} me-1"></i> 
                                    {{ $notification->is_pinned ? 'Bỏ ghim' : 'Ghim' }}
                                </button>
                            <a href="{{ route('admin.notification.edit', $notification->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.notification.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4 class="text-primary">{{ $notification->title }}</h4>
                                <div class="d-flex flex-wrap gap-3 text-muted small mb-3">
                                    <div>
                                        <i class="bi bi-person me-1"></i>Người tạo: <strong>{{ $notification->user->name }}</strong>
                                    </div>
                                    <div>
                                        <i class="bi bi-calendar3 me-1"></i>Ngày tạo: <strong>{{ $notification->created_at->format('d/m/Y H:i') }}</strong>
                                    </div>
                                    @if($notification->category)
                                    <div>
                                        <i class="bi bi-tag me-1"></i>Danh mục: <strong>{{ $notification->category->name }}</strong>
                                    </div>
                                    @endif
                                </div>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Nội dung thông báo</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="notification-content">
                                            {!! $notification->content !!}
                                        </div>
                                    </div>
                                </div>

                                @if(count($notification->images_array) > 0)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Hình ảnh</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row" id="galleryContainer">
                                            @foreach($notification->images_array as $index => $image)
                                                <div class="col-md-3 col-sm-4 col-6 mb-3">
                                                    <div class="card h-100">
                                                        <a href="{{ asset('storage/' . $image) }}" target="_blank" class="image-popup" data-index="{{ $index }}">
                                                            <img src="{{ asset('storage/' . $image) }}" class="card-img-top" alt="Hình ảnh thông báo" style="height: 160px; object-fit: cover;">
                                                        </a>
                                                        <div class="card-body p-2">
                                                            <p class="card-text small text-truncate mb-0">
                                                                {{ basename($image) }}
                                                            </p>
                                                            <small class="text-muted">
                                                                <a href="{{ asset('storage/' . $image) }}" download class="text-decoration-none">
                                                                    <i class="bi bi-download"></i> Tải xuống
                                                                </a>
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal xem ảnh lớn -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Xem ảnh</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Hình ảnh thông báo">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" id="downloadImage" download>
                    <i class="bi bi-download"></i> Tải xuống
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý popup ảnh
        const imageLinks = document.querySelectorAll('.image-popup');
        const modalImage = document.getElementById('modalImage');
        const downloadLink = document.getElementById('downloadImage');
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        
        imageLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const imageSrc = this.getAttribute('href');
                modalImage.src = imageSrc;
                downloadLink.href = imageSrc;
                imageModal.show();
            });
        });
    });
</script>

@endsection