<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeguridadAsistencia extends Model
{
    use HasFactory;

    protected $table = 'seguridad_asistencia';
    protected $primaryKey = 'id_seguridad_asistencia';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'base',
        'cod_sede',
        'cod_sedes',
        'fecha',
        'h_ingreso',
        'fecha_salida',
        'h_salida',
        'observacion',
        'imagen',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_lectora($dato=null)
    {
        if(isset($dato['id_seguridad_asistencia'])){
            $sql = "SELECT sa.id_seguridad_asistencia,sa.base,
                    CONCAT(us.usuario_apater,' ',us.usuario_amater,', ',us.usuario_nombres) AS colaborador,
                    DATE_FORMAT(sa.fecha,'%d/%m/%Y') AS fecha,sa.h_ingreso,sa.cod_sede,sa.fecha_salida,
                    sa.h_salida,sa.cod_sedes,sa.observacion,sa.imagen
                    FROM seguridad_asistencia sa
                    INNER JOIN users us ON sa.id_usuario=us.id_usuario
                    WHERE sa.id_seguridad_asistencia=".$dato['id_seguridad_asistencia'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            if ($dato['fec_desde'] && $dato['fec_hasta']) {
                $fec_desde = $dato['fec_desde'];
                $fec_hasta = $dato['fec_hasta'];
                $sql = "SELECT sa.id_seguridad_asistencia,sa.base,
                        CONCAT(us.usuario_apater,' ',us.usuario_amater,', ',us.usuario_nombres) AS colaborador,
                        DATE_FORMAT(sa.fecha,'%d/%m/%Y') AS f_ingreso,sa.h_ingreso,sa.cod_sede,
                        DATE_FORMAT(sa.fecha_salida,'%d/%m/%Y') AS f_salida,sa.h_salida,sa.cod_sedes,sa.observacion,
                        sa.imagen
                        FROM seguridad_asistencia sa
                        INNER JOIN users us ON sa.id_usuario=us.id_usuario
                        WHERE (sa.fecha BETWEEN '$fec_desde' AND '$fec_hasta')
                        AND sa.estado = 1";
            } else {
                $sql = "SELECT sa.id_seguridad_asistencia,sa.base,
                        CONCAT(us.usuario_apater,' ',us.usuario_amater,', ',us.usuario_nombres) AS colaborador,
                        DATE_FORMAT(sa.fecha,'%d/%m/%Y') AS f_ingreso,sa.h_ingreso,sa.cod_sede,
                        DATE_FORMAT(sa.fecha_salida,'%d/%m/%Y') AS f_salida,sa.h_salida,sa.cod_sedes,sa.observacion,
                        sa.imagen
                        FROM seguridad_asistencia sa
                        INNER JOIN users us ON sa.id_usuario=us.id_usuario
                        WHERE (sa.fecha=CURDATE() AND sa.estado=1) OR (sa.fecha_salida=CURDATE() AND sa.estado=1)";
            }

            $query = DB::select($sql);
            return $query;
        }
    }

    public static function get_list_manual($dato=null)
    {
        $parte_usuario = "";
        if($dato['id_colaborador']!="0"){
            $parte_usuario = "AND sa.id_usuario=".$dato['id_colaborador'];
        }
        $parte_base = "";
        if($dato['cod_base']!="0"){
            $parte_base = "AND sa.base='".$dato['cod_base']."'";
        }elseif(session('usuario')->id_puesto==24 && $dato['cod_base']=="0"){
            $parte_base = "AND sa.base IN ('CD','OFC','AMT')";
        }
        $sql = "SELECT sa.id_seguridad_asistencia,sa.base,
                CONCAT(us.usuario_apater,' ',us.usuario_amater,', ',us.usuario_nombres) AS colaborador,
                DATE_FORMAT(sa.fecha,'%d/%m/%Y') AS f_ingreso,sa.h_ingreso,sa.cod_sede,
                DATE_FORMAT(sa.fecha_salida,'%d/%m/%Y') AS f_salida,sa.h_salida,sa.cod_sedes,sa.observacion,
                sa.imagen
                FROM seguridad_asistencia sa
                INNER JOIN users us ON sa.id_usuario=us.id_usuario
                WHERE (sa.fecha BETWEEN '".$dato['fecha_inicio']."' AND '".$dato['fecha_fin']."') $parte_usuario $parte_base AND sa.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
