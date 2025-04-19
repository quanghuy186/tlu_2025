@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Gán vai trò người dùng</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active">General</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section py-4">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">Gán quyền cho người dùng</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.user_has_permission.create') }}" method="POST">
                @csrf
                <div class="mb-4">
                  <label for="userSelect" class="form-label fw-bold">Người dùng</label>
                    <h2>{{ $user->email }} - {{ $user->name }}</h2>
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                </div>

                <div class="mt-4 mb-4">
                  <h6 class="fw-bold mb-3">Danh sách các quyền</h6>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        @foreach ($list_permissions as $i => $permission)
                            @if (in_array($permission->id, $list_user_has_permissions))
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                    <input class="form-check-input" name="permission_id[]" type="checkbox" value="{{ $permission->id }}" id="permission_id_{{ $i }}" checked>
                                    <label class="form-check-label" for="permission_id_{{ $i }}">
                                        {{ $permission->description }}
                                    </label>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                    <input class="form-check-input" name="permission_id[]" type="checkbox" value="{{ $permission->id }}" id="permission_id_{{ $i }}">
                                    <label class="form-check-label" for="permission_id_{{ $i }}">
                                        {{ $permission->description }}
                                    </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                  </a>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Lưu lại
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


@endsection
