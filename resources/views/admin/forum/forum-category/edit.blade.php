@extends('layouts/admin')

@section('title')
   Chỉnh sửa danh mục bài viết diễn đàn
@endsection

@section('content')
<div class="pagetitle">
    <h1>Chỉnh sửa danh mục diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.categories.index') }}">Danh mục diễn đàn</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa danh mục</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Cập nhật danh mục: {{ $category->name }}</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('admin.forum.categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                <div class="form-text">Tên danh mục sẽ được hiển thị cho người dùng.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control" id="slug" value="{{ $category->slug }}" disabled readonly>
                                <div class="form-text">Slug sẽ tự động được tạo từ tên danh mục khi cập nhật.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Danh mục cha</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">-- Không có danh mục cha --</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ (old('parent_id', $category->parent_id) == $parent->id) ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Chọn danh mục cha nếu đây là danh mục con.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                                <div class="form-text">Mô tả ngắn gọn về danh mục này.</div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Hiển thị danh mục</label>
                                <div class="form-text">Nếu không chọn, danh mục sẽ bị ẩn và không hiển thị cho người dùng.</div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Cập nhật danh mục
                                </button>
                                <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-1"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tự động cập nhật trường slug khi người dùng nhập tên danh mục
        const nameInput = document.getElementById('name');
        const slugDisplay = document.getElementById('slug');
        
        function generateSlug() {
            if (!nameInput || !slugDisplay) return;
            
            let slug = nameInput.value;
            
            // Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            
            // Chuyển sang chữ thường
            slug = slug.toLowerCase();
            
            // Xóa các ký tự đặc biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            
            // Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, '-');
            
            // Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            
            // Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            
            // Hiển thị slug
            slugDisplay.value = slug;
        }
        
        if (nameInput && slugDisplay) {
            // Cập nhật slug khi người dùng nhập
            nameInput.addEventListener('input', generateSlug);
            nameInput.addEventListener('blur', generateSlug);
            
            // Tạo slug ngay khi tải trang (cho trường hợp edit)
            generateSlug();
        }
    });
</script>

@endsection