<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    /** @use HasFactory<\Database\Factories\CursoFactory> */
    use HasFactory;


    // CONFIGURAMOS EL ELOQUENT
    // NOMBRE DE LA TABLA DE LA BASE DE DATOS
    protected $table = 'cursos';

    // definimos qué propiedades son seteables (serían como los setter)
    // Estas propiedades son las que van a ser seteables cuando se creen.
    // Por ejemplo cuando se use en los Seeders
    protected $fillable = ['titulo','descripcion','precio','visible'];
}
