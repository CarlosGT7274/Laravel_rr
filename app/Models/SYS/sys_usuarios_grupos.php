<?php

namespace App\Models\SYS;

class sys_usuarios_grupos extends \App\Models\modeloBase
{
    /**
     * The attributes that are mass assignable.
     * @var string[]
     */
    protected $fillable = [
        'id_grupo', 'id_usuario'
    ];
}
