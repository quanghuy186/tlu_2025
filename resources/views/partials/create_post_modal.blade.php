<!-- resources/views/forum/partials/create_post_modal.blade.php -->

<div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Tạo bài viết mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newPostForm" action="{{ route('forum.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <label for="title" class="col-sm-2 col-form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
								<div class="text-danger alert alert-danger">{{ $errors->first('title') }}</div>
							@endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-2 col-form-label">Chuyên mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">-- Chọn chuyên mục --</option>
                                @foreach($categories as $parentCategory)
                                    <option value="{{ $parentCategory->id }}" {{ old('category_id') == $parentCategory->id ? 'selected' : '' }}
                                            {{ isset($category) && $category->id == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>
                                    
                                    @if($parentCategory->childCategories && count($parentCategory->childCategories) > 0)
                                        @foreach($parentCategory->childCategories as $childCategory)
                                            <option value="{{ $childCategory->id }}" {{ old('category_id') == $childCategory->id ? 'selected' : '' }}
                                                    {{ isset($category) && $category->id == $childCategory->id ? 'selected' : '' }}>
                                                — {{ $childCategory->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="content" class="col-sm-2 col-form-label">Nội dung <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="8">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Hỗ trợ định dạng Markdown</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="images" class="col-sm-2 col-form-label">Hình ảnh</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Có thể chọn nhiều hình ảnh (JPG, PNG, GIF - Tối đa 2MB/ảnh)</small>
                            
                            <div id="image_previews" class="row mt-3 d-none">
                            </div>
                        </div>
                    </div>

                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                {{-- <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}> --}}
                                <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    Đăng ẩn danh (người xem sẽ không thấy tên tác giả)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notify_replies" name="notify_replies" {{ old('notify_replies') ? 'checked' : '' }} checked>
                                <label class="form-check-label" for="notify_replies">
                                    Thông báo cho tôi khi có bình luận mới
                                </label>
                            </div>
                        </div>
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="submit" class="btn btn-success" id="submitPost">Đăng bài viết</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    const imagePreviewsContainer = document.getElementById('image_previews');
    
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            imagePreviewsContainer.innerHTML = '';
            
            if (this.files.length > 0) {
                imagePreviewsContainer.classList.remove('d-none');
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    
                    if (!file.type.match('image.*')) {
                        continue;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const colDiv = document.createElement('div');
                        colDiv.className = 'col-md-3 mb-2';
                        
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'rounded border p-1';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid rounded';
                        img.alt = 'Image Preview';
                        
                        imgDiv.appendChild(img);
                        colDiv.appendChild(imgDiv);
                        imagePreviewsContainer.appendChild(colDiv);
                    };
                    
                    reader.readAsDataURL(file);
                }
            } else {
                imagePreviewsContainer.classList.add('d-none');
            }
        });
    }
    
    const submitButton = document.getElementById('submitPost');
    const postForm = document.getElementById('newPostForm');
    
    if (submitButton && postForm) {
        submitButton.addEventListener('click', function() {
            if (postForm.checkValidity()) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Đang đăng...';
                
                postForm.submit();
            } else {
                postForm.reportValidity();
            }
        });
    }
});
</script>   