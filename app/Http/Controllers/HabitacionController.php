<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    /**
     * vistas de habitaciones
     */
    public function index(Request $request)
    {
         if ($request->filled(['fecha_entrada', 'fecha_salida'])) {
        $request->validate([
            'fecha_entrada' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_entrada',
        ], [
            'fecha_salida.after' => 'La fecha de salida debe ser posterior a la de entrada.',
        ]);
    }

        // Obtener todas las habitaciones
        $habitaciones = Habitacion::All();
        return view('cliente.habitaciones.index',  compact('habitaciones')); // Retorna la vista habitaciones.blade.php
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Show the form for editing the specified resource.
     */
    public function edit(Habitacion $habitacion)
    {
        //
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
