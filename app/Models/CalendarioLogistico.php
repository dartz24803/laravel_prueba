<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CalendarioLogistico extends Model
{
    use HasFactory;

    protected $table = 'calendario_logistico';
    protected $primaryKey = 'id_calendario';

    public $timestamps = false;

    protected $fillable = [
        'fec_de',
        'fec_hasta',
        'de_real',
        'hasta_real',
        'hora_real_llegada',
        'hora_ingreso_insta',
        'hora_descargo_merca',
        'hora_salida',

        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];
    
    static function get_list_rproveedor($dato){
        //$id_usuario= session('usuario')->id_usuario;
        $id_puesto= session('usuario')->id_puesto;

        $base="";
        if($dato['base']!="0"){
            $base=" AND cl.base='".$dato['base']."'";
        }elseif($id_puesto==24 && $dato['base']=="0"){
            $base=" AND cl.base in ('CD','OFC','AMT')";  
        }
        if($dato['base']==""){
            $base="";
        }
        
        if($dato['desde']==""){
            $dato['desde'] = date('Y-m-d');
        }
        if($dato['hasta']==""){
            $dato['hasta'] = date('Y-m-d');
        }

        $estado="";
        if($dato['estado']!=3){
            $estado=" AND cl.estado_interno='".$dato['estado']."' ";
        }

        $sql = "SELECT cl.*,tc.color,p.nombre_proveedor,
        DATE_FORMAT(cl.fec_de, '%H:%i %p') AS hora_programada,
        DATE_FORMAT(cl.fec_hasta, '%d-%m-%Y %H:%i %p') AS fecha_hasta,
        DATE_FORMAT(cl.hora_real_llegada, '%H:%i %p') AS fecha_real_llegada,
        DATE_FORMAT(cl.hora_ingreso_insta, '%H:%i %p') AS fecha_ingreso_insta,
        DATE_FORMAT(cl.hora_descargo_merca, '%H:%i %p') AS fecha_descarga_merca,
        DATE_FORMAT(cl.hora_salida, '%H:%i %p') AS fecha_salida,
        DATE_FORMAT(cl.fec_reg, '%d/%m/%Y %H:%i %p') AS fecha_registro,
        DATE_FORMAT(cl.fec_reg, '%d/%m/%Y %H:%i %p') AS fecha_registro_excel,
        u.usuario_nombres,u.usuario_apater,u.usuario_amater
        FROM calendario_logistico cl
        LEFT JOIN tipo_calendario_logistico tc ON tc.id_tipo_calendario=cl.id_tipo_calendario
        LEFT JOIN proveedor p ON cl.id_proveedor=p.id_proveedor
        left join users u on cl.user_reg=u.id_usuario
        WHERE cl.estado=1 and cl.invitacion=0 $base $estado and DATE_FORMAT(cl.fec_de, '%Y-%m-%d') 
        BETWEEN '".$dato['desde']."' and '".$dato['hasta']."' ";

        //print_r($sql);

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}