<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $usuarios = [
            [
                'email' => 'hermsale@gmail.com',

                'name' => 'Admin Principal',
                'password' => Hash::make('alejandro2025'),
                'id_rol' => 1,

            ]
            ,
            [
                'email' => 'yg-hotel_Romina@gmail.com',
                'name' => 'Romina Recepcionista',
                'password' => Hash::make('romina2025'),
                'id_rol' => 2,
            ]
            ,
            [
                'email' => 'agustin@gmail.com',
                'name' => 'Agustin',
                'password' => Hash::make('agustin2025'),
                'id_rol' => 3,
            ],
        ];

        // Para evitar duplicados en futuros seeds, podés hacer lo siguiente:
        foreach ($usuarios as $user) {
            User::updateOrCreate(
                ['email' => $user['email']], // Criterio de búsqueda
                $user                         // Datos a insertar o actualizar
            );
        }
        // ¿Qué hace esto?
            // - Si ya existe un usuario con ese email, lo actualiza con los nuevos datos.
            // - Si no existe, lo crea.
            // De esta forma evitás duplicados y mantenés los datos consistentes.
}









}
