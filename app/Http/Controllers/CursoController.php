<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /**
     * El metodo index es el metodo principal de este controlador
     * En este metodo se muestra todos los recursos de este controlador.
     * Osea si son cursos, se muestra todos los cursos disponibles
     */
    public function index()
    {
        // de esta manera obtenemos en cursos lo que haya en la tabla Curso
        $cursos = Curso::orderBy('precio') // nos permite hacer ordenamientos
        ->select(['id','titulo','precio']) // nos permite traer en formato de array lo que necesitamos 
        ->get(); // luego del ordenamiento se concatena con una flecha ->
        return $cursos;
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
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
