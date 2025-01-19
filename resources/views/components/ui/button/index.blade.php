@props([
    'href',
    'type' => 'button',
])
@aware([
    'left',
    'right',
])

@isset($href)
    <a
        href="{{ $href }}"
        {{ $attributes->twMerge([
            'flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-800 font-medium select-none outline-none duration-150',
            'hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 active:bg-gray-200',
        ]) }}
    >
        {{ $left }}
        {{ $slot }}
        {{ $right }}
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->twMerge([
            'flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm text-gray-800 font-medium select-none outline-none duration-150',
            'hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 active:bg-gray-200',
            'disabled:opacity-50 disabled:pointer-events-none',
        ]) }}
    >
        {{ $left }}
        {{ $slot }}
        {{ $right }}
    </button>
@endisset
