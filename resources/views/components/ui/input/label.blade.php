@props(['required' => false])

<label {{ $attributes->twMerge('text-sm font-semibold', $required ? 'after:-ms-0.5 after:text-red-500 after:content-[\'*\']' : '') }}>
    {{ $slot }}
</label>
