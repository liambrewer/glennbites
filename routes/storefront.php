<?php

use App\Http\Controllers\Storefront\AuthController;
use App\Http\Controllers\Storefront\OnboardingController;
use App\Http\Controllers\Storefront\ProductsController;
use Illuminate\Support\Facades\Route;

Route::domain(parse_url(config('app.url'))['host'])->name('storefront.')->group(function () {
    Route::controller(AuthController::class)->name('auth.')->group(function () {
        Route::middleware(['guest:web'])->group(function () {
            Route::get('login', 'showLoginForm')->name('show-login-form');
            Route::post('login', 'sendOneTimePassword')->name('send-one-time-password');

            Route::get('login/{otp}', 'showOneTimePasswordForm')->name('show-one-time-password-form');
            Route::post('login/{id}', 'attemptOneTimePassword')->name('attempt-one-time-password');
        });

        Route::middleware(['auth:web'])->group(function () {
            Route::post('logout', 'logout')->name('logout');
        });
    });

    Route::middleware(['auth:web'])->group(function () {
        Route::middleware(['onboarded:false'])->controller(OnboardingController::class)->name('onboarding.')->group(function () {
            Route::get('onboarding', 'showOnboardingForm')->name('show-onboarding-form');
            Route::post('onboarding', 'store')->name('store');
        });

        Route::middleware(['onboarded:true'])->group(function () {
            Route::redirect('/', '/products')->name('home');

            Route::controller(ProductsController::class)->prefix('/products')->name('products.')->group(function () {
                Route::get('/', 'index')->name('index');
            });
        });
    });
});
