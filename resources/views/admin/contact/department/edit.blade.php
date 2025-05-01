@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Chỉnh sửa đơn vị</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.department.index') }}">Quản lý đơn vị</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa đơn vị</li>
      </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title m-0 fw-bold text-primary">Thông tin đơn vị</h5>
                        <span class="badge bg-info px-3">Mã: {{ $department->code }}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.department.update', $department->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Thông tin đơn vị</h6>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Tên đơn vị <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $department->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="code" class="form-label">Mã đơn vị <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                        id="code" name="code" value="{{ old('code', $department->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="parent_id" class="form-label">Đơn vị cha</label>
                                    <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                                        <option value="">-- Không có đơn vị cha --</option>
                                        @foreach($departmentOptions as $id => $name)
                                            <option value="{{ $id }}" {{ old('parent_id', $department->parent_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone', $department->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email đơn vị</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email', $department->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                        id="address" name="address" value="{{ old('address', $department->address) }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Mô tả</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3">{{ old('description', $department->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4 mt-5">
                                <h6 class="fw-bold text-primary border-bottom pb-2">Thông tin tài khoản quản lý đơn vị</h6>
                                @if($department->manager)
                                    <p class="small text-muted">Đơn vị này đang được quản lý bởi tài khoản có thông tin dưới đây</p>
                                @else
                                    <p class="small text-muted">Hệ thống sẽ tự động tạo tài khoản quản lý mới cho đơn vị này</p>
                                @endif
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="manager_name" class="form-label">Họ tên người quản lý <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('manager_name') is-invalid @enderror" 
                                        id="manager_name" name="manager_name" 
                                        value="{{ old('manager_name', $department->manager ? $department->manager->name : '') }}" required>
                                    @error('manager_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="manager_email" class="form-label">Email người quản lý <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('manager_email') is-invalid @enderror" 
                                        id="manager_email" name="manager_email" 
                                        value="{{ old('manager_email', $department->manager ? $department->manager->email : '') }}" required>
                                    <div class="form-text">
                                        Email này sẽ được dùng làm tên đăng nhập cho tài khoản quản lý.
                                        @if($department->manager)
                                            <span class="text-warning">Nếu bạn thay đổi email, mật khẩu tài khoản này sẽ được đặt lại.</span>
                                        @endif
                                    </div>
                                    @error('manager_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="manager_avatar" class="form-label">Ảnh đại diện</label>
                                
                                @if($department->manager && $department->manager->avatar)
                                    <div class="mb-2">
                                        <p class="mb-2">Ảnh hiện tại:</p>
                                        <img src="{{ asset('storage/avatars/' . $department->manager->avatar) }}" 
                                            alt="{{ $department->manager->name }}" 
                                            class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                @endif
                                
                                <input type="file" class="form-control @error('manager_avatar') is-invalid @enderror" 
                                    id="manager_avatar" name="manager_avatar" accept="image/*">
                                <div class="form-text">Chấp nhận định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB. Upload ảnh mới sẽ thay thế ảnh hiện tại.</div>
                                @error('manager_avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                <div class="mt-3" id="avatar-preview-container" style="display: none;">
                                    <p class="mb-2">Xem trước ảnh mới:</p>
                                    <div class="border rounded p-2 d-inline-block">
                                        <img src="" id="avatar-preview" style="max-width: 150px; max-height: 150px;" class="img-thumbnail">
                                    </div>
                                </div>
                            </div>
                            
                            @if(!$department->manager)
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle-fill me-2"></i> Mật khẩu tạm thời sẽ được tạo tự động và hiển thị sau khi cập nhật đơn vị thành công.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Nếu bạn thay đổi email người quản lý, hệ thống sẽ tạo mật khẩu mới và hiển thị sau khi cập nhật.
                                </div>
                            @endif
                            
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.department.index') }}" class="btn btn-secondary">Hủy</a>
                                <button type="submit" class="btn btn-primary">Cập nhật đơn vị</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xem trước ảnh đại diện
        const avatarInput = document.getElementById('manager_avatar');
        const avatarPreview = document.getElementById('avatar-preview');
        const previewContainer = document.getElementById('avatar-preview-container');
        
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            } else {
                previewContainer.style.display = 'none';
            }
        });
    });
</script>
@endsection