@extends('layouts/admin')

@section('content')

<div class="pagetitle">
    <h1>General Tables</h1>
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
              <h5 class="card-title">Table with stripped rows</h5>

              <!-- Table with stripped rows -->
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Họ và tên</th>
                    <th scope="col">Email</th>
                    <th scope="col">Trạng thái tài khoản</th>
                    <th scope="col">Chức vụ</th>
                    <th scope="col">Hành động</th>
                  </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->is_active == 1)
                                    <p class="text-success">
                                        Hoạt động
                                    </p>
                                @elseif ($user->is_active == 0)
                                    <p class="text-danger">
                                        Chưa kích hoạt
                                    </p>
                                @endif
                            </td>
                            <td>2016-05-25</td>
                            <td>2016-05-25</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
      </div>
    </div>
  </section>


@endsection
