@extends('layouts.email')

@section('content')
<div class="auth-card card">
    <div class="auth-header">
        <h4 class="mb-0">{{ __('Quên mật khẩu') }}</h4>
    </div>
    <div class="card-body p-4">
        <div class="mb-4 text-muted">
            {{ __('Quên mật khẩu? Không vấn đề gì. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu qua email để bạn có thể chọn một mật khẩu mới.') }}
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>{{ __('Gửi liên kết đặt lại mật khẩu') }}
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-1"></i>{{ __('Quay lại đăng nhập') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
