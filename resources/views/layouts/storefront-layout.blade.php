<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>glennbites</title>

    @include('layouts.include.common.head')
</head>
<body class="font-onest antialiased">

<main>
    {{ $slot }}
</main>

@include('layouts.include.common.body')
</body>
</html>
