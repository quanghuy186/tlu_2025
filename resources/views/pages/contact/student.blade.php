@extends('layouts.app')

@section('title')
    Danh bạ sinh viên
@endsection

@section('content')
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Danh bạ sinh viên</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Danh bạ</a></li>
                        <li class="breadcrumb-item active"><a href="#">Danh bạ sinh viên</a></li>
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

        <div class="student-list">
            @include('partials.student_list', ['students' => $students])

                </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script>
    $(document).ready(function(){
        var currentSearch = "{{ $fullname ?? '' }}";
        var currentClass = "{{ $class_id ?? 'all' }}";
        var currentYear = "{{ $enrollment_year ?? 'all' }}";
        
        function loadData(options) {
            if (options.fullname !== undefined) {
                currentSearch = options.fullname;
            }
            if (options.class_id !== undefined) {
                currentClass = options.class_id;
            }
            if (options.enrollment_year !== undefined) {
                currentYear = options.enrollment_year;
            }
            
            var url = options.sort 
                ? "{{ route('contact.student.sort') }}" 
                : "{{ route('contact.student.search') }}";
            
            var data = {
                fullname: currentSearch,
                class_id: currentClass,
                enrollment_year: currentYear
            };
            
            if (options.sort) {
                data.sort = options.sort;
            }
            
            if (options.page) {
                data.page = options.page;
            }
            
            $(".student-list").addClass("loading");
            
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
        
        $("#sortSelect").change(function() {
            loadData({
                sort: $(this).val()
            });
        });
        
        $("#classSelect").change(function() {
            loadData({
                class_id: $(this).val()
            });
        });
        
        $("#yearSelect").change(function() {
            loadData({
                enrollment_year: $(this).val()
            });
        });
        
        $("#searchForm").submit(function(e) {
            e.preventDefault(); 
            
            loadData({
                fullname: $("input[name='fullname']").val()
            });
        });
        
        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            
            var page = $(this).data('page');
            
            loadData({
                page: page
            });
            
            $('html, body').animate({
                scrollTop: $(".student-list-container").offset().top - 100
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