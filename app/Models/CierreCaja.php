<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransaccionCaja;
use App\Models\User;

class CierreCaja extends Model
{
    use HasFactory;

    // ✅ Cambiamos al nombre correcto de tabla
    protected $table = 'cierre_cajas';

    protected $fillable = ['fecha', 'total', 'usuario_id'];

    public function transacciones()
    {
        return $this->hasMany(TransaccionCaja::class, 'cierre_caja_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
