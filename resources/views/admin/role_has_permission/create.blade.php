@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>Cấp quyền cho vai trò người dùng</h1>
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
              <form action="{{ route('admin.role_has_permission.create') }}" method="POST" id="rolePermissionForm">
                @csrf
                <div class="mb-4">
                  <label for="role_id" class="form-label fw-bold">Vai trò</label>
                  <select class="form-select form-select-lg mb-3" name="role_id" id="role_id" aria-label="Chọn vai trò">
                    <option value="">-- Chọn vai trò --</option>
                    @foreach ($list_roles as $role)
                      <option value="{{ $role->id }}">{{ $role->roles_name }} - {{ $role->description }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mt-4 mb-4" id="permission_id">
                  <h6 class="fw-bold mb-3">Danh sách quyền</h6>
                  <div class="card">
                    <div class="card-body">
                      <div class="row" id="permissionsContainer">
                        @foreach ($list_permissions as $i => $permission)
                          <div class="col-md-6 mb-2">
                            <div class="form-check">
                              <input class="form-check-input" name="permission_id[]" type="checkbox" value="{{ $permission->id }}" id="permission_id_{{ $i }}">
                              <label class="form-check-label" for="permission_id_{{ $i }}">
                                {{ $permission->description }}
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

@section('custom-js')
<script>
$(function(){
    $('#role_id').on('change', function(){
        var role_id = $(this).val();
        var apiUrl = "{{ route('admin.api.role_has_permission.getRoleId') }}";
        apiUrl += '/' + role_id;

        $.ajax({
            method: 'GET',
            url: apiUrl,
            dataType: 'json'
        })
        .done(function(response){
            // debugger;
            var arrPermission = response.data;
            $("#permission_id input[type='checkbox']").each(function(){
                // var value = Number((this).val());
                var value = Number($(this).val());
                if(arrPermission.includes(value)){
                    $(this).prop('checked', true);
                }else{
                    $(this).prop('checked', false);
                }
            });
        });
    });
    $('#role_id').trigger('change');
});
</script>
@endsection