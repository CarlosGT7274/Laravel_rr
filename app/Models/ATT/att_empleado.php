<?php

namespace App\Models\ATT;

class att_empleado extends \App\Models\modeloBase
{
    protected $table = 'att_empleado';
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'emp_id';

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
        'emp_pin',
        'emp_code',
        'emp_role',
        'emp_firstname',
        'emp_lastname',
        'emp_username',
        'emp_pwd',
        'emp_privilege',
        'emp_group',
        'emp_active',
        'emp_cardNumber',
        'IsSelect'
    ];
}
