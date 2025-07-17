<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Habitacion;
use App\Models\Calendario;
use App\Models\Reserva; // 👈 Asegurate de importar el modelo
use Illuminate\Support\Carbon;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        // 📅 Obtenemos el rango activo de fechas desde la tabla `calendarios`
        $rango = Calendario::first();

        if (!$rango) {
            return view('backoffice.calendario.sin-rango'); // ⛔ Si no hay calendario configurado
        }

        // 📆 Fecha base: seleccionada por el usuario o inicio del calendario
      $input = $request->input('fecha');

if ($input) {
    try {
        // Primero intentamos con formato nativo del input date
        $fechaBase = \Carbon\Carbon::createFromFormat('Y-m-d', $input)->startOfDay();
    } catch (\Exception $e) {
        try {
            // Luego intentamos con formato manual (d/m/Y)
            $fechaBase = \Carbon\Carbon::createFromFormat('d/m/Y', $input)->startOfDay();
        } catch (\Exception $e2) {
            $fechaBase = \Carbon\Carbon::parse($rango->fecha_inicio)->startOfDay(); // fallback
        }
    }
} else {
    $fechaBase = \Carbon\Carbon::parse($rango->fecha_inicio)->startOfDay();
}


        $fechaBase->locale('es');

        // 🚫 Si el usuario fuerza una fecha fuera del calendario
        if ($fechaBase->lt($rango->fecha_inicio) || $fechaBase->gt($rango->fecha_fin)) {
            return view('backoffice.calendario.fuera-rango', compact('rango', 'fechaBase'));
        }

        // 📆 Generamos TODAS las fechas del calendario desde inicio hasta fin
        $fechas = collect();
        $dia = Carbon::parse($rango->fecha_inicio);
        $fin = Carbon::parse($rango->fecha_fin);

        while ($dia->lte($fin)) {
            $fechas->push($dia->copy());
            $dia->addDay();
        }

        // 🏨 Traemos habitaciones
        $habitaciones = Habitacion::all();

        // 📊 Calculamos % de ocupación para cada día
        $ocupaciones = $fechas->mapWithKeys(function ($fecha) use ($habitaciones) {
            $ocupadas = 0;

            foreach ($habitaciones as $hab) {
                if ($hab->reservas()
                        ->whereDate('fecha_ingreso', '<=', $fecha)
                        ->whereDate('fecha_egreso', '>', $fecha)
                        ->exists()) {
                    $ocupadas++;
                }
            }

            $porcentaje = $habitaciones->count() > 0
                ? round(($ocupadas / $habitaciones->count()) * 100)
                : 0;

            return [$fecha->toDateString() => $porcentaje];
        });

        // 🔴 BLOQUE PARA PILL DE RESERVAS ───────────────────────────────
        // Traemos reservas activas dentro del rango actual del calendario
        $reservas = Reserva::with(['usuario', 'habitacion'])
            ->where('estado_reserva', '!=', 'Cancelada')
            ->whereDate('fecha_egreso', '>', $rango->fecha_inicio)
            ->whereDate('fecha_ingreso', '<', $rango->fecha_fin)
            ->get()
            ->groupBy('id_habitacion'); // agrupadas por habitación
        // ───────────────────────────────────────────────────────────────

        return view('backoffice.calendario.index', compact(
            'fechas',
            'habitaciones',
            'ocupaciones',
            'fechaBase',
            'reservas',
            'rango'
        ));
    }

    public function actualizarRango(Request $request)
    {
        logger('🟡 Paso 1: Entró al método actualizarRango');

        // ✅ Validamos que las fechas sean correctas
        $request->validate([
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);
        logger('🟡 Paso 2: Validación de fechas correcta', [
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        // 🛡️ Verificamos si existen reservas fuera del nuevo rango
        $reservaFueraDeRango = \App\Models\Reserva::where(function ($q) use ($request) {
            $q->whereDate('fecha_ingreso', '<', $request->fecha_inicio)
              ->orWhereDate('fecha_egreso', '>', $request->fecha_fin);
        })->exists();

        logger('🟡 Paso 3: Resultado de verificación de reservas fuera de rango', [
            'hayReservasFuera' => $reservaFueraDeRango,
        ]);

        if ($reservaFueraDeRango) {
            logger('🔴 Error: Hay reservas fuera del rango');
            return back()->with('error', 'No se puede establecer este rango. Existen reservas activas fuera del rango seleccionado.');
        }

        // 🔍 Buscamos el calendario actual
        $calendario = \App\Models\Calendario::first();
        logger('🟡 Paso 4: Resultado de Calendario::first()', ['calendario' => $calendario]);

        if ($calendario) {
            logger('🟢 Paso 5A: Calendario existente, vamos a actualizarlo');
            $calendario->fecha_inicio = $request->fecha_inicio;
            $calendario->fecha_fin = $request->fecha_fin;
            $calendario->updated_at = now(); // Forzamos que el modelo esté "dirty"

            logger('🟢 Paso 6A: Estado del modelo antes de guardar', [
                'isDirty' => $calendario->isDirty(),
                'dirtyFields' => $calendario->getDirty(),
            ]);

            $calendario->save();
            logger('🟢 Paso 7A: Calendario actualizado correctamente');
        } else {
            logger('🟢 Paso 5B: No hay calendario existente, creamos uno nuevo');

            \App\Models\Calendario::create([
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);

            logger('🟢 Paso 6B: Calendario creado correctamente');
        }

        logger('✅ Paso 8: Redireccionando con éxito');
        return redirect()->route('calendario.index')->with('success', 'Calendario actualizado correctamente.');
    }
    public function checkIn($id)
{
    $reserva = Reserva::findOrFail($id);

    if ($reserva->estado_reserva !== 'pendiente') {
        return response()->json(['success' => false, 'message' => 'Reserva no está pendiente.']);
    }

    $reserva->estado_reserva = 'Activa';
    $reserva->save();

    return response()->json(['success' => true, 'estado' => 'Activa']);
}

public function checkOut($id)
{
    $reserva = Reserva::findOrFail($id);

    if ($reserva->estado_reserva !== 'Activa') {
        return response()->json(['success' => false, 'message' => 'Reserva no está activa.']);
    }

    $reserva->estado_reserva = 'Finalizada';
    $reserva->save();

    return response()->json(['success' => true, 'estado' => 'Finalizada']);
}

public function cancelarAjax($id)
{
    $reserva = Reserva::findOrFail($id);

    if (in_array($reserva->estado_reserva, ['Cancelada', 'Finalizada'])) {
        return response()->json(['success' => false, 'message' => 'No se puede cancelar.']);
    }

    $reserva->estado_reserva = 'Cancelada';
    $reserva->save();

    return response()->json(['success' => true, 'estado' => 'Cancelada']);
}

}
