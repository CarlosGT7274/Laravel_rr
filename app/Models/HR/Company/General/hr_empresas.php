<?php

namespace App\Models\HR\Company\General;

use App\Models\modeloBase;

class hr_empresas extends modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_empresa';

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
        'razonSocial',
        'rfc', 'giroComercial',
        'contacto', 'telefono',
        'email', 'fax', 'web',
        'calle', 'colonia',
        'poblacion', 'estado', 'logo'
    ];
}
