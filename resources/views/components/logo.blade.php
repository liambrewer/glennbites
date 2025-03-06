@use(Illuminate\Support\Facades\Vite)

<img {{ $attributes->only('class')->twMerge('size-12') }} src="{{ Vite::asset('resources/images/deca.png') }}" alt="Deca Logo">
