<?php

use App\Http\Controllers\POS;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;

Route::domain('pos.' . parse_url(config('app.url'))['host'])->name('pos.')->group(function () {
    Route::name('auth.')->prefix('/auth')->controller(POS\AuthController::class)->middleware('guest:employee')->group(function () {
        Route::get('/login', 'showLoginForm')->name('show-login-form');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout')->withoutMiddleware('guest:employee');
    });

    Route::middleware('auth:employee')->group(function () {
        Route::get('/', POS\HomeController::class)->name('home');

        Route::name('orders.')->prefix('/orders')->controller(POS\OrderController::class)->group(function () {
            Route::get('/', 'index')->name('index');

            Route::get('/{order}/pickup-label.pdf', function (Order $order) {
                return Pdf::view('labels.pickup', compact('order'))
                    ->paperSize(4, 2.25, 'in')
                    ->orientation(Orientation::Landscape)
                    ->withBrowsershot(function (Browsershot $browsershot) {

                    });
            });
        });

        Route::name('users.')->prefix('/users')->controller(POS\UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
        });

        Route::get('/metrics', POS\MetricController::class)->name('metrics');

        Route::get('/activity', POS\ActivityController::class)->name('activity');
    });
});
