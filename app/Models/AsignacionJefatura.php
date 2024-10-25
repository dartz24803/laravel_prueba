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
                LEFT JOIN gerencia g on p.id_gerencia=g.id_gerencia and p.id_area=a.id_area and p.id_puesto=pps.id_puesto_permitido
                WHERE pps.estado='1' and pps.id_puesto_jefe=".$id_puesto."";
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
