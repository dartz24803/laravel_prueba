<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LecturaServicio extends Model
{
    use HasFactory;

    protected $table = 'lectura_servicio';

    public $timestamps = false;

    protected $fillable = [
        'cod_base',
        'fecha',
        'hora_ing',
        'lect_ing',
        'img_ing',
        'hora_sal',
        'lect_sal',
        'img_sal',
        'lect_ant',
        'id_servicio',
        'id_datos_servicio',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_lectura_servicio($dato)
    {
        $parte_servicio = "";
        if($dato['id_servicio']!="0"){
            $parte_servicio = "ls.id_servicio=".$dato['id_servicio']." AND";
        }
        $parte_anio = "";
        if($dato['anio']!="0"){
            $parte_anio = "YEAR(ls.fecha)='".$dato['anio']."' AND";
        }
        $parte_mes = "";
        if($dato['mes']!="0"){
            $parte_mes = "MONTH(ls.fecha)='".$dato['mes']."' AND";
        }
        $sql = "SELECT ls.id,DATE_FORMAT(ls.fecha,'%d/%m/%Y') AS fecha,se.nom_servicio,
                ds.suministro,DATE_FORMAT(ls.hora_ing,'%H:%i') AS hora_ing,ls.lect_ing,ls.img_ing,
                DATE_FORMAT(ls.hora_sal,'%H:%i') AS hora_sal,ls.lect_sal,ls.img_sal
                FROM lectura_servicio ls
                INNER JOIN servicio se ON ls.id_servicio=se.id_servicio
                INNER JOIN datos_servicio ds ON ls.id_datos_servicio=ds.id_datos_servicio
                WHERE $parte_servicio $parte_anio $parte_mes ls.estado=1";
        $query = DB::select($sql);
        return $query;
    }
}
