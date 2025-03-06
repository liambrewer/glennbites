@props(['type' => 'text', 'label', 'name', 'required' => false, 'value' => ''])

<div {{ $attributes->only('class')->twMerge('flex flex-col text-gray-800') }}>
    @isset ($label) <x-ui.input.label class="mb-0.5" :for="$name" :$required>{{ $label }}</x-ui.input.label> @endisset
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{
            $attributes
                ->except(['class', 'id', 'name', 'value'])
                ->twMerge(
                    'rounded border bg-white px-3 py-2.5 text-sm ring-blue-200 duration-150',
                    'read-only:bg-gray-50 read-only:text-gray-400',
                    'focus:border-blue-500 focus:bg-white focus:outline-none focus:ring',
                    $errors->has($name) ? 'border-red-500 bg-red-50 focus:border-red-500 focus:ring-red-200' : ''
                )
        }}
    >
    @error($name)
        <x-ui.input.error>
            {{ $message }}
        </x-ui.input.error>
    @enderror
</div>
