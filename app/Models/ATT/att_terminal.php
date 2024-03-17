<?php

namespace App\Models\ATT;

class att_terminal extends \App\Models\modeloBase
{
    protected $table = 'att_terminal';
    /**
     * The primary key associated with the table.
     * @var string
     */
    protected $primaryKey = 'terminal_id';

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
        'teminal_no',
        'terminal_status',
        'terminal_name',
        'terminal_location',
        'termnal_conecttype',
        'terminal_conectpwd',
        'terminal_domainname',
        'terminal_tcpip',
        'terminal_port',
        'terminal_serial',
        'terminal_baudrate',
        'terminal_type',
        'terminal_users',
        'terminal_fingerprints',
        'terminal_punches',
        'terminal_faces',
        'terminal_zem',
        'terminal_kind',
        'IsSelect',
        'terminal_timechk',
        'terminal_lastchk'
    ];
}
