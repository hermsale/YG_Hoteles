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
            ['nombre_permiso' => 'crear cursos'],
            ['nombre_permiso' => 'leer cursos'],
            ['nombre_permiso' => 'modificar cursos'],
            ['nombre_permiso' => 'eliminar cursos'],
        ];

        foreach ($permisos as $permiso) {
            Permiso::updateOrCreate(['nombre_permiso' => $permiso['nombre_permiso']], $permiso);
        }
        // Con esto:
        // Si ya existe un permiso con ese id, lo actualiza.
        // Si no existe, lo crea.
    }
}
