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
            $fecha=" WHERE DATE_FORMAT(ar.punch_time,'%m') = '".$cod_mes."' AND DATE_FORMAT(ar.punch_time,'%Y') = '".$cod_anio."'";
        }else{
            $fecha=" WHERE DATE_FORMAT(ar.punch_time,'%Y-%m-%d') BETWEEN '".$finicio."' and '".$ffin."'";
        }

        $resultados = [];
        
        foreach ($usuarios as $usuario) {
            $dni = $usuario->usuario_codigo;
            
            $sql = "SELECT DISTINCT DATE(it.punch_time) AS orden, u.centro_labores,
            u.usuario_apater,u.usuario_amater,u.usuario_nombres, u.usuario_codigo as num_doc,
                    DATE_FORMAT(it.punch_time, '%d/%m/%Y') AS fecha,  -- Formatear siempre en d/m
                    (SELECT DATE_FORMAT(ir.punch_time, '%H:%i %p') 
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 1) AS ingreso,
                    (SELECT DATE_FORMAT(ir.punch_time, '%H:%i %p') 
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 1,1) AS inicio_refrigerio,
                    (SELECT DATE_FORMAT(ir.punch_time, '%H:%i %p') 
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 2,1) AS fin_refrigerio,
                    (SELECT DATE_FORMAT(ir.punch_time, '%H:%i %p') 
                    FROM iclock_transaction ir
                    WHERE ir.emp_code = it.emp_code AND DATE(ir.punch_time) = DATE(it.punch_time)
                    ORDER BY ir.punch_time ASC
                    LIMIT 3,1) AS salida
                    FROM iclock_transaction it
                    join lanumerouno.users u ON it.emp_code=u.usuario_codigo
                    WHERE it.emp_code = :dni
                    ORDER BY DATE(it.punch_time) DESC";
        
            // Imprimir consulta con el valor reemplazado
            //$sql_with_dni = str_replace(':dni', "'$dni'", $sql);
            //print_r($sql_with_dni);
            
            // Ejecutar la consulta
            $result = DB::connection('second_mysql')->select($sql, [$dni]);
            
            // Convertir el resultado a un array y añadirlo al array de resultados
            $resultados[$dni] = json_decode(json_encode($result), true);
        }
        return $resultados;
        
    }

    function get_list_usuario_xnum_doc($num_doc)
    {
        $sql = "SELECT u.*,
        (SELECT fec_inicio h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_inicio,
        (SELECT h.fec_fin h FROM historico_colaborador h where u.id_usuario=h.id_usuario and h.estado in (1,3) ORDER BY h.fec_inicio DESC,h.fec_fin DESC limit 1)as fec_fin
        from users u
        where u.num_doc='$num_doc' ";
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
}
