<?php

namespace App\Models\ATT;

class att_template extends \App\Models\modeloBase
{
    protected $table = 'att_template';
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'template_id';

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
        'finger_id',
        'effective',
        'template_type',
        'template_len',
        'template_str',
        'template_obj',
        'template_remark',
        'emp_id'
    ];
}
