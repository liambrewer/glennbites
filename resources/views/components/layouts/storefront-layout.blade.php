@props(['header', 'back'])

@php
    use App\Helpers\NavLink;
    use App\Services\CartService;

    $navLinks = [
       NavLink::create(
           href: route('storefront.products'),
           icon: 'heroicon-s-building-storefront',
           label: 'Products',
           exact: true,
       ),
       NavLink::create(
           href: route('storefront.cart'),
           icon: 'heroicon-s-shopping-cart',
           label: 'Cart',
           exact: true,
       ),
       NavLink::create(
           href: route('storefront.orders.index'),
           icon: 'heroicon-s-rectangle-stack',
           label: 'Orders',
           exact: false,
       ),
       NavLink::create(
           href: route('storefront.account'),
           icon: 'heroicon-s-user-circle',
           label: 'Account',
           exact: true,
       ),
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ isset($title) ? "$title - Glennbites" : "Glennbites" }}</title>

    @include('partials.head')

    @vite(['resources/js/storefront/app.js', 'resources/css/storefront/app.css'])
</head>
<body class="font-onest antialiased">
<div class="bg-gray-100">
    <div class="h-full min-h-lvh">
        <header x-data="{ open: false }" class="bg-white border-b sticky top-0 z-10">
            <div class="flex items-center h-12 container mx-auto px-4">
                <a wire:navigate href="{{ route('storefront.home') }}" class="flex gap-2 items-center h-full">
                    <x-logo class="size-8" />

                    <h1 class="text-2xl font-bold">Glennbites</h1>
                </a>

                <div class="grow"></div>

                <nav class="hidden md:contents">
                    <ul class="flex gap-2">
                        @foreach ($navLinks as $navLink)
                            <li class="contents">
                                <a
                                    wire:navigate
                                    class="flex items-center justify-center py-1.5 px-3 gap-1.5 rounded-lg duration-150 text-sm {{ $navLink->active ? 'bg-blue-500 text-white' : 'hover:bg-blue-50 active:bg-blue-100' }}"
                                    href="{{ $navLink->href }}"
                                >
                                    <x-dynamic-component :component="$navLink->icon" class="size-4" />

                                    {{ $navLink->label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>

                <button @click="open = true" class="size-8 p-1 md:hidden">
                    <x-heroicon-s-bars-3 />
                </button>
            </div>

            <div
                x-cloak
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="-translate-y-full"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="ease-in duration-300"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="-translate-y-full"
                @click.outside="open = false"
                class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-50 flex flex-col p-4 gap-4 bg-white border-b shadow-lg md:hidden"
            >
                <x-ui.button @click="open = false">
                    <x-slot:left>
                        <x-ui.button.icon icon="heroicon-s-x-mark" />
                    </x-slot:left>

                    Close
                </x-ui.button>

                <ul class="flex flex-col gap-1">
                    @foreach ($navLinks as $navLink)
                        <li class="contents">
                            <a
                                @click="open = false"
                                wire:navigate
                                class="flex items-center justify-center py-4 px-3 gap-1.5 rounded-lg duration-150 {{ $navLink->active ? 'bg-blue-500 text-white' : 'hover:bg-blue-50 active:bg-blue-100' }}"
                                href="{{ $navLink->href }}"
                            >
                                <x-dynamic-component :component="$navLink->icon" class="size-4" />

                                {{ $navLink->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div x-cloak x-show="open" x-transition.opacity.duration.300ms class="fixed inset-0 z-40 bg-gray-500/20 md:hidden"></div>
        </header>

        <main class="container mx-auto p-4">
            @if (isset($back) || isset($header))
                <div class="flex gap-2 flex-col md:flex-row md:items-center mb-4">
                    @isset ($back)
                        <x-ui.button wire:navigate href="{{ $back }}" class="md:w-fit">
                            <x-slot:left>
                                <x-ui.button.icon icon="heroicon-s-arrow-left" />
                            </x-slot:left>

                            Back
                        </x-ui.button>
                    @endisset
                    @isset ($header)
                        <h1 class="text-xl font-bold text-center md:text-left">{{ $header }}</h1>
                    @endisset
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    <footer class="bg-white border-t p-4">
        <div class="container mx-auto">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Glennbites. All rights reserved.
            </p>
        </div>
    </footer>
</div>

@include('partials.body')
</body>
</html>
