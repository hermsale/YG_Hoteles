<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    // Llamamos al seeder de cursos
        $this->call([
            CategoriaSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,
            RolPermisoSeeder::class,
            AmenitySeeder::class,
            HabitacionSeeder::class,
            HabitacionAmenitySeeder::class,
            ImagenSeeder::class,
            UserSeeder::class,
            PromocionSeeder::class,
            ReservaSeeder::class,
        ]
        );
    }
}
