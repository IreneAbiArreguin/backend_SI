<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // ← Agregar esta línea

class CheckRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verificar si el usuario está autenticado y tiene el rol
        if (!Auth::check()) { // ← Usar Auth::check()
            return redirect()->route('login');
        }

        if (Auth::user()->id_rol != $role) { // ← Usar Auth::user()
            abort(403, 'No tienes permisos para acceder a esta página.');
        }

        return $next($request);
    }
}