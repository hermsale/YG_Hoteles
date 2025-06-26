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
     * funcion para confirmar y almacenar una reserva
     */
    public function store(Request $request)
    {
        // validamos los datos de la reserva
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_ingreso' => 'required|date',
            'fecha_egreso' => 'required|date|after:fecha_ingreso',
            'huespedes' => 'required|integer|min:1',
            'precio_total' => 'required|numeric|min:0',
        ]);
        // Verificamos que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debés iniciar sesión para reservar.');
        }

        // creamos una nueva reserva
        // y asignamos los datos del request
        $reserva = new Reserva();
        $reserva->id_usuario = Auth::id(); // o $request->user()->id
        $reserva->id_habitacion = $request->habitacion_id;
        $reserva->fecha_ingreso = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso);
        $reserva->fecha_egreso = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_egreso);
        $reserva->precio_final = $request->precio_total;
        $reserva->estado_reserva = 'Activa';
        $reserva->estado_pago = 'Pendiente'; // Estado inicial de pago
        $reserva->save();

        return redirect()->route('welcome')->with('success', 'Reserva confirmada correctamente.');
    }

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
