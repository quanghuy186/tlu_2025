@extends('layouts.app')

@section('content')
<div class="container">
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
            {{-- <div class="filter-group">
                <span class="filter-label">Loại đơn vị:</span>
                <select class="filter-select">
                    <option value="all">Tất cả</option>
                    <option value="academic">Đơn vị đào tạo</option>
                    <option value="research">Đơn vị nghiên cứu</option>
                    <option value="administrative">Đơn vị hành chính</option>
                    <option value="service">Đơn vị dịch vụ</option>
                </select>
            </div> --}}
        </div>

        <form action="{{route('contact.department.search')}}" method="GET">
            <div class="search-box mt-5">
                <i class="fas fa-search me-2"></i>
                <input name="fullname" type="text" placeholder="Tìm kiếm tên đơn vị...">
                <button type="button"><i class="fas fa-arrow-right"></i></button>
            </div>
        </form>
    </div>

    <!-- Unit List -->
    <div class="unit-list-container">
        <div class="unit-list-header">
            <div class="unit-count">
                Hiển thị <span class="text-primary">1-10</span> trong tổng số <span class="text-primary">25</span> Đơn vị
            </div>
            <div class="view-options">
                <button type="button" class="active"><i class="fas fa-list"></i></button>
                <button type="button"><i class="fas fa-th-large"></i></button>
            </div>
        </div>

        <!-- Unit List Items -->
        <div class="unit-list">
            <!-- Unit Item 1 - Faculty -->
            @foreach ($departments as $department)
                <div class="unit-item">
                    @if($department->manager)
                    <div class="d-flex align-items-center">
                        @if($department->manager->avatar)
                            <img src="{{ asset('storage/avatars/'.$department->manager->avatar) }}" 
                                alt="{{ $department->manager->name }}" style="border-radius : 50%" 
                                class="unit-logo">
                        @else
                            <span class="avatar avatar-sm bg-primary text-white rounded-circle me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                {{ strtoupper(substr($department->manager->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                @else
                    <span class="text-muted"></span>
                @endif
                    <div class="unit-info">
                        <div class="unit-name">{{$department->name}}</div>
                        <div class="unit-type">Đơn vị đào tạo</div>
                        <div class="unit-meta">
                            <div class="unit-meta-item">
                                <i class="fas fa-user-tie"></i>
                                <span>
                                    Trưởng đơn vị: 
                                    @if ($department->manager && $department->manager->name)
                                        {{ $department->manager->name }}
                                    @endif
                                </span>
                                
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-users"></i>
                                <span>Số cán bộ: 45</span>
                            </div>
                            <div class="unit-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Cơ sở: Hà Nội</span>
                            </div>
                        </div>
                    </div>
                    <div class="unit-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#unitDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
           
            <!-- More units can be added here -->
        </div>

        @if ($departments->hasPages())
            <div class="pagination-container">
                <ul class="pagination">
                    {{-- Liên kết trang trước --}}
                    @if ($departments->onFirstPage())
                        <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                    @else
                        <li><a href="{{ $departments->previousPageUrl() }}"><i class="fas fa-angle-double-left"></i></a></li>
                    @endif

                    {{-- Các phần tử phân trang --}}
                    @foreach ($departments->getUrlRange(1, $departments->lastPage()) as $page => $url)
                        @if ($page == $departments->currentPage())
                            <li><a href="#" class="active">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Liên kết trang tiếp theo --}}
                    @if ($departments->hasMorePages())
                        <li><a href="{{ $departments->nextPageUrl() }}"><i class="fas fa-angle-double-right"></i></a></li>
                    @else
                        <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                    @endif
                </ul>
            </div>
        @endif
            </div>
        </div>
    </div>
</div>

