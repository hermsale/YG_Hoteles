<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolAdminRecepcionistaMiddleware
{
    /**
     * se creo este middleware para poder gestionar los permisos que tienen en comun recepcionista y administrador
     * 
     */

    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && in_array(auth()->user()->rol->nombre_rol, ['Recepcionista', 'Administrador'])) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado');
    }
}
