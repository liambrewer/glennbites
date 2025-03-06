<?php

namespace App\Http\Controllers\Storefront\Auth;

class LogoutController
{
    public function __invoke()
    {
        auth('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        return to_route('storefront.auth.login');
    }
}
