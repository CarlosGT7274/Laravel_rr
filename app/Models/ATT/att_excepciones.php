<?php

namespace App\Models\ATT;

class att_excepciones extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id';

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
        'fecha_excep',
        'tiempoini',
        'tiempofin',
        'observacion',
        'id_codpago',
        'id_trabajador'
    ];
}
