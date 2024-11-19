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
        'id_centro_labor',
        'id_ubicacion',
        'usuario_nombres',
        'usuario_apater',
        'usuario_amater',
        'usuario_codigo',
        'usuario_password',
        'password_desencriptado',
        'id_nivel',
        'usuario_email',
        'emailp',
        'num_celp',
        'num_fijop',
        'num_cele',
        'num_fijoe',
        'num_anexoe',
        'directorio',
        'asistencia',
        'id_horario',
        'horas_semanales',
        'id_puesto',
        'id_empresa',
        'id_empresapl',
        'id_regimen',
        'id_tipo_contrato',
        'id_tipo_documento',
        'num_doc',
        'fec_emision_doc',
        'fec_vencimiento_doc',
        'id_nacionalidad',
        'id_genero',
        'id_estado_civil',
        'urladm',
        'foto',
        'foto_nombre',
        'observaciones',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'situacion',
        'centro_labores',
        'acceso',
        'verif_email',
        'ip_acceso',
        'enfermedades',
        'alergia',
        'hijos',
        'terminos',
        'id_situacion_laboral',
        'ini_funciones',
        'fin_funciones',
        'fec_ingreso',
        'fec_termino',
        'desvinculacion',
        'fec_reg_desv',
        'induccion',
        'nota_induccion',
        'datos_completos',
        'fec_reg_ind',
        'id_modalidad_laboral',
        'home_office',
        'domiciliado',
        'asignacion_familiar',
        'aporte_voluntario',
        'neto_uss',
        'id_banco_cts',
        'cuenta_cts',
        'id_banco_haberes',
        'cuenta_haberes',
        'id_tipo_trabajador',
        'id_sector_laboral',
        'id_nivel_educativo',
        'id_ocupacion',
        'id_cargo_trabajador',
        'id_sctr_salud',
        'id_sctr_pension',
        'id_situacion_trabajador',
        'fecha_cese',
        'fec_baja',
        'cancelar_baja',
        'id_motivo_baja',
        'observaciones_baja',
        'doc_baja',
        'fec_asignacionjr',
        'id_puestojr',
        'cancelar_asignacionjr',
        'estado_asignacioncv',
        'fec_asignacioncv',
        'fec_iniciocv',
        'fec_regvc',
        'cancelar_asignacioncv',
        'id_puestocv',
        'id_regimen_pensionario',
        'fecha_inscripcion',
        'cuspp_afp',
        'id_comision_afp',
        'regimen_a',
        'jornada_trabajo',
        'trabajo_nocturno',
        'discapacidad',
        'sindicalizado',
        'renta_quinta',
        'id_tipo_pago',
        'id_periocidad',
        'id_situacion_especial_trabajador',
        'afiliado_eps',
        'id_eps',
        'ingreso_quinta',
        'ruc_quinta',
        'razon_social_quinta',
        'renta_bruta_quinta',
        'retencion_renta_quinta',
        'trabajador',
        'pensionista',
        'servicio_cuarta',
        'servicio_mod',
        'terceros',
        'ruc_categoria',
        'gusto_personales',
        'edicion_perfil',
        'perf_revisado',
        'fec_edi_perfil',
        'user_edi_perfil',
        'fec_perf_revisado',
        'user_perf_revisado',
        'accesos_email',
        'motivo_renuncia',
        'correo_bienvenida',
        'documento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function get_list_colaborador_usuario(array $filters)
    {
        $query = self::select('id_usuario', 'usuario_apater', 'usuario_amater', 'usuario_nombres', 'id_nivel')
            ->where('estado', 1);


        if (isset($filters['id_usuario'])) {
            $query->where('id_usuario', $filters['id_usuario']);
        }
        // Devuelve los resultados
        return $query->get();
    }

    public function login($usuario)
    {
        $query = "SELECT u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo,
                u.id_nivel, ub.cod_ubi AS centro_labores, ub.id_sede AS id_sede_laboral, u.emailp, u.num_celp, u.induccion, u.datos_completos,u.id_puesto,u.acceso,
                u.ini_funciones,u.fec_reg,u.usuario_password,u.estado, n.nom_nivel, p.nom_puesto, a.nom_area, p.id_area,
                (SELECT GROUP_CONCAT(puestos) FROM area WHERE estado=1 AND orden!='') AS grupo_puestos, sg.id_gerencia,
                CASE WHEN u.urladm=1 THEN (select r.url_config from config r where r.descrip_config='Foto_Postulante'
                and r.estado=1) else (select r.url_config from config r where r.descrip_config='Foto_colaborador'
                and r.estado=1) end as url_foto,p.id_nivel as nivel_jerarquico,u.desvinculacion,
                pps.registro_masivo, visualizar_amonestacion(u.id_puesto) AS visualizar_amonestacion,
                sl.descripcion AS sede_laboral, ubi.cod_ubi AS ubicacion,
                visualizar_responsable_area(u.id_puesto) AS visualizar_responsable_area,
                pps.estado as estadopps, pps.registro_masivo, pps.id_puesto_permitido, u.id_centro_labor,
                visualizar_mi_equipo(u.id_puesto) AS visualizar_mi_equipo,
                (SELECT COUNT(*) FROM asignacion_jefatura aj
                WHERE aj.id_puesto_jefe=u.id_puesto and aj.estado=1) as puestos_asignados,u.id_cargo,
                u.id_centro_labor
                FROM users u
                LEFT JOIN permiso_papeletas_salida pps ON u.id_puesto=pps.id_puesto_jefe AND pps.estado=1
                LEFT JOIN nivel n ON u.id_nivel=n.id_nivel
                LEFT JOIN puesto p ON u.id_puesto=p.id_puesto
                LEFT JOIN area a ON p.id_area=a.id_area
                LEFT JOIN sub_gerencia sg ON a.id_departamento=sg.id_sub_gerencia
                LEFT JOIN ubicacion ub ON u.id_centro_labor=ub.id_ubicacion
                LEFT JOIN ubicacion ubi ON u.id_ubicacion=ubi.id_ubicacion
                LEFT JOIN sede_laboral sl ON ub.id_sede=sl.id
                WHERE u.usuario_codigo='$usuario' AND u.estado IN (1,4) AND u.desvinculacion IN (0)";
        $result = DB::select($query);
        return $result;
    }

    public static function get_list_usuario_ft($dato = null)
    {
        $parte = "";
        if (isset($dato['base'])) {
            $parte = "centro_labores='" . $dato['base'] . "' AND";
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

    function get_list_colaborador_programacion_diaria($base, $id_puesto)
    {
        $sql = "SELECT id_usuario,CONCAT(usuario_nombres,' ',usuario_apater,' ',usuario_amater) AS colaborador
                FROM users
                WHERE centro_labores='$base' AND id_puesto=$id_puesto AND estado=1
                ORDER BY usuario_apater,usuario_amater,usuario_nombres";
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }


    //obtener horarios x base actual
    function get_horarios_x_base_hoy($base = null)
    {
        $parte = "";
        if ($base != '0') {
            $parte = " AND t.base = '$base'";
        }
        $sql = "SELECT hd.id_horario, t.base, hd.dia, hd.nom_dia, hd.hora_entrada, hd.hora_descanso_e, hd.hora_descanso_s, hd.hora_salida
                FROM horario_dia hd LEFT JOIN turno t ON hd.id_turno=t.id_turno
                WHERE hd.dia = IF(DAYOFWEEK(CURDATE()) = 1, 7, DAYOFWEEK(CURDATE()) - 1) AND hd.id_turno>0 $parte;";
        $query = $this->db->query($sql)->result_Array();
        return $query;
    }
    //lista con hora de entrada y salida
    function get_list_cuadro_control_visual($base)
    {
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

    function contador_presentes_ccv($base = null)
    {
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

    function contador_total_x_bases($base = null)
    {
        $sql = "SELECT COUNT(*) AS contador_total_x_bases FROM users u LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                WHERE u.centro_labores = '$base'
                AND u.estado = 1
                AND NOT u.usuario_nombres LIKE 'Base%'";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_usuarios_x_baset($cod_base = null, $area = null, $estado)
    {
        
        $base = "";
        if ($cod_base != "0") {
            $base = "AND u.id_centro_labor='$cod_base'";
        }
        $carea = "";
        if (isset($area) && $area > 0) {
            $carea = "AND p.id_area='$area' ";
        }

        $id_estado = "";
        if ($estado == 1) {
            $id_estado = "AND u.estado=1";
        } else {
            $id_estado = "AND u.estado in (2,3)";
        }
        $sql = "SELECT u.*,(SELECT fec_inicio h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_inicio,
                (SELECT h.fec_fin h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_fin
                FROM users u
                LEFT JOIN puesto p ON u.id_puesto = p.id_puesto
                WHERE u.id_nivel<>8 $base $carea $id_estado";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    public function list_usuarios_responsables($dato)
    {
        $sql = "SELECT 	u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo,
                u.id_nivel, u.usuario_email, u.centro_labores, u.emailp, u.num_celp, u.induccion, u.datos_completos,
                u.desvinculacion, u.ini_funciones,u.fec_reg,
                u.usuario_password,u.estado, n.nom_nivel, p.nom_puesto, a.id_area,
                DATE_FORMAT(u.fec_nac, '%M %d,%Y') as fec_nac, u.usuario_codigo,g.id_gerencia,
                u.foto, u.acceso, u.id_puesto, u.id_cargo, u.directorio

                FROM users u
                left join nivel n on n.id_nivel=u.id_nivel
                left join puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN area a on a.id_area=p.id_area
                LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia

                WHERE  u.estado IN (1,4) and u.desvinculacion IN (0) and u.id_nivel<>8 and u.id_puesto in (" . $dato['puestos_jefes'][0]['puestos'] . ")";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    function get_list_colaborador($id_usuario = null)
    {
        if (isset($id_usuario) && $id_usuario > 0) {
            $sql = "SELECT u.*, n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                    from users u
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN area a on a.id_area=p.id_area
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    where u.estado=1 and id_usuario =" . $id_usuario;
        } else {
            $sql = "SELECT u.*,  n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                    from users u
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN area a on a.id_area=p.id_area
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    where u.estado=1 and u.id_nivel<>8";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_colaborador_all()
    {
        $sql = "SELECT u.*,  a.nom_area, g.nom_gerencia, p.nom_puesto
                    from users u
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN area a on a.id_area=p.id_area
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    where u.estado=1 and u.id_nivel<>8";

        $result = DB::select($sql);
        // No es necesario convertir a array
        return $result; // Retornar como objeto
    }


    static function get_list_proximos_cumpleanios_admin($dato)
    {
        $anio = date('Y');
        $sql = "SELECT u.id_usuario,u.centro_labores,u.foto,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.fec_nac,u.foto_nombre,
        CONCAT(YEAR(NOW()), '-', DATE_FORMAT(u.fec_nac, '%m-%d')) as cumpleanio,
        (SELECT COUNT(*) FROM saludo_cumpleanio_historial i where i.id_cumpleaniero=u.id_usuario and year(i.fec_reg)='$anio' and i.estado=1) as cantidad,
        p.nom_puesto
        FROM users u
        left join puesto p on u.id_puesto=p.id_puesto
        WHERE u.estado=1 and DATE_FORMAT(u.fec_nac, '%m')='" . $dato['cod_mes'] . "'
        ORDER BY cumpleanio  ASC;";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_usuario($id_usuario = null)
    {
        if (isset($id_usuario) && $id_usuario > 0) {
            $sql = "SELECT u.*, p.nom_puesto, m.nom_mes, g.cod_genero, g.nom_genero,a.cod_area,
                    a.nom_area,t.cod_tipo_documento,ge.nom_gerencia,
                    u.usuario_email/*,(SELECT st.archivo FROM saludo_temporal st
                    WHERE st.id_usuario=u.id_usuario
                    LIMIT 1) AS archivo_saludo*/
                    FROM users u
                    INNER JOIN puesto p ON p.id_puesto=u.id_puesto
                    INNER JOIN area a ON a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia ge ON ge.id_gerencia=sg.id_gerencia
                    left join mes m on m.id_mes=u.mes_nac
                    left join genero g on g.id_genero=u.id_genero
                    left join tipo_documento t on t.id_tipo_documento=u.id_tipo_documento
                    WHERE u.id_usuario=$id_usuario";
        } else {
            $sql = "SELECT * FROM parentesco";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_saludo_cumpleanios($id_usuario)
    {
        $anio = date('Y');
        $sql = "SELECT u.*,CONCAT(YEAR(NOW()), '-', DATE_FORMAT(a.fec_nac, '%m-%d')) as cumpleanio,
        a.usuario_nombres,a.usuario_apater,a.usuario_amater,
        concat(b.usuario_nombres,' ',b.usuario_apater) as saludado_por,
        case when u.estado_registro=1 then 'Aprobado' when u.estado_registro=2 then 'Pendiente de aprobación' end as desc_estado_registro
        FROM saludo_cumpleanio_historial u
        left join users a on u.id_cumpleaniero=a.id_usuario
        left join users b on u.id_usuario=b.id_usuario
        where u.id_cumpleaniero='$id_usuario' and year(u.fec_reg)='$anio' and u.estado=1";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_list_proximos_cumpleanios()
    {
        $id_usuario = session('usuario')->id_usuario;
        // $centro_labores= session('usuario')->centro_labores;
        $anio = date('Y');
        $sql = "SELECT u.id_usuario,u.foto,u.usuario_nombres,u.usuario_apater,u.usuario_amater,u.fec_nac,
                u.foto_nombre,CONCAT(YEAR(NOW()), '-', DATE_FORMAT(fec_nac, '%m-%d')) as cumpleanio,
                h.id_historial,h.estado_registro,m.nom_mes,
                LOWER(u.usuario_nombres) AS nombres_min,LOWER(u.usuario_apater) AS apater_min,
                ar.nom_area,u.centro_labores
                FROM users u
                LEFT JOIN saludo_cumpleanio_historial h on h.id_usuario='$id_usuario' and
                h.id_cumpleaniero=u.id_usuario and year(h.fec_reg)='$anio' and h.estado=1
                LEFT JOIN mes m on month(u.fec_nac)=m.cod_mes
                INNER JOIN puesto pu ON pu.id_puesto=u.id_puesto
                INNER JOIN area ar ON pu.id_area=ar.id_area
                WHERE (DATE_FORMAT(u.fec_nac, '%m-%d') BETWEEN DATE_FORMAT(NOW(), '%m-%d') AND
                DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 5 DAY), '%m-%d')) AND u.usuario_nombres NOT LIKE 'Base%' AND u.estado=1
                ORDER BY cumpleanio ASC";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }





    public static function get_list_cesado($dato)
    {
        $parte_gerencia = "";
        if ($dato['id_gerencia'] != "0") {
            $parte_gerencia = "ge.id_gerencia=" . $dato['id_gerencia'] . " AND";
        }
        $sql = "SELECT us.id_usuario,us.ini_funciones AS orden,
                CASE WHEN YEAR(us.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                WHEN YEAR(us.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                WHEN YEAR(us.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                WHEN YEAR(us.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                WHEN YEAR(us.fec_nac) >= 2013 THEN '&alpha;' ELSE '' END AS generacion,
                us.centro_labores,us.usuario_apater,us.usuario_amater,us.usuario_nombres,
                DATE_FORMAT(us.ini_funciones,'%d-%m-%Y') AS fecha_ingreso,td.cod_tipo_documento,us.num_doc,
                us.num_celp,pu.nom_puesto,ar.nom_area,CASE WHEN SUBSTRING(us.fin_funciones,1,1)='2' THEN
                TIMESTAMPDIFF(DAY, us.ini_funciones, us.fin_funciones)
                ELSE TIMESTAMPDIFF(DAY, us.ini_funciones, CURDATE()) END AS dias_laborados,us.verif_email,
                us.foto,us.documento,us.fec_baja
                FROM users us
                LEFT JOIN tipo_documento td ON us.id_tipo_documento=td.id_tipo_documento
                INNER JOIN puesto pu ON pu.id_puesto=us.id_puesto
                INNER JOIN area ar ON ar.id_area=pu.id_area
                INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=ar.id_departamento
                INNER JOIN gerencia ge ON ge.id_gerencia=sg.id_gerencia
                WHERE $parte_gerencia us.id_nivel<>8 AND us.estado=3
                ORDER BY us.ini_funciones DESC";
        $query = DB::select($sql);
        return $query;
    }

    public static function perfil_porcentaje($id_usuario)
    {
        $sql = "SELECT u.id_usuario, u.usuario_apater, u.centro_labores, td.cod_tipo_documento,
                u.num_celp,u.num_doc, u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad,
                u.foto, u.verif_email,
                (case when u.usuario_nombres is not null and u.usuario_apater is not null and u.usuario_amater is not null
                and u.id_nacionalidad is not null and u.id_tipo_documento is not null
                and u.num_doc is not null and u.id_genero is not null and u.fec_nac is not null
                and u.id_estado_civil is not null and u.num_celp is not null and u.foto_nombre is not null
                and (u.emailp is not null || u.usuario_email is not null)
                then 1 else 0 end) as datos_personales,
                (case when (select count(1) from gusto_preferencia_users where gusto_preferencia_users.id_usuario=u.id_usuario and gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos where hijos.id_usuario=u.id_usuario and hijos.estado=1)>0) then 1 else 0 end) as cont_hijos,
                (case when (select count(1) from conoci_idiomas where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0 then 1 else 0 end) as idiomas,
                (case when u.enfermedades=2 or (u.enfermedades=1 and (select count(1) from enfermedad_usuario where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0) then 1 else 0 end) as cont_enfermedades,
                (case when u.id_genero=1 or (select count(1) from gestacion_usuario where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0 then 1 else 0 end) as gestacion,
                (case when u.alergia=0 then 0 else 1 end) as cont_alergia,
                (case when (select count(1) from referencia_convocatoria where referencia_convocatoria.id_usuario=u.id_usuario and referencia_convocatoria.estado=1)>0 then 1 else 0 end) as ref_convoc,
                (case when e.cv_doc<>'' and e.dni_doc<>'' and e.recibo_doc<>'' then 1 else 0 end) as adj_documentacion,
                (case when u.terminos=0 then 0 else 1 end) as cont_terminos,
                (case when (select count(1) from curso_complementario where curso_complementario.id_usuario=u.id_usuario and curso_complementario.estado=1)>0 then 1 else 0 end) as con_cursos_compl,
                (case when (select count(1) from otros_usuario where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0 then 1 else 0 end) as con_otros,
                (case when d.id_departamento is not null and d.id_provincia is not null and d.id_distrito is not null
                and d.id_tipo_vivienda is not null and d.referencia is not null and d.lat is not null and d.lng is not null
                then 1 else 0 end) as domicilio_user, (case when cb.cuenta_bancaria=2 then 1
                when cb.id_banco is not null and cb.cuenta_bancaria is not null
                and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                and cb.num_codigo_interbancario is not null then 1 else 0 end) as cuenta_bancaria,
                (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                then 1 else 0 end) as talla_usuario, (case when ou.id_grupo_sanguineo is not null
                then 1 else 0 end) as grupo_sanguineo,
                (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                (case when sp.id_respuestasp is not null then 1 else 0 end) as sistema_pension,
                (case when du.cv_doc is not null and du.dni_doc is not null and du.recibo_doc is not null
                then 1 else 0 end) as documentacion, (case when co.nl_excel is not null and
                co.nl_word is not null and co.nl_ppoint is not null then 1 else 0 end) as office,
                (case when (select count(1) from referencia_familiar
                where referencia_familiar.id_usuario=u.id_usuario and referencia_familiar.nom_familiar is not null
                and referencia_familiar.id_parentesco is not null
                and referencia_familiar.fec_nac is not null and (referencia_familiar.celular1 is not null ||
                referencia_familiar.celular2 is not null || referencia_familiar.fijo is not null)
                and referencia_familiar.estado=1)>0 then 1 else 0 end) as referencia,
                (case when (select count(1) from contacto_emergencia
                where contacto_emergencia.id_usuario=u.id_usuario and contacto_emergencia.nom_contacto is not null
                and contacto_emergencia.id_parentesco is not null
                and (contacto_emergencia.celular1 is not null || contacto_emergencia.celular2 is not null ||
                contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                then 1 else 0 end) as contactoe,
                (case when (select count(1) from estudios_generales
                where estudios_generales.id_usuario=u.id_usuario and
                estudios_generales.id_grado_instruccion is not null
                and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                estudios_generales.estado=1)>0 then 1 else 0 end) as estudiosg,
                (case when (select count(1) from experiencia_laboral
                where experiencia_laboral.id_usuario=u.id_usuario and experiencia_laboral.empresa is not null
                and experiencia_laboral.cargo is not null and experiencia_laboral.fec_ini is not null
                and experiencia_laboral.fec_fin is not null and experiencia_laboral.motivo_salida is not null
                and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                then 1 else 0 end) as experiencial, a.nom_area, g.nom_gerencia, p.nom_puesto,
                u.usuario_email, em.nom_empresa, du.dni_doc
                from users u
                INNER JOIN puesto p ON p.id_puesto=u.id_puesto
                INNER JOIN area a ON a.id_area=p.id_area
                INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                INNER JOIN gerencia g ON g.id_gerencia=sg.id_gerencia
                left join domicilio_users d on d.id_usuario=u.id_usuario
                left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                left join conoci_office co on co.id_usuario=u.id_usuario
                left join otros_usuario ou on ou.id_usuario=u.id_usuario
                left join documentacion_usuario du on du.id_usuario=u.id_usuario
                left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                left join empresas em on em.id_empresa=u.id_empresapl
                left join (select id_usuario,cv_doc,dni_doc,recibo_doc
                            from documentacion_usuario where estado=1) as e on u.id_usuario=e.id_usuario
                WHERE u.id_usuario=$id_usuario";

        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    static function get_jefe_area($id_area)
    {
        $jefes = [];
        switch ($id_area) {
            case 2:
                $jefes = ['JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN'];
                break;
            case 5:
                $jefes = ['GERENTE DE GESTIÓN COMERCIAL'];
                break;
            case 6:
                $jefes = ['SUPERVISOR DE COMPRAS E INGRESOS', 'JEFE DE DTO. GESTIÓN LOGÍSTICA'];
                break;
            case 7:
                $jefes = ['COORDINADOR DE MARKETING'];
                break;
            case 9:
                $jefes = ['JEFE DE CONTABILIDAD Y LEGAL', 'ASISTENTE CONTABLE'];
                break;
            case 10:
                $jefes = ['JEFE DE DTO. GESTIÓN DE INFRAESTRUCTURA'];
                break;
            case 11:
                $jefes = ['JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO'];
                break;
            case 12:
                $jefes = ['JEFE DE DTO. GESTIÓN DE SEGURIDAD Y SALUD'];
                break;
                /*case 13:
                $jefes = ['ANALISTA PROGRAMADOR SR.'];
                break;*/
            case 13:
                $jefes = [815, 2655];
                break;
            case 14:
                $jefes = ['ADMINISTRADOR DE TIENDA', 'COORDINADOR JR. DE TIENDA', 'COORDINADOR SR. DE TIENDA', 'JEFE DE DTO. GESTIÓN DE VENTAS'];
                break;
            case 15:
                $jefes = ['COORDINADOR SR. DE CAJA'];
                break;
            case 17:
                $jefes = ['ASISTENTE DE TESORERÍA'];
                break;
            case 18:
                $jefes = ['ANALISTA DE PROCESOS Y PROYECTOS'];
                break;
            case 19:
                $jefes = ['COORDINADOR DE CONTROL INTERNO'];
                break;
            case 21:
                $jefes = ['JEFE DE BUSINESS INTELLIGENCE'];
                break;
            case 25:
                $jefes = ['COORDINADOR SR. DE SOPORTE TÉCNICO'];
                break;
            case 26:
                $jefes = ['JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO'];
                break;
            case 27:
                $jefes = ['JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN'];
                break;
            case 28:
                $jefes = ['JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN'];
                break;
            case 29:
                $jefes = ['JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO'];
                break;
            case 30:
                $jefes = ['SUPERVISOR DE DISTRIBUCIÓN', ''];
                break;
            case 31:
                $jefes = ['JEFE DE DTO. GESTIÓN DE INFRAESTRUCTURA'];
                break;
            case 32:
                $jefes = ['JEFE DE DTO. GESTIÓN DE SEGURIDAD Y SALUD'];
                break;
            case 33:
                $jefes = ['JEFE DE DTO. GESTIÓN DE VENTAS'];
                break;
            case 34:
                $jefes = ['JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO'];
                break;
            case 35:
                $jefes = ['JEFE DE DTO. GESTIÓN LOGÍSTICA'];
                break;
            case 36:
                $jefes = ['GERENTE DE ADMINISTRACIÓN Y FINANZAS'];
                break;
            case 37:
                $jefes = ['GERENTE DE OPERACIONES Y PLANEAMIENTO'];
                break;
            case 38:
                $jefes = ['DIRECTOR GENERAL'];
                break;
            case 40:
                $jefes = ['SUPERVISOR NACIONAL DE ABASTECIMIENTO E INVENTARIOS', 'JEFE DE DTO. GESTIÓN LOGÍSTICA'];
                break;
            case 41:
                $jefes = ['JEFE DE DTO. GESTIÓN DE INFRAESTRUCTURA', 'SUPERVISOR DE MANTENIMIENTO'];
                break;
            case 42:
                $jefes = ['SUPERVISOR DE PICKING E INVENTARIO', 'JEFE DE DTO. GESTIÓN LOGÍSTICA'];
                break;
            case 43:
                $jefes = ['JEFE DE DTO. GESTIÓN DEL TALENTO HUMANO'];
                break;
            case 44:
                $jefes = ['JEFE DE DTO. GESTIÓN DE SEGURIDAD Y SALUD'];
                break;
            case 45:
                $jefes = ['JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN'];
                break;
            case 46:
                $jefes = ['GERENTE DE ADQUISICIÓN DE MATERIALES'];
                break;
            case 47:
                $jefes = ['JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN'];
                break;
        }

        $resultados = [];
        if ($id_area != 13) {
            foreach ($jefes as $jefe) {
                $sql = "SELECT u.emailp
                        FROM users u
                        JOIN puesto p ON u.id_puesto = p.id_puesto
                        WHERE p.nom_puesto = '$jefe'
                        AND u.emailp IS NOT NULL
                        AND u.emailp != ''; ";

                $result = DB::select($sql);
                $query = json_decode(json_encode($result), true);
                // Agrega los resultados al conjunto $resultados
                foreach ($query as $row) {
                    $resultados[] = $row;
                }
            }
        } else {
            //cuando es sistemas manda a Odile y Daniel
            foreach ($jefes as $jefe) {
                $sql = "SELECT u.emailp
                        FROM users u
                        JOIN puesto p ON u.id_puesto = p.id_puesto
                        WHERE id_usuario='$jefe'
                        AND u.emailp IS NOT NULL
                        AND u.emailp != ''; ";

                $result = DB::select($sql);
                $query = json_decode(json_encode($result), true);
                // Agrega los resultados al conjunto $resultados
                foreach ($query as $row) {
                    $resultados[] = $row;
                }
            }
        }
        // Convertir $resultados a un conjunto para eliminar duplicados
        $resultados = array_unique($resultados, SORT_REGULAR);

        return $resultados;
    }


    static function get_list_usuario_inventario()
    {
        $sql = "SELECT u.*, p.nom_puesto, m.nom_mes, g.cod_genero, g.nom_genero,a.nom_area,t.cod_tipo_documento,ge.nom_gerencia,
                u.usuario_email
                FROM users u
                left join area a on a.id_area=u.id_area
                left join puesto p on p.id_puesto=u.id_puesto
                left join mes m on m.id_mes=u.mes_nac
                left join genero g on g.id_genero=u.id_genero
                left join tipo_documento t on t.id_tipo_documento=u.id_tipo_documento
                left join gerencia ge on ge.id_gerencia = u.id_gerencia
                WHERE u.estado=1 and u.id_nivel in (1,9)";

        $query = DB::select($sql);
        return $query;
    }

    function get_list_colaborador_xarea($area)
    {
        $sql = "SELECT u.*,  n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                from users u
                LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                LEFT JOIN gerencia g on g.id_gerencia=u.id_gerencia
                LEFT JOIN area a on a.id_area=u.id_area
                LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                where u.estado=1 and u.id_nivel<>8 and u.id_area='" . $area . "'";

        $query = DB::select($sql);
        return $query;
    }

    static function get_list_usuarios_x_base($cod_base)
    {
        $sql = "SELECT * from users where estado=1 and centro_labores='$cod_base' and id_nivel<>8";

        $result = DB::select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    static function get_list_vendedor($centro_labores = NULL, $id_puesto = null)
    {
        $id_nivel = session('usuario')->id_nivel;
        $id_pueston = session('usuario')->id_puesto;

        if (isset($id_puesto) && $id_puesto != '0' && $id_puesto != '') {
            $buscar = "id_puesto in ($id_puesto) AND";
        } else {
            $buscar = "";
        }

        if ($id_nivel == 1 || $id_pueston == 39) {
            $sql = "SELECT * FROM users
                    WHERE $buscar id_nivel NOT IN (8,12) AND estado=1
                    ORDER BY usuario_apater ASC, usuario_amater ASC, usuario_nombres ASC";
        } elseif (isset($centro_labores) && $centro_labores != '0') {
            $sql = "SELECT * FROM users
                    WHERE $buscar centro_labores='$centro_labores' AND id_nivel NOT IN (8,12) AND estado=1
                    ORDER BY usuario_apater ASC, usuario_amater ASC, usuario_nombres ASC";
        } else {
            $sql = "SELECT * FROM users e
                    WHERE $buscar id_nivel NOT IN (8,12) AND estado=1
                    ORDER BY usuario_apater ASC, usuario_amater ASC, usuario_nombres ASC";
        }

        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    static function get_list_colaborador_xarea_static($area)
    {
        if ($area == 41) {
            $sql = "SELECT u.*,
                   CONCAT(u.usuario_nombres, ' ', u.usuario_apater) AS nombre_completo,
                   a.nom_area,
                   g.nom_gerencia,
                   p.nom_puesto,
                   sg.id_sub_gerencia
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a ON a.id_area = p.id_area
                LEFT JOIN sub_gerencia sg ON sg.id_sub_gerencia = a.id_departamento
                LEFT JOIN gerencia g ON g.id_gerencia = sg.id_gerencia
                WHERE u.estado = 1
                AND p.id_puesto IN (12, 155, 134)";
        } else {
            $sql = "SELECT u.*,
                   CONCAT(u.usuario_nombres, ' ', u.usuario_apater) AS nombre_completo,
                   a.nom_area,
                   g.nom_gerencia,
                   p.nom_puesto,
                   sg.id_sub_gerencia
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a ON a.id_area = p.id_area
                LEFT JOIN sub_gerencia sg ON sg.id_sub_gerencia = a.id_departamento
                LEFT JOIN gerencia g ON g.id_gerencia = sg.id_gerencia
                WHERE u.estado = 1
                AND u.id_nivel <> 8
                AND p.id_area = '" . $area . "'";
        }

        $query = DB::select($sql);
        return $query;
    }


    static function get_list_colaboradort($id_usuario = null, $estado = null)
    {
        if (isset($id_usuario) && $id_usuario > 0) {
            $sql = "SELECT u.*, n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                    from users u
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN area a on a.id_area=p.id_area
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    where id_usuario =" . $id_usuario;
        } else {
            $id_estado = "";
            if (isset($estado) && $estado > 0) {
                if ($estado == 1) {
                    $id_estado = " and u.estado=" . $estado;
                } else {
                    $id_estado = " and u.estado in (2,3)";
                }
            }
            $sql = "SELECT u.*,  n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                    from users u
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN area a on a.id_area=p.id_area
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    where u.id_nivel<>8 $id_estado";
        }
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    static function colaborador_porcentaje($id_usuario = null, $centro_labores = null, $dato = null, $data)
    {
        $id_gerencia = session('usuario')->id_gerencia;
        $id_puesto = session('usuario')->id_puesto;
        $id_nivel = session('usuario')->id_nivel;
        $visualizar_mi_equipo =  session('usuario')->visualizar_mi_equipo;

        if (isset($id_usuario) && $id_usuario > 0) {
            $sql = "SELECT u.*, n.nom_nacionalidad,td.nom_tipo_documento,a.nom_area,pu.nom_puesto,
                    gr.nom_grado_instruccion,
                    EXTRACT(DAY FROM u.fec_nac) AS dia,
                    case month(a.fec_nac)
                    WHEN 1 THEN 'Enero'
                    WHEN 2 THEN  'Febrero'
                    WHEN 3 THEN 'Marzo'
                    WHEN 4 THEN 'Abril'
                    WHEN 5 THEN 'Mayo'
                    WHEN 6 THEN 'Junio'
                    WHEN 7 THEN 'Julio'
                    WHEN 8 THEN 'Agosto'
                    WHEN 9 THEN 'Septiembre'
                    WHEN 10 THEN 'Octubre'
                    WHEN 11 THEN 'Noviembre'
                    WHEN 12 THEN 'Diciembre'
                    END mes,
                    c.nom_contacto,c.celular1,c.celular2,c.fijo,ub.cod_ubi AS centro_labores
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto pu ON pu.id_puesto=u.id_puesto
                    INNER JOIN area a ON a.id_area=p.id_area
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN grado_instruccion gr on gr.id_grado_instruccion=u.id_grado_instruccion
                    LEFT JOIN contacto_emergencia ce on ce.id_contacto_emergencia=u.id_contacto_emergencia
                    where u.estado in (1) and id_usuario =" . $id_usuario;
        } elseif ($id_nivel == "1") {
            $base = "";
            if ($data['base'] != "0") {
                $base = "AND u.id_centro_labor='" . $data['base'] . "'";
            }
            $sql = "SELECT u.id_usuario, u.usuario_apater,u.fec_baja,
                    ub.cod_ubi AS centro_labores, td.cod_tipo_documento,
                    td.nom_tipo_documento, u.num_celp,u.num_doc, u.verif_email,
                    u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad, u.foto,
                    estau.nom_estado_usuario, ge.nom_genero, depart.nombre_departamento,
                    provic.nombre_provincia, distr.nombre_distrito, banc.nom_banco,
                    spn.cod_sistema_pensionario, afp.nom_afp, banc.nom_banco, cb.num_cuenta_bancaria,
                    u.fec_ingreso, u.fec_termino,em.ruc_empresa,EXTRACT(DAY FROM u.fec_nac) AS dia,
                    case month(u.fec_nac) WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero' WHEN 3 THEN 'Marzo'
                    WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio'
                    WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre'
                    WHEN 12 THEN 'Diciembre' END as mes,u.usuario_email, u.fec_nac, situlab.nom_situacion_laboral,
                    u.ini_funciones,d.nom_via,d.num_via,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                    u.usuario_email, em.nom_empresa, du.dni_doc, tp.cod_talla as polo, tc.cod_talla as camisa,
                    tpa.cod_talla as pantalon, tz.cod_talla as zapato,
                    date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;' ELSE '-' END AS generacion,u.id_puesto
                    FROM users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p ON p.id_puesto=u.id_puesto
                    INNER JOIN area a ON a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g ON g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    left join domicilio_users d on d.id_usuario=u.id_usuario
                    left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    left join conoci_office co on co.id_usuario=u.id_usuario
                    left join otros_usuario ou on ou.id_usuario=u.id_usuario
                    left join documentacion_usuario du on du.id_usuario=u.id_usuario and du.estado=1
                    left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                    left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                    left join empresas em on em.id_empresa=u.id_empresapl
                    left join vw_estado_usuario estau on estau.id_estado_usuario=u.estado
                    left join genero ge on ge.id_genero=u.id_genero
                    left join departamento depart on depart.id_departamento=d.id_departamento
                    left join provincia provic on provic.id_provincia=d.id_provincia
                    left join distrito distr on distr.id_distrito=d.id_distrito
                    left join banco banc on banc.id_banco=cb.id_banco
                    left join sistema_pensionario spn on spn.id_sistema_pensionario =sp.id_sistema_pensionario
                    left join afp afp on afp.id_afp  =sp.id_afp
                    left join situacion_laboral situlab on situlab.id_situacion_laboral =u.id_situacion_laboral
                    left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                    left join talla tp on tp.id_talla=ru.polo
                    left join talla tc on tc.id_talla=ru.camisa
                    left join talla tpa on tpa.id_talla=ru.pantalon
                    left join talla tz on tz.id_talla=ru.zapato
                    left join motivo_baja_rrhh mt on u.id_motivo_baja=mt.id_motivo
                    where u.estado in (1) and u.id_nivel<>8 $base
                    ORDER BY u.ini_funciones DESC";
        } elseif ($id_puesto == "1" || $id_puesto == "39" || $id_puesto == "80" || $id_puesto == "92") {
            $sql = "SELECT u.id_usuario, u.usuario_apater, u.verif_email,u.fec_baja,
                    ub.cod_ubi AS centro_labores, td.cod_tipo_documento,
                    td.nom_tipo_documento, u.num_celp,u.num_doc,
                    u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad, u.foto,
                    estau.nom_estado_usuario, ge.nom_genero, depart.nombre_departamento,
                    provic.nombre_provincia, distr.nombre_distrito, banc.nom_banco,
                    spn.cod_sistema_pensionario, afp.nom_afp, banc.nom_banco, cb.num_cuenta_bancaria,
                    u.fec_ingreso, u.fec_termino,em.ruc_empresa,EXTRACT(DAY FROM u.fec_nac) AS dia,
                    case month(u.fec_nac) WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero'
                    WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio'
                    WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre'
                    WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre' END mes,
                    u.usuario_email, u.fec_nac, situlab.nom_situacion_laboral,u.ini_funciones,d.nom_via,
                    d.num_via,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                    u.usuario_email, em.nom_empresa, du.dni_doc,
                    date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,
                    date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;' ELSE 'No se pudo determinar la generación'
                    END AS generacion,u.id_puesto
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p ON p.id_puesto=u.id_puesto
                    INNER JOIN area a ON a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g ON g.id_gerencia=sg.id_gerencia
                    left join domicilio_users d on d.id_usuario=u.id_usuario
                    left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    left join conoci_office co on co.id_usuario=u.id_usuario
                    left join otros_usuario ou on ou.id_usuario=u.id_usuario
                    left join documentacion_usuario du on du.id_usuario=u.id_usuario and du.estado=1
                    left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                    left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                    left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                    left join empresas em on em.id_empresa=u.id_empresapl
                    left join vw_estado_usuario estau on estau.id_estado_usuario=u.estado
                    left join genero ge on ge.id_genero=u.id_genero
                    left join departamento depart on depart.id_departamento=d.id_departamento
                    left join provincia provic on provic.id_provincia=d.id_provincia
                    left join distrito distr on distr.id_distrito=d.id_distrito
                    left join banco banc on banc.id_banco=cb.id_banco
                    left join sistema_pensionario spn on spn.id_sistema_pensionario =sp.id_sistema_pensionario
                    left join afp afp on afp.id_afp  =sp.id_afp
                    left join situacion_laboral situlab on situlab.id_situacion_laboral =u.id_situacion_laboral
                    left join motivo_baja_rrhh mt on u.id_motivo_baja=mt.id_motivo
                    where u.estado in (1) and u.id_nivel<>8 and u.id_gerencia='" . $id_gerencia . "'
                    ORDER BY u.ini_funciones DESC";
        } elseif (isset($dato) && count($dato['list_ajefatura']) > 0 || $id_puesto == "24") {
            $sql = "SELECT u.id_usuario, u.usuario_apater,u.fec_baja,
                    ub.cod_ubi AS centro_labores, td.cod_tipo_documento,
                    td.nom_tipo_documento, u.num_celp,u.num_doc,
                    u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad, u.foto,
                    estau.nom_estado_usuario, ge.nom_genero, depart.nombre_departamento,
                    provic.nombre_provincia, distr.nombre_distrito, banc.nom_banco,
                    spn.cod_sistema_pensionario, afp.nom_afp, banc.nom_banco, cb.num_cuenta_bancaria,
                    u.fec_ingreso, u.fec_termino,em.ruc_empresa,EXTRACT(DAY FROM u.fec_nac) AS dia,
                    case month(u.fec_nac) WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero' WHEN 3 THEN 'Marzo'
                    WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio'
                    WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre'
                    WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre' END mes,u.usuario_email, u.fec_nac,
                    situlab.nom_situacion_laboral,u.ini_funciones,d.nom_via,d.num_via,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                    u.usuario_email, em.nom_empresa, du.dni_doc,date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;' ELSE 'No se pudo determinar la generación'
                    END AS generacion,u.id_puesto
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p ON p.id_puesto=u.id_puesto
                    INNER JOIN area a ON a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g ON g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    left join domicilio_users d on d.id_usuario=u.id_usuario
                    left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    left join conoci_office co on co.id_usuario=u.id_usuario
                    left join otros_usuario ou on ou.id_usuario=u.id_usuario
                    left join documentacion_usuario du on du.id_usuario=u.id_usuario and du.estado=1
                    left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                    left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                    left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                    left join empresas em on em.id_empresa=u.id_empresapl
                    left join vw_estado_usuario estau on estau.id_estado_usuario=u.estado
                    left join genero ge on ge.id_genero=u.id_genero

                    left join departamento depart on depart.id_departamento=d.id_departamento
                    left join provincia provic on provic.id_provincia=d.id_provincia
                    left join distrito distr on distr.id_distrito=d.id_distrito

                    left join banco banc on banc.id_banco=cb.id_banco
                    left join sistema_pensionario spn on spn.id_sistema_pensionario =sp.id_sistema_pensionario
                    left join afp afp on afp.id_afp  =sp.id_afp

                    left join situacion_laboral situlab on situlab.id_situacion_laboral =u.id_situacion_laboral
                    left join motivo_baja_rrhh mt on u.id_motivo_baja=mt.id_motivo
                    where u.estado in (1) and u.id_nivel<>8 and u.id_puesto in " . $dato['cadena'] . "
                    ORDER BY u.ini_funciones DESC";
        } elseif (session('usuario')->visualizar_mi_equipo != "sin_acceso_mi_equipo") {
            $sql = "SELECT u.id_usuario,u.usuario_apater,u.verif_email,ub.cod_ubi AS centro_labores,
                    td.cod_tipo_documento,u.fec_baja,td.nom_tipo_documento,u.num_celp,
                    u.num_doc,u.usuario_amater,u.usuario_nombres,n.nom_nacionalidad,u.foto,
                    estau.nom_estado_usuario,ge.nom_genero,depart.nombre_departamento,
                    provic.nombre_provincia,distr.nombre_distrito,banc.nom_banco,
                    spn.cod_sistema_pensionario,afp.nom_afp,banc.nom_banco,
                    cb.num_cuenta_bancaria,u.fec_ingreso, u.fec_termino,em.ruc_empresa,
                    EXTRACT(DAY FROM u.fec_nac) AS dia,CASE MONTH(u.fec_nac)
                    WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero' WHEN 3 THEN 'Marzo'
                    WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio'
                    WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre'
                    WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre'
                    END mes,u.usuario_email,u.fec_nac,situlab.nom_situacion_laboral,
                    u.ini_funciones,d.nom_via,d.num_via,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area,g.nom_gerencia, p.nom_puesto, c.nom_cargo,u.usuario_email,em.nom_empresa,
                    du.dni_doc,date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,
                    date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;'
                    ELSE 'No se pudo determinar la generación' END AS generacion,u.id_puesto
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p on p.id_puesto=u.id_puesto
                    INNER JOIN area a on a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    LEFT JOIN domicilio_users d ON d.id_usuario=u.id_usuario
                    LEFT JOIN tipo_documento td ON td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n ON n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN conoci_office co ON co.id_usuario=u.id_usuario
                    LEFT JOIN otros_usuario ou ON ou.id_usuario=u.id_usuario
                    LEFT JOIN documentacion_usuario du ON du.id_usuario=u.id_usuario and du.estado=1
                    LEFT JOIN cuenta_bancaria cb ON cb.id_usuario=u.id_usuario
                    LEFT JOIN ropa_usuario ru ON ru.id_usuario=u.id_usuario
                    LEFT JOIN sist_pens_usuario sp ON sp.id_usuario=u.id_usuario
                    LEFT JOIN empresas em ON em.id_empresa=u.id_empresapl
                    LEFT JOIN vw_estado_usuario estau ON estau.id_estado_usuario=u.estado
                    LEFT JOIN genero ge ON ge.id_genero=u.id_genero
                    LEFT JOIN departamento depart ON depart.id_departamento=d.id_departamento
                    LEFT JOIN provincia provic ON provic.id_provincia=d.id_provincia
                    LEFT JOIN distrito distr ON distr.id_distrito=d.id_distrito
                    LEFT JOIN banco banc ON banc.id_banco=cb.id_banco
                    LEFT JOIN sistema_pensionario spn ON spn.id_sistema_pensionario=sp.id_sistema_pensionario
                    LEFT JOIN afp afp ON afp.id_afp  =sp.id_afp
                    LEFT JOIN situacion_laboral situlab ON situlab.id_situacion_laboral =u.id_situacion_laboral
                    LEFT JOIN motivo_baja_rrhh mt ON u.id_motivo_baja=mt.id_motivo
                    WHERE u.estado in (1) and u.id_nivel<>8 and u.id_puesto IN ($visualizar_mi_equipo)
                    ORDER BY u.ini_funciones DESC";
        } elseif (isset($centro_labores) && count($dato['list_ajefatura']) < 1) {
            $sql = "SELECT u.id_usuario, u.usuario_apater, u.verif_email,
                    ub.cod_ubi AS centro_labores, td.cod_tipo_documento,u.fec_baja,
                    td.nom_tipo_documento, u.num_celp,u.num_doc,
                    u.usuario_amater, u.usuario_nombres, n.nom_nacionalidad, u.foto,
                    estau.nom_estado_usuario, ge.nom_genero, depart.nombre_departamento,
                    provic.nombre_provincia, distr.nombre_distrito, banc.nom_banco,
                    spn.cod_sistema_pensionario, afp.nom_afp, banc.nom_banco, cb.num_cuenta_bancaria,
                    u.fec_ingreso, u.fec_termino,em.ruc_empresa,EXTRACT(DAY FROM u.fec_nac) AS dia,
                    case month(u.fec_nac) WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero' WHEN 3 THEN 'Marzo'
                    WHEN 4 THEN 'Abril' WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio'
                    WHEN 8 THEN 'Agosto' WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre'
                    WHEN 11 THEN 'Noviembre' WHEN 12 THEN 'Diciembre' END mes,u.usuario_email, u.fec_nac,
                    situlab.nom_situacion_laboral,u.ini_funciones,d.nom_via,d.num_via,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                    u.usuario_email, em.nom_empresa, du.dni_doc,
                    date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,
                    date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;'
                    ELSE 'No se pudo determinar la generación'
                    END AS generacion,u.id_puesto
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p on p.id_puesto=u.id_puesto
                    INNER JOIN area a on a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    left join domicilio_users d on d.id_usuario=u.id_usuario
                    left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    left join conoci_office co on co.id_usuario=u.id_usuario
                    left join otros_usuario ou on ou.id_usuario=u.id_usuario
                    left join documentacion_usuario du on du.id_usuario=u.id_usuario and du.estado=1
                    left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                    left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                    left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                    left join empresas em on em.id_empresa=u.id_empresapl
                    left join vw_estado_usuario estau on estau.id_estado_usuario=u.estado
                    left join genero ge on ge.id_genero=u.id_genero
                    left join departamento depart on depart.id_departamento=d.id_departamento
                    left join provincia provic on provic.id_provincia=d.id_provincia
                    left join distrito distr on distr.id_distrito=d.id_distrito
                    left join banco banc on banc.id_banco=cb.id_banco
                    left join sistema_pensionario spn on spn.id_sistema_pensionario =sp.id_sistema_pensionario
                    left join afp afp on afp.id_afp  =sp.id_afp
                    left join situacion_laboral situlab on situlab.id_situacion_laboral =u.id_situacion_laboral
                    left join motivo_baja_rrhh mt on u.id_motivo_baja=mt.id_motivo
                    where u.estado in (1) and u.id_nivel<>8 and u.id_centro_labor='" . $centro_labores . "'
                    ORDER BY u.ini_funciones DESC";
        } else {
            $sql = "SELECT u.id_usuario, u.usuario_apater, ub.cod_ubi AS centro_labores,
                    td.cod_tipo_documento,u.fec_baja,u.num_celp,u.num_doc, u.usuario_amater,
                    u.usuario_nombres, n.nom_nacionalidad,u.foto, u.verif_email,
                    EXTRACT(DAY FROM u.fec_nac) AS dia,case month(u.fec_nac)
                    WHEN 1 THEN 'Enero' WHEN 2 THEN  'Febrero' WHEN 3 THEN 'Marzo' WHEN 4 THEN 'Abril'
                    WHEN 5 THEN 'Mayo' WHEN 6 THEN 'Junio' WHEN 7 THEN 'Julio' WHEN 8 THEN 'Agosto'
                    WHEN 9 THEN 'Septiembre' WHEN 10 THEN 'Octubre' WHEN 11 THEN 'Noviembre'
                    WHEN 12 THEN 'Diciembre' END mes,
                    (case when u.usuario_nombres is not null and u.usuario_apater is not null and
                    u.usuario_amater is not null and u.id_nacionalidad is not null and
                    u.id_tipo_documento is not null and u.num_doc is not null and
                    u.id_genero is not null and u.fec_nac is not null and u.id_estado_civil is not null and
                    u.num_celp is not null and u.foto_nombre <>'' and
                    (u.emailp is not null || u.usuario_email is not null) then 1 else 0 end) AS datos_personales,
                    (case when (select count(1) from gusto_preferencia_users
                    where gusto_preferencia_users.id_usuario=u.id_usuario and
                    gusto_preferencia_users.estado=1)>0 then 1 else 0 end) as gustos_preferencias,
                    (case when d.id_departamento is not null and d.id_provincia is not null and
                    d.id_distrito is not null and d.id_tipo_vivienda is not null and
                    d.referencia is not null and d.lat is not null and d.lng is not null
                    then 1 else 0 end) AS domicilio_user,
                    (case when (select count(1) from referencia_familiar
                    where referencia_familiar.id_usuario=u.id_usuario and
                    referencia_familiar.nom_familiar is not null
                    and referencia_familiar.id_parentesco is not null
                    and referencia_familiar.fec_nac is not null and
                    (referencia_familiar.celular1 is not null || referencia_familiar.celular2 is not null ||
                    referencia_familiar.fijo is not null) and referencia_familiar.estado=1)>0
                    then 1 else 0 end) AS referencia,
                    (case when u.hijos=2 or (u.hijos=1 and (select count(1) from hijos
                    where hijos.id_usuario=u.id_usuario AND hijos.nom_hijo IS NOT NULL AND
                    hijos.id_genero IS NOT NULL AND hijos.fec_nac IS NOT NULL AND
                    hijos.num_doc IS NOT NULL AND hijos.id_biologico IS NOT NULL AND
                    hijos.documento IS NOT NULL AND hijos.estado=1)>0) then 1 else 0 end) AS cont_hijos,
                    (case when (select count(1) from contacto_emergencia
                    where contacto_emergencia.id_usuario=u.id_usuario and
                    contacto_emergencia.nom_contacto is not null
                    and contacto_emergencia.id_parentesco is not null
                    and (contacto_emergencia.celular1 is not null ||
                    contacto_emergencia.celular2 is not null ||
                    contacto_emergencia.fijo is not null) and contacto_emergencia.estado=1)>0
                    then 1 else 0 end) AS contactoe,
                    (case when (select count(1) from estudios_generales
                    where estudios_generales.id_usuario=u.id_usuario and
                    estudios_generales.id_grado_instruccion is not null
                    and (estudios_generales.carrera is not null || estudios_generales.centro is not null) and
                    estudios_generales.estado=1)>0 then 1 else 0 end) AS estudiosg,
                    (case when co.nl_excel is not null and
                    co.nl_word is not null and co.nl_ppoint is not null
                    then 1 else 0 end) AS office,
                    (case when (select count(1) from conoci_idiomas
                    where conoci_idiomas.id_usuario=u.id_usuario and conoci_idiomas.estado=1)>0
                    then 1 else 0 end) AS idiomas,
                    (case when (select count(1) from curso_complementario
                    where curso_complementario.id_usuario=u.id_usuario and
                    curso_complementario.estado=1)>0 then 1 else 0 end) AS con_cursos_compl,
                    (case when (select count(1) from experiencia_laboral
                    where experiencia_laboral.id_usuario=u.id_usuario and
                    experiencia_laboral.empresa is not null
                    and experiencia_laboral.cargo is not null and
                    experiencia_laboral.fec_ini is not null
                    and experiencia_laboral.fec_fin is not null and
                    experiencia_laboral.motivo_salida is not null
                    and experiencia_laboral.remuneracion is not null and experiencia_laboral.estado=1)>0
                    then 1 else 0 end) AS experiencial,
                    (case when u.enfermedades=2 or (u.enfermedades=1 and
                    (select count(1) from enfermedad_usuario
                    where enfermedad_usuario.id_usuario=u.id_usuario and enfermedad_usuario.estado=1)>0)
                    then 1 else 0 end) AS cont_enfermedades,
                    (case when u.id_genero=1 or (select count(1) from gestacion_usuario
                    where gestacion_usuario.id_usuario=u.id_usuario and gestacion_usuario.estado=1)>0
                    then 1 else 0 end) AS gestacion,
                    (case when u.alergia=0 then 0 else 1 end) AS cont_alergia,
                    (case when (select count(1) from otros_usuario
                    where otros_usuario.id_usuario=u.id_usuario and otros_usuario.estado=1)>0
                    then 1 else 0 end) AS con_otros,
                    (case when (select count(1) from referencia_convocatoria
                    where referencia_convocatoria.id_usuario=u.id_usuario and
                    referencia_convocatoria.estado=1)>0 then 1 else 0 end) AS ref_convoc,
                    (case when du.cv_doc <>'' and du.dni_doc <>'' and
                    du.recibo_doc <>'' then 1 else 0 end) as documentacion,
                    (case when ru.polo is not null and ru.pantalon is not null and ru.zapato is not null
                    then 1 else 0 end) AS talla_usuario,
                    (case when sp.id_respuestasp is not null then 1 else 0 end) AS sistema_pension,
                    (case when cb.cuenta_bancaria=2 then 1
                    when cb.id_banco is not null and cb.cuenta_bancaria is not null
                    and cb.cuenta_bancaria=1 and cb.num_cuenta_bancaria is not null
                    and cb.num_codigo_interbancario is not null then 1 else 0 end) AS cuenta_bancaria,
                    (case when u.terminos=0 then 0 else 1 end) AS cont_terminos,
                    (case when ou.id_grupo_sanguineo is not null
                    then 1 else 0 end) as grupo_sanguineo,
                    (case when ou.cert_vacu_covid is not null then 1 else 0 end) as covid,
                    a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                    u.usuario_email, em.nom_empresa, du.dni_doc, tp.cod_talla as polo, tc.cod_talla as camisa,
                    tpa.cod_talla as pantalon, tz.cod_talla as zapato,date_format(u.fec_baja,'%d-%m-%Y') as fecha_baja,
                    date_format(u.ini_funciones,'%d-%m-%Y') as fecha_ingreso,
                    mt.nom_motivo,u.doc_baja,u.ini_funciones,
                    CASE WHEN YEAR(u.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                    WHEN YEAR(u.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                    WHEN YEAR(u.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                    WHEN YEAR(u.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                    WHEN YEAR(u.fec_nac) >= 2013 THEN '&alpha;'
                    ELSE 'No se pudo determinar la generación'
                    END AS generacion,u.id_puesto
                    from users u
                    INNER JOIN ubicacion ub ON ub.id_ubicacion=u.id_centro_labor
                    INNER JOIN puesto p on p.id_puesto=u.id_puesto
                    INNER JOIN area a on a.id_area=p.id_area
                    INNER JOIN sub_gerencia sg ON sg.id_sub_gerencia=a.id_departamento
                    INNER JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    left join domicilio_users d on d.id_usuario=u.id_usuario
                    left join tipo_documento td on td.id_tipo_documento=u.id_tipo_documento
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    left join conoci_office co on co.id_usuario=u.id_usuario
                    left join otros_usuario ou on ou.id_usuario=u.id_usuario
                    left join documentacion_usuario du on du.id_usuario=u.id_usuario and du.estado=1
                    left join cuenta_bancaria cb on cb.id_usuario=u.id_usuario
                    left join ropa_usuario ru on ru.id_usuario=u.id_usuario
                    left join sist_pens_usuario sp on sp.id_usuario=u.id_usuario
                    left join empresas em on em.id_empresa=u.id_empresapl
                    left join talla tp on tp.id_talla=ru.polo
                    left join talla tc on tc.id_talla=ru.camisa
                    left join talla tpa on tpa.id_talla=ru.pantalon
                    left join talla tz on tz.id_talla=ru.zapato
                    left join motivo_baja_rrhh mt on u.id_motivo_baja=mt.id_motivo
                    where u.estado in (1) and u.id_nivel<>8
                    ORDER BY u.ini_funciones DESC";
        }

        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    public static function get_list_familiar_postulante($dato = null)
    {
        $sql = "SELECT ub.cod_ubi AS centro_labores,us.num_doc,us.usuario_apater,us.usuario_amater,
                us.usuario_nombres,eu.nom_estado_usuario AS nom_estado,
                CASE WHEN us.fin_funciones IS NOT NULL AND us.fin_funciones NOT LIKE '%0000%' THEN
                DATE_FORMAT(us.fin_funciones,'%d/%m/%Y') ELSE '' END AS fecha_cese
                FROM users us
                INNER JOIN ubicacion ub ON ub.id_ubicacion=us.id_centro_labor
                LEFT JOIN vw_estado_usuario eu ON eu.id_estado_usuario=us.estado
                WHERE us.id_centro_labor IN (SELECT ba.id_ubicacion FROM base ba
                WHERE ba.id_departamento='" . $dato['id_departamento'] . "' AND ba.estado=1) AND
                us.estado IN (1,3) AND (us.usuario_apater='" . $dato['postulante_apater'] . "' OR
                us.usuario_amater='" . $dato['postulante_amater'] . "')";
        $query = DB::select($sql);
        return $query;
    }



    public static function get_list_responsable_area($id_area)
    {
        // Consulta modificada con LEFT JOIN para vincular las tablas puesto y area
        $sql = "SELECT u.*
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a ON a.id_area = p.id_area
                WHERE u.estado = 1 AND a.id_area = :id_area";

        // Ejecutar la consulta utilizando parámetros para prevenir SQL Injection
        $query = DB::select($sql, ['id_area' => $id_area]);

        return $query;
    }
}
