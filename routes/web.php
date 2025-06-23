<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// // definimos la ruta de acceso '/cursos' y por medio de un array accedemos al CursoController y le indicamos el metodo a ejecutar


//  el metodo 'updateDescripcion'  es la comunicacion controlador. y el name es lo que hace la conexion con la vista, donde hay un form y un route
// Route::put('/cursos/{curso}', [CursoController::class, 'updateDescripcion'])->name('cursos.updateDescripcion');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); // le agrego un name a la ruta

Route::get('/dashboard',
 [DashboardController::class, 'listaImgHabitacion'])->middleware
 (['auth', 'verified','rol.AdminRecepcionista'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
