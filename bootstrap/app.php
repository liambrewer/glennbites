<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Models\Employee;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->redirectTo(
            guests: function (Request $request) {
                if ($request->routeIs('pos.*')) {
                    return route('pos.auth.show-login-form');
                } else {
                    return route('home');
                }
            },
            users: function (Request $request) {
                if ($request->user('employee') !== null) {
                    return route('pos.home');
                } else {
                    return route('home');
                }
            },
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
