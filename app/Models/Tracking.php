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
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_tracking($id=null){
        if(isset($id)){
            $sql = "SELECT tr.*,IFNULL(tr.importe_transporte,0) AS importe_formateado,
                    mp.ultimo_id AS id_detalle,de.id_estado
                    FROM tracking tr
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_tracking
                    FROM tracking_detalle_proceso
                    GROUP BY id_tracking) mp ON tr.id=mp.id_tracking
                    LEFT JOIN tracking_detalle_proceso dp ON mp.ultimo_id=dp.id
                    LEFT JOIN (SELECT MAX(id) AS ultimo_id,id_detalle
                    FROM tracking_detalle_estado
                    GROUP BY id_detalle) me ON mp.ultimo_id=me.id_detalle
                    LEFT JOIN tracking_detalle_estado de ON me.ultimo_id=de.id
                    WHERE tr.id=$id";
            $query = DB::select($sql);
            return $query[0];
        }else{
            $sql = "SELECT tr.id,tr.n_requerimiento,tr.desde,tr.hacia,tp.descripcion AS proceso,
                    DATE_FORMAT(de.fecha,'%d-%m-%Y') AS fecha,DATE_FORMAT(de.fecha,'%H:%i') AS hora,
                    te.descripcion AS estado,de.id_estado
                    FROM tracking tr
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