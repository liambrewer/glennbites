<?php

use App\Models\User;
use Livewire\Attributes\{Computed, Title, Layout};
use Livewire\Volt\Component;

new
#[Title('Account')]
#[Layout('components.layouts.storefront-layout', [
    'header' => 'My Account',
])]
class extends Component {
    #[Computed]
    public function user(): User
    {
        return auth('web')->user();
    }
}; ?>

<div>
    <form action="{{ route('storefront.auth.logout') }}" method="POST">
        @csrf

        <x-ui.button.danger type="submit">
            <x-slot:left>
                <x-ui.button.icon icon="heroicon-s-arrow-left-start-on-rectangle" />
            </x-slot:left>
            Logout
        </x-ui.button.danger>
    </form>
</div>
