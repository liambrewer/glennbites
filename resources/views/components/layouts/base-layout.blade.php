<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>glennbites</title>

    @include('partials.head')
</head>
<body class="font-onest antialiased bg-slate-100">
{{ $slot }}

@include('partials.body')
</body>
</html>
