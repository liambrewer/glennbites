<?php

namespace App\Http\Controllers\Storefront\Auth;

use App\Http\Requests\Storefront\Auth\StoreOnboardingRequest;

class OnboardingController
{
    public function create()
    {
        return view('storefront.auth.onboarding');
    }

    public function store(StoreOnboardingRequest $request)
    {
        $validated = $request->validated();

        $user = auth('web')->user();

        if (! $user->onboarded) {
            $user->update(['name' => $validated['first_name'].' '.$validated['last_name'], 'onboarded_at' => now()]);
        }

        return redirect()->intended(route('storefront.home'));
    }
}
