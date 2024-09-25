<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsersHistoricoColaborador extends Model
{
    use HasFactory;

    protected $table = 'users_historico_colaborador';

    public $timestamps = false;

    protected $primaryKey = 'id_historico_colaborador';

    protected $fillable = [
        'id_usuario',
        'id_situacion_laboral',
        'fec_inicio',
        'fec_venc',
        'fec_fin',
        'motivo_fin',
        'id_empresa',
        'id_regimen',
        'id_tipo_contrato',
        'sueldo',
        'bono',
        'observacion',
        'movilidad',
        'refrigerio',
        'asignacion_educac',
        'vale_alimento',
        'otra_remun',
        'remun_exoner',
        'hora_mes',
        'estado_intermedio',
        'id_motivo_cese',
        'archivo_cese',
        'flag_cesado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    static function valida_dato_planilla_activo($dato){
        $sql = "SELECT * FROM historico_colaborador where id_usuario='".$dato['id_usuario']."' and DATE_FORMAT(fec_fin, '%Y-%m-%d')='0000-00-00' and estado=1";
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
