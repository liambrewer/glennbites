@props(['status'])

@php
use App\Enums\OrderStatus;

$icon = null;
$chipClasses = 'flex items-center gap-1.5 text-white text-sm font-semibold px-2.5 py-0.5 rounded-full';

switch ($status) {
    case (OrderStatus::PENDING):
            $icon = 'heroicon-c-clock';
            $chipClasses .= ' bg-yellow-500';
            break;
    case (OrderStatus::RESERVED):
        $icon = 'heroicon-c-arrow-down-tray';
        $chipClasses .= ' bg-blue-500';
        break;
    case (OrderStatus::COMPLETED):
        $icon = 'heroicon-c-check';
        $chipClasses .= ' bg-green-500';
        break;
    case (OrderStatus::CANCELED):
        $icon = 'heroicon-c-exclamation-triangle';
        $chipClasses .= ' bg-red-500';
        break;
    case (OrderStatus::SHORTED):
        $icon = 'heroicon-c-x-circle';
        $chipClasses .= ' bg-amber-500';
        break;
}
@endphp

<span {{ $attributes->class($chipClasses) }}>
    @if(isset($icon)) <x-dynamic-component :component="$icon" class="size-3.5" /> @endif

    {{ $status }}
</span>
