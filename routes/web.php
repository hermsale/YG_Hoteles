<?php

use App\Http\Controllers\CajaController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ResenaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\RolAdministrador;
use App\Http\Middleware\RolAdminRecepcionistaMiddleware;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


// ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// backoffice
// definimos la ruta de acceso '/dashboard' y por medio de un array accedemos al DashboardController y le indicamos el metodo a ejecutar
Route::get('/dashboard', [DashboardController::class,'index']) // por buenas practicas el encarpetado va asi, dentro de backoffice
->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('dashboard');

Route::get('/calendario', [CalendarioController::class, 'index'])->
middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('calendario.index');

Route::get('/dashboard/reservas', [ReservaController::class, 'indexBackoffice'])
->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('reservas.indexBackoffice');

Route::post('/reservas/{id}/confirmar-pago', [ReservaController::class, 'pagoConfirmado'])->
middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('reservas.pagoConfirmado');

// habitaciones CRUD - SOLAMENTE ACCESO ADMINISTRADOR ///////////////////////////////////////////////////////////////
Route::get('backoffice/habitaciones', [HabitacionController::class, 'indexBackoffice'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.index');

// ruta para crear una habitacion
Route::get('backoffice/habitaciones/crear', [HabitacionController::class, 'crear'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.crear');

// se usa el metodo post para guardar los datos de la habitacion en la bd
Route::post('backoffice/habitaciones', [HabitacionController::class, 'store'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.store');

// HABILITAR habitación (pasar de Inactivo a Activo)
Route::post('backoffice/habitaciones/{habitacion}/habilitar', [HabitacionController::class, 'habilitar'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.habilitar');
// INHABILITAR habitación (pasar de Activo a Inactivo)
Route::post('backoffice/habitaciones/{habitacion}/inhabilitar', [HabitacionController::class, 'inhabilitar'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.inhabilitar');

// ruta para editar una habitacion
// se usa el metodo get para mostrar el formulario de edicion de la habitacion
Route::get('backoffice/habitaciones/{id}/editar',[HabitacionController::class, 'editar'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.editar');

// funcion para actualizar una habitacion
// se usa el metodo put para actualizar los datos de la habitacion
Route::put('backoffice/habitaciones/{habitacion}/update', [HabitacionController::class, 'update'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.update');

// funcion para eliminar una habitacion
Route::delete('backoffice/habitaciones/{habitacion}/destroy', [HabitacionController::class, 'destroy'])->
middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('backoffice.habitaciones.destroy');
// funcion para eliminar una imagen de una habitacion
Route::delete('backoffice/habitaciones/{id}/imgDestroy', [ImagenController::class, 'destroy'])->
middleware(['auth', 'verified', 'rol.admin'])->name('backoffice.habitaciones.imgDestroy');

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// CRUD  de usuarios - solo visto para administradores
Route::middleware(['auth','verified', 'rol.admin'])->group(function () {
    Route::get('backoffice/usuarios', [UsuarioController::class, 'index'])->name('backoffice.usuarios.index');
    Route::get('backoffice/usuarios/crear', [UsuarioController::class, 'crearUsuario'])->name('backoffice.usuarios.crear');
    Route::post('backoffice/usuarios', [UsuarioController::class, 'store'])->name('backoffice.usuarios.store');
    Route::post('backoffice/usuarios/{usuario}/resetear-clave', [UsuarioController::class, 'resetearClave'])->name('backoffice.usuarios.resetearClave');
    Route::delete('backoffice/usuarios/{id}/destroy', [UsuarioController::class, 'destroy'])->name('backoffice.usuarios.destroy');
});


Route::get('backoffice/reservas',[ReservaController::class, 'indexBackoffice'])->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('backoffice.reservas.index');
// ruta para crear una reserva desde el backoffice
Route::get('backoffice/reservas/crear', [ReservaController::class, 'reservaBackoffice'])->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('backoffice.reservas.crear');
// ruta para cancelar una reserva desde el backoffice
Route::post('dashboard/reservas/{id}/cancelar', [ReservaController::class, 'cancelarReservaBackoffice'])->middleware('auth','verified','rol.AdminRecepcionista')->name('backoffice.reservas.cancelarReserva');


// Cliente
// ruta hacia cliente habitaciones
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones/disponibilidad', [HabitacionController::class, 'disponibilidad'])->name('habitaciones.disponibilidad');

// vista de contacto
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');

// ruta hacia cliente fotos
Route::get('/fotos', [ImagenController::class, 'index'])->name('fotos.index');
Route::get('/resenia', [ResenaController::class, 'index'])->name('resenia.index');

// ruta hacia cliente reservas
Route::get('/reserva', [ReservaController::class, 'index'])->middleware(['auth', 'verified'])->name('reservas.index');
Route::get('/reserva/confirmar', [ReservaController::class, 'confirmar'])->middleware(['auth', 'verified'])->name('reservas.confirmar');
Route::get('/reserva/detalle/{id}', [ReservaController::class, 'detalleReserva'])->middleware(['auth', 'verified'])->name('reservas.detalleReserva');

// se crea para mostrar el aviso de pago
Route::post('/reserva/detalle/{id}/aviso-pago', [ReservaController::class, 'avisoPago'])->middleware(['auth', 'verified'])->name('reservas.avisoPago');

Route::post('/reserva/detalle/{id}/cancelar', [ReservaController::class, 'cancelarReserva'])->middleware('auth','verified')->name('reservas.cancelarReserva');

// se crea la ruta para reservar una habitacion     ||controlador        || nombre de la funcion     || nombre de la ruta personalizada
Route::post('/reserva/confirmar', [ReservaController::class, 'confirmarYGuardar'])->middleware(['auth','verified'])->name('reservas.confirmarYGuardar');

// rutas agus



    Route::post('/calendario/actualizar-rango', [CalendarioController::class, 'actualizarRango'])
    ->name('calendario.actualizar-rango')
    ->middleware('auth', RolAdministrador::class); // Solo admin

    Route::post('/reserva/{id}/checkin', [ReservaController::class, 'checkIn'])->name('reservas.checkin');
    Route::post('/reserva/{id}/checkout', [ReservaController::class, 'checkOut'])->name('reservas.checkout');
    Route::post('/reserva/{id}/cancelar', [ReservaController::class, 'cancelarAjax'])->name('reservas.cancelarAjax'); //AJAX para las pills
    Route::post('/reserva/{id}/dejar-pendiente', [ReservaController::class, 'dejarPendiente'])->name('reservas.dejarPendiente');

    Route::post('/reserva/actualizar-posicion', [ReservaController::class, 'actualizarPosicion']);

    //Rutas para el crud de reserva desde la vista de detalle de reserva
    Route::put('/reservas/{id}/actualizar-fechas', [ReservaController::class, 'actualizarFechas'])
    ->name('reservas.actualizarFechas')
    ->middleware(RolAdminRecepcionistaMiddleware::class);
    Route::put('/reservas/{id}/actualizar-total', [ReservaController::class, 'actualizarTotal'])
    ->name('reservas.actualizarTotal')
    ->middleware(RolAdminRecepcionistaMiddleware::class);
    Route::put('/reservas/{id}/actualizar-estado', [ReservaController::class, 'actualizarEstado'])
    ->name('reservas.actualizarEstado')
    ->middleware(RolAdminRecepcionistaMiddleware::class);
    Route::put('/reservas/{id}/actualizar-pago', [ReservaController::class, 'actualizarPago'])
    ->name('reservas.actualizarPago')
    ->middleware(RolAdminRecepcionistaMiddleware::class);


   //Rutas para la vista de caja
    Route::get('/caja', [CajaController::class, 'index'])
    ->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])
    ->name('caja.index');
    Route::get('/cierres-caja', [CajaController::class, 'listarCierres'])
    ->middleware(['auth', 'verified', 'rol.AdminRecepcionista']);
    Route::get('/cierres/{id}/transacciones', [CajaController::class, 'verDetalle'])
    ->name('caja.verDetalle')
    ->middleware(['auth', 'verified', 'rol.AdminRecepcionista']);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::delete('/reservas/{id}', [ReservaController::class, 'eliminar'])
    ->name('reservas.eliminar')
    ->middleware(['auth', RolAdminRecepcionistaMiddleware::class]);

require __DIR__.'/auth.php';

Route::post('/caja/cierre', [CajaController::class, 'guardarCierre'])
    ->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])
    ->name('caja.guardarCierre');
