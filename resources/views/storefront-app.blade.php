<!DOCTYPE html>
<html>
<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <title inertia>{{ config('app.name', 'Glennbites') }}</title>

    @routes
    @viteReactRefresh
    @vite(['resources/js/storefront/app.tsx', "resources/js/storefront/Pages/{$page['component']}.tsx", 'resources/css/storefront/app.css'])
    @inertiaHead
</head>
<body class="font-onest antialiased">
    @inertia
</body>
</html>
