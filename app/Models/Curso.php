<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    /** @use HasFactory<\Database\Factories\CursoFactory> */
    use HasFactory;

    // protected $table = 'cursos';

    // definimos qué propiedades son seteables (serían como los setter)
    protected $fillable = ['titulo','descripcion','precio'];
}
