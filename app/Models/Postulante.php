<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Postulante extends Model
{
    use HasFactory;

    protected $table = 'postulante';
    protected $primaryKey = 'id_postulante';

    public $timestamps = false;

    protected $fillable = [
        'id_centro_labor',
        'postulante_nombres',
        'postulante_apater',
        'postulante_amater',
        'postulante_codigo',
        'postulante_password',
        'password_desencriptado',
        'id_nivel',
        'postulante_email',
        'emailp',
        'num_celp',
        'num_fijop',
        'num_cele',
        'num_anexoe',
        'id_gerencia',
        'id_area',
        'id_puesto',
        'id_cargo',
        'id_tipo_documento',
        'num_doc',
        'id_nacionalidad',
        'id_genero',
        'id_estado_civil',
        'foto',
        'foto_nombre',
        'ini_funciones',
        'fin_funciones',
        'observaciones',
        'dia_nac',
        'mes_nac',
        'anio_nac',
        'fec_nac',
        'situacion',
        'enfermedades',
        'alergia',
        'centro_labores',
        'id_puesto_evaluador',
        'id_evaluador',
        'flag_email',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
        'acceso',
        'ip_acceso',
        'estado_postulacion',
        'aprobado'
    ];

    public static function get_list_postulante($dato=null)
    {
        if($dato['estado']!=null){
            if(is_string($dato['estado'])) {
                $array = explode(',', $dato['estado']);
            }elseif(is_array($dato['estado'])) {
                $array = $dato['estado'];
            }
            $parte_estado = "po.estado_postulacion IN (";
            $concatenado = "";
            if(in_array(1,$array)){
                $concatenado = $concatenado."1,2,3,4,5,6,7,8,11,";
            }
            if(in_array(2,$array)){
                $concatenado = $concatenado."10,";
            }
            if(in_array(3,$array)){
                $concatenado = $concatenado."9,";
            }
            if($concatenado == ""){
                $parte_estado = "";
            }else{
                $concatenado = substr($concatenado,0,-1);
                $parte_estado = $parte_estado.$concatenado.") AND";
            }
        }else{
            $parte_estado = "po.estado_postulacion='0' AND";
        }

        $parte_area = "";
        if($dato['id_area']!="0"){
            $parte_area = "po.id_area=".$dato['id_area']." AND";
        }

        $parte_base = "";
        if(session('usuario')->id_puesto=="30" || 
        session('usuario')->id_puesto=="128" || 
        session('usuario')->id_puesto=="161" ||
        session('usuario')->id_puesto=="314"){
            $parte_base = "po.id_centro_labor='".session('usuario')->id_centro_labor."' AND";
        }

        $sql = "SELECT po.id_postulante,po.fec_reg AS orden,
                CASE WHEN DATE(po.fec_reg)=CURDATE() 
                THEN CONCAT('Hoy ',DATE_FORMAT(po.fec_reg,'%H:%i %p'))
                WHEN TIMESTAMPDIFF(DAY, DATE(po.fec_reg), CURDATE())=1 
                THEN CONCAT('Ayer ',DATE_FORMAT(po.fec_reg,'%H:%i %p')) 
                ELSE DATE_FORMAT(po.fec_reg, '%d/%m/%Y') END AS fecha,
                CONCAT(UPPER(SUBSTRING(ar.nom_area, 1, 1)), 
                LCASE(SUBSTRING(ar.nom_area, 2))) AS nom_area, 
                CONCAT(UPPER(SUBSTRING(pu.nom_puesto, 1, 1)), 
                LCASE(SUBSTRING(pu.nom_puesto, 2))) AS nom_puesto,
                CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(po.postulante_nombres,' ',1), 1, 1)), 
                LCASE(SUBSTRING(SUBSTRING_INDEX(po.postulante_nombres,' ',1), 2)), ' ', 
                UPPER(SUBSTRING(po.postulante_apater, 1, 1)), 
                LCASE(SUBSTRING(po.postulante_apater, 2))) AS nom_postulante,
                po.num_doc,po.num_celp,
                CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1), 1, 1)), 
                LCASE(SUBSTRING(SUBSTRING_INDEX(us.usuario_nombres,' ',1), 2)), ' ', 
                UPPER(SUBSTRING(us.usuario_apater, 1, 1)), 
                LCASE(SUBSTRING(us.usuario_apater, 2))) AS creado_por,
                ep.nom_estado_postulante AS nom_estado
                FROM postulante po
                INNER JOIN puesto pu ON pu.id_puesto=po.id_puesto
                INNER JOIN area ar ON ar.id_area=pu.id_area
                INNER JOIN users us ON us.id_usuario=po.user_reg
                INNER JOIN vw_estado_postulante ep ON ep.id_estado_postulante=po.estado_postulacion
                WHERE TIMESTAMPDIFF(DAY, DATE(po.fec_act), CURDATE())<=30 AND $parte_estado 
                $parte_area $parte_base po.estado=1
                ORDER BY po.fec_reg DESC";
        $query = DB::select($sql);
        return $query;
    }

    public static function get_list_todos($dato=null)
    {
        if($dato['estado_postulante_1']=="0" && $dato['estado_postulante_2']=="0" && $dato['estado_postulante_3']=="0"){
            $parte_estado = "AND p.estado_postulacion=0";
        }else{
            $parte_estado = "AND p.estado_postulacion IN (";
            if($dato['estado_postulante_1']==1){
                $parte_estado = $parte_estado."1,2,3,4,5,6,7,8,11,";
            }
            if($dato['estado_postulante_2']==1){
                $parte_estado = $parte_estado."10,";
            }
            if($dato['estado_postulante_3']==1){
                $parte_estado = $parte_estado."9,";
            }
            $parte_estado = substr($parte_estado,0,-1);
            $parte_estado = $parte_estado.")";
        }

        $parte_area = "";
        if($dato['id_area']!="0"){
            $parte_area = "AND p.id_area=".$dato['id_area'];
        }

        $parte_base = "";
        if(session('usuario')->id_puesto==26 || 
        session('usuario')->id_puesto==29 || 
        session('usuario')->id_puesto==128 || 
        session('usuario')->id_puesto==16 || 
        session('usuario')->id_puesto==98 || 
        session('usuario')->id_puesto==197 || 
        session('usuario')->id_puesto==161){
            $parte_base = "AND p.centro_labores='".session('usuario')->centro_labores."'";
            if($dato['id_area']!="0"){
                $parte_area = "AND p.id_area=".$dato['id_area'];
            }else{
                $parte_area = "AND p.id_area IN (".session('usuario')->id_area.",44)";
            }
        }

        $sql = "SELECT p.id_postulante,p.fec_reg AS orden,
                CASE WHEN DATE(p.fec_reg)=CURDATE() THEN CONCAT('Hoy ',DATE_FORMAT(p.fec_reg,'%H:%i %p'))
                WHEN TIMESTAMPDIFF(DAY, DATE(p.fec_reg), CURDATE())=1 THEN 
                CONCAT('Ayer ',DATE_FORMAT(p.fec_reg,'%H:%i %p')) 
                ELSE DATE_FORMAT(p.fec_reg, '%d/%m/%Y') END AS fecha_tabla,
                CONCAT(UPPER(SUBSTRING(a.nom_area, 1, 1)), LCASE(SUBSTRING(a.nom_area, 2))) AS nom_area, 
                CONCAT(UPPER(SUBSTRING(pu.nom_puesto, 1, 1)), LCASE(SUBSTRING(pu.nom_puesto, 2))) AS nom_puesto,
                CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(p.postulante_nombres,' ',1), 1, 1)), LCASE(SUBSTRING(SUBSTRING_INDEX(p.postulante_nombres,' ',1), 2)), ' ', 
                UPPER(SUBSTRING(p.postulante_apater, 1, 1)), LCASE(SUBSTRING(p.postulante_apater, 2))) AS nombres,
                p.num_doc,p.num_celp, 
                CONCAT(UPPER(SUBSTRING(SUBSTRING_INDEX(u.usuario_nombres,' ',1), 1, 1)), LCASE(SUBSTRING(SUBSTRING_INDEX(u.usuario_nombres,' ',1), 2)), ' ', 
                UPPER(SUBSTRING(u.usuario_apater, 1, 1)), LCASE(SUBSTRING(u.usuario_apater, 2))) AS creado_por,
                e.nom_estados_postulante
                FROM postulante p
                LEFT JOIN users u ON u.id_usuario=p.user_reg
                LEFT JOIN puesto pu ON pu.id_puesto=p.id_puesto
                LEFT JOIN vw_estado_postulante e ON e.id_estado_postulante=p.estado_postulacion
                LEFT JOIN area a ON p.id_area=a.id_area
                WHERE p.estado=1 $parte_area $parte_base $parte_estado
                ORDER BY p.fec_reg DESC";
        $query = DB::select($sql);
        return $query;
    }
}
