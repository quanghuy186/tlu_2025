@extends('layouts.app')

@section('title')
    Danh bạ đơn vị
@endsection

@section('content')
<div class="container">

<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Danh bạ đơn vị</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">Danh bạ</a></li>
                        <li class="breadcrumb-item active"><a href="#">Danh bạ đơn vị</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

    <!-- Search and Filter Section -->
    <div class="search-filter-container">
        
        <div class="filter-group">
            <span class="filter-label">Sắp xếp theo:</span>
            <select class="filter-select" id="sortSelect" name="sort">
                <option value="name">Tên (A-Z)</option>
                <option value="name-desc">Tên (Z-A)</option>
            </select>
        </div>

        <form id="searchForm" action="{{ route('contact.department.search') }}" method="GET">
            <div class="search-box mt-5">
                <i class="fas fa-search me-2"></i>
                <input name="fullname" value="{{ $fullname ?? '' }}" type="text" placeholder="Tìm kiếm tên đơn vị...">
                <button type="submit"><i class="fas fa-arrow-right"></i></button>
            </div>
        </form> 
    </div>
    
    <!-- Unit List -->
    <div class="unit-list-container">
        <div class="unit-list-header">
            <div class="unit-count">
                Hiển thị <span class="text-primary">{{ $departments->firstItem() ?? 0 }}-{{ $departments->lastItem() ?? 0 }}</span> 
                trong tổng số <span class="text-primary">{{ $departments->total() }}</span> Đơn vị
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Unit List Items -->
        <div class="unit-list">
            @include('partials.department_list', ['departments' => $departments])
            
        </div>
    </div>
</div>

<!-- Unit Detail Modal 1 -->

@endsection


@section('custom-js')
<script>
    $(document).ready(function(){
        // Biến để lưu trữ các tham số tìm kiếm hiện tại
        var currentSearch = "{{ $fullname ?? '' }}";
        function loadData(options) {
            // Cập nhật các biến nếu có tham số tương ứng
            if (options.fullname !== undefined) {
                currentSearch = options.fullname;
            }
            var url = options.sort 
                ? "{{ route('contact.department.sort') }}" 
                : "{{ route('contact.department.search') }}";
            
            // Chuẩn bị dữ liệu gửi đi
            var data = {
                fullname: currentSearch,
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
            $(".unit-list").addClass("loading");
            
            // Gửi yêu cầu Ajax
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function(response) {
                    $(".unit-list").html(response).removeClass("loading");
                },
                error: function(xhr) {
                    console.error("Lỗi khi tải dữ liệu:", xhr.responseText);
                    $(".unit-list").removeClass("loading");
                }
            });
        }
        
        $("#sortSelect").change(function() {
            loadData({
                sort: $(this).val()
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
                scrollTop: $(".unit-list-container").offset().top - 100
            }, 200);
        });
        
        $("<style>")
            .prop("type", "text/css")
            .html(`
                .unit-list.loading {
                    position: relative;
                    min-height: 200px;
                }
                .unit-list.loading:after {
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