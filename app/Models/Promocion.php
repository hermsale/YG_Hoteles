<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Promocion
 * Representa una promoción de descuento que puede aplicarse a reservas.
 */
class Promocion extends Model
{
    // Nombre real de la tabla en la base de datos
    protected $table = 'promociones';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'descuento_porcentaje',
        'fecha_inicio',
        'fecha_fin',
    ];

    /**
     * Relación con reservas.
     * Una promoción puede estar asociada a muchas reservas.
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_promocion');// esto devuelve las reservas asociadas a la promoción
    }
}
