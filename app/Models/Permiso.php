<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    // defino los fillable para usar eloquent y sea seteable para create update, etc
    protected $fillable = ['nombre_permiso'];
    // creamos la funcion que une la tabla muchos a muchos
//  Permiso necesita la relación inversa hacia Rol, ya que es muchos a muchos.
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permiso_rol', 'id_permiso', 'id_rol');
    }
}
