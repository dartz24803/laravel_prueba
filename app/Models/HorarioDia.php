<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HorarioDia extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'horario_dia';

    protected $primaryKey = 'id_horario_dia';

    protected $fillable = [
        'id_horario',
        'id_turno',
        'con_descanso',
        'dia',
        'nom_dia',
        'hora_entrada',
        'hora_entrada_desde',
        'hora_entrada_hasta',
        'hora_salida',
        'hora_salida_desde',
        'hora_salida_hasta',
        'hora_descanso_e',
        'hora_descanso_e_desde',
        'hora_descanso_e_hasta',
        'hora_descanso_s',
        'hora_descanso_s_desde',
        'hora_descanso_s_hasta',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    //obtener horarios x base actual
    function get_horarios_x_base_hoy($base=null){
        $parte = "";
        if ($base!='0') {
            $parte = " AND t.base = '$base'";
        }
        $sql = "SELECT hd.id_horario, t.base, hd.dia, hd.nom_dia, hd.hora_entrada, hd.hora_descanso_e, hd.hora_descanso_s, hd.hora_salida 
                FROM horario_dia hd LEFT JOIN turno t ON hd.id_turno=t.id_turno 
                WHERE hd.dia = IF(DAYOFWEEK(CURDATE()) = 1, 7, DAYOFWEEK(CURDATE()) - 1) AND hd.id_turno>0 $parte;";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
