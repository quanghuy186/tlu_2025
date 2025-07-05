@extends('layouts/admin')

@section('title')
   Tạo thông báo mới
@endsection

@section('content')

<div class="pagetitle">
    <h1>Thêm thông báo mới</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.notification.index') }}">Thông báo</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
      </ol>
    </nav>
</div>

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Thêm thông báo mới</h5>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('admin.notification.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="title" class="col-md-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="content" class="col-md-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                                <div class="col-md-10">
                                    <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="content" rows="6" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category_id" class="col-md-2 col-form-label">Danh mục</label>
                                <div class="col-md-10">
                                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach($categories as $id => $name)
                                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Chọn danh mục cho thông báo này</small>
                                        <a href="{{ route('admin.notification-category.create') }}" target="_blank" class="small">
                                            <i class="bi bi-plus-circle"></i> Thêm danh mục mới
                                        </a>
                                    </div>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="images" class="col-md-2 col-form-label">Hình ảnh</label>
                                <div class="col-md-10">
                                    <input class="form-control @error('images.*') is-invalid @enderror" type="file" id="images" name="images[]" multiple accept="image/*">
                                    <small class="text-muted">Bạn có thể chọn nhiều hình ảnh (JPG, PNG, GIF). Mỗi ảnh tối đa 2MB.</small>
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-3" id="imagePreviewContainer" style="display: none;">
                                        <h6>Xem trước:</h6>
                                        <div class="row" id="imagePreview"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-2">
                                    <button type="submit" class="btn btn-primary">Lưu thông báo</button>
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
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo']
            })
            .catch(error => {
                console.error(error);
            });
        
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const preview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            preview.innerHTML = '';
            previewContainer.style.display = 'none';
            
            if (this.files && this.files.length > 0) {
                previewContainer.style.display = 'block';
                
                Array.from(this.files).forEach(file => {
                    if (!file.type.match('image.*')) {
                        return;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-4 col-6 mb-3';
                        
                        const card = document.createElement('div');
                        card.className = 'card h-100';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'card-img-top';
                        img.style.height = '140px';
                        img.style.objectFit = 'cover';
                        
                        const cardBody = document.createElement('div');
                        cardBody.className = 'card-body p-2';
                        
                        const fileName = document.createElement('p');
                        fileName.className = 'card-text small text-truncate mb-0';
                        fileName.textContent = file.name;
                        
                        const fileSize = document.createElement('small');
                        fileSize.className = 'text-muted';
                        fileSize.textContent = formatFileSize(file.size);
                        
                        cardBody.appendChild(fileName);
                        cardBody.appendChild(fileSize);
                        card.appendChild(img);
                        card.appendChild(cardBody);
                        col.appendChild(card);
                        preview.appendChild(col);
                    };
                    
                    reader.readAsDataURL(file);
                });
            }
        });
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    });
</script>

@endsection