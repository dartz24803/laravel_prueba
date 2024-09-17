<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Horario extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'horario';

    protected $primaryKey = 'id_horario';

    protected $fillable = [
        'cod_horario',
        'cod_base',
        'nombre',
        'feriado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_horario_modulo($cod_base){
        if($cod_base=="0"){
            $parte = "";
        }else{
            $parte = "h.cod_base='$cod_base' AND";
        }
        $sql = "SELECT h.id_horario,h.cod_base,h.nombre,
                (SELECT group_concat(distinct d.nom_dia ORDER by d.dia ASC) 
                FROM horario_dia d 
                WHERE d.id_horario=h.id_horario and d.estado=1) AS dias,
                CASE WHEN h.feriado=1 THEN 'Si' ELSE 'No' END AS feriado
                FROM horario h
                WHERE $parte h.estado=1";
                
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
