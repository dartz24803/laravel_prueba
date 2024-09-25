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
        'password_desencriptado',
        'id_nivel',
        'usuario_email',
        'id_puesto',
        'centro_labores',
        'acceso',
        'verif_email',
        'documento',
        'id_horario',
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
        u.id_nivel, u.centro_labores, u.emailp, u.num_celp, u.induccion, u.datos_completos,u.id_puesto,u.acceso,
        u.ini_funciones,u.fec_reg,u.usuario_password,u.estado, n.nom_nivel, p.nom_puesto, a.nom_area, u.id_area,
        (SELECT GROUP_CONCAT(puestos) FROM area WHERE estado=1 AND orden!='') AS grupo_puestos,
        CASE WHEN u.urladm=1 THEN (select r.url_config from config r where r.descrip_config='Foto_Postulante'
        and r.estado=1) else (select r.url_config from config r where r.descrip_config='Foto_colaborador'
        and r.estado=1) end as url_foto,p.id_nivel as nivel_jerarquico,u.desvinculacion,u.id_cargo,
        pps.registro_masivo, visualizar_amonestacion(u.id_puesto) AS visualizar_amonestacion,
        sl.descripcion AS sede_laboral
        FROM users u
        LEFT JOIN permiso_papeletas_salida pps ON u.id_puesto=pps.id_puesto_jefe AND pps.estado=1
        LEFT JOIN nivel n ON u.id_nivel=n.id_nivel
        LEFT JOIN puesto p ON u.id_puesto=p.id_puesto
        LEFT JOIN area a ON u.id_area=a.id_area
        LEFT JOIN sede_laboral sl ON p.id_sede_laboral=sl.id
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
            $base = "AND u.centro_labores='$cod_base'";
        }
        $carea = "";
        if (isset($area) && $area > 0) {
            $carea = "AND u.id_area='$area' ";
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
                WHERE u.id_nivel<>8 $base $carea $id_estado";
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
    }

    public function list_usuarios_responsables($dato)
    {
        $sql = "SELECT 	u.id_usuario, u.usuario_nombres, u.usuario_apater, u.usuario_amater, u.usuario_codigo,
                u.id_nivel, u.usuario_email, u.centro_labores, u.emailp, u.num_celp, u.induccion, u.datos_completos,
                u.desvinculacion, u.ini_funciones,u.fec_reg,
                u.usuario_password,u.estado, n.nom_nivel, p.nom_puesto, u.id_area,
                DATE_FORMAT(u.fec_nac, '%M %d,%Y') as fec_nac, u.usuario_codigo,u.id_gerencia,
                u.foto, u.acceso, u.id_puesto, u.id_cargo, u.directorio

                FROM users u
                left join nivel n on n.id_nivel=u.id_nivel
                left join puesto p on p.id_puesto=u.id_puesto

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
                    LEFT JOIN gerencia g on g.id_gerencia=u.id_gerencia
                    LEFT JOIN area a on a.id_area=u.id_area
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    where u.estado=1 and id_usuario =" . $id_usuario;
        } else {
            $sql = "SELECT u.*,  n.nom_nacionalidad, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo
                    from users u
                    LEFT JOIN nacionalidad n on n.id_nacionalidad=u.id_nacionalidad
                    LEFT JOIN gerencia g on g.id_gerencia=u.id_gerencia
                    LEFT JOIN area a on a.id_area=u.id_area
                    LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                    LEFT JOIN cargo c on c.id_cargo=u.id_cargo
                    where u.estado=1 and u.id_nivel<>8";
        }
        $result = DB::select($sql);
        return json_decode(json_encode($result), true);
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
            $sql = "SELECT u.*, p.nom_puesto, m.nom_mes, g.cod_genero, g.nom_genero,a.cod_area,a.nom_area,t.cod_tipo_documento,ge.nom_gerencia,
                    u.usuario_email,(SELECT st.archivo FROM saludo_temporal st
                    WHERE st.id_usuario=u.id_usuario
                    LIMIT 1) AS archivo_saludo
                    FROM users u
                    left join area a on a.id_area=u.id_area
                    left join puesto p on p.id_puesto=u.id_puesto
                    left join mes m on m.id_mes=u.mes_nac
                    left join genero g on g.id_genero=u.id_genero
                    left join tipo_documento t on t.id_tipo_documento=u.id_tipo_documento
                    left join gerencia ge on ge.id_gerencia = u.id_gerencia
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
                LOWER(u.usuario_nombres) AS nombres_min,LOWER(u.usuario_apater) AS apater_min
                FROM users u
                left join saludo_cumpleanio_historial h on h.id_usuario='$id_usuario' and
                h.id_cumpleaniero=u.id_usuario and year(h.fec_reg)='$anio' and h.estado=1
                left join mes m on month(u.fec_nac)=m.cod_mes
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
            $parte_gerencia = "us.id_gerencia=" . $dato['id_gerencia'] . " AND";
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
                LEFT JOIN puesto pu ON us.id_puesto=pu.id_puesto
                LEFT JOIN area ar ON us.id_area=ar.id_area
                WHERE $parte_gerencia us.id_nivel<>8 AND us.estado=3
                ORDER BY us.ini_funciones DESC";
        $query = DB::select($sql);
        return $query;
    }

    public static function perfil_porcentaje($id_usuario){
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
                /*(case when ou.cert_covid is not null then 1 else 0 end) as covid,*/
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
                then 1 else 0 end) as experiencial, a.nom_area, g.nom_gerencia, p.nom_puesto, c.nom_cargo,
                u.usuario_email, em.nom_empresa, du.dni_doc
                from users u
                LEFT JOIN gerencia g on g.id_gerencia=u.id_gerencia
                LEFT JOIN area a on a.id_area=u.id_area
                LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN cargo c on c.id_cargo=u.id_cargo
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
}
