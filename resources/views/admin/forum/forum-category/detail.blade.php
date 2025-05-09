@extends('layouts/admin')

@section('content')
<div class="pagetitle">
    <h1>Chi tiết danh mục diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.forum.categories.index') }}">Danh mục diễn đàn</a></li>
        <li class="breadcrumb-item active">Chi tiết danh mục</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Chi tiết danh mục: {{ $category->name }}</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.forum.categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="200">ID</th>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $category->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục cha</th>
                                        <td>
                                            @if($category->parent)
                                                <a href="{{ route('admin.forum.categories.show', $category->parent->id) }}">
                                                    {{ $category->parent->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">Không có</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả</th>
                                        <td>{{ $category->description ?? 'Không có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái</th>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-danger">Ẩn</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục con</th>
                                        <td>
                                            @php
                                                $childCategories = \App\Models\ForumCategory::where('parent_id', $category->id)->get();
                                            @endphp
                                            
                                            @if($childCategories->count() > 0)
                                                <ul class="mb-0">
                                                    @foreach($childCategories as $child)
                                                        <li>
                                                            <a href="{{ route('admin.forum.categories.show', $child->id) }}">{{ $child->name }}
                                                            </a>
                                                            @if(!$child->is_active)
                                                                <span class="badge bg-danger ms-1">Ẩn</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-muted">Không có danh mục con</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo</th>
                                        <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật</th>
                                        <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection