<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = Rol::where('nombre_rol', 'Administrador')->first();
        $recepcionista = Rol::where('nombre_rol', 'Recepcionista')->first();
        $cliente = Rol::where('nombre_rol', 'Cliente')->first();

        // permisos para recepcionista
        $permisosRecepcionista = [
            'crear reserva',
            'editar reserva',
            'cancelar reserva',
            'ver reserva',
            // 'crear habitacion',
            // 'editar habitacion',
            'ver habitacion',
            'ver usuario',
            // 'ver reportes',
            'abrir caja',
            'cerrar caja',
            'ver caja',
            // 'realizar arqueo de caja',
        ];

        // permisos para cliente
        $permisosCliente = [
            'crear reserva',
            'ver reserva',
        ];

        // permisos para administrador
        $permisosAdmin = Permiso::pluck('id')->toArray(); // todos

        // Asignación
        $admin->permisos()->sync($permisosAdmin);

        $recepcionista->permisos()->sync(
            Permiso::whereIn('nombre_permiso', $permisosRecepcionista)->pluck('id')->toArray()
        );

        // cargamos todos los permisos excepto el filtro. Lo obtenemos directamente de la lista de Permiso
        $permisosRecepcionista = collect($permisosAdmin)->filter(function ($nombre) {
            return !in_array($nombre, ['Eliminar Usuario', 'Eliminar Habitacion']);
        });


        $recepcionista->permisos()->sync($permisosRecepcionista->keys()->toArray());


        // “Buscá todos los permisos cuyo nombre_permiso esté en el array $permisosRecepcionista y traeme sus IDs”.
        $cliente->permisos()->sync(
            Permiso::whereIn('nombre_permiso', $permisosCliente)->pluck('id')->toArray()
        );
    }
}
