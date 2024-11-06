<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExamenEntrenamiento extends Model
{
    use HasFactory;

    protected $table = 'examen_entrenamiento';

    public $timestamps = false;

    protected $fillable = [
        'id_entrenamiento',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'hora_fin_real',
        'nota',
        'fecha_revision',
        'usuario_revision',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_examen_entrenamiento($dato=null){
        if(isset($dato['id'])){
            $sql = "SELECT ee.*,sp.id_puesto_aspirado,CONCAT(ee.fecha,' ',ee.hora_fin) AS fecha_completa,
                    (SELECT nt.id_notificacion FROM notificacion nt
                    WHERE nt.id_tipo=46 AND nt.solicitante=ee.id
                    ORDER BY nt.id_notificacion DESC
                    LIMIT 1) AS id_notificacion,
                    CASE WHEN ee.hora_inicio IS NULL THEN 0 ELSE 1 END AS iniciado,
                    CASE WHEN ee.hora_fin_real IS NULL THEN 0 ELSE 1 END AS finalizado,sp.id_usuario,
                    UPPER(pu.nom_puesto) AS puesto_aspirado
                    FROM examen_entrenamiento ee
                    LEFT JOIN entrenamiento en ON ee.id_entrenamiento=en.id
                    LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
                    LEFT JOIN puesto pu ON sp.id_puesto_aspirado=pu.id_puesto
                    WHERE ee.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $sql = "SELECT ee.id,ee.fecha AS orden,LOWER(pa.nom_puesto) AS nom_puesto_aspirado,sp.base,
                    LOWER(CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater)) 
                    AS nombre_completo,CASE WHEN ee.fecha IS NULL THEN '' 
                    ELSE DATE_FORMAT(ee.fecha,'%d/%m/%Y') END AS fecha,CASE WHEN ee.hora_inicio IS NULL THEN '' 
                    ELSE DATE_FORMAT(ee.hora_inicio,'%H:%i:%s') END AS hora_inicio,
                    CASE WHEN ee.hora_fin IS NULL THEN '' 
                    ELSE DATE_FORMAT(ee.hora_fin,'%H:%i:%s') END AS hora_fin,
                    CASE WHEN ee.hora_fin_real IS NULL THEN '' 
                    ELSE DATE_FORMAT(ee.hora_fin_real,'%H:%i:%s') END AS hora_fin_real,
                    CASE WHEN ee.fecha_revision IS NULL THEN '' 
                    ELSE ee.nota END AS nota,CASE WHEN ee.fecha_revision IS NULL THEN 'Pendiente' 
                    ELSE (CASE WHEN ee.nota>=14 THEN 'Aprobado' ELSE 'Desaprobado' END) END AS nom_estado,
                    CASE WHEN ee.fecha_revision IS NULL THEN 'warning' 
                    ELSE (CASE WHEN ee.nota>=14 THEN 'success' ELSE 'danger' END) END AS color_estado,
                    ee.hora_fin_real,ee.fecha_revision
                    FROM examen_entrenamiento ee
                    LEFT JOIN entrenamiento en ON ee.id_entrenamiento=en.id
                    LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
                    LEFT JOIN puesto pa ON sp.id_puesto_aspirado=pa.id_puesto
                    LEFT JOIN users us ON sp.id_usuario=us.id_usuario
                    WHERE ee.estado=1
                    ORDER BY ee.fecha DESC";
            $query = DB::select($sql);
            return $query;
        }
    }
    
    static function valida_entrenamiento_pendiente($id_usuario){
        $sql = "SELECT en.id FROM entrenamiento en
                INNER JOIN solicitud_puesto sp ON sp.id=en.id_solicitud_puesto AND 
                sp.id_usuario=$id_usuario
                WHERE (en.estado_e=1 AND en.estado=1) OR (en.estado_e=2 AND 
                (CASE WHEN (SELECT COUNT(1) FROM examen_entrenamiento ee
                WHERE ee.id_entrenamiento=en.id AND ee.estado=1)=2 THEN 1
                ELSE IFNULL((SELECT CASE WHEN ee.nota>=14 OR ee.fecha_revision IS NULL THEN 1 ELSE 0 END 
                FROM examen_entrenamiento ee
                WHERE ee.id_entrenamiento=en.id AND ee.estado=1
                ORDER BY ee.id DESC
                LIMIT 1),0) END)=0)";
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
