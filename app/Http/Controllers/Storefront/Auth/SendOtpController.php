<?php

namespace App\Http\Controllers\Storefront\Auth;

use App\Actions\SendOneTimePassword;
use App\Exceptions\OneTimePasswordThrottleException;
use App\Http\Requests\Storefront\Auth\SendOtpRequest;
use Illuminate\Validation\ValidationException;

class SendOtpController
{
    public function create()
    {
        return view('storefront.auth.send-otp');
    }

    public function store(SendOtpRequest $request)
    {
        $validated = $request->validated();

        $email = strtolower($validated['email']);

        try {
            $otp = (new SendOneTimePassword)->handle($email);

            return redirect($otp->url);
        } catch (OneTimePasswordThrottleException $e) {
            throw ValidationException::withMessages([
                'email' => $e->getMessage(),
            ]);
        }
    }
}
