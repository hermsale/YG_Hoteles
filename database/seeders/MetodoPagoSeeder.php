<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodoPago; // ✅ Importación agregada

class MetodoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $metodos = ['Efectivo', 'Tarjeta Débito', 'Tarjeta Crédito', 'Transferencia Bancaria'];

        foreach ($metodos as $nombre) {
            MetodoPago::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
    