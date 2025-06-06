<?php

namespace Database\Seeders;

use App\Models\Imagen;
use Illuminate\Database\Seeder;

class ImagenSeeder extends Seeder
{
    public function run()
    {
        $imagenes = [
            ['url' => 'img/habitacion-deluxe101-1.jpg', 'id_habitacion' => 1],
            ['url' => 'img/habitacion-simple201-1.jpg', 'id_habitacion' => 2],
            ['url' => 'img/habitacion-doble301-1.jpg', 'id_habitacion' => 3],
            ['url' => 'img/habitacion-triple401-1.jpg', 'id_habitacion' => 4],
        ];

        foreach ($imagenes as $imagen) {
            Imagen::updateOrCreate(
                ['url' => $imagen['url']],
                ['id_habitacion' => $imagen['id_habitacion']]
            );
        }
    }
}
