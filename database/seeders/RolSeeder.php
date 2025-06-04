<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    // asigno los id fijos. Porque se necesita que sea ese el orden.

    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'nombre_rol' => 'Recepcionista',
            ],
            [
                'id' => 2,
                'nombre_rol' => 'Cliente',
            ],
        ];

        // Para evitar duplicados en futuros seeds, podés hacer esto:
        foreach ($roles as $rol) {
            Rol::updateOrCreate(['id' => $rol['id']], $rol);
        }
        // Con esto:
        // Si ya existe un rol con ese id, lo actualiza.
        // Si no existe, lo crea.

    }
}
