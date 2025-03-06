@php
use App\Helpers\NavLink;

$employee = auth('employee')->user();
$navLinks = [
   NavLink::create(
       href: route('pos.home'),
       icon: 'heroicon-m-home',
       label: 'Home',
       exact: true,
   ),
   NavLink::create(
       href: route('pos.orders.index'),
       icon: 'heroicon-m-rectangle-stack',
       label: 'Orders',
       exact: false,
   ),
   NavLink::create(
       href: route('pos.users.index'),
       icon: 'heroicon-m-users',
       label: 'Users',
       exact: false,
   ),
   NavLink::create(
       href: route('pos.metrics'),
       icon: 'heroicon-m-chart-bar',
       label: 'Metrics',
       exact: false,
   ),
   NavLink::create(
       href: route('pos.activity'),
       icon: 'heroicon-m-clock',
       label: 'Activity Stream',
       exact: true,
   ),
];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Glennbites POS</title>

    @include('partials.head')

    @vite(['resources/js/pos/app.js', 'resources/css/pos/app.css'])
</head>
<body class="font-onest antialiased bg-slate-100">
<aside class="fixed inset-y-0 left-0 flex flex-col gap-5 w-64 p-5 border-r bg-slate-50">
    <h1 class="text-lg font-semibold">Glennbites POS</h1>

    <ul class="flex flex-col gap-1 grow">
        @foreach ($navLinks as $navLink)
            <li class="contents">
                <a class="{{ 'group flex items-center h-12 px-2.5 gap-2.5 rounded-lg border ' . ($navLink->active ? 'bg-blue-50 border-blue-200' : 'bg-white') }}" href="{{ $navLink->href }}" wire:navigate>
                    <x-dynamic-component :component="$navLink->icon" class="{{ 'size-4 ' . ($navLink->active ? 'text-blue-600' : 'text-gray-600') }}" />

                    <span class="{{ 'font-semibold text-sm ' . ($navLink->active ? 'text-blue-800' : 'text-gray-800') }}">{{ $navLink->label }}</span>

                    <div class="grow"></div>

                    <x-heroicon-m-arrow-right class="{{  'size-4 ' . ($navLink->active ? 'text-blue-600' : 'text-gray-600 -translate-x-4 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 group-active:translate-x-0 group-active:opacity-100 duration-150') }}" />
                </a>
            </li>
        @endforeach
    </ul>

    <div class="flex items-center justify-between">
        <div>
            <div class="text-gray-800 text-sm font-semibold">{{ $employee->name }}</div>
            <div class="text-gray-600 text-xs">{{ $employee->employee_number }}</div>
        </div>

        <form action="{{ route('pos.auth.logout') }}" method="post">
            @csrf

            <x-ui.button.primary type="submit"><x-ui.button.icon icon="heroicon-s-arrow-left-start-on-rectangle" /></x-ui.button.primary>
        </form>
    </div>
</aside>

<main class="ms-64 p-5">
    {{ $slot }}
</main>

@include('partials.body')
</body>
</html>
