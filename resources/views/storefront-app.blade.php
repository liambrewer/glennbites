<!DOCTYPE html>
<html>
<head lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <title inertia>{{ config('app.name', 'Glennbites') }}</title>

    @routes
    @viteReactRefresh
    @vite(['resources/js/storefront/app.tsx', "resources/js/storefront/pages/{$page['component']}.tsx", 'resources/css/storefront/app.css'])
    @inertiaHead
</head>
<body class="font-onest antialiased">
    @inertia
</body>
</html>
