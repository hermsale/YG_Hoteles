<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'rol.admin' => \App\Http\Middleware\RolAdministrador::class,
            'rol.AdminRecepcionista' => \App\Http\Middleware\RolAdminRecepcionistaMiddleware::class,
            'rol.cliente' => \App\Http\Middleware\RolCliente::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
