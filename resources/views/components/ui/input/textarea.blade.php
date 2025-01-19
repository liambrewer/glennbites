@props(['label' => 'label', 'name' => 'name', 'required' => false, 'value' => '', 'readonly' => false, 'rows' => 2])

<div {{ $attributes->only('class')->class('flex flex-col text-gray-800') }}>
    <x-ui.input.label class="mb-0.5" :for="$name" :$required>{{ $label }}</x-ui.input.label>
    <textarea
        class="text-input @error($name) text-input-error @enderror"
        name="{{ $name }}"
        id="{{ $name }}"
        placeholder="{{ $label }}"
        rows="{{ $rows }}"
        {{ $attributes->except(['class', 'placeholder', 'id', 'name', 'rows']) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <x-ui.input.error>
            {{ $message }}
        </x-ui.input.error>
    @enderror
</div>
