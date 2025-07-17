<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Calendario;
use Carbon\Carbon;

class CalendarioSeeder extends Seeder
{
    public function run()
    {
        // 📅 Rango desde el 1 de enero al 31 de diciembre del año actual
        $añoActual = Carbon::now()->year;

        Calendario::create([
            'fecha_inicio' => Carbon::create($añoActual, 1, 1)->startOfDay(),
            'fecha_fin'    => Carbon::create($añoActual, 12, 31)->endOfDay(),
        ]);
    }
}
