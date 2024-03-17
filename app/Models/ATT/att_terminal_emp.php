<?php

namespace App\Models\ATT;

class att_terminal_emp extends \App\Models\modeloBase
{
    protected $table = 'att_terminal_emp';
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'emp_pin';

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
        'terminal_serial',
        'emp_pin',
        'emp_status',
        'last_sync',
        'Isdone',
        'IsSelect'
    ];
}
