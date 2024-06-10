<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HorariosCuadroControl extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'horarios_cuadro_control';

    protected $fillable = [
        'cod_base',
        'id_puesto',
        'puesto',
        'dia',
        't_refrigerio_h',
        'hora_entrada',
        'hora_salida',
        'ini_refri',
        'fin_refri',
        'ini_refri2',
        'fin_refri2',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function listar($base=null){
        if($base != 0){
            $parte = "hc.cod_base = '$base' AND ";
        }else{
            $parte ="";
        }
        $sql = "SELECT hc.*,ds.nombre AS nom_dia,
            CASE WHEN t_refrigerio_h=1 THEN CONCAT(hora_entrada,' ',hora_salida,' - ',ini_refri,' ',
            fin_refri)
            WHEN t_refrigerio_h=2 THEN CONCAT(hora_entrada,' ',hora_salida)
            WHEN t_refrigerio_h=3 THEN CONCAT(hora_entrada,' ',hora_salida,' - ',ini_refri,' ',
            fin_refri,' - ',ini_refri2,' ',fin_refri2) END AS horario
            FROM horarios_cuadro_control hc
            LEFT JOIN dia_semana ds ON hc.dia=ds.id
            WHERE $parte hc.estado=1";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