<!-- Unit Detail Modal 1 -->
<div class="modal fade" id="unitDetailModal1" tabindex="-1" aria-labelledby="unitDetailModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unitDetailModalLabel1">Thông tin Chi tiết Đơn vị</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="unit-detail">
                    <!-- Unit Header -->
                    <div class="unit-detail-header">
                        <img src="https://via.placeholder.com/150x150?text=CNTT" alt="Khoa CNTT" class="unit-detail-logo">
                        <div class="unit-detail-title">
                            <div class="unit-detail-name">Khoa Công nghệ thông tin</div>
                            <div class="unit-detail-type">Đơn vị đào tạo</div>
                            <div class="unit-detail-meta">
                                <div class="unit-detail-meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Thành lập: 1999</span>
                                </div>
                                <div class="unit-detail-meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>Số cán bộ: 45</span>
                                </div>
                                <div class="unit-detail-meta-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Cơ sở: Hà Nội</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Description -->
                    <div class="unit-detail-section">
                        <div class="unit-detail-section-title">Giới thiệu</div>
                        <div class="unit-detail-description">
                            <p>Khoa Công nghệ thông tin được thành lập vào năm 1999, là một trong những khoa đầu tiên của Trường Đại học Thủy Lợi. Sau hơn 20 năm phát triển, Khoa đã khẳng định được vị thế là một trong những đơn vị đào tạo hàng đầu về Công nghệ thông tin tại Việt Nam.</p>
                            <p>Hiện nay, Khoa Công nghệ thông tin đào tạo các chuyên ngành: Công nghệ thông tin, Kỹ thuật phần mềm, Hệ thống thông tin, An toàn thông tin, Khoa học dữ liệu và Trí tuệ nhân tạo. Khoa cũng đào tạo ở các bậc: đại học, thạc sĩ và tiến sĩ.</p>
                            <p>Với đội ngũ giảng viên có trình độ cao, cơ sở vật chất hiện đại, Khoa Công nghệ thông tin cam kết đào tạo nguồn nhân lực chất lượng cao, đáp ứng nhu cầu của xã hội trong kỷ nguyên số.</p>
                        </div>
                    </div>

                    <!-- Leadership -->
                    <div class="unit-detail-section">
                        <div class="unit-detail-section-title">Ban lãnh đạo</div>
                        <div class="leader-list">
                            <div class="leader-item">
                                <img src="https://via.placeholder.com/150x150?text=Leader1" alt="Trưởng khoa" class="leader-avatar">
                                <div class="leader-info">
                                    <div class="leader-name">TS. Nguyễn Thanh Tùng</div>
                                    <div class="leader-position">Trưởng khoa</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <img src="https://via.placeholder.com/150x150?text=Leader2" alt="Phó trưởng khoa" class="leader-avatar">
                                <div class="leader-info">
                                    <div class="leader-name">TS. Phạm Tuấn Minh</div>
                                    <div class="leader-position">Phó Trưởng khoa</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <img src="https://via.placeholder.com/150x150?text=Leader3" alt="Phó trưởng khoa" class="leader-avatar">
                                <div class="leader-info">
                                    <div class="leader-name">PGS.TS. Hoàng Xuân Dậu</div>
                                    <div class="leader-position">Phó Trưởng khoa</div>
                                </div>
                            </div>
                            <div class="leader-item">
                                <img src="https://via.placeholder.com/150x150?text=Leader4" alt="Trợ lý khoa" class="leader-avatar">
                                <div class="leader-info">
                                    <div class="leader-name">ThS. Lê Thị Hương</div>
                                    <div class="leader-position">Trợ lý Khoa</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff List -->
                    <div class="unit-detail-section">
                        <div class="unit-detail-section-title">Bộ môn trực thuộc</div>
                        <div class="staff-list">
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=BM1" alt="Bộ môn" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Bộ môn Khoa học máy tính</div>
                                    <div class="staff-position">Trưởng BM: TS. Lê Văn Thịnh</div>
                                </div>
                            </div>
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=BM2" alt="Bộ môn" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Bộ môn Công nghệ phần mềm</div>
                                    <div class="staff-position">Trưởng BM: TS. Trần Thu Hà</div>
                                </div>
                            </div>
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=BM3" alt="Bộ môn" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Bộ môn Hệ thống thông tin</div>
                                    <div class="staff-position">Trưởng BM: PGS.TS. Nguyễn Hữu Quỳnh</div>
                                </div>
                            </div>
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=BM4" alt="Bộ môn" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Bộ môn Mạng và An toàn thông tin</div>
                                    <div class="staff-position">Trưởng BM: TS. Đoàn Văn Ban</div>
                                </div>
                            </div>
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=PTN" alt="Phòng thí nghiệm" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Phòng thí nghiệm CNTT</div>
                                    <div class="staff-position">Quản lý: ThS. Vũ Văn Thắng</div>
                                </div>
                            </div>
                            <div class="staff-item">
                                <img src="https://via.placeholder.com/150x150?text=VP" alt="Văn phòng" class="staff-avatar">
                                <div class="staff-info">
                                    <div class="staff-name">Văn phòng Khoa</div>
                                    <div class="staff-position">Nhân viên: 3 người</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="unit-detail-section">
                        <div class="unit-detail-section-title">Thông tin liên hệ</div>
                        <ul class="contact-info-list">
                            <li class="contact-info-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="contact-label">Địa chỉ:</span>
                                <span class="contact-value">Tầng 3, Nhà C5, Trường ĐH Thủy Lợi, 175 Tây Sơn, Đống Đa, Hà Nội</span>
                            </li>
                            <li class="contact-info-item">
                                <i class="fas fa-phone-alt"></i>
                                <span class="contact-label">Điện thoại:</span>
                                <span class="contact-value">(024) 3563 2211</span>
                            </li>
                            <li class="contact-info-item">
                                <i class="fas fa-envelope"></i>
                                <span class="contact-label">Email:</span>
                                <span class="contact-value">cntt@tlu.edu.vn</span>
                            </li>
                            <li class="contact-info-item">
                                <i class="fas fa-globe"></i>
                                <span class="contact-label">Website:</span>
                                <span class="contact-value"><a href="#" target="_blank">cse.tlu.edu.vn</a></span>
                            </li>
                            <li class="contact-info-item">
                                <i class="fab fa-facebook"></i>
                                <span class="contact-label">Facebook:</span>
                                <span class="contact-value"><a href="#" target="_blank">facebook.com/cse.tlu</a></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <a href="#" class="btn btn-primary">Xem trang Khoa CNTT</a>
            </div>
        </div>
    </div>
