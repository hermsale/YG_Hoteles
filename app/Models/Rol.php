<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    // 👇 Recomendación:
// Siempre que tengas un modelo cuyo plural Laravel pueda interpretar mal (como Rol, Pais, Categoria, etc.), declarale el nombre de la tabla explícitamente:
// Este paso de aclaracion lo tenemos que hacer, porque creamos la tabla en plural y despues el modelo en singular
    protected $table = 'roles'; 
    // defino los fillable para usar eloquent y sea seteable
    protected $fillable = ['nombre_rol'];

    // relacion 1 rol para muchos usuarios
    //  En el modelo Rol, agregá la relación inversa
    // 1 rol puede tener MUCHOS usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    // genero la relacion (muchos a muchos)
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'id_rol', 'id_permiso');
    }
}
