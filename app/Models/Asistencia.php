<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Asistencia extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function buscar_reporte_control_asistencia($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios){
        if($tipo==1){
            $fecha=" AND DATE_FORMAT(it.punch_time,'%m') = '".$cod_mes."' AND DATE_FORMAT(it.punch_time,'%Y') = '".$cod_anio."'";
        }else{
            $fecha=" AND DATE_FORMAT(it.punch_time,'%Y-%m-%d') BETWEEN '".$finicio."' and '".$ffin."'";
        }

        $doc_iclock="";
        $doc_ar="";
        $base_ar="";

        $resultados = [];
        //print_r($usuarios);
        foreach ($usuarios as $usuario) {
            $dni = $usuario->usuario_codigo;
            
            $sql = "SELECT DISTINCT DATE(it.punch_time) AS orden, ub.cod_ubi AS centro_labores,
                    u.usuario_apater,u.usuario_amater,u.usuario_nombres, u.usuario_codigo as num_doc,
                    DATE_FORMAT(it.punch_time, '%d/%m/%Y') AS fecha,
                    (SELECT ir.punch_time
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 1) AS ingreso,
                    (SELECT ir.punch_time
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 1,1) AS inicio_refrigerio,
                    (SELECT ir.punch_time
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 2,1) AS fin_refrigerio,
                    (SELECT ir.punch_time
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 3,1) AS salida
                    FROM iclock_transaction it
                    join lanumerouno.users u ON LPAD(it.emp_code,8,'0')=u.usuario_codigo
                    join lanumerouno.ubicacion ub ON u.id_centro_labor=ub.id_ubicacion
                    WHERE LPAD(it.emp_code,8,'0') = :dni $fecha $base_ar $doc_iclock $doc_ar
                    ORDER BY DATE(it.punch_time) DESC";
        
            // Imprimir consulta con el valor reemplazado
            // $sql_with_dni = str_replace(':dni', "'$dni'", $sql);
            // print_r($sql_with_dni);
            
            // Ejecutar la consulta
            $result = DB::connection('second_mysql')->select($sql, [$dni]);
            
            // Convertir el resultado a un array y añadirlo al array de resultados
            $resultados[$dni] = json_decode(json_encode($result), true);
        }
        return $resultados;
        
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

    function get_list_usuarios_x_baset($cod_base = null, $area = null, $estado){
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

    
    public function buscar_reporte_control_asistencia_nm($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios){
        if($tipo==1){
            $fecha=" AND DATE_FORMAT(c.fecha,'%m') = '".$cod_mes."' AND DATE_FORMAT(c.fecha,'%Y') = '".$cod_anio."'";
        }else{
            $fecha=" AND DATE_FORMAT(c.fecha,'%Y-%m-%d') BETWEEN '".$finicio."' and '".$ffin."'";
        }

        $doc_iclock="";
        $doc_ar="";
        $base_ar="";

        $resultados = [];
        //print_r($usuarios);
        foreach ($usuarios as $usuario) {
            $dni = $usuario->usuario_codigo;
            
            $sql = "SELECT u.usuario_codigo AS emp_code, 
                        c.fecha AS orden, c.fecha,
                        ub.cod_ubi AS centro_labores,
                        u.usuario_apater,u.usuario_amater,u.usuario_nombres, u.usuario_codigo as num_doc
                    FROM calendario c
                    JOIN lanumerouno.users u
                    join lanumerouno.ubicacion ub ON u.id_centro_labor=ub.id_ubicacion
                    LEFT JOIN iclock_transaction it 
                        ON c.fecha = DATE(it.punch_time) 
                        AND it.emp_code = u.usuario_codigo
                    WHERE it.punch_time IS NULL
                    AND u.usuario_codigo = :dni $fecha $base_ar $doc_iclock $doc_ar
                    ORDER BY c.fecha ASC;";
        
            // Imprimir consulta con el valor reemplazado
            // $sql_with_dni = str_replace(':dni', "'$dni'", $sql);
            // print_r($sql_with_dni);
            
            // Ejecutar la consulta
            $result = DB::connection('second_mysql')->select($sql, [$dni]);
            
            // Convertir el resultado a un array y añadirlo al array de resultados
            $resultados[$dni] = json_decode(json_encode($result), true);
        }
        return $resultados;
    }
    
    public function buscar_reporte_control_asistencia_excel($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios){
        if($tipo==1){
            $fecha=" AND DATE_FORMAT(c.fecha,'%m') = '".$cod_mes."' AND DATE_FORMAT(c.fecha,'%Y') = '".$cod_anio."'";
        }else{
            $fecha=" AND DATE_FORMAT(c.fecha,'%Y-%m-%d') BETWEEN '".$finicio."' and '".$ffin."'";
        }

        $doc_iclock="";
        $doc_ar="";
        $base_ar="";

        $resultados = [];
        // print_r($usuarios);
        foreach ($usuarios as $usuario) {
            $dni = $usuario->usuario_codigo;
            // print_r($dni);
            $sql = "SELECT c.fecha,u.usuario_nombres,u.usuario_apater,u.usuario_amater,
                        u.usuario_codigo AS emp_code,
                        IFNULL(m.marcaciones, 0) AS total_marcaciones,
                        CASE 
                            WHEN IFNULL(m.marcaciones, 0) = 4 THEN 1
                            ELSE 0
                        END AS estado_marcacion
                    FROM calendario c
                    JOIN lanumerouno.users u
                    LEFT JOIN (
                        SELECT DATE(it.punch_time) AS fecha,
                            it.emp_code,
                            COUNT(*) AS marcaciones
                        FROM iclock_transaction it
                        WHERE it.emp_code = $dni
                        GROUP BY DATE(it.punch_time), it.emp_code
                    ) m ON c.fecha = m.fecha AND u.usuario_codigo = m.emp_code
                    WHERE u.usuario_codigo = $dni $fecha $base_ar $doc_iclock $doc_ar
                    ORDER BY c.fecha ASC;";
        
            // Imprimir consulta con el valor reemplazado
            // $sql_with_dni = str_replace(':dni', "'$dni'", $sql);
            // print_r($sql_with_dni);
            
            // Ejecutar la consulta
            $result = DB::connection('second_mysql')->select($sql);
            
            // Convertir el resultado a un array y añadirlo al array de resultados
            $resultados[$dni] = json_decode(json_encode($result), true);
        }
        return $resultados;
    }
    /*
    public function buscar_reporte_control_asistencia_excel($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios){
        if ($tipo == 1) {
            $fecha = " AND DATE_FORMAT(c.fecha,'%m') = :cod_mes AND DATE_FORMAT(c.fecha,'%Y') = :cod_anio";
        } else {
            $fecha = " AND DATE_FORMAT(c.fecha,'%Y-%m-%d') BETWEEN :finicio AND :ffin";
        }

        $doc_iclock = "";
        $doc_ar = "";
        $base_ar = "";

        $resultados = [];
        
        foreach ($usuarios as $usuario) {
            $dni = $usuario->usuario_codigo;

            $sql = "SELECT 
                        c.fecha,
                        u.usuario_nombres,
                        u.usuario_apater,
                        u.usuario_amater,
                        u.usuario_codigo AS emp_code,
                        IFNULL(m.marcaciones, 0) AS total_marcaciones,
                        CASE 
                            WHEN IFNULL(m.marcaciones, 0) = 4 THEN 1 -- Tiene las 4 marcaciones
                            ELSE 0 -- No tiene 4 marcaciones
                        END AS estado_marcacion
                    FROM calendario c
                    JOIN lanumerouno.users u
                    LEFT JOIN (
                        SELECT 
                            DATE(it.punch_time) AS fecha,
                            it.emp_code,
                            COUNT(*) AS marcaciones
                        FROM iclock_transaction it
                        WHERE it.emp_code = :dni
                        GROUP BY DATE(it.punch_time), it.emp_code
                    ) m ON c.fecha = m.fecha AND u.usuario_codigo = m.emp_code
                    WHERE 
                        u.usuario_codigo = :dni $fecha $base_ar $doc_iclock $doc_ar
                    ORDER BY c.fecha ASC;";

            // Parámetros para la consulta
            $params = [
                'dni' => $dni,
                'cod_mes' => $cod_mes,
                'cod_anio' => $cod_anio,
                'finicio' => $finicio,
                'ffin' => $ffin,
            ];

            // Ejecutar la consulta
            $result = DB::connection('second_mysql')->select($sql, $params);
            
            // Convertir el resultado a un array y añadirlo al array de resultados
            $resultados[$dni] = json_decode(json_encode($result), true);
        }
        
        return $resultados;
    }*/
}
