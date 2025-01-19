@props(['required' => false])

<label {{ $attributes->merge(['class' => $required ? 'label label-required' : 'label']) }}>
    {{ $slot }}
</label>
