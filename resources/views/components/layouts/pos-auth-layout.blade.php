<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Glennbites POS</title>

    @include('partials.head')

    @vite(['resources/js/pos/app.js', 'resources/css/pos/app.css'])
</head>
<body class="font-onest antialiased bg-slate-100">
{{ $slot }}

@include('partials.body')
</body>
</html>
