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
            <a href="{{ route('chat.start', $department->manager->id) }}" class="action-btn">
                <i class="fas fa-message"></i>
            </a>
        </div>

        <div class="unit-actions mx-3">
            <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#unitDetailModal{{ $department->id }}">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>

    <div class="modal fade" id="unitDetailModal{{ $department->id }}" tabindex="-1" aria-labelledby="unitDetailModalLabel{{ $department->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unitDetailModalLabel{{ $department->id }}">Thông tin Chi tiết Đơn vị</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="unit-detail">
                        <!-- Unit Header -->
                        <div class="unit-detail-header">
                            <img src="https://via.placeholder.com/150x150?text=CNTT" alt="{{ $department->name }}" class="unit-detail-logo">
                            <div class="unit-detail-title">
                                <div class="unit-detail-name">{{ $department->name }}</div>
                                <div class="unit-detail-type">Đơn vị đào tạo</div>
                                <div class="unit-detail-meta">
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Thành lập: 1958</span>
                                    </div>
                                    <div class="unit-detail-meta-item">
                                        <i class="fas fa-users"></i>
                                        <span>Số cán bộ: 45</span>
                                    </div>
                                    {{-- <div class="unit-detail-meta-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>Cơ sở: Hà Nội</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <!-- Unit Description -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Giới thiệu</div>
                            <div class="unit-detail-description">
                                <p>{{ $department->description }}</p>
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

                       
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Bộ môn trực thuộc</div>
                            <div class="staff-list">
                                @foreach ($department->children as $child)
                                    <div class="staff-item">
                                        <img src="https://via.placeholder.com/150x150?text=BM1" alt="Bộ môn" class="staff-avatar">
                                        <div class="staff-info">
                                            <div class="staff-name">{{ $child->name }}</div>
                                            <div class="staff-position">Trưởng BM: TS. Lê Văn Thịnh</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="unit-detail-section">
                            <div class="unit-detail-section-title">Thông tin liên hệ</div>
                            <ul class="contact-info-list">
                                <li class="contact-info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span class="contact-label">Địa chỉ:</span>
                                    <span class="contact-value">{{ $department->address }}</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="contact-label">Điện thoại:</span>
                                    <span class="contact-value">{{ $department->phone }}</span>
                                </li>
                                <li class="contact-info-item">
                                    <i class="fas fa-envelope"></i>
                                    <span class="contact-label">Email:</span>
                                    <span class="contact-value">{{ $department->email }}</span>
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
                    <a href="#" class="btn btn-primary">Xem trang {{ $department->name }}</a>
                </div>
            </div>
        </div>
    </div>
@endforeach

            
{{-- Phân trang --}}
@if ($departments->hasPages())
<div class="pagination-container">
    <ul class="pagination">
        {{-- Liên kết trang trước --}}
        @if ($departments->onFirstPage())
            <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
        @else
            <li><a href="#" class="page-link" data-page="{{ $departments->currentPage() - 1 }}">
                <i class="fas fa-angle-double-left"></i>
            </a></li>
        @endif

        {{-- Các phần tử phân trang --}}
        @foreach ($departments->getUrlRange(1, $departments->lastPage()) as $page => $url)
            @if ($page == $departments->currentPage())
                <li><a href="#" class="active">{{ $page }}</a></li>
            @else
                <li><a href="#" class="page-link" data-page="{{ $page }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Liên kết trang tiếp theo --}}
        @if ($departments->hasMorePages())
            <li><a href="#" class="page-link" data-page="{{ $departments->currentPage() + 1 }}">
                <i class="fas fa-angle-double-right"></i>
            </a></li>
        @else
            <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
        @endif
    </ul>
</div>
@endif