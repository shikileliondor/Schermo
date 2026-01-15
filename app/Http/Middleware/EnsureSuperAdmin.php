<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->isSuperAdmin()) {
            abort(403);
        }

        if (! $user->is_active) {
            Auth::logout();
            abort(403);
        }

        return $next($request);
    }
}
