<x-layouts.pos-layout>
    <h1 class="text-lg font-semibold mb-5">Activity Stream</h1>

    <ul class="divide-y">
        @foreach($stockMovements as $stockMovement)
            <li class="py-2.5">
                <div>{{ $stockMovement->id }}</div>
                <div>{{ $stockMovement->type }}</div>
                <div>{{ $stockMovement->reason }}</div>
                <div>{{ $stockMovement->quantity_change }}</div>
                <div>{{ $stockMovement->product->name }}</div>
            </li>
        @endforeach
    </ul>
</x-layouts.pos-layout>
