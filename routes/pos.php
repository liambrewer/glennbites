<?php

use App\Http\Controllers\POS;
use Illuminate\Support\Facades\Route;

Route::name('pos.')->prefix('/pos')->group(function () {
    Route::get('/', POS\HomeController::class)->name('home');

    Route::name('orders.')->prefix('/orders')->controller(POS\OrderController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::name('users.')->prefix('/users')->controller(POS\UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
    });

    Route::get('/metrics', POS\MetricController::class)->name('metrics');

    Route::get('/activity', POS\ActivityController::class)->name('activity');
});
