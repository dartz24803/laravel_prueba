<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HistoricoColaborador extends Model
{
    use HasFactory;

    protected $table = 'historico_colaborador';

    public $timestamps = false;

    protected $primaryKey = 'id_historico_colaborador';

    protected $fillable = [
        'id_usuario',
        'id_situacion_laboral',
        'fec_inicio',
        'fec_vencimiento',
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
    
    static function valida_dato_planilla($dato){
        $sql = "SELECT * FROM historico_colaborador where id_situacion_laboral='".$dato['id_situacion_laboral']."' and 
                fec_inicio='".$dato['fec_inicio']."' and id_usuario='".$dato['id_usuario']."' and estado in (1,3)";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true); 
    }

    static function valida_dato_planilla_activo($dato){
        $sql = "SELECT * FROM historico_colaborador where id_usuario='".$dato['id_usuario']."' and DATE_FORMAT(fec_fin, '%Y-%m-%d')='0000-00-00' and estado=1";
        
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    public static function get_list_dato_planilla($dato=null){
        $sql = "SELECT hc.id_historico_colaborador,hc.fec_reg AS orden,
                CASE WHEN hc.estado=1 THEN 'Activo'
                WHEN hc.estado=3 AND hc.flag_cesado=1 THEN 'Cesado'
                WHEN hc.estado=3 AND hc.flag_cesado=0 THEN 'Terminado'
                WHEN hc.estado=4 THEN 'Renovación'
                WHEN hc.estado=5 THEN 'Reingreso' END AS nom_estado,sl.nom_situacion_laboral,
                CASE WHEN hc.fec_inicio IS NOT NULL AND hc.fec_inicio NOT LIKE '%0000%' THEN 
                DATE_FORMAT(hc.fec_inicio,'%d/%m/%Y') ELSE '' END AS fec_inicio,
                CASE WHEN hc.fec_fin IS NOT NULL AND hc.fec_fin NOT LIKE '%0000%' THEN 
                DATE_FORMAT(hc.fec_fin,'%d/%m/%Y') ELSE '' END AS fec_fin,em.nom_empresa,
                CONCAT((CASE WHEN hc.fec_fin IS NOT NULL AND hc.fec_fin NOT LIKE '%0000%' THEN 
                TIMESTAMPDIFF(DAY, hc.fec_inicio, hc.fec_fin)
                ELSE TIMESTAMPDIFF(DAY, hc.fec_inicio, CURDATE()) END),' Día(s)') AS dias_laborados,
                CONCAT('S/. ',hc.sueldo) AS sueldo,CONCAT('S/. ',hc.bono) AS bono,
                CONCAT('S/. ',(hc.sueldo+hc.bono)) AS total,hc.observacion,mb.nom_motivo
                FROM historico_colaborador hc
                INNER JOIN situacion_laboral sl ON sl.id_situacion_laboral=hc.id_situacion_laboral
                LEFT JOIN empresas em ON hc.id_empresa=em.id_empresa
                LEFT JOIN motivo_baja_rrhh mb ON hc.id_motivo_cese=mb.id_motivo
                WHERE hc.id_usuario=".$dato['id_usuario']." AND hc.estado IN (1,3,4)";
        $query = DB::select($sql);
        return $query;
    }
}
