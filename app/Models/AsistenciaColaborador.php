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
            $sql = "SELECT a.* FROM semanas a where a.estado=1 and a.anio='" . $anio . "'";
        }

        $query = DB::select($sql);
        dd($query);
        return $query;
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

    public static function get_list_tardanza($dato)
    {
        /*hd.id_turno>0 AND (WEEKDAY('$fecha')+1)=hd.dia AND*/
        $parte_fecha = "vm.fecha='" . $dato['dia'] . "' AND";
        if ($dato['tipo_fecha'] == "2") {
            $parte_fecha = "YEAR(vm.fecha)='" . date('Y') . "' AND MONTH(vm.fecha)='" . $dato['mes'] . "' AND";
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
                FROM zkbiotime.vista_marcacion_minima vm
                INNER JOIN users us ON vm.emp_code=us.num_doc
                INNER JOIN ubicacion ub ON ub.id_ubicacion=us.id_centro_labor
                INNER JOIN puesto pu ON us.id_puesto=pu.id_puesto
                LEFT JOIN horario_dia hd ON us.id_horario=hd.id_horario AND 
                hd.id_turno>0 AND (WEEKDAY(vm.fecha)+1)=hd.dia
                WHERE $parte_fecha $parte_base $parte_area $parte_usuario us.estado=1 AND 
                hd.estado=1 AND FLOOR(TIME_TO_SEC(TIMEDIFF(vm.hora_llegada, hd.hora_entrada))/60)>0";
        $query = DB::select($sql);
        return $query;
    }


    public static function get_list_dotacion($fecha)
    {
        $sql = "SELECT CASE WHEN us.centro_labores LIKE 'B%' THEN CONCAT('ZZZ',us.centro_labores) 
                ELSE us.centro_labores END AS orden,us.centro_labores,COUNT(1) AS dotacion,
                (SELECT COUNT(DISTINCT bi.emp_code) 
                FROM zkbiotime.iclock_transaction bi
                WHERE DATE(bi.punch_time)='$fecha' AND bi.emp_code IN 
                (SELECT ub.num_doc FROM users ub
                LEFT JOIN horario_dia hi ON ub.id_horario=hi.id_horario AND hi.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hi.dia AND ub.centro_labores=us.centro_labores AND 
                hi.id_turno>0 AND ub.estado=1)) AS presentes,
                COUNT(0)-(SELECT COUNT(DISTINCT bi.emp_code) 
                FROM zkbiotime.iclock_transaction bi
                WHERE DATE(bi.punch_time)='$fecha' AND bi.emp_code IN 
                (SELECT ub.num_doc FROM users ub
                LEFT JOIN horario_dia hi ON ub.id_horario=hi.id_horario AND hi.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hi.dia AND ub.centro_labores=us.centro_labores AND 
                hi.id_turno>0 AND ub.estado=1)) AS ausentes,
                CONCAT(ROUND((SELECT COUNT(DISTINCT bi.emp_code) 
                FROM zkbiotime.iclock_transaction bi
                WHERE DATE(bi.punch_time)='$fecha' AND bi.emp_code IN 
                (SELECT ub.num_doc FROM users ub
                LEFT JOIN horario_dia hi ON ub.id_horario=hi.id_horario AND hi.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hi.dia AND ub.centro_labores=us.centro_labores AND 
                hi.id_turno>0 AND ub.estado=1))*100/COUNT(0),1),'%') AS porcentaje_asistencia,
                (SELECT DATE_FORMAT(MIN(bi.punch_time),'%H:%i')
                FROM zkbiotime.iclock_transaction bi
                WHERE DATE(bi.punch_time)='$fecha' AND bi.emp_code IN 
                (SELECT ub.num_doc FROM users ub
                LEFT JOIN horario_dia hi ON ub.id_horario=hi.id_horario AND hi.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hi.dia AND ub.centro_labores=us.centro_labores AND 
                hi.id_turno>0 AND ub.estado=1)) AS hora_apertura,
                CASE WHEN COUNT(0)=(SELECT COUNT(DISTINCT bi.emp_code) 
                FROM zkbiotime.iclock_transaction bi
                WHERE DATE(bi.punch_time)='$fecha' AND bi.emp_code IN 
                (SELECT ub.num_doc FROM users ub
                LEFT JOIN horario_dia hi ON ub.id_horario=hi.id_horario AND hi.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hi.dia AND ub.centro_labores=us.centro_labores AND 
                hi.id_turno>0 AND ub.estado=1)) THEN 'Todos marcaron' ELSE 'Faltan marcas' END AS nom_estado
                FROM users us 
                LEFT JOIN horario_dia hd ON us.id_horario=hd.id_horario AND hd.estado=1
                WHERE (WEEKDAY('$fecha')+1)=hd.dia AND hd.id_turno>0 AND us.estado=1
                GROUP BY us.centro_labores
                ORDER BY orden ASC";
        $query = DB::select($sql);
        return $query;
    }



    public static function get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia = null, $dato)
    {
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
            $fecha = "ai.fecha='" . $dato['dia'] . "' AND";
            if ($dato['tipo_fecha'] == "2") {
                $fecha = "(ai.fecha BETWEEN '" . $dato['get_semana'][0]['fec_inicio'] . "' AND '" . $dato['get_semana'][0]['fec_fin'] . "') AND";
            }
            $base = "";
            if ($dato['base'] != "0") {
                $base = "ai.centro_labores='" . $dato['base'] . "' AND";
            }
            $area = "";
            if ($dato['area'] != "0") {
                $area = "ai.id_area='" . $dato['id_area'] . "' AND";
            }
            $usuario = "";
            if ($dato['usuario'] != "0") {
                $usuario = "ai.id_usuario='" . $dato['usuario'] . "' AND";
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
    }
}
