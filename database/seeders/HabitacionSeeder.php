<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habitacion;
use App\Models\Categoria;

/**
 * Seeder para poblar la tabla `habitacion` con Eloquent.
 */
class HabitacionSeeder extends Seeder
{
    public function run()
    {
        // Obtener IDs de categorías por nombre
        $categoriaDeluxe = Categoria::where('nombre', 'Deluxe')->first()?->id;
        $categoriaSimple = Categoria::where('nombre', 'Simple')->first()?->id;
        $categoriaDoble = Categoria::where('nombre', 'Doble')->first()?->id;
        $categoriaTriple = Categoria::where('nombre', 'Triple')->first()?->id;

        if (!$categoriaDeluxe || !$categoriaSimple || !$categoriaDoble || !$categoriaTriple) {
            throw new \Exception("Faltan categorías en la tabla `categoria`. Ejecutá primero CategoriaTableSeeder.");
        }


        // Crear habitaciones
        Habitacion::create([
            'nombre' => 'Suite Deluxe',
            'descripcion' => 'Amplia habitación con jacuzzi y balcón privado.',
            'capacidad' => 2,
            'codigo_habitacion' => 101,
            'precio_noche' => 130000.00,
            'estado' => 'Activo',
            'id_categoria' => $categoriaDeluxe
        ]);

        Habitacion::create([
            'nombre' => 'Habitación Simple',
            'descripcion' => 'Habitación cómoda ideal para una persona.',
            'capacidad' => 1,
            'codigo_habitacion' => 201,
            'precio_noche' => 70000.00,
            'estado' => 'Activo',
            'id_categoria' => $categoriaSimple
        ]);

        Habitacion::create([
            'nombre' => 'Habitación Doble',
            'descripcion' => 'Ideal para dos personas, equipada con comodidades modernas.',
            'capacidad' => 2,
            'codigo_habitacion' => 301,
            'precio_noche' => 90000.00,
            'estado' => 'Activo',
            'id_categoria' => $categoriaDoble
        ]);

        Habitacion::create([
            'nombre' => 'Habitación Triple',
            'descripcion' => 'Espaciosa habitación para grupos o familias.',
            'capacidad' => 3,
            'codigo_habitacion' => 401,
            'precio_noche' => 120000.00,
            'estado' => 'Activo',
            'id_categoria' => $categoriaTriple
        ]);
    }
}
