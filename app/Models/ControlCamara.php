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
        $sql = "SELECT cc.id,cc.fecha AS orden,se.nombre_sede,DATE_FORMAT(cc.fecha,'%d-%m-%Y') AS fecha,
                CONCAT(us.usuario_apater,', ',us.usuario_nombres) AS colaborador,
                CASE WHEN cc.hora_programada>='12:00:00' THEN 
                CONCAT(DATE_FORMAT(cc.hora_programada,'%H:%i'),' PM') 
                ELSE CONCAT(DATE_FORMAT(cc.hora_programada,'%H:%i'),' AM') END AS hora_programada,
                CASE WHEN cc.hora_registro>='12:00:00' THEN 
                CONCAT(DATE_FORMAT(cc.hora_registro,'%H:%i'),' PM') 
                ELSE CONCAT(DATE_FORMAT(cc.hora_registro,'%H:%i'),' AM') END AS hora_registro,
                CASE WHEN TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro)>0
                THEN TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro) ELSE '' END AS diferencia,
                CASE WHEN TIMESTAMPDIFF(MINUTE, cc.hora_programada, cc.hora_registro)>5
                THEN 'Atrasado' ELSE 'OK' END AS observacion,lo.descripcion AS tienda,
                oc.descripcion AS ocurrencia,
                (SELECT COUNT(1) FROM control_camara_archivo ca
                WHERE ca.id_control_camara=cc.id) AS archivos
                FROM control_camara cc
                LEFT JOIN sedes se ON cc.id_sede=se.id_sede
                LEFT JOIN users us ON cc.id_usuario=us.id_usuario
                LEFT JOIN local lo ON cc.id_tienda=lo.id_local
                LEFT JOIN ocurrencias_camaras oc ON cc.id_ocurrencia=oc.id_ocurrencias_camaras
                WHERE $parte_sede $parte_local cc.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
