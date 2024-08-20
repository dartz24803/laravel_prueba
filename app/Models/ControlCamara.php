<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ControlCamara extends Model
{
    use HasFactory;

    protected $table = 'control_camara';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_sede',
        'fecha',
        'completado',
        'hora_programada',
        'hora_registro',
        'id_tienda',
        'id_ocurrencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];


    public static function get_list_control_camara($dato)
    {
        $parte_sede = "";
        if($dato['id_sede']!="0"){
            $parte_sede = "cc.id_sede=".$dato['id_sede']." AND";
        }
        $parte_local = "";
        if($dato['id_local']!="0"){
            $parte_local = "cc.id_tienda=".$dato['id_local']." AND";
        }
        $sql = "SELECT cc.id, cc.fec_reg,
                    cc.fecha AS orden,
                    se.nombre_sede,
                    DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,
                    CONCAT(us.usuario_apater, ', ', us.usuario_nombres) AS colaborador,
                    CASE
                        WHEN cc.hora_programada >= '12:00:00' THEN CONCAT(DATE_FORMAT(cc.hora_programada, '%H:%i'), ' PM')
                        ELSE CONCAT(DATE_FORMAT(cc.hora_programada, '%H:%i'), ' AM')
                    END AS hora_programada,
                    CASE
                        WHEN cc.hora_registro >= '12:00:00' THEN CONCAT(DATE_FORMAT(cc.hora_registro, '%H:%i'), ' PM')
                        ELSE CONCAT(DATE_FORMAT(cc.hora_registro, '%H:%i'), ' AM')
                    END AS hora_registro,
                    CASE
                        WHEN TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro) > 0 THEN TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro)
                        ELSE ''
                    END AS diferencia,
                    CASE
                        WHEN lo.id_local IN (16, 17) AND TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro) > 10 THEN 'Atrasado'
                        WHEN lo.id_local = 18 AND TIMESTAMPDIFF(MINUTE, cc.hora_registro, cc.hora_programada) > 10 THEN 'Atrasado'
                        ELSE 'OK'
                    END AS observacion,
                    lo.descripcion AS tienda,
                    GROUP_CONCAT(oc.descripcion ORDER BY oc.id_ocurrencias_camaras SEPARATOR ', ') AS ocurrencia,
                    (SELECT COUNT(1) FROM control_camara_archivo ca WHERE ca.id_control_camara = cc.id) AS archivos
                FROM
                    control_camara cc
                LEFT JOIN
                    sedes se ON cc.id_sede = se.id_sede
                LEFT JOIN
                    users us ON cc.id_usuario = us.id_usuario
                LEFT JOIN
                    local lo ON cc.id_tienda = lo.id_local
                LEFT JOIN
                    detalle_ocurrencias_camaras doc ON cc.id = doc.id_control_camara
                LEFT JOIN
                    ocurrencias_camaras oc ON doc.id_ocurrencia = oc.id_ocurrencias_camaras
                WHERE
                    $parte_local
                    $parte_sede
                    cc.estado = 1
                GROUP BY cc.id, cc.fecha, se.nombre_sede, us.usuario_apater,
                    us.usuario_nombres, cc.hora_programada, cc.hora_registro, lo.descripcion, cc.fec_reg, lo.id_local
                ORDER BY
                    cc.id DESC;";

        $query = DB::select($sql);
        return $query;
    }
}
