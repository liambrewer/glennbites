<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Pickup Label</title>

    <style>
        @media print {
            @page {
                size: 4in 2.25in;
                margin: 0;
            }
            html, body {
                margin: 0;
                padding: 0;
                width: 4in;
                height: 2.25in;
            }
        }
    </style>

    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-full p-4 box-border gap-2 font-onest">
<div class="grid grid-cols-4 w-full items-center text-xs">
    <span class="text-lg uppercase font-semibold text-start">Pickup</span>
    <span class="text-center">Order #: {{ $order->id }}</span>
    <span class="text-center">Items: {{ $order->items->sum('quantity') }}</span>
    <div class="text-end leading-3">
        <div>{{ $order->created_at->format('g:i A') }}</div>
        <div>{{ $order->created_at->format('m/d/Y') }}</div>
    </div>
</div>

<div class="grow flex justify-between w-full">

    <div class="flex flex-col justify-start">
        <h2 class="text-2xl font-bold overflow-clip line-clamp-1">{{ $order->user->name }}</h2>
        <p class="text-sm">Placed At: {{ $order->created_at->format('g:i A') }}</p>

        <div class="grow"></div>

        <p class="text-lg font-bold">Total Due: ${{ $order->total }}</p>
    </div>

    <div class="flex items-end justify-end flex-shrink-0">
        <img src="{{ (new chillerlan\QRCode\QRCode)->render('http://glennbites.test/orders/1') }}" alt="QR Code" class="size-32">
    </div>
</div>
</body>
</html>
