<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run()
    {
        $amenities = [
            'WiFi', 'Baño privado', 'Caja de seguridad', 'TV SMART', 'TV',
            'Aire acondicionado', 'Piso térmico', 'Jacuzzi', 'Mesa ratona para trabajar',
            'Sillón simple', 'Sillón doble', 'Servicio de lavandería', 'Frigobar',
            'Secador de pelo', 'Room service 24 hs', 'Desayuno incluido', 'Balcón privado',
            'Cortinas blackout', 'Espejo de cuerpo entero'
        ];

        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(['nombre' => $amenity]);
        }
    }
}
