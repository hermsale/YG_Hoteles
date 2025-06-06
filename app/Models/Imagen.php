<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    /** @use HasFactory<\Database\Factories\ImagenFactory> */
    use HasFactory;
    protected $table = 'imagenes';

    protected $fillable = ['url', 'id_habitacion'];

    // muchas imagenes pertenecen a 1 habitacion
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
