<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Habitacion;
use Illuminate\Database\Eloquent\SoftDeletes;




class Reserva extends Model
{// aplico el use para poder ejecutar los soft deletes
    use SoftDeletes;

    protected $fillable = [
        'id_usuario',
        'id_habitacion',
        'fecha_ingreso',
        'fecha_egreso',
        'precio_final',
        'estado_pago',
        'estado_reserva',
        'fecha_creacion',
        'aviso_pago',
        'check_in',
        'id_promocion',
    ];
    protected $casts = [
    'fecha_ingreso' => 'date',
    'fecha_egreso' => 'date',
    ];


    /**
     * Relación con usuario.
     * Una reserva pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con habitación.
     * Una reserva está asociada a una habitación.
     */
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'id_habitacion');
    }

    /**
     * Relación con promoción.
     * Una reserva puede tener una promoción.
     */
    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'id_promocion');
    }

    /**
     * Calcula la posición (left, width) de la reserva dentro del calendario.
     * Retorna null si está fuera del rango de fechas.
     */
    public function calcularPosicionEnCalendario(Collection $fechas): ?array
        {
            $inicioIndex = $fechas->search(fn($f) => $f->toDateString() === $this->fecha_ingreso->toDateString());
            $finIndex = $fechas->search(fn($f) => $f->toDateString() === $this->fecha_egreso->copy()->subDay()->toDateString());


            // La fecha de egreso es exclusiva, así que la celda no se ocupa
            if ($inicioIndex === false || $finIndex === false || $finIndex <= $inicioIndex) {
                return null;
            }

            $span = $finIndex - $inicioIndex;
            $leftPercent = ($inicioIndex / $fechas->count()) * 100;
            $widthPercent = ($span / $fechas->count()) * 100;

            return [
                'left' => $leftPercent,
                'width' => $widthPercent,
            ];
        }


    /**
     * Verifica si esta reserva genera overbooking dentro de una habitación.
     * Solo considera solapamiento real, excluyendo fecha_egreso.
     */
    public function tieneOverbooking(Habitacion $habitacion): bool
        {
            return $habitacion->reservas->filter(function ($r) {
                return $r->id !== $this->id &&
                    $r->fecha_ingreso < $this->fecha_egreso &&
                    $r->fecha_egreso > $this->fecha_ingreso;
            })->count() > 1; // Se permite que haya una: la actual
        }

}
