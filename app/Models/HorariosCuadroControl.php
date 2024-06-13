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

    protected $primaryKey = 'id_horarios_cuadro_control';

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

    public function contador_x_puesto_y_base($cod_base, $puesto, $dia){
        $sql = "SELECT COUNT(DISTINCT puesto) AS contador FROM horarios_cuadro_control
                WHERE cod_base='".$cod_base."' AND puesto LIKE '".$puesto.'%'."' and estado = 1 and dia = $dia
                GROUP BY cod_base;";
        $result = DB::select($sql);
        //print_r($result[0]);
        if (!empty($result)) {
            // Accede al primer elemento del array y luego al campo 'contador'
            return $result[0]->contador + 1;
        } else {
            return 0;
        }
    }
    
    public function get_list_c_cuadro_control_visual($base){
        $sql = "SELECT pu.nom_puesto,u.centro_labores,u.id_puesto,u.id_usuario,
                CONCAT(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) AS colaborador,
                (SELECT hc.id_horarios_cuadro_control FROM cuadro_control_visual_horario ch 
                LEFT JOIN horarios_cuadro_control hc ON ch.horario = hc.id_horarios_cuadro_control 
                WHERE u.id_usuario = ch.id_usuario AND hc.dia = ((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY ch.fec_reg 
                DESC LIMIT 1) AS id_horario
                FROM users u
                LEFT JOIN puesto pu ON u.id_puesto=pu.id_puesto
                WHERE u.centro_labores = '$base' AND u.estado = 1 AND NOT u.usuario_nombres LIKE 'Base%'";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    public function get_list_programacion_diaria($base){
        $parte = "";
        if($base!="0"){
            $parte = "WHERE hc.cod_base='$base'";
        }
        $sql = "SELECT LEFT(hc.puesto,LENGTH(hc.puesto)-1) AS puesto,ds.nombre AS nom_dia,us.centro_labores,
                CASE WHEN hc.t_refrigerio_h=1 
                THEN CONCAT(hc.hora_entrada,' ',hc.hora_salida,' - ',hc.ini_refri,' ',hc.fin_refri) 
                WHEN hc.t_refrigerio_h=2 THEN CONCAT(hc.hora_entrada,' ',hc.hora_salida) 
                WHEN hc.t_refrigerio_h=3 THEN CONCAT(hc.hora_entrada,' ',hc.hora_salida,' - ',hc.ini_refri,' ',
                hc.fin_refri,' - ',hc.ini_refri2,' ',hc.fin_refri2) END AS horario,
                CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) AS colaborador
                FROM cuadro_control_visual_horario ch
                JOIN (SELECT MAX(id_cuadro_control_visual_horario) AS id
                FROM cuadro_control_visual_horario 
                GROUP BY id_usuario,dia) uh ON ch.id_cuadro_control_visual_horario=uh.id
                LEFT JOIN horarios_cuadro_control hc ON ch.horario=hc.id_horarios_cuadro_control
                LEFT JOIN dia_semana ds ON hc.dia=ds.id
                LEFT JOIN users us ON ch.id_usuario=us.id_usuario
                $parte";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
    
    function get_list_horario_programacion_diaria($base,$id_puesto,$dia){
        $sql = "SELECT id_horarios_cuadro_control,CASE WHEN t_refrigerio_h=1 
                THEN CONCAT(hora_entrada,' ',hora_salida,' - ',ini_refri,' ',fin_refri) 
                WHEN t_refrigerio_h=2 THEN CONCAT(hora_entrada,' ',hora_salida) 
                WHEN t_refrigerio_h=3 THEN CONCAT(hora_entrada,' ',hora_salida,' - ',ini_refri,' ',
                fin_refri,' - ',ini_refri2,' ',fin_refri2) END AS horario 
                FROM horarios_cuadro_control 
                WHERE cod_base='$base' AND id_puesto=$id_puesto AND dia='$dia' AND estado=1";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
