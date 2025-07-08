<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    /**
     * muestro todas las reservas del usuario logueado
     */
    public function index()
    {
        $reservas = Reserva::where('id_usuario', Auth::id())
            ->with(['habitacion.categoria'])
            ->orderBy('fecha_creacion', 'desc') // Carga eficiente para la tabla
            ->get();

        return view('cliente.reservas.index', compact('reservas'));
    }

    // Gestion de Reservas en el Backoffice
    public function indexBackoffice()
    {
        if (!in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Recepcionista'])) {
            abort(403, 'Acceso no autorizado.');
        }

        $reservas = Reserva::with(['usuario', 'habitacion.categoria'])
            ->orderByDesc('fecha_ingreso')
            ->get();

        return view('backoffice.reservas.index', compact('reservas'));
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
        $cantidadNoches = $fechaEntrada->diffInDays($fechaSalida); // calculo la cantidad de noches entre las fechas
        $importeTotal = $cantidadNoches * $habitacion->precio_noche; // calculo del importe total

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
    public function confirmarYGuardar(Request $request)
    {
        Log::info('Se ejecutó confirmar y guardar Reserva');

        try {
            // validamos los datos de la reserva
            $request->validate([
                'habitacion_id' => 'required|exists:habitaciones,id',
                'fecha_ingreso' => ['required', 'regex:/^\d{2}\/\d{2}\/\d{4}$/'], // Formato dd/mm/yyyy
                'fecha_egreso' => ['required', 'regex:/^\d{2}\/\d{2}\/\d{4}$/'],
                'precio_total' => 'required|numeric|min:0',
            ]);
            Log::info('Datos de reserva validados correctamente');
        } catch (\Exception $e) {
            Log::error('Error al validar los datos de la reserva: ' . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
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
        $reserva->aviso_pago = false; // Estado inicial aviso de pago
        $reserva->fecha_creacion = now();

        $reserva->save();
        // registramos la reserva en el log
        Log::info('ID de reserva creada: ' . $reserva->id);
        // redirigimos al usuario a la lista de reservas con un mensaje de éxito
        return redirect()->route('reservas.index')->with('success', 'Reserva confirmada correctamente.');
    }

    // funcion para dar aviso de pago de una reserva
    public function avisoPago(string $id)
    {
        Log::info('Se ejecutó aviso de pago');
        $reserva = Reserva::where('id', $id)->where('id_usuario', Auth::id())->firstOrFail();

        if ($reserva->estado_pago !== 'Pendiente') {
            return back()->with('error', 'No se puede dar aviso de pago en este estado.');
        }

        Log::info($reserva->aviso_pago);
        $reserva->aviso_pago = true;
        $reserva->save();

        return back()->with('success', 'Aviso de pago enviado correctamente.');
    }

    // funcion para confirmar el pago de una reserva
    // Esta función se ejecuta cuando el usuario confirma que ha realizado el pago
    // y el administrador o recepcionista confirma que si se pago
    public function pagoConfirmado(string $id)
    {
        if (!in_array(Auth::user()->rol->nombre_rol, ['Administrador', 'Recepcionista'])) {
            abort(403, 'Acceso no autorizado.');
        }

        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado_pago !== 'Pendiente' || !$reserva->aviso_pago) {
            return back()->with('error', 'El pago no puede confirmarse. Verificá el estado.');
        }

        $reserva->estado_pago = 'Pagado';
        $reserva->save();

        return back()->with('success', 'Pago confirmado correctamente.');
    }

    // boton para cancelar una reserva
    public function cancelarReserva(string $id)
    {
        Log::info('Se ejecutó cancelar reserva');
        $reserva = Reserva::where('id', $id)->where('id_usuario', Auth::id())->firstOrFail();

        // Verificar si la reserva está en un estado que permite cancelación
        if ($reserva->estado_reserva !== 'Activa') {
            return back()->with('error', 'No se puede cancelar una reserva que no está activa.');
        }

        // Cambiar el estado de la reserva a cancelada
        $reserva->estado_reserva = 'Cancelada';
        $reserva->estado_pago = 'Cancelado';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    /**
     * muestro los detalles de una reserva específica
     */
    public function detalleReserva(string $id)
    {
        $reserva = Reserva::with(['habitacion.categoria', 'habitacion.imagenes'])->findOrFail($id);

        // parseo las fechas de ingreso y egreso
        $fechaIngreso = \Carbon\Carbon::parse($reserva->fecha_ingreso);
        $fechaEgreso = \Carbon\Carbon::parse($reserva->fecha_egreso);

        // Calcular la cantidad de noches
        $cantidadNoches =   $fechaIngreso->diffInDays($fechaEgreso);

        // Verificar que la reserva le pertenezca al usuario logueado
        if ($reserva->id_usuario !== Auth::id()) {
            abort(403, 'No tenés permiso para ver esta reserva.');
        }

        return view('cliente.reservas.detalle', compact('reserva', 'cantidadNoches'));
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
