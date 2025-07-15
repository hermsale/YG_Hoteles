<?php

namespace App\Livewire;

use App\Models\Habitacion;
use App\Models\Promocion;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConfirmarReservaModal extends Component
{

    public $mostrarModal = false;
    public $nombreHabitacion = '';
    public $imagenUrl = '';
    public $capacidad = '';
    public $codigo_habitacion = '';
    public $fechaEntrada = '';
    public $fechaSalida = '';
    public $precioNoche = 0;
    public $cantidadNoches = 0;
    public $importe = 0;
    public $importeTotal = 0;
    public $promociones = [];
    public $promocionSeleccionada = null;
    public $idPromo = null;
    public $descuento = 0;
    #[On('abrir-modal-reserva')]

    public function abrirModalReserva($nombreHabitacion, $imagenUrl, $capacidad, $codigo_habitacion, $fechaEntrada, $fechaSalida, $precioNoche)
    {

        $this->nombreHabitacion = $nombreHabitacion;
        $this->imagenUrl = $imagenUrl;
        $this->capacidad = $capacidad;
        $this->codigo_habitacion = $codigo_habitacion;
        $this->fechaEntrada = $fechaEntrada;
        $this->fechaSalida = $fechaSalida;
        $this->precioNoche = $precioNoche;

        // Reinicio los valores
        $this->descuento = 0;
        $this->importeTotal = 0;
        $this->promocionSeleccionada = '';


        // Calcular cantidad de noches
        $entrada = Carbon::parse($this->fechaEntrada);
        $salida = Carbon::parse($this->fechaSalida);
        $this->cantidadNoches = $entrada->diffInDays($salida);

        $this->promociones = Promocion::all();



        // Calcular importe total
        $this->importe = $this->cantidadNoches * $this->precioNoche;

        $this->mostrarModal = true;
    }

    public function updatedPromocionSeleccionada($promoId)
    {
        $this->idPromo = $promoId;
        Log::info('Promoción seleccionada: ' . $promoId);
        if ($promoId) {
            $promo = collect($this->promociones)->firstWhere('id', $promoId);

            if ($promo) {
                $this->descuento = $promo->descuento_porcentaje;
                $this->importeTotal = $this->cantidadNoches * $this->precioNoche * (1 - $this->descuento / 100);
            }
        } else {
            // Sin promoción seleccionada
            $this->descuento = 0;
            $this->importeTotal = $this->cantidadNoches * $this->precioNoche;
        }
    }

    // boton para aplicar la promoción
    // este método se llama cuando el usuario selecciona una promoción
    public function aplicarPromocion()
    {

        $this->updatedPromocionSeleccionada($this->promocionSeleccionada);
    }


    public function confirmarReserva()
    {
        try {
            // Validación manual (opcional si ya validaste antes)
            $validator = Validator::make([
                'fechaEntrada' => $this->fechaEntrada,
                'fechaSalida' => $this->fechaSalida,
                'importeTotal' => $this->importeTotal,
                'codigo_habitacion' => $this->codigo_habitacion,
            ], [
                'fechaEntrada' => 'required|date',
                'fechaSalida' => 'required|date|after:fechaEntrada',
                'importeTotal' => 'required|numeric|min:0',
                'codigo_habitacion' => 'required|string',
            ]);

            if ($validator->fails()) {
                $this->addError('validacion', 'Datos inválidos en la reserva.');
                return;
            }

            // Verificar autenticación
            if (!Auth::check()) {
                session()->flash('error', 'Debés iniciar sesión para confirmar la reserva.');
                return redirect()->route('login');
            }

            // Buscar la habitación por código
            $habitacion = Habitacion::where('codigo_habitacion', $this->codigo_habitacion)->first();
            if (!$habitacion) {
                $this->addError('habitacion', 'No se encontró la habitación seleccionada.');
                return;
            }

            // si no se asigno ninguna promoción, se asigna null
            if (empty($this->promocionSeleccionada)) {
                // Sin promoción
                $this->idPromo = null;
                $this->descuento = 0;
                $this->importeTotal = $this->cantidadNoches * $this->precioNoche;
            } else {
                // Buscar promoción en la colección y aplicar descuento
                $promo = collect($this->promociones)->firstWhere('id', $this->promocionSeleccionada);

                if ($promo) {
                    $this->idPromo = $promo->id;
                    $this->descuento = $promo->descuento_porcentaje;
                    $this->importeTotal = $this->cantidadNoches * $this->precioNoche * (1 - $this->descuento / 100);
                }
            }

            // Crear la reserva
            $reserva = new Reserva();
            $reserva->id_usuario = Auth::id();
            $reserva->id_habitacion = $habitacion->id;
            $reserva->fecha_ingreso = $this->fechaEntrada;
            $reserva->fecha_egreso = $this->fechaSalida;
            $reserva->precio_final = $this->importeTotal;
            $reserva->estado_reserva = 'Activa';
            $reserva->estado_pago = 'Pagado';
            $reserva->id_promocion = $this->idPromo; // Asignar promoción si se seleccionó
            $reserva->aviso_pago = false;
            $reserva->fecha_creacion = now();
            $reserva->save();

            // Opcional: cerrar el modal
            $this->mostrarModal = false;

            // Redirigir con mensaje
            session()->flash('success', 'Reserva confirmada correctamente.');
            return redirect()->route('reservas.index');
        } catch (\Exception $e) {
            Log::error('Error al confirmar reserva: ' . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al confirmar la reserva.');
        }
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function render()
    {
        return view('livewire.confirmar-reserva-modal');
    }
}
