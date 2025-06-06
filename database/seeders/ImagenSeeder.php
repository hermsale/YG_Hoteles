<?php

namespace Database\Seeders;

use App\Models\Imagen;
use Illuminate\Database\Seeder;

class ImagenSeeder extends Seeder
{
    public function run()
    {
         $imagenes = [
            'img/habitacion-deluxe101-1.jpg',
            'img/habitacion-simple201-1.jpg',
            'img/habitacion-doble301-1.jpg',
            'img/habitacion-triple401-1.jpg',
        ];

        foreach ($imagenes as $imagen) {
            Imagen::updateOrCreate(['url' => $imagen]);
        }
    }
}
