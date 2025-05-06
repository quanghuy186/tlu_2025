@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Quản lý danh mục diễn đàn</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item">Quản lý</li>
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
                                <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.forum.categories.index') }}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body mt-5">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="mb-4">
                                    <h6 class="fw-bold">Thông tin danh mục</h6>
                                    <hr>
                                    <table class="table">
                                        <tr>
                                            <th style="width: 200px;">ID</th>
                                            <td>{{ $category->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Tên danh mục</th>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mô tả</th>
                                            <td>{{ $category->description ?? 'Không có mô tả' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Ngày tạo</th>
                                            <td>{{ $category->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Cập nhật lần cuối</th>
                                            <td>{{ $category->updated_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card border shadow-sm h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Thống kê</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Ví dụ thống kê, có thể điều chỉnh -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Tổng số chủ đề:</span>
                                            <span class="badge bg-primary">{{ $category->topics_count ?? 0 }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>Tổng số bài viết:</span>
                                            <span class="badge bg-success">{{ $category->posts_count ?? 0 }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Bài viết mới nhất:</span>
                                            <span class="badge bg-info">{{ $category->latest_post_date ?? 'Chưa có' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Phần hiển thị các chủ đề thuộc danh mục -->
                        <div class="mt-4">
                            <h6 class="fw-bold">Chủ đề thuộc danh mục này</h6>
                            <hr>
                            
                            @if(isset($category->topics) && $category->topics->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tiêu đề</th>
                                                <th>Tác giả</th>
                                                <th>Trả lời</th>
                                                <th>Lượt xem</th>
                                                <th>Ngày tạo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->topics as $topic)
                                            <tr>
                                                <td>{{ $topic->title }}</td>
                                                <td>{{ $topic->user->name ?? 'Không xác định' }}</td>
                                                <td>{{ $topic->replies_count ?? 0 }}</td>
                                                <td>{{ $topic->views ?? 0 }}</td>
                                                <td>{{ $topic->created_at->format('d/m/Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    Chưa có chủ đề nào thuộc danh mục này
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection