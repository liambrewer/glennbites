<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>glennbites POS</title>

    @include('layouts.include.common.head')
</head>
<body class="font-onest antialiased bg-slate-50">
{{ $slot }}

@include('layouts.include.common.body')
</body>
</html>
