<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Categoria
 * Representa una categoría de habitación (ej: Deluxe, Simple, Doble, Triple).
 */
class Categoria extends Model
{
    // Nombre real de la tabla en PostgreSQL
    protected $table = 'categorias';

    // Clave primaria personalizada
    // protected $primaryKey = 'id_categoria';

    // Campos que se pueden asignar en masa
    protected $fillable = ['nombre'];

    /**
     * Relación: una categoría tiene muchas habitaciones.
     */
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'id_categoria');
    }
}
