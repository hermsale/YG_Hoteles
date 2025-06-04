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
    }
}
