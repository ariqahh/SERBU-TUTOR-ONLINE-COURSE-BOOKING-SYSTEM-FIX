<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // memeriksa jika bukan user/jika belum login/ tidak punya role maka akan ditolak
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Akses ditolak.');
        }
        return $next($request);
    }
}

