<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Categoria;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * vistas de habitaciones
     */
    public function index(Request $request)
    {

        // Obtener todas las habitaciones
        $habitaciones = Habitacion::All();
        return view('cliente.habitaciones.index',  compact('habitaciones')); // Retorna la vista habitaciones.blade.php
        //
    }

    public function indexBackoffice(Request $request)
    {
        // Obtener todas las habitaciones
        $habitaciones = Habitacion::with(['imagenes', 'categoria', 'amenities'])->get();
        return view('backoffice.habitaciones.index', compact('habitaciones')); // Retorna la vista habitaciones.blade.php
    }

    // funcion para verificar la disponibilidad de habitaciones
    public function disponibilidad(Request $request)
    {
        // Validar las fechas de entrada y salida
        $request->validate([
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_entrada', // validamos que la fecha de salida sea posterior a la de entrada
        ], [
            // Mensajes de error personalizados
            'fecha_entrada.required' => 'La fecha de entrada es obligatoria.',
            'fecha_entrada.date' => 'La fecha de entrada debe ser una fecha válida.',
            'fecha_salida.required' => 'La fecha de salida es obligatoria.',
            'fecha_salida.date' => 'La fecha de salida debe ser una fecha válida.',
            'fecha_salida.after' => 'La fecha de salida debe ser posterior a la de entrada.',
        ]);


        $query = Habitacion::query();

        // query para filtrar habitaciones activas
        // solo se muestran las habitaciones que están activas
        $query->where('estado', 'Activo');
        // query para verificar disponibilidad segun capacidad de huespedes
        if ($request->filled('huespedes')) {
            $query->where('capacidad', '>=', (int) $request->huespedes);
        }

        // query para filtrar habitaciones disponibles según las fechas de entrada y salida
        if ($request->filled(['fecha_entrada', 'fecha_salida'])) {
            $fechaEntrada = $request->fecha_entrada;
            $fechaSalida = $request->fecha_salida;

            $query->whereDoesntHave('reservas', function ($q) use ($fechaEntrada, $fechaSalida) {
                $q->where('estado_reserva', 'Activa')
                    ->where(function ($query) use ($fechaEntrada, $fechaSalida) {
                        $query->where(function ($q) use ($fechaEntrada) {
                            $q->where('fecha_egreso', '>', $fechaEntrada);
                        })->where(function ($q) use ($fechaSalida) {
                            $q->where('fecha_ingreso', '<', $fechaSalida);
                        });
                    });
            });
        }

        // Obtener todas las habitaciones
        $habitaciones =  $query->with(['imagenes', 'categoria', 'amenities'])->get();
        return view('cliente.habitaciones.disponibilidad', compact('habitaciones')); // Retorna la vista disponibilidad.blade.php
    }
    /**
     * funcion para crear una habitacion
     */
    public function crear()
    {
        $categorias = Categoria::all();
        $amenities = Amenity::all();

        return view('backoffice.habitaciones.crear', compact('categorias', 'amenities'));
    }


    /**
     * funcion para almacenar una habitacion
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Habitacion $habitacion)
    {
        //
    }

    /**
     * funcion para editar una habitacion
     */
    public function editar($id)
{
    // guardo todo lo que viene del id de la habitacion que se quiere editar
    $habitacion = Habitacion::with(['imagenes', 'categoria', 'amenities'])->findOrFail($id);
    // traigo todas las categorias y amenities disponibles
    $categorias = Categoria::all();
    $amenities = Amenity::all();

    return view('backoffice.habitaciones.editar', compact('habitacion', 'categorias', 'amenities'));
}

    // funcion para inhabilitar una habitacion
    // se cambia el estado de la habitacion a Inactivo
    public function inhabilitar(Habitacion $habitacion)
    {
        $habitacion->estado = 'Inactivo';
        $habitacion->save();

        return redirect()->route('backoffice.habitaciones.index')
            ->with('success', 'Habitación inhabilitada correctamente.');
    }

    // funcion para habilitar una habitacion
    // se cambia el estado de la habitacion a Activo
    public function habilitar(Habitacion $habitacion)
    {

        $habitacion->estado = 'Activo';
        $habitacion->save();

        return redirect()->route('backoffice.habitaciones.index')
            ->with('success', 'Habitación habilitada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        Log::info('Se ingresó al método update.', ['id' => $habitacion->id]);
        Log::info('request ', $request->all());
        // Validar los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'capacidad' => 'required|integer|min:1',
            'precio_noche' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'amenities' => 'array',
            'amenities.*' => 'exists:amenities,id',
        ]);

        // Actualizar los datos de la habitación
        $habitacion->update($request->only([
            'nombre',
            'descripcion',
            'capacidad',
            'precio_noche',
            'categoria_id',
        ]));

        // Sincronizar las amenities
        $habitacion->amenities()->sync($request->amenities);

        return redirect()->route('backoffice.habitaciones.index')
            ->with('success', 'Habitación actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        //
    }
}
