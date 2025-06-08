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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
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
