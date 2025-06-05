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
            ['url' => 'https://hotel.com/img/deluxe101.jpg'],
            ['url' => 'https://hotel.com/img/simple201.jpg'],
            ['url' => 'https://hotel.com/img/doble301.jpg'],
            ['url' => 'https://hotel.com/img/triple401.jpg'],
        ];

        foreach ($imagenes as $imagen) {
            Imagen::updateOrCreate(['url' => $imagen['url']], $imagen);
        }
    }
}
