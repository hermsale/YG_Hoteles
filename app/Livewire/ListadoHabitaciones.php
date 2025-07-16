<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Habitacion;
use Illuminate\Support\Facades\Log;

use Livewire\Attributes\On;

class ListadoHabitaciones extends Component
{
    public $habitaciones = [];
    public $fechaEntrada;
    public $fechaSalida;
    // nueva manera de importar atributos en Livewire
    #[On('buscarHabitaciones')]


    // este metodo se encarga de filtrar las habitaciones según los criterios seleccionados
    // por el usuario en el formulario de reserva
    public function filtrar($filtros)
    {
        Log::info("ListadoHabitaciones component initialized");
        Log::info('Filtros de búsqueda:', $filtros);

        // Asignar las fechas de entrada y salida a las propiedades del componente
        // para que puedan ser utilizadas en la vista o en otros métodos
        $this->fechaEntrada = $filtros['fecha_entrada'];
        $this->fechaSalida = $filtros['fecha_salida'];

        $this->habitaciones = Habitacion::with(['imagenes', 'amenities', 'categoria'])
            ->where('estado', 'Activo') // ✅ solo habitaciones activas
            ->where('capacidad', '>=', $filtros['huespedes']) // ✅ capacidad mínima
            ->whereDoesntHave('reservas', function ($q) use ($filtros) {
                $q->where('estado_reserva', 'Activa') // ✅ solo reservas activas
                  ->where(function ($query) use ($filtros) {
                      $query->where('fecha_egreso', '>', $filtros['fecha_entrada'])
                            ->where('fecha_ingreso', '<', $filtros['fecha_salida']);
                  });
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.listado-habitaciones');
    }
}
