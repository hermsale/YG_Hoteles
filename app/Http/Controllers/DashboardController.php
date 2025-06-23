<?php

namespace App\Http\Controllers;

use App\Models\Imagen;

class DashboardController extends Controller
{

    // muestra la pantalla de bienvenida del backoffice
    public function index()
    {
        return view('backoffice.dashboard'); // Retorna la vista dashboard.blade.php
    }
    // funcion para mostrar todas las imagenes de las habitaciones
    public function listaImgHabitacion()
    {
        $imagenes = Imagen::all(); // Obtiene todas las imágenes
        return view('dashboard', compact('imagenes')); // Pasa las imágenes a la vista dashboard.blade.php
    }
}
