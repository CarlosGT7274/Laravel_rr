<?php

namespace App\Models\HR\Employee\General;

class hr_vacaciones extends \App\Models\modeloBase
{
    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'id_empleado',
        'id_empresa',
        'años_totales',
        'dias_disponibles'
    ];
    protected $primaryKey = 'id_empleado';
    public $incrementing = true;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'id_empresa',
    ];
}
