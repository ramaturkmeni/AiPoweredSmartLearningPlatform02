<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'غير مصرح لك بالوصول.');
        }

        return $next($request);
    }
}