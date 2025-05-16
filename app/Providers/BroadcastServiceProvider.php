<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        // Define broadcast channels
        $this->registerChannels();
    }

    /**
     * Register the channels.
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