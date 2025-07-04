<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\Authenticate;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [

        ]);

        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'web' => \App\Http\Middleware\UpdateLastSeen::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'censor' => \App\Http\Middleware\CensorMiddleware::class,
            'manager_admin' => \App\Http\Middleware\ManagerAdminMiddleware::class,
            'redirect_admin' => \App\Http\Middleware\RedirectAdmin::class,
            'redirect_censor' => \App\Http\Middleware\RedirectCensorMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();