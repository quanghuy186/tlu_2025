@extends('layouts/admin')

@section('title')
   Xem chi tiết thông tin người dùng
@endsection

@section('content')

<div class="pagetitle">
    <h1>Chi tiết tài khoản</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Quản lý tài khoản</a></li>
        <li class="breadcrumb-item active">Chi tiết tài khoản</li>
      </ol>
    </nav>
</div>

<section class="section py-4">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title m-0 fw-bold text-primary">Thông tin tài khoản</h5>
            <div>
              <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Quay lại
              </a>
              <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary btn-sm ms-1">
                <i class="bi bi-pencil-square me-1"></i>Chỉnh sửa
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Thông tin cá nhân</h5>
                  </div>
                  <div class="card-body">
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Họ và tên:</label>
                      <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $user->name }}</p>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Email:</label>
                      <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $user->email }}</p>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Ngày tạo:</label>
                      <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Cập nhật lần cuối:</label>
                      <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $user->updated_at->format('d/m/Y H:i:s') }}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-shield-check me-2"></i>Trạng thái tài khoản</h5>
                  </div>
                  <div class="card-body">
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Trạng thái kích hoạt:</label>
                      <div class="col-sm-8">
                        @if ($user->email_verified == 1)
                        <span class="badge bg-success rounded-pill px-3">Đã kích hoạt</span>
                        @elseif ($user->email_verified == 0)
                        <span class="badge bg-danger rounded-pill px-3">Chưa kích hoạt</span>
                        @endif
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Trạng thái hoạt động:</label>
                      <div class="col-sm-8">
                        @if ($user->is_active == 1)
                        <span class="badge bg-success rounded-pill px-3">Hoạt động</span>
                        @elseif ($user->is_active == 0)
                        <span class="badge bg-danger rounded-pill px-3">Ngừng hoạt động</span>
                        @endif
                      </div>
                    </div>
                    <div class="mb-3 row">
                      <label class="col-sm-4 col-form-label fw-bold">Lần đăng nhập cuối:</label>
                      <div class="col-sm-8">
                        <p class="form-control-plaintext">
                          @if ($user->last_login_at)
                            {{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i:s') }}
                          @else
                            Chưa có thông tin
                          @endif
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i>Vai trò</h5>
                    <a href="{{ route('admin.user_has_role.create_with_user', $user->id) }}" class="btn btn-info btn-sm">
                      <i class="bi bi-pencil-square me-1"></i>Phân vai trò
                    </a>
                  </div>
                  <div class="card-body">
                    @if($roles->count() > 0)
                      <ul class="list-group list-group-flush">
                        @foreach($roles as $role)
                          <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $role->name }}
                            <span class="badge bg-primary rounded-pill">{{ $role->description ?? 'Không có mô tả' }}</span>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <p class="text-muted text-center py-3">Người dùng chưa được phân vai trò</p>
                    @endif
                  </div>
                </div>
              </div>
              
              <div class="col-md-6">
                <div class="card mb-4">
                  <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-key me-2"></i>Quyền hạn</h5>
                    <a href="{{ route('admin.user_has_permission.create_with_user', $user->id) }}" class="btn btn-warning btn-sm">
                      <i class="bi bi-pencil-square me-1"></i>Phân quyền
                    </a>
                  </div>
                  <div class="card-body">
                    @if($permissions->count() > 0)
                      <div class="table-responsive">
                        <table class="table table-sm table-hover">
                          <thead>
                            <tr>
                              <th>Tên quyền</th>
                              <th>Mô tả</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($permissions as $permission)
                              <tr>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description ?? 'Không có mô tả' }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    @else
                      <p class="text-muted text-center py-3">Người dùng chưa được phân quyền trực tiếp</p>
                    @endif
                  </div>
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-activity me-2"></i>Lịch sử hoạt động gần đây</h5>
                  </div>
                  <div class="card-body">
                    <p class="text-muted text-center py-3">Chưa có dữ liệu hoạt động</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
