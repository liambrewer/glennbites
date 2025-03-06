@props(['title', 'description'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ isset($title) ? "$title - Glennbites" : "Glennbites" }}</title>

    @include('partials.head')

    @vite(['resources/js/storefront/app.js', 'resources/css/storefront/app.css'])
</head>
<body class="font-onest antialiased bg-gray-100">
<div class="flex h-full min-h-dvh items-center justify-center">
    <div class="flex w-full max-w-md flex-col gap-8 px-4 py-8 md:px-0">
        <x-logo class="mx-auto" />

        <div class="space-y-2 text-center">
            @isset ($title) <h1 class="text-lg font-semibold">{{ $title }}</h1> @endisset
            @isset ($description) <p class="text-sm text-gray-600">{{ $description }}</p> @endisset
        </div>

        {{ $slot }}
    </div>
</div>

@include('partials.body')
</body>
</html>
