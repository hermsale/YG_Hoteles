<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormularioReserva extends Component
{
    public $fecha_entrada;
    public $fecha_salida;
    public $huespedes = 1;

    public $habitaciones = [];

    public function mount()
    {
        $this->fecha_entrada = Carbon::now()->toDateString();
        $this->fecha_salida = Carbon::now()->addDay()->toDateString();
    }

    public function updatedFechaEntrada($value)
    {
        if ($this->fecha_salida <= $value) {
            $this->fecha_salida = date('Y-m-d', strtotime($value . ' +1 day'));
        }
    }

    public function buscar()
    {
        Log::info('Iniciando búsqueda de habitaciones', [
            'fecha_entrada' => $this->fecha_entrada,
            'fecha_salida' => $this->fecha_salida,
            'huespedes' => $this->huespedes,
        ]);

        $this->validate([
            'fecha_entrada' => 'required|date|before:fecha_salida',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'huespedes' => 'required|integer|min:1|max:4',
        ]);

        $this->dispatch('buscarHabitaciones', [
            'fecha_entrada' => $this->fecha_entrada,
            'fecha_salida' => $this->fecha_salida,
            'huespedes' => $this->huespedes,
        ]);
    }

    public function render()
    {
        return view('livewire.formulario-reserva');
    }
}
