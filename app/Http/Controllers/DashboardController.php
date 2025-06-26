<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Reserva;
use Carbon\Carbon;

class DashboardController extends Controller
{

    // muestra la pantalla de bienvenida del backoffice
    public function index()
    {
         $hoy = Carbon::today();

        $totalLlegadas = Reserva::whereDate('fecha_ingreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        $totalSalidas = Reserva::whereDate('fecha_egreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        $totalAlojados = Reserva::where('fecha_ingreso', '<=', $hoy)
            ->where('fecha_egreso', '>=', $hoy)
            ->where('estado_reserva', 'Activa')
            ->where('check_in', true)
            ->count();

        return view('backoffice.dashboard.index', compact(
            'totalLlegadas', 'totalSalidas', 'totalAlojados'
        ));
    }
    // funcion para mostrar todas las imagenes de las habitaciones
    public function listaImgHabitacion()
    {
        $imagenes = Imagen::all(); // Obtiene todas las imágenes
        return view('backoffice.dashboard.index', compact('imagenes')); // Pasa las imágenes a la vista dashboard.blade.php
    }
}
