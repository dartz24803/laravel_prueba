<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Soporte extends Model
{
    use HasFactory;

    protected $table = 'soporte';

    public $timestamps = false;

    protected $primaryKey = 'id_soporte';

    protected $fillable = [
        'id_especialidad',
        'id_area',
        'id_elemento',
        'id_asunto',
        'id_sede',
        'idsoporte_nivel',
        'idsoporte_area_especifica',
        'codigo',
        'idsoporte_motivo_cancelacion',
        'idsoporte_tipo',
        'area_cancelacion',
        'idsoporte_solucion',
        'idsoporte_ejecutor',
        'id_responsable',
        'fec_vencimiento',
        'fec_cierre',
        'descripcion',
        'estado',
        'estado_registro',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'

    ];

    public static function listTicketsSoporte()
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_ubicacion2',
            'area.nom_area as nombre_area',
            'users.centro_labores as base',
            'users.usuario_nombres as usuario_nombre',
            'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion as idsoporte_motivo_cancelacion'


        )
            ->leftjoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftjoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftjoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftjoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftjoin('soporte_motivo_cancelacion', 'soporte.idsoporte_motivo_cancelacion', '=', 'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion')
            ->leftjoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftjoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftjoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftjoin('users', 'soporte.user_reg', '=', 'users.id_usuario')

            ->where('soporte.estado', 1)
            ->get();
    }


    public static function listTicketsSoporteMaster()
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_ubicacion2',
            'area.nom_area as nombre_area',
            'users.usuario_nombres as usuario_nombre',
            'users.centro_labores as base',
            'st.nombre as nombre_tipo',
            DB::raw("CASE WHEN soporte.id_responsable IS NULL THEN 'SIN DESIGNAR' ELSE us.usuario_nombres END as nombre_responsable")
        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->leftJoin('soporte_asunto as sa', 'soporte.id_asunto', '=', 'sa.idsoporte_asunto')
            ->leftJoin('users as us', 'soporte.id_responsable', '=', 'us.id_usuario')
            ->leftJoin('soporte_tipo as st', 'sa.idsoporte_tipo', '=', 'st.idsoporte_tipo')
            ->where('soporte.estado', 1)
            ->get();
    }

    public static function getTicketById($id_soporte)
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'soporte_asunto.idsoporte_tipo as idsoporte_tipo',
            'soporte_solucion.comentario as descripcion_solucion',
            'soporte_solucion.fec_comentario as fecha_comentario',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_ejecutor.nombre_proyecto as nombre_proyecto',
            'soporte_ejecutor.proveedor as proveedor',
            'soporte_ejecutor.nombre_contratista as nombre_contratista',
            'soporte_ejecutor.dni_prestador_servicio as dni_prestador_servicio',
            'soporte_ejecutor.ruc as ruc',
            'soporte_ejecutor.fec_inicio_proyecto as fec_inicio_proyecto',
            'soporte_ejecutor.idejecutor_responsable as idejecutor_responsable',
            'soporte_area_especifica.nombre as nombre_ubicacion2',
            'area.nom_area as nombre_area',
            'area_cancelacion.cod_area as cod_area',
            'users.usuario_nombres as usuario_nombre',
            'users.usuario_email as usuario_email',
            'users.centro_labores as base',
            'st.nombre as nombre_tipo',

            DB::raw("CASE 
                WHEN soporte.id_responsable IS NULL 
                THEN 'SIN DESIGNAR' 
                ELSE CONCAT(us.usuario_nombres, ' ', us.usuario_apater, ' ', us.usuario_amater) END as nombre_responsable_asignado"),
            DB::raw("CASE 
                WHEN soporte_solucion.id_responsable IS NULL 
                THEN 'SIN DESIGNAR' 
                ELSE CONCAT(usr.usuario_nombres, ' ', usr.usuario_apater, ' ', usr.usuario_amater) END as nombre_responsable_solucion"),
            'se.nombre as nombre_ejecutor_responsable',
            'usr.foto as foto_responsable_solucion'

        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('soporte_ejecutor', 'soporte.idsoporte_ejecutor', '=', 'soporte_ejecutor.idsoporte_ejecutor')
            ->leftJoin('soporte_motivo_cancelacion', 'soporte.idsoporte_motivo_cancelacion', '=', 'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion')
            ->leftJoin('soporte_solucion', 'soporte.idsoporte_solucion', '=', 'soporte_solucion.idsoporte_solucion')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area as area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('area as area_cancelacion', 'soporte.area_cancelacion', '=', 'area_cancelacion.id_area')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->leftJoin('soporte_asunto as sa', 'soporte.id_asunto', '=', 'sa.idsoporte_asunto')
            ->leftJoin('users as us', 'soporte.id_responsable', '=', 'us.id_usuario')
            ->leftJoin('users as usr', 'soporte_solucion.id_responsable', '=', 'usr.id_usuario')
            ->leftJoin('ejecutor_responsable as se', 'soporte_ejecutor.idejecutor_responsable', '=', 'se.idejecutor_responsable')
            ->leftJoin('soporte_tipo as st', 'sa.idsoporte_tipo', '=', 'st.idsoporte_tipo')
            ->where('soporte.id_soporte', $id_soporte)
            ->where('soporte.estado', 1)
            ->first();
    }
}
