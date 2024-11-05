<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AsignacionJefatura extends Model
{
    use HasFactory;
    
    protected $table = 'asignacion_jefatura';

    protected $primaryKey = 'id_asignacion_jefatura';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto_permitido',
        'id_puesto_jefe',
        'estado',
        'user_reg',
        'fec_reg',
        'user_act',
        'fec_act',
        'user_eli',
        'fec_eli',
    ];

    function get_list_ajefatura_puesto($id_puesto){
        $sql = "SELECT pps.*,p.nom_puesto as puesto_permitido, pjefe.nom_puesto as puesto_jefe, a.nom_area, g.nom_gerencia
                FROM asignacion_jefatura pps
                LEFT JOIN puesto p on p.id_puesto=pps.id_puesto_permitido 
                LEFT JOIN puesto pjefe on pjefe.id_puesto=pps.id_puesto_jefe
                LEFT JOIN area a on p.id_area=a.id_area and p.id_puesto=pps.id_puesto_permitido
                LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                LEFT JOIN gerencia g on g.id_gerencia=sg.id_gerencia and p.id_area=a.id_area and p.id_puesto=pps.id_puesto_permitido
                WHERE pps.estado='1' and pps.id_puesto_jefe=".$id_puesto."";
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
    
    static function get_list_marcacion_mi_equipo($dni){
        $sql = "SELECT DISTINCT DATE(it.punch_time) AS orden,
                CASE WHEN DATE(it.punch_time)=CURDATE() THEN 'Hoy'
                WHEN TIMESTAMPDIFF(DAY, DATE(it.punch_time), CURDATE())=1 THEN 'Ayer' 
                ELSE DATE_FORMAT(it.punch_time, '%d/%m') END AS fecha,
                (SELECT DATE_FORMAT(ir.punch_time,'%H:%i %p') 
                FROM iclock_transaction ir
                WHERE ir.emp_code=it.emp_code AND DATE(ir.punch_time)=DATE(it.punch_time)
                ORDER BY ir.punch_time ASC
                LIMIT 1) AS ingreso,
                (SELECT DATE_FORMAT(ir.punch_time,'%H:%i %p') 
                FROM iclock_transaction ir
                WHERE ir.emp_code=it.emp_code AND DATE(ir.punch_time)=DATE(it.punch_time)
                ORDER BY ir.punch_time ASC
                LIMIT 1,1) AS inicio_refrigerio,
                (SELECT DATE_FORMAT(ir.punch_time,'%H:%i %p') 
                FROM iclock_transaction ir
                WHERE ir.emp_code=it.emp_code AND DATE(ir.punch_time)=DATE(it.punch_time)
                ORDER BY ir.punch_time ASC
                LIMIT 2,1) AS fin_refrigerio,
                (SELECT DATE_FORMAT(ir.punch_time,'%H:%i %p') 
                FROM iclock_transaction ir
                WHERE ir.emp_code=it.emp_code AND DATE(ir.punch_time)=DATE(it.punch_time)
                ORDER BY ir.punch_time ASC
                LIMIT 3,1) AS salida
                FROM iclock_transaction it
                WHERE it.emp_code='$dni'
                ORDER BY DATE(it.punch_time) DESC";

        $result = DB::connection('second_mysql')->select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
