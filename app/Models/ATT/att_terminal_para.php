<?php

namespace App\Models\ATT;

class att_terminal_para extends \App\Models\modeloBase
{
    protected $table = 'att_terminal_para';
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'para_id';

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
        'parameter_name',
        'parameter_value',
        'terminal_id',
        'infoid'
    ];
}