</div>

@endsection


@section('custom-js')
<script>
    $(document).ready(function(){
        // Biến để lưu trữ các tham số tìm kiếm hiện tại
        var currentSearch = "{{ $fullname ?? '' }}";
        // var currentClass = "{{ $class_id ?? 'all' }}";
        
        // Hàm chung để tải dữ liệu khi có thay đổi bất kỳ
        function loadData(options) {
            // Cập nhật các biến nếu có tham số tương ứng
            if (options.fullname !== undefined) {
                currentSearch = options.fullname;
            }
            // if (options.enrollment_year !== undefined) {
            //     currentYear = options.enrollment_year;
            // }
            
            // Xác định URL dựa trên loại hành động
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
            $(".department-list").addClass("loading");
            
            // Gửi yêu cầu Ajax
            $.ajax({
                url: url,
                type: "GET",
                data: data,
                success: function(response) {
                    $(".department-list").html(response).removeClass("loading");
                },
                error: function(xhr) {
                    console.error("Lỗi khi tải dữ liệu:", xhr.responseText);
                    $(".department-list").removeClass("loading");
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
        // $("#classSelect").change(function() {
        //     loadData({
        //         class_id: $(this).val()
        //     });
        // });
        
        // Xử lý sự kiện khi select khóa thay đổi
        // $("#yearSelect").change(function() {
        //     loadData({
        //         enrollment_year: $(this).val()
        //     });
        // });
        
        // Xử lý form tìm kiếm bằng Ajax
        $("#searchForm").submit(function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của form
            
            loadData({
                fullname: $("input[name='fullname']").val()
            });
        });
        
        // Xử lý phân trang bằng Ajax
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            
            var page = $(this).attr('href').split('page=')[1];
            
            loadData({
                page: page
            });
            
            // Cuộn lên đầu danh sách (tùy chọn)
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