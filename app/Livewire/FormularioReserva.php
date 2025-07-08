<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;

class FormularioReserva extends Component
{
    public $fecha_entrada;
    public $fecha_salida;
    public $huespedes = 1;

    public function mount()
    {
        $this->fecha_entrada = Carbon::now()->toDateString(); // hoy
        $this->fecha_salida = Carbon::now()->addDay()->toDateString(); // mañana
    }

    public function updatedFechaEntrada($value)
    {
        // Si la nueva fecha de salida no es posterior, actualizala
        $entrada = Carbon::parse($value);
        $salida = Carbon::parse($this->fecha_salida);

        if ($salida->lessThanOrEqualTo($entrada)) {
            $this->fecha_salida = $entrada->copy()->addDay()->toDateString();
        }
    }

    public function buscar()
    {
        // validación simple
        $this->validate([
            'fecha_entrada' => 'required|date|before:fecha_salida',
            'fecha_salida' => 'required|date|after:fecha_entrada',
            'huespedes' => 'required|integer|min:1|max:4',
        ]);

        // Redireccionar con parámetros como lo hacía antes
        return redirect()->route('habitaciones.disponibilidad', [
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
