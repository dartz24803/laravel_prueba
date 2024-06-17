<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupervisionTienda extends Model
{
    use HasFactory;

    protected $table = 'supervision_tienda';

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

    public static function get_list_supervision_tienda($dato){
        if($dato['base']=='0'){
            $parte = "";
        }else{
            $parte = "st.base='".$dato['base']."' AND";
        }
        $sql = "SELECT st.id,st.fecha AS orden,st.base,DATE_FORMAT(st.fecha,'%d-%m-%Y') AS fecha,
                CASE WHEN st.observacion='' THEN 'Sin observación' ELSE st.observacion END AS observacion,
                CASE WHEN (SELECT COUNT(1) FROM detalle_supervision_tienda dc
                WHERE dc.id_supervision_tienda=st.id)=(SELECT COUNT(1) FROM detalle_supervision_tienda dc
                WHERE dc.id_supervision_tienda=st.id AND dc.valor=1) THEN 'Completo' 
                ELSE 'Incompleto' END AS nom_estado,
                CASE WHEN (SELECT COUNT(1) FROM detalle_supervision_tienda dc
                WHERE dc.id_supervision_tienda=st.id)=(SELECT COUNT(1) FROM detalle_supervision_tienda dc
                WHERE dc.id_supervision_tienda=st.id AND dc.valor=1) THEN 'success' 
                ELSE 'danger' END AS color_estado,
                (SELECT COUNT(1) FROM archivos_supervision_tienda dc
                WHERE dc.id_supervision_tienda=st.id) AS v_evidencia
                FROM supervision_tienda st
                WHERE $parte st.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
