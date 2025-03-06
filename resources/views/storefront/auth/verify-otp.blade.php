<x-layouts.storefront-auth-layout>
    <x-slot:title>
        Verify One-Time Password
    </x-slot:title>
    <x-slot:description>
        Please enter the one-time password sent to your email.
    </x-slot:description>

    <form method="post" action="{{ $url }}" class="space-y-8">
        @csrf

        <x-ui.input.text
            x-data
            x-mask="999-999"
            name="code"
            type="text"
            label="One-Time Password"
            placeholder="123-456"
            required
        />

        <x-ui.button.primary class="w-full" type="submit">
            <x-slot:left>
                <x-ui.button.icon icon="heroicon-s-lock-closed" />
            </x-slot:left>

            <span>Verify One-Time Password</span>
        </x-ui.button.primary>
    </form>
</x-layouts.storefront-auth-layout>
