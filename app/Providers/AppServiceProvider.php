<?php

namespace App\Providers;

use App\Models\ForumPost;
use App\Models\User;
use App\Policies\DepartmentPolicy;
use App\Policies\ForumCommentPolicy;
use App\Policies\ForumPostPolicy;
use App\Policies\StudentPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\UserHasRolePolicy;
use App\Policies\NotiticationPolicy;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        Carbon::setLocale('vi');

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return URL::route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);
        });

        Gate::define('view-detail-teacher', [TeacherPolicy::class, 'view']);
        Gate::define('view-detail-student', [StudentPolicy::class, 'view']);
        Gate::define('view-detail-department', [DepartmentPolicy::class, 'view']);
        Gate::define('create-notification', [NotiticationPolicy::class, 'create']);
        Gate::define('show-anonymously', [ForumPostPolicy::class, 'view']);
        Gate::define('show-anonymously-comment', [ForumCommentPolicy::class, 'view']);
    }
}
