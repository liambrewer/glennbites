<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storefront\StoreOnboardingRequest;
use Inertia\Inertia;

class OnboardingController extends Controller
{
    public function showOnboardingForm()
    {
        return Inertia::render('onboarding');
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
