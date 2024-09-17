<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Turno extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'turno';

    protected $primaryKey = 'id_turno';

    protected $fillable = [
        'base',
        'entrada',
        'salida',
        't_refrigerio',
        'ini_refri',
        'fin_refri',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_turno_xbase($cod_base){
        $sql = "SELECT a.id_turno,a.base,date_format(a.entrada,'%H:%i') as entrada,
            date_format(a.salida,'%H:%i') as salida,a.t_refrigerio,
            case when a.t_refrigerio=1 then date_format(a.ini_refri,'%H:%i') end as ini_refri,
            case when a.t_refrigerio=1 then date_format(a.fin_refri, '%H:%i') end as fin_refri,
            case when a.t_refrigerio=2 then 'Sin Refrigerio' when a.t_refrigerio=1 then 'Refrigerio Fijo' end as desc_t_refrigerio,
            a.estado_registro,
            case when a.t_refrigerio=1 then 
                (case when a.ini_refri<>'00:00:00' and a.fin_refri<>'00:00:00' then
                    concat(date_format(a.entrada,'%H:%i'),' - ',date_format(a.salida,'%H:%i'),' (',date_format(a.ini_refri,'%H:%i'),' - ',date_format(a.fin_refri, '%H:%i'),')')
                    else concat(date_format(a.entrada,'%H:%i'),' - ',date_format(a.salida,'%H:%i')) end)
                else concat(date_format(a.entrada,'%H:%i'),' - ',date_format(a.salida,'%H:%i')) end as option_select
            FROM turno a 
            WHERE a.base='".$cod_base."' and a.estado_registro=1 and a.estado=1";
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    public static function get_turno_para_horario($id_turno){
            $sql = "SELECT a.id_turno,a.base,date_format(a.entrada,'%H:%i') as entrada,
            date_format(a.salida,'%H:%i') as salida,a.t_refrigerio,
            case when a.t_refrigerio=1 then date_format(a.ini_refri,'%H:%i') end as ini_refri,
            case when a.t_refrigerio=1 then date_format(a.fin_refri, '%H:%i') end as fin_refri,
            case when a.t_refrigerio=2 then 'Sin Refrigerio' when a.t_refrigerio=1 then 'Refrigerio Fijo' end as desc_t_refrigerio,
            a.estado_registro
            FROM turno a WHERE a.id_turno=$id_turno";
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
