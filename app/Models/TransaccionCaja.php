<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\MetodoPago;
use App\Models\CierreCaja;

class TransaccionCaja extends Model
{
    use HasFactory;

    protected $fillable = [
        'cierre_caja_id',
        'concepto',
        'cliente',
        'monto',
        'metodo_pago_id',
        'comentario',
        'usuario_id',
    ];


    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class);
    }


    public function cierre()
    {
        return $this->belongsTo(CierreCaja::class, 'cierre_caja_id');
    }

    // Relación con usuario que hizo la transacción
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
