<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'tracking';

    public $timestamps = false;

    protected $fillable = [
        'n_requerimiento',
        'n_guia_remision',
        'semana',
        'id_origen_desde',
        'desde',
        'id_origen_hacia',
        'hacia',
        'guia_transporte',
        'peso',
        'paquetes',
        'sobres',
        'fardos',
        'bultos',
        'caja',
        'transporte',
        'nombre_transporte',
        'importe_transporte',
        'factura_transporte',
        'observacion_inspf',
        'diferencia',
        'guia_diferencia',
        'devolucion',
        'iniciar',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_tracking($dato=null){
        if(isset($dato['id'])){
            $sql = "SELECT tr.*,bd.cod_base AS desde,bh.cod_base AS hacia,
                    IFNULL(tr.importe_transporte,0) AS importe_formateado,
                    mp.ultimo_id AS id_detalle,de.id_estado,
                    (SELECT ta.archivo FROM tracking_archivo ta
                    WHERE ta.id_tracking=tr.id AND ta.tipo=1
                    ORDER BY ta.id DESC
                    LIMIT 1) AS archivo_transporte
                    FROM tracking tr
                    LEFT JOIN base bd ON tr.id_origen_desde=bd.id_base
                    LEFT JOIN base bh ON tr.id_origen_hacia=bh.id_base
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_tracking
                    FROM tracking_detalle_proceso
                    GROUP BY id_tracking) mp ON tr.id=mp.id_tracking
                    LEFT JOIN tracking_detalle_proceso dp ON mp.ultimo_id=dp.id
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_detalle
                    FROM tracking_detalle_estado
                    GROUP BY id_detalle) me ON mp.ultimo_id=me.id_detalle
                    LEFT JOIN tracking_detalle_estado de ON me.ultimo_id=de.id
                    WHERE tr.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }elseif(isset($dato['llegada_tienda'])){
            $sql = "SELECT tr.id,bh.cod_base AS hacia,bh.tiempo_llegada,
                    mp.ultimo_id AS id_detalle,de.id_estado,
                    TIMESTAMPDIFF(DAY, DATE(de.fecha), CURDATE()) AS diferencia_dias
                    FROM tracking tr
                    LEFT JOIN base bh ON tr.id_origen_hacia=bh.id_base
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_tracking
                    FROM tracking_detalle_proceso
                    GROUP BY id_tracking) mp ON tr.id=mp.id_tracking
                    LEFT JOIN tracking_detalle_proceso dp ON mp.ultimo_id=dp.id
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_detalle
                    FROM tracking_detalle_estado
                    GROUP BY id_detalle) me ON mp.ultimo_id=me.id_detalle
                    LEFT JOIN tracking_detalle_estado de ON me.ultimo_id=de.id
                    WHERE de.id_estado=4 AND 
                    TIMESTAMPDIFF(DAY, DATE(de.fecha), CURDATE())=bh.tiempo_llegada";
            $query = DB::select($sql);
            return $query;
        }else{
            $sql = "SELECT tr.id,tr.n_requerimiento,bd.cod_base AS desde,bh.cod_base AS hacia,tp.descripcion AS proceso,
                    DATE_FORMAT(de.fecha,'%d-%m-%Y') AS fecha,DATE_FORMAT(de.fecha,'%H:%i') AS hora,
                    CASE WHEN tr.devolucion=1 AND de.id_estado IN (14,15,16) 
                    THEN CONCAT(te.descripcion,' (PENDIENTE DEVOLUCIÓN)') ELSE te.descripcion END AS estado,
                    de.id_estado
                    FROM tracking tr
                    LEFT JOIN base bd ON tr.id_origen_desde=bd.id_base
                    LEFT JOIN base bh ON tr.id_origen_hacia=bh.id_base
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_tracking
                    FROM tracking_detalle_proceso
                    GROUP BY id_tracking) mp ON tr.id=mp.id_tracking
                    LEFT JOIN tracking_detalle_proceso dp ON mp.ultimo_id=dp.id
                    LEFT JOIN tracking_proceso tp ON dp.id_proceso=tp.id
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_detalle
                    FROM tracking_detalle_estado
                    GROUP BY id_detalle) me ON mp.ultimo_id=me.id_detalle
                    LEFT JOIN tracking_detalle_estado de ON me.ultimo_id=de.id
                    LEFT JOIN tracking_estado te ON de.id_estado=te.id
                    WHERE tr.estado=1";
            $query = DB::select($sql);
            return $query;
        }
    }
}