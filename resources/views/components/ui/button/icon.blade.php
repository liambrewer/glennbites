@props(['icon'])

@isset($icon)
    <x-dynamic-component {{ $attributes->twMerge('w-5 h-5 flex-shrink-0') }} :component="$icon" />
@else
    <div {{ $attributes->twMerge('w-5 h-5 flex-shrink-0') }}>
        {{ $slot }}
    </div>
@endisset
