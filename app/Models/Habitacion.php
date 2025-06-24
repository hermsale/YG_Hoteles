<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
  protected $table = 'habitaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'codigo_habitacion',
        'precio_noche',
        'estado',
        'id_categoria',
    ];

    // 🔁 Una habitación pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    // 🔁 Una habitación tiene muchas imágenes
    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_habitacion');
    }

    // 1 habitacion puede tener muchos amenitys
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'habitacion_amenity', 'id_habitacion', 'id_amenity');
    }
}
