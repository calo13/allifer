<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Si el usuario tiene alguno de los roles permitidos
        foreach ($roles as $role) {
            if (auth()->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Si es cliente, redirigir al catálogo
        if (auth()->user()->hasRole('Cliente')) {
            return redirect()->route('catalogo')->with('error', 'No tienes permisos para acceder a esa sección.');
        }

        abort(403, 'No tienes permisos para acceder a esta sección.');
    }
}
