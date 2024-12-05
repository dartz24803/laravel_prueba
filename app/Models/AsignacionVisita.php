<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsignacionVisita extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla
    protected $table = 'asignacion_visita';

    // Define la clave primaria
    protected $primaryKey = 'id_asignacion_visita';

    // Indica que no se usará el manejo automático de timestamps (created_at y updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'cod_asignacion',
        'id_inspector',
        'id_puesto_inspector',
        'fecha',
        'punto_partida',
        'punto_llegada',
        'tipo_punto_partida',
        'tipo_punto_llegada',
        'id_modelo',
        'id_proceso',
        'observacion_otros',
        'id_tipo_transporte',
        'costo',
        'inspector_acompaniante',
        'observacion',
        'fec_ini_visita',
        'fec_fin_visita',
        'ch_alm',
        'ini_alm',
        'fin_alm',
        'estado_registro',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];


    public static function getListAsignacion($fini, $ffin, $idUsuario)
    {
        return self::select(
            'asignacion_visita.id_asignacion_visita',
            'asignacion_visita.cod_asignacion',
            'asignacion_visita.id_inspector',
            'asignacion_visita.id_puesto_inspector',
            'asignacion_visita.fecha',
            DB::raw("IF(asignacion_visita.punto_partida = 9999, 'Domicilio', proveedor_partida.responsable) as proveedor_responsable_partida"),
            DB::raw("IF(asignacion_visita.punto_llegada = 9999, 'Domicilio', proveedor_llegada.responsable) as proveedor_responsable_llegada"),
            'asignacion_visita.tipo_punto_partida',
            'asignacion_visita.tipo_punto_llegada',
            'asignacion_visita.id_modelo',
            'asignacion_visita.id_proceso',
            'asignacion_visita.inspector_acompaniante',
            'asignacion_visita.fec_ini_visita',
            'asignacion_visita.fec_fin_visita',
            'asignacion_visita.ch_alm',
            'asignacion_visita.ini_alm',
            'asignacion_visita.fin_alm',
            'asignacion_visita.estado_registro',
            'asignacion_visita.estado',
            DB::raw("CONCAT(users.usuario_apater, ' ', users.usuario_amater, ' ', users.usuario_nombres) AS nombre_completo"),
            'ficha_tecnica_produccion.modelo as nom_modelo',
            'ficha_tecnica_produccion.img_ft_produccion as img_ft_produccion',
            'proceso_visita.nom_proceso as nom_proceso',
            DB::raw("GROUP_CONCAT(DISTINCT tipo_transporte_produccion.nom_tipo_transporte SEPARATOR ', ') as nom_tipo_transporte"),
            DB::raw("SUM(asignacion_visita_transporte.costo) as total_costo")
        )
            ->leftJoin('users', 'asignacion_visita.id_inspector', '=', 'users.id_usuario')
            ->leftJoin('proveedor_general as proveedor_partida', 'asignacion_visita.punto_partida', '=', 'proveedor_partida.id_proveedor')
            ->leftJoin('proveedor_general as proveedor_llegada', 'asignacion_visita.punto_llegada', '=', 'proveedor_llegada.id_proveedor')
            ->leftJoin('ficha_tecnica_produccion', 'asignacion_visita.id_modelo', '=', 'ficha_tecnica_produccion.id_ft_produccion')
            ->leftJoin('proceso_visita', 'asignacion_visita.id_proceso', '=', 'proceso_visita.id_procesov')
            ->leftJoin('asignacion_visita_transporte', 'asignacion_visita.id_asignacion_visita', '=', 'asignacion_visita_transporte.id_asignacion_visita')
            ->leftJoin('tipo_transporte_produccion', 'asignacion_visita_transporte.id_tipo_transporte', '=', 'tipo_transporte_produccion.id_tipo_transporte')
            ->whereBetween('asignacion_visita.fecha', [$fini, $ffin])
            ->where('asignacion_visita.estado', 1)
            // Aquí se filtra por el id del inspector ($idUsuario)
            ->when($idUsuario, function ($query, $idUsuario) {
                return $query->where('asignacion_visita.id_inspector', $idUsuario);
            })
            ->groupBy(
                'asignacion_visita.id_asignacion_visita',
                'asignacion_visita.cod_asignacion',
                'asignacion_visita.id_inspector',
                'asignacion_visita.id_puesto_inspector',
                'asignacion_visita.fecha',
                'asignacion_visita.punto_partida',
                'asignacion_visita.punto_llegada',
                'asignacion_visita.tipo_punto_partida',
                'asignacion_visita.tipo_punto_llegada',
                'asignacion_visita.id_modelo',
                'asignacion_visita.id_proceso',
                'asignacion_visita.inspector_acompaniante',
                'asignacion_visita.fec_ini_visita',
                'asignacion_visita.fec_fin_visita',
                'asignacion_visita.ch_alm',
                'asignacion_visita.ini_alm',
                'asignacion_visita.fin_alm',
                'asignacion_visita.estado_registro',
                'asignacion_visita.estado',
                'ficha_tecnica_produccion.modelo',
                'ficha_tecnica_produccion.img_ft_produccion',
                'proceso_visita.nom_proceso',
                'proveedor_partida.responsable',
                'proveedor_llegada.responsable',
                'users.usuario_apater',
                'users.usuario_amater',
                'users.usuario_nombres'

            )
            ->orderBy('asignacion_visita.cod_asignacion', 'DESC')
            ->get();
    }



    // public static function getListAsignacion($fini, $ffin, $idUsuario)
    // {
    //     return self::select(
    //         'asignacion_visita.id_asignacion_visita',
    //         'asignacion_visita.cod_asignacion',
    //         'asignacion_visita.id_inspector',
    //         'asignacion_visita.id_puesto_inspector',
    //         'asignacion_visita.fecha',
    //         DB::raw("IF(asignacion_visita.punto_partida = 9999, 'Domicilio', proveedor_partida.responsable) as proveedor_responsable_partida"),
    //         DB::raw("IF(asignacion_visita.punto_llegada = 9999, 'Domicilio', proveedor_llegada.responsable) as proveedor_responsable_llegada"),
    //         'asignacion_visita.tipo_punto_partida',
    //         'asignacion_visita.tipo_punto_llegada',
    //         'asignacion_visita.id_modelo',
    //         'asignacion_visita.id_proceso',
    //         'asignacion_visita.inspector_acompaniante',
    //         'asignacion_visita.fec_ini_visita',
    //         'asignacion_visita.fec_fin_visita',
    //         'asignacion_visita.ch_alm',
    //         'asignacion_visita.ini_alm',
    //         'asignacion_visita.fin_alm',
    //         'asignacion_visita.estado_registro',
    //         'asignacion_visita.estado',
    //         DB::raw("CONCAT(users.usuario_apater, ' ', users.usuario_amater, ' ', users.usuario_nombres) AS nombre_completo"),
    //         'ficha_tecnica_produccion.modelo as nom_modelo',
    //         'proceso_visita.nom_proceso as nom_proceso',
    //         'tipo_transporte_produccion.nom_tipo_transporte as nom_tipo_transporte'
    //     )
    //         ->leftJoin('users', 'asignacion_visita.id_inspector', '=', 'users.id_usuario')
    //         ->leftJoin('proveedor_general as proveedor_partida', 'asignacion_visita.punto_partida', '=', 'proveedor_partida.id_proveedor')
    //         ->leftJoin('proveedor_general as proveedor_llegada', 'asignacion_visita.punto_llegada', '=', 'proveedor_llegada.id_proveedor')
    //         ->leftJoin('ficha_tecnica_produccion', 'asignacion_visita.id_modelo', '=', 'ficha_tecnica_produccion.id_ft_produccion')
    //         ->leftJoin('proceso_visita', 'asignacion_visita.id_proceso', '=', 'proceso_visita.id_procesov')
    //         ->leftJoin('asignacion_visita_transporte', 'asignacion_visita.id_asignacion_visita', '=', 'asignacion_visita_transporte.id_asignacion_visita')
    //         ->leftJoin('tipo_transporte_produccion', 'asignacion_visita_transporte.id_tipo_transporte', '=', 'tipo_transporte_produccion.id_tipo_transporte')
    //         ->whereBetween('asignacion_visita.fecha', [$fini, $ffin])
    //         ->where('asignacion_visita.estado', 1)
    //         // Aquí se filtra por el id del inspector ($idUsuario)
    //         ->when($idUsuario, function ($query, $idUsuario) {
    //             return $query->where('asignacion_visita.id_inspector', $idUsuario);
    //         })
    //         ->orderBy('asignacion_visita.cod_asignacion', 'DESC')
    //         ->get();
    // }
    
    static function get_list_asignacion_visita($id_asignacion_visita=null,$dato){
        if(isset($id_asignacion_visita) && $id_asignacion_visita>0){
            $sql="SELECT * from asignacion_visita where id_asignacion_visita='$id_asignacion_visita'";
        }else{
            $sql="SELECT a.*,b.usuario_nombres,b.usuario_apater,b.usuario_amater,
            case when tipo_punto_partida=1 or tipo_punto_partida=2 then 
            (CASE WHEN c.responsable!='' THEN c.responsable ELSE c.nombre_proveedor END)
            when tipo_punto_partida=3 then a.punto_partida 
            when tipo_punto_partida=4 then 'Domicilio' end as desc_punto_partida,
            case when tipo_punto_llegada=1 or tipo_punto_llegada=2 then 
            (CASE WHEN d.responsable!='' THEN d.responsable ELSE d.nombre_proveedor END)
            when tipo_punto_llegada=3 then a.punto_llegada 
            when tipo_punto_llegada=4 then 'Domicilio' end as desc_punto_llegada,e.nom_tipo_transporte,
            (SELECT group_concat(distinct g.nom_tipo_transporte) from asignacion_visita_transporte f
            left join tipo_transporte_produccion g on f.id_tipo_transporte=g.id_tipo_transporte
            where f.estado=1 and f.id_asignacion_visita=a.id_asignacion_visita) as transporte,
            case when a.estado_registro=1 then 'Por Iniciar' when a.estado_registro=2 then 'Iniciado' when a.estado_registro=3 then 'Finalizado' end as desc_estado_registro,
            DATE_FORMAT(a.fec_ini_visita, '%H:%i') as fecha_inicio, DATE_FORMAT(a.fec_fin_visita, '%H:%i') as fecha_fin,
            (SELECT GROUP_CONCAT(DISTINCT h.modelo) 
            FROM ficha_tecnica_produccion h 
            WHERE FIND_IN_SET(h.id_ft_produccion, a.id_modelo)) AS modelos,
            (SELECT GROUP_CONCAT(DISTINCT concat(h.img_ft_produccion,'___',h.modelo)) 
            FROM ficha_tecnica_produccion h 
            WHERE FIND_IN_SET(h.id_ft_produccion, a.id_modelo)) AS url_modelos,
            ROUND(COALESCE((SELECT SUM(i.costo) FROM asignacion_visita_transporte i WHERE i.id_asignacion_visita=a.id_asignacion_visita and i.estado=1), 0),2) AS total_transporte,
            f.nom_proceso
            from asignacion_visita a 
            left join users b on a.id_inspector=b.id_usuario
            left join proveedor_general c on a.punto_partida=c.id_proveedor
            left join proveedor_general d on a.punto_llegada=d.id_proveedor
            left join tipo_transporte_produccion e on a.id_tipo_transporte=e.id_tipo_transporte
            left join proceso_visita f on a.id_proceso=f.id_procesov
            where a.estado=1 and a.fecha between '".$dato['fini']."' and '".$dato['ffin']."'";
        }
        
        $result = DB::select($sql);
        // Convertir el resultado a un array
        return $result;
    }
}
