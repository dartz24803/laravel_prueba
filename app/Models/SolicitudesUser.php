<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SolicitudesUser extends Model
{
    protected $table = 'solicitudes_user';
    protected $primaryKey = 'id_solicitudes_user';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_solicitudes',
        'cod_solicitud',
        'cod_base',
        'id_gerencia',
        'anio',
        'fec_desde',
        'fec_hasta',
        'dif_dias',
        'fec_solicitud',
        'hora_salida',
        'hora_retorno',
        'horar_salida',
        'horar_retorno',
        'user_horar_salida',
        'user_horar_entrada',
        'id_motivo',
        'destino',
        'tramite',
        'especificacion_destino',
        'especificacion_tramite',
        'motivo',
        'estado_solicitud',
        'user_aprob',
        'fec_apro',
        'sin_ingreso',
        'sin_retorno',
        'mediodia',
        'observacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    function get_list_papeletas_salida($estado_solicitud=null){
        $id_usuario= session('usuario')->id_usuario;
        if($estado_solicitud > 0){
            if($estado_solicitud==1){
                $buscar="and su.estado_solicitud IN (1,4,5)";
            }else{
                $buscar="and su.estado_solicitud=$estado_solicitud";
            }
        }else{
            $buscar="";
        }

        $sql = "SELECT su.*,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.usuario_email,u.centro_labores,
                a.nom_area,u.foto,u.num_doc,
                CASE WHEN su.id_motivo IN (1,2) AND su.id_solicitudes_user>7 THEN de.nom_destino ELSE su.destino END AS destino,
                CASE WHEN su.id_motivo IN (1,2) AND su.id_solicitudes_user>7 THEN tr.nom_tramite ELSE su.tramite END AS tramite
                FROM solicitudes_user su
                left join users u on su.user_reg=u.id_usuario
                left join area a on u.id_area=a.id_area
                left join gerencia g on u.id_gerencia=g.id_gerencia
                LEFT JOIN destino de ON de.id_destino=su.destino
                LEFT JOIN tramite tr ON tr.id_tramite=su.tramite
                where su.estado in (1) and id_solicitudes=2 AND su.id_usuario ='$id_usuario' $buscar
                order by su.fec_reg DESC";
        
            $result = DB::select($sql);

            // Convertir el resultado a un array
            return json_decode(json_encode($result), true);
    }
    
    function get_list_papeletas_salida_uno(){
        $id_usuario= session('usuario')->id_usuario;

        $sql = "SELECT su.*,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.usuario_email,a.nom_area,u.foto,
                u.num_doc  FROM solicitudes_user su
                left join users u on su.user_reg=u.id_usuario
                left join area a on u.id_area=a.id_area
                left join gerencia g on u.id_gerencia=g.id_gerencia
                where su.estado in (1) AND  su.estado_solicitud in (1) and id_solicitudes=2
                AND su.id_usuario='$id_usuario'
                order by su.fec_reg DESC Limit 1";
        
            $result = DB::select($sql);

            // Convertir el resultado a un array
            return json_decode(json_encode($result), true);
    }
}
