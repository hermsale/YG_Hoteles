<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

class RolAdministrador
{
    public function handle(Request $request, Closure $next)
    {
        // se gestiona los permisos exclusivos del administrador
        if (Auth::check() && Auth::user()->rol->nombre_rol === 'Administrador') {
            return $next($request);
        }
        //  rol (singular), porque estás usando belongsTo, y accedés a nombre_rol desde la tabla roles.

        abort(403, 'Acceso no autorizado');
    }

}
