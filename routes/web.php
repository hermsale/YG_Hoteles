<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ResenaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
