<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ocurrencias extends Model
{
    use HasFactory;

    protected $table = 'ocurrencia';
    protected $primaryKey = 'id_ocurrencia';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'cod_base',
        'cod_ocurrencia',
        'fec_ocurrencia',
        'hora_ocurrencia',
        'id_tipo',
        'id_zona',
        'id_estilo',
        'id_conclusion',
        'id_gestion',
        'monto',
        'cantidad',
        'descripcion',
        'accion_inmediata',
        'revisado',
        'user_revisado',
        'hora',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_combo_colaborador_ocurrencia()
    {
        $sql = "SELECT oc.id_usuario AS id_colaborador,
                CONCAT(us.usuario_nombres,' ',us.usuario_apater) AS nom_colaborador 
                FROM ocurrencia oc
                LEFT JOIN users us ON us.id_usuario=oc.id_usuario
                WHERE oc.estado=1 AND oc.id_usuario>0
                GROUP BY oc.id_usuario,CONCAT(us.usuario_nombres,' ',us.usuario_apater),us.usuario_nombres,us.usuario_apater
                ORDER BY us.usuario_nombres ASC,us.usuario_apater";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    public static function get_list_ocurrencia($id_ocurrencia = null, $cod_base = null, $fecha = null, $fecha_fin = null, $id_tipo_ocurrencia = null, $id_colaborador = null)
    {
        if (isset($id_ocurrencia) && $id_ocurrencia > 0) {
            $sql = "SELECT *,DATE_FORMAT(fec_ocurrencia, '%Y-%m-%d') AS fecha_ocurrencia 
                    FROM ocurrencia 
                    WHERE id_ocurrencia=$id_ocurrencia";
        } else {
            $parte_base = "";
            if ($cod_base != "Todo") {
                $parte_base = "AND oc.cod_base='$cod_base'";
            }
            $parte_tipo_ocurrencia = "";
            if ($id_tipo_ocurrencia != "Todo") {
                $parte_tipo_ocurrencia = "AND oc.id_tipo='$id_tipo_ocurrencia'";
            }
            $parte_colaborador = "";
            if ($id_colaborador != "Todo") {
                $parte_colaborador = "AND oc.id_usuario='$id_colaborador'";
            }
            $sql = "SELECT oc.id_ocurrencia,oc.cod_ocurrencia,
                    DATE_FORMAT(oc.fec_ocurrencia, '%d-%m-%Y') AS fecha_ocurrencia,
                    oc.cod_base,CONCAT(us.usuario_nombres,' ',us.usuario_apater) AS colaborador,
                    tc.nom_tipo_ocurrencia,co.nom_conclusion,og.nom_gestion,oc.cantidad,
                    oc.monto,oc.descripcion,oc.id_zona,oc.id_estilo,CASE WHEN oc.revisado=1 THEN 'Si' 
                    ELSE 'No' END AS v_revisado,oc.hora,CASE WHEN oc.id_zona=1 THEN 'Hombre'
                    WHEN oc.id_zona=2 THEN 'Mujer' WHEN oc.id_zona=3 THEN 'Infantil'
                    ELSE '' END AS nom_zona,CASE WHEN oc.id_estilo=1 THEN 'Lector de código de barra'
                    ELSE '' END AS nom_estilo
                    FROM ocurrencia oc
                    LEFT JOIN tipo_ocurrencia tc ON tc.id_tipo_ocurrencia=oc.id_tipo
                    LEFT JOIN conclusion co ON co.id_conclusion=oc.id_conclusion
                    LEFT JOIN ocurrencia_gestion og ON og.id_gestion=oc.id_gestion
                    LEFT JOIN users us ON us.id_usuario=oc.id_usuario
                    WHERE oc.estado=1 AND oc.fec_ocurrencia BETWEEN '" . $fecha . "' AND '" . $fecha_fin . "' 
                    $parte_base $parte_tipo_ocurrencia $parte_colaborador
                    ORDER BY oc.cod_ocurrencia ASC";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
