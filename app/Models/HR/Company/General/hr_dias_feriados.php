<?php
namespace App\Models\HR\Company\General;

class hr_dias_feriados extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_dia_feriado';

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
        'nombre', 'tipo',
        'inicio', 'fin',
        'id_empresa'
    ];
}