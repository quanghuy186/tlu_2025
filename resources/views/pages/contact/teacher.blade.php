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
                        <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Danh bạ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh bạ Cán bộ Giảng viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5" id="cbgv-access">
    <div class="search-filter-container">
        
        <div class="filter-options">
            <div class="filter-group">
                <span class="filter-label">Sắp xếp theo:</span>
                <select class="filter-select" id="sortSelect" name="sort">
                    <option value="name" {{ ($sort ?? 'name') == 'name' ? 'selected' : '' }}>Tên (A-Z)</option>
                    <option value="name-desc" {{ ($sort ?? '') == 'name-desc' ? 'selected' : '' }}>Tên (Z-A)</option>
                    <option value="department" {{ ($sort ?? '') == 'department' ? 'selected' : '' }}>Đơn vị</option>
                    <option value="position" {{ ($sort ?? '') == 'position' ? 'selected' : '' }}>Chức vụ</option>
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

        <form action="{{ route('contact.teacher.search') }}" method="GET" id="search-form">
            <div class="search-box mt-5">
                <i class="fas fa-search me-2"></i>
                <input name="fullname" value="{{ $fullname ?? '' }}" type="text" placeholder="Tìm kiếm theo tên hoặc mã cán bộ...">
                <button type="submit"><i class="fas fa-arrow-right"></i></button>
            </div>
        </form>
        
    </div>

    <!-- Teacher List -->
    <div class="teacher-list-container" id="teacher-list-container">
        <div class="teacher-list-header">
            <div class="teacher-count">
                Hiển thị <span class="text-primary">{{ $teachers->firstItem() ?? 0 }}-{{ $teachers->lastItem() ?? 0 }}</span> 
                trong tổng số <span class="text-primary">{{ $teachers->total() ?? 0 }}</span> Cán bộ Giảng viên
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Teacher List Items -->
        <div class="teacher-list">
            @include('partials.teacher_list', ['teachers' => $teachers])
        </div>
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
$(document).ready(function() {
    // Biến để lưu trữ các tham số hiện tại
    let currentFilters = {
        fullname: '{{ $fullname ?? '' }}',
        department_id: '{{ $department_id ?? 'all' }}',
        academic_rank: '{{ $selected_rank ?? 'all' }}',
        sort: '{{ $sort ?? 'name' }}'
    };
    
    // Hàm gửi Ajax request chung
    function sendAjaxRequest(url, data, successCallback) {
        showLoading();
        
        $.ajax({
            url: url,
            type: 'GET',
            data: data,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (successCallback) {
                    successCallback(response);
                }
                hideLoading();
            },
            error: function(xhr, status, error) {
                console.error('Ajax Error:', error);
                console.error('Response:', xhr.responseText);
                hideLoading();
                
                let errorMsg = 'Có lỗi xảy ra khi tải dữ liệu.';
                if (xhr.status === 404) {
                    errorMsg = 'Không tìm thấy trang yêu cầu.';
                } else if (xhr.status === 500) {
                    errorMsg = 'Lỗi server. Vui lòng thử lại sau.';
                }
                alert(errorMsg);
            }
        });
    }
    
    // Xử lý sự kiện click pagination
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        
        var page = $(this).data('page');
        if (!page || $(this).parent().hasClass('disabled')) {
            return;
        }
        
        var requestData = {
            page: page,
            fullname: currentFilters.fullname,
            department_id: currentFilters.department_id,
            academic_rank: currentFilters.academic_rank,
            sort: currentFilters.sort
        };
        
        var searchUrl = '{{ route("contact.teacher.search") }}';
        
        sendAjaxRequest(searchUrl, requestData, function(response) {
            $('.teacher-list').html(response);
            
            // Cuộn lên đầu danh sách
            $('html, body').animate({
                scrollTop: $('#teacher-list-container').offset().top - 100
            }, 300);
        });
    });
    
    // Xử lý sự kiện tìm kiếm
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        
        // Cập nhật filters
        currentFilters.fullname = $('input[name="fullname"]').val() || '';
        
        var requestData = {
            page: 1, // Reset về trang 1
            fullname: currentFilters.fullname,
            department_id: currentFilters.department_id,
            academic_rank: currentFilters.academic_rank,
            sort: currentFilters.sort
        };
        
        var searchUrl = $(this).attr('action');
        
        sendAjaxRequest(searchUrl, requestData, function(response) {
            $('.teacher-list').html(response);
            updateTeacherCount();
        });
    });
    
    // Xử lý sự kiện lọc theo department
    $('#departmentSelect').on('change', function() {
        currentFilters.department_id = $(this).val();
        triggerFilter();
    });
    
    // Xử lý sự kiện lọc theo academic_rank
    $('#rankSelect').on('change', function() {
        currentFilters.academic_rank = $(this).val();
        triggerFilter();
    });
    
    // Xử lý sự kiện sắp xếp
    $('#sortSelect').on('change', function() {
        currentFilters.sort = $(this).val();
        
        var requestData = {
            page: 1, // Reset về trang 1
            fullname: currentFilters.fullname,
            department_id: currentFilters.department_id,
            academic_rank: currentFilters.academic_rank,
            sort: currentFilters.sort
        };
        
        var sortUrl = '{{ route("contact.teacher.sort") }}';
        
        sendAjaxRequest(sortUrl, requestData, function(response) {
            $('.teacher-list').html(response);
            updateTeacherCount();
        });
    });
    
    // Hàm trigger filter chung
    function triggerFilter() {
        var requestData = {
            page: 1, // Reset về trang 1
            fullname: currentFilters.fullname,
            department_id: currentFilters.department_id,
            academic_rank: currentFilters.academic_rank,
            sort: currentFilters.sort
        };
        
        var searchUrl = '{{ route("contact.teacher.search") }}';
        
        sendAjaxRequest(searchUrl, requestData, function(response) {
            $('.teacher-list').html(response);
            updateTeacherCount();
        });
    }
    
    // Cập nhật số lượng giáo viên hiển thị
    function updateTeacherCount() {
        // Lấy thông tin từ phần pagination-info trong response
        var paginationInfo = $('.pagination-info').text();
        if (paginationInfo) {
            var matches = paginationInfo.match(/Hiển thị (\d+) - (\d+) của (\d+)/);
            if (matches) {
                $('.teacher-count').html(
                    'Hiển thị <span class="text-primary">' + matches[1] + '-' + matches[2] + '</span> ' +
                    'trong tổng số <span class="text-primary">' + matches[3] + '</span> Cán bộ Giảng viên'
                );
            }
        }
    }
    
    // Hàm hiển thị loading
    function showLoading() {
        $('.loading-overlay').remove();
        
        $('body').append(`
            <div class="loading-overlay" style="
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
            ">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `);
    }
    
    // Hàm ẩn loading
    function hideLoading() {
        $('.loading-overlay').remove();
    }
});
</script>
@endsection