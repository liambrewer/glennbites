@props(['title' => null])

<div class="space-y-1">
    @if($title)
        <span class="text-gray-800 text-sm font-semibold">{{ $title }}</span>
    @endif
    <ul class="flex gap-1">
        {{ $slot }}
    </ul>
</div>
