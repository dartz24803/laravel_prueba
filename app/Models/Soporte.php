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
        'idsoporte_tipo',
        'idsoporte_solucion',
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
            'users.usuario_nombres as usuario_nombre'

        )
            ->leftjoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftjoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftjoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftjoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
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
            'soporte_solucion.comentario as descripcion_solucion',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_ubicacion2',
            'area.nom_area as nombre_area',
            'users.usuario_nombres as usuario_nombre',
            'users.centro_labores as base',
            'st.nombre as nombre_tipo',
            DB::raw("CASE 
            WHEN soporte.id_responsable IS NULL 
            THEN 'SIN DESIGNAR' 
            ELSE CONCAT(us.usuario_nombres, ' ',us.usuario_apater, ' ', us.usuario_amater)  END as nombre_responsable")

        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('soporte_solucion', 'soporte.idsoporte_solucion', '=', 'soporte_solucion.idsoporte_solucion')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->leftJoin('soporte_asunto as sa', 'soporte.id_asunto', '=', 'sa.idsoporte_asunto')
            ->leftJoin('users as us', 'soporte.id_responsable', '=', 'us.id_usuario')
            ->leftJoin('soporte_tipo as st', 'sa.idsoporte_tipo', '=', 'st.idsoporte_tipo')
            ->where('soporte.id_soporte', $id_soporte)  // Filtrar por ID del soporte
            ->where('soporte.estado', 1)  // Asegurarse de que el estado sea 1
            ->first();  // Obtener el primer registro (único)
    }
}
