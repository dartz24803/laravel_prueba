<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsistenciaColaborador extends Model
{
    use HasFactory;

    protected $table = 'asistencia_colaborador';

    protected $primaryKey = 'id_asistencia_colaborador';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'centro_labores',
        'id_area',
        'fecha',
        'id_horario',
        'nom_horario',
        'marcacion_entrada',
        'marcacion_idescanso',
        'marcacion_fdescanso',
        'marcacion_salida',
        'obs_marc_entrada',
        'obs_marc_idescanso',
        'obs_marc_fdescanso',
        'obs_marc_salida',
        'con_descanso',
        'dia',
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
        'observacion',
        'flag_diatrabajado',
        'estado_registro',
        'registro',
        'flag_editado',
        'd_dias',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];


    public static function getListAsistenciaColaborador($id_asistencia_colaborador = null, $dato)
    {
        $anio = date('Y');
        $queryParams = [];

        // Si se pasa el id_asistencia_colaborador
        if (isset($id_asistencia_colaborador) && $id_asistencia_colaborador > 0) {
            $sql = "SELECT * FROM asistencia_colaborador
                    WHERE id_asistencia_colaborador = :id_asistencia_colaborador";
            $queryParams['id_asistencia_colaborador'] = $id_asistencia_colaborador;
        } else {
            // Inicializamos la parte dinámica de la consulta
            $conditions = [];
            // Filtramos por fecha
            if ($dato['tipo_fecha'] == "2") {
                $conditions[] = "MONTH(ac.fecha) = :mes AND YEAR(ac.fecha) = :anio";
                $queryParams['mes'] = $dato['mes'];
                $queryParams['anio'] = $anio;
            } else {
                $conditions[] = "ac.fecha = :dia";
                $queryParams['dia'] = $dato['dia'];
            }

            // Filtramos por base
            if ($dato['base'] != "0") {
                $conditions[] = "ac.centro_labores = :base";
                $queryParams['base'] = $dato['base'];
            }

            // Filtramos por área
            if ($dato['area'] != "0") {
                $conditions[] = "ac.id_area = :area";
                $queryParams['area'] = $dato['area'];
            }

            // Filtramos por usuario
            if ($dato['usuario'] != "0") {
                $conditions[] = "ac.id_usuario = :usuario";
                $queryParams['usuario'] = $dato['usuario'];
            }

            // Construimos la consulta final con los filtros
            $sql = "
                SELECT ac.id_asistencia_colaborador,
                    CONCAT(
                        UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), 1, 1)),
                        LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), 2))
                    ) AS colaborador,
                    us.num_doc,
                    ac.centro_labores,
                    DATE_FORMAT(ac.fecha, '%d/%m/%Y') AS fecha,
                    CASE 
                        WHEN ac.con_descanso = 1 THEN CONCAT(
                            DATE_FORMAT(ac.hora_entrada, '%H:%i'), ' - ',
                            DATE_FORMAT(ac.hora_salida, '%H:%i'), ' (',
                            DATE_FORMAT(ac.hora_descanso_e, '%H:%i'), ' - ',
                            DATE_FORMAT(ac.hora_descanso_s, '%H:%i'), ')'
                        )
                        ELSE CONCAT(
                            DATE_FORMAT(ac.hora_entrada, '%H:%i'), ' - ',
                            DATE_FORMAT(ac.hora_salida, '%H:%i')
                        ) 
                    END AS turno,
                    CASE 
                        WHEN ac.estado_registro IN (1, 2) THEN DATE_FORMAT(ac.marcacion_entrada, '%H:%i') 
                        ELSE '-' 
                    END AS marcacion_entrada,
                    CASE 
                        WHEN ac.estado_registro IN (1, 2) THEN 
                            CASE WHEN ac.con_descanso = 1 THEN DATE_FORMAT(ac.marcacion_idescanso, '%H:%i') ELSE '-' END 
                        ELSE '-' 
                    END AS marcacion_idescanso,
                    CASE 
                        WHEN ac.estado_registro IN (1, 2) THEN 
                            CASE WHEN ac.con_descanso = 1 THEN DATE_FORMAT(ac.marcacion_fdescanso, '%H:%i') ELSE '-' END 
                        ELSE '-' 
                    END AS marcacion_fdescanso,
                    CASE 
                        WHEN ac.estado_registro IN (1, 2) THEN DATE_FORMAT(ac.marcacion_salida, '%H:%i') 
                        ELSE '-' 
                    END AS marcacion_salida,
                    CASE 
                        WHEN ac.estado_registro = '1' THEN '#5cb85c' 
                        WHEN ac.estado_registro = '2' THEN '#f0ad4e'
                        WHEN ac.estado_registro = '3' THEN '#d9534f' 
                        WHEN ac.estado_registro = '4' THEN '#5bc0de'
                        WHEN ac.estado_registro = '8' THEN '#292b2c' 
                        WHEN ac.estado_registro = '7' THEN '#59287a'
                        WHEN ac.estado_registro = '9' THEN '#0275d8' 
                        WHEN ac.estado_registro = '10' THEN '#6c757d'
                        WHEN ac.estado_registro = '11' THEN '#a76d46' 
                    END AS bandage,
                    ea.nom_estado,
                    us.usuario_nombres, us.usuario_apater, us.usuario_amater, ac.flag_diatrabajado
                FROM asistencia_colaborador ac
                LEFT JOIN users us ON ac.id_usuario = us.id_usuario
                LEFT JOIN estado_asistencia ea ON ac.estado_registro = ea.id_estado_asistencia
                WHERE " . implode(" AND ", $conditions) . " AND ac.estado = 1
                ORDER BY ac.fecha DESC";
        }

        // Ejecutamos la consulta con los parámetros
        $query = DB::select($sql, $queryParams);

        return $query;
    }

    public static function get_list_base_reg_agente()
    {
        $sql = "SELECT cod_base 
        FROM base 
        WHERE estado = '1' 
        GROUP BY cod_base 
        ORDER BY cod_base ASC";
        $query = DB::select($sql);

        return $query;
    }

    public static function get_list_colaboradort($id_usuario = null, $estado = null)
    {
        if (isset($id_usuario) && $id_usuario > 0) {
            $sql = "SELECT u.*, 
                    n.nom_nacionalidad, 
                    a.nom_area, 
                    g.nom_gerencia, 
                    p.nom_puesto, 
                    c.nom_cargo
                FROM users u
                LEFT JOIN nacionalidad n ON n.id_nacionalidad = u.id_nacionalidad
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a on a.id_area = p.id_area
                LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia = a.id_departamento
                LEFT JOIN gerencia g on g.id_gerencia = sg.id_gerencia
                LEFT JOIN cargo c ON c.id_cargo = u.id_cargo
                WHERE id_usuario = :id_usuario";
            $query = DB::select($sql, ['id_usuario' => $id_usuario]);
        } else {
            $id_estado = "";
            $params = [];
            if (isset($estado) && $estado > 0) {
                if ($estado == 1) {
                    $id_estado = " AND u.estado = :estado";
                    $params['estado'] = $estado; // Agregar el parámetro 'estado'
                } else {
                    $id_estado = " AND u.estado IN (2, 3)";
                }
            }

            $sql = "SELECT u.*, 
                    n.nom_nacionalidad, 
                    a.nom_area, 
                    g.nom_gerencia, 
                    p.nom_puesto, 
                    c.nom_cargo
                FROM users u
                LEFT JOIN nacionalidad n ON n.id_nacionalidad = u.id_nacionalidad
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a on a.id_area = p.id_area
                LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia = a.id_departamento
                LEFT JOIN gerencia g on g.id_gerencia = sg.id_gerencia
                LEFT JOIN cargo c ON c.id_cargo = u.id_cargo
                WHERE u.id_nivel <> 8 $id_estado";

            // Ejecutamos la consulta pasando los parámetros adecuados
            $query = DB::select($sql, $params);
        }

        return $query;
    }


    public static function get_listar_area($id_area = null)
    {
        if (isset($id_area) && $id_area > 0) {
            $sql = "SELECT * FROM area
            WHERE estado = 1 AND id_area = :id_area
            ORDER BY nom_area ASC";
            $query = DB::select($sql, ['id_area' => $id_area]);
        } else {
            $sql = "SELECT * FROM area
            WHERE estado = 1
            ORDER BY nom_area ASC";
            $query = DB::select($sql);
        }

        return $query;
    }

    public static function get_list_gerencia($id_gerencia = null)
    {
        if (isset($id_gerencia) && $id_gerencia > 0) {
            $sql = "SELECT * FROM gerencia
            WHERE estado = '1' AND id_gerencia = :id_gerencia";
            $query = DB::select($sql, ['id_gerencia' => $id_gerencia]);
        } else {
            $sql = "SELECT g.*, d.direccion 
            FROM gerencia g
            LEFT JOIN direccion d ON g.id_direccion = d.id_direccion
            WHERE g.estado = '1'";
            $query = DB::select($sql);
        }

        return $query;
    }


    public static function get_list_nav_evaluaciones()
    {
        $sql = "SELECT GROUP_CONCAT(evaluador) AS evaluadores FROM asignacion_evaluador WHERE estado = 1";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_mes()
    {
        $sql = "SELECT * FROM mes WHERE estado='1' ";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_area($id_gerencia = null, $id_area = null)
    {
        if (isset($id_gerencia) && $id_gerencia > 0 && isset($id_area) && $id_area > 0) {
            $sql = "SELECT t.*, g.nom_gerencia FROM area t
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=t.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    WHERE t.estado='1' and t.id_gerencia=$id_gerencia and t.id_area=$id_area";
        } elseif (isset($id_gerencia) && $id_gerencia > 0) {
            $sql = "SELECT t.*, g.nom_gerencia FROM area t
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=t.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    WHERE t.estado='1' and t.id_gerencia=$id_gerencia";
        } else {
            $sql = "SELECT t.*,g.nom_gerencia FROM area t
                    LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=t.id_departamento
                    LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia
                    WHERE t.estado='1' ";
        }
        //throw new Exception($sql) ;
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_base_general()
    {
        $sql = "SELECT cod_base from base WHERE estado='1' GROUP BY cod_base order by cod_base ASC";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_colaborador_rrhh_xbase($dato)
    {
        // Si id_area no es 0, se agrega la condición de filtro para el área
        $area = "";
        if ($dato['id_area'] != "0") {
            $area = "AND a.id_area = '" . $dato['id_area'] . "'";
        }

        // Consulta SQL con LEFT JOIN y la condición dinámica para el área
        $sql = "SELECT u.* 
                FROM users u
                LEFT JOIN puesto p ON p.id_puesto = u.id_puesto
                LEFT JOIN area a ON a.id_area = p.id_area
                WHERE u.estado = 1 
                  AND u.id_nivel != 8 ";

        // Ejecutar la consulta y obtener los resultados
        $query = DB::select($sql);

        return $query;
    }




    public static  function get_list_semanas($id_semanas = null)
    {
        $anio = date('Y-m-d');
        if (isset($id_semanas) && $id_semanas > 0) {
            $sql = "SELECT a.* FROM semanas a where a.id_semanas='$id_semanas'";
        } else {
            $sql = "SELECT a.* FROM semanas a where a.estado=1 and a.anio='" . $anio . "' ORDER BY id_semanas ASC";
        }

        $query = DB::select($sql);
        // dd($query);
        return $query;
    }

    public static  function get_list_semanas_excel($id_semanas = null)
    {
        $anio = date('Y-m-d');
        if (isset($id_semanas) && $id_semanas > 0) {
            $sql = "SELECT a.* FROM semanas a where a.id_semanas='$id_semanas'";
        } else {
            $sql = "SELECT a.* FROM semanas a where a.estado=1 and a.anio='" . $anio . "'";
        }

        $query = DB::select($sql);
        // dd($query);
        // return $query;
        return json_decode(json_encode($query), true);
    }
    public static  function get_list_notificacion()
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "SELECT n.*,co.mensaje,co.icono,concat_ws(' ',us.usuario_nombres,us.usuario_apater) AS solicitante 
                FROM notificacion n
                LEFT JOIN config co ON co.id_config=n.id_tipo
                LEFT JOIN users us ON us.id_usuario=n.solicitante
                WHERE n.estado=1 AND n.leido=0 AND n.id_usuario=$id_usuario";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_marcacion_colaborador_ausencia($id_asistencia_inconsistencia = null, $dato)
    {
        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            // Si se pasa el id_asistencia_inconsistencia, se arma la consulta para un solo registro
            $sql = "SELECT a.id_asistencia_inconsistencia, a.id_usuario, a.centro_labores,
                            a.id_area, a.fecha, a.id_horario, a.con_descanso, a.dia, a.nom_horario, a.observacion,
                            DATE_FORMAT(a.hora_entrada,'%H:%i') as hora_entrada,
                            (DATE_FORMAT(DATE_ADD(a.hora_entrada,INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                            DATE_FORMAT(a.hora_entrada_desde,'%H:%i') as hora_entrada_desde,
                            DATE_FORMAT(a.hora_entrada_hasta,'%H:%i') as hora_entrada_hasta,
                            DATE_FORMAT(a.hora_salida,'%h:%i') as hora_salida,
                            DATE_FORMAT(a.hora_salida_desde,'%h:%i') as hora_salida_desde,
                            DATE_FORMAT(a.hora_salida_hasta,'%h:%i') as hora_salida_hasta,
                            DATE_FORMAT(a.hora_descanso_e,'%H:%i') as hora_descanso_e,
                            DATE_FORMAT(a.hora_descanso_e_desde,'%H:%i') as hora_descanso_e_desde,
                            DATE_FORMAT(a.hora_descanso_e_hasta,'%H:%i') as hora_descanso_e_hasta,
                            DATE_FORMAT(a.hora_descanso_s,'%H:%i') as hora_descanso_s,
                            DATE_FORMAT(a.hora_descanso_s_desde,'%H:%i') as hora_descanso_s_desde,
                            DATE_FORMAT(a.hora_descanso_s_hasta,'%H:%i') as hora_descanso_s_hasta,
                            a.observacion,
                            a.estado,
                            b.usuario_nombres, b.usuario_apater, b.usuario_amater, b.num_doc,
                            CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),1,1)),
                            LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),2))),' ',
                            CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),1,1)),
                            LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),2)))) AS colaborador,
        
                            CASE WHEN a.con_descanso = 1 THEN 
                            CONCAT(DATE_FORMAT(a.hora_entrada,'%H:%i'),' - ', DATE_FORMAT(a.hora_salida,'%H:%i'),' (',
                            DATE_FORMAT(a.hora_descanso_e,'%H:%i'),' - ', DATE_FORMAT(a.hora_descanso_s,'%H:%i'),')')
                            ELSE CONCAT(DATE_FORMAT(a.hora_entrada,'%H:%i'),' - ', DATE_FORMAT(a.hora_salida,'%H:%i')) 
                            END AS turno
        
                            FROM asistencia_colaborador_inconsistencia a 
                            LEFT JOIN users b ON a.id_usuario=b.id_usuario
                            WHERE a.id_asistencia_inconsistencia='$id_asistencia_inconsistencia' AND a.flag_ausencia=1";
        } else {
            // Verifica si $dato es un array o un objeto
            $fecha = "";
            if (isset($dato['dia'])) {
                $fecha = "ai.fecha='" . $dato['dia'] . "' AND";
            } elseif (isset($dato->dia)) {
                $fecha = "ai.fecha='" . $dato->dia . "' AND";
            }

            // Verifica tipo_fecha
            if (isset($dato['tipo_fecha']) && $dato['tipo_fecha'] == "2") {
                // Verifica que get_semana sea un array de objetos y accede a sus propiedades con '->'
                if (isset($dato['get_semana']) && is_array($dato['get_semana']) && isset($dato['get_semana'][0])) {
                    $fecha = "(ai.fecha BETWEEN '" . $dato['get_semana'][0]->fec_inicio . "' AND '" . $dato['get_semana'][0]->fec_fin . "') AND";
                } elseif (isset($dato->get_semana) && is_array($dato->get_semana) && isset($dato->get_semana[0])) {
                    $fecha = "(ai.fecha BETWEEN '" . $dato->get_semana[0]->fec_inicio . "' AND '" . $dato->get_semana[0]->fec_fin . "') AND";
                }
            }

            $base = "";
            if (isset($dato['base']) && $dato['base'] != "0") {
                $base = "ai.centro_labores='" . $dato['base'] . "' AND";
            }

            $area = "";
            if (isset($dato['area']) && $dato['area'] != "0") {
                $area = "ai.id_area='" . $dato['area'] . "' AND";
            }

            $usuario = "";
            if (isset($dato['usuario']) && $dato['usuario'] != "0") {
                $usuario = "ai.id_usuario='" . $dato['usuario'] . "' AND";
            }

            // Construcción de la consulta
            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc, ai.centro_labores, DATE_FORMAT(ai.fecha, '%d/%m/%Y') AS fecha,
                    CASE WHEN ai.con_descanso=1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i'), ' (', DATE_FORMAT(ai.hora_descanso_e, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_descanso_s, '%H:%i'), ')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i')) END AS turno
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario=us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia=1 AND ai.estado=1";
        }

        // Ejecutar la consulta
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_marcacion_colaborador_ausencia_2($id_asistencia_inconsistencia = null, $dato)
    {

        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            // Si se pasa el id_asistencia_inconsistencia, se arma la consulta para un solo registro
            $sql = "SELECT a.id_asistencia_inconsistencia, a.id_usuario, a.centro_labores,
                            a.id_area, a.fecha, a.id_horario, a.con_descanso, a.dia, a.nom_horario, a.observacion,
                            DATE_FORMAT(a.hora_entrada,'%H:%i') as hora_entrada,
                            (DATE_FORMAT(DATE_ADD(a.hora_entrada,INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                            DATE_FORMAT(a.hora_entrada_desde,'%H:%i') as hora_entrada_desde,
                            DATE_FORMAT(a.hora_entrada_hasta,'%H:%i') as hora_entrada_hasta,
                            DATE_FORMAT(a.hora_salida,'%h:%i') as hora_salida,
                            DATE_FORMAT(a.hora_salida_desde,'%h:%i') as hora_salida_desde,
                            DATE_FORMAT(a.hora_salida_hasta,'%h:%i') as hora_salida_hasta,
                            DATE_FORMAT(a.hora_descanso_e,'%H:%i') as hora_descanso_e,
                            DATE_FORMAT(a.hora_descanso_e_desde,'%H:%i') as hora_descanso_e_desde,
                            DATE_FORMAT(a.hora_descanso_e_hasta,'%H:%i') as hora_descanso_e_hasta,
                            DATE_FORMAT(a.hora_descanso_s,'%H:%i') as hora_descanso_s,
                            DATE_FORMAT(a.hora_descanso_s_desde,'%H:%i') as hora_descanso_s_desde,
                            DATE_FORMAT(a.hora_descanso_s_hasta,'%H:%i') as hora_descanso_s_hasta,
                            a.observacion,
                            a.estado,
                            b.usuario_nombres, b.usuario_apater, b.usuario_amater, b.num_doc,
                            CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),1,1)),
                            LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),2))),' ',
                            CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),1,1)),
                            LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),2)))) AS colaborador,
        
                            CASE WHEN a.con_descanso = 1 THEN 
                            CONCAT(DATE_FORMAT(a.hora_entrada,'%H:%i'),' - ', DATE_FORMAT(a.hora_salida,'%H:%i'),' (',
                            DATE_FORMAT(a.hora_descanso_e,'%H:%i'),' - ', DATE_FORMAT(a.hora_descanso_s,'%H:%i'),')')
                            ELSE CONCAT(DATE_FORMAT(a.hora_entrada,'%H:%i'),' - ', DATE_FORMAT(a.hora_salida,'%H:%i')) 
                            END AS turno
        
                            FROM asistencia_colaborador_inconsistencia a 
                            LEFT JOIN users b ON a.id_usuario=b.id_usuario
                            WHERE a.id_asistencia_inconsistencia='$id_asistencia_inconsistencia' AND a.flag_ausencia=1";
        } else {
            // Verifica si $dato es un array o un objeto
            $fecha = "";
            if (isset($dato['dia'])) {
                $fecha = "ai.fecha='" . $dato['dia'] . "' AND";
            } elseif (isset($dato->dia)) {
                $fecha = "ai.fecha='" . $dato->dia . "' AND";
            }

            // Verifica tipo_fecha
            if (isset($dato['tipo_fecha']) && $dato['tipo_fecha'] == "2") {
                // Verifica que get_semana sea un array de objetos y accede a sus propiedades con '->'
                if (isset($dato['get_semana']) && is_array($dato['get_semana']) && isset($dato['get_semana'][0])) {
                    $fecha = "(ai.fecha BETWEEN '" . $dato['get_semana'][0]->fec_inicio . "' AND '" . $dato['get_semana'][0]->fec_fin . "') AND";
                } elseif (isset($dato->get_semana) && is_array($dato->get_semana) && isset($dato->get_semana[0])) {
                    $fecha = "(ai.fecha BETWEEN '" . $dato->get_semana[0]->fec_inicio . "' AND '" . $dato->get_semana[0]->fec_fin . "') AND";
                }
            }

            $base = "";
            if (isset($dato['base']) && $dato['base'] != "0") {
                $base = "ai.centro_labores='" . $dato['base'] . "' AND";
            }

            $area = "";
            if (isset($dato['area']) && $dato['area'] != "0") {
                $area = "ai.id_area='" . $dato['area'] . "' AND";
            }

            $usuario = "";
            if (isset($dato['usuario']) && $dato['usuario'] != "0") {
                $usuario = "ai.id_usuario='" . $dato['usuario'] . "' AND";
            }

            // Construcción de la consulta
            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc, ai.centro_labores, DATE_FORMAT(ai.fecha, '%d/%m/%Y') AS fecha,
                    CASE WHEN ai.con_descanso=1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i'), ' (', DATE_FORMAT(ai.hora_descanso_e, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_descanso_s, '%H:%i'), ')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i')) END AS turno
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario=us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia=1 AND ai.estado=1";
        }

        // Ejecutar la consulta
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }

    public static function get_list_tardanza($dato)
    {
        if ($dato['tipo_fecha'] == 1) {
            $parte_fecha = "vm.fecha='" . $dato['dia'] . "' AND";
        } else if ($dato['tipo_fecha'] == "2") {
            $parte_fecha = "YEAR(vm.fecha)='" . date('Y') . "' AND MONTH(vm.fecha)='" . $dato['mes'] . "' AND";
        } else if ($dato['tipo_fecha'] == 3) {
            $parte_fecha = "(vm.fecha BETWEEN '" . $dato['get_semana'][0]->fec_inicio . "' AND '" . $dato['get_semana'][0]->fec_fin . "') AND";
        }

        $parte_base = "";
        if ($dato['base'] != "0") {
            $parte_base = "ub.cod_ubi='" . $dato['base'] . "' AND";
        }
        $parte_area = "";
        if ($dato['area'] != "0") {
            $parte_area = "pu.id_area='" . $dato['area'] . "' AND";
        }
        $parte_usuario = "";
        if ($dato['usuario'] != "0") {
            $parte_usuario = "vm.emp_code=" . $dato['usuario'] . " AND";
        }
        $sql = "SELECT LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater)) AS colaborador,
                us.centro_labores AS base,LOWER(pu.nom_puesto) AS puesto,vm.emp_code AS dni,
                DATE_FORMAT(vm.fecha,'%d/%m/%Y') AS fecha,
                DATE_FORMAT(hd.hora_entrada,'%H:%i') AS hora_inicio_turno,vm.hora_llegada,
                FLOOR(TIME_TO_SEC(TIMEDIFF(vm.hora_llegada, hd.hora_entrada))/60) AS minutos_atraso
                FROM vista_marcacion_minima vm
                INNER JOIN lanumerouno.users us ON vm.emp_code=us.num_doc
                INNER JOIN lanumerouno.ubicacion ub ON ub.id_ubicacion=us.id_centro_labor
                INNER JOIN lanumerouno.puesto pu ON us.id_puesto=pu.id_puesto
                LEFT JOIN lanumerouno.horario_dia hd ON us.id_horario=hd.id_horario AND 
                hd.id_turno>0 AND (WEEKDAY(vm.fecha)+1)=hd.dia
                WHERE $parte_fecha $parte_base $parte_area $parte_usuario us.estado=1 AND 
                hd.estado=1 AND FLOOR(TIME_TO_SEC(TIMEDIFF(vm.hora_llegada, hd.hora_entrada))/60)>0";
        $query = DB::connection('second_mysql')->select($sql);
        return $query;
        // return json_decode(json_encode($query), true);
    }


    public static function get_list_tardanza_excel($dato)
    {
        if ($dato['tipo_fecha'] == 1) {
            $parte_fecha = "vm.fecha='" . $dato['dia'] . "' AND";
        } else if ($dato['tipo_fecha'] == "2") {
            $parte_fecha = "YEAR(vm.fecha)='" . date('Y') . "' AND MONTH(vm.fecha)='" . $dato['mes'] . "' AND";
        } else if ($dato['tipo_fecha'] == 3) {
            $parte_fecha = "(vm.fecha BETWEEN '" . $dato['get_semana'][0]->fec_inicio . "' AND '" . $dato['get_semana'][0]->fec_fin . "') AND";
        }

        $parte_base = "";
        if ($dato['base'] != "0") {
            $parte_base = "ub.cod_ubi='" . $dato['base'] . "' AND";
        }
        $parte_area = "";
        if ($dato['area'] != "0") {
            $parte_area = "pu.id_area='" . $dato['area'] . "' AND";
        }
        $parte_usuario = "";
        if ($dato['usuario'] != "0") {
            $parte_usuario = "vm.emp_code=" . $dato['usuario'] . " AND";
        }
        $sql = "SELECT LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater)) AS colaborador,
                us.centro_labores AS base,LOWER(pu.nom_puesto) AS puesto,vm.emp_code AS dni,
                DATE_FORMAT(vm.fecha,'%d/%m/%Y') AS fecha,
                DATE_FORMAT(hd.hora_entrada,'%H:%i') AS hora_inicio_turno,vm.hora_llegada,
                FLOOR(TIME_TO_SEC(TIMEDIFF(vm.hora_llegada, hd.hora_entrada))/60) AS minutos_atraso
                FROM vista_marcacion_minima vm
                INNER JOIN lanumerouno.users us ON vm.emp_code=us.num_doc
                INNER JOIN lanumerouno.ubicacion ub ON ub.id_ubicacion=us.id_centro_labor
                INNER JOIN lanumerouno.puesto pu ON us.id_puesto=pu.id_puesto
                LEFT JOIN lanumerouno.horario_dia hd ON us.id_horario=hd.id_horario AND 
                hd.id_turno>0 AND (WEEKDAY(vm.fecha)+1)=hd.dia
                WHERE $parte_fecha $parte_base $parte_area $parte_usuario us.estado=1 AND 
                hd.estado=1 AND FLOOR(TIME_TO_SEC(TIMEDIFF(vm.hora_llegada, hd.hora_entrada))/60)>0";
        $query = DB::connection('second_mysql')->select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }


    public static function get_list_dotacion($fecha)
    {
        $sql = "SELECT 
                    CASE 
                        WHEN COALESCE(us.centro_labores, '1') LIKE 'B%' THEN CONCAT('ZZZ', COALESCE(us.centro_labores, '1')) 
                        ELSE COALESCE(us.centro_labores, '1') 
                    END AS orden,
                    COALESCE(us.centro_labores, '1') AS centro_labores,
                    COUNT(*) AS dotacion,
                    COUNT(DISTINCT presentes.emp_code) AS presentes,
                    COUNT(*) - COUNT(DISTINCT presentes.emp_code) AS ausentes,
                    CONCAT(ROUND((COUNT(DISTINCT presentes.emp_code) * 100 / COUNT(*)), 1), '%') AS porcentaje_asistencia,
                    MIN(presentes.punch_time_formatted) AS hora_apertura,
                    CASE 
                        WHEN COUNT(*) = COUNT(DISTINCT presentes.emp_code) THEN 'Todos marcaron' 
                        ELSE 'Faltan marcas' 
                    END AS nom_estado
                FROM 
                    users us
                LEFT JOIN horario_dia hd 
                    ON us.id_horario = hd.id_horario 
                    AND hd.estado = 1
                    AND (WEEKDAY(?) + 1) = hd.dia
                    AND hd.id_turno > 0
                LEFT JOIN (
                    SELECT 
                        bi.emp_code,
                        DATE_FORMAT(MIN(bi.punch_time), '%H:%i') AS punch_time_formatted
                    FROM 
                        zkbiotime.iclock_transaction bi
                    WHERE 
                        DATE(bi.punch_time) = ?
                    GROUP BY 
                        bi.emp_code
                ) AS presentes 
                    ON presentes.emp_code = us.num_doc
                WHERE 
                    us.estado = 1
                GROUP BY 
                    orden, centro_labores
                ORDER BY 
                    orden ASC;
                ";

        $query = DB::select($sql, [$fecha, $fecha]);
        return $query;
    }





    public static function get_list_marcacion_colaborador_inconsistencias_2($id_asistencia_inconsistencia = null, $dato)
    {
        // dd($dato);
        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            $sql = "SELECT a.id_asistencia_inconsistencia,a.id_usuario,a.centro_labores,
                    a.id_area,a.fecha,a.id_horario,a.con_descanso,a.dia,a.nom_horario,a.observacion,a.id_turno,
                    DATE_FORMAT(a.hora_entrada,'%H:%i') as hora_entrada,
                    (DATE_FORMAT(DATE_ADD(a.hora_entrada,INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                    DATE_FORMAT(a.hora_entrada_desde,'%H:%i') as hora_entrada_desde,
                    DATE_FORMAT(a.hora_entrada_hasta,'%H:%i') as hora_entrada_hasta,
                    DATE_FORMAT(a.hora_salida,'%H:%i') as hora_salida,
                    DATE_FORMAT(a.hora_salida_desde,'%H:%i') as hora_salida_desde,
                    DATE_FORMAT(a.hora_salida_hasta,'%H:%i') as hora_salida_hasta,
                    DATE_FORMAT(a.hora_descanso_e,'%H:%i') as hora_descanso_e,
                    DATE_FORMAT(a.hora_descanso_e_desde,'%H:%i') as hora_descanso_e_desde,
                    DATE_FORMAT(a.hora_descanso_e_hasta,'%H:%i') as hora_descanso_e_hasta,
                    DATE_FORMAT(a.hora_descanso_s,'%H:%i') as hora_descanso_s,
                    DATE_FORMAT(a.hora_descanso_s_desde,'%H:%i') as hora_descanso_s_desde,
                    DATE_FORMAT(a.hora_descanso_s_hasta,'%H:%i') as hora_descanso_s_hasta,
                    a.observacion,a.estado,b.usuario_nombres,b.usuario_apater,b.usuario_amater,b.num_doc,b.centro_labores,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),2)))) AS colaborador,
                    case when a.tipo_inconsistencia=3 then 'Sin Turno' 
                    else (
                        case when 
                        a.con_descanso=1 then 
                        concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i'),' (',date_format(a.hora_descanso_e,'%H:%i'),' - ',date_format(a.hora_descanso_s,'%H:%i'),')')
                        else concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i')) end
                    ) end as turno
                    FROM asistencia_colaborador_inconsistencia a 
                    left join users b on a.id_usuario=b.id_usuario
                    where a.id_asistencia_inconsistencia='$id_asistencia_inconsistencia' and a.flag_ausencia=0";
        } else {
            $fecha = "ai.fecha='" . $dato->dia . "' AND";
            if ($dato->tipo_fecha == "2") {
                $fecha = "(ai.fecha BETWEEN '" . $dato->get_semana[0]->fec_inicio . "' AND '" . $dato->get_semana[0]->fec_fin . "') AND";
            }

            $base = "";
            if ($dato->base != "0") {
                $base = "ai.centro_labores='" . $dato->base . "' AND";
            }

            $area = "";
            if ($dato->area != "0") {
                $area = "ai.id_area='" . $dato->area . "' AND";
            }

            $usuario = "";
            if ($dato->usuario != "0") {
                $usuario = "ai.id_usuario='" . $dato->usuario . "' AND";
            }


            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc,ai.centro_labores,DATE_FORMAT(ai.fecha,'%d/%m/%Y') AS fecha,
                    CASE WHEN ai.tipo_inconsistencia=3 THEN 'Sin Turno'
                    ELSE (CASE WHEN ai.con_descanso=1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i'),' (',DATE_FORMAT(ai.hora_descanso_e,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_descanso_s,'%H:%i'),')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i')) END) END AS turno,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=1 AND 
                    am.visible=1 AND am.estado=1) AS entrada,ai.tipo_inconsistencia,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=2 AND 
                    am.visible=1 AND am.estado=1) AS salidaarefrigerio,ai.con_descanso,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=3 AND 
                    am.visible=1 AND am.estado=1) AS entradaderefrigerio,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=4 AND 
                    am.visible=1 AND am.estado=1) AS salida,us.usuario_nombres,us.usuario_apater,us.usuario_amater
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario=us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia=0 AND ai.estado=1";
        }
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }

    public static function get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia = null, $dato)
    {
        // dd($dato);
        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            $sql = "SELECT a.id_asistencia_inconsistencia,a.id_usuario,a.centro_labores,
                    a.id_area,a.fecha,a.id_horario,a.con_descanso,a.dia,a.nom_horario,a.observacion,a.id_turno,
                    DATE_FORMAT(a.hora_entrada,'%H:%i') as hora_entrada,
                    (DATE_FORMAT(DATE_ADD(a.hora_entrada,INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                    DATE_FORMAT(a.hora_entrada_desde,'%H:%i') as hora_entrada_desde,
                    DATE_FORMAT(a.hora_entrada_hasta,'%H:%i') as hora_entrada_hasta,
                    DATE_FORMAT(a.hora_salida,'%H:%i') as hora_salida,
                    DATE_FORMAT(a.hora_salida_desde,'%H:%i') as hora_salida_desde,
                    DATE_FORMAT(a.hora_salida_hasta,'%H:%i') as hora_salida_hasta,
                    DATE_FORMAT(a.hora_descanso_e,'%H:%i') as hora_descanso_e,
                    DATE_FORMAT(a.hora_descanso_e_desde,'%H:%i') as hora_descanso_e_desde,
                    DATE_FORMAT(a.hora_descanso_e_hasta,'%H:%i') as hora_descanso_e_hasta,
                    DATE_FORMAT(a.hora_descanso_s,'%H:%i') as hora_descanso_s,
                    DATE_FORMAT(a.hora_descanso_s_desde,'%H:%i') as hora_descanso_s_desde,
                    DATE_FORMAT(a.hora_descanso_s_hasta,'%H:%i') as hora_descanso_s_hasta,
                    a.observacion,a.estado,b.usuario_nombres,b.usuario_apater,b.usuario_amater,b.num_doc,b.centro_labores,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),2)))) AS colaborador,
                    case when a.tipo_inconsistencia=3 then 'Sin Turno' 
                    else (
                        case when 
                        a.con_descanso=1 then 
                        concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i'),' (',date_format(a.hora_descanso_e,'%H:%i'),' - ',date_format(a.hora_descanso_s,'%H:%i'),')')
                        else concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i')) end
                    ) end as turno
                    FROM asistencia_colaborador_inconsistencia a 
                    left join users b on a.id_usuario=b.id_usuario
                    where a.id_asistencia_inconsistencia='$id_asistencia_inconsistencia' and a.flag_ausencia=0";
        } else {
            $fecha = "ai.fecha='" . $dato->dia . "' AND";
            if ($dato->tipo_fecha == "2") {
                $fecha = "(ai.fecha BETWEEN '" . $dato->get_semana[0]->fec_inicio . "' AND '" . $dato->get_semana[0]->fec_fin . "') AND";
            }

            $base = "";
            if ($dato->base != "0") {
                $base = "ai.centro_labores='" . $dato->base . "' AND";
            }

            $area = "";
            if ($dato->area != "0") {
                $area = "ai.id_area='" . $dato->area . "' AND";
            }

            $usuario = "";
            if ($dato->usuario != "0") {
                $usuario = "ai.id_usuario='" . $dato->usuario . "' AND";
            }


            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc,ai.centro_labores,DATE_FORMAT(ai.fecha,'%d/%m/%Y') AS fecha,
                    CASE WHEN ai.tipo_inconsistencia=3 THEN 'Sin Turno'
                    ELSE (CASE WHEN ai.con_descanso=1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i'),' (',DATE_FORMAT(ai.hora_descanso_e,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_descanso_s,'%H:%i'),')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i')) END) END AS turno,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=1 AND 
                    am.visible=1 AND am.estado=1) AS entrada,ai.tipo_inconsistencia,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=2 AND 
                    am.visible=1 AND am.estado=1) AS salidaarefrigerio,ai.con_descanso,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=3 AND 
                    am.visible=1 AND am.estado=1) AS entradaderefrigerio,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=4 AND 
                    am.visible=1 AND am.estado=1) AS salida,us.usuario_nombres,us.usuario_apater,us.usuario_amater
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario=us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia=0 AND ai.estado=1";
        }
        $query = DB::select($sql);
        return $query;
        // return json_decode(json_encode($query), true);
    }


    public static function get_list_marcacion_colaborador_inconsistencias_excel($id_asistencia_inconsistencia = null, $dato)
    {
        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            $sql = "SELECT a.id_asistencia_inconsistencia, a.id_usuario, a.centro_labores,
                    a.id_area, a.fecha, a.id_horario, a.con_descanso, a.dia, a.nom_horario, a.observacion, a.id_turno,
                    DATE_FORMAT(a.hora_entrada, '%H:%i') as hora_entrada,
                    (DATE_FORMAT(DATE_ADD(a.hora_entrada, INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                    DATE_FORMAT(a.hora_entrada_desde, '%H:%i') as hora_entrada_desde,
                    DATE_FORMAT(a.hora_entrada_hasta, '%H:%i') as hora_entrada_hasta,
                    DATE_FORMAT(a.hora_salida, '%H:%i') as hora_salida,
                    DATE_FORMAT(a.hora_salida_desde, '%H:%i') as hora_salida_desde,
                    DATE_FORMAT(a.hora_salida_hasta, '%H:%i') as hora_salida_hasta,
                    DATE_FORMAT(a.hora_descanso_e, '%H:%i') as hora_descanso_e,
                    DATE_FORMAT(a.hora_descanso_e_desde, '%H:%i') as hora_descanso_e_desde,
                    DATE_FORMAT(a.hora_descanso_e_hasta, '%H:%i') as hora_descanso_e_hasta,
                    DATE_FORMAT(a.hora_descanso_s, '%H:%i') as hora_descanso_s,
                    DATE_FORMAT(a.hora_descanso_s_desde, '%H:%i') as hora_descanso_s_desde,
                    DATE_FORMAT(a.hora_descanso_s_hasta, '%H:%i') as hora_descanso_s_hasta,
                    a.observacion, a.estado, b.usuario_nombres, b.usuario_apater, b.usuario_amater, b.num_doc, b.centro_labores,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres, ' ', 1), 1, 1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres, ' ', 1), 2))), ' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater, ' ', 1), 1, 1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater, ' ', 1), 2)))) AS colaborador,
                    CASE WHEN a.tipo_inconsistencia = 3 THEN 'Sin Turno' 
                    ELSE (
                        CASE WHEN 
                        a.con_descanso = 1 THEN 
                        CONCAT(DATE_FORMAT(a.hora_entrada, '%H:%i'), ' - ', DATE_FORMAT(a.hora_salida, '%H:%i'), ' (', DATE_FORMAT(a.hora_descanso_e, '%H:%i'), ' - ', DATE_FORMAT(a.hora_descanso_s, '%H:%i'), ')')
                        ELSE CONCAT(DATE_FORMAT(a.hora_entrada, '%H:%i'), ' - ', DATE_FORMAT(a.hora_salida, '%H:%i')) END
                    ) END AS turno
                    FROM asistencia_colaborador_inconsistencia a 
                    LEFT JOIN users b ON a.id_usuario = b.id_usuario
                    WHERE a.id_asistencia_inconsistencia = '$id_asistencia_inconsistencia' AND a.flag_ausencia = 0";
        } else {

            $fecha = "ai.fecha='" . $dato['dia'] . "' AND";


            if ($dato['tipo_fecha'] == "2") {
                $fecha = "(ai.fecha BETWEEN '" . $dato['get_semana'][0]['fec_inicio'] . "' AND '" . $dato['get_semana'][0]['fec_fin'] . "') AND";
            }
            // dd($dato['dia']);
            $base = "";
            if ($dato['base'] != "0") {
                $base = "ai.centro_labores='" . $dato['base'] . "' AND";
            }

            $area = "";
            if ($dato['area'] != "0") {
                $area = "ai.id_area='" . $dato['area'] . "' AND";
            }

            $usuario = "";
            if ($dato['usuario'] != "0") {
                $usuario = "ai.id_usuario='" . $dato['usuario'] . "' AND";
            }

            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), 1, 1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), 2))), ' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater, ' ', 1), 1, 1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater, ' ', 1), 2)))) AS colaborador,
                    us.num_doc, ai.centro_labores, DATE_FORMAT(ai.fecha, '%d/%m/%Y') AS fecha,
                    CASE WHEN ai.tipo_inconsistencia = 3 THEN 'Sin Turno'
                    ELSE (CASE WHEN ai.con_descanso = 1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i'), ' (', DATE_FORMAT(ai.hora_descanso_e, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_descanso_s, '%H:%i'), ')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada, '%H:%i'), ' - ',
                    DATE_FORMAT(ai.hora_salida, '%H:%i')) END) END AS turno,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion, '%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion = 1 AND 
                    am.visible = 1 AND am.estado = 1) AS entrada, ai.tipo_inconsistencia,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion, '%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion = 2 AND 
                    am.visible = 1 AND am.estado = 1) AS salidaarefrigerio, ai.con_descanso,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion, '%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion = 3 AND 
                    am.visible = 1 AND am.estado = 1) AS entradaderefrigerio,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion, '%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion = 4 AND 
                    am.visible = 1 AND am.estado = 1) AS salida, us.usuario_nombres, us.usuario_apater, us.usuario_amater
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario = us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia = 0 AND ai.estado = 1";
        }

        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }



    public static function get_list_marcacion_colaborador_inconsistencias_json($id_asistencia_inconsistencia = null, $dato)
    {
        // dd($dato);
        if (isset($id_asistencia_inconsistencia) && $id_asistencia_inconsistencia > 0) {
            $sql = "SELECT a.id_asistencia_inconsistencia,a.id_usuario,a.centro_labores,
                    a.id_area,a.fecha,a.id_horario,a.con_descanso,a.dia,a.nom_horario,a.observacion,a.id_turno,
                    DATE_FORMAT(a.hora_entrada,'%H:%i') as hora_entrada,
                    (DATE_FORMAT(DATE_ADD(a.hora_entrada,INTERVAL 1 MINUTE), '%H:%i:%s')) as max_hora_entrada,
                    DATE_FORMAT(a.hora_entrada_desde,'%H:%i') as hora_entrada_desde,
                    DATE_FORMAT(a.hora_entrada_hasta,'%H:%i') as hora_entrada_hasta,
                    DATE_FORMAT(a.hora_salida,'%H:%i') as hora_salida,
                    DATE_FORMAT(a.hora_salida_desde,'%H:%i') as hora_salida_desde,
                    DATE_FORMAT(a.hora_salida_hasta,'%H:%i') as hora_salida_hasta,
                    DATE_FORMAT(a.hora_descanso_e,'%H:%i') as hora_descanso_e,
                    DATE_FORMAT(a.hora_descanso_e_desde,'%H:%i') as hora_descanso_e_desde,
                    DATE_FORMAT(a.hora_descanso_e_hasta,'%H:%i') as hora_descanso_e_hasta,
                    DATE_FORMAT(a.hora_descanso_s,'%H:%i') as hora_descanso_s,
                    DATE_FORMAT(a.hora_descanso_s_desde,'%H:%i') as hora_descanso_s_desde,
                    DATE_FORMAT(a.hora_descanso_s_hasta,'%H:%i') as hora_descanso_s_hasta,
                    a.observacion,a.estado,b.usuario_nombres,b.usuario_apater,b.usuario_amater,b.num_doc,b.centro_labores,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(b.usuario_apater,' ',1),2)))) AS colaborador,
                    case when a.tipo_inconsistencia=3 then 'Sin Turno' 
                    else (
                        case when 
                        a.con_descanso=1 then 
                        concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i'),' (',date_format(a.hora_descanso_e,'%H:%i'),' - ',date_format(a.hora_descanso_s,'%H:%i'),')')
                        else concat(date_format(a.hora_entrada,'%H:%i'),' - ',date_format(a.hora_salida,'%H:%i')) end
                    ) end as turno
                    FROM asistencia_colaborador_inconsistencia a 
                    left join users b on a.id_usuario=b.id_usuario
                    where a.id_asistencia_inconsistencia='$id_asistencia_inconsistencia' and a.flag_ausencia=0";
        } else {
            $fecha = "ai.fecha='" . $dato->dia . "' AND";
            if ($dato->tipo_fecha == "2") {
                $fecha = "(ai.fecha BETWEEN '" . $dato->get_semana[0]->fec_inicio . "' AND '" . $dato->get_semana[0]->fec_fin . "') AND";
            }

            $base = "";
            if ($dato->base != "0") {
                $base = "ai.centro_labores='" . $dato->base . "' AND";
            }

            $area = "";
            if ($dato->area != "0") {
                $area = "ai.id_area='" . $dato->area . "' AND";
            }

            $usuario = "";
            if ($dato->usuario != "0") {
                $usuario = "ai.id_usuario='" . $dato->usuario . "' AND";
            }


            $sql = "SELECT ai.id_asistencia_inconsistencia,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc,ai.centro_labores,DATE_FORMAT(ai.fecha,'%d/%m/%Y') AS fecha,
                    CASE WHEN ai.tipo_inconsistencia=3 THEN 'Sin Turno'
                    ELSE (CASE WHEN ai.con_descanso=1 THEN CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i'),' (',DATE_FORMAT(ai.hora_descanso_e,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_descanso_s,'%H:%i'),')') ELSE CONCAT(DATE_FORMAT(ai.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ai.hora_salida,'%H:%i')) END) END AS turno,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=1 AND 
                    am.visible=1 AND am.estado=1) AS entrada,ai.tipo_inconsistencia,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=2 AND 
                    am.visible=1 AND am.estado=1) AS salidaarefrigerio,ai.con_descanso,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=3 AND 
                    am.visible=1 AND am.estado=1) AS entradaderefrigerio,
                    (SELECT GROUP_CONCAT(DATE_FORMAT(am.marcacion,'%H:%i') SEPARATOR ', ') 
                    FROM asistencia_colaborador_marcaciones am
                    WHERE am.id_asistencia_inconsistencia = ai.id_asistencia_inconsistencia AND am.tipo_marcacion=4 AND 
                    am.visible=1 AND am.estado=1) AS salida,us.usuario_nombres,us.usuario_apater,us.usuario_amater
                    FROM asistencia_colaborador_inconsistencia ai
                    LEFT JOIN users us ON ai.id_usuario=us.id_usuario
                    WHERE $fecha $base $area $usuario ai.flag_ausencia=0 AND ai.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
        // return json_decode(json_encode($query), true);
    }

    public static function get_list_detalle_marcacion_inconsistencia($dato)
    {
        $sql = "SELECT a.id_asistencia_detalle,a.id_asistencia_inconsistencia,
        a.marcacion,a.obs_marcacion,a.tipo_marcacion,a.visible
        from asistencia_colaborador_marcaciones a 
        where a.id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "' and a.estado=1 order by a.marcacion asc";
        $query = DB::select($sql);
        return $query;
        // return json_decode(json_encode($query), true);
    }

    public static function get_list_detalle_marcacion_inconsistencia_2($dato)
    {
        $sql = "SELECT a.id_asistencia_detalle,a.id_asistencia_inconsistencia,
        a.marcacion,a.obs_marcacion,a.tipo_marcacion,a.visible
        from asistencia_colaborador_marcaciones a 
        where a.id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "' and a.estado=1 order by a.marcacion asc";
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }



    public static function insert_asistencia_inconsistencia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        $sql = "INSERT INTO asistencia_colaborador_marcaciones (
            marcacion,obs_marcacion,id_asistencia_inconsistencia,tipo_marcacion,visible,estado,user_reg,fec_reg)
            values ('" . $dato['marcacion'] . "','" . $dato['obs_marcacion'] . "',
            '" . $dato['id_asistencia_inconsistencia'] . "','" . $dato['tipo_marcacion'] . "',1,1,$id_usuario,NOW())";
        DB::statement($sql);
    }

    public static function update_marcacion_inconsistencia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "UPDATE asistencia_colaborador_marcaciones SET marcacion='" . $dato['marcacion'] . "',
        obs_marcacion='" . $dato['obs_marcacion'] . "',tipo_marcacion='" . $dato['tipo_marcacion'] . "',visible='" . $dato['visible'] . "',user_act='$id_usuario',fec_act=NOW() 
        WHERE id_asistencia_detalle='" . $dato['id_asistencia_detalle'] . "';";
        DB::statement($sql);
    }


    public static function update_obs_asistencia_inconsistencia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        $sql = "UPDATE asistencia_colaborador_inconsistencia SET observacion='" . $dato['observacion_inconsistencia'] . "',
        user_act='$id_usuario',fec_act=NOW() 
        WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "';";
        DB::statement($sql);
    }

    public static function get_list_detalle_marcacion_inconsistencia_visible($dato)
    {
        $sql = "SELECT a.id_asistencia_detalle, a.id_asistencia_inconsistencia,
            a.marcacion, a.obs_marcacion, a.tipo_marcacion, a.visible
            FROM asistencia_colaborador_marcaciones a 
            WHERE a.id_asistencia_inconsistencia = ? AND a.estado = 1 AND a.visible = 1 
            ORDER BY a.marcacion ASC";

        // Ejecuta la consulta y convierte el resultado en array
        $query = DB::select($sql, [$dato['id_asistencia_inconsistencia']]);
        return json_decode(json_encode($query), true);
    }

    public static function get_list_detalle_marcacion_inconsistencia_total($dato)
    {
        $sql = "SELECT 
                    COUNT(1) as total_marcaciones,
                    (SELECT COUNT(1) 
                     FROM asistencia_colaborador_marcaciones 
                     WHERE id_asistencia_inconsistencia = ? 
                           AND estado = 1 
                           AND visible = 1 
                           AND tipo_marcacion = 1) as t_entrada,
                    (SELECT COUNT(1) 
                     FROM asistencia_colaborador_marcaciones 
                     WHERE id_asistencia_inconsistencia = ? 
                           AND estado = 1 
                           AND visible = 1 
                           AND tipo_marcacion = 2) as t_srefri,
                    (SELECT COUNT(1) 
                     FROM asistencia_colaborador_marcaciones 
                     WHERE id_asistencia_inconsistencia = ? 
                           AND estado = 1 
                           AND visible = 1 
                           AND tipo_marcacion = 3) as t_erefri,
                    (SELECT COUNT(1) 
                     FROM asistencia_colaborador_marcaciones 
                     WHERE id_asistencia_inconsistencia = ? 
                           AND estado = 1 
                           AND visible = 1 
                           AND tipo_marcacion = 4) as t_salida
                FROM asistencia_colaborador_marcaciones a 
                WHERE a.id_asistencia_inconsistencia = ? 
                      AND a.estado = 1 
                      AND a.visible = 1 
                      AND a.tipo_marcacion <> '0'";

        // Ejecuta la consulta usando parámetros de enlace para evitar inyecciones SQL
        $query = DB::select($sql, array_fill(0, 5, $dato['id_asistencia_inconsistencia']));

        // Convierte el resultado a array
        return json_decode(json_encode($query), true);
    }

    public static function validar_marcacion_inconsistencia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;

        // Inserta el registro en la tabla `asistencia_colaborador`
        DB::insert("
        INSERT INTO asistencia_colaborador (
            id_usuario, fecha, id_horario, con_descanso, dia, centro_labores, id_area,
            hora_entrada, hora_entrada_desde, hora_entrada_hasta, hora_salida, hora_salida_desde, hora_salida_hasta,
            hora_descanso_e, hora_descanso_e_desde, hora_descanso_e_hasta, hora_descanso_s, hora_descanso_s_desde, 
            hora_descanso_s_hasta, marcacion_entrada, marcacion_idescanso, marcacion_fdescanso, marcacion_salida, 
            flag_editado, flag_diatrabajado, registro, estado_registro, nom_horario, observacion, obs_marc_entrada,
            obs_marc_idescanso, obs_marc_fdescanso, obs_marc_salida, estado, fec_reg, user_reg
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)", [
            $dato['id_usuario'],
            $dato['fecha'],
            $dato['id_horario'],
            $dato['con_descanso'],
            $dato['dia'],
            $dato['centro_labores'],
            $dato['id_area'],
            $dato['hora_entrada'],
            $dato['hora_entrada_desde'],
            $dato['hora_entrada_hasta'],
            $dato['hora_salida'],
            $dato['hora_salida_desde'],
            $dato['hora_salida_hasta'],
            $dato['hora_descanso_e'],
            $dato['hora_descanso_e_desde'],
            $dato['hora_descanso_e_hasta'],
            $dato['hora_descanso_s'],
            $dato['hora_descanso_s_desde'],
            $dato['hora_descanso_s_hasta'],
            $dato['marcacion1'],
            $dato['marcacion2'],
            $dato['marcacion3'],
            $dato['marcacion4'],
            1,
            $dato['flag_diatrabajado'],
            $dato['registro'],
            $dato['estado_registro'],
            $dato['nom_horario'],
            $dato['observacion'],
            $dato['obs_marcacion1'],
            $dato['obs_marcacion2'],
            $dato['obs_marcacion3'],
            $dato['obs_marcacion4'],
            1,
            $id_usuario
        ]);

        // Actualiza el estado de `asistencia_colaborador_inconsistencia`
        DB::update("
        UPDATE asistencia_colaborador_inconsistencia 
        SET estado = 2, user_eli = ?, fec_eli = NOW() 
        WHERE id_asistencia_inconsistencia = ?", [
            $id_usuario,
            $dato['id_asistencia_inconsistencia']
        ]);

        // Actualiza el estado de `asistencia_colaborador_marcaciones`
        DB::update("
        UPDATE asistencia_colaborador_marcaciones 
        SET estado = 2, user_eli = ?, fec_eli = NOW() 
        WHERE id_asistencia_inconsistencia = ?", [
            $id_usuario,
            $dato['id_asistencia_inconsistencia']
        ]);
    }

    public static function get_list_turno_xbase($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
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
            WHERE a.base='" . $dato['cod_base'] . "' and a.estado_registro=1 and a.estado=1";

        $query = DB::select($sql);
        return $query;
    }


    public static function get_list_turno($id_turno = null)
    {
        if (isset($id_turno) && $id_turno > 0) {
            $sql = "SELECT a.id_turno,a.base,date_format(a.entrada,'%H:%i') as entrada,
            date_format(a.salida,'%H:%i') as salida,a.t_refrigerio,
            case when a.t_refrigerio=1 then date_format(a.ini_refri,'%H:%i') end as ini_refri,
            case when a.t_refrigerio=1 then date_format(a.fin_refri, '%H:%i') end as fin_refri,
            case when a.t_refrigerio=2 then 'Sin Refrigerio' when a.t_refrigerio=1 then 'Refrigerio Fijo' end as desc_t_refrigerio,
            a.estado_registro
            FROM turno a 
            left join tolerancia_horario b on b.id_tolerancia=1
            WHERE a.id_turno=$id_turno";
        } else {
            $sql = "SELECT a.id_turno,a.base,date_format(a.entrada,'%H:%i') as entrada,
            date_format(a.salida,'%H:%i') as salida,a.t_refrigerio,
            case when a.t_refrigerio=1 then date_format(a.ini_refri,'%H:%i') end as ini_refri,
            case when a.t_refrigerio=1 then date_format(a.fin_refri, '%H:%i') end as fin_refri,
            case when a.t_refrigerio=2 then 'Sin Refrigerio' when a.t_refrigerio=1 then 'Refrigerio Fijo' end as desc_t_refrigerio,
            case when a.estado_registro=1 then 'Activo' when a.estado_registro=2 then 'Inactivo' end as desc_estado
            FROM turno a 
            WHERE a.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    public static function consulta_tolerancia_horario_activo()
    {
        $sql = "SELECT a.*,CASE WHEN a.tipo=1 THEN a.tolerancia 
                WHEN a.tipo=2 THEN a.tolerancia*60 END AS minutos 
                FROM tolerancia_horario a 
                WHERE a.estado=1 AND a.estado_registro=1";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }


    public static function update_turno_inconsistencia($dato, $minutos)
    {
        $id_usuario = session('usuario')->id_usuario;

        // Use ternary to set the value to NULL if it's null in the data
        $hora_descanso_e = isset($dato['ini_refri']) ? "'" . $dato['ini_refri'] . "'" : 'NULL';
        $hora_descanso_s = isset($dato['fin_refri']) ? "'" . $dato['fin_refri'] . "'" : 'NULL';
        // First SQL statement to update main fields
        $sql = "UPDATE asistencia_colaborador_inconsistencia SET 
        con_descanso='" . $dato['con_descanso'] . "',
        hora_entrada='" . $dato['entrada'] . "',
        hora_salida='" . $dato['salida'] . "',
        hora_descanso_e=$hora_descanso_e,
        hora_descanso_s=$hora_descanso_s,
        id_turno='" . $dato['id_turno'] . "',
        tipo_inconsistencia='0',
        user_act='$id_usuario',
        fec_act=NOW() 
        WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "';";
        DB::statement($sql);
        // Second SQL statement to update calculated fields
        $sql = "UPDATE asistencia_colaborador_inconsistencia SET 
        hora_entrada_desde=(DATE_FORMAT(DATE_SUB(hora_entrada,INTERVAL $minutos MINUTE), '%H:%i:%s')),
        hora_entrada_hasta=(DATE_FORMAT(DATE_ADD(hora_entrada,INTERVAL $minutos MINUTE), '%H:%i:%s')),
        hora_salida_desde=(DATE_FORMAT(DATE_SUB(hora_salida,INTERVAL $minutos MINUTE), '%H:%i:%s')),
        hora_salida_hasta=(DATE_FORMAT(DATE_ADD(hora_salida,INTERVAL $minutos MINUTE), '%H:%i:%s')),
        hora_descanso_e_desde=CASE WHEN con_descanso=1 THEN (DATE_FORMAT(DATE_SUB(hora_descanso_e,INTERVAL $minutos MINUTE), '%H:%i:%s')) END,
        hora_descanso_e_hasta=CASE WHEN con_descanso=1 THEN (DATE_FORMAT(DATE_ADD(hora_descanso_e,INTERVAL $minutos MINUTE), '%H:%i:%s')) END,
        hora_descanso_s_desde=CASE WHEN con_descanso=1 THEN (DATE_FORMAT(DATE_SUB(hora_descanso_s,INTERVAL $minutos MINUTE), '%H:%i:%s')) END,
        hora_descanso_s_hasta=CASE WHEN con_descanso=1 THEN (DATE_FORMAT(DATE_ADD(hora_descanso_s,INTERVAL $minutos MINUTE), '%H:%i:%s')) END,
        fec_act=NOW() 
        WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "'";

        DB::statement($sql);
    }




    public static function get_list_estado_asistencia_ausencia()
    {
        $sql = "SELECT * FROM estado_asistencia 
                WHERE id_estado_asistencia in (3,5,7,8,9,10,11)";
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }

    public static function update_ausencia_inconsistencia($dato)
    {
        $sql = "UPDATE asistencia_colaborador_inconsistencia SET flag_ausencia=0
                WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "'";
        DB::statement($sql);
    }


    public static function get_list_estado_asistencia($id_estado_asistencia = null)
    {
        if (isset($id_estado_asistencia) && $id_estado_asistencia > 0) {
            $sql = "SELECT * FROM estado_asistencia WHERE id_estado_asistencia=$id_estado_asistencia";
        } else {
            $sql = "SELECT * FROM estado_asistencia WHERE estado=1";
        }
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }



    public static function update_estado_ausencia($dato)
    {
        // SQL con placeholders
        $sql = "INSERT INTO asistencia_colaborador (
        id_usuario, fecha, id_horario, con_descanso, dia, centro_labores, id_area,
        hora_entrada, hora_entrada_desde, hora_entrada_hasta,
        hora_salida, hora_salida_desde, hora_salida_hasta,
        hora_descanso_e, hora_descanso_e_desde, hora_descanso_e_hasta,
        hora_descanso_s, hora_descanso_s_desde, hora_descanso_s_hasta,
        flag_editado, flag_diatrabajado,
        registro, estado_registro, nom_horario, observacion,
        estado, fec_reg, user_reg
    ) VALUES (
        :id_usuario, :fecha, :id_horario, :con_descanso, :dia, :centro_labores, :id_area,
        :hora_entrada, :hora_entrada_desde, :hora_entrada_hasta,
        :hora_salida, :hora_salida_desde, :hora_salida_hasta,
        :hora_descanso_e, :hora_descanso_e_desde, :hora_descanso_e_hasta,
        :hora_descanso_s, :hora_descanso_s_desde, :hora_descanso_s_hasta,
        1, :flag_diatrabajado,
        :registro, :estado_registro, :nom_horario, :observacion,
        1, NOW(), 0
    )";

        // Parámetros para la consulta
        $queryParams = [
            'id_usuario' => $dato['id_usuario'],
            'fecha' => $dato['fecha'],
            'id_horario' => $dato['id_horario'],
            'con_descanso' => $dato['con_descanso'],
            'dia' => $dato['dia'],
            'centro_labores' => $dato['centro_labores'],
            'id_area' => $dato['id_area'],
            'hora_entrada' => $dato['hora_entrada'],
            'hora_entrada_desde' => $dato['hora_entrada_desde'],
            'hora_entrada_hasta' => $dato['hora_entrada_hasta'],
            'hora_salida' => $dato['hora_salida'],
            'hora_salida_desde' => $dato['hora_salida_desde'],
            'hora_salida_hasta' => $dato['hora_salida_hasta'],
            'hora_descanso_e' => $dato['hora_descanso_e'],
            'hora_descanso_e_desde' => $dato['hora_descanso_e_desde'],
            'hora_descanso_e_hasta' => $dato['hora_descanso_e_hasta'],
            'hora_descanso_s' => $dato['hora_descanso_s'],
            'hora_descanso_s_desde' => $dato['hora_descanso_s_desde'],
            'hora_descanso_s_hasta' => $dato['hora_descanso_s_hasta'],
            'flag_diatrabajado' => $dato['flag_diatrabajado'],
            'registro' => $dato['registro'],
            'estado_registro' => $dato['estado_registro'],
            'nom_horario' => $dato['nom_horario'],
            'observacion' => $dato['observacion'],
        ];
        // Ejecutar la consulta
        DB::insert($sql, $queryParams);
        // Obtener el ID de la última inserción
        $id = DB::getPdo()->lastInsertId();
        return $id;
    }

    public static function delete_inconsistencia_ausencia($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "UPDATE asistencia_colaborador_inconsistencia SET estado='2',id_asistencia_colaborador='" . $dato['id_asistencia_colaborador'] . "',user_eli='$id_usuario',fec_eli=NOW() 
        WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "';";
        DB::statement($sql);
        $sql = "UPDATE asistencia_colaborador_marcaciones SET estado='2',id_asistencia_colaborador='" . $dato['id_asistencia_colaborador'] . "',user_eli='$id_usuario',fec_eli=NOW() 
        WHERE id_asistencia_inconsistencia='" . $dato['id_asistencia_inconsistencia'] . "';";
        DB::statement($sql);
    }

    public static function get_list_asistencia_colaborador($id_asistencia_colaborador = null, $dato)
    {
        $anio = date('Y');
        if (isset($id_asistencia_colaborador) && $id_asistencia_colaborador > 0) {
            $sql = "SELECT * FROM asistencia_colaborador
                    WHERE id_asistencia_colaborador=$id_asistencia_colaborador";
        } else {
            $fecha = "ac.fecha='" . $dato['dia'] . "' AND";
            if ($dato['tipo_fecha'] == "2") {
                $fecha = "MONTH(ac.fecha)='" . $dato['mes'] . "' AND YEAR(ac.fecha)='$anio' AND";
            }
            $base = "";
            if ($dato['base'] != "0") {
                $base = "ac.centro_labores='" . $dato['base'] . "' AND";
            }
            $area = "";
            if ($dato['area'] != "0") {
                $area = "ac.id_area='" . $dato['area'] . "' AND";
            }
            $usuario = "";
            if ($dato['usuario'] != "0") {
                $usuario = "ac.id_usuario='" . $dato['usuario'] . "' AND";
            }

            $sql = "SELECT ac.id_asistencia_colaborador,
                    CONCAT(CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1),2))),' ',
                    CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),1,1)),
                    LOWER(SUBSTRING(SUBSTRING_INDEX(us.usuario_apater,' ',1),2)))) AS colaborador,
                    us.num_doc,ac.centro_labores,DATE_FORMAT(ac.fecha,'%d/%m/%Y') AS fecha,
                    CASE WHEN ac.con_descanso=1 THEN CONCAT(DATE_FORMAT(ac.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ac.hora_salida,'%H:%i'),' (',DATE_FORMAT(ac.hora_descanso_e,'%H:%i'),' - ',
                    DATE_FORMAT(ac.hora_descanso_s,'%H:%i'),')') ELSE CONCAT(DATE_FORMAT(ac.hora_entrada,'%H:%i'),' - ',
                    DATE_FORMAT(ac.hora_salida,'%H:%i')) END AS turno,
                    CASE WHEN ac.estado_registro IN (1,2) THEN DATE_FORMAT(ac.marcacion_entrada,'%H:%i') 
                    ELSE '-' END AS marcacion_entrada,
                    CASE WHEN ac.estado_registro in (1,2) THEN (CASE WHEN ac.con_descanso=1 THEN 
                    DATE_FORMAT(ac.marcacion_idescanso,'%H:%i') ELSE '-' END) ELSE '-' END AS marcacion_idescanso,
                    CASE WHEN ac.estado_registro in (1,2) THEN (CASE WHEN ac.con_descanso=1 THEN 
                    DATE_FORMAT(ac.marcacion_fdescanso,'%H:%i') ELSE '-' END) ELSE '-' END AS marcacion_fdescanso,
                    CASE WHEN ac.estado_registro in (1,2) THEN DATE_FORMAT(ac.marcacion_salida,'%H:%i') 
                    ELSE '-' END AS marcacion_salida,
                    CASE WHEN ac.estado_registro='1' THEN '#5cb85c' WHEN ac.estado_registro='2' THEN '#f0ad4e'
                    WHEN ac.estado_registro='3' THEN '#d9534f' WHEN ac.estado_registro='4' THEN '#5bc0de'
                    WHEN ac.estado_registro='8' THEN '#292b2c' WHEN ac.estado_registro='7' THEN '#59287a'
                    WHEN ac.estado_registro='9' THEN '#0275d8' WHEN ac.estado_registro='10' THEN '#6c757d'
                    WHEN ac.estado_registro='11' THEN '#a76d46' END AS bandage,ea.nom_estado,
                    us.usuario_nombres,us.usuario_apater,us.usuario_amater,ac.flag_diatrabajado
                    FROM asistencia_colaborador ac
                    LEFT JOIN users us ON ac.id_usuario=us.id_usuario
                    LEFT JOIN estado_asistencia ea ON ac.estado_registro=ea.id_estado_asistencia
                    WHERE $fecha $base $area $usuario ac.estado=1";
        }
        $query = DB::select($sql);
        // return $query;
        return json_decode(json_encode($query), true);
    }

    public static function update_asistencia_colaborador_dia_trabajado($dato)
    {
        $sql = "UPDATE asistencia_colaborador SET flag_diatrabajado = :flag_diatrabajado
                WHERE id_asistencia_colaborador = :id_asistencia_colaborador";

        DB::statement($sql, [
            'flag_diatrabajado' => $dato['flag_diatrabajado'],
            'id_asistencia_colaborador' => $dato['id_asistencia_colaborador']
        ]);
    }


    public static function get_list_dotacion_marcaciones($dato)
    {
        $sql = "SELECT us.num_doc AS dni,
                    LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), ' ', us.usuario_apater)) AS colaborador,
                    LOWER(pu.nom_puesto) AS puesto,
                    us.num_celp AS celular,
                    DATE_FORMAT(MIN(bi.punch_time), '%H:%i') AS marcacion
                FROM zkbiotime.iclock_transaction bi
                LEFT JOIN users us ON bi.emp_code = us.num_doc
                LEFT JOIN horario_dia hd ON us.id_horario = hd.id_horario AND hd.estado = 1
                LEFT JOIN puesto pu ON us.id_puesto = pu.id_puesto
                WHERE DATE(bi.punch_time) = '" . $dato['fecha'] . "'
                  AND (WEEKDAY('" . $dato['fecha'] . "') + 1) = hd.dia
                  AND hd.id_turno > 0
                  AND us.centro_labores = '" . $dato['centro_labores'] . "'
                  AND us.estado = 1
                GROUP BY us.num_doc, us.usuario_nombres, us.usuario_apater, pu.nom_puesto, us.num_celp";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }




    public static function get_list_dotacion_ausentes($dato)
    {
        $sql = "SELECT us.num_doc AS dni,
                    LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1), ' ', us.usuario_apater)) AS colaborador,
                    LOWER(pu.nom_puesto) AS puesto,
                    us.num_celp AS celular
            FROM users us
            LEFT JOIN horario_dia hd ON us.id_horario = hd.id_horario AND hd.estado = 1
            LEFT JOIN puesto pu ON us.id_puesto = pu.id_puesto
            WHERE (WEEKDAY('" . $dato['fecha'] . "') + 1) = hd.dia
              AND hd.id_turno > 0
              AND us.centro_labores = '" . $dato['centro_labores'] . "'
              AND us.estado = 1
              AND us.num_doc NOT IN (
                  SELECT us.num_doc
                  FROM zkbiotime.iclock_transaction bi
                  LEFT JOIN users us ON bi.emp_code = us.num_doc
                  LEFT JOIN horario_dia hd ON us.id_horario = hd.id_horario AND hd.estado = 1
                  WHERE DATE(bi.punch_time) = '" . $dato['fecha'] . "'
                    AND (WEEKDAY('" . $dato['fecha'] . "') + 1) = hd.dia
                    AND hd.id_turno > 0
                    AND us.centro_labores = '" . $dato['centro_labores'] . "'
                    AND us.estado = 1
                  GROUP BY us.id_usuario,us.num_doc
              )
            GROUP BY us.num_doc, 
                     us.usuario_nombres, 
                     us.usuario_apater, 
                     pu.nom_puesto, 
                     us.num_celp";

        // Ejecutar la consulta
        $query = DB::select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($query), true);
    }

    public static function get_list_asistencia_colaborador_excel($id_asistencia_colaborador = null, $dato)
    {
        $anio = date('Y');
        if (isset($id_asistencia_colaborador) && $id_asistencia_colaborador > 0) {
            $sql = "SELECT a.* 
            FROM asistencia_colaborador a 
            where a.id_asistencia_colaborador='$id_asistencia_colaborador'";
        } else {
            $base = "";
            if ($dato['base'] != "0") {
                $base = " and a.centro_labores='" . $dato['base'] . "'";
            }

            $area = "";
            if ($dato['area'] != "0") {
                $area = " and a.id_area='" . $dato['id_area'] . "'";
            }
            $usuario = "";
            if ($dato['usuario'] != "0") {
                $usuario = " and a.id_usuario='" . $dato['usuario'] . "'";
            }
            $fecha = " and a.fecha='" . $dato['dia'] . "'";
            if ($dato['tipo_fecha'] == "2") {
                $fecha = " and month(a.fecha)='" . $dato['mes'] . "' and year(a.fecha)='$anio'";
            }
            $sql = "SELECT a.id_usuario,
            b.usuario_nombres,b.usuario_apater,b.usuario_amater,a.fecha,a.flag_diatrabajado
            FROM asistencia_colaborador a 
            left join users b on a.id_usuario=b.id_usuario
            where a.estado=1 $base $area $usuario $fecha";
        }
        $query = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($query), true);
    }

    public static function get_id_mes($cod_mes)
    {
        $sql = "SELECT * from mes where cod_mes=$cod_mes";
        $query = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($query), true);
    }


    public static function get_list_tolerancia_horario($id_tolerancia = null)
    {
        if (isset($id_tolerancia) && $id_tolerancia > 0) {
            $sql = "SELECT * FROM tolerancia_horario WHERE id_tolerancia=$id_tolerancia";
        } else {
            $sql = "SELECT a.*, case when a.estado_registro=1 then 'Activo' when a.estado_registro=2 then 'Inactivo' end as desc_estado_registro,
            case when a.tipo=1 then 'Minuto(s)' when a.tipo=2 then 'Hora(s)' end as desc_tipo
            FROM tolerancia_horario a 
            WHERE a.estado='1' ";
        }
        $query = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($query), true);
    }

    public static function actualizar_estado_tolerancia_horario($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        if ($dato['estado_registro'] == 1) {
            $sql = "UPDATE tolerancia_horario set estado_registro=2,fec_act=NOW(), user_reg='$id_usuario' where estado=1 and estado_registro=1";
            DB::statement($sql);
        }
        $sql = "UPDATE tolerancia_horario SET estado_registro='" . $dato['estado_registro'] . "', fec_act=NOW(), user_act=" . $id_usuario . " WHERE id_tolerancia = " . $dato['id_tolerancia'] . "";
        DB::statement($sql);
    }

    public static function update_tolerancia_horario_cron($minutos)
    {
        $sql = "UPDATE horario_dia SET 
                hora_entrada_desde = DATE_FORMAT(DATE_SUB(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s'),
                hora_entrada_hasta = DATE_FORMAT(DATE_ADD(hora_entrada, INTERVAL $minutos MINUTE), '%H:%i:%s'),
                hora_salida_desde = DATE_FORMAT(DATE_SUB(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s'),
                hora_salida_hasta = DATE_FORMAT(DATE_ADD(hora_salida, INTERVAL $minutos MINUTE), '%H:%i:%s'),
                hora_descanso_e_desde = CASE 
                                            WHEN con_descanso = 1 
                                            THEN DATE_FORMAT(DATE_SUB(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') 
                                            ELSE hora_descanso_e_desde 
                                        END,
                hora_descanso_e_hasta = CASE 
                                            WHEN con_descanso = 1 
                                            THEN DATE_FORMAT(DATE_ADD(hora_descanso_e, INTERVAL $minutos MINUTE), '%H:%i:%s') 
                                            ELSE hora_descanso_e_hasta 
                                        END,
                hora_descanso_s_desde = CASE 
                                            WHEN con_descanso = 1 
                                            THEN DATE_FORMAT(DATE_SUB(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') 
                                            ELSE hora_descanso_s_desde 
                                        END,
                hora_descanso_s_hasta = CASE 
                                            WHEN con_descanso = 1 
                                            THEN DATE_FORMAT(DATE_ADD(hora_descanso_s, INTERVAL $minutos MINUTE), '%H:%i:%s') 
                                            ELSE hora_descanso_s_hasta 
                                        END,
                fec_act = NOW() 
                WHERE estado = 1";
        DB::statement($sql);
    }


    public static function delete_tolerancia_horario($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "UPDATE tolerancia_horario SET estado=2, fec_eli=NOW(), user_eli=" . $id_usuario . " WHERE id_tolerancia = " . $dato['id_tolerancia'] . "";
        DB::statement($sql);
    }


    public static function valida_tolerancia_horario($dato)
    {
        $v = "";
        if ($dato['mod'] == 2) {
            $v = " and id_tolerancia!='" . $dato['id_tolerancia'] . "'";
        }
        $sql = "SELECT * FROM tolerancia_horario where tolerancia='" . $dato['tolerancia'] . "' and tipo='" . $dato['tipo'] . "' and estado=1 $v";
        $query = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($query), true);
    }

    public static function insert_tolerancia_horario($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "UPDATE tolerancia_horario set estado_registro=2,fec_act=NOW(), user_reg='$id_usuario' where estado=1 and estado_registro=1";
        DB::statement($sql);

        $sql = "INSERT INTO tolerancia_horario (tipo,tolerancia,estado_registro, fec_reg, user_reg, estado) 
                values ('" . $dato['tipo'] . "','" . $dato['tolerancia'] . "',1, NOW()," . $id_usuario . ", '1')";
        DB::statement($sql);
    }


    public static function update_tolerancia_horario($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "UPDATE tolerancia_horario set tolerancia='" . $dato['tolerancia'] . "',tipo='" . $dato['tipo'] . "',fec_act=NOW(), 
                user_act=" . $id_usuario . " where id_tolerancia=" . $dato['id_tolerancia'] . "";
        DB::statement($sql);
    }

    public static function valida_asistencia_manual($dato, $id = null)
    {
        if (isset($id)) {
            $sql = "SELECT id FROM acceso_asistencia_manual
                    WHERE id_usuario=" . $dato['id_usuario'] . " AND estado=1 AND id!=$id";
        } else {
            $sql = "SELECT id FROM acceso_asistencia_manual
                    WHERE id_usuario=" . $dato['id_usuario'] . " AND estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }


    public static function get_list_asistencia_manual($id = null)
    {
        if (isset($id)) {
            $sql = "SELECT * FROM acceso_asistencia_manual
                    WHERE id=$id";
        } else {
            $sql = "SELECT aa.id,
                    LOWER(CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',us.usuario_apater)) AS nom_usuario,
                    CASE WHEN aa.entrada=1 THEN 'Si' ELSE 'No' END AS entrada,
                    CASE WHEN aa.salida=1 THEN 'Si' ELSE 'No' END AS salida,
                    CASE WHEN aa.inicio_refrigerio=1 THEN 'Si' ELSE 'No' END AS inicio_refrigerio,
                    CASE WHEN aa.fin_refrigerio=1 THEN 'Si' ELSE 'No' END AS fin_refrigerio
                    FROM acceso_asistencia_manual aa
                    LEFT JOIN users us ON aa.id_usuario=us.id_usuario
                    WHERE aa.estado=1";
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }


    public static function get_list_colaborador_asistencia_manual()
    {
        $sql = "SELECT id_usuario,CONCAT(usuario_nombres,' ',usuario_apater,' ',usuario_amater) AS nom_usuario 
                FROM users
                WHERE id_horario>0 AND estado=1";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }




    public static function insert_asistencia_manual($dato)
    {
        $id_usuario = session('usuario')->id_usuario;
        $sql = "INSERT INTO asistencia_manual (id_usuario,base,fecha,marcacion,estado,fec_reg,user_reg) 
                VALUES ('" . $dato['id_usuario'] . "','" . $dato['base'] . "','" . $dato['fecha'] . "',
                '" . $dato['marcacion'] . "',1,NOW(),$id_usuario)";
        DB::statement($sql);
    }
}
