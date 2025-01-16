<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Orientation;
use Spatie\LaravelPdf\Facades\Pdf;

Route::get('/', function () {
    return view('pos.dashboard');
});

Route::get('/orders/{order}/pickup-label.pdf', function (Order $order) {
    return Pdf::view('labels.pickup', compact('order'))
        ->paperSize(4, 2.25, 'in')
        ->orientation(Orientation::Landscape)
        ->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot
                ->setNodeBinary('/Users/liambrewer/Library/Application\ Support/Herd/config/nvm/versions/node/v22.12.0/bin/node')
                ->setNpmBinary('/Users/liambrewer/Library/Application\ Support/Herd/config/nvm/versions/node/v22.12.0/bin/npm');
        });
});

Route::get('/orders/{order}/pickup-label', function (Order $order) {
    return view('labels.pickup', compact('order'));
});

require __DIR__ . '/pos.php';
