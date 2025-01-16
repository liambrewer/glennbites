@props(['status'])

@php
use App\Enums\OrderStatus;

$icon = null;
$chipClasses = 'flex items-center gap-1.5 text-white text-sm font-semibold px-2.5 py-0.5 rounded-full';

switch ($status) {
    case (OrderStatus::PENDING):
        $icon = 'heroicon-c-clock';
        $chipClasses .= ' bg-blue-500';
        break;
}
@endphp

<span {{ $attributes->class($chipClasses) }}>
    @if(isset($icon)) <x-dynamic-component :component="$icon" class="size-3.5" /> @endif

    {{ $status }}
</span>
