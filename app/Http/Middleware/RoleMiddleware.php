<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- ini penting

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $role)) {
            abort(403, 'Akses embungen.');
        }

        return $next($request);
    }
}
