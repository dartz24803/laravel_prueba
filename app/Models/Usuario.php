<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    protected $fillable = [
        'usuario_apater',
        'usuario_amater',
        'usuario_nombres',
        'usuario_codigo',
        'usuario_password',
        'id_nivel',
        'id_puesto',
        'centro_labores',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function login($usuario){
        $query = "SELECT u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo,
        u.id_nivel, u.usuario_email, u.centro_labores, u.emailp, u.num_celp, u.induccion, u.datos_completos,
        u.desvinculacion, u.ini_funciones,u.fec_reg,s.nom_situacion_laboral,
        u.usuario_password,u.estado, n.nom_nivel, p.nom_puesto,SUBSTRING(nom_puesto,1,14) AS parte_nom_puesto, a.nom_area, u.id_area,
        DATE_FORMAT(u.fec_nac, '%M %d,%Y') as fec_nac, u.usuario_codigo,u.id_gerencia,
        u.urladm,u.foto,u.foto_nombre, u.acceso, u.id_cargo, pe.id_puesto_evaluador, u.directorio,
        pps.estado as estadopps, pps.registro_masivo, pps.id_puesto_permitido,
        (SELECT GROUP_CONCAT(puestos) FROM area
        WHERE estado=1 AND orden!='') AS grupo_puestos,
        (SELECT COUNT(*) FROM asignacion_jefatura aj
        WHERE aj.id_puesto_jefe=u.id_puesto and aj.estado=1) as puestos_asignados,
        CASE WHEN (SELECT count(*) FROM area ar
        WHERE CONCAT(',', ar.puestos, ',') like CONCAT('%',u.id_puesto, '%'))>0 THEN 'SI' ELSE 'NO' END AS encargado_p,
        CASE WHEN (SELECT count(*) FROM invitado_calendario i
        WHERE i.id_usuario=u.id_usuario and i.estado=1)>0 THEN 'SI' ELSE 'NO' END AS calendario_l,
        (SELECT h.fec_inicio FROM historico_colaborador h
        WHERE h.id_historico_colaborador=(SELECT MAX(h2.id_historico_colaborador) FROM historico_colaborador h2 WHERE h2.id_usuario=u.id_usuario and h2.estado=1) and h.estado=1) as fec_inicio,
        CASE WHEN (SELECT COUNT(1) FROM entrenamiento en
        LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
        WHERE sp.id_usuario=u.id_usuario AND en.estado_e=1 AND en.estado=1)>0 THEN
        (SELECT sp.id_puesto_aspirado FROM entrenamiento en
        LEFT JOIN solicitud_puesto sp ON en.id_solicitud_puesto=sp.id
        WHERE sp.id_usuario=u.id_usuario AND en.estado_e=1 AND en.estado=1
        ORDER BY en.id DESC
        LIMIT 1) ELSE (CASE WHEN u.fec_asignacionjr=CURDATE() THEN u.id_puestojr
        ELSE u.id_puesto END) END AS id_puesto,
        CASE WHEN u.urladm=1 THEN (select r.url_config from config r
        where r.descrip_config='Foto_Postulante' and r.estado=1) else
        (select r.url_config from config r
        where r.descrip_config='Foto_colaborador' and r.estado=1) end as url_foto,p.id_nivel as nivel_jerarquico,
        case when (select count(*) from asignacion_visita av
        where av.id_puesto_inspector=u.id_puesto and av.estado=1)>0 then 1 else 0 end as reg_visita_produccion,
        visualizar_amonestacion(u.id_puesto) AS visualizar_amonestacion,
        visualizar_mi_equipo(u.id_puesto) AS visualizar_mi_equipo,
        visualizar_responsable_area(u.id_puesto) AS visualizar_responsable_area,
        visualizar_asistencia_manual(u.id_usuario) AS visualizar_asistencia_manual,
        sl.descripcion AS sede_laboral
        FROM users u
        LEFT JOIN nivel n ON u.id_nivel=n.id_nivel
        LEFT JOIN puesto p ON u.id_puesto=p.id_puesto
        LEFT JOIN puesto_evaluador pe ON u.id_puesto=pe.id_puesto
        LEFT JOIN area a ON u.id_area=a.id_area
        LEFT JOIN situacion_laboral s ON u.id_situacion_laboral=s.id_situacion_laboral
        LEFT JOIN permiso_papeletas_salida pps ON u.id_puesto=pps.id_puesto_jefe AND pps.estado=1
        LEFT JOIN sede_laboral sl ON p.id_sede_laboral=sl.id
        WHERE u.usuario_codigo='$usuario' AND u.estado IN (1,4) AND u.desvinculacion IN (0)";
        $result = DB::select($query);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    public static function get_list_usuario_ft($dato=null){
        $parte = "";
        if(isset($dato['base'])){
            $parte = "centro_labores='".$dato['base']."' AND";
        }
        $sql = "SELECT id_usuario,CASE WHEN (usuario_apater='' OR usuario_apater IS NULL) AND
                (usuario_amater='' OR usuario_amater IS NULL) THEN usuario_nombres ELSE
                CONCAT(usuario_nombres,' ',usuario_apater,' ',usuario_amater) END AS nom_usuario
                FROM users
                WHERE $parte estado=1
                ORDER BY usuario_nombres ASC";
        $query = DB::select($sql);
        return $query;
    }

    function get_list_colaborador_programacion_diaria($base,$id_puesto){
        $sql = "SELECT id_usuario,CONCAT(usuario_nombres,' ',usuario_apater,' ',usuario_amater) AS colaborador
                FROM users
                WHERE centro_labores='$base' AND id_puesto=$id_puesto AND estado=1
                ORDER BY usuario_apater,usuario_amater,usuario_nombres";
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }


    //obtener horarios x base actual
    function get_horarios_x_base_hoy($base=null){
        $parte = "";
        if ($base!='0') {
            $parte = " AND t.base = '$base'";
        }
        $sql = "SELECT hd.id_horario, t.base, hd.dia, hd.nom_dia, hd.hora_entrada, hd.hora_descanso_e, hd.hora_descanso_s, hd.hora_salida
                FROM horario_dia hd LEFT JOIN turno t ON hd.id_turno=t.id_turno
                WHERE hd.dia = IF(DAYOFWEEK(CURDATE()) = 1, 7, DAYOFWEEK(CURDATE()) - 1) AND hd.id_turno>0 $parte;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //lista con hora de entrada y salida
    function get_list_cuadro_control_visual($base){
        $sql = "SELECT u.id_usuario,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.centro_labores,
                u.num_celp,u.usuario_codigo,u.foto,p.nom_puesto,
                (SELECT CASE WHEN hcc.t_refrigerio_h=1
                THEN CONCAT(hcc.hora_entrada,' ',hcc.hora_salida,' - ',hcc.ini_refri,' ',hcc.fin_refri)
                WHEN hcc.t_refrigerio_h=2 THEN CONCAT(hcc.hora_entrada,' ',hcc.hora_salida)
                WHEN hcc.t_refrigerio_h=3 THEN CONCAT(hcc.hora_entrada,' ',hcc.hora_salida,' - ',
                hcc.ini_refri,' ',hcc.fin_refri,' - ',hcc.ini_refri2,' ',hcc.fin_refri2) END
                FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS horario,
                (SELECT hcc.hora_entrada FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS hora_entrada,
                (SELECT hcc.hora_salida FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS hora_salida,
                (SELECT hcc.ini_refri FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS ini_refri,
                (SELECT hcc.fin_refri FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS fin_refri,
                (SELECT hcc.ini_refri2 FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS ini_refri2,
                (SELECT hcc.fin_refri2 FROM cuadro_control_visual_horario ccvh
                LEFT JOIN horarios_cuadro_control hcc ON ccvh.horario=hcc.id_horarios_cuadro_control
                WHERE ccvh.id_usuario=u.id_usuario AND ccvh.dia=((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)
                ORDER BY id_cuadro_control_visual_horario DESC
                LIMIT 1) AS fin_refri2,
                (SELECT ccve.estado FROM cuadro_control_visual_estado ccve
                WHERE ccve.id_usuario = u.id_usuario AND DATE(fec_reg) = CURDATE()
                ORDER BY fec_reg DESC
                LIMIT 1) AS estado
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                WHERE u.centro_labores = '$base' AND u.estado = 1 AND NOT u.usuario_nombres LIKE 'Base%';";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function contador_presentes_ccv($base=null){
        $sql = "SELECT COUNT(*) AS contador_presentes_ccv
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN cuadro_control_visual_estado ccve ON ccve.id_usuario = u.id_usuario AND DATE(ccve.fec_reg) = CURDATE()
                WHERE
                    u.centro_labores = '$base'
                    AND u.estado = 1
                    AND NOT u.usuario_nombres LIKE 'Base%'
                    AND ccve.estado = 1
                    AND p.nom_puesto = 'VENDEDOR'";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function contador_total_x_bases($base=null){
        $sql = "SELECT COUNT(*) AS contador_total_x_bases FROM users u LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                WHERE u.centro_labores = '$base'
                AND u.estado = 1
                AND NOT u.usuario_nombres LIKE 'Base%'";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_usuarios_x_baset($cod_base=null,$area=null,$estado){
        $base="";
        if($cod_base!="0"){
            $base = "AND u.centro_labores='$cod_base'";
        }
        $carea="";
        if(isset($area) && $area > 0){
            $carea = "AND u.id_area='$area' ";
        }

        $id_estado="";
        if($estado==1){
            $id_estado = "AND u.estado=1";
        }else{
            $id_estado = "AND u.estado in (2,3)";
        }
        $sql = "SELECT u.*,(SELECT fec_inicio h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_inicio,
                (SELECT h.fec_fin h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_fin
                FROM users u
                WHERE u.id_nivel<>8 $base $carea $id_estado";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }
}
