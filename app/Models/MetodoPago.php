<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransaccionCaja;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = 'metodo_pago';

    public function transacciones()
    {
        return $this->hasMany(TransaccionCaja::class, 'metodo_pago_id');
    }
}
