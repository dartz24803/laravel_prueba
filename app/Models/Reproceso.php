<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reproceso extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'reproceso';

    protected $primaryKey = 'id';
    
    protected $fillable = [
        'fecha_documento',
        'documento',
        'usuario',
        'descripcion',
        'cantidad',
        'proveedor',
        'estado_r',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_reproceso(){
        $sql = "SELECT re.id,re.fecha_documento AS orden,UPPER(me.nom_mes) AS mes,
                    DATE_FORMAT(re.fecha_documento,'%d/%m/%Y') AS fecha_documento,re.documento,
                    ur.nombre AS usuario,re.descripcion,re.cantidad,re.proveedor,
                    CASE WHEN re.estado_r=1 THEN 'PENDIENTE' WHEN re.estado_r=2 THEN 'EN PROCESO'
                    WHEN re.estado_r=3 THEN 'REPORTADO' ELSE '' END AS status
                    FROM reproceso re
                    LEFT JOIN mes me ON MONTH(re.fecha_documento)=me.id_mes
                    LEFT JOIN usuario_reproceso ur ON re.usuario=ur.id
                    WHERE re.estado=1
                    ORDER BY re.fecha_documento DESC";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
