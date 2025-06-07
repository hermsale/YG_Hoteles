<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promocion;

/**
 * Seeder de promociones predefinidas
 * Inserta promociones de ejemplo para usar en reservas
 */
class PromocionSeeder extends Seeder
{
    public function run()
    {
        // Promoción 1: Hot Sale
        Promocion::create([
            'nombre' => 'Hot Sale 25% off',
            'descripcion' => 'Promoción por tiempo limitado - 25% de descuento.',
            'descuento_porcentaje' => 25,
            'fecha_inicio' => '2025-06-01',
            'fecha_fin' => '2025-06-30'
        ]);

        // Promoción 2: Bienvenida
        Promocion::create([//esta funcion se encarga de insertar datos de ejemplo en la tabla promociones
            'nombre' => 'Descuento Bienvenida 10% off',
            'descripcion' => 'Promoción para nuevos clientes - 10% de descuento.',
            'descuento_porcentaje' => 10,
            'fecha_inicio' => '2025-01-01',
            'fecha_fin' => '2025-12-31'
        ]);
    }
}
