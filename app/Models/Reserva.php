<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{

    /**
 * Relación con usuario.
 * Una reserva pertenece a un usuario.
 */
public function usuario()
{
    return $this->belongsTo(User::class, 'id_usuario');// esto devuelve el usuario asociado a la reserva
}

/**
 * Relación con habitación.
 * Una reserva está asociada a una habitación.
 */
public function habitacion()
{
    return $this->belongsTo(Habitacion::class, 'id_habitacion');//esto devuelve la habitación asociada a la reserva
}

/**
 * Relación con promoción.
 * Una reserva puede tener una promoción.
 */
public function promocion()
{
    return $this->belongsTo(Promocion::class, 'id_promocion');//esto devuelve la promoción asociada a la reserva
}

}
