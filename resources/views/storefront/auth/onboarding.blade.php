<x-layouts.storefront-auth-layout>
    <x-slot:title>
        Onboarding
    </x-slot:title>
    <x-slot:description>
        Welcome to Glennbites! Please enter your information to get started.
    </x-slot:description>

    <form method="post" action="{{ route('storefront.auth.onboarding') }}" class="space-y-8">
        @csrf

        <div class="space-y-4">
            <x-ui.input.text
                value="{{ auth('web')->user()->email }}"
                name="email"
                type="email"
                label="Email"
                readonly
            />

            <x-ui.input.text
                name="first_name"
                type="text"
                label="First Name"
                placeholder="John"
                required
            />

            <x-ui.input.text
                name="last_name"
                type="text"
                label="Last Name"
                placeholder="Doe"
                required
            />
        </div>

        <x-ui.button.primary class="w-full" type="submit">
            <x-slot:left>
                <x-ui.button.icon icon="heroicon-s-user-plus" />
            </x-slot:left>

            <span>Complete Onboarding</span>
        </x-ui.button.primary>
    </form>
</x-layouts.storefront-auth-layout>
