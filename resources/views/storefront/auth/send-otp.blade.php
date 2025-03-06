<x-layouts.storefront-auth-layout>
    <x-slot:title>
        Login to Glennbites
    </x-slot:title>
    <x-slot:description>
        Welcome back! Please enter your email to receive a one-time password.
    </x-slot:description>

    <form method="post" action="{{ route('storefront.auth.send-otp.store') }}" class="space-y-8">
        @csrf

        <x-ui.input.text
            name="email"
            type="email"
            label="Email"
            placeholder="first.last00@k12.leanderisd.org"
            required
        />

        <x-ui.button.primary class="w-full" type="submit">
            <x-slot:left>
                <x-ui.button.icon icon="heroicon-s-envelope" />
            </x-slot:left>

            <span>Send One-Time Password</span>
        </x-ui.button.primary>
    </form>

</x-layouts.storefront-auth-layout>
