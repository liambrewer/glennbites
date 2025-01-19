@props(['type' => 'text', 'label' => 'Label', 'name' => 'name', 'required' => false, 'value' => ''])

<div {{ $attributes->only('class')->class('flex flex-col text-gray-800') }}>
    <x-ui.input.label class="mb-0.5" :for="$name" :$required>{{ $label }}</x-ui.input.label>
    <input
        class="text-input @error($name) text-input-error @enderror"
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $label }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->except(['class', 'value', 'placeholder', 'id', 'name', 'type']) }}
    >
    @error($name)
        <x-ui.input.error>
            {{ $message }}
        </x-ui.input.error>
    @enderror
</div>
