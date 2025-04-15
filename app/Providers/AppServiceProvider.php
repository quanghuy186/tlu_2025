<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserHasRolePolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

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
        ResetPassword::createUrlUsing(function ($user, string $token) {
            return URL::route('password.reset', [
                'token' => $token,
                'email' => $user->email,
            ]);
        });

        Gate::define('view-user', function(User $user) {
            return tluHasPermission($user,'view-user');
        });

        Gate::define('edit-user', function(User $user) {
            return tluHasPermission($user,'edit-user');
        });

        //dinh nghia với policy
        Gate::define('update-user', [UserHasRolePolicy::class,'update']);
    }
}
