<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Suceso extends Model
{
    use HasFactory;

    protected $table = 'suceso';
    protected $primaryKey = 'id_suceso';

    public $timestamps = false;

    protected $fillable = [
        'cod_suceso',
        'nom_suceso',
        'id_tipo_error',
        'id_error',
        'centro_labores',
        'monto',
        'archivo',
        'user_suceso',
        'estado_suceso',
        'usuario_aprobado',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    public static function get_list_suceso($dato)
    {
        $parte_estado = "";
        if($dato['estado_suceso']!="0"){
            $parte_estado = "AND su.estado_suceso=".$dato['estado_suceso'];
        }
        if(session('usuario')->id_nivel=="1" || 
        session('usuario')->id_puesto=="9" || 
        session('usuario')->id_puesto=="128" ||
        session('usuario')->id_puesto=="158" ||
        session('usuario')->id_puesto=="209"){
            $parte_base = "";
            if($dato['cod_base']!="0"){
                $parte_base = "AND su.centro_labores='".$dato['cod_base']."'";
            }
        }else{
            $parte_base = "AND su.centro_labores='".session('usuario')->centro_labores."'";
        }
        $sql = "SELECT su.fec_reg AS orden,su.id_suceso,DATE_FORMAT(su.fec_reg,'%d/%m/%Y %H:%i:%s') AS fecha,
                su.centro_labores,su.cod_suceso,te.nom_tipo_error,er.nom_error,su.monto,su.nom_suceso,
                (SELECT GROUP_CONCAT(CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) 
                ORDER BY us.id_usuario SEPARATOR ', ')
                FROM users us
                WHERE FIND_IN_SET(us.id_usuario, su.user_suceso)) AS user_suceso,
                su.archivo,su.estado_suceso
                FROM suceso su
                INNER JOIN tipo_error te ON su.id_tipo_error=te.id_tipo_error
                INNER JOIN error er ON su.id_error=er.id_error
                WHERE (DATE_FORMAT(su.fec_reg,'%Y-%m-%d') BETWEEN '".$dato['fecha_inicio']."' AND
                '".$dato['fecha_fin']."') $parte_base $parte_estado AND su.estado=1
                ORDER BY su.fec_reg ASC";
        $query = DB::select($sql);
        return $query;
    }
}
