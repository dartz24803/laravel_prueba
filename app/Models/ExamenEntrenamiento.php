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
                    CASE WHEN ee.fecha_revision IS NULL THEN '' 
                    ELSE ee.nota END AS nota,CASE WHEN ee.fecha_revision IS NULL THEN 'Pendiente' 
                    ELSE (CASE WHEN ee.nota>=14 THEN 'Aprobado' ELSE 'Rechazado' END) END AS nom_estado,
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
}
