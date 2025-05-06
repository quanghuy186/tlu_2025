@extends('layouts.app')

@section('content')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Danh bạ Cán bộ Giảng viên</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh bạ Cán bộ Giảng viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content - For CBGV Access -->
<div class="container mb-5" id="cbgv-access">
    <!-- Search and Filter Section -->
    <div class="search-filter-container">
        
        <div class="filter-options" >
            <div class="filter-group">
                <span class="filter-label">Sắp xếp theo:</span>
                <select class="filter-select" id="sortSelect">
                    <option value="name">Tên (A-Z)</option>
                    <option value="name-desc">Tên (Z-A)</option>
                </select>
            </div> 

            <div class="filter-group">
                <span class="filter-label">Đơn vị:</span>
                <select class="filter-select" id="departmentSelect" name="department_id">
                    <option value="all">Tất cả đơn vị</option>
                    @foreach ($departments as $d)
                        <option value="{{ $d->id }}" {{ isset($department_id) && $department_id == $d->id ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <span class="filter-label">Chức vụ:</span>
                <select class="filter-select" id="rankSelect" name="academic_rank">
                    <option value="all">Tất cả chức vụ</option>
                    @foreach ($academic_rank as $a)
                        <option value="{{ $a->academic_rank }}" {{ isset($selected_rank) && $selected_rank == $a->academic_rank ? 'selected' : '' }}>
                            {{ $a->academic_rank }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <form action="{{ route('contact.teacher.search') }}" method="GET">
            <div class="search-box mt-5">
                <i class="fas fa-search me-2"></i>
                <input name="fullname" value="{{ $fullname ?? '' }}" type="text" placeholder="Tìm kiếm theo tên hoặc mã cán bộ...">
                <button type="submit"><i class="fas fa-arrow-right"></i></button>
            </div>
        </form>
        
    </div>

    <!-- Teacher List -->
    <div class="teacher-list-container">
        <div class="teacher-list-header">
            <div class="teacher-count">
                Hiển thị <span class="text-primary">1-10</span> trong tổng số <span class="text-primary">153</span> Cán bộ Giảng viên
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Teacher List Items -->
        <div class="teacher-list">
            @include('partials.teacher_list', ['teachers' => $teachers])
            {{-- @foreach($teachers as $teacher)
                <div class="teacher-item">
                    <img src="{{ asset('storage/avatars/'.($teacher->user->avatar ?? 'default.png')) }}" alt="Giảng viên" class="teacher-avatar">
                    <div class="teacher-info">
                        <div class="teacher-name">{{ $teacher->user->name ?? 'Chưa cập nhật' }}</div>
                        <div class="teacher-position">{{ $teacher->position ?? 'Chưa cập nhật' }}</div>
                        <div class="teacher-department">
                            Đơn vị: 
                            @if($teacher->department)
                                <a href="#">{{ $teacher->department->name }}</a>
                            @else
                                <span>Chưa cập nhật</span>
                            @endif
                        </div>
                    </div>
                   
                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal{{ $teacher->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="teacherDetailModal{{ $teacher->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Thông tin Cán bộ Giảng viên</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="teacher-detail">
                                    <img src="{{ asset('storage/avatars/'.($teacher->user->avatar ?? 'default.png')) }}" alt="Giảng viên" class="teacher-detail-avatar">
                                    <div class="teacher-detail-name">{{ $teacher->user->name ?? 'Chưa cập nhật' }}</div>
                                    <div class="teacher-detail-position">{{ $teacher->position ?? 'Chưa cập nhật' }}</div>
            
                                    <ul class="teacher-detail-info">
                                        <li>
                                            <i class="fas fa-id-card"></i>
                                            <span class="detail-label">Mã cán bộ:</span>
                                            <span class="detail-value">{{ $teacher->code ?? 'Chưa cập nhật' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-envelope"></i>
                                            <span class="detail-label">Email:</span>
                                            <span class="detail-value">{{ $teacher->user->email ?? 'Chưa cập nhật' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-phone"></i>
                                            <span class="detail-label">Điện thoại:</span>
                                            <span class="detail-value">{{ $teacher->phone ?? 'Chưa cập nhật' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-building"></i>
                                            <span class="detail-label">Đơn vị:</span>
                                            <span class="detail-value">
                                                @if($teacher->department)
                                                    <a href="#">{{ $teacher->department->name }}</a>
                                                @else
                                                    Chưa cập nhật
                                                @endif
                                            </span>
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span class="detail-label">Địa chỉ:</span>
                                            <span class="detail-value">{{ $teacher->address ?? 'Chưa cập nhật' }}</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-briefcase"></i>
                                            <span class="detail-label">Chuyên môn:</span>
                                            <span class="detail-value">{{ $teacher->specialization ?? 'Chưa cập nhật' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
            
        </div>


        <!-- Pagination -->
        
            {{-- </div>
        </div> --}}
    </div>
</div>

<!-- Access Denied - For Student Access (Hidden by default) -->
<div class="container mb-5" id="student-access" style="display: none;">
    <div class="access-denied">
        <i class="fas fa-lock"></i>
        <h2>Quyền truy cập bị hạn chế</h2>
        <p>Bạn không có quyền truy cập vào danh bạ Cán bộ Giảng viên. Chỉ Cán bộ Giảng viên mới có thể truy cập vào phần này.</p>
        <a href="#" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
</div>

@endsection

@section('custom-js')
<script>
$(document).ready(function(){
    // Biến để lưu trữ các tham số tìm kiếm hiện tại
    var currentSearch = "{{ $fullname ?? '' }}";
    var currentDepartment = "{{ $department_id ?? 'all' }}";
    var currentRank = "{{ $selected_rank ?? 'all' }}";
    
    // Hàm chung để tải dữ liệu khi có thay đổi bất kỳ
    function loadData(options) {
        // Cập nhật các biến nếu có tham số tương ứng
        if (options.sort) {
            // Chỉ cập nhật sortBy, không cần lưu vào biến toàn cục
        }
        if (options.search !== undefined) {
            currentSearch = options.search;
        }
        if (options.department_id !== undefined) {
            currentDepartment = options.department_id;
        }
        if (options.academic_rank !== undefined) {
            currentRank = options.academic_rank;
        }
        
        // Xác định URL dựa trên loại hành động
        var url = options.sort 
            ? "{{ route('contact.teacher.sort') }}" 
            : "{{ route('contact.teacher.search') }}";
        
        // Chuẩn bị dữ liệu gửi đi
        var data = {
            fullname: currentSearch,
            department_id: currentDepartment,
            academic_rank: currentRank
        };
        
        // Thêm tham số sort nếu có
        if (options.sort) {
            data.sort = options.sort;
        }
        
        // Gửi yêu cầu Ajax
        $.ajax({
            url: url,
            type: "GET",
            data: data,
            success: function(response) {
                $(".teacher-list").html(response);
            },
            error: function(xhr) {
                console.error("Lỗi khi tải dữ liệu:", xhr.responseText);
            }
        });
    }
    
    // Xử lý sự kiện khi select sắp xếp thay đổi
    $("#sortSelect").change(function() {
        loadData({
            sort: $(this).val()
        });
    });
    
    // Xử lý sự kiện khi select department thay đổi
    $("#departmentSelect").change(function() {
        loadData({
            department_id: $(this).val()
        });
    });
    
    // Xử lý sự kiện khi select chức vụ thay đổi
    $("#rankSelect").change(function() {
        loadData({
            academic_rank: $(this).val()
        });
    });
    
    // Xử lý form tìm kiếm bằng Ajax
    $(".search-box form").submit(function(e) {
        e.preventDefault(); // Ngăn chặn hành vi mặc định của form
        
        loadData({
            search: $("input[name='fullname']").val()
        });
    });
    
    // Xử lý các link phân trang để duy trì tham số tìm kiếm

    $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            
            var page = $(this).data('page');
            
            loadData({
                page: page
            });
            
            // Scroll to top of list (optional)
            $('html, body').animate({
                scrollTop: $(".teacher-list-container").offset().top - 100
            }, 200);
    });

    $("<style>")
            .prop("type", "text/css")
            .html(`
                .student-list.loading {
                    position: relative;
                    min-height: 200px;
                }
                .student-list.loading:after {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(255, 255, 255, 0.7) url('/images/spinner.gif') no-repeat center center;
                    z-index: 5;
                }
            `).appendTo("head");
});
</script>
@endsection