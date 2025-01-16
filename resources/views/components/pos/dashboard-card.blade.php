@props(['title', 'href', 'icon'])

<div
    {{ $attributes->class('border rounded-3xl p-5 pt-4 shadow-xl bg-white flex flex-col gap-5') }}
>
    @if(isset($href))
        <a href="{{ $href }}" class="group flex items-center gap-1.5 w-fit flex-shrink-0">
            @if(isset($icon)) <x-dynamic-component :component="$icon" class="size-4" /> @endif

            <span class="text-xl font-semibold">{{ $title }}</span>

            <x-heroicon-c-arrow-right class="size-4 -translate-x-1.5 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 duration-150" />
        </a>
    @else
        <div class="group flex items-center gap-1.5 w-fit flex-shrink-0">
            @if(isset($icon)) <x-dynamic-component :component="$icon" class="size-4" /> @endif

            <span class="text-xl font-semibold">{{ $title }}</span>
        </div>
    @endif

    {{ $slot }}
</div>
