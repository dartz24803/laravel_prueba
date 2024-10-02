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
        'tiempo_llegada',
        'tipo_pago',
        'nombre_transporte',
        'importe_transporte',
        'factura_transporte',
        'observacion_inspf',
        'diferencia',
        'guia_sobrante',
        'guia_faltante',
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
                    LIMIT 1) AS archivo_transporte,md.id_dos,di.nombre_distrito,
                    CASE WHEN tr.transporte='1' THEN 'Agencia - Terrestre'
                    WHEN tr.transporte='2' THEN 'Agencia - Aérea' 
                    WHEN tr.transporte='3' THEN 'Propio' ELSE '' END AS tipo_transporte,
                    (SELECT COUNT(1) FROM tracking_diferencia tdif
                    WHERE tdif.id_tracking=tr.id AND tdif.enviado<tdif.recibido) AS sobrantes,
                    (SELECT COUNT(1) FROM tracking_diferencia tdif
                    WHERE tdif.id_tracking=tr.id AND tdif.enviado>tdif.recibido) AS faltantes
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
                    LEFT JOIN (SELECT MAX(id) AS id_dos,id_tracking
                    FROM tracking_detalle_proceso
                    WHERE id_proceso=2
                    GROUP BY id_tracking) md ON tr.id=md.id_tracking
                    LEFT JOIN distrito di ON bh.id_distrito=di.id_distrito
                    WHERE tr.id=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }elseif(isset($dato['llegada_tienda'])){
            $sql = "SELECT tr.id,bh.cod_base AS hacia,tr.tiempo_llegada,
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
                    TIMESTAMPDIFF(DAY, DATE(de.fecha), CURDATE())=tr.tiempo_llegada";
            $query = DB::select($sql);
            return $query;
        }else{
            $sql = "SELECT tr.id,tr.n_requerimiento,bd.cod_base AS desde,bh.cod_base AS hacia,tp.descripcion AS proceso,
                    CONCAT(CASE WHEN DAYNAME(de.fecha)='Monday' THEN 'Lun'
                    WHEN DAYNAME(de.fecha)='Tuesday' THEN 'Mar'
                    WHEN DAYNAME(de.fecha)='Wednesday' THEN 'Mie'
                    WHEN DAYNAME(de.fecha)='Thursday' THEN 'Jue'
                    WHEN DAYNAME(de.fecha)='Friday' THEN 'Vie'
                    WHEN DAYNAME(de.fecha)='Saturday' THEN 'Sab'
                    WHEN DAYNAME(de.fecha)='Sunday' THEN 'Dom' ELSE '' END,' ',
                    DATE_FORMAT(de.fecha,'%d-%m-%Y')) AS fecha,DATE_FORMAT(de.fecha,'%H:%i') AS hora,
                    CASE WHEN tr.devolucion=1 AND de.id_estado IN (14,15,16) 
                    THEN CONCAT(te.descripcion,' (PENDIENTE DEVOLUCIÓN)') ELSE te.descripcion END AS estado,
                    de.id_estado,te.id_proceso,te.descripcion,
                    (SELECT COUNT(1) FROM tracking_diferencia tdif
                    WHERE tdif.id_tracking=tr.id AND tdif.enviado<tdif.recibido) AS sobrantes,
                    (SELECT COUNT(1) FROM tracking_diferencia tdif
                    WHERE tdif.id_tracking=tr.id AND tdif.enviado>tdif.recibido) AS faltantes
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
                    WHERE (tr.estado=1 AND de.id_estado!=21) OR (tr.estado=1 AND de.id_estado=21 AND 
                    DATE(de.fecha)>DATE_SUB(CURDATE(), INTERVAL 1 WEEK))";
            $query = DB::select($sql);
            return $query;
        }
    }

    public static function get_list_bd_tracking($dato=null){
        $sql = "SELECT tr.n_requerimiento,bd.cod_base AS desde,bh.cod_base AS hacia,
                tp.descripcion AS proceso,
                CONCAT(CASE WHEN DAYNAME(tde.fecha)='Monday' THEN 'Lun'
                WHEN DAYNAME(tde.fecha)='Tuesday' THEN 'Mar'
                WHEN DAYNAME(tde.fecha)='Wednesday' THEN 'Mie'
                WHEN DAYNAME(tde.fecha)='Thursday' THEN 'Jue'
                WHEN DAYNAME(tde.fecha)='Friday' THEN 'Vie'
                WHEN DAYNAME(tde.fecha)='Saturday' THEN 'Sab'
                WHEN DAYNAME(tde.fecha)='Sunday' THEN 'Dom' ELSE '' END,' ',
                DATE_FORMAT(tde.fecha,'%d-%m-%Y')) AS fecha,DATE_FORMAT(tde.fecha,'%H:%i') AS hora,
                te.descripcion AS estado
                FROM tracking_detalle_estado tde
                LEFT JOIN tracking_detalle_proceso tdp ON tde.id_detalle=tdp.id
                LEFT JOIN tracking tr ON tdp.id_tracking=tr.id
                LEFT JOIN base bd ON tr.id_origen_desde=bd.id_base
                LEFT JOIN base bh ON tr.id_origen_hacia=bh.id_base
                LEFT JOIN tracking_proceso tp ON tdp.id_proceso=tp.id
                LEFT JOIN tracking_estado te ON tde.id_estado=te.id
                WHERE tr.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}