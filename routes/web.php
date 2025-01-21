<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;

Route::domain(parse_url(config('app.url'))['host'])->group(function () {
    Route::get('/', function () {
        return "Home";
    })->name('home');

    Route::get('/orders/{order}/pickup-label', function (Order $order) {
        return view('labels.pickup', compact('order'));
    });
});

require __DIR__ . '/pos.php';
