<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TrackingDetalleEstado extends Model
{
    use HasFactory;

    protected $table = 'tracking_detalle_estado';

    public $timestamps = false;

    protected $fillable = [
        'id_detalle',
        'id_estado',
        'fecha',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    function get_list_tracking_detalle_estado($id_detalle,$id_estado){
        $sql = "SELECT CONCAT(DATE_FORMAT(fecha, '%d'),' ', 
                CASE MONTH(fecha) WHEN 1 THEN 'ENERO' WHEN 2 THEN 'FEBRERO' WHEN 3 THEN 'MARZO'
                WHEN 4 THEN 'ABRIL' WHEN 5 THEN 'MAYO' WHEN 6 THEN 'JUNIO' WHEN 7 THEN 'JULIO'
                WHEN 8 THEN 'AGOSTO' WHEN 9 THEN 'SEPTIEMBRE' WHEN 10 THEN 'OCTUBRE' WHEN 11 THEN 'NOVIEMBRE'
                WHEN 12 THEN 'DICIEMBRE' END, ' DEL ',DATE_FORMAT(fecha, '%Y')) AS fecha_formateada,fecha
                FROM tracking_detalle_estado
                WHERE id_detalle=$id_detalle AND id_estado=$id_estado
                ORDER BY id DESC
                LIMIT 1";
        $query = DB::select($sql);
        return $query[0];
    }
}
