<?php

namespace App\Http\Controllers;

use App\Models\Imagen;

class DashboardController extends Controller
{
    public function listaImgHabitacion()
    {
        $imagenes = Imagen::all(); // Obtiene todas las imágenes
        return view('dashboard', compact('imagenes')); // Pasa las imágenes a la vista dashboard.blade.php
    }
}
