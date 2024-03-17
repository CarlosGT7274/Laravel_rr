<?php

namespace App\Models\HR\Employee\General;

class hr_empleados extends \App\Models\modeloBase
{
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'id_empleado';

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
        'id_usuario', 'telefono',
        'telefono2', 'email2',

        'rfc', 'curp', 'sexo',
        'estadoCivil', 'cumpleaños',
        'lugarNatal',

        'calle', 'colonia',
        'poblacion', 'ciudad',
        'estado', 'codigoPostal',

        'nombreEmergencia',
        'dirEmergencia', 'telEmergencia',

        'imss', 'tipoSangre',
        'enferemedades', 'fonacot',
        'unidadMedica',

        'alta', 'altaFiscal',
        'contratoInicio', 'contratoFin',

        'sueldo', 'formaPago',
        'pensAlimenticia',

        'nomClave', 'nomBanco',
        'nomLocalidad', 'nomReferencia',
        'nomCuenta',

        'id_unidad',
        'id_departamento',
        'id_puesto',
        'id_tipo_empleado',
        'id_horario',
        'id_terminal_user',
        'id_empresa',
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
