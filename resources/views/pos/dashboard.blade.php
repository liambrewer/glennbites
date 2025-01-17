<x-pos-layout>
    <div class="grid grid-cols-4 grid-rows-6 h-screen p-5 gap-5">
        <x-pos.dashboard-card class="row-span-3" title="Users" :href="route('pos.users.index')" icon="heroicon-c-users">

        </x-pos.dashboard-card>
        <x-pos.dashboard-card class="col-span-2 row-span-6" title="Orders" :href="route('pos.orders.index')" icon="heroicon-c-rectangle-stack">
            <div class="grow overflow-scroll">
                <livewire:pos.current-orders />
            </div>
        </x-pos.dashboard-card>
        <x-pos.dashboard-card class="row-span-2" title="Metrics" :href="route('pos.metrics')" icon="heroicon-c-chart-bar">

        </x-pos.dashboard-card>
        <x-pos.dashboard-card class="row-span-2" title="Print Queue" icon="heroicon-c-printer">

        </x-pos.dashboard-card>
        <x-pos.dashboard-card class="row-span-3" title="Activity Stream" :href="route('pos.activity')" icon="heroicon-c-clock">

        </x-pos.dashboard-card>
        <x-pos.dashboard-card class="row-span-2" title="Terminal State" icon="heroicon-c-computer-desktop">
            <div class="grow">
                <div class="font-semibold text-gray-800">{{ $user->name }}</div>
                <div class="text-sm text-gray-600">{{ $user->employee_number }}</div>
            </div>

            <form action="{{ route('pos.auth.logout') }}" method="post">
                @csrf

                <button type="submit">Log Out</button>
            </form>
        </x-pos.dashboard-card>
    </div>

{{--    <script>--}}
{{--        const iframeBtn = document.getElementById('iframe-print-btn')--}}

{{--        iframeBtn.addEventListener('click', function () {--}}
{{--            const iframe = document.createElement('iframe');--}}
{{--            iframe.style.display = 'none'--}}
{{--            document.body.append(iframe)--}}

{{--            iframe.addEventListener('load', function () {--}}
{{--                iframe.contentWindow.body.addEventListener('afterprint', () => {--}}
{{--                    iframe.remove();--}}
{{--                });--}}

{{--                iframe.contentWindow.print();--}}
{{--            })--}}

{{--            iframe.src = 'http://glennbites.test/orders/1/pickup-label.pdf'--}}
{{--        })--}}

{{--        const htmlBtn = document.getElementById('html-print-btn')--}}

{{--        htmlBtn.addEventListener('click', function () {--}}
{{--            const iframe = document.createElement('iframe');--}}
{{--            iframe.style.display = 'none'--}}
{{--            iframe.src = 'http://glennbites.test/orders/1/pickup-label'--}}
{{--            iframe.onload = function () {--}}
{{--                console.log("onload iframe")--}}

{{--                this.contentWindow.addEventListener('afterprint', function () {--}}
{{--                    console.log("afterprint iframe")--}}
{{--                    document.body.removeChild(iframe)--}}
{{--                })--}}

{{--                this.contentWindow.focus();--}}
{{--                this.contentWindow.print();--}}
{{--            }--}}
{{--            document.body.append(iframe)--}}
{{--        })--}}
{{--    </script>--}}
</x-pos-layout>
