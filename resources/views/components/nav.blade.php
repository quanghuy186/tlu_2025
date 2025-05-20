@if (Auth::check())

@else
    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để tiếp tục.</p>
@endif

<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @elseif(session('error'))
        toastr.error("{{ session('error') }}");
    @elseif(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span><i class="fas fa-envelope me-2"></i> info@tlu.edu.vn</span>
                    <span class="ms-3"><i class="fas fa-phone me-2"></i> (024) 3852 2201</span>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="me-3"><i class="fas fa-globe me-1"></i> tlu.edu.vn</a>
                    <a href="#"><i class="fas fa-map-marker-alt me-1"></i> 175 Tây Sơn, Đống Đa, Hà Nội</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    @if (request()->is('home*'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('home.index') }}">Trang chủ</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.index') }}">Trang chủ</a>
                        </li>
                    @endif
                   
                    @if(request()->is('contact*'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('contact.index') }}">Danh bạ</a>
                        </li>
                    @else
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.index') }}">Danh bạ</a>
                        </li>
                    @endif

                    @if(request()->is('messages*'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('messages.index') }}">Tin nhắn</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('messages.index') }}">Tin nhắn</a>
                        </li>
                    @endif
                    
                    @if (request()->is('forum'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('forum.index') }}">Diễn đàn</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('forum.index') }}">Diễn đàn</a>
                        </li>
                    @endif

                    @if(request()->is('notification'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('notification.index') }}">Thông báo</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('notification.index') }}">Thông báo</a>
                        </li>
                    @endif
                </ul>
                <div class="dropdown">
                    <a href="#" class="user-menu dropdown-toggle" data-bs-toggle="dropdown" data-bs-toggle="modal" data-bs-target="#userInfoModal">
                        {{-- <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" alt="User Avatar" class="user-avatar"> --}}
                        <span>
                            
                            {{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">Thông tin tài khoản</li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#userInfoModal"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="{{ route('password.form') }}"><i class="fas fa-cog"></i>Đổi mật khẩu</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-bell"></i> Thông báo</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                                @csrf
                                <button type="submit" class="btn btn-link dropdown-item w-100 text-left">
                                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

  
    {{-- <div class="modal fade user-info-modal" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel">Thông tin cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="https://via.placeholder.com/200x200?text=User" alt="User Profile" class="avatar">
                    <div class="user-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <span class="badge rounded-pill">Sinh viên</span>
                    </div>
                    <ul class="info-list">
                        <li><i class="fas fa-id-card"></i> Mã số: SV12345678</li>
                        <li><i class="fas fa-building"></i> Khoa Công nghệ thông tin</li>
                        <li><i class="fas fa-envelope"></i> a.nv123456@tlu.edu.vn</li>
                        <li><i class="fas fa-phone"></i> 0987654321</li>
                        <li><i class="fas fa-map-marker-alt"></i> Hà Nội, Việt Nam</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Cập nhật thông tin</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade user-info-modal" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userInfoModalLabel">Thông tin cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateProfileForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                {{-- <img src="{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar)  : 'https://via.placeholder.com/200x200?text=User' }}" 
                                     alt="User Profile" class="avatar" id="avatarPreview"> --}}
                                <label for="avatarInput" class="avatar-upload-btn">
                                    <i class="fas fa-camera"></i>
                                </label>
                                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                            </div>
                            <h4 class="mt-2">{{ Auth::user()->name }}</h4>
                            <span class="badge rounded-pill">{{ Auth::user()->role ?? 'Sinh viên' }}</span>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name"><i class="fas fa-user"></i> Họ và tên</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="studentId"><i class="fas fa-id-card"></i> Mã số sinh viên</label>
                                    <input type="text" class="form-control" id="studentId" name="student_id" value="{{ Auth::user()->student_id ?? 'SV12345678' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="faculty"><i class="fas fa-building"></i> Khoa</label>
                                    <select class="form-select" id="faculty" name="faculty">
                                        <option value="Công nghệ thông tin" {{ (Auth::user()->faculty ?? '') == 'Công nghệ thông tin' ? 'selected' : '' }}>Công nghệ thông tin</option>
                                        <option value="Kỹ thuật tài nguyên nước" {{ (Auth::user()->faculty ?? '') == 'Kỹ thuật tài nguyên nước' ? 'selected' : '' }}>Kỹ thuật tài nguyên nước</option>
                                        <option value="Kỹ thuật xây dựng" {{ (Auth::user()->faculty ?? '') == 'Kỹ thuật xây dựng' ? 'selected' : '' }}>Kỹ thuật xây dựng</option>
                                        <option value="Kinh tế và Quản lý" {{ (Auth::user()->faculty ?? '') == 'Kinh tế và Quản lý' ? 'selected' : '' }}>Kinh tế và Quản lý</option>
                                        <option value="Điện - Điện tử" {{ (Auth::user()->faculty ?? '') == 'Điện - Điện tử' ? 'selected' : '' }}>Điện - Điện tử</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                    <input readonly type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                                </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone"><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ Auth::user()->phone ?? '0987654321' }}">
                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ Auth::user()->address ?? 'Hà Nội, Việt Nam' }}">
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="updateProfileForm" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Script xử lý preview ảnh đại diện -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatarInput');
            const avatarPreview = document.getElementById('avatarPreview');
            
            avatarInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>