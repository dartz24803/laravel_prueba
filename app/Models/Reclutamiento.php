<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reclutamiento extends Model
{
    use HasFactory;

    protected $table = 'reclutamiento';
    protected $primaryKey = 'id_reclutamiento';
    public $timestamps = false;

    protected $fillable = [
        'cod_reclutamiento',
        'id_area',
        'id_puesto',
        'id_solicitante',
        'id_evaluador',
        'vacantes',
        'cod_base',
        'id_ubicacion',
        'id_modalidad_laboral',
        'tipo_sueldo',
        'sueldo',
        'desde',
        'a',
        'id_asignado',
        'prioridad',
        'fec_cierre',
        'fec_termino',
        'fec_cierre_r',
        'observacion',
        'estado_reclutamiento',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    static function get_list_reclutamiento_asig(){
        $sql = "SELECT asi.id_usuario, concat(asi.usuario_nombres,' ',asi.usuario_apater,' ',
                asi.usuario_amater) as asignado_a
                FROM reclutamiento r
                left join users asi on r.id_asignado=asi.id_usuario
                where r.id_asignado!=0 and r.estado=1
                GROUP BY asi.id_usuario, asi.usuario_nombres, asi.usuario_apater, asi.usuario_amater";

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    static
    function get_list_reclutamiento($id_reclutamiento=null,$id_usuario=null,$pestania=null){
        $id_nivel= session('usuario')->id_nivel;
        if(isset($id_reclutamiento) && $id_reclutamiento>0){
            $sql = "SELECT r.* FROM reclutamiento r where r.id_reclutamiento='$id_reclutamiento' ";
        }else{
            if($id_nivel==1 || $id_nivel==2) {
                $asignado="";
                if($id_usuario!="0"){
                    $asignado="and r.id_asignado=$id_usuario";
                }
                $v_pestania="";
                if($pestania==1){
                    $v_pestania=" and (select count(1) from reclutamiento_reclutado d where d.id_reclutamiento=r.id_reclutamiento and d.estado=1) < r.vacantes and r.estado_reclutamiento in (1,2)";
                }if($pestania==2){
                    $v_pestania=" and (select count(1) from reclutamiento_reclutado d where d.id_reclutamiento=r.id_reclutamiento and d.estado=1) = r.vacantes and r.estado_reclutamiento in (3)";
                }
                $sql="SELECT r.*,date_format(r.fec_reg,'%d-%m-%Y') as fecha_registro, u.cod_ubi,
                p.nom_puesto,concat(asi.usuario_nombres,' ',asi.usuario_apater,' ',asi.usuario_amater) as asignado_a,
                concat(sol.usuario_nombres,' ',sol.usuario_apater,' ',sol.usuario_amater) as solicitado,
                concat(eva.usuario_nombres,' ',eva.usuario_apater,' ',eva.usuario_amater) as evaluador,
                case when r.estado_reclutamiento=1 then 'Por iniciar'
                when r.estado_reclutamiento=2 then 'En proceso'
                when r.estado_reclutamiento=3 then 'Completado' end as nom_estado_reclutamiento,
                case when r.prioridad=1 then 'Baja'
                when r.prioridad=2 then 'Media'
                when r.prioridad=3 then 'Alta' end as nom_prioridad,
                date_format(r.fec_cierre,'%d-%m-%Y') as fecha_cierre,
                (select count(1) from reclutamiento_reclutado d where d.id_reclutamiento=r.id_reclutamiento and d.estado=1) as reclutados,
                case when r.tipo_sueldo=1 then 'Fijo' when r.tipo_sueldo=2 then 'Banda' end as tipo_remuneracion,
                a.nom_area,m.nom_modalidad_laboral
                FROM reclutamiento r
                LEFT JOIN ubicacion u on r.id_ubicacion=u.id_ubicacion
                left join puesto p on r.id_puesto=p.id_puesto
                left join users asi on r.id_asignado=asi.id_usuario
                left join users sol on r.id_solicitante=sol.id_usuario
                left join users eva on r.id_evaluador=eva.id_usuario
                left join area a on r.id_area=a.id_area
                left join modalidad_laboral m on r.id_modalidad_laboral=m.id_modalidad_laboral
                where r.estado=1 $asignado $v_pestania";
            }else{
                $id_usuario= session('usuario')->id_usuario;
                $sql = "SELECT r.*,date_format(r.fec_reg,'%d-%m-%Y') as fecha_registro, u.cod_ubi,
                p.nom_puesto,concat(asi.usuario_nombres,' ',asi.usuario_apater,' ',asi.usuario_amater) as asignado_a,
                concat(sol.usuario_nombres,' ',sol.usuario_apater,' ',sol.usuario_amater) as solicitado,
                concat(eva.usuario_nombres,' ',eva.usuario_apater,' ',eva.usuario_amater) as evaluador,
                case when r.estado_reclutamiento=1 then 'Por iniciar'
                when r.estado_reclutamiento=2 then 'En proceso'
                when r.estado_reclutamiento=3 then 'Completado' end as nom_estado_reclutamiento,
                case when r.prioridad=1 then 'Baja'
                when r.prioridad=2 then 'Media'
                when r.prioridad=3 then 'Alta' end as nom_prioridad,
                date_format(r.fec_cierre,'%d-%m-%Y') as fecha_cierre,
                (select count(*) from reclutamiento_reclutado d where d.id_reclutamiento=r.id_reclutamiento and d.estado=1) as reclutados,
                a.nom_area
                FROM reclutamiento r
                LEFT JOIN ubicacion u on r.id_ubicacion=u.id_ubicacion
                left join puesto p on r.id_puesto=p.id_puesto
                left join users asi on r.id_asignado=asi.id_usuario
                left join users sol on r.id_solicitante=sol.id_usuario
                left join users eva on r.id_evaluador=eva.id_usuario
                left join area a on r.id_area=a.id_area
                where r.estado=1 and r.id_solicitante='$id_usuario'";
            }

        }

        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
