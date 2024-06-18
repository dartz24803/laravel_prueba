<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asistencia extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function buscar_reporte_control_asistencia($cod_mes,$cod_anio,$cod_base,$num_doc,$tipo,$finicio,$ffin){
        if($tipo==1){
            $fecha=" AND DATE_FORMAT(ar.punch_time,'%m') = '".$cod_mes."' AND DATE_FORMAT(ar.punch_time,'%Y') = '".$cod_anio."'";
        }else{
            $fecha=" AND DATE_FORMAT(ar.punch_time,'%Y-%m-%d') BETWEEN '".$finicio."' and '".$ffin."'";
        }

        $base_iclock="";
        $base_ar="";


        $doc_iclock="";
        $doc_ar="";
        if($num_doc!=0){
            if (strlen($num_doc>8)){$num_doc=substr($num_doc, 0,-1);}else{$num_doc=$num_doc;}
            $doc_iclock=" and LPAD(ar.emp_code,8,'0') like '%".$num_doc."%'";
            $doc_ar=" and u.num_doc = '.$num_doc.' ";
        }else{
            if($cod_base!="" && $cod_base!="0"){
                //$base_iclock=" and ar.terminal_alias = '".$cod_base."' ";
                $base_ar="WHERE u.centro_labores = '".$cod_base."' ";
            }
        }

        $vista = "SELECT
                        todo.usuario_nombres AS usuario_nombres,
                        todo.usuario_apater AS usuario_apater,
                        todo.usuario_amater AS usuario_amater,
                        todo.usuario_email AS usuario_email,
                        todo.nom_area AS nom_area,
                        todo.foto AS foto,
                        todo.num_doc AS num_doc,
                        todo.id_gerencia AS id_gerencia,
                        todo.id_area AS id_area,
                        todo.nom_gerencia AS nom_gerencia,
                        todo.punch_time AS punch_time,
                        todo.estado_marcacion AS estado_marcacion,
                        todo.codigo_usuario AS codigo_usuario,
                        todo.base AS base,
                        todo.tipo AS tipo,
                        todo.lugar AS lugar,
                        todo.marcacion AS marcacion,
                        todo.id_asistencia_remota AS id_asistencia_remota,
                        todo.tipo_asistencia AS tipo_asistencia
                    FROM
                        (
                            (
                                SELECT
                                    u.usuario_nombres AS usuario_nombres,
                                    u.usuario_apater AS usuario_apater,
                                    u.usuario_amater AS usuario_amater,
                                    u.usuario_email AS usuario_email,
                                    a.nom_area AS nom_area,
                                    u.foto AS foto,
                                    u.num_doc AS num_doc,
                                    u.id_gerencia AS id_gerencia,
                                    u.id_area AS id_area,
                                    g.nom_gerencia AS nom_gerencia,
                                    ar.punch_time AS punch_time,
                                    ar.marcacion AS estado_marcacion,
                                    u.num_doc AS codigo_usuario,
                                    u.centro_labores AS base,
                                    1 AS tipo,
                                    ar.lugar AS lugar,
                                    ar.marcacion AS marcacion,
                                    ar.id_asistencia_remota AS id_asistencia_remota,
                                    CASE WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_entrada_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_entrada_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Ingreso' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(hd.hora_salida_desde, '%H:%i:%s') AND DATE_FORMAT(hd.hora_salida_hasta, '%H:%i:%s') THEN 'Salida' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_descanso_e_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_descanso_e_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Inicio Descanso' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_descanso_s_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_descanso_s_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Fin Descanso'
                                    END AS tipo_asistencia
                                FROM lanumerouno.asistencia_remota ar
                                LEFT JOIN lanumerouno.users u ON (ar.user_reg = u.id_usuario)
                                LEFT JOIN lanumerouno.area a ON (u.id_area = a.id_area)
                                LEFT JOIN lanumerouno.gerencia g ON (u.id_gerencia = g.id_gerencia)
                                LEFT JOIN zkbiotime.iclock_transaction b ON (LPAD(CONVERT(b.emp_code USING utf8), 8,'0') = u.usuario_codigo  )
                                LEFT JOIN lanumerouno.horario_dia hd ON ( u.id_horario = hd.id_horario AND hd.dia = CASE DAYNAME(  DATE_FORMAT(ar.punch_time, '%Y-%m-%d')) WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END )
                                $base_ar $doc_ar $fecha
                            )
                            UNION
                            (
                                SELECT
                                    u.usuario_nombres AS usuario_nombres,
                                    u.usuario_apater AS usuario_apater,
                                    u.usuario_amater AS usuario_amater,
                                    u.usuario_email AS usuario_email,
                                    a.nom_area AS nom_area,
                                    u.foto AS foto,
                                    u.num_doc AS num_doc,
                                    u.id_gerencia AS id_gerencia,
                                    u.id_area AS id_area,
                                    g.nom_gerencia AS nom_gerencia,
                                    ar.punch_time AS punch_time,
                                    ar.punch_state AS estado_marcacion,
                                    ar.emp_code AS codigo_usuario,
                                    ar.terminal_alias AS base,
                                    2 AS tipo,
                                    'Marcador' AS lugar,
                                    'Marcador' AS marcacion,
                                    ar.id AS id,
                                    CASE WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_entrada_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_entrada_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Ingreso' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(hd.hora_salida_desde, '%H:%i:%s') AND DATE_FORMAT(hd.hora_salida_hasta, '%H:%i:%s') THEN 'Salida' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_descanso_e_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_descanso_e_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Inicio Descanso' WHEN DATE_FORMAT(ar.punch_time, '%H:%i:%s') BETWEEN DATE_FORMAT(
                                        hd.hora_descanso_s_desde,
                                        '%H:%i:%s'
                                    ) AND DATE_FORMAT(
                                        hd.hora_descanso_s_hasta,
                                        '%H:%i:%s'
                                    ) THEN 'Fin Descanso'
                                END AS tipo_asistencia
                                FROM
                                    (
                                        (
                                            (
                                                (zkbiotime.iclock_transaction ar
                                                LEFT JOIN lanumerouno.users u ON (u.usuario_codigo LIKE CONCAT('%', LPAD(CONVERT(emp_code USING utf8), 8,'0'),'%'))
                                                )
                                                LEFT JOIN lanumerouno.area a ON (u.id_area = a.id_area)
                                            )
                                            LEFT JOIN lanumerouno.gerencia g ON (u.id_gerencia = g.id_gerencia)
                                        )
                                        LEFT JOIN lanumerouno.horario_dia hd ON
                                        ( u.id_horario = hd.id_horario AND hd.dia = CASE DAYNAME( DATE_FORMAT(ar.punch_time, '%Y-%m-%d') ) WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 WHEN 'Sunday' THEN 7 END)
                                    ) $base_iclock $doc_iclock $fecha
                            ) LIMIT 31
                        ) todo
        ";
        $sql=" SELECT
            a.num_doc,CONCAT(a.usuario_nombres,' ',a.usuario_apater,' ',a.usuario_amater) as nombres, CONCAT(a.num_doc,'-',DATE_FORMAT(a.punch_time,'%d-%m-%Y')) as validador, DATE_FORMAT(a.punch_time,'%d/%m/%Y') as fecha,DATE_FORMAT(a.punch_time,'%d-%m-%Y') as fecha2,

            (SELECT CONCAT(DATE_FORMAT(t.punch_time,'%H:%i:%s'),'--',t.id_asistencia_remota) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d') ORDER BY t.punch_time ASC LIMIT 1) as ingreso,
            (SELECT CONCAT(DATE_FORMAT(t.punch_time,'%H:%i:%s'),'--',t.id_asistencia_remota) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d') ORDER BY t.punch_time ASC LIMIT 1, 1) as idescanso,
            (SELECT CONCAT(DATE_FORMAT(t.punch_time,'%H:%i:%s'),'--',t.id_asistencia_remota) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d') ORDER BY t.punch_time ASC LIMIT 2, 1) as fdescanso,

            CASE WHEN (SELECT COUNT(*) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d'))>3 THEN (SELECT CONCAT(DATE_FORMAT(t.punch_time,'%H:%i:%s'),'--',t.id_asistencia_remota) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d') ORDER BY t.punch_time DESC LIMIT 1) ELSE '' END AS salida,
            CASE WHEN (SELECT COUNT(*) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d'))>1 THEN (SELECT CONCAT(DATE_FORMAT(t.punch_time,'%H:%i:%s'),'--',t.id_asistencia_remota) FROM ($vista) t WHERE a.num_doc = t.num_doc and DATE_FORMAT(t.punch_time,'%Y-%m-%d')=DATE_FORMAT(a.punch_time,'%Y-%m-%d') ORDER BY t.punch_time DESC LIMIT 1) ELSE '' END AS salidasabado

            FROM ($vista) AS a
            group by a.num_doc,nombres,validador,fecha,fecha2,ingreso,idescanso,fdescanso,salida,salidasabado order by fecha2 desc
        ";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_usuario_xnum_doc($num_doc){
        $sql = "SELECT u.*,
        (SELECT fec_inicio h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_inicio,
        (SELECT h.fec_fin h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_fin
        from users u
        where u.num_doc='$num_doc' ";
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
