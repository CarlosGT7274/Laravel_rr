<?php

namespace App\Models\HR\Employee\Incidencies;

class hr_movimientos_vacaciones extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_movimiento_vacaciones';

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
        'tipo',
        'dias',
        'inicio', 'fin',
        'pago',
        'id_incidencia',
        'id_empresa'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'id_empresa'
    ];
}
