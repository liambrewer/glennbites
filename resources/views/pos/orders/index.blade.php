<x-pos-layout>
    <h1 class="text-lg font-semibold mb-5">Orders</h1>

{{--    <ul class="grid grid-cols-2 gap-5">--}}
{{--        @foreach($orders as $order)--}}
{{--            <li class="bg-slate-50 border rounded-lg p-5">--}}
{{--                <h2>{{ $order->user->name }}</h2>--}}
{{--            </li>--}}
{{--        @endforeach--}}
{{--    </ul>--}}
    <livewire:pos.current-orders />
</x-pos-layout>
