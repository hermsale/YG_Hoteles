<?php

namespace App\Http\Controllers;


use App\Models\Curso;
use Illuminate\Http\Request;
// ruta para usar Rule
use Illuminate\Validation\Rule;


class CursoController extends Controller
{
    /**
     * El metodo index es el metodo principal de este controlador
     * En este metodo se muestra todos los recursos de este controlador.
     * Osea si son cursos, se muestra todos los cursos disponibles
     */
    public function index()
    {

        // toma el contenido de la constante DESCRIPCION definido en el modelo Curso.
        $opcionesDescripcion = Curso::DESCRIPCION;
        // de esta manera obtenemos en cursos lo que haya en la tabla Curso
        $cursos = Curso::select(['id','titulo','precio','descripcion']) // nos permite traer en formato de array lo que necesitamos
        ->orderBy('precio') // nos permite hacer ordenamientos
        ->get(); // luego del ordenamiento se concatena con una flecha ->
        return view('cursos.index', [
            'titulo' => 'Lista de cursos', // key
            'cursos' => $cursos,
            'opcionesDescripcion' => $opcionesDescripcion, // para luego pasarlo a la vista (seria un array)
        ]);
    }

        // compact('cursos')); // si index esta encarpetado,. tenemos que indicar el nombre de la carpeta y '.'
                                                // si queremos enviar todo lo que llega a cursos, se puede hacer un compact y enviar todo

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
     * Metodo para Actualizar el estado de Descripcion de curso
     */
    public function updateDescripcion(Request $request, Curso $curso)
    {
        $request->validate([
        'descripcion' => ['required', Rule::in(Curso::DESCRIPCION)],  //el campo es válido solamente si su valor está en esa lista. y es REQUERIDO.
    ]);
    // Si no se cumple esta validación, Laravel devuelve automáticamente una respuesta con errores de validación (normalmente un 422 con JSON, o vuelve a la vista con errores si es web).

    $curso->update([
        'descripcion' => $request->descripcion,
    ]);
    // update es una funcion que Laravel ya trae por defecto.
    // Esta línea actualiza el modelo $curso en la base de datos, solamente el campo descripcion, con el valor que viene en el request.

    return back()->with('success', 'Curso actualizado correctamente');
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
