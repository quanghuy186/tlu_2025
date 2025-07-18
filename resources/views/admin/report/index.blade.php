@extends('layouts.admin')

@section('content')
<div class="pagetitle">
  <h1>Quản lý báo cáo</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
      <li class="breadcrumb-item active">Báo cáo bài viết</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">

        <!-- Pending Reports Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card sales-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'pending']) }}">Hôm nay</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'pending', 'period' => 'month']) }}">Tháng này</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'pending', 'period' => 'year']) }}">Năm nay</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Báo cáo chờ xử lý <span>| Hôm nay</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $pendingCount }}</h6>
                  @if($pendingChange > 0)
                    <span class="text-danger small pt-1 fw-bold">{{ $pendingChange }}%</span> <span class="text-muted small pt-2 ps-1">tăng</span>
                  @elseif($pendingChange < 0)
                    <span class="text-success small pt-1 fw-bold">{{ abs($pendingChange) }}%</span> <span class="text-muted small pt-2 ps-1">giảm</span>
                  @else
                    <span class="text-muted small pt-1">không đổi</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Resolved Reports Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card revenue-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'resolved']) }}">Hôm nay</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'resolved', 'period' => 'month']) }}">Tháng này</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'resolved', 'period' => 'year']) }}">Năm nay</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Báo cáo đã xử lý <span>| Hôm nay</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $resolvedCount }}</h6>
                  @if($resolvedChange > 0)
                    <span class="text-success small pt-1 fw-bold">{{ $resolvedChange }}%</span> <span class="text-muted small pt-2 ps-1">tăng</span>
                  @elseif($resolvedChange < 0)
                    <span class="text-danger small pt-1 fw-bold">{{ abs($resolvedChange) }}%</span> <span class="text-muted small pt-2 ps-1">giảm</span>
                  @else
                    <span class="text-muted small pt-1">không đổi</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Rejected Reports Card -->
        <div class="col-xxl-4 col-md-4">
          <div class="card info-card customers-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'rejected']) }}">Hôm nay</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'rejected', 'period' => 'month']) }}">Tháng này</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'rejected', 'period' => 'year']) }}">Năm nay</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Báo cáo từ chối <span>| Hôm nay</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-x-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{ $rejectedCount }}</h6>
                  @if($rejectedChange > 0)
                    <span class="text-danger small pt-1 fw-bold">{{ $rejectedChange }}%</span> <span class="text-muted small pt-2 ps-1">tăng</span>
                  @elseif($rejectedChange < 0)
                    <span class="text-success small pt-1 fw-bold">{{ abs($rejectedChange) }}%</span> <span class="text-muted small pt-2 ps-1">giảm</span>
                  @else
                    <span class="text-muted small pt-1">không đổi</span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Reports List -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Danh sách báo cáo</h5>
                
                <div class="filter-container d-flex mb-3">
                  <div class="filter">
                    <a class="btn btn-sm btn-outline-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      @if($status == 'pending')
                        Chờ xử lý
                      @elseif($status == 'resolved')
                        Đã xử lý
                      @elseif($status == 'rejected')
                        Từ chối
                      @else
                        Tất cả
                      @endif
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'all']) }}">Tất cả</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'pending']) }}">Chờ xử lý</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'resolved']) }}">Đã xử lý</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.reports.index', ['status' => 'rejected']) }}">Từ chối</a></li>
                    </ul>
                  </div>

                  <!-- Search Form -->
                  {{-- <form action="{{ route('admin.reports.index') }}" method="GET" class="d-flex flex-grow-1">
                    <input type="hidden" name="status" value="{{ $status }}">
                    <div class="input-group input-group-sm">
                      <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Tìm kiếm...">
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                      </button>
                    </div>
                  </form> --}}
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Bài viết</th>
                      <th scope="col">Người báo cáo</th>
                      <th scope="col">Trạng thái</th>
                      <th scope="col">Ngày tạo</th>
                      <th scope="col">Hành động</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($reports as $report)
                      <tr>
                        <th scope="row">{{ $report->id }}</th>
                        <td>
                          <a href="{{ route('admin.forum.posts.show', $report->post_id) }}" target="_blank">
                            {{ Str::limit($report->post->title ?? 'Bài viết đã bị xóa', 30) }}
                          </a>
                        </td>
                        <td>{{ $report->user->name }}</td>
                        <td>{!! $report->status_badge !!}</td>
                        <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                          <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i>
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="6" class="text-center py-4">Không có báo cáo nào</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="d-flex justify-content-center mt-4">
                {{ $reports->appends(['status' => $status, 'search' => $search])->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

