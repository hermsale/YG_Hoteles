<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    /**
     * Valores por defecto para los atributos del modelo.
     */
    protected $attributes = [
        // Si no enviás 'id_rol' al crear un User, automáticamente será 2
        'id_rol' => 2,
    ];


    protected $fillable = [
        'name',
        'email',
        'password',
        // agrego las nuevas columnas
        'is_admin',
        'id_rol'
    ];


    // va a tener un id_rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }



    // funcion creada para verificar si un usuario es admin o si tiene permiso para determinada accion
    public function tienePermiso($nombrePermiso)
    {
        if ($this->is_admin) {
            return true;
        }

        return $this->rol->permisos->contains('nombre_permiso', $nombrePermiso);
        // esta regla va a permitir hacer esto en el blade
        //     @if(auth()->user()->is_admin || auth()->user()->tienePermiso('Crear Reserva'))
        //     <a href="...">Crear reserva</a>
            // @endif
    }

    // si querés verificar si un usuario es administrador:
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    // También podrías agregar algo para saber si tiene un rol específico:
    public function hasRole(string $nombreRol): bool
    {
        return $this->rol?->nombre_rol === $nombreRol;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean', // se agrega el is_admin
        ];
    }
}
