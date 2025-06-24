<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $reservas = Reserva::where('id_usuario', Auth::id())
                ->with(['habitacion.categoria']) // Carga eficiente para la tabla
                ->get();

    return view('cliente.reservas.index', compact('reservas'));
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
    public function show(string $id)
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
