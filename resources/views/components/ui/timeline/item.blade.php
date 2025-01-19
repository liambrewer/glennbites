@props([
    'title',
    'time',
])

<li class="mb-4 last:mb-0 ml-4">
    <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5"></div>
    <time class="text-gray-600 text-sm leading-none mb-1">{{ $time->toDayDateTimeString() }} {{ $time->timezoneAbbreviatedName }} ({{ $time->diffForHumans() }})</time>
    <h3 class="text-gray-800 font-semibold text-lg mb-1.5">{{ $title }}</h3>

    {{ $slot }}
</li>
