@props(['label' => 'label', 'name' => 'name', 'required' => false, 'value' => '', 'readonly' => false, 'rows' => 2])

<div {{ $attributes->only('class')->class('flex flex-col text-gray-800') }}>
    <x-ui.input.label class="mb-0.5" :for="$name" :$required>{{ $label }}</x-ui.input.label>
    <textarea
        class="rounded border px-3 py-2.5 text-sm duration-150 read-only:bg-gray-100 read-only:text-gray-400 focus:border-blue-500 focus:outline-none focus:ring focus:ring-blue-200 @error($name) border-red-500 bg-red-50 placeholder-red-500 @enderror"
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
