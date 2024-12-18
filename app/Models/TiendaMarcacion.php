<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TiendaMarcacion extends Model
{
    use HasFactory;

    protected $table = 'tienda_marcacion';
    protected $primaryKey = 'id_tienda_marcacion';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'cant_foto_ingreso',
        'cant_foto_apertura',
        'cant_foto_cierre',
        'cant_foto_salida',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_tienda_marcacion(){
        $sql = "SELECT tm.id_tienda_marcacion,tm.cod_base,
                (SELECT GROUP_CONCAT(td.nom_dia ORDER BY td.dia ASC SEPARATOR ', ') 
                FROM tienda_marcacion_dia td
                WHERE td.id_tienda_marcacion=tm.id_tienda_marcacion) AS dias
                FROM tienda_marcacion tm
                WHERE tm.estado=1";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_reporte_apertura_cierre_tienda(){
        $sql = "SELECT tm.cod_base,
                (SELECT ac.ingreso FROM apertura_cierre_tienda ac
                WHERE ac.fecha=CURDATE() AND ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS ingreso,
                (SELECT TIMESTAMPDIFF(MINUTE, ac.ingreso, ac.ingreso_horario)
                FROM apertura_cierre_tienda ac
                WHERE ac.fecha=CURDATE() AND ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS diferencia_ingreso,
                (SELECT ac.apertura FROM apertura_cierre_tienda ac
                WHERE ac.fecha=CURDATE() AND ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS apertura,
                (SELECT TIMESTAMPDIFF(MINUTE, ac.apertura, ac.apertura_horario)
                FROM apertura_cierre_tienda ac
                WHERE ac.fecha=CURDATE() AND ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS diferencia_apertura,
                (SELECT ac.cierre FROM apertura_cierre_tienda ac
                WHERE ac.fecha=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND 
                ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS cierre,
                (SELECT TIMESTAMPDIFF(MINUTE, ac.cierre, ac.cierre_horario)
                FROM apertura_cierre_tienda ac
                WHERE ac.fecha=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND 
                ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS diferencia_cierre,
                (SELECT ac.salida FROM apertura_cierre_tienda ac
                WHERE ac.fecha=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND 
                ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS salida,
                (SELECT TIMESTAMPDIFF(MINUTE, ac.salida, ac.salida_horario)
                FROM apertura_cierre_tienda ac
                WHERE ac.fecha=DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND 
                ac.cod_base=tm.cod_base AND ac.estado=1
                ORDER BY ac.id_apertura_cierre DESC
                LIMIT 1) AS diferencia_salida
                FROM tienda_marcacion tm
                WHERE tm.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}