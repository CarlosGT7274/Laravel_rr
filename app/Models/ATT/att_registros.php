<?php

namespace App\Models\ATT;

class att_registros extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'punch_id';

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
        'emp_id',
        'punch_time',
        'workcode',
        'workstate',
        'terminal_id',
        'punch_type',
        'operator',
        'operator_reason',
        'operator_time',
        'IsSelect',
    ];
}
