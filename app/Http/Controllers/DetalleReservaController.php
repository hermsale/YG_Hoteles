<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;

class DetalleReservaController extends Controller
{
    /**
     * Muestra el panel de detalles de una reserva desde el backoffice.
     * Solo accesible por administradores y recepcionistas.
     */
    public function show($id)
    {
        // Cargamos la reserva con sus relaciones (cliente y habitación)
        $reserva = Reserva::with(['usuario', 'habitacion'])->findOrFail($id);

        return view('backoffice.reservas.detallesdereservas', compact('reserva'));
    }
}
