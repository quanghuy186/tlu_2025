@extends('layouts.app')

@section('content')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Danh bạ Sinh viên</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Danh bạ Sinh viên</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Main Content - For Students -->
<div class="container mb-5" id="cbgv-access">
    <!-- Search and Filter Section -->
    <div class="search-filter-container">
        
        <div class="filter-options">
            <div class="filter-group">
                <span class="filter-label">Sắp xếp theo:</span>
                <select class="filter-select" id="sortSelect" name="sort">
                    <option value="name">Tên (A-Z)</option>
                    <option value="name-desc">Tên (Z-A)</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Khóa:</span>
                <select class="filter-select" id="yearSelect" name="enrollment_year">
                    <option value="all">Tất cả khóa</option>
                    @foreach ($enrollment_years as $year)
                        <option value="{{ $year }}" {{ isset($enrollment_year) && $enrollment_year == $year ? 'selected' : '' }}>
                            K{{ $year - 1958 }} ({{ $year }}-{{ $year + 4 }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">Lớp:</span>
                <select class="filter-select" id="classSelect" name="class_id">
                    <option value="all">Tất cả lớp</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ isset($class_id) && $class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <form id="searchForm" action="{{ route('contact.student.search') }}" method="GET">
            <div class="search-box mt-5">
                <i class="fas fa-search me-2"></i>
                <input name="fullname" value="{{ $fullname ?? '' }}" type="text" placeholder="Tìm kiếm theo tên, mã sinh viên hoặc lớp...">
                <button type="submit"><i class="fas fa-arrow-right"></i></button>
            </div>
        </form> 
        
    </div>

    <!-- Student List -->
    <div class="student-list-container">
        <div class="student-list-header">
            <div class="student-count">
                Hiển thị <span class="text-primary">{{ $students->firstItem() ?? 0 }}-{{ $students->lastItem() ?? 0 }}</span> 
                trong tổng số <span class="text-primary">{{ $students->total() }}</span> Sinh viên
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Student List Items -->
        <div class="student-list">
            @include('partials.student_list', ['students' => $students])

            
        <!-- Pagination -->
        
                </div>
            </div>
        </div>
    @endsection

@section('custom-js')
<script>
    $(document).ready(function(){
        // Biến để lưu trữ các tham số tìm kiếm hiện tại
        var currentSearch = "{{ $fullname ?? '' }}";
        var currentClass = "{{ $class_id ?? 'all' }}";
        var currentYear = "{{ $enrollment_year ?? 'all' }}";
        
        // Hàm chung để tải dữ liệu khi có thay đổi bất kỳ
        function loadData(options) {
            // Cập nhật các biến nếu có tham số tương ứng
            if (options.fullname !== undefined) {
                currentSearch = options.fullname;
            }
            if (options.class_id !== undefined) {
                currentClass = options.class_id;
            }
            if (options.enrollment_year !== undefined) {
                currentYear = options.enrollment_year;
            }
            
            // Xác định URL dựa trên loại hành động
            var url = options.sort 
                ? "{{ route('contact.student.sort') }}" 
                : "{{ route('contact.student.search') }}";
            
            // Chuẩn bị dữ liệu gửi đi
            var data = {
                fullname: currentSearch,
                class_id: currentClass,
                enrollment_year: currentYear
            };
            
            // Thêm tham số sort nếu có
            if (options.sort) {
                data.sort = options.sort;
            }
            
            // Thêm tham số page nếu có
            if (options.page) {
                data.page = options.page;
            }
            
            // Hiển thị loading indicator (tùy chọn)
            $(".student-list").addClass("loading");
            
            // Gửi yêu cầu Ajax
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function(response) {
                    $(".student-list").html(response).removeClass("loading");
                },
                error: function(xhr) {
                    console.error("Lỗi khi tải dữ liệu:", xhr.responseText);
                    $(".student-list").removeClass("loading");
                }
            });
        }
        
        // Xử lý sự kiện khi select sắp xếp thay đổi
        $("#sortSelect").change(function() {
            loadData({
                sort: $(this).val()
            });
        });
        
        // Xử lý sự kiện khi select lớp thay đổi
        $("#classSelect").change(function() {
            loadData({
                class_id: $(this).val()
            });
        });
        
        // Xử lý sự kiện khi select khóa thay đổi
        $("#yearSelect").change(function() {
            loadData({
                enrollment_year: $(this).val()
            });
        });
        
        // Xử lý form tìm kiếm bằng Ajax
        $("#searchForm").submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của form
            
            loadData({
                fullname: $("input[name='fullname']").val()
            });
        });
        
        // Xử lý phân trang bằng Ajax
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            
            var page = $(this).data('page');
            
            loadData({
                page: page
            });
            
            // Scroll to top of list (optional)
            $('html, body').animate({
                scrollTop: $(".student-list-container").offset().top - 100
            }, 200);
        });
        
        // Thêm loading indicator CSS (tùy chọn)
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
            `)
            .appendTo("head");
    });
</script>
@endsection