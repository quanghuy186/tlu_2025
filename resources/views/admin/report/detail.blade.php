@extends('layouts.admin')

@section('content')
<div class="pagetitle">
  <h1>Chi tiết báo cáo</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
      <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Báo cáo bài viết</a></li>
      <li class="breadcrumb-item active">Chi tiết báo cáo #{{ $report->id }}</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Thông tin báo cáo</h5>
          
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h4>Báo cáo #{{ $report->id }}</h4>
              <p class="text-muted mb-0">Đã tạo: {{ $report->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>{!! $report->status_badge !!}</div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-3 fw-bold">Người báo cáo:</div>
            <div class="col-md-9">{{ $report->post->author->name }}</div>
          </div>
          
          <div class="row mb-3">
            <div class="col-md-3 fw-bold">Bài viết:</div>
            <div class="col-md-9">
              @if($report->post)
                <a href="{{ route('admin.forum.posts.show', $report->post_id) }}" target="_blank">
                  {{ $report->post->title }}
                </a>
              @else
                <span class="text-muted">Bài viết đã bị xóa</span>
              @endif
            </div>
          </div>
          
          <div class="row mb-4">
            <div class="col-md-3 fw-bold">Lý do báo cáo:</div>
            <div class="col-md-9">
              <div class="p-3 bg-light rounded">
                {!! nl2br(e($report->reason)) !!}
              </div>
            </div>
          </div>
          
          @if($report->status !== 'pending')
            <div class="row mb-3">
              <div class="col-md-3 fw-bold">Ngày xử lý:</div>
              <div class="col-md-9">{{ $report->updated_at->format('d/m/Y H:i') }}</div>
            </div>
            
            @if($report->notes)
              <div class="row mb-4">
                <div class="col-md-3 fw-bold">Ghi chú:</div>
                <div class="col-md-9">
                  <div class="p-3 bg-light rounded">
                    {!! nl2br(e($report->notes)) !!}
                  </div>
                </div>
              </div>
            @endif
          @endif
          
          @if($report->status === 'pending')
            <form action="{{ route('admin.reports.resolve', ['report' => $report->id]) }}" method="POST">
              @csrf
              <div class="row mb-3">
                <div class="col-md-12">
                  <label for="notes" class="form-label fw-bold">Ghi chú của admin</label>
                  <textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
                </div>
              </div>
              
              <div class="row">
                <div class="col-md-12">
                  <button type="submit" name="action" value="resolve" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i> Đánh dấu đã xử lý
                  </button>
                  <button type="submit" name="action" value="reject" class="btn btn-warning ms-2">
                    <i class="bi bi-x-circle me-1"></i> Từ chối báo cáo
                  </button>
                  @if($report->post)
                    <button type="submit" name="action" value="delete_post" class="btn btn-danger ms-2" 
                            onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này? Hành động này không thể hoàn tác.')">
                      <i class="bi bi-trash me-1"></i> Xóa bài viết
                    </button>
                  @endif
                </div>
              </div>
            </form>
          @else
            <div class="row">
              <div class="col-md-12">
                <a href="{{ route('admin.reports.index') }}" class="btn btn-primary">
                  <i class="bi bi-arrow-left me-1"></i> Quay lại danh sách
                </a>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      @if($report->post)
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Nội dung bài viết</h5>
            
            <div class="post-preview">
              <h6>{{ $report->post->title }}</h6>
              <p class="text-muted small">
                Đăng bởi: {{ $report->post->author->name }} - 
                
                {{ $report->post->created_at->format('d/m/Y H:i') }}
              </p>
              
              <div class="post-content mb-3">
                {!! Str::limit(strip_tags($report->post->content), 300) !!}
                @if(strlen(strip_tags($report->post->content)) > 300)
                  <a href="{{ route('admin.forum.posts.show', $report->post_id) }}" target="_blank" class="text-primary">Xem thêm</a>
                @endif
              </div>
              
              <a href="{{ route('admin.forum.posts.show', $report->post_id) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-eye me-1"></i> Xem bài viết
              </a>
            </div>
          </div>
        </div>
      @endif
      
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Người báo cáo</h5>
          
          <div class="user-info">
            <div class="d-flex align-items-center mb-3">
              <div class="user-avatar me-3">
                <img src="{{ $report->user->avatar ?? asset('assets/img/default-avatar.png') }}" 
                     alt="{{ $report->user->name }}" 
                     class="rounded-circle" 
                     width="50" height="50">
              </div>
              <div>
                <h6 class="mb-0">{{ $report->user->name }}</h6>
                <p class="text-muted mb-0 small">{{ $report->user->email }}</p>
              </div>
            </div>
            
            <div class="user-stats d-flex flex-wrap">
              <div class="stat-item me-4 mb-2">
                <span class="d-block text-muted small">Ngày tham gia</span>
                <span class="fw-semibold">{{ $report->user->created_at->format('d/m/Y') }}</span>
              </div>
              
              <div class="stat-item me-4 mb-2">
                <span class="d-block text-muted small">Số báo cáo</span>
                <span class="fw-semibold">{{ $report->user->reports()->count() }}</span>
              </div>
            </div>
            
            <a href="{{ route('admin.user.detail', $report->user->id) }}" class="btn btn-sm btn-outline-primary mt-2">
              <i class="bi bi-person me-1"></i> Xem hồ sơ
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection