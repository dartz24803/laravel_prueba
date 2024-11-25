<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Amonestacion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'amonestacion';

    protected $primaryKey = 'id_amonestacion';

    protected $fillable = [
        'cod_amonestacion',
        'fecha',
        'id_solicitante',
        'id_colaborador',
        'id_revisor',
        'tipo',
        'id_gravedad_amonestacion',
        'motivo',
        'detalle',
        'fec_aprobacion',
        'documento',
        'estado_amonestacion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    function get_list_amonestacion($id_amonestacion=null,$id_area=null){
        $id_usuario = Session::get('usuario')->id_usuario;
        $id_puesto = Session::get('usuario')->id_puesto;
        $base = Session::get('usuario')->centro_labores;
        $visualizar_amonestacion = Session::get('usuario')->visualizar_amonestacion;

        if(isset($id_amonestacion) && $id_amonestacion>0){
            $sql = "SELECT i.*,g.nom_gravedad_amonestacion,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,p.nom_puesto,
                concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
                concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
                date_format(i.fec_aprobacion, '%d/%m/%Y') as fecha_aprobacion,date_format(i.fecha, '%d/%m/%Y') as fecha_suceso,m.nom_motivo_amonestacion,
                (select concat(j.usuario_nombres,' ',j.usuario_apater) from users j where j.id_puesto=19 and estado=1 limit 1) as jeferrhh,
                a.nom_tipo_amonestacion, ar.nom_area,
                CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                FROM amonestacion i
                left join users u on i.id_colaborador=u.id_usuario
                left join users s on i.id_solicitante=s.id_usuario
                left join users r on i.id_revisor=r.id_usuario
                left join puesto p on u.id_puesto=p.id_puesto
                LEFT JOIN area ar on ar.id_area=p.id_area
                left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
                left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
                left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
                where i.estado=1 and i.id_amonestacion='$id_amonestacion'";
        }else{
            if(isset($id_area) && $id_area>0){
                $sql = "SELECT i.*,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,
                concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
                concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
                g.nom_gravedad_amonestacion,
                case when i.estado_amonestacion=1 then 'Por Iniciar'
                when i.estado_amonestacion=2 then 'Aprobado'
                when i.estado_amonestacion=3 then 'Rechazado'
                when i.estado_amonestacion=4 then 'Aceptado'
                when i.estado_amonestacion=5 then 'No Aceptado' end as desc_estado_amonestacion,
                date_format(i.fecha, '%d/%m/%Y') as fecha_amonestacion,a.nom_tipo_amonestacion,
                m.nom_motivo_amonestacion,ar.id_area,
                CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                FROM amonestacion i
                left join users u on i.id_colaborador=u.id_usuario
                left join users s on i.id_solicitante=s.id_usuario
                left join users r on i.id_revisor=r.id_usuario
                LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN area ar on ar.id_area=p.id_area
                left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
                left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
                left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
                where i.estado=1 and ar.id_area=$id_area and r.centro_labores='$base'";
            }elseif($id_puesto==128){
                $sql = "SELECT i.*,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,
                concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
                concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
                g.nom_gravedad_amonestacion,
                case when i.estado_amonestacion=1 then 'Por Iniciar'
                when i.estado_amonestacion=2 then 'Aprobado'
                when i.estado_amonestacion=3 then 'Rechazado'
                when i.estado_amonestacion=4 then 'Aceptado'
                when i.estado_amonestacion=5 then 'No Aceptado' end as desc_estado_amonestacion,
                date_format(i.fecha, '%d/%m/%Y') as fecha_amonestacion,a.nom_tipo_amonestacion,
                m.nom_motivo_amonestacion, a.nom_area,
                CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                FROM amonestacion i
                left join users u on i.id_colaborador=u.id_usuario
                left join users s on i.id_solicitante=s.id_usuario
                left join users r on i.id_revisor=r.id_usuario
                LEFT JOIN puesto p on p.id_puesto=u.id_puesto
                LEFT JOIN area ar on ar.id_area=p.id_area
                left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
                left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
                left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
                where i.estado=1 and s.id_usuario=$id_usuario";
            }elseif($visualizar_amonestacion!="sin_acceso_amonestacion"){
                $sql = "SELECT i.*,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,
                        concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
                        concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
                        g.nom_gravedad_amonestacion,
                        case when i.estado_amonestacion=1 then 'Por Iniciar'
                        when i.estado_amonestacion=2 then 'Aprobado'
                        when i.estado_amonestacion=3 then 'Rechazado'
                        when i.estado_amonestacion=4 then 'Aceptado'
                        when i.estado_amonestacion=5 then 'No Aceptado' end as desc_estado_amonestacion,
                        date_format(i.fecha, '%d/%m/%Y') as fecha_amonestacion,a.nom_tipo_amonestacion,
                        m.nom_motivo_amonestacion,
                        CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                        FROM amonestacion i
                        left join users u on i.id_colaborador=u.id_usuario
                        left join users s on i.id_solicitante=s.id_usuario
                        left join users r on i.id_revisor=r.id_usuario
                        left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
                        left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
                        left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
                        WHERE u.id_puesto IN ($visualizar_amonestacion) AND i.estado=1";
            }else{
                $sql = "SELECT i.*,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,
                        concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
                        concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
                        g.nom_gravedad_amonestacion,
                        case when i.estado_amonestacion=1 then 'Por Iniciar'
                        when i.estado_amonestacion=2 then 'Aprobado'
                        when i.estado_amonestacion=3 then 'Rechazado'
                        when i.estado_amonestacion=4 then 'Aceptado'
                        when i.estado_amonestacion=5 then 'No Aceptado' end as desc_estado_amonestacion,
                        date_format(i.fecha, '%d/%m/%Y') as fecha_amonestacion,a.nom_tipo_amonestacion,
                        m.nom_motivo_amonestacion,
                        CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
                        FROM amonestacion i
                        left join users u on i.id_colaborador=u.id_usuario
                        left join users s on i.id_solicitante=s.id_usuario
                        left join users r on i.id_revisor=r.id_usuario
                        left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
                        left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
                        left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
                        where i.estado=1;";
            }
        }
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }

    function update_amonestacion($dato) {
        $id_usuario = session('usuario')->id_usuario;
        $id_puesto = session('usuario')->id_puesto;
        $estado = $dato['documento'] != "" ? $dato['estado_amonestacion'] : null;

        if (session('usuario')->id_nivel == 1 || $id_puesto == 23) {
            $estado = '2';
        }

        DB::table('amonestacion')
            ->where('id_amonestacion', $dato['id_amonestacion'])
            ->update([
                'id_solicitante' => $dato['id_solicitante'],
                'fecha' => $dato['fecha'],
                'id_colaborador' => $dato['id_colaborador'],
                'tipo' => $dato['tipo'],
                'id_gravedad_amonestacion' => $dato['id_gravedad_amonestacion'],
                'motivo' => $dato['motivo'],
                'detalle' => $dato['detalle'],
                'estado_amonestacion' => $estado,
                'fec_act' => now(),
                'user_act' => $id_usuario
            ]);
    }

    function aprobacion_amonestacion($dato){
        $id_usuario= session('usuario')->id_usuario;
        $fec_aprobacion = null;
        if($dato['tipo']==1){
            $fec_aprobacion=now();
        }

        DB::table('amonestacion')
            ->where('id_amonestacion', $dato['id_amonestacion'])
            ->update([
                'estado_amonestacion' => $dato['estado_amonestacion'],
                'id_revisor' => $id_usuario,
                'fec_aprobacion' => $fec_aprobacion,
                'fec_act' => now(),
                'user_act' => $id_usuario,
            ]);

    }

    function get_list_amonestaciones_recibidas(){
        $id_usuario = session('usuario')->id_usuario;
        $sql = "SELECT i.*,concat(u.usuario_nombres,' ',u.usuario_apater,' ',u.usuario_amater) as colaborador,
            concat(s.usuario_nombres,' ',s.usuario_apater,' ',s.usuario_amater) as solicitante,
            concat(r.usuario_nombres,' ',r.usuario_apater,' ',r.usuario_amater) as revisor,
            g.nom_gravedad_amonestacion,
            case when i.estado_amonestacion=1 then 'Por Iniciar'
            when i.estado_amonestacion=2 then 'Aprobado'
            when i.estado_amonestacion=3 then 'Rechazado'
            when i.estado_amonestacion=4 then 'Aceptado'
            when i.estado_amonestacion=5 then 'No Aceptado' end as desc_estado_amonestacion,
            date_format(i.fecha, '%d/%m/%Y') as fecha_amonestacion,a.nom_tipo_amonestacion,
            m.nom_motivo_amonestacion,ar.id_area,
            CASE WHEN i.documento!='' THEN 'Si' ELSE 'No' END AS v_documento
            FROM amonestacion i
            left join users u on i.id_colaborador=u.id_usuario
            left join users s on i.id_solicitante=s.id_usuario
            left join users r on i.id_revisor=r.id_usuario
            LEFT JOIN puesto p on p.id_puesto=u.id_puesto
            LEFT JOIN area ar on ar.id_area=p.id_area
            left join tipo_amonestacion a on i.tipo=a.id_tipo_amonestacion
            left join motivo_amonestacion m on i.motivo=m.id_motivo_amonestacion
            left join gravedad_amonestacion g on i.id_gravedad_amonestacion=g.id_gravedad_amonestacion
            where i.estado=1 and i.id_colaborador=$id_usuario and i.estado_amonestacion in (2,4)";
        $query = DB::select($sql);
        return json_decode(json_encode($query), true);
    }
}
