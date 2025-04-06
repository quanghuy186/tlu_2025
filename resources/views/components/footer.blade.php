<footer>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-about">
                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Thuy-Loi.png" alt="Logo TLU" class="img-fluid">
                    <p>Danh bạ điện tử Trường Đại học Thủy Lợi cung cấp thông tin liên lạc chính thức của các đơn vị, cán bộ, giảng viên và sinh viên trong trường, đảm bảo tính bảo mật và chính xác.</p>
                    <div class="social-links">
                        <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="footer-links">
                    <h5 class="footer-title">Liên kết nhanh</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Trang chủ</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Đơn vị</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Giảng viên</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Sinh viên</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Thông báo</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Liên hệ</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-sm-6 col-lg-2">
                <div class="footer-links">
                    <h5 class="footer-title">Người dùng</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Tài khoản</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Đổi mật khẩu</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Quản lý thông tin</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Cập nhật liên hệ</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Trợ giúp</a></li>
                        <li><a href="#"><i class="fas fa-chevron-right me-2"></i> Chính sách bảo mật</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="footer-contact">
                    <h5 class="footer-title">Liên hệ</h5>
                    <div class="mb-3">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>175 Tây Sơn, Đống Đa, Hà Nội</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-phone-alt"></i>
                        <span>(024) 3852 2201</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-envelope"></i>
                        <span>info@tlu.edu.vn</span>
                    </div>
                    <div class="mb-3">
                        <i class="fas fa-globe"></i>
                        <span>www.tlu.edu.vn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">© 2025 Trường Đại học Thủy Lợi. Bản quyền thuộc về Đại học Thủy Lợi.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

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
</body>
</html>
