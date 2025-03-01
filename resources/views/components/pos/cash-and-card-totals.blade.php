@props(['total'])

<div class="flex gap-2.5 text-lg">
    <div title="Cash Total">
        <x-heroicon-c-banknotes class="size-5 inline text-green-600" />
        <span class="text-green-800 font-semibold">${{ number_format((float) $total, 2, '.', '') }}</span>
    </div>
    <div title="Credit Card Total">
        <x-heroicon-c-credit-card class="size-5 inline text-blue-600" />
        <span class="text-blue-800 font-semibold">${{ number_format((float) $total + 0.40, 2, '.', '') }}</span>
    </div>
</div>
