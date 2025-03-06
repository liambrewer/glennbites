<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserOnboarded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $shouldBeOnboarded = 'true'): Response
    {
        $shouldBeOnboarded = $shouldBeOnboarded === 'true';

        $user = auth('web')->user();

        if ($shouldBeOnboarded && ! $user->onboarded) {
            return to_route('storefront.auth.onboarding.create');
        } elseif (! $shouldBeOnboarded && $user->onboarded) {
            return to_route('storefront.home');
        }

        return $next($request);
    }
}
