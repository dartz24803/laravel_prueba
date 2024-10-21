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

    function get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc){
        $id_puesto = session('usuario')->id_puesto;
        $id_nivel = session('usuario')->id_nivel;

        if($base=="0"){
            if($id_nivel==1 || $id_puesto==23 || $id_puesto==26){
                $buscar= "";
            }elseif($id_puesto==128){
                $buscar=" AND cod_base not in ('OFC', 'CD', 'DEED', 'EXT', 'EXT', 'AMT') ";
            }else{
                $buscar= "AND su.cod_base IN ('CD','OFC', 'AMT')";
            }
        }else{
            $buscar = "AND su.cod_base='".$base."'";
        }
        $colaborador="";
        if($num_doc!="0"){
            $colaborador=" and u.id_usuario='$num_doc'";
        }

        if($estado_solicitud==4){
            $estado_solicitud=" ";
        }else{
            $estado_solicitud=" AND su.estado_solicitud=$estado_solicitud ";
        }

        $sql = "SELECT su.*,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.usuario_email,
                u.id_modalidad_laboral,u.centro_labores,a.nom_area,u.foto,u.num_doc,
                ua.usuario_nombres as nom_apro,ua.usuario_apater as apater_apro,
                ua.usuario_amater as amater_apro,de.nom_destino,tr.nom_tramite
                FROM solicitudes_user su
                left join users u on su.id_usuario=u.id_usuario
                left join area a on u.id_area=a.id_area
                left join gerencia g on u.id_gerencia=g.id_gerencia
                left join users ua on ua.id_usuario=su.user_aprob
                LEFT JOIN destino de ON de.id_destino=su.destino
                LEFT JOIN tramite tr ON tr.id_tramite=su.tramite
                WHERE u.id_modalidad_laboral!=3 AND su.estado in (1,3) $estado_solicitud $buscar $colaborador
                and fec_solicitud BETWEEN '".$fecha_revision."' AND '".$fecha_revision_fin."'
                order by su.fec_reg DESC";


        $result = DB::select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    function get_list_papeletas_salida_gestion($estado_solicitud = null, $fecha_revision = null, $fecha_revision_fin = null, $separado_por_comas_puestos = null){
        $usuario_codigo = session('usuario')->usuario_codigo;
        $centro_labores = session('usuario')->centro_labores;
        $id_nivel = session('usuario')->id_nivel;
        $id_gerencia = session('usuario')->id_gerencia;
        $id_puesto = session('usuario')->id_puesto;

        // Construcción de condiciones dinámicas
        $motivo = "";
        if (isset($separado_por_comas_puestos) && $separado_por_comas_puestos != '') {
            $puesto = " and u.id_puesto in ($separado_por_comas_puestos)";
            if ($id_puesto == 122) {
                $motivo = " and su.id_motivo=1 ";
            }
        } else {
            $puesto = "";
        }

        // Filtro por estado de solicitud
        if (isset($estado_solicitud) && $estado_solicitud == 4) {
            $solicitud = " and su.estado_solicitud in (1,2,3,4,5) ";
        } else {
            if ($estado_solicitud == 1) {
                if ($id_puesto == 21 || $id_puesto == 279) {
                    $solicitud = " and su.estado_solicitud IN (5)";
                } elseif ($id_nivel == 1 || $id_puesto == 19) {
                    $solicitud = " and su.estado_solicitud IN (1,4,5)";
                } else {
                    $solicitud = " and su.estado_solicitud IN (1,4)";
                }
            } else {
                $solicitud = isset($estado_solicitud) ? " and su.estado_solicitud=$estado_solicitud " : "";
            }
        }

        $buscar = "";
        $area = "";

        // Filtros por gerencia y área
        if ($id_nivel == 1 || $id_puesto == 23 || $id_puesto == 19) {
            $gerencia = "";
            $puesto = "";
        } elseif ($usuario_codigo === "46553611" || $usuario_codigo === "46156858" || $usuario_codigo === "08584691" || $id_puesto == 40) {
            $gerencia = " and u.id_gerencia=$id_gerencia ";
            $puesto = "";
        } elseif ($usuario_codigo === "29426417") {
            $gerencia = " and u.id_gerencia in ($id_gerencia, 1) ";
            $puesto = "";
        } elseif ($usuario_codigo === "44582537") {
            $gerencia = " and u.id_gerencia in ($id_gerencia, 2) ";
            $puesto = "";
        } elseif ($id_puesto == 10) {
            $gerencia = "";
            $puesto = "";
            $area = " and u.id_area in (17) ";
            $motivo = " and su.id_motivo=1 ";
        } elseif ($id_puesto == 93) {
            $gerencia = "";
            $puesto = " and u.id_puesto in (11) ";
            $area = "";
            $motivo = " and su.id_motivo=1 ";
        } else {
            $gerencia = "";
            $buscar = " and su.cod_base='$centro_labores'";
        }

        // Manejo de fechas
        if (!empty($fecha_revision) && !empty($fecha_revision_fin)) {
            $fecha_filter = " and su.fec_solicitud BETWEEN '$fecha_revision' AND '$fecha_revision_fin'";
        } else {
            $fecha_filter = ""; // No agregar filtro de fechas si están vacías
        }

        $sql = "SELECT su.*, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_email, a.nom_area,
                    u.foto, u.num_doc, u.id_puesto,
                    CASE WHEN su.id_motivo IN (1,2) AND su.id_solicitudes_user > 7 THEN de.nom_destino ELSE su.destino END AS destino,
                    CASE WHEN su.id_motivo IN (1,2) AND su.id_solicitudes_user > 7 THEN tr.nom_tramite ELSE su.tramite END AS tramite
                FROM solicitudes_user su
                LEFT JOIN users u ON su.id_usuario = u.id_usuario
                LEFT JOIN area a ON u.id_area = a.id_area
                LEFT JOIN gerencia g ON u.id_gerencia = g.id_gerencia
                LEFT JOIN destino de ON de.id_destino = su.destino
                LEFT JOIN tramite tr ON tr.id_tramite = su.tramite
                WHERE su.estado IN (1, 3) $gerencia $area $puesto $motivo $solicitud $buscar $fecha_filter
                ORDER BY su.fec_reg DESC";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function insert_or_update_papeletas_salida($dato,$id_solicitudes_user){
        $cod_base= session('usuario')->centro_labores;
        $id_usuario= session('usuario')->id_usuario;
        $id_gerencia =session('usuario')->id_gerencia;
        $parametro =$dato['parametro'];
        if($id_solicitudes_user == null){
            if($parametro>0){
                if($dato['id_motivo']==3){
                    $dato['id_motivo']=0;
                }

                if($dato['sin_ingreso']==1){
                    $dato['hora_salida']="08:00:00";
                    $dato['horar_salida']="08:00:00";
                }else{
                    $dato['horar_salida']="00:00:00";
                }
                $cabecera="";
                $valores="";
                if($dato['id_motivo']==1){
                    $estado_solicitud = 2;
                    $cabecera=",user_aprob,fec_apro";
                    $valores=",$id_usuario,NOW()";
                }else{
                    $estado_solicitud = 4;
                }
                $sql = "INSERT INTO solicitudes_user (dif_dias, user_horar_salida, user_horar_entrada,
                 mediodia,observacion,
                        id_usuario,id_solicitudes,cod_solicitud,cod_base,
                        fec_solicitud,id_gerencia,hora_salida,hora_retorno,horar_salida,id_motivo,
                        motivo,destino,tramite,especificacion_destino,especificacion_tramite,
                        estado_solicitud,sin_ingreso,sin_retorno,fec_reg,
                        user_reg,estado,fec_act,user_act $cabecera)
                        VALUES (0.0,0,0,0,0, ".$dato['colaborador'].",'2','".$dato['cod_solicitud']."',
                        '".$dato['centro_labores']."','".$dato['fec_solicitud']."','".$id_gerencia."',
                        '".$dato['hora_salida']."','".$dato['hora_retorno']."',
                        '".$dato['horar_salida']."','".$dato['id_motivo']."','".$dato['otros']."',
                        '".$dato['destino']."','".$dato['tramite']."','".$dato['especificacion_destino']."',
                        '".$dato['especificacion_tramite']."','$estado_solicitud','".$dato['sin_ingreso']."',
                        '".$dato['sin_retorno']."',NOW(),".$id_usuario.",'1',now(),$id_usuario $valores)";
                DB::insert($sql);
            }else{
                if($dato['id_motivo']==3){
                    $dato['id_motivo']=0;
                }

                if($dato['sin_ingreso']==1){
                    $dato['hora_salida']="08:00:00";
                }

                if($dato['id_motivo']==2){
                    $estado_solicitud = 4;
                }else{
                    $estado_solicitud = 1;
                }

                $sql = "INSERT INTO solicitudes_user (dif_dias, user_horar_salida, user_horar_entrada,
                user_aprob, mediodia,observacion,
                        id_usuario,id_solicitudes,cod_solicitud,cod_base,
                        fec_solicitud,id_gerencia,hora_salida,hora_retorno,id_motivo,motivo,destino,
                        tramite,especificacion_destino,especificacion_tramite,estado_solicitud,sin_ingreso,
                        sin_retorno,fec_reg,user_reg,estado,fec_act,user_act)
                        VALUES (0.0,0,0,0,0,0, ".$id_usuario.",'2','".$dato['cod_solicitud']."','".$cod_base."',
                        '".$dato['fec_solicitud']."','".$id_gerencia."','".$dato['hora_salida']."',
                        '".$dato['hora_retorno']."','".$dato['id_motivo']."','".$dato['otros']."',
                        '".$dato['destino']."','".$dato['tramite']."','".$dato['especificacion_destino']."',
                        '".$dato['especificacion_tramite']."',$estado_solicitud,'".$dato['sin_ingreso']."',
                        '".$dato['sin_retorno']."',NOW(),".$id_usuario.",'1',NOW(),$id_usuario)";
                DB::insert($sql);
            }
        }else{
            if($dato['id_motivo']==3){
                $dato['id_motivo']=0;
            }

            if($dato['sin_ingreso']==1){
                $dato['hora_salida']="08:00:00";
            }

            $sql = "UPDATE solicitudes_user SET
                    fec_solicitud='".$dato['fec_solicitud']."',
                    hora_salida='".$dato['hora_salida']."',
                    hora_retorno='".$dato['hora_retorno']."',
                    id_motivo='".$dato['id_motivo']."',
                    motivo='".$dato['otros']."',
                    destino='".$dato['destino']."',
                    tramite='".$dato['tramite']."',
                    especificacion_destino='".$dato['especificacion_destino']."',
                    especificacion_tramite='".$dato['especificacion_tramite']."',
                    sin_ingreso='".$dato['sin_ingreso']."',
                    sin_retorno='".$dato['sin_retorno']."',
                    fec_act=NOW(), user_act=$id_usuario
                    where id_solicitudes_user=".$dato['id_solicitudes_user']."";
            DB::update($sql);
        }
    }

    function get_id_papeletas_salida($id_solicitudes_user){
        $sql = "SELECT su.*,us.id_modalidad_laboral,CONCAT(us.usuario_nombres,' ',us.usuario_apater,' ',us.usuario_amater) AS nombres,
                CASE WHEN su.id_motivo=1 THEN 'Laboral' WHEN su.id_motivo=2 THEN 'Personal' WHEN su.id_motivo=3 THEN 'Otros' ELSE ''
                END AS nom_motivo,de.nom_destino AS destino,tr.nom_tramite AS tramite,us.id_horario,us.num_doc
                FROM solicitudes_user su
                LEFT JOIN users us ON us.id_usuario=su.id_usuario
                LEFT JOIN destino de ON de.id_destino=su.destino
                LEFT JOIN tramite tr ON tr.id_tramite=su.tramite
                WHERE su.id_solicitudes_user=$id_solicitudes_user";

        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    function validar_insert_papeletas_salida($dato){
        $id_usuario= session('usuario')->id_usuario;
        if($dato['parametro']>0){
            $sql = "SELECT * FROM solicitudes_user WHERE id_usuario='".$dato['colaborador']."' AND
                    fec_solicitud='".$dato['fec_solicitud']."' AND tramite='".$dato['tramite']."' AND estado=1";
        }else{
            $sql = "SELECT * FROM solicitudes_user WHERE id_usuario=$id_usuario AND
                    fec_solicitud='".$dato['fec_solicitud']."' AND tramite='".$dato['tramite']."' AND estado=1";
        }

        $result = DB::select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    static function aprobado_papeletas_salida($dato){
        $id_usuario= session('usuario')->id_usuario;

        if($dato['id_motivo'] == 2){//motivo personal
            if(session('usuario')->id_puesto == 19 || session('usuario')->id_puesto == 4){//estos puestos pueden aprobar directo
                $sql = "UPDATE solicitudes_user SET estado_solicitud=2
                        WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                DB::update($sql);
                if($dato['id_modalidad_laboral']==3){
                    $sql = "UPDATE solicitudes_user SET estado_solicitud=2,horar_salida=hora_salida,
                            horar_retorno=hora_retorno,fec_act=NOW(), user_act=$id_usuario,fec_apro=NOW(),
                            user_aprob=$id_usuario
                            WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                    DB::update($sql);
                }else{
                    $parte="";
                    if($dato['sin_ingreso']==1){
                        $parte=",horar_salida='08:00:00'";
                    }

                    $sql = "UPDATE solicitudes_user SET estado_solicitud= 2,
                            fec_act=NOW(), user_act=$id_usuario, fec_apro=NOW(), user_aprob=$id_usuario $parte
                            WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                    DB::update($sql);
                }

                if(count($dato['horario'])>0 && $dato['sin_ingreso']==1){
                    $sql = "INSERT INTO iclock_transaction (
                        emp_code,punch_time,punch_state,verify_type,source,purpose,
                        upload_time,emp_id,is_mask,temperature,work_code)
                        values ('".$dato['num_doc']."','".date('Y-m-d')." ".$dato['horario'][0]['hora_entrada']."',0,1,1,9,
                        '".date('Y-m-d')." ".$dato['horario'][0]['hora_entrada']."',(SELECT id from personnel_employee where LPAD(emp_code,8,'0')='".$dato['num_doc']."'),'255','255.0','PAPELETA SIN INGRESO')";
                        //$this->db5->query($sql);
                    }

                if(count($dato['horario'])>0 && $dato['sin_retorno']==1){
                    $sql = "INSERT INTO iclock_transaction (
                        emp_code,punch_time,punch_state,verify_type,source,purpose,
                        upload_time,emp_id,is_mask,temperature,work_code)
                        values ('".$dato['num_doc']."','".date('Y-m-d')." ".$dato['horario'][0]['hora_salida']."',0,1,1,9,
                        '".date('Y-m-d')." ".$dato['horario'][0]['hora_salida']."',(SELECT id from personnel_employee where LPAD(emp_code,8,'0')='".$dato['num_doc']."'),'255','255.0','PAPELETA SIN RETORNO')";
                    //$this->db5->query($sql);
                    }
            }else{//gerencia aprueba a estado 5 -> "aprobacion de rh"
                $sql = "UPDATE solicitudes_user SET estado_solicitud=5
                        WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                DB::update($sql);
            }
        }else{
            $sql = "UPDATE solicitudes_user SET estado_solicitud=2
                    WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
            DB::update($sql);
            if($dato['id_modalidad_laboral']==3){
                $sql = "UPDATE solicitudes_user SET estado_solicitud=2,horar_salida=hora_salida,
                        horar_retorno=hora_retorno,fec_act=NOW(), user_act=$id_usuario,fec_apro=NOW(),
                        user_aprob=$id_usuario
                        WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                DB::update($sql);
            }else{
                $parte="";
                if($dato['sin_ingreso']==1){
                    $parte=",horar_salida='08:00:00'";
                }

                $sql = "UPDATE solicitudes_user SET estado_solicitud= 2,
                        fec_act=NOW(), user_act=$id_usuario, fec_apro=NOW(), user_aprob=$id_usuario $parte
                        WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
                DB::update($sql);
            }

            if(count($dato['horario'])>0 && $dato['sin_ingreso']==1){
                $sql = "INSERT INTO iclock_transaction (
                    emp_code,punch_time,punch_state,verify_type,source,purpose,
                    upload_time,emp_id,is_mask,temperature,work_code)
                    values ('".$dato['num_doc']."','".date('Y-m-d')." ".$dato['horario'][0]['hora_entrada']."',0,1,1,9,
                    '".date('Y-m-d')." ".$dato['horario'][0]['hora_entrada']."',(SELECT id from personnel_employee where LPAD(emp_code,8,'0')='".$dato['num_doc']."'),'255','255.0','PAPELETA SIN INGRESO')";
                //$this->db5->query($sql);
            }

            if(count($dato['horario'])>0 && $dato['sin_retorno']==1){
                $sql = "INSERT INTO iclock_transaction (
                    emp_code,punch_time,punch_state,verify_type,source,purpose,
                    upload_time,emp_id,is_mask,temperature,work_code)
                    values ('".$dato['num_doc']."','".date('Y-m-d')." ".$dato['horario'][0]['hora_salida']."',0,1,1,9,
                    '".date('Y-m-d')." ".$dato['horario'][0]['hora_salida']."',(SELECT id from personnel_employee where LPAD(emp_code,8,'0')='".$dato['num_doc']."'),'255','255.0','PAPELETA SIN RETORNO')";
                //$this->db5->query($sql);
            }
        }
    }

    static function anulado_papeletas_salida($dato){
        $id_usuario = session('usuario')->id_usuario;

        $parte="";
        if($dato['sin_ingreso']==1){
            $parte=",hora_salida=''";
        }

        $sql = "UPDATE solicitudes_user SET estado_solicitud= 3,
                fec_act=NOW(), user_act=$id_usuario $parte
                WHERE id_solicitudes_user = ".$dato['id_solicitudes_user']."";
        DB::update($sql);
    }
}
