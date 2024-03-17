<?php

namespace App\Models\SYS;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;

class sys_usuarios extends Authenticable implements JWTSubject
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'email', 'password',
        'nombre', 'apellidoP', 'apellidoM',
        'tokenActual', 'ultimoLogin',
        'tokenCambiarContraseña',
        'tiempoTokenContraseña',
        'id_rol'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
        'tokenActual',
        'tokenCambiarContraseña',
        'tiempoTokenContraseña',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
