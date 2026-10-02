<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = auth()->user();

        if ($user && $user->role && $user->role->name === $role) {
            return $next($request);
        }

        abort(403, 'Unauthorized - You do not have the required role: ' . $role);
    }
}
