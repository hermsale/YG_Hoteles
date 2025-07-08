<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Categoria;
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
    public function editar(Habitacion $habitacion)
    {
        $habitacion = Habitacion::with(['categoria', 'imagenes', 'amenities'])->findOrFail($habitacion->id);
        return view('backoffice.habitaciones.editar', compact('habitacion'));
    }

    public function inhabilitar(Habitacion $habitacion){
        $habitacion = Habitacion::findOrFail($habitacion->id);
        // Cambiar el estado de la habitación a inactivo
        $habitacion->estado = 'Inactivo'; 
        $habitacion->save();

        return redirect()->route('habitaciones.index')->with('success', 'Habitación inhabilitada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitacion $habitacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitacion $habitacion)
    {
        //
    }
}
