@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Thông tin chi tiết đơn vị</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.department.index') }}">Quản lý đơn vị</a></li>
        <li class="breadcrumb-item active">Chi tiết đơn vị</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title m-0 fw-bold text-primary">{{ $department->name }}</h5>
                            <p class="text-muted small mb-0">Mã đơn vị: {{ $department->code }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.department.edit', $department->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.department.index') }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">Thông tin cơ bản</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Tên đơn vị:</span>
                                                <span>{{ $department->name }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Mã đơn vị:</span>
                                                <span class="badge bg-light text-dark">{{ $department->code }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Đơn vị cha:</span>
                                                <span>{{ $department->parent ? $department->parent->name : 'Không có' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Cấp bậc:</span>
                                                <span>{{ $department->level }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Ngày tạo:</span>
                                                <span>{{ $department->created_at->format('d/m/Y H:i') }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Cập nhật lần cuối:</span>
                                                <span>{{ $department->updated_at->format('d/m/Y H:i') }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">Thông tin quản lý</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($department->manager)
                                            <div class="text-center mb-3">
                                                @if($department->manager->avatar)
                                                    <img src="{{ asset('storage/avatars/' . $department->manager->avatar) }}" 
                                                        alt="{{ $department->manager->name }}" 
                                                        class="rounded-circle img-thumbnail mb-2"
                                                        style="width: 128px; height: 128px; object-fit: cover;">
                                                @else
                                                    <div class="mx-auto rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2"
                                                        style="width: 128px; height: 128px; font-size: 48px;">
                                                        {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <h5 class="mb-1">{{ $department->manager->name }}</h5>
                                                <p class="text-muted mb-0">Trưởng đơn vị</p>
                                            </div>
                                            
                                            <hr>
                                            
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    <span class="fw-bold">Email:</span>
                                                    <span>{{ $department->manager->email }}</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    <span class="fw-bold">Trạng thái tài khoản:</span>
                                                    @if($department->manager->is_active)
                                                        <span class="badge bg-success rounded-pill">Đang hoạt động</span>
                                                    @else
                                                        <span class="badge bg-danger rounded-pill">Ngừng hoạt động</span>
                                                    @endif
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                    <span class="fw-bold">Trạng thái xác thực:</span>
                                                    @if($department->manager->email_verified)
                                                        <span class="badge bg-success rounded-pill">Đã xác thực</span>
                                                    @else
                                                        <span class="badge bg-warning rounded-pill">Chưa xác thực</span>
                                                    @endif
                                                </li>
                                            </ul>
                                        @else
                                            <div class="text-center py-4">
                                                <div class="mb-3">
                                                    <i class="bi bi-person-x text-muted" style="font-size: 48px;"></i>
                                                </div>
                                                <p class="mb-0">Đơn vị này chưa có người quản lý.</p>
                                                <p class="mb-0">
                                                    <a href="{{ route('admin.department.edit', $department->id) }}" class="btn btn-sm btn-primary mt-2">
                                                        <i class="bi bi-person-plus-fill me-1"></i> Phân công người quản lý
                                                    </a>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">Thông tin liên hệ</h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Số điện thoại:</span>
                                                <span>{{ $department->phone ?: 'Chưa cập nhật' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Email:</span>
                                                <span>{{ $department->email ?: 'Chưa cập nhật' }}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                <span class="fw-bold">Địa chỉ:</span>
                                                <span>{{ $department->address ?: 'Chưa cập nhật' }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">Mô tả</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $department->description ?: 'Không có mô tả.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($department->children->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light">
                                        <h6 class="card-title mb-0">Đơn vị trực thuộc ({{ $department->children->count() }})</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Tên đơn vị</th>
                                                        <th>Mã đơn vị</th>
                                                        <th>Trưởng đơn vị</th>
                                                        <th class="text-center">Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($department->children as $child)
                                                    <tr>
                                                        <td>
                                                            <i class="bi bi-building text-secondary me-2"></i> {{ $child->name }}
                                                        </td>
                                                        <td><span class="badge bg-light text-dark">{{ $child->code }}</span></td>
                                                        <td>
                                                            @if($child->manager)
                                                                <div class="d-flex align-items-center">
                                                                    @if($child->manager->avatar)
                                                                        <img src="{{ asset('storage/avatars/'.$child->manager->avatar) }}" 
                                                                            alt="{{ $child->manager->name }}" 
                                                                            class="rounded-circle me-2"
                                                                            style="width: 32px; height: 32px; object-fit: cover;">
                                                                    @else
                                                                        <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                                            {{ strtoupper(substr($child->manager->name, 0, 1)) }}
                                                                        </span>
                                                                    @endif
                                                                    <span>{{ $child->manager->name }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-muted">Chưa phân công</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.department.detail', $child->id) }}" class="btn btn-sm btn-info">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection