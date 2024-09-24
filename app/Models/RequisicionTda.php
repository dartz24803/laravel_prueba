<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RequisicionTda extends Model
{
    use HasFactory;

    protected $table = 'requisicion_tda';
    protected $primaryKey = 'id_requisicion';

    public $timestamps = false;

    protected $fillable = [
        'cod_requisicion',
        'fecha',
        'base',
        'id_usuario',
        'estado_registro',
        'fec_aprob',
        'user_aprob',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_requisicion_tienda($dato=null)
    {
        $parte_base = "";
        if($dato['base']!="0"){
            $parte_base = "rt.base='".$dato['base']."' AND";
        }
        $sql = "SELECT rt.id_requisicion,rt.fecha AS orden,DATE_FORMAT(rt.fecha,'%d-%m-%Y') AS fecha,
                rt.base,CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',
                us.usuario_amater) AS nom_usuario,
                CONCAT('S/ ',ROUND((SELECT SUM(rd.cantidad*rd.precio) FROM requisicion_tda_detalle rd
                WHERE rd.id_requisicion=rt.id_requisicion),2)) AS total,
                CASE WHEN rt.estado_registro=1 THEN 'PENDIENTE DE APROBACIÓN' 
                WHEN rt.estado_registro=2 THEN 'APROBADO' ELSE '' END AS nom_estado,rt.estado_registro
                FROM requisicion_tda rt
                INNER JOIN users us ON us.id_usuario=rt.id_usuario
                WHERE $parte_base rt.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
