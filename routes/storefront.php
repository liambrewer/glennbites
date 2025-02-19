<?php

use App\Http\Controllers\Storefront\ProductsController;
use Illuminate\Support\Facades\Route;

Route::domain(parse_url(config('app.url'))['host'])->name('storefront.')->group(function () {
    Route::redirect('/', '/products');

    Route::controller(ProductsController::class)->prefix('/products')->name('products.')->group(function () {
        Route::get('/', 'index')->name('index');
    });
});
