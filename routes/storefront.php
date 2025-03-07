<?php

use App\Http\Controllers\Storefront\Auth\AttemptOtpController;
use App\Http\Controllers\Storefront\Auth\LogoutController;
use App\Http\Controllers\Storefront\Auth\SendOtpController;
use App\Http\Controllers\Storefront\Auth\OnboardingController;
use App\Models\Order;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::domain(parse_url(config('app.url'))['host'])->name('storefront.')->group(function () {
    Route::name('auth.')->group(function () {
        Route::middleware(['guest:web'])->group(function () {
            Route::redirect('login', 'login/otp')->name('login');

            Route::controller(SendOtpController::class)->prefix('login/otp')->name('send-otp.')->group(function () {
                Route::get('/', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });

            Route::controller(AttemptOtpController::class)->prefix('login/otp/{otp}/verify')->name('verify-otp.')->group(function () {
                Route::get('/', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });
        });

        Route::middleware(['auth:web'])->group(function () {
            Route::middleware(['onboarded:false'])->controller(OnboardingController::class)->prefix('onboarding')->name('onboarding.')->group(function () {
                Route::get('/', 'create')->name('create');
                Route::post('/', 'store')->name('store');
            });

            Route::post('logout', LogoutController::class)->name('logout');
        });
    });

    Route::middleware(['auth:web'])->group(function () {
        Route::middleware(['onboarded:true'])->group(function () {
            Route::redirect('/', '/products')->name('home');

//            Route::controller(ProductsController::class)->prefix('products')->name('products.')->group(function () {
//                Route::get('/', 'index')->name('index');
//            });

            Volt::route('products', 'storefront.products')->name('products');

            Volt::route('cart', 'storefront.cart')->name('cart');

            Volt::route('account', 'storefront.account')->name('account');

            Volt::route('orders', 'storefront.orders.index')->name('orders.index');
            Volt::route('orders/{order}', 'storefront.orders.show')->name('orders.show');

//            Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
//                Route::get('/', 'index')->name('index');
//
//                Route::post('add', 'add')->name('add');
//                Route::post('remove', 'remove')->name('remove');
//                Route::post('delete', 'delete')->name('delete');
//                Route::post('clear', 'clear')->name('clear');
//            });
        });
    });
});
