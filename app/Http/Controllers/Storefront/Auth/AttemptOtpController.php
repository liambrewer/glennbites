<?php

namespace App\Http\Controllers\Storefront\Auth;

use App\Actions\AttemptOneTimePassword;
use App\Enums\OneTimePasswordStatus;
use App\Exceptions\OneTimePasswordAttemptException;
use App\Http\Requests\Storefront\Auth\AttemptOtpRequest;
use App\Models\OneTimePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class AttemptOtpController
{
    public function create(Request $request, OneTimePassword $otp)
    {
        $sid = $request->session()->getId();

        if (! $request->hasValidSignature()) {
            return redirect()->route('storefront.auth.send-otp.create')->with('status', OneTimePasswordStatus::SIGNATURE->errorMessage());
        }

        if ($request['sid'] !== $sid) {
            return redirect()->route('storefront.auth.send-otp.create')->with('status', OneTimePasswordStatus::SESSION->errorMessage());
        }

        $url = URL::temporarySignedRoute('storefront.auth.verify-otp.store', now()->addMinutes(5), [
            'otp' => $otp,
            'sid' => $sid,
        ]);

        return view('storefront.auth.verify-otp', compact('url'));
    }

    public function store(AttemptOtpRequest $request, OneTimePassword $otp)
    {
        $validated = $request->validated();

        try {
            $otp = (new AttemptOneTimePassword)->handle(id: $otp->id, sid: $validated['sid'], code: $validated['code']);

            auth('web')->login(user: $otp->user, remember: true);

            return redirect()->intended(route('storefront.home'));
        } catch (OneTimePasswordAttemptException $e) {
            throw ValidationException::withMessages([
                'code' => $e->getMessage(),
            ]);
        }
    }
}
