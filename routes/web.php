<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\ResenaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


// ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// // definimos la ruta de acceso '/cursos' y por medio de un array accedemos al CursoController y le indicamos el metodo a ejecutar



// backoffice
// definimos la ruta de acceso '/dashboard' y por medio de un array accedemos al DashboardController y le indicamos el metodo a ejecutar
Route::get('/dashboard', [DashboardController::class,'index']) // por buenas practicas el encarpetado va asi, dentro de backoffice
->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('dashboard');
Route::get('/calendario', [CalendarioController::class, 'index'])->
middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('calendario.index');


// ruta hacia cliente habitaciones
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones/disponibilidad', [HabitacionController::class, 'disponibilidad'])->name('habitaciones.disponibilidad');


// ruta hacia cliente fotos
Route::get('/fotos', [ImagenController::class, 'index'])->name('fotos.index');
Route::get('/resenia', [ResenaController::class, 'index'])->name('resenia.index');

// ruta hacia cliente reservas
Route::get('/reserva', [ReservaController::class, 'index'])->middleware(['auth', 'verified'])->name('reservas.index');
Route::get('/reserva/confirmar', [ReservaController::class, 'confirmar'])->middleware(['auth', 'verified'])->name('reservas.confirmar');
Route::get('/reserva/detalle/{id}', [ReservaController::class, 'detalleReserva'])->middleware(['auth', 'verified'])->name('reservas.detalleReserva');

// se crea para mostrar el aviso de pago
Route::post('/reserva/detalle/{id}/aviso-pago', [ReservaController::class, 'avisoPago'])->name('reservas.avisoPago');
Route::post('/reserva/detalle/{id}/cancelar', [ReservaController::class, 'cancelarReserva'])->name('reservas.cancelarReserva');

// se crea la ruta para reservar una habitacion     ||controlador        || nombre de la funcion     || nombre de la ruta personalizada
Route::post('/reserva/confirmar', [ReservaController::class, 'confirmarYGuardar'])->name('reservas.confirmarYGuardar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
