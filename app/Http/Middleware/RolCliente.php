<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolCliente
{
    /**
     * Handle an incoming request.
     *
     * Se gestiona los permisos del cliente
     */
    // Dentro de RolAdministrador.php
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->rol->nombre_rol === 'Cliente') {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }

}
