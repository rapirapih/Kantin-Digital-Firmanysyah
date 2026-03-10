<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->profile_completed) {
            if (!$request->routeIs('profile.*') && !$request->routeIs('logout')) {
                return redirect()->route('profile.edit')
                    ->with('status', 'Silakan lengkapi profil Anda terlebih dahulu.');
            }
        }

        return $next($request);
    }
}
