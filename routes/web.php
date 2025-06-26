<?php

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


//  el metodo 'updateDescripcion'  es la comunicacion controlador. y el name es lo que hace la conexion con la vista, donde hay un form y un route
// Route::put('/cursos/{curso}', [CursoController::class, 'updateDescripcion'])->name('cursos.updateDescripcion');



Route::get('/dashboard', [DashboardController::class,'index']) // por buenas practicas el encarpetado va asi, dentro de backoffice
->middleware(['auth', 'verified', 'rol.AdminRecepcionista'])->name('dashboard');

// ruta hacia cliente habitaciones
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
// ruta hacia cliente fotos
Route::get('/fotos', [ImagenController::class, 'index'])->name('fotos.index');
Route::get('/resenia', [ResenaController::class, 'index'])->name('resenia.index');

// ruta hacia cliente reservas
Route::get('/reserva', [ReservaController::class, 'index'])->middleware(['auth', 'verified'])->name('reservas.index');
Route::get('/reserva/confirmar', [ReservaController::class, 'confirmar'])->name('reservas.confirmar');
Route::get('/reserva/detalle/{id}', [ReservaController::class, 'detalleReserva'])->middleware(['auth', 'verified'])->name('detalleReserva');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
