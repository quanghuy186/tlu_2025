<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserHasRolePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return URL::route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);
        });

        // Gate::define('view-user', function(User $user) {
        //     return tluHasPermission($user,'view-user');
        // });

        // Gate::define('edit-user', function(User $user) {
        //     return tluHasPermission($user,'edit-user');
        // });

        // Gate::define('update-user', [UserHasRolePolicy::class,'update']);

        // Gate::define('view-contact-student');
    }
}
