<?php

namespace App\Http\Controllers\Storefront;

use App\Actions\AttemptOneTimePassword;
use App\Actions\SendOneTimePassword;
use App\Enums\OneTimePasswordStatus;
use App\Exceptions\OneTimePasswordAttemptException;
use App\Exceptions\OneTimePasswordThrottleException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storefront\Auth\AttemptOneTimePasswordRequest;
use App\Http\Requests\Storefront\Auth\SendOneTimePasswordRequest;
use App\Models\OneTimePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLoginForm(Request $request)
    {
        return Inertia::render('auth/login', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function sendOneTimePassword(SendOneTimePasswordRequest $request)
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

    public function showOneTimePasswordForm(Request $request, OneTimePassword $otp)
    {
        $sid = $request->session()->getId();

        if (! $request->hasValidSignature()) {
            return redirect()->route('storefront.auth.show-login-form')->with('status', OneTimePasswordStatus::SIGNATURE->errorMessage());
        }

        if ($request['sid'] !== $sid) {
            return redirect()->route('storefront.auth.show-login-form')->with('status', OneTimePasswordStatus::SESSION->errorMessage());
        }

        $url = URL::temporarySignedRoute('storefront.auth.attempt-one-time-password', now()->addMinutes(5), [
            'id' => $otp->id,
            'sid' => $sid,
        ]);

        return Inertia::render('auth/one-time-password', [
            'email' => $otp->user->email,
            'url' => $url,
        ]);
    }

    public function attemptOneTimePassword(AttemptOneTimePasswordRequest $request, string $id)
    {
        $validated = $request->validated();

        try {
            $otp = (new AttemptOneTimePassword)->handle($id, $validated['sid'], $validated['code']);

            auth()->guard('web')->login(user: $otp->user, remember: true);

            return to_route('storefront.home');
        } catch (OneTimePasswordAttemptException $e) {
            throw ValidationException::withMessages(['code' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('storefront.auth.show-login-form');
    }
}
