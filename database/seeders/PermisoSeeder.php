<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            ['nombre_permiso' => 'Crear Reserva'],
            ['nombre_permiso' => 'Cancelar Reserva'],
            ['nombre_permiso' => 'Editar Reserva'],
            ['nombre_permiso' => 'Ver Reserva'],
            ['nombre_permiso' => 'Crear Habitacion'],
            ['nombre_permiso' => 'Editar Habitacion'],
            ['nombre_permiso' => 'Eliminar Habitacion'],
            ['nombre_permiso' => 'Ver Habitacion'],
            ['nombre_permiso' => 'Crear Usuario'], // exclusiva is_admin. para crear recepcionistas
            ['nombre_permiso' => 'Editar Usuario'],
            ['nombre_permiso' => 'Eliminar Usuario'], // es para el is_admin
            ['nombre_permiso' => 'Ver Usuario'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(['nombre_permiso' => $permiso['nombre_permiso']], $permiso);
        }
        // Con esto:
        // Si ya existe un permiso con ese id, lo actualiza.
        // Si no existe, lo crea.
    }
}
