@if (Auth::check())

@else
    <p>Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để tiếp tục.</p>
@endif


<body>
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @elseif(session('error'))
            toastr.error("{{ session('error') }}");
        @elseif(session('warning'))
            toastr.warning("{{ session('warning') }}");
        @endif
    </script>
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

                    @if(request()->is('chat*'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('chat.index') }}">Tin nhắn</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('chat.index') }}">Tin nhắn</a>
                        </li>
                    @endif
                    
                    @if (request()->is('forum*'))
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('forum.index') }}">Diễn đàn</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('forum.index') }}">Diễn đàn</a>
                        </li>
                    @endif

                    @if(request()->is('notification*'))
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
                        <img src="{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar) : asset('user_default.jpg') }}" alt="User Avatar" class="user-avatar">
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header">Thông tin tài khoản</li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#userInfoModal"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
                        <li><a class="dropdown-item" href="{{ route('password.form') }}"><i class="fas fa-cog"></i>Đổi mật khẩu</a></li>
                        <li><a class="dropdown-item" href="{{ route('notification.index') }}"><i class="fas fa-bell"></i> Thông báo</a></li>
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
    

<div class="modal fade user-info-modal" id="userInfoModal" tabindex="-1" aria-labelledby="userInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userInfoModalLabel">Thông tin cá nhân</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="updateProfileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            <img src="{{ Auth::user()->avatar ? asset('storage/avatars/'.Auth::user()->avatar) : asset('user_default.jpg') }}" 
                                alt="User Profile" class="avatar" id="avatarPreview">
                            <label for="avatarInput" class="avatar-upload-btn">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*">
                        </div>
                        
                        <!-- Hiển thị tên người dùng -->
                        <h4 class="mt-2">{{ Auth::user()->name }}</h4>
                        
                        <!-- Hiển thị các badge cho mỗi vai trò -->
                        <div class="mb-3">
                            @php
                                $roles = [];
                                if (hasRole(1, Auth::user())) $roles[] = ['id' => 1, 'name' => 'Sinh viên', 'class' => 'bg-primary'];
                                if (hasRole(2, Auth::user())) $roles[] = ['id' => 2, 'name' => 'Giảng viên', 'class' => 'bg-info'];
                                if (hasRole(3, Auth::user())) $roles[] = ['id' => 3, 'name' => 'Đơn vị', 'class' => 'bg-success'];
                                if (hasRole(4, Auth::user())) $roles[] = ['id' => 4, 'name' => 'Kiểm duyệt viên', 'class' => 'bg-warning text-dark'];
                            @endphp
                            
                            @foreach($roles as $role)
                                <span class="badge rounded-pill {{ $role['class'] }} me-1" data-role-id="{{ $role['id'] }}">
                                    {{ $role['name'] }}
                                </span>
                            @endforeach
                        </div>
                        
                        <!-- Hiển thị selector cho vai trò khi người dùng có nhiều vai trò -->
                        @if(count($roles) > 1)
                            <div class="form-group mb-4">
                                <label for="role_selector" class="fw-bold">Chọn vai trò để cập nhật:</label>
                                <select id="role_selector" class="form-select" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="role_id" value="{{ $roles[0]['id'] ?? 1 }}">
                        @endif
                    </div>
                    
                    <!-- Form cho Sinh viên (Role 1) -->
                    <div id="role-form-1" class="role-form">
                        <div class="role-header mb-3">
                            <h5 class="text-primary">Thông tin Sinh viên</h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name_student"><i class="fas fa-user"></i> Họ và tên</label>
                                    <input type="text" class="form-control" id="name_student" name="student[name]" 
                                           value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="student_id"><i class="fas fa-id-card"></i> Mã số sinh viên</label>
                                    <input type="text" class="form-control" id="student_id" name="student[student_id]" 
                                           value="{{ Auth::user()->student->student_code ?? 'SV12345678' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="class_room"><i class="fas fa-building"></i> Lớp học</label>
                                    <select class="form-select" id="class_room" name="student[class_id]" 
                                            data-current-class-id="{{ Auth::user()->student->class_id ?? '' }}">
                                        <option value="">-- Đang tải danh sách lớp học --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_student"><i class="fas fa-envelope"></i> Email</label>
                                    <input readonly type="email" class="form-control" id="email_student" 
                                           value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone_student"><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone_student" name="student[phone]" 
                                           value="{{ Auth::user()->phone ?? '0987654321' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address_student"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                                    <input type="text" class="form-control" id="address_student" name="student[address]" 
                                           value="{{ Auth::user()->address ?? 'Việt Nam' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form cho Giảng viên (Role 2) -->
                    <div id="role-form-2" class="role-form">
                        <div class="role-header mb-3">
                            <h5 class="text-info">Thông tin Giảng viên</h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name_teacher"><i class="fas fa-user"></i> Họ và tên</label>
                                    <input type="text" class="form-control" id="name_teacher" name="teacher[name]" 
                                           value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="teacher_code"><i class="fas fa-id-card"></i> Mã giảng viên</label>
                                    <input type="text" class="form-control" id="teacher_code" name="teacher[teacher_code]" 
                                           value="{{ Auth::user()->teacher->teacher_code ?? 'Chưa cập nhật' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="department"><i class="fas fa-building"></i> Thuộc đơn vị</label>
                                    <select class="form-select" id="department" name="teacher[department_id]" data-current-department-id="{{ Auth::user()->teacher->department_id ?? '' }}">
                                        <option value="">Đang tải dữ liệu...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_teacher"><i class="fas fa-envelope"></i> Email</label>
                                    <input readonly type="email" class="form-control" id="email_teacher" 
                                           value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone_teacher"><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone_teacher" name="teacher[phone]" 
                                           value="{{ Auth::user()->phone ?? '0987654321' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address_teacher"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                                    <input type="text" class="form-control" id="address_teacher" name="teacher[address]" 
                                           value="{{ Auth::user()->address ?? 'Hà Nội, Việt Nam' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form cho Đơn vị (Role 3) -->
                    <div id="role-form-3" class="role-form">
                        <div class="role-header mb-3">
                            <h5 class="text-success">Thông tin Đơn vị</h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="department_name"><i class="fas fa-building"></i> Tên đơn vị</label>
                                    <input type="text" class="form-control" id="department_name" name="department[name]" 
                                           value="{{ Auth::user()->managedDepartment->name ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="department_description" style="height: 100px" name="department[description]">{{ Auth::user()->managedDepartment->description ?? '' }}</textarea>
                                    <label for="department_description">Mô tả đơn vị {{ Auth::user()->managedDepartment->name ?? '' }}</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_department"><i class="fas fa-envelope"></i> Email đơn vị</label>
                                    <input type="email" class="form-control" id="email_department" name="department[email]" 
                                           value="{{ Auth::user()->managedDepartment->email ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone_department"><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone_department" name="department[phone]" 
                                           value="{{ Auth::user()->managedDepartment->phone ?? '' }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                                    <input type="text" class="form-control" id="address" name="department[address]" 
                                           value="{{ Auth::user()->managedDepartment->address ?? 'Hà Nội, Việt Nam' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form cho Kiểm duyệt viên (Role 4) -->
                    <div id="role-form-4" class="role-form">
                        <div class="role-header mb-3">
                            <h5 class="text-warning">Thông tin Kiểm duyệt viên</h5>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name_moderator"><i class="fas fa-user"></i> Họ và tên</label>
                                    <input type="text" class="form-control" id="name_moderator" name="moderator[name]" 
                                           value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email_moderator"><i class="fas fa-envelope"></i> Email</label>
                                    <input readonly type="email" class="form-control" id="email_moderator" 
                                           value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone_moderator"><i class="fas fa-phone"></i> Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone_moderator" name="moderator[phone]" 
                                           value="{{ Auth::user()->phone ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address_mod"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                                    <input type="text" class="form-control" id="address_mod" name="moderator[address_mod]" 
                                           value="{{ Auth::user()->address ?? 'Việt Nam' }}">
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" form="updateProfileForm" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hàm để hiển thị form cho vai trò được chọn
        function showRoleForm(roleId) {
            // Ẩn tất cả các form vai trò
            document.querySelectorAll('.role-form').forEach(form => {
                form.style.display = 'none';
            });
            
            // Hiển thị form cho vai trò được chọn
            const selectedForm = document.getElementById(`role-form-${roleId}`);
            if (selectedForm) {
                selectedForm.style.display = 'block';
            }
        }
        
        // Xử lý sự kiện khi người dùng thay đổi vai trò
        const roleSelector = document.getElementById('role_selector');
        if (roleSelector) {
            // Hiển thị form ban đầu dựa trên vai trò được chọn
            showRoleForm(roleSelector.value);
            
            // Lắng nghe sự kiện thay đổi
            roleSelector.addEventListener('change', function() {
                showRoleForm(this.value);
            });
        } else {
            // Nếu không có selector (chỉ có một vai trò), hiển thị form cho vai trò đó
            const hiddenRoleInput = document.querySelector('input[name="role_id"]');
            if (hiddenRoleInput) {
                showRoleForm(hiddenRoleInput.value);
            }
        }
        
        // Xử lý xem trước avatar khi người dùng chọn file
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        
        if (avatarInput && avatarPreview) {
            avatarInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        avatarPreview.src = e.target.result;
                    };
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userInfoModal = document.getElementById('userInfoModal');
        if (userInfoModal) {
            userInfoModal.addEventListener('shown.bs.modal', function() {
                if (document.getElementById('role-form-1') && 
                    document.getElementById('role-form-1').style.display === 'block') {
                    loadClasses();
                }
            });
        }
        
        const roleSelector = document.getElementById('role_selector');
        if (roleSelector) {
            roleSelector.addEventListener('change', function() {
                if (this.value === '1') { 
                    loadClasses();
                }
            });
        }

        function loadClasses() {
            const classSelect = document.getElementById('class_room');
            
            if (!classSelect) return;
            if (classSelect.options.length <= 1) {
                const currentClassId = classSelect.getAttribute('data-current-class-id') || '';
                
                fetch('/api/classes') 
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        classSelect.innerHTML = '<option value="">-- Chọn lớp học --</option>';
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(classItem => {
                                const option = document.createElement('option');
                                option.value = classItem.id;
                                option.textContent = classItem.class_name;
                                if (currentClassId && currentClassId == classItem.id) {
                                    option.selected = true;
                                }
                                
                                classSelect.appendChild(option);
                            });
                        } else {
                            console.log('Không có dữ liệu lớp học hoặc dữ liệu không đúng định dạng:', data);
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi tải danh sách lớp học:', error);
                        classSelect.innerHTML = '<option value="">-- Lỗi khi tải danh sách --</option>';
                    });
            }
        }
        
        if (document.getElementById('role-form-1') && 
            document.getElementById('role-form-1').style.display === 'block') {
            loadClasses();
        }
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const departmentDropdown = document.getElementById('department');
    
    if (departmentDropdown) {
        const currentDepartmentId = departmentDropdown.getAttribute('data-current-department-id');
        // console.log('Current department ID:', currentDepartmentId);
        
        fetch('/api/department')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(departments => {
                // Debug - log the departments from API
                console.log('Departments from API:', departments);
                
                // Clear existing options
                departmentDropdown.innerHTML = '';
                
                // Add a default option
                const defaultOption = document.createElement('option');
                defaultOption.value = "";
                defaultOption.textContent = "Chọn đơn vị";
                departmentDropdown.appendChild(defaultOption);
                
                // Add option for each department
                departments.forEach(department => {
                    const option = document.createElement('option');
                    option.value = department.id; // Use ID as value, not name
                    option.textContent = department.name;
                    
                    // Select the previously selected option based on IDF
                    // if (department.id.toString() === currentDepartmentId) {
                    //     option.selected = true;
                    // }

                    if (currentDepartmentId && currentDepartmentId == department.id) {
                        option.selected = true;
                    }
                    
                    departmentDropdown.appendChild(option);
                });
                
                // If no option was selected and we have options, select the first one
                if (departmentDropdown.selectedIndex === 0 && departmentDropdown.options.length > 1) {
                    departmentDropdown.selectedIndex = 1;
                }
            })
            .catch(error => {
                console.error('Error fetching departments:', error);
                // Add a fallback option in case of error
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "Không thể tải dữ liệu";
                departmentDropdown.appendChild(option);
            });
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('updateProfileForm');
    
    if (form) {
        console.log('Form được tìm thấy');
        
        form.addEventListener('submit', function(event) {
            console.log('Form đang được submit');
            
            // Chỉ sử dụng cho mục đích debug
            // event.preventDefault();
            
            // Hiển thị dữ liệu form
            const formData = new FormData(this);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
        });
        
        const submitBtn = document.querySelector('button[type="submit"][form="updateProfileForm"]');
        if (submitBtn) {
            console.log('Nút submit được tìm thấy');
            submitBtn.addEventListener('click', function() {
                console.log('Nút submit được click');
            });
        } else {
            console.error('Không tìm thấy nút submit!');
        }
    } else {
        console.error('Không tìm thấy form với ID updateProfileForm!');
    }
});
</script>