@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa thông báo</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">Thông báo</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Chỉnh sửa thông báo</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.notification.update', $notification->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label for="title" class="col-md-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $notification->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="content" class="col-md-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="content" rows="6" required>{{ old('content', $notification->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category" class="col-md-2 col-form-label">Danh mục</label>
                                <div class="col-md-10">
                                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category_id">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $key => $value)
                                            <option value="{{ $key }}" {{ old('category', $notification->category) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Existing Images Display and Remove Option -->
                            @if(count($notification->images_array) > 0)
                                <div class="row mb-3">
                                    <label class="col-md-2 col-form-label">Hình ảnh hiện tại</label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            @foreach($notification->images_array as $image)
                                                <div class="col-md-2 mb-3">
                                                    <div class="card h-100">
                                                        <img src="{{ asset('storage/' . $image) }}" class="card-img-top" alt="Hình ảnh thông báo" style="height: 100px; object-fit: cover;">
                                                        <div class="card-body p-2 text-center">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="{{ $image }}" id="remove_image_{{ $loop->index }}" name="remove_images[]">
                                                                <label class="form-check-label" for="remove_image_{{ $loop->index }}">
                                                                    Xóa
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-text text-muted">Chọn các hình ảnh bạn muốn xóa</div>
                                    </div>
                                </div>
                            @endif

                            <!-- Upload New Images -->
                            <div class="row mb-3">
                                <label for="images" class="col-md-2 col-form-label">Thêm hình ảnh mới</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('images.*') is-invalid @enderror" type="file" id="images" name="images[]" multiple accept="image/*">
                                    <small class="text-muted">Bạn có thể chọn nhiều hình ảnh (JPG, PNG, GIF). Mỗi ảnh tối đa 2MB.</small>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-2" id="imagePreviewContainer" style="display: none;">
                                        <h6>Xem trước:</h6>
                                        <div class="row" id="imagePreview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-primary">Cập nhật thông báo</button>
                                    <a href="{{ route('admin.notification.index') }}" class="btn btn-secondary">Hủy</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
        
        // Image preview functionality
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            preview.innerHTML = '';
            previewContainer.style.display = 'none';
            
            if (this.files && this.files.length > 0) {
                previewContainer.style.display = 'block';
                
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-2 mb-2';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        
                        col.appendChild(img);
                        preview.appendChild(col);
                    }
                    
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>

@endsection