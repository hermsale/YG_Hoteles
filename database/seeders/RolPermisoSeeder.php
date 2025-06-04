<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recepcionista = Rol::where('nombre_rol', 'Recepcionista')->first();
        $cliente = Rol::where('nombre_rol', 'Cliente')->first();

        // IDs o nombres de los permisos
        // Permisos del Cliente
        $permisosCliente = [
            'Crear Reserva',
            'Cancelar Reserva',
            'Ver Reserva',
        ];

        // Permisos del Recepcionista: todos menos 'Eliminar Usuario' y 'Eliminar Habitacion'
        $todosLosPermisos = Permiso::pluck('nombre_permiso', 'id');

        // cargamos todos los permisos excepto el filtro. Lo obtenemos directamente de la lista de Permiso
        $permisosRecepcionista = $todosLosPermisos->filter(function ($nombre) {
            return !in_array($nombre, ['Eliminar Usuario', 'Eliminar Habitacion']);
        });


        $recepcionista->permisos()->sync($permisosRecepcionista->keys()->toArray());


        // “Buscá todos los permisos cuyo nombre_permiso esté en el array $permisosRecepcionista y traeme sus IDs”.
        $cliente->permisos()->sync(
            Permiso::whereIn('nombre_permiso', $permisosCliente)->pluck('id')->toArray()
        );
    }
}
