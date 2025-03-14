<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::domain(parse_url(config('app.url'))['host'])->group(function () {
    Route::get('/orders/{order}/pickup-label', function (Order $order) {
        return view('labels.pickup', compact('order'));
    });
});

require __DIR__.'/storefront.php';
require __DIR__.'/pos.php';
