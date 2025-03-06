@php
    use App\Helpers\NavLink;

    $employee = auth('employee')->user();
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
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ isset($title) ? "$title - Glennbites" : "Glennbites" }}</title>

    @include('partials.head')

    @vite(['resources/js/storefront/app.js', 'resources/css/storefront/app.css'])
</head>
<body class="font-onest antialiased bg-slate-100">
<div class="bg-gray-100">
    <div class="h-full min-h-lvh">
        <header x-data="{ open: false }" class="bg-white border-b sticky top-0 z-10">
            <div class="flex items-center h-12 container mx-auto px-4">
                <a wire:navigate href="{{ route('storefront.home') }}" class="flex gap-2 items-center h-full">
                    <x-logo class="size-8" />

                    <h1 class="text-2xl font-bold">Glennbites</h1>
                </a>

                <div class="grow"></div>

                <button @click="open = true" class="size-8 p-1">
                    <x-heroicon-s-bars-3 />
                </button>
            </div>

            <div
                x-cloak
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="ease-in duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                @click.outside="open = false"
                class="flex flex-col p-2.5 gap-2.5 fixed inset-x-0 top-0 z-50 w-full h-full max-w-xs bg-white"
            >
                <x-ui.button class="w-fit" @click="open = false">
                    <x-ui.button.icon icon="heroicon-s-x-mark" />
                </x-ui.button>

                <ul class="flex flex-col gap-1">
                    @foreach ($navLinks as $navLink)
                        <li class="contents">
                            <a
                                wire:navigate
                                class="flex items-center py-1.5 px-3 gap-1.5 rounded-lg duration-150 {{ $navLink->active ? 'bg-blue-500 text-white border' : 'hover:bg-blue-50' }}"
                                href="{{ $navLink->href }}"
                            >
                                <x-dynamic-component :component="$navLink->icon" class="size-4" />

                                {{ $navLink->label }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="grow"></div>

                <form action="{{ route('storefront.auth.logout') }}" method="POST">
                    @csrf

                    <x-ui.button.danger type="submit" class="w-full">
                        <x-slot:left>
                            <x-ui.button.icon icon="heroicon-s-arrow-left-start-on-rectangle" />
                        </x-slot:left>
                        Logout
                    </x-ui.button.danger>
                </form>
            </div>

            <div x-cloak x-show="open" x-transition.opacity.duration.300ms class="fixed inset-0 z-40 bg-gray-500/20"></div>
        </header>

        <main class="container mx-auto p-4">
            {{ $slot }}
        </main>
    </div>

    <footer class="bg-white border-t">
        Glennbites
    </footer>
</div>

@include('partials.body')
</body>
</html>
