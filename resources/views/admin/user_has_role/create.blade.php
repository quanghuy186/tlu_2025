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

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Gán vai trò cho người dùng</h5>
                <div class="mb-3">
                    <label for="" class="form-label">Người dùng</label>
                    <select
                        class="form-select form-select-lg"
                        name=""
                        id=""
                    >
                        @foreach ($list_users as $user)
                        <option value="">{{ $user->email }} - {{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                @foreach ($list_roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="" />
                        <label class="form-check-label" for=""> {{ $role->description }} </label>
                    </div>
                @endforeach

               <a
                name=""
                id=""
                class="btn btn-primary mt-3"
                href="#"
                role="button"
                >Lưu lại</a
               >

               <a
               name=""
               id=""
               class="btn btn-primary mt-3"
               href="#"
               role="button"
               >Quay lại</a
              >


            </div>
          </div>
      </div>
    </div>
  </section>


@endsection
