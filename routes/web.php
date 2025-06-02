<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// definimos la ruta de acceso '/cursos' y por medio de un array accedemos al CursoController y le indicamos el metodo a ejecutar
Route::get('/cursos', [
    CursoController::class,'index'
])->name('cursos.index'); // le indicamos nombre, para poder identificarlo en la vista



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); // le agrego un name a la ruta

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
