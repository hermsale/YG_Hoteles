<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
     // defino los fillable para usar eloquent y sea seteable para create update, etc
    protected $fillable = ['nombre'];

}
