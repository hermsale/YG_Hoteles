<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
    ];

    // ✅ Agregado: clave primaria explícita
    protected $primaryKey = 'id';

    // ✅ Agregado: autoincremento (por si Laravel lo ignora)
    public $incrementing = true;

    // ✅ Agregado: tipo entero
    protected $keyType = 'int';
    
     // ✅ Aseguramos timestamps si usás created_at y updated_at
    public $timestamps = true;

    // (opcional) Relación con User si más adelante querés auditar cambios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
