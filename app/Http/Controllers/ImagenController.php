<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

// php artisan make:controller ImagenController --resource
// Esto crea un controller llamado ImagenController en app/Http/Controllers.
// La opción --resource genera los métodos estándar CRUD: index, create, store, show, edit, update, destroy.
class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todas las imágenes
        $imagenes = Imagen::all();
        // Retornar una vista con las imágenes
        return view('cliente.fotos.index', compact('imagenes'));
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
        //
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
        // Buscar la imagen por ID
        $imagen = Imagen::findOrFail($id);
        $ruta = public_path($imagen->url);

        Log::info('Eliminando imagen', ['id' => $imagen->id, 'url' => $imagen->url]);
        // Eliminar archivo del storage
        if (file_exists($ruta)) {
            unlink($ruta);
            Log::info('Imagen eliminada del disco.', ['archivo' => $imagen->url]);
        } else {
            Log::warning('El archivo de imagen no existe en disco.', ['archivo' => $imagen->url]);
        }

        // Eliminar registro de la base
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
