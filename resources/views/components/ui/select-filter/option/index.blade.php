@props(['icon', 'active' => false])

<li class="contents">
    <button {{ $attributes->class([
        'inline-flex items-center gap-1.5 px-3 h-8 text-sm font-semibold rounded-xl border outline-none duration-150',
        'focus:ring-2 focus:ring-offset-1 focus:ring-blue-500',
        'text-white bg-blue-500 border-blue-500' => $active,
        'text-gray-600 bg-white hover:text-gray-800' => !$active,
    ]) }}>
        @isset ($icon)
            <div class="w-5 h-5 flex-shrink-0">
                {{ $icon }}
            </div>
        @endisset
        {{ $slot }}
    </button>
</li>
