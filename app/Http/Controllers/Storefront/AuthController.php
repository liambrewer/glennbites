<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Http\Requests\Storefront\Auth\CompleteRegistrationRequest;
use App\Http\Requests\Storefront\Auth\SendLoginLinkRequest;
use App\Models\LoginToken;
use App\Models\User;
use App\Notifications\LoginLinkNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return Inertia::render('Auth/Login');
    }

    public function sendLoginLink(SendLoginLinkRequest $request)
    {
        $validated = $request->validated();

        $loginToken = LoginToken::generateForEmail($validated['email']);

        $signedUrl = URL::temporarySignedRoute(
            'storefront.auth.handle-login-link',
            now()->addMinutes(30),
            ['token' => $loginToken->token]
        );

        Notification::route('mail', $validated['email'])
            ->notify(new LoginLinkNotification($signedUrl));

        return back()->with('message', 'Login link sent!');
    }

    public function handleLoginLink(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'This link has expired or is invalid.');
        }

        $loginToken = LoginToken::findValidToken($token);

        if (!$loginToken) {
            abort(401, 'This link has expired or is invalid.');
        }

        $email = $loginToken->email;

        $loginToken->markAsUsed();

        $user = User::where('email', $email)->first();

        if ($user) {
            Auth::guard('web')->login($user);
            return redirect()->intended(route('storefront.home'));
        } else {
            session(['registration_email' => $email]);
            return redirect()->route('storefront.auth.show-register-form');
        }
    }

    public function showRegisterForm()
    {
        $email = session('registration_email');

        if (!$email) {
            return redirect()->route('storefront.auth.show-login-form');
        }

        return Inertia::render('Auth/Register', [
            'email' => $email,
        ]);
    }

    public function completeRegistration(CompleteRegistrationRequest $request)
    {
        $validated = $request->validated();

        $email = session('registration_email');

        if (!$email) {
            abort(401, 'Registration session expired.');
        }

        $user = User::create([
            'email' => $email,
            'name' => $validated['first_name'].' '.$validated['last_name'],
            'password' => Str::random(20),
        ]);

        session()->forget('registration_email');

        Auth::guard('web')->login($user);

        return redirect()->intended(route('storefront.home'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('storefront.auth.show-login-form');
    }
}
