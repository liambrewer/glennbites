@php
    use chillerlan\QRCode\QRCode;

    $qrcode = (new QRCode())->render("https://example.comhttps://example.comhttps://example.com");
@endphp

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
        }
    </style>

    @vite('resources/css/pos/app.css')
</head>
<body>
<div class="bg-white text-black font-onest" style="width: 4in; height: 2.25in;">
    <div class="flex flex-col h-full">
        <div class="flex justify-between items-start p-3 border-b border-b-black">
            <div class="flex flex-col justify-between grow pr-2 h-full" style="max-width: calc(100% - 80px);">
                <div class="flex gap-1 text-xs">
                    <div>
                        <span class="font-semibold">Order:</span> #{{ $order->id }}
                    </div>

                    <div>
                        <span class="font-semibold">Items:</span> {{ $order->items->sum('quantity') }}
                    </div>
                </div>

                <div class="text-xl font-bold truncate w-full leading-none">{{ $order->user->name }}</div>

                <x-pos.cash-and-card-totals :total="$order->total" />
            </div>

            <img src="{{ $qrcode }}" alt="QR Code" class="size-16 shrink-0" />
        </div>

        <div class="flex-1 overflow-hidden divide-y divide-black" style="max-height: 1.25in;">
            @foreach($order->items as $item)
                <div class="flex justify-between text-sm px-3 py-0.5">
                    <div class="truncate pr-2" style="max-width: 2.75in;">
                        <span class="font-semibold">{{ $item->quantity }}x</span> {{ $item->product->name }}
                    </div>
                    <div class="text-right">${{ number_format($item->total, 2) }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>
