@foreach($teachers as $teacher)
    <div class="teacher-item">
        <img src="{{ $teacher->user && $teacher->user->avatar ? asset('storage/avatars/'.$teacher->user->avatar) : asset('user_default.jpg') }}" alt="Giảng viên" class="teacher-avatar">
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

        <div class="mx-3 teacher-actions">
            <a href="{{ route('chat.start', $teacher->user->id) }}" class="action-btn">
                <i class="fas fa-message"></i>
            </a>
        </div>

        @can('view-detail-teacher', $teacher)
            <div class="teacher-actions">
                <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal{{ $teacher->id }}">
                    <i class="fas fa-eye"></i>
                </a>
            </div>
        @endcan
        
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
                        <img src="{{ $teacher->user && $teacher->user->avatar ? asset('storage/avatars/'.$teacher->user->avatar) : asset('user_default.jpg') }}" alt="Giảng viên" class="teacher-detail-avatar">
                        <div class="teacher-detail-name">{{ $teacher->user->name ?? 'Chưa cập nhật' }}</div>
                        <div class="teacher-detail-position">{{ $teacher->position ?? 'Chưa cập nhật' }}</div>

                        <ul class="teacher-detail-info">
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">Mã cán bộ:</span>
                                <span class="detail-value">{{ $teacher->teacher_code ?? 'Chưa cập nhật' }}</span>
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
                                <i class="fas fa-graduation-cap"></i>
                                <span class="detail-label">Học hàm/Học vị:</span>
                                <span class="detail-value">{{ $teacher->academic_rank ?? 'Chưa cập nhật' }}</span>
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
@endforeach

@if ($teachers->hasPages())
<div class="pagination-container">
    <ul class="pagination">
        {{-- Nút First --}}
        @if ($teachers->currentPage() > 1)
            <li><a href="#" class="page-link" data-page="1">
                <i class="fas fa-angle-double-left"></i>
            </a></li>
        @endif

        {{-- Nút Previous --}}
        @if ($teachers->onFirstPage())
            <li class="disabled"><span><i class="fas fa-angle-left"></i></span></li>
        @else
            <li><a href="#" class="page-link" data-page="{{ $teachers->currentPage() - 1 }}">
                <i class="fas fa-angle-left"></i>
            </a></li>
        @endif

        {{-- Logic hiển thị số trang thông minh --}}
        @php
            $currentPage = $teachers->currentPage();
            $lastPage = $teachers->lastPage();
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
            
            // Điều chỉnh để luôn hiển thị 5 trang nếu có thể
            if ($end - $start < 4) {
                if ($start == 1) {
                    $end = min($lastPage, $start + 4);
                } else {
                    $start = max(1, $end - 4);
                }
            }
        @endphp

        {{-- Hiển thị trang đầu và dấu ... nếu cần --}}
        @if ($start > 1)
            <li><a href="#" class="page-link" data-page="1">1</a></li>
            @if ($start > 2)
                <li class="disabled"><span>...</span></li>
            @endif
        @endif

        {{-- Hiển thị các trang trong khoảng --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <li><a href="#" class="active">{{ $page }}</a></li>
            @else
                <li><a href="#" class="page-link" data-page="{{ $page }}">{{ $page }}</a></li>
            @endif
        @endfor

        {{-- Hiển thị dấu ... và trang cuối nếu cần --}}
        @if ($end < $lastPage)
            @if ($end < $lastPage - 1)
                <li class="disabled"><span>...</span></li>
            @endif
            <li><a href="#" class="page-link" data-page="{{ $lastPage }}">{{ $lastPage }}</a></li>
        @endif

        {{-- Nút Next --}}
        @if ($teachers->hasMorePages())
            <li><a href="#" class="page-link" data-page="{{ $teachers->currentPage() + 1 }}">
                <i class="fas fa-angle-right"></i>
            </a></li>
        @else
            <li class="disabled"><span><i class="fas fa-angle-right"></i></span></li>
        @endif

        {{-- Nút Last --}}
        @if ($teachers->currentPage() < $teachers->lastPage())
            <li><a href="#" class="page-link" data-page="{{ $teachers->lastPage() }}">
                <i class="fas fa-angle-double-right"></i>
            </a></li>
        @endif
    </ul>
    
    {{-- Hiển thị thông tin trang --}}
    <div class="pagination-info">
        Hiển thị {{ $teachers->firstItem() }} - {{ $teachers->lastItem() }} 
        của {{ $teachers->total() }} kết quả
        (Trang {{ $teachers->currentPage() }}/{{ $teachers->lastPage() }})
    </div>
</div>
@endif