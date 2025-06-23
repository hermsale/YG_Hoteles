<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolRecepcionista
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // Dentro de RolAdministrador.php
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol->nombre_rol === 'Recepcionista') {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }

}
