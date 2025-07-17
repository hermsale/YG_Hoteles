<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CierreCaja;
use App\Models\TransaccionCaja;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CajaController extends Controller
{
    public function index()
    {
        return view('backoffice.caja.index');
    }

    public function guardarCierre(Request $request)
{

    Log::info("request ".$request);
    // ✅ Validación
    $validated = $request->validate([
        'transacciones' => 'required|array|min:1',
        'transacciones.*.concepto' => 'required|string',
        'transacciones.*.cliente' => 'nullable|string',
        'transacciones.*.monto' => 'required|numeric',
        'transacciones.*.metodo_pago_id' => 'required|exists:metodo_pago,id',
        'transacciones.*.comentario' => 'nullable|string',
        'transacciones.*.usuario_id' => 'nullable|integer',
    ]);

    $fecha = Carbon::parse($request->input('fecha'))->startOfDay();


    // ✅ Verificamos si ya hay un cierre para hoy
    $cierreExistente = CierreCaja::whereDate('fecha', $fecha)->first();

    if ($cierreExistente) {
        return response()->json([
            'existe' => true,
            'mensaje' => 'Ya existe un cierre de caja para hoy. ¿Deseás sobrescribirlo?'
        ]);
    }

    // ✅ Calculamos el total del cierre
    $total = collect($validated['transacciones'])->sum('monto');

    // ✅ Creamos el cierre
    $cierre = CierreCaja::create([
        'fecha' => $fecha,
        'total' => $total,
        'usuario_id' => Auth::id()
    ]);

    // ✅ Creamos las transacciones asociadas
    foreach ($validated['transacciones'] as $transaccion) {
        TransaccionCaja::create([
            'concepto' => $transaccion['concepto'],
            'cliente' => $transaccion['cliente'] ?? null,
            'monto' => $transaccion['monto'],
            'metodo_pago_id' => $transaccion['metodo_pago_id'],
            'comentario' => $transaccion['comentario'] ?? null,
            'usuario_id' => $transaccion['usuario_id'] ?? Auth::id(),
            'cierre_caja_id' => $cierre->id,
        ]);
    }

    return response()->json(['success' => true, 'mensaje' => '✅ Cierre de caja guardado correctamente.']);
}
// Método para listar cierres de caja
public function listarCierres()
{
    $cierres = CierreCaja::orderByDesc('fecha')->get();

    return response()->json($cierres);
}
// Método para ver detalle de un cierre específico
public function verDetalle($id)
{
    $cierre = CierreCaja::with(['transacciones.usuario', 'transacciones.metodoPago', 'usuario'])->findOrFail($id);

    return response()->json([
        'cierre' => $cierre,
        'transacciones' => $cierre->transacciones
    ]);
}



}
