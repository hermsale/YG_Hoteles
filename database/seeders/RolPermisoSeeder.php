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
        $recepcionista = Rol::where('nombre_rol', 'Recepcionista')->first();
        $cliente = Rol::where('nombre_rol', 'Cliente')->first();

        // IDs o nombres de los permisos
        $permisosAdmin = ['crear cursos', 'leer cursos', 'modificar cursos', 'eliminar cursos'];
        $permisosCliente = ['leer cursos'];

        // Sync permite asociar sin duplicar
        $recepcionista->permisos()->sync(
            Permiso::whereIn('nombre_permiso', $permisosAdmin)->pluck('id')->toArray()
        );

        $cliente->permisos()->sync(
            Permiso::whereIn('nombre_permiso', $permisosCliente)->pluck('id')->toArray()
        );
    }
}
