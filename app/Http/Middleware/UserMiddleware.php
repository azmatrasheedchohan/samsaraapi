<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Allow access if the user is authenticated and has either 'user' or 'admin' role
        if (auth()->check() && (auth()->user()->role === 'user' || auth()->user()->role === 'admin')) {
            return $next($request);
        }

        // If the condition fails, deny access
        abort(403, 'Unauthorized access');
    }
}
