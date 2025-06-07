<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
    // defino los fillable para usar eloquent y sea seteable para create update, etc
    protected $fillable = ['nombre'];

    // 1 amenity puede estar en muchas habitaciones
    public function habitaciones()
    {
        return $this->belongsToMany(Habitacion::class, 'habitacion_amenity', 'id_amenity', 'id_habitacion');
    }
}
