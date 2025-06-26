<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reserva;
use Carbon\Carbon;

class DashboardReservas extends Component
{
    public $filtro = 'llegadas';

    public $totalLlegadas = 0;
    public $totalSalidas = 0;
    public $totalAlojados = 0;

    // Cambiar filtro seleccionado
    public function setFiltro($tipo)
    {
        $this->filtro = $tipo;
    }

    // Acción de Check In desde la vista
    public function hacerCheckIn($id)
    {
        $reserva = Reserva::find($id);

        if ($reserva && $reserva->estado_reserva === 'Activa') {
            $reserva->check_in = true;
            $reserva->save();
        }
    }
    public function cancelarCheckIn($id)
{
    $reserva = Reserva::find($id);

    if ($reserva && $reserva->estado_reserva === 'Activa' && $reserva->check_in === true) {
        $reserva->check_in = false;
        $reserva->save();
    }
}


    public function render()
    {
        $hoy = Carbon::today();
        $reservas = collect();

        // Filtro dinámico
        if ($this->filtro === 'llegadas') {
            $reservas = Reserva::whereDate('fecha_ingreso', $hoy)
                ->where('estado_reserva', 'Activa')->get();
        } elseif ($this->filtro === 'salidas') {
            $reservas = Reserva::whereDate('fecha_egreso', $hoy)
                ->where('estado_reserva', 'Activa')->get();
        } elseif ($this->filtro === 'alojados') {
            $reservas = Reserva::where('fecha_ingreso', '<=', $hoy)
                ->where('fecha_egreso', '>=', $hoy)
                ->where('estado_reserva', 'Activa')
                ->where('check_in', true)
                ->get();
        }

        // Totales para los box
        $this->totalLlegadas = Reserva::whereDate('fecha_ingreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        $this->totalSalidas = Reserva::whereDate('fecha_egreso', $hoy)
            ->where('estado_reserva', 'Activa')->count();

        $this->totalAlojados = Reserva::where('fecha_ingreso', '<=', $hoy)
            ->where('fecha_egreso', '>=', $hoy)
            ->where('estado_reserva', 'Activa')
            ->where('check_in', true)
            ->count();

        return view('livewire.dashboard-reservas', [
            'reservas' => $reservas,
            'filtro' => $this->filtro
        ]);
    }
}
