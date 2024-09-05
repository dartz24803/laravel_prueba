<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Entrenamiento extends Model
{
    use HasFactory;

    protected $table = 'entrenamiento';

    public $timestamps = false;

    protected $fillable = [
        'id_solicitud_puesto',
        'fecha_inicio',
        'fecha_fin',
        'estado_e',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_entrenamiento($dato=null){
        if(isset($dato['id'])){
            $sql = "SELECT en.id,LOWER(CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater)) 
                    AS nombre_completo,LOWER(pu.nom_puesto) AS nom_puesto_actual,
                    LOWER(pa.nom_puesto) AS nom_puesto_aspirado,sp.id_usuario,sp.id_puesto_aspirado,
                    RIGHT(sp.base,2) AS base,en.estado_e,
                    /*INFOSAP*/
                    us.usuario_nombres,us.usuario_apater,us.usuario_amater,us.num_doc,pa.perfil_infosap,
                    sp.id_usuario,IFNULL((SELECT ba.id_base FROM base ba 
                    WHERE ba.cod_base=sp.base AND ba.estado=1
                    ORDER BY ba.id_base DESC
                    LIMIT 1),0) AS id_base
                    FROM entrenamiento en
                    LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
                    LEFT JOIN users us ON sp.id_usuario=us.id_usuario
                    LEFT JOIN puesto pu ON sp.id_puesto=pu.id_puesto
                    LEFT JOIN puesto pa ON sp.id_puesto_aspirado=pa.id_puesto
                    WHERE en.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $sql = "SELECT en.id,en.fec_reg AS orden,LOWER(pa.nom_puesto) AS nom_puesto_aspirado,sp.base,
                    LOWER(CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater)) 
                    AS nombre_completo,DATE_FORMAT(en.fecha_inicio,'%d-%m-%Y') AS fecha_inicio,
                    DATE_FORMAT(en.fecha_fin,'%d-%m-%Y') AS fecha_fin,CASE WHEN en.estado_e=1 THEN 'En proceso'
                    WHEN en.estado_e=2 THEN 'Finalizado' ELSE '' END AS nom_estado,
                    CASE WHEN en.estado_e=1 THEN 'warning' WHEN en.estado_e=2 THEN 'success' 
                    ELSE '' END AS color_estado,
                    CASE WHEN en.estado_e=2 THEN '#FF000036' ELSE 'transparent' END AS color_fondo,
                    IFNULL((SELECT ee.nota FROM examen_entrenamiento ee 
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                    ORDER BY ee.id DESC
                    LIMIT 1),'') AS nota,
                    (CASE WHEN (SELECT ee.nota FROM examen_entrenamiento ee 
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                    ORDER BY ee.id DESC
                    LIMIT 1)>=14 THEN 'Aprobado' 
                    WHEN (SELECT ee.nota FROM examen_entrenamiento ee 
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                    ORDER BY ee.id DESC
                    LIMIT 1)<14 THEN 'Desaprobado' 
                    WHEN (SELECT ee.hora_fin_real FROM examen_entrenamiento ee 
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                    ORDER BY ee.id DESC
                    LIMIT 1) IS NOT NULL THEN 'Pendiente de revisión' ELSE '' END) AS nom_evaluacion,
                    CASE WHEN (SELECT COUNT(1) FROM examen_entrenamiento ee
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1)=2 THEN 1
                    ELSE (SELECT CASE WHEN ee.nota>=14 OR ee.fecha_revision IS NULL THEN 1 ELSE 0 END 
                    FROM examen_entrenamiento ee
                    WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                    ORDER BY ee.id DESC
                    LIMIT 1) END AS examen_asignado,
                    CASE WHEN (SELECT COUNT(1) FROM pregunta pr 
                    WHERE pr.id_puesto=sp.id_puesto_aspirado AND pr.id_tipo=1 AND pr.estado=1)>=15 AND 
                    (SELECT COUNT(1) FROM pregunta pr 
                    WHERE pr.id_puesto=sp.id_puesto_aspirado AND pr.id_tipo=2 AND pr.estado=1)>=5 THEN 1
                    ELSE 0 END AS examen_acceso,sp.id_puesto_aspirado
                    FROM entrenamiento en
                    LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
                    LEFT JOIN puesto pa ON sp.id_puesto_aspirado=pa.id_puesto
                    LEFT JOIN users us ON sp.id_usuario=us.id_usuario
                    WHERE en.estado=1
                    ORDER BY en.fec_reg DESC";
            $query = DB::select($sql);
            return $query;
        }
    }

    public static function get_list_entrenamiento_terminado(){
        $sql = "SELECT en.id,us.usuario_nombres,us.usuario_apater,us.usuario_amater,
                us.num_doc,pu.perfil_infosap,sp.id_usuario,sp.id_puesto_aspirado AS id_puesto,
                IFNULL((SELECT ba.id_base FROM base ba 
                WHERE ba.cod_base=sp.base AND ba.estado=1
                ORDER BY ba.id_base DESC
                LIMIT 1),0) AS id_base
                FROM entrenamiento en
                LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
                LEFT JOIN users us ON sp.id_usuario=us.id_usuario
                LEFT JOIN puesto pu ON sp.id_puesto=pu.id_puesto
                WHERE DATE_ADD(en.fecha_fin, INTERVAL 1 DAY)=CURDATE() AND en.estado_e=1 AND en.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
