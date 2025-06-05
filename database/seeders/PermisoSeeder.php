<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // reservas
            ['nombre_permiso' => 'crear reserva'],
            ['nombre_permiso' => 'editar reserva'],
            ['nombre_permiso' => 'cancelar reserva'],
            ['nombre_permiso' => 'ver reserva'],
            // habitaciones
            ['nombre_permiso' => 'crear habitacion'],
            ['nombre_permiso' => 'editar habitacion'],
            ['nombre_permiso' => 'eliminar habitacion'],
            ['nombre_permiso' => 'ver habitacion'],
            /// usuarios
            ['nombre_permiso' => 'ver usuario'],
            ['nombre_permiso' => 'crear usuario'],
            ['nombre_permiso' => 'editar usuario'],
            ['nombre_permiso' => 'eliminar usuario'],
            ['nombre_permiso' => 'restablecer contraseña usuario'],
            ['nombre_permiso' => 'asignar rol a usuario'],

            // caja
            ['nombre_permiso' => 'abrir caja'],
            ['nombre_permiso' => 'cerrar caja'],
            ['nombre_permiso' => 'ver caja'],
            ['nombre_permiso' => 'realizar arqueo de caja'],
            ['nombre_permiso' => 'ver historial de caja'],

            // reportes
            ['nombre_permiso' => 'ver reportes'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(
                ['nombre_permiso' => $permiso['nombre_permiso']],
                $permiso
            );
        }
    }
}
