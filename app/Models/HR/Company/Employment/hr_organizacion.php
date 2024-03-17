<?php
namespace App\Models\HR\Company\Employment;

class hr_organizacion extends \App\Models\modeloBase
{
    protected $table = "hr_organizacion";

    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * Indicates if the model's ID is auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'key',
        'parent_key',
        'id_empresa',
        'id_departamento',
        'id_puesto',
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