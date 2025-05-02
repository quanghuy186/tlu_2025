@include('components.header')

@include('components.nav')

@yield('content')

@include('components.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        document.getElementById('openProfileModal').addEventListener('click', function(e) {
            e.preventDefault();
            var userModal = new bootstrap.Modal(document.getElementById('userInfoModal'));
            userModal.show();
        });
    });
</script>

{{-- teacher --}}
<!-- Bootstrap & JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Đây là nơi để thiết lập logic hiển thị quyền truy cập phù hợp
        // Đoạn code bên dưới có thể được sửa đổi dựa trên logic xác thực thực tế

        // Ví dụ: Kiểm tra vai trò người dùng
        const userRole = 'cbgv'; // Giả sử vai trò là 'cbgv' hoặc 'student'

        // Hiển thị nội dung phù hợp dựa trên vai trò
        if (userRole === 'cbgv') {
            document.getElementById('cbgv-access').style.display = 'block';
            document.getElementById('student-access').style.display = 'none';
        } else if (userRole === 'student') {
            document.getElementById('cbgv-access').style.display = 'none';
            document.getElementById('student-access').style.display = 'block';
        }

        // Khởi tạo tooltips nếu cần
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Xử lý sự kiện tìm kiếm
        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box button');

        searchButton.addEventListener('click', function() {
            const searchValue = searchInput.value.trim().toLowerCase();
            searchTeachers(searchValue);
        });

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const searchValue = searchInput.value.trim().toLowerCase();
                searchTeachers(searchValue);
            }
        });

        // Hàm tìm kiếm giảng viên (mô phỏng)
        function searchTeachers(query) {
            console.log('Tìm kiếm giảng viên với từ khóa:', query);
            // Thực hiện logic tìm kiếm thực tế ở đây
            // Ví dụ: gửi AJAX request đến server
        }

        // Xử lý sự kiện thay đổi bộ lọc
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        // Hàm áp dụng bộ lọc (mô phỏng)
        function applyFilters() {
            const sortBy = document.querySelector('select[class="filter-select"]:nth-child(1)').value;
            const department = document.querySelector('select[class="filter-select"]:nth-child(2)').value;
            const position = document.querySelector('select[class="filter-select"]:nth-child(3)').value;

            console.log('Áp dụng bộ lọc:', { sortBy, department, position });
            // Thực hiện logic lọc thực tế ở đây
        }

        // Xử lý chuyển đổi kiểu xem
        const viewButtons = document.querySelectorAll('.view-options button');
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Thay đổi kiểu xem (danh sách hoặc lưới)
                const isList = this.querySelector('i').classList.contains('fa-list');
                if (isList) {
                    document.querySelector('.teacher-list').classList.remove('grid-view');
                } else {
                    document.querySelector('.teacher-list').classList.add('grid-view');
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Thiết lập phân quyền truy cập dựa trên vai trò người dùng
        const userRole = 'cbgv'; // Có thể là 'cbgv' hoặc 'student'
        const studentClass = '62CNTT1'; // Lớp của sinh viên hiện tại

        // Hiển thị phù hợp dựa trên vai trò
        if (userRole === 'cbgv') {
            // CBGV có thể xem tất cả thông tin
            document.getElementById('cbgv-access').style.display = 'block';
            document.getElementById('student-access').style.display = 'none';
        } else if (userRole === 'student') {
            // Sinh viên chỉ xem được danh sách sinh viên cùng lớp
            document.getElementById('cbgv-access').style.display = 'none';
            document.getElementById('student-access').style.display = 'block';
        }

        // Xử lý chuyển đổi kiểu xem
        const viewOptionButtons = document.querySelectorAll('.view-options button');
        const studentLists = document.querySelectorAll('.student-list');

        viewOptionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Cập nhật trạng thái active
                viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Thay đổi kiểu xem
                const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                studentLists.forEach(list => {
                    if (isGridView) {
                        list.classList.add('grid-view');
                    } else {
                        list.classList.remove('grid-view');
                    }
                });
            });
        });

        // Xử lý tìm kiếm
        const searchInputs = document.querySelectorAll('.search-box input');
        const searchButtons = document.querySelectorAll('.search-box button');

        searchInputs.forEach((input, index) => {
            const button = searchButtons[index];

            input.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    performSearch(input.value);
                }
            });

            button.addEventListener('click', function() {
                performSearch(input.value);
            });
        });

        function performSearch(query) {
            query = query.trim().toLowerCase();
            console.log('Đang tìm kiếm: ' + query);
            // Thực hiện tìm kiếm tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
        }

        // Xử lý bộ lọc
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            // Thu thập tất cả các giá trị bộ lọc
            const filters = {};
            filterSelects.forEach(select => {
                const filterName = select.previousElementSibling.textContent.trim().replace(':', '').toLowerCase();
                filters[filterName] = select.value;
            });

            console.log('Đang áp dụng bộ lọc:', filters);
            // Áp dụng bộ lọc tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý chuyển đổi kiểu xem
        const viewOptionButtons = document.querySelectorAll('.view-options button');
        const unitList = document.querySelector('.unit-list');

        viewOptionButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Cập nhật trạng thái active
                viewOptionButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Thay đổi kiểu xem
                const isGridView = this.querySelector('i').classList.contains('fa-th-large');
                if (isGridView) {
                    unitList.classList.add('grid-view');
                } else {
                    unitList.classList.remove('grid-view');
                }
            });
        });

        // Xử lý tìm kiếm
        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box button');

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch(searchInput.value);
            }
        });

        searchButton.addEventListener('click', function() {
            performSearch(searchInput.value);
        });

        function performSearch(query) {
            query = query.trim().toLowerCase();
            console.log('Đang tìm kiếm: ' + query);
            // Thực hiện tìm kiếm tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
        }

        // Xử lý bộ lọc
        const filterSelects = document.querySelectorAll('.filter-select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                applyFilters();
            });
        });

        function applyFilters() {
            // Thu thập tất cả các giá trị bộ lọc
            const filters = {};
            filterSelects.forEach(select => {
                const filterName = select.previousElementSibling.textContent.trim().replace(':', '').toLowerCase();
                filters[filterName] = select.value;
            });

            console.log('Đang áp dụng bộ lọc:', filters);
            // Áp dụng bộ lọc tại đây (gửi yêu cầu Ajax hoặc lọc dữ liệu hiện có)
        }
    });
</script>



</body>
</html>
