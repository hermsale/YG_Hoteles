<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reserva;

/**
 * Seeder para la tabla reserva.
 * Inserta reservas de ejemplo con Eloquent.
 */
class ReservaSeeder extends Seeder
{
    public function run()
    {
        $reservas = [
            [
                'id_usuario' => 1,
                'id_habitacion' => 2,
                'fecha_ingreso' => '2025-06-01',
                'fecha_egreso' => '2025-06-05',
                'id_promocion' => null,
                'estado_reserva' => 'Activa',
                'estado_pago' => 'Pagado',
                'precio_final' => 70000 * 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 3,
                'id_habitacion' => 3,
                'fecha_ingreso' => '2025-06-10',
                'fecha_egreso' => '2025-06-13',
                'id_promocion' => 2,
                'estado_reserva' => 'Activa',
                'estado_pago' => 'Pendiente',
                'precio_final' => 90000 * 3 * 0.9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 2,
                'id_habitacion' => 1,
                'fecha_ingreso' => '2025-04-01',
                'fecha_egreso' => '2025-04-04',
                'id_promocion' => 1,
                'estado_reserva' => 'Finalizada',
                'estado_pago' => 'Pagado',
                'precio_final' => 130000 * 3 * 0.75,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_usuario' => 1,
                'id_habitacion' => 2,
                'fecha_ingreso' => '2025-06-01',
                'fecha_egreso' => '2025-06-05',
                'id_promocion' => null,
                'estado_reserva' => 'Activa',
                'estado_pago' => 'Cancelado',
                'precio_final' => 70000 * 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($reservas as $reserva) {
            Reserva::create($reserva);
        }
    }
}
