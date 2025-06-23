<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Quản trị hệ thống</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

    <link href="{{ asset('assets/admin/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/admin/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <!-- toastr.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- toastr.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
      :root {
        --primary-color: #005baa;
        --secondary-color: #00a8e8;
        --accent-color: #ff5722;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --text-color: #333;
        --bg-color: #f5f7fa;
        --border-color: #e9ecef;
    }
      .pagination {
        margin-top: 20px;
        margin-bottom: 40px;
        justify-content: center;
    }

    .pagination .page-item .page-link {
        color: var(--primary-color);
        transition: all 0.3s;
        border-radius: 5px;
        margin: 0 3px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        color: #ffffff;
        border-color: var(--primary-color);
    }

    .pagination .page-item .page-link:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
    }

    /* Custom Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .pagination-container .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination-container .pagination li {
        margin: 0 5px;
    }

    .pagination-container .pagination a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        border: 1px solid var(--border-color);
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
    }

    .pagination-container .pagination a:hover,
    .pagination-container .pagination a.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    </style>
</head>

<body>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @elseif(session('error'))
          toastr.error("{{ session('error') }}");
        @endif
    </script>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{route('admin.dashboard')}}" class="logo d-flex align-items-center">
        <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="">
        <span class="d-none d-lg-block">Trang quản lý</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ asset('assets/admin/img/profile-img.jpg') }} " alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{ Auth::user()->name }}</h6>
              <span>Quản trị hệ thống</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            {{-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> --}}

            <li>

              <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                @csrf
                <button type="submit" class="btn btn-link dropdown-item w-100 text-left">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </button>
              </form>
            </li>

          </ul>
        </li>

      </ul>
    </nav>

  </header>

  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Bảng điều khiển</span>
        </a>
      </li>

      @if(hasRole(999, Auth()->user()))
        <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-person"></i><span>Người dùng</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.user.index') }}">
              <i class="bi bi-circle"></i><span>Quản lý người dùng</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.role.index') }}">
              <i class="bi bi-circle"></i><span>Quản lý danh sách vai trò</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.permission.index') }}">
              <i class="bi bi-circle"></i><span>Quản lý danh sách quyền</span>
            </a>
          </li>
          <!-- <li>
            <a href="{{ route('admin.user_has_role') }}">
              <i class="bi bi-circle"></i><span>Phân vai trò người dùng</span>
            </a>
          </li> -->
          <li>
            <a href="{{ route('admin.role_has_permission') }}">
              <i class="bi bi-circle"></i><span>Phân quyền cho vai trò</span>
            </a>
          </li>
          <!-- <li>
            <a href="{{ route('admin.role_has_permission') }}">
              <i class="bi bi-circle"></i><span>Phân quyền cho người dùng</span>
            </a>
          </li> -->
        </ul>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Quản lý danh bạ</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.department.index') }}">
              <i class="bi bi-circle"></i><span>Đơn vị</span>
            </a>
          </li>
          <li>
            <a href=" {{route('admin.class.index')}}">
              <i class="bi bi-circle"></i><span>Lớp học</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.teacher.index')}}">
              <i class="bi bi-circle"></i><span>Cán bộ giảng viên</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.student.index')}}">
              <i class="bi bi-circle"></i><span>Sinh viên</span>
            </a>
          </li>
        </ul>
      </li>

      @endif
      {{-- manager forum --}}
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Quản lý diễn đàn</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('admin.forum.categories.index')}}">
              <i class="bi bi-circle"></i><span>Danh mục</span>
            </a>
          </li>
          <li>
            <a href="{{route('admin.forum.posts.index')}}">
              <i class="bi bi-circle"></i><span>Bài viết</span>
            </a>
          </li>
          <li>
            <a href="{{ route('admin.forum.comments.index') }}">
              <i class="bi bi-circle"></i><span>Bình luận</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Thông báo</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('admin.notification.index') }}">
              <i class="bi bi-circle"></i><span>Quản lý thông báo</span>
            </a>
          </li>

          <li>
            <a href="{{ route('admin.notification-category.index') }}">
              <i class="bi bi-circle"></i><span>Quản lý danh mục</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-gear"></i>
          <span>Cài đặt</span>
        </a>
      </li>
    </ul>

  </aside>

  <main id="main" class="main">

    @yield('content')

  </main>

  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="{{ asset('assets/admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>

    
<script type="text/javascript">
    function ChangeToSlug() {
        var slug;
        slug = document.getElementById("name").value;
        slug = slug.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        document.getElementById('slug').value = slug;
    }
</script>
    @yield('custom-js');
</body>

</html>
