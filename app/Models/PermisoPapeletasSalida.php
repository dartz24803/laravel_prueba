<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermisoPapeletasSalida extends Model
{
    protected $table = 'permiso_papeletas_salida';

    protected $primaryKey = 'id_permiso_papeletas_salida';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto_permitido',
        'id_puesto_jefe',
        'registro_masivo',
        'estado',
        'user_reg',
        'fec_reg',
        'user_act',
        'fec_act',
        'user_eli',
        'fec_eli'
    ];

    /******permisos papeletas salida**/
    function get_list_permiso_papeletas_salida(){
        $sql = "SELECT pps.*,p.nom_puesto, pjefe.nom_puesto as puesto_jefe, a.nom_area, g.nom_gerencia
                FROM permiso_papeletas_salida pps
                LEFT JOIN puesto p on p.id_puesto=pps.id_puesto_permitido
                LEFT JOIN puesto pjefe on pjefe.id_puesto=pps.id_puesto_jefe
                LEFT JOIN area a on p.id_area=a.id_area and p.id_puesto=pps.id_puesto_permitido
                LEFT JOIN sub_gerencia sg on sg.id_sub_gerencia=a.id_departamento
                LEFT JOIN gerencia g on sg.id_gerencia=g.id_gerencia and p.id_area=a.id_area and p.id_puesto=pps.id_puesto_permitido
                WHERE pps.estado='1'";


        $result = DB::select($sql);
        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }

    public function permiso_pps_puestos_gest_dinamico(){
        $id_puesto = session('usuario')->id_puesto;
        $sql = "SELECT pps.id_puesto_permitido
            FROM permiso_papeletas_salida pps
            LEFT JOIN puesto p on p.id_puesto=pps.id_puesto_permitido
            WHERE pps.estado='1' and id_puesto_jefe=$id_puesto";


        $result = DB::select($sql);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
