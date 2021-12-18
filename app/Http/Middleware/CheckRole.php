<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response|RedirectResponse|never
    {
        if (!auth()->user()->hasRole($role) && !auth()->user()->hasRole('super-admin')) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
