<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->role === $role) {
            return $next($request);
        }
        //abort(403, 'Accès refusé.');
        
        return response()->json('Accès refusé.',403);

    }
}