<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(401);
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}