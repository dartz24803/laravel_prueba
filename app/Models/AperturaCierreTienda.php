<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AperturaCierreTienda extends Model
{
    use HasFactory;

    protected $table = 'apertura_cierre_tienda';
    protected $primaryKey = 'id_apertura_cierre';

    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'cod_base',
        'ingreso',
        'ingreso_horario',
        'obs_ingreso',
        'apertura',
        'apertura_horario',
        'obs_apertura',
        'cierre',
        'cierre_horario',
        'obs_cierre',
        'salida',
        'salida_horario',
        'obs_salida',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_apertura_cierre_tienda($dato)
    {
        if(isset($dato['id_apertura_cierre'])){
            $sql = "SELECT id_apertura_cierre,cod_base,CASE WHEN apertura IS NULL AND cierre IS NULL AND 
                    salida IS NULL THEN '2'
                    WHEN apertura IS NOT NULL AND cierre IS NULL AND salida IS NULL THEN '3'
                    WHEN apertura IS NOT NULL AND cierre IS NOT NULL AND salida IS NULL THEN '4'
                    ELSE '0' END AS tipo_apertura 
                    FROM apertura_cierre_tienda
                    WHERE id_apertura_cierre=".$dato['id_apertura_cierre'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            $parte = "";
            if($dato['cod_base']!="0"){
                $parte = "AND ac.cod_base='".$dato['cod_base']."'";
            }
            $sql = "SELECT ac.id_apertura_cierre,ac.cod_base,
                    DATE_FORMAT(ac.fecha,'%d/%m/%Y') AS fecha,
                    /*CONCAT( (CASE WHEN DAYNAME(ac.fecha)='Monday' THEN 'Lunes'
                    WHEN DAYNAME(ac.fecha)='Tuesday' THEN 'Martes' 
                    WHEN DAYNAME(ac.fecha)='Wednesday' THEN 'Miércoles' 
                    WHEN DAYNAME(ac.fecha)='Thursday' THEN 'Jueves' 
                    WHEN DAYNAME(ac.fecha)='Friday' THEN 'Viernes'
                    WHEN DAYNAME(ac.fecha)='Saturday' THEN 'Sábado' 
                    WHEN DAYNAME(ac.fecha)='Sunday' THEN 'Domingo' 
                    ELSE '' END) ,' ',LPAD(DAY(ac.fecha),2,'0'),' de ', 
                    (CASE WHEN MONTH(ac.fecha)=1 THEN 'Enero' 
                    WHEN MONTH(ac.fecha)=2 THEN 'Febrero' WHEN MONTH(ac.fecha)=3 THEN 'Marzo' 
                    WHEN MONTH(ac.fecha)=4 THEN 'Abril' WHEN MONTH(ac.fecha)=5 THEN 'Mayo' 
                    WHEN MONTH(ac.fecha)=6 THEN 'Junio' WHEN MONTH(ac.fecha)=7 THEN 'Julio' 
                    WHEN MONTH(ac.fecha)=8 THEN 'Agosto' WHEN MONTH(ac.fecha)=9 THEN 'Septiembre' 
                    WHEN MONTH(ac.fecha)=10 THEN 'Octubre' WHEN MONTH(ac.fecha)=11 THEN 'Noviembre' 
                    WHEN MONTH(ac.fecha)=12 THEN 'Diciembre' ELSE '' END),' de ',YEAR(ac.fecha)) AS fecha,*/
                    DATE_FORMAT(ac.ingreso_horario,'%H:%i') AS ingreso_programado,
                    DATE_FORMAT(ac.ingreso,'%H:%i') AS ingreso_real,
                    TIMESTAMPDIFF(MINUTE, ac.ingreso, ac.ingreso_horario) AS ingreso_diferencia,
                    CONCAT(CASE WHEN (SELECT COUNT(1) FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=1)>0 THEN 
                    (SELECT GROUP_CONCAT(co.descripcion SEPARATOR ', ') 
                    FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=1) ELSE '' END,
                    CASE WHEN ac.obs_ingreso IS NOT NULL THEN CONCAT(', ',ac.obs_ingreso) 
                    ELSE '' END) AS obs_ingreso,
                    DATE_FORMAT(ac.apertura_horario,'%H:%i') AS apertura_programada,
                    DATE_FORMAT(ac.apertura,'%H:%i') AS apertura_real,
                    TIMESTAMPDIFF(MINUTE, ac.apertura, ac.apertura_horario) AS apertura_diferencia,
                    CONCAT(CASE WHEN (SELECT COUNT(1) FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=2)>0 THEN 
                    (SELECT GROUP_CONCAT(co.descripcion SEPARATOR ', ') 
                    FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=2) ELSE '' END,
                    CASE WHEN ac.obs_apertura IS NOT NULL THEN CONCAT(', ',ac.obs_apertura) 
                    ELSE '' END) AS obs_apertura,
                    DATE_FORMAT(ac.cierre_horario,'%H:%i') AS cierre_programado,
                    DATE_FORMAT(ac.cierre,'%H:%i') AS cierre_real,
                    TIMESTAMPDIFF(MINUTE, ac.cierre, ac.cierre_horario) AS cierre_diferencia,
                    CONCAT(CASE WHEN (SELECT COUNT(1) FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=3)>0 THEN 
                    (SELECT GROUP_CONCAT(co.descripcion SEPARATOR ', ') 
                    FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=3) ELSE '' END,
                    CASE WHEN ac.obs_cierre IS NOT NULL THEN CONCAT(', ',ac.obs_cierre) 
                    ELSE '' END) AS obs_cierre,
                    DATE_FORMAT(ac.salida_horario,'%H:%i') AS salida_programada,
                    DATE_FORMAT(ac.salida,'%H:%i') AS salida_real,
                    TIMESTAMPDIFF(MINUTE, ac.salida, ac.salida_horario) AS salida_diferencia,
                    CONCAT(CASE WHEN (SELECT COUNT(1) FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=4)>0 THEN 
                    (SELECT GROUP_CONCAT(co.descripcion SEPARATOR ', ') 
                    FROM observacion_apertura_cierre_tienda oa
                    INNER JOIN c_observacion_apertura_cierre_tienda co ON co.id=oa.id_observacion
                    WHERE oa.id_apertura_cierre=ac.id_apertura_cierre AND oa.tipo_apertura=4) ELSE '' END,
                    CASE WHEN ac.obs_salida IS NOT NULL THEN CONCAT(', ',ac.obs_salida) 
                    ELSE '' END) AS obs_salida,
                    CASE WHEN ac.apertura IS NULL AND ac.cierre IS NULL AND ac.salida IS NULL THEN '2'
                    WHEN ac.apertura IS NOT NULL AND ac.cierre IS NULL AND ac.salida IS NULL THEN '3'
                    WHEN ac.apertura IS NOT NULL AND ac.cierre IS NOT NULL AND ac.salida IS NULL THEN '4'
                    ELSE '0' END AS tipo_apertura,ac.fecha AS fecha_v,
                    (SELECT COUNT(1) FROM archivos_apertura_cierre_tienda aa
                    WHERE aa.id_apertura_cierre=ac.id_apertura_cierre) AS archivos
                    FROM apertura_cierre_tienda ac
                    WHERE (ac.fecha BETWEEN '".$dato['fec_ini']."' AND '".$dato['fec_fin']."') $parte AND 
                    ac.estado=1";
            $query = DB::select($sql);
            return $query;
        }
    }
}