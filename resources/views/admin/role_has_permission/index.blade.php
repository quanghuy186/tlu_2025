@extends('layouts/admin')

@section('title')
   Cấp quyền cho vai trò
@endsection

@section('content')

<div class="pagetitle">
    <h1>Cấp quyền cho vai trò</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="">Người dùng</a></li>
        <li class="breadcrumb-item active">Cấp quyền cho vai trò</li>
      </ol>
    </nav>
</div>

  <section class="section py-4">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
              <h5 class="card-title m-0 fw-bold text-primary">Danh sách quyền</h5>
              <a href="{{ route('admin.role_has_permission.create') }}" class="btn btn-success btn-sm d-flex align-items-center">
                <i class="bi bi-plus-circle me-2"></i>Cấp quyền cho vai trò
              </a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <!-- <th class="text-center" width="5%">ID</th>  -->
                      <th>Tên vai trò</th>
                      <th>Tên quyền</th>
                      <th class="text-center" width="15%">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($grouped_role_has_permission as $key => $grhp)
                    <?php
                      $role_id = $grhp->first()->role_id;
                    ?>
                    <tr>
                      <td class="fw-bold">{{ $key }}</td>
                      <td>
                        @foreach ($grhp as $rhp)
                          <ul>
                            <li>{{ $rhp->permission->description }}</li>
                          </ul>
                        @endforeach
                      </td>
                      <td>
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('admin.role_has_permission.create', ['role_id' => $role_id]) }}" data-bs-toggle="tooltip" data-bs-title="Chỉnh sửa" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                          </a>
                          <!-- <a href="#" data-bs-toggle="tooltip" data-bs-title="Xem chi tiết" class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye-fill"></i>
                          </a> -->
                          <a href="#" data-bs-toggle="tooltip" data-bs-title="Xóa" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash-fill"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer bg-white py-3">
              <!-- Có thể thêm phân trang ở đây -->
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Trước</a>
                  </li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Sau</a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection
