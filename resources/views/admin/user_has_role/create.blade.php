@extends('layouts/admin')

@section('title')
   Gán vai trò cho người dùng
@endsection

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
              <h5 class="card-title mb-0">Gán vai trò cho người dùng</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.user_has_role.create') }}" method="POST">
                @csrf
                <div class="mb-4">
                  <label for="userSelect" class="form-label fw-bold">Người dùng</label>
                  <select class="form-select form-select-lg mb-3" name="user_id" id="userSelect" aria-label="Chọn người dùng">
                    <option selected disabled>-- Chọn người dùng --</option>
                    @foreach ($list_users as $user)
                      <option value="{{ $user->id }}">{{ $user->email }} - {{ $user->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mt-4 mb-4">
                  <h6 class="fw-bold mb-3">Danh sách vai trò</h6>
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        @foreach ($list_roles as $i => $role)
                          <div class="col-md-6 mb-2">
                            <div class="form-check">
                              <input class="form-check-input" name="role_id[]" type="checkbox" value="{{ $role->id }}" id="role_id_{{ $i }}">
                              <label class="form-check-label" for="role_id_{{ $i }}">
                                {{ $role->description }}
                              </label>
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                  <a href="#" class="btn btn-outline-secondary">
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
