<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Log;

use Livewire\Attributes\On;

class ListadoHabitaciones extends Component
{
    public $habitaciones = [];

    // nueva manera de importar atributos en Livewire
    #[On('buscarHabitaciones')]


    // este metodo se encarga de filtrar las habitaciones según los criterios seleccionados
    // por el usuario en el formulario de reserva
    public function filtrar($filtros)
    {
        Log::info("ListadoHabitaciones component initialized");
        Log::info('Filtros de búsqueda:', $filtros);

        $this->habitaciones = Habitacion::with(['imagenes', 'amenities', 'categoria'])
            ->where('capacidad', '>=', $filtros['huespedes'])
            ->whereDoesntHave('reservas', function ($q) use ($filtros) {
                $q->where(function ($q2) use ($filtros) {
                    $q2->whereBetween('fecha_ingreso', [$filtros['fecha_entrada'], $filtros['fecha_salida']])
                       ->orWhereBetween('fecha_egreso', [$filtros['fecha_entrada'], $filtros['fecha_salida']])
                       ->orWhere(function ($q3) use ($filtros) {
                           $q3->where('fecha_ingreso', '<', $filtros['fecha_entrada'])
                              ->where('fecha_egreso', '>', $filtros['fecha_salida']);
                       });
                });
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.listado-habitaciones');
    }
}
