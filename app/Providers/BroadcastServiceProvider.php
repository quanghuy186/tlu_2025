<?php

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
  
    public function boot()
    {
        Broadcast::routes(['middleware' => ['auth']]);
        require base_path('routes/channels.php');
    }
}