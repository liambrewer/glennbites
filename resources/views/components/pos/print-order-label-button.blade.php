@props(['order'])

<x-ui.button.primary {{ $attributes->except(['x-data', 'x-bind:disabled', '@click']) }} x-data="orderPrinter('{{ $order->id }}')" x-bind:disabled="printing" @click="printPdf">
    <x-slot name="left">
        <template x-if="!printing"><span><x-ui.button.icon icon="heroicon-m-printer" /></span></template>
        <template x-if="printing"><span><x-ui.button.icon icon="heroicon-m-arrow-path" class="animate-spin" /></span></template>
    </x-slot>

    <template x-if="!printing"><span>Print Label</span></template>
    <template x-if="printing"><span>Printing...</span></template>
</x-ui.button.primary>
