<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MiddlewareDjiye
{public function handle(Request $request, Closure $next, ...$roles)
    {
        // Vérifiez si l'utilisateur est connecté
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Vérifiez si l'utilisateur a le rôle requis
        foreach ($roles as $role) {
            if (auth()->user()->role == $role) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'Unauthorized'], 403);
    }
}

