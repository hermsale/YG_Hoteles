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

        // Configuramos el locale de Carbon para español
        // Esto permite que las fechas se muestren en español
        // para que se muestre el nombre del dia y del mes en español
        // en la vista del dashboard
        $fechaHora = Carbon::now()->translatedFormat('l d \d\e F \d\e Y - H:i');
        $fechaHoraActualizada= ucwords($fechaHora);

        // traemos los datos de las reservas del dia de hoy
        // para mostrar en el dashboard
        $hoy = Carbon::today();

        // total de llegadas
        $totalLlegadas = Reserva::whereDate('fecha_ingreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        // total de salidas
        $totalSalidas = Reserva::whereDate('fecha_egreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        // total de alojados (los que estan alojados hoy)
        // alojados son los que tienen check_in true y estan en el rango de fechas
        // de ingreso y egreso de la reserva.
        $totalAlojados = Reserva::where('fecha_ingreso', '<=', $hoy)
            ->where('fecha_egreso', '>=', $hoy)
            ->where('estado_reserva', 'Activa')
            ->where('check_in', true)
            ->count();

        return view('backoffice.dashboard.index', compact(
            'totalLlegadas', 'totalSalidas', 'totalAlojados', 'fechaHoraActualizada'
        ));
    }
    // funcion para mostrar todas las imagenes de las habitaciones
    public function listaImgHabitacion()
    {
        $imagenes = Imagen::all(); // Obtiene todas las imágenes
        return view('backoffice.dashboard.index', compact('imagenes')); // Pasa las imágenes a la vista dashboard.blade.php
    }
}
