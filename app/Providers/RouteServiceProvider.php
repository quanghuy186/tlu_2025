<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            // Load channels.php nếu tồn tại
            if (file_exists(base_path('routes/channels.php'))) {
                require base_path('routes/channels.php');
            }
        });
        
        // Nếu bạn muốn định nghĩa channels trực tiếp thay vì trong file
        // có thể gọi phương thức này ở đây
        // $this->registerChannels();
    }

    /**
     * Register the channels (tùy chọn).
     * Chỉ cần nếu bạn muốn định nghĩa channels trực tiếp trong provider
     * thay vì file channels.php
     */
    protected function registerChannels(): void
    {
        Broadcast::channel('messages.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });
        
        Broadcast::channel('typing.{id}', function ($user, $id) {
            return (int) $user->id === (int) $id;
        });
    }
}