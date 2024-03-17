<?php
namespace App\Models\SYS;

class sys_notificaciones extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_notificacion';

    /**
     * Indicates if the model's ID is auto-incrementing.
     * @var bool
     */
    public $incrementing = true;

    /**
     * The data type of the auto-incrementing ID.
     * @var string
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'mensaje', 'creacion',
        'publicacion', 'id_usuario',
        'id_grupo'
    ];
}