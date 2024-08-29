<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolicitudPuesto extends Model
{
    use HasFactory;

    protected $table = 'solicitud_puesto';

    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'base',
        'id_puesto',
        'id_puesto_aspirado',
        'id_usuario',
        'grado_instruccion',
        'observacion',
        'estado_s',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_solicitud_puesto($dato){
        if(isset($dato['id'])){
            $sql = "SELECT sp.id,LOWER(CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater)) 
                    AS nombre_completo,sp.base,LOWER(pu.nom_puesto) AS nom_puesto_actual,
                    LOWER(pa.nom_puesto) AS nom_puesto_aspirado,CASE WHEN sp.observacion=1 THEN 'Si' 
                    ELSE 'No' END AS observacion,sp.id_puesto_aspirado,
                    /*INFOSAP*/
                    us.usuario_nombres,us.usuario_apater,us.usuario_amater,us.num_doc,pa.perfil_infosap,
                    sp.id_usuario,IFNULL((SELECT ba.id_base FROM base ba 
                    WHERE ba.cod_base=sp.base AND ba.estado=1
                    ORDER BY ba.id_base DESC
                    LIMIT 1),0) AS id_base
                    FROM solicitud_puesto sp
                    INNER JOIN users us ON sp.id_usuario=us.id_usuario
                    INNER JOIN puesto pu ON sp.id_puesto=pu.id_puesto
                    INNER JOIN puesto pa ON sp.id_puesto_aspirado=pa.id_puesto
                    WHERE sp.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $parte = "";
            if($dato['base']!="0"){
                $parte = "sp.base='".$dato['base']."' AND";
            }
            $sql = "SELECT sp.id,sp.fecha AS orden,DATE_FORMAT(sp.fecha,'%d-%m-%Y') AS fecha_solicitud,sp.base,
                    LOWER(pu.nom_puesto) AS nom_puesto,LOWER(pa.nom_puesto) AS nom_puesto_aspirado,
                    LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater)) 
                    AS nom_usuario,gi.nom_grado_instruccion AS grado_instruccion,
                    CASE WHEN sp.observacion=1 THEN 'Si' ELSE 'No' END AS observacion,
                    CASE WHEN sp.estado_s=1 THEN 'Pendiente' WHEN sp.estado_s=2 THEN 'Aprobado'
                    WHEN sp.estado_s=3 THEN 'Rechazado' ELSE '' END AS nom_estado,
                    CASE WHEN sp.estado_s=1 THEN 'warning' WHEN sp.estado_s=2 THEN 'success'
                    WHEN sp.estado_s=3 THEN 'danger' ELSE '' END AS color_estado,sp.estado_s,sp.id_usuario
                    FROM solicitud_puesto sp
                    INNER JOIN puesto pu ON sp.id_puesto=pu.id_puesto
                    INNER JOIN puesto pa ON sp.id_puesto_aspirado=pa.id_puesto
                    INNER JOIN users us ON sp.id_usuario=us.id_usuario
                    INNER JOIN grado_instruccion gi ON sp.grado_instruccion=gi.id_grado_instruccion
                    WHERE $parte sp.estado=1
                    ORDER BY sp.fecha DESC";
            $query = DB::select($sql);
            return $query;
        }
    }
}
