{{-- resources/views/partials/student_list.blade.php --}}
@foreach ($students as $student)
    <div class="student-item">
        <img src="{{ $student->user && $student->user->avatar ? asset('storage/avatars/'.$student->user->avatar) :  asset('user_default.jpg') }}" 
            alt="Sinh viên" class="student-avatar">
        <div class="student-info">
            <div class="student-name">{{ $student->user->name ?? 'Chưa cập nhật' }}</div>
            <div class="student-id">
                {{ $student->class ? $student->class->name : 'Chưa cập nhật' }} - 
                {{ $student->student_code ?? 'Chưa cập nhật' }}
            </div>
            <div class="student-class">
                Lớp: 
                @if($student->class)
                    <a href="#">{{ $student->class->name ?? 'Chưa cập nhật' }}</a>
                @else
                    <span>Chưa cập nhật</span>
                @endif
                - 
                @if($student->department)
                    {{ $student->department->name }}
                @else
                    Chưa cập nhật
                @endif
            </div>
        </div>
        <div class="student-actions mx-3">
            <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#studentDetailModal{{ $student->id }}">
                <i class="fas fa-eye"></i>
            </a>
        </div>

        <div class="student-actions">
            <a href="{{ route('chat.start', $student->user->id) }}" class="action-btn">
                <i class="fas fa-message"></i>
            </a>
        </div>

    </div>

    <!-- Student Detail Modal -->
    <div class="modal fade" id="studentDetailModal{{ $student->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thông tin Sinh viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="student-detail">
                        <img src="{{ $student->user && $student->user->avatar ? asset('storage/avatars/'.$student->user->avatar) : asset('user_default.jpg') }}" 
                            alt="Sinh viên" class="student-detail-avatar">
                        <div class="student-detail-name">{{ $student->user->name ?? 'Chưa cập nhật' }}</div>
                        <div class="student-detail-id">{{ $student->student_code ?? 'Chưa cập nhật' }}</div>

                        <ul class="student-detail-info">
                            <li>
                                <i class="fas fa-graduation-cap"></i>
                                <span class="detail-label">Lớp:</span>
                                <span class="detail-value">{{ $student->class ? $student->class->name : 'Chưa cập nhật' }}</span>
                            </li>
                            <li>
                                <i class="fas fa-user-graduate"></i>
                                <span class="detail-label">Khóa:</span>
                                <span class="detail-value">
                                    @if($student->enrollment_year)
                                        K{{ $student->enrollment_year - 1957 }} ({{ $student->enrollment_year }}-{{ $student->enrollment_year + 4 }})
                                    @else
                                        Chưa cập nhật
                                    @endif
                                </span>
                            </li>
                            <li>
                                <i class="fas fa-building"></i>
                                <span class="detail-label">Khoa:</span>
                                <span class="detail-value">
                                    @if($student->department)
                                        <a href="#">{{ $student->department->name }}</a>
                                    @else
                                        Chưa cập nhật
                                    @endif
                                </span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $student->user->email ?? 'Chưa cập nhật' }}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span class="detail-label">Điện thoại:</span>
                                <span class="detail-value">{{ $student->phone ?? 'Chưa cập nhật' }}</span>
                            </li>
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="detail-label">Địa chỉ:</span>
                                <span class="detail-value">{{ $student->address ?? 'Chưa cập nhật' }}</span>
                            </li>
                            <li>
                                <i class="fas fa-calendar-alt"></i>
                                <span class="detail-label">Ngày sinh:</span>
                                <span class="detail-value">{{ $student->birthday ? date('d/m/Y', strtotime($student->birthday)) : 'Chưa cập nhật' }}</span>
                            </li>
                            <li>
                                <i class="fas fa-id-card"></i>
                                <span class="detail-label">CCCD:</span>
                                <span class="detail-value">{{ $student->id_card ?? 'Chưa cập nhật' }}</span>
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


{{-- Bao gồm điều khiển phân trang ở đây --}}

@if ($students->hasPages())
<div class="pagination-container">
    <ul class="pagination">
        {{-- Nút First --}}
        @if ($students->currentPage() > 1)
            <li><a href="#" class="page-link" data-page="1">
                <i class="fas fa-angle-double-left"></i>
            </a></li>
        @endif

        {{-- Nút Previous --}}
        @if ($students->onFirstPage())
            <li class="disabled"><span><i class="fas fa-angle-left"></i></span></li>
        @else
            <li><a href="#" class="page-link" data-page="{{ $students->currentPage() - 1 }}">
                <i class="fas fa-angle-left"></i>
            </a></li>
        @endif

        {{-- Logic hiển thị số trang thông minh --}}
        @php
            $currentPage = $students->currentPage();
            $lastPage = $students->lastPage();
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
        @if ($students->hasMorePages())
            <li><a href="#" class="page-link" data-page="{{ $students->currentPage() + 1 }}">
                <i class="fas fa-angle-right"></i>
            </a></li>
        @else
            <li class="disabled"><span><i class="fas fa-angle-right"></i></span></li>
        @endif

        {{-- Nút Last --}}
        @if ($students->currentPage() < $students->lastPage())
            <li><a href="#" class="page-link" data-page="{{ $students->lastPage() }}">
                <i class="fas fa-angle-double-right"></i>
            </a></li>
        @endif
    </ul>
    
    {{-- Hiển thị thông tin trang --}}
    <div class="pagination-info">
        Hiển thị {{ $students->firstItem() }} - {{ $students->lastItem() }} 
        của {{ $students->total() }} kết quả
        (Trang {{ $students->currentPage() }}/{{ $students->lastPage() }})
    </div>
</div>
@endif