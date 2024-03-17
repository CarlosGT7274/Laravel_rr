<?php

namespace App\Models\SYS;

class sys_roles_permisos extends \App\Models\modeloBase
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id_rol',
        "id_permiso",
        "valor"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'id_rol',
    ];
}
