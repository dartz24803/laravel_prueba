<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class Empresas extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'empresas';

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        'cod_empresa',
        'nom_empresa',
        'ruc_empresa',
        'id_banco',
        'num_cuenta',
        'email_empresa',
        'representante_empresa',
        'id_tipo_documento',
        'num_documento',
        'num_partida',
        'id_departamento',
        'id_distrito',
        'id_provincia',
        'direccion',
        'activo',
        'id_regimen',
        'telefono_empresa',
        'inicio_actividad',
        'dias_laborales',
        'hora_dia',
        'aporte_senati',
        'firma',
        'logo',
        'pie',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

}
