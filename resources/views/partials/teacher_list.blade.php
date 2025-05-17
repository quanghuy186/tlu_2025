@foreach($teachers as $teacher)
                <div class="teacher-item">
                    <img src="{{ asset('storage/avatars/'.($teacher->user->avatar ?? 'default.png')) }}" alt="Giảng viên" class="teacher-avatar">
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
                    {{-- <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal1">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div> --}}

                    <div class="teacher-actions">
                        <a href="{{ route('messages.send') }}" class="action-btn">
                            <i class="fas fa-message"></i>
                        </a>
                    </div>


                    <div class="teacher-actions">
                        <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#teacherDetailModal{{ $teacher->id }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
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
                                    <img src="{{ asset('storage/avatars/'.($teacher->user->avatar ?? 'default.png')) }}" alt="Giảng viên" class="teacher-detail-avatar">
                                    <div class="teacher-detail-name">{{ $teacher->user->name ?? 'Chưa cập nhật' }}</div>
                                    <div class="teacher-detail-position">{{ $teacher->position ?? 'Chưa cập nhật' }}</div>
            
                                    <ul class="teacher-detail-info">
                                        <li>
                                            <i class="fas fa-id-card"></i>
                                            <span class="detail-label">Mã cán bộ:</span>
                                            <span class="detail-value">{{ $teacher->code ?? 'Chưa cập nhật' }}</span>
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
                    {{-- Liên kết trang trước --}}
                    @if ($teachers->onFirstPage())
                        <li><a href="#"><i class="fas fa-angle-double-left"></i></a></li>
                    @else
                        <li><a href="#" class="page-link" data-page="{{ $teachers->currentPage() - 1 }}">
                            <i class="fas fa-angle-double-left"></i>
                        </a></li>
                    @endif

                    {{-- Các phần tử phân trang --}}
                    @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
                        @if ($page == $teachers->currentPage())
                                <li><a href="#" class="active">{{ $page }}</a></li>
                        @else
                                <li><a href="#" class="page-link" data-page="{{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Liên kết trang tiếp theo --}}
                    @if ($teachers->hasMorePages())
                        <li><a href="#" class="page-link" data-page="{{ $teachers->currentPage() + 1 }}">
                            <i class="fas fa-angle-double-right"></i>
                        </a></li>
                    @else
                        <li><a href="#"><i class="fas fa-angle-double-right"></i></a></li>
                    @endif
                </ul>
            </div>
            @endif