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
            $sql = "SELECT CASE WHEN apertura IS NULL AND cierre IS NULL AND salida IS NULL THEN '2'
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
                $parte = "AND cod_base='".$dato['cod_base']."'";
            }
            $sql = "SELECT id_apertura_cierre,cod_base,
                    CONCAT( (CASE WHEN DAYNAME(fecha)='Monday' THEN 'Lunes'
                    WHEN DAYNAME(fecha)='Tuesday' THEN 'Martes' WHEN DAYNAME(fecha)='Wednesday' THEN 'Miércoles' 
                    WHEN DAYNAME(fecha)='Thursday' THEN 'Jueves' WHEN DAYNAME(fecha)='Friday' THEN 'Viernes'
                    WHEN DAYNAME(fecha)='Saturday' THEN 'Sábado' WHEN DAYNAME(fecha)='Sunday' THEN 'Domingo' 
                    ELSE '' END) ,' ',LPAD(DAY(fecha),2,'0'),' de ', (CASE WHEN MONTH(fecha)=1 THEN 'Enero' 
                    WHEN MONTH(fecha)=2 THEN 'Febrero' WHEN MONTH(fecha)=3 THEN 'Marzo' 
                    WHEN MONTH(fecha)=4 THEN 'Abril' WHEN MONTH(fecha)=5 THEN 'Mayo' 
                    WHEN MONTH(fecha)=6 THEN 'Junio' WHEN MONTH(fecha)=7 THEN 'Julio' 
                    WHEN MONTH(fecha)=8 THEN 'Agosto' WHEN MONTH(fecha)=9 THEN 'Septiembre' 
                    WHEN MONTH(fecha)=10 THEN 'Octubre' WHEN MONTH(fecha)=11 THEN 'Noviembre' 
                    WHEN MONTH(fecha)=12 THEN 'Diciembre' ELSE '' END),' de ',YEAR(fecha)) AS fecha,ingreso,
                    apertura,cierre,salida,obs_ingreso,obs_apertura,obs_cierre,obs_salida,estado,
                    DATE_FORMAT(ingreso_horario,'%H:%i') AS ingreso_programado,
                    DATE_FORMAT(ingreso,'%H:%i') AS ingreso_real,
                    TIMESTAMPDIFF(MINUTE, ingreso_horario, ingreso) AS ingreso_diferencia,
                    DATE_FORMAT(apertura_horario,'%H:%i') AS apertura_programada,
                    DATE_FORMAT(apertura,'%H:%i') AS apertura_real,
                    TIMESTAMPDIFF(MINUTE, apertura_horario, apertura) AS apertura_diferencia,
                    DATE_FORMAT(cierre_horario,'%H:%i') AS cierre_programado,
                    DATE_FORMAT(cierre,'%H:%i') AS cierre_real,
                    TIMESTAMPDIFF(MINUTE, cierre_horario, cierre) AS cierre_diferencia,
                    DATE_FORMAT(salida_horario,'%H:%i') AS salida_programada,
                    DATE_FORMAT(salida,'%H:%i') AS salida_real,
                    TIMESTAMPDIFF(MINUTE, salida_horario, salida) AS salida_diferencia,
                    CASE WHEN apertura IS NULL AND cierre IS NULL AND salida IS NULL THEN '2'
                    WHEN apertura IS NOT NULL AND cierre IS NULL AND salida IS NULL THEN '3'
                    WHEN apertura IS NOT NULL AND cierre IS NOT NULL AND salida IS NULL THEN '4'
                    ELSE '0' END AS tipo_apertura
                    FROM apertura_cierre_tienda
                    WHERE (fecha BETWEEN '".$dato['fec_ini']."' AND '".$dato['fec_fin']."') $parte AND 
                    estado=1";
            $query = DB::select($sql);
            return $query;
        }
    }
}