<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Organigrama extends Model
{
    use HasFactory;

    protected $table = 'organigrama';

    public $timestamps = false;

    protected $fillable = [
        'id_puesto',
        'id_usuario',
        'fecha',
        'usuario'
    ];

    public static function get_list_colaborador($dato){
        $parte_gerencia = "";
        if($dato['id_gerencia']!="0"){
            $parte_gerencia = "WHERE us.id_gerencia=".$dato['id_gerencia'];
        }
        $sql = "SELECT og.id_usuario,us.ini_funciones AS orden,
                CASE WHEN YEAR(us.fec_nac) BETWEEN 1946 AND 1964 THEN 'BB'
                WHEN YEAR(us.fec_nac) BETWEEN 1965 AND 1980 THEN 'X'
                WHEN YEAR(us.fec_nac) BETWEEN 1981 AND 1996 THEN 'Y'
                WHEN YEAR(us.fec_nac) BETWEEN 1997 AND 2012 THEN 'Z'
                WHEN YEAR(us.fec_nac) >= 2013 THEN '&alpha;' ELSE '' END AS generacion,
                sl.descripcion AS sede_laboral,us.centro_labores AS ubicacion,us.usuario_apater,
                us.usuario_amater,us.usuario_nombres,pu.nom_puesto,ar.nom_area,sg.nom_sub_gerencia,
                ge.nom_gerencia,DATE_FORMAT(us.ini_funciones,'%d-%m-%Y') AS fecha_ingreso,
                td.cod_tipo_documento,us.num_doc,us.num_celp,
                DATE_FORMAT(us.fec_baja,'%d-%m-%Y') AS fecha_baja,mt.nom_motivo,us.doc_baja,us.foto
                FROM organigrama og
                LEFT JOIN users us ON og.id_usuario=us.id_usuario
                LEFT JOIN puesto pu ON og.id_puesto=pu.id_puesto
                LEFT JOIN sede_laboral sl ON pu.id_sede_laboral=sl.id
                LEFT JOIN area ar ON us.id_area=ar.id_area
                LEFT JOIN sub_gerencia sg ON us.id_sub_gerencia=sg.id_sub_gerencia
                LEFT JOIN gerencia ge ON us.id_gerencia=ge.id_gerencia
                LEFT JOIN tipo_documento td ON us.id_tipo_documento=td.id_tipo_documento
                LEFT JOIN motivo_baja_rrhh mt ON us.id_motivo_baja=mt.id_motivo
                $parte_gerencia
                ORDER BY us.ini_funciones DESC";
        $query = DB::select($sql);
        return $query;
    }
}
