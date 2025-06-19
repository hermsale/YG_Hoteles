<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

/**
 * Seeder para poblar la tabla `categoria` con Eloquent.
 */
class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            'Deluxe',
            'Simple',
            'Doble',
            'Triple',
        ];

        foreach ($categorias as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }
    }
}
