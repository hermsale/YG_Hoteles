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
         User::updateOrCreate(
            ['email' => 'hermsale@gmail.com'],
            [
                'name' => 'Admin Principal',
                'password' => Hash::make('alejandro2025'),
                'is_admin' => true,
                'id_rol' => 1,
            ]
        );

         // Romina Recepcionista
        User::updateOrCreate(
            ['email' => 'romina@yg-hoteles.com'],
            [
                'name' => 'Romina Recepcionista',
                'password' => Hash::make('romina2025'),
                'is_admin' => false,
                'id_rol' => 1, // Recepcionista
            ]
        );

        // Agustín Cliente
        User::updateOrCreate(
            ['email' => 'agustin@gmail.com'],
            [
                'name' => 'Agustin',
                'password' => Hash::make('agustin2025'),
                'is_admin' => false,
                'id_rol' => 2, // Cliente
            ]
        );
    }
}
