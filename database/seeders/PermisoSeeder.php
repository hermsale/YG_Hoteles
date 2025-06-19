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
<<<<<<< HEAD
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
=======
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
>>>>>>> 7b833e4463abee1076ce4bd1b1d45ba717972223
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(
                ['nombre_permiso' => $permiso['nombre_permiso']],
                $permiso
            );
        }
    }
}
