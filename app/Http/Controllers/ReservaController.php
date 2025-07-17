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
     * Muestra todas las reservas, según el tipo de usuario
     */
    public function index()
    {
        $usuario = Auth::user();

        if (in_array($usuario->rol->nombre_rol, ['Administrador', 'Recepcionista'])) {
            $reservas = Reserva::with(['habitacion.categoria', 'usuario'])
                ->orderBy('fecha_creacion', 'desc')
                ->get();
        } else {
            $reservas = Reserva::where('id_usuario', $usuario->id)
                ->with(['habitacion.categoria'])
                ->orderBy('fecha_creacion', 'desc')
                ->get();
        }

        return view('cliente.reservas.index', compact('reservas'));
    }

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

    public function confirmarYGuardar(Request $request)
    {
        Log::info('Se ejecutó confirmar y guardar Reserva');

        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'fecha_ingreso' => ['required', 'regex:/^\d{2}\/\d{2}\/\d{4}$/'],
            'fecha_egreso' => ['required', 'regex:/^\d{2}\/\d{2}\/\d{4}$/'],
            'precio_total' => 'required|numeric|min:0',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debés iniciar sesión para reservar.');
        }

        $reserva = new Reserva();
        $reserva->id_usuario = Auth::id();
        $reserva->id_habitacion = $request->habitacion_id;
        $reserva->fecha_ingreso = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_ingreso);
        $reserva->fecha_egreso = \Carbon\Carbon::createFromFormat('d/m/Y', $request->fecha_egreso);
        $reserva->precio_final = $request->precio_total;
        $reserva->estado_reserva = 'Activa';
        $reserva->estado_pago = 'Pendiente';
        $reserva->aviso_pago = false;
        $reserva->fecha_creacion = now();
        $reserva->save();

        Log::info('ID de reserva creada: ' . $reserva->id);

        return redirect()->route('reservas.index')->with('success', 'Reserva confirmada correctamente.');
    }

    public function avisoPago(string $id)
    {
        $reserva = Reserva::where('id', $id)->where('id_usuario', Auth::id())->firstOrFail();

        if ($reserva->estado_pago !== 'Pendiente') {
            return back()->with('error', 'No se puede dar aviso de pago en este estado.');
        }

        $reserva->aviso_pago = true;
        $reserva->save();

        return back()->with('success', 'Aviso de pago enviado correctamente.');
    }

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

    public function cancelarReserva(string $id)
    {
        $reserva = Reserva::where('id', $id)->where('id_usuario', Auth::id())->firstOrFail();

        if ($reserva->estado_reserva !== 'Activa') {
            return back()->with('error', 'No se puede cancelar una reserva que no está activa.');
        }

        $reserva->estado_reserva = 'Cancelada';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    public function cancelarReservaBackoffice(string $id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado_reserva !== 'Activa') {
            return back()->with('error', 'No se puede cancelar una reserva que no está activa.');
        }

        $reserva->estado_reserva = 'Cancelada';
        $reserva->save();

        return back()->with('success', 'Reserva cancelada correctamente.');
    }

    public function detalleReserva(string $id)
    {
        $reserva = Reserva::with(['habitacion.categoria', 'habitacion.imagenes'])->findOrFail($id);
        $fechaIngreso = \Carbon\Carbon::parse($reserva->fecha_ingreso);
        $fechaEgreso = \Carbon\Carbon::parse($reserva->fecha_egreso);
        $cantidadNoches = $fechaIngreso->diffInDays($fechaEgreso);

        if (Auth::user()->rol->nombre_rol === 'Cliente' && $reserva->id_usuario !== Auth::id()) {
            abort(403, 'No tenés permiso para ver esta reserva.');
        }

        return view('cliente.reservas.detalle', compact('reserva', 'cantidadNoches'));
    }

    public function reservaBackoffice()
    {
        return view('backoffice.reservas.crear');
    }

    // Métodos nuevos para gestión en el calendario
    public function checkIn($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado_reserva !== 'pendiente') {
            return response()->json(['success' => false, 'message' => 'Solo se puede hacer check-in si la reserva está pendiente.']);
        }

        $reserva->estado_reserva = 'Activa';
        $reserva->save();

        return response()->json(['success' => true, 'estado' => 'Activa']);
    }

    public function checkOut($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado_reserva !== 'Activa') {
            return response()->json(['success' => false, 'message' => 'Solo se puede hacer check-out si la reserva está activa.']);
        }

        $reserva->estado_reserva = 'Finalizada';
        $reserva->save();

        return response()->json(['success' => true, 'estado' => 'Finalizada']);
    }

    public function cancelarAjax($id)
    {
        $reserva = Reserva::findOrFail($id);

        if (in_array($reserva->estado_reserva, ['Cancelada', 'Finalizada'])) {
            return response()->json(['success' => false, 'message' => 'La reserva ya está cancelada o finalizada.']);
        }

        $reserva->estado_reserva = 'Cancelada';
        $reserva->save();

        return response()->json(['success' => true, 'estado' => 'Cancelada']);
    }

    public function dejarPendiente($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->estado_reserva !== 'Activa') {
            return response()->json(['success' => false, 'message' => 'Solo podés revertir una reserva activa a pendiente.']);
        }

        $reserva->estado_reserva = 'pendiente';
        $reserva->save();

        return response()->json(['success' => true, 'estado' => 'pendiente']);
    }

    public function actualizarPosicion(Request $request)
    {
        $reserva = Reserva::find($request->id);

        if (!$reserva) {
            return response()->json(['success' => false, 'message' => 'Reserva no encontrada']);
        }

        $reserva->fecha_ingreso = $request->nueva_fecha_ingreso;
        $reserva->fecha_egreso = $request->nueva_fecha_egreso;
        $reserva->id_habitacion = $request->nueva_id_habitacion;
        $reserva->save();

        return response()->json(['success' => true]);
    }

    public function verDetalle($id)
    {
        $reserva = Reserva::with(['usuario', 'habitacion.categoria', 'habitacion.imagenes', 'promocion'])->findOrFail($id);
        $cantidadNoches = $reserva->fecha_ingreso->diffInDays($reserva->fecha_egreso);

        return view('backoffice.reservas.detalle', compact('reserva', 'cantidadNoches'));
    }

    public function actualizarFechas(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'fecha_ingreso' => 'required|date',
            'fecha_egreso' => 'required|date|after:fecha_ingreso',
        ]);

        $reserva->fecha_ingreso = $request->fecha_ingreso;
        $reserva->fecha_egreso = $request->fecha_egreso;
        $reserva->save();

        return back()->with('success', 'Fechas actualizadas correctamente.');
    }

    public function actualizarTotal(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'precio_final' => 'required|numeric|min:0',
        ]);

        $reserva->precio_final = $request->precio_final;
        $reserva->save();

        return back()->with('success_total', 'El total a pagar fue actualizado correctamente.');
    }

    public function actualizarEstado(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'estado_reserva' => 'required|in:Activa,Finalizada,Cancelada,Pendiente',
        ]);

        $reserva->estado_reserva = $request->estado_reserva;
        $reserva->save();

        return back()->with('success_estado', 'Estado de reserva actualizado correctamente.');
    }

    public function actualizarPago(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'estado_pago' => 'required|in:Pendiente,Pagado,Cancelado',
        ]);

        $reserva->estado_pago = $request->estado_pago;
        $reserva->save();

        return back()->with('success_pago', 'Estado de pago actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->trashed()) {
            return back()->with('error', 'La reserva ya fue eliminada.');
        }

        $reserva->delete();

        return redirect()->route('reservas.indexBackoffice')->with('success_eliminar', 'La reserva fue eliminada correctamente.');
    }
}
