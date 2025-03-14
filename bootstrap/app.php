<?php

use App\Http\Middleware\EnsureUserOnboarded;
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
        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PORT | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_AWS_ELB);

        $middleware->alias([
            'onboarded' => EnsureUserOnboarded::class,
        ]);

        $middleware->redirectTo(
            guests: function (Request $request) {
                if ($request->routeIs('pos.*')) {
                    return route('pos.auth.show-login-form');
                } else {
                    return route('storefront.auth.login');
                }
            },
            users: function (Request $request) {
                if ($request->user('employee') !== null) {
                    return route('pos.home');
                } else {
                    return route('storefront.home');
                }
            },
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
