<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SalidaContometro extends Model
{
    use HasFactory;

    protected $table = 'salida_contometro';
    protected $primaryKey = 'id_salida_contometro';

    public $timestamps = false;

    protected $fillable = [
        'id_insumo',
        'cantidad_salida',
        'cod_base',
        'flag_acceso',
        'fecha',
        'id_usuario',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_salida_contometro($dato)
    {
        $parte_base = "";
        $parte_insumo = "";
        if($dato['cod_base']!="0"){
            $parte_base = "AND sc.cod_base='".$dato['cod_base']."'";
        }
        if($dato['id_insumo']!="0"){
            $parte_insumo = "AND sc.id_insumo=".$dato['id_insumo'];
        }
        $sql = "SELECT sc.id_salida_contometro,sc.fecha AS orden,sc.cod_base,iu.nom_insumo,
                CASE WHEN sc.flag_acceso=1 THEN sc.cod_base 
                ELSE CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) END AS nom_usuario,
                sc.cantidad_salida,DATE_FORMAT(sc.fecha, '%d-%m-%Y %H:%i:%s') AS fecha,
                DATE_FORMAT(sc.fecha, '%H:%i:%s') AS hora
                FROM salida_contometro sc
                INNER JOIN insumo iu on iu.id_insumo=sc.id_insumo 
                INNER JOIN users us on us.id_usuario=sc.id_usuario 
                WHERE (DATE(sc.fecha) BETWEEN '".$dato['inicio']."' AND '".$dato['fin']."') $parte_base 
                $parte_insumo AND sc.estado=1
                ORDER BY sc.cod_base ASC,sc.fecha ASC";
        $query = DB::select($sql);
        return $query;
    }
}
