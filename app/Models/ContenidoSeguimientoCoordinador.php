<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContenidoSeguimientoCoordinador extends Model
{
    use HasFactory;

    protected $table = 'contenido_seguimiento_coordinador';

    public $timestamps = false;

    protected $fillable = [
        'base',
        'id_area',
        'id_periocidad',
        'nom_dia_1',
        'nom_dia_2',
        'nom_dia_3',
        'dia_1',
        'dia_2',
        'dia',
        'mes',
        'descripcion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_c_seguimiento_coordinador($dato){
        $parte_b = "";
        $parte_a = "";
        $parte_p = "";
        if($dato['base']!="0"){
            $parte_b = "cs.base='".$dato['base']."' AND";
        }
        if($dato['id_area']!="0"){
            $parte_a = "cs.id_area=".$dato['id_area']." AND";
        }
        if($dato['id_periocidad']!="0"){
            $parte_p = "cs.id_periocidad=".$dato['id_periocidad']." AND";
        }
        $sql = "SELECT cs.id,cs.base,ar.nom_area,CASE WHEN cs.id_periocidad=1 THEN 'Diario'
                WHEN cs.id_periocidad=2 THEN 'Semanal' WHEN cs.id_periocidad=3 THEN 'Quincenal'
                WHEN cs.id_periocidad=4 THEN 'Mensual'
                WHEN cs.id_periocidad=5 THEN 'Anual' ELSE '' END AS periocidad,
                CASE WHEN cs.id_periocidad=2 THEN (CASE WHEN cs.nom_dia_1>0 AND cs.nom_dia_2>0 AND
                cs.nom_dia_3>0 THEN CONCAT(du.nombre,', ',dd.nombre,' y ',dt.nombre)
                WHEN cs.nom_dia_1>0 AND cs.nom_dia_2=0 AND cs.nom_dia_3=0 THEN du.nombre  
                WHEN cs.nom_dia_1=0 AND cs.nom_dia_2>0 AND cs.nom_dia_3=0 THEN dd.nombre
                WHEN cs.nom_dia_1=0 AND cs.nom_dia_2=0 AND cs.nom_dia_3>0 THEN dt.nombre
                WHEN cs.nom_dia_1>0 AND cs.nom_dia_2>0 AND cs.nom_dia_3=0 THEN 
                CONCAT(du.nombre,' y ',dd.nombre) 
                WHEN cs.nom_dia_1=0 AND cs.nom_dia_2>0 AND cs.nom_dia_3>0 THEN 
                CONCAT(dd.nombre,' y ',dt.nombre) 
                WHEN cs.nom_dia_1>0 AND cs.nom_dia_2=0 AND cs.nom_dia_3>0 THEN 
                CONCAT(du.nombre,' y ',dt.nombre) ELSE '' END)
                WHEN cs.id_periocidad=3 THEN (CASE WHEN cs.dia_1>0 AND cs.dia_2>0 
                THEN CONCAT(cs.dia_1,' y ',cs.dia_2) 
                WHEN cs.dia_1>0 AND cs.dia_2=0 THEN cs.dia_1
                WHEN cs.dia_1=0 AND cs.dia_2>0 THEN cs.dia_2 ELSE '' END)
                WHEN cs.id_periocidad=4 THEN (CASE WHEN cs.dia>0 THEN cs.dia ELSE '' END) 
                WHEN cs.id_periocidad = 5 THEN CONCAT(cs.dia, ' de ', LEFT(m.nom_mes, 3))
                ELSE '' END AS dia, cs.descripcion
                FROM contenido_seguimiento_coordinador cs
                LEFT JOIN area ar ON cs.id_area=ar.id_area
                LEFT JOIN dia_semana du ON cs.nom_dia_1=du.id
                LEFT JOIN dia_semana dd ON cs.nom_dia_2=dd.id
                LEFT JOIN dia_semana dt ON cs.nom_dia_3=dt.id
                LEFT JOIN mes m ON cs.mes=m.id_mes
                WHERE $parte_p $parte_a $parte_b cs.estado=1";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_contenido_seguimiento_coordinador($dato){
        $centro_labores = session('usuario')->centro_labores;
        $sql = "SELECT id,descripcion,CASE WHEN id_periocidad=1 THEN 'Diario'
                WHEN id_periocidad=2 THEN 'Semanal' WHEN id_periocidad=3 THEN 'Quincenal'
                WHEN id_periocidad=4 THEN 'Mensual' WHEN id_periocidad=5 THEN 'Anual' ELSE '' END periocidad
                FROM contenido_seguimiento_coordinador
                WHERE base='$centro_labores' AND (id_periocidad=1 || 
                (id_periocidad=2 AND (((DAYOFWEEK('".$dato['fecha']."') + 5) % 7 + 1)=nom_dia_1 OR 
                ((DAYOFWEEK('".$dato['fecha']."') + 5) % 7 + 1)=nom_dia_2) OR 
                ((DAYOFWEEK('".$dato['fecha']."') + 5) % 7 + 1)=nom_dia_3) ||
                (id_periocidad=3 AND (dia_1=DAY('".$dato['fecha']."') OR dia_2=DAY('".$dato['fecha']."'))) || 
                (id_periocidad=4 AND dia=DAY('".$dato['fecha']."')) ||
                (id_periocidad=5 AND dia=DAY('".$dato['fecha']."') AND mes=MONTH('".$dato['fecha']."'))) AND 
                estado=1";
        $query = DB::select($sql);
        return $query;
    } 
}
