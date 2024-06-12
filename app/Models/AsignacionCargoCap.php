<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionCargoCap extends Model
{
    use HasFactory;

    protected $table = 'asignacion_cargo_cap';

    protected $primaryKey = 'id_asignacion';

    protected $fillable = [
        'cod_base',
        'id_cargo_cap',
        'cap_aprobado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
}
