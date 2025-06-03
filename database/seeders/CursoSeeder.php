<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Esto es lo que haciamos antes de configurar el Eloquent
        // DB::create('cursos')->insert([
        //      [
        //         'titulo' => 'Curso de Programación',
        //         'descripcion' => '...',
        //         'precio' => 250000.00,
        //         'visible' => true,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'titulo' => 'Curso de cocina',
        //         'descripcion' => '...',
        //         'precio' => 150000.00,
        //         'visible' => true,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'titulo' => 'Cómo pelar una naranja',
        //         'descripcion' => '...',
        //         'precio' => 50.00,
        //         'visible' => true,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);

        $cursos = [
            [
                'titulo' => 'Curso de Programación',
                'descripcion' => '...',
                'precio' => 250000.00,
                'visible' => true,
            ],
            [
                'titulo' => 'Curso de cocina',
                'descripcion' => '...',
                'precio' => 150000.00,
                'visible' => true,
            ],
            [
                'titulo' => 'Cómo pelar una naranja',
                'descripcion' => '...',
                'precio' => 50.00,
                'visible' => true,
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
