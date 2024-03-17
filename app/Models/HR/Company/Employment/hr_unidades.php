<?php

namespace App\Models\HR\Company\Employment;

class hr_unidades extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_unidad';

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
        'nombre',
        'tipo',
        'poblacion',
        'estado',
        'region',
        'id_empresa'
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
