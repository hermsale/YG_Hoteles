<?php

namespace Database\Seeders;

use App\Models\Imagen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagenSeeder extends Seeder
{
    public function run()
    {
         $imagenes = [
            ['url' => 'img/habitacion-deluxe101-1.png'],
            ['url' => 'img/habitacion-simple201-1.png'],
            ['url' => 'img/habitacion-doble301-1.png'],
            ['url' => 'img/habitacion-triple401-1.png'],
        ];

        foreach ($imagenes as $imagen) {
            Imagen::updateOrCreate(['url' => $imagen['url']], $imagen);
        }
    }
}
