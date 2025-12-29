<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // Seguridad extra
        if (!$user || !$user->role) {
            abort(403, 'Acceso no autorizado');
        }

        // Verificar si el rol del usuario está permitido
        if (!in_array($user->role->name, $roles)) {
            abort(403, 'No tienes permisos para acceder aquí');
        }

        return $next($request);
    }
}
