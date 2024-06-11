<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FuncionTemporal extends Model
{
    use HasFactory;

    protected $table = 'funcion_temporal';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'base',
        'id_tipo',
        'select_tarea',
        'tarea',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_funcion_temporal($dato=null){
        if(isset($dato['id'])){
            $sql = "SELECT * FROM funcion_temporal ft 
                    LEFT JOIN tareas_funcion_temporal tft ON ft.select_tarea=tft.id
                    WHERE id_funcion=".$dato['id'];
            $query = DB::select($sql);
            return $query[0];
        }else{
            //if($dato['id_asignado']=='0'){
                $parte = "";
            /*}else{
                $parte = "ft.id_usuario=".$dato['id_asignado']." AND";
            }*/

            $sql = "SELECT ft.id,ft.fec_reg AS orden,ft.base,
                    LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater)) AS 
                    nom_usuario, /*c.nom_cargo*/ '' AS puesto_asignado, 
                    CASE WHEN ft.id_tipo=1 THEN 'Función' WHEN ft.id_tipo=2 THEN 'Tarea' 
                    ELSE '' END AS nom_tipo,
                    CASE WHEN ft.id_tipo = 2 AND ft.select_tarea = 19 THEN LOWER(ft.tarea)
                    WHEN ft.id_tipo = 2 AND ft.select_tarea != 19 THEN LOWER(tft.descripcion)
                    WHEN ft.id_tipo = 2 AND ft.select_tarea IS NULL THEN LOWER(ft.tarea)
                    WHEN ft.id_tipo=1 THEN LOWER(pu.nom_puesto) ELSE '' END AS actividad,
                    CASE WHEN DATE(ft.fecha)=CURDATE() 
                    THEN 'Hoy' WHEN TIMESTAMPDIFF(DAY, DATE(ft.fecha), CURDATE())=1 THEN 'Ayer'
                    ELSE DATE_FORMAT(ft.fecha, '%d/%m') END AS fecha_tabla,
                    CASE WHEN DATE_FORMAT(ft.hora_inicio,'%H:%i')='00:00' AND 
                    DATE_FORMAT(ft.hora_fin,'%H:%i')='23:59' THEN 'Todo el día'
                    WHEN ft.hora_fin IS NULL OR ft.hora_fin='00:00:00' 
                    THEN CONCAT(DATE_FORMAT(ft.hora_inicio,'%H:%i'),' - Por definir')
                    ELSE CONCAT(DATE_FORMAT(ft.hora_inicio,'%H:%i'),' - ',
                    DATE_FORMAT(ft.hora_fin,'%H:%i')) END AS horario,ft.fecha,
                    CASE WHEN ft.hora_fin IS NULL OR ft.hora_fin='00:00:00' THEN '#FF000036' 
                    ELSE 'transparent' END AS color_fondo
                    FROM funcion_temporal ft
                    LEFT JOIN users us ON ft.id_usuario=us.id_usuario
                    LEFT JOIN puesto pu ON ft.tarea=pu.id_puesto
                    LEFT JOIN tareas_funcion_temporal tft ON ft.select_tarea=tft.id
                    LEFT JOIN users u ON ft.id_usuario=u.id_usuario
                    /*LEFT JOIN cargo c ON u.id_cargo=c.id_cargo*/
                    WHERE $parte ft.estado=1
                    ORDER BY ft.fec_reg DESC";
            $query = DB::select($sql);
            return $query;
        }
    }
}
