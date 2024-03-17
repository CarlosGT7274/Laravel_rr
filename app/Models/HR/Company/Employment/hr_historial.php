<?php

namespace App\Models\HR\Company\Employment;

class hr_historial extends \App\Models\modeloBase
{
    protected $table = "hr_historial";

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Indicates if the model's ID is auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

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
        'id_empleado',
        'id_empresa',
        'movimiento',
        'estado', 'fecha',
        'id_unidad', 'id_puesto',
        'id_departamento',
        'sueldo', 'observaciones',
        'infoBaja'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'id_empresa',
    ];
}
