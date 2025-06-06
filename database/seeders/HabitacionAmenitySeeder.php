<?php

namespace Database\Seeders;
use App\Models\Habitacion;
use Illuminate\Database\Seeder;

class HabitacionAmenitySeeder extends Seeder
{
    public function run()
    {
        // Usar find() solo si estás seguro del ID. Mejor aún: buscar por código o nombre.
        $habitacionDeluxe = Habitacion::find(1);
        $habitacionSimple = Habitacion::find(2);
        $habitacionDoble = Habitacion::find(3);
        $habitacionTriple = Habitacion::find(4);

        if ($habitacionDeluxe) {
            $habitacionDeluxe->amenities()->sync([1, 2, 3, 4, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16, 17, 18, 19]);
        }

        if ($habitacionSimple) {
            $habitacionSimple->amenities()->sync([1, 2, 5, 6, 10, 14, 18]);
        }

        if ($habitacionDoble) {
            $habitacionDoble->amenities()->sync([1, 2, 3, 4, 6, 9, 10, 13, 14, 15, 18]);
        }

        if ($habitacionTriple) {
            $habitacionTriple->amenities()->sync([1, 2, 3, 4, 6, 9, 11, 12, 13, 14, 15, 18]);
        }

        // $this->command->info('Amenities asignados con Eloquent correctamente.');
    }
}
