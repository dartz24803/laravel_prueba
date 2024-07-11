<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Slide extends Model
{
    use HasFactory;

    protected $table = 'slide';

    public $timestamps = false;

    protected $primaryKey = 'id_slide';

    protected $fillable = [
        'id_area',
        'tipo',
        'base',
        'orden',
        'titulo',
        'descripcion',
        'entrada_slide',
        'salida_slide',
        'duracion',
        'tipo_slide',
        'archivoslide',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    //COMUNICADOS
    public static function get_list_slider_rrhh($dato){
        if(isset($dato['id_slide'])){
            $sql = "SELECT * FROM slide 
                    WHERE id_slide=".$dato['id_slide'];
        }else{
            $btipo = "";
            if($dato['tipo']==2){
                $btipo = " IN ('2')";
            }else{
                $btipo = "= '".$dato['tipo']."'";
            }
            $sql = "SELECT sl.id_slide,sl.orden,CASE WHEN sl.tipo_slide=1 THEN 'Imagen' 
                    WHEN sl.tipo_slide=2 THEN 'Video' ELSE '' END AS tipo_slide,sl.duracion,sl.titulo,
                    sl.descripcion,DATE_FORMAT(sl.fec_reg,'%d-%m-%Y') AS creado,sl.archivoslide
                    FROM slide sl
                    WHERE sl.estado=1 AND sl.id_area='11' AND sl.base$btipo";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
