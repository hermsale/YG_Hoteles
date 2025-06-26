<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * muestro todas las reservas del usuario logueado
     */
    public function index()
    {
        $reservas = Reserva::where('id_usuario', Auth::id())
            ->with(['habitacion.categoria']) // Carga eficiente para la tabla
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }


    /**
     * pantalla para confirmar una reserva
     */


    // método para confirmar una reserva
    public function confirmar(Request $request)
    {
        $habitacion = Habitacion::with('categoria')->findOrFail($request->habitacion_id);

        $fechaEntrada = new \Carbon\Carbon($request->fecha_entrada);
        $fechaSalida = new \Carbon\Carbon($request->fecha_salida);
        $cantidadNoches = $fechaEntrada->diffInDays($fechaSalida);
        $importeTotal = $cantidadNoches * $habitacion->precio_noche;

        return view('cliente.reservas.confirmar', [
            'habitacion' => $habitacion,
            'fechaEntrada' => $fechaEntrada->format('d/m/Y'),
            'fechaSalida' => $fechaSalida->format('d/m/Y'),
            'cantidadNoches' => $cantidadNoches,
            'importeTotal' => $importeTotal,
            'huespedes' => $request->huespedes,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * muestro los detalles de una reserva específica
     */
    public function detalleReserva(string $id)
    {
        $reserva = Reserva::with(['habitacion.categoria', 'habitacion.imagenes'])->findOrFail($id);

        // Verificar que la reserva le pertenezca al usuario logueado
        if ($reserva->id_usuario !== Auth::id()) {
            abort(403, 'No tenés permiso para ver esta reserva.');
        }

        return view('cliente.reservas.detalle', compact('reserva'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
