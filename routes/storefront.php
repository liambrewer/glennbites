<?php

use App\Http\Controllers\Storefront\AuthController;
use App\Http\Controllers\Storefront\ProductsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::domain(parse_url(config('app.url'))['host'])->name('storefront.')->group(function () {
    Route::controller(AuthController::class)->name('auth.')->group(function () {
        Route::middleware(['guest:web'])->group(function () {
            Route::get('login', 'showLoginForm')->name('show-login-form');
            Route::post('login', 'sendLoginLink')->name('send-login-link');

            Route::get('login/{token}', 'handleLoginLink')->name('handle-login-link');

            Route::get('register', 'showRegisterForm')->name('show-register-form');
            Route::post('register', 'completeRegistration')->name('complete-registration');
        });

        Route::middleware(['auth:web'])->group(function () {
            Route::post('logout', 'logout')->name('logout');
        });
    });

    Route::middleware(['auth:web'])->group(function () {
        Route::redirect('/', '/products')->name('home');

        Route::controller(ProductsController::class)->prefix('/products')->name('products.')->group(function () {
            Route::get('/', 'index')->name('index');
        });
    });
});
