<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeguimientoCoordinador extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_coordinador';

    public $timestamps = false;

    protected $fillable = [
        'base',
        'fecha',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_seguimiento_coordinador($dato){
        if($dato['base']=='0'){
            $parte = "";
        }else{
            $parte = "sc.base='".$dato['base']."' AND";
        }
        $sql = "SELECT sc.id,sc.fecha AS orden,sc.base,DATE_FORMAT(sc.fecha,'%d-%m-%Y') AS fecha,
                CASE WHEN sc.observacion='' THEN 'Sin observación' ELSE sc.observacion END AS observacion,
                CASE WHEN (SELECT COUNT(1) FROM detalle_seguimiento_coordinador dc
                WHERE dc.id_seguimiento_coordinador=sc.id)=(SELECT COUNT(1) 
                FROM detalle_seguimiento_coordinador dc
                WHERE dc.id_seguimiento_coordinador=sc.id AND dc.valor=1) THEN 'Completo' 
                ELSE 'Incompleto' END AS nom_estado,
                CASE WHEN (SELECT COUNT(1) FROM detalle_seguimiento_coordinador dc
                WHERE dc.id_seguimiento_coordinador=sc.id)=(SELECT COUNT(1) 
                FROM detalle_seguimiento_coordinador dc
                WHERE dc.id_seguimiento_coordinador=sc.id AND dc.valor=1) THEN 'success' 
                ELSE 'danger' END AS color_estado,
                (SELECT COUNT(1) FROM archivos_seguimiento_coordinador dc
                WHERE dc.id_seguimiento_coordinador=sc.id) AS v_evidencia
                FROM seguimiento_coordinador sc
                WHERE $parte sc.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
