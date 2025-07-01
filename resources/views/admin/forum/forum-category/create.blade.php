@extends('layouts/admin')

@section('title')
   Quản lý danh mục diễn đàn
@endsection

@section('content')
<div class="pagetitle">
    <h1>Thêm danh mục diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.categories.index') }}">Danh mục diễn đàn</a></li>
        <li class="breadcrumb-item active">Thêm danh mục</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title m-0 fw-bold text-primary">Thêm danh mục diễn đàn mới</h5>
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
                        
                        <form method="POST" action="{{ route('admin.forum.categories.store') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                <div class="form-text">Tên danh mục sẽ được hiển thị cho người dùng.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Danh mục cha</label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="">-- Không có danh mục cha --</option>
                                    @foreach($parentCategories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Chọn danh mục cha nếu đây là danh mục con.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                <div class="form-text">Mô tả ngắn gọn về danh mục này.</div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Hiển thị danh mục</label>
                                <div class="form-text">Nếu không chọn, danh mục sẽ bị ẩn và không hiển thị cho người dùng.</div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Lưu danh mục
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