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

    protected $fillable = ['id_especialidad', 'id_area', 'id_elemento', 'id_asunto', 'id_sede', 'idsoporte_nivel', 'idsoporte_area_especifica', 'codigo', 'idsoporte_motivo_cancelacion', 'area_cancelacion', 'id_segundo_responsable', 'idsoporte_solucion', 'img1', 'img2', 'img3', 'img4', 'img5', 'idsoporte_ejecutor', 'id_responsable', 'fec_vencimiento', 'fec_cierre', 'fec_cierre_sr', 'descripcion', 'estado', 'estado_registro', 'estado_registro_sr', 'fec_reg', 'user_reg', 'fec_act', 'user_act', 'fec_eli', 'user_eli', 'tipo_otros', 'activo_tipo'];

    public static function listTicketsSoporte()
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_area_especifica',
            'area.nom_area as nombre_area',
            'users.centro_labores as base',
            DB::raw("IF(users.usuario_apater IS NOT NULL AND users.usuario_apater != '', CONCAT(users.usuario_nombres, ' ', users.usuario_apater), users.usuario_nombres) as usuario_nombre_completo"),
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
            ->orderBy('soporte.fec_reg', 'DESC')
            ->get();
    }

    public static function listTicketsSoporteMaster($id_subgerencia)
    {
        // Obtener los IDs de área según el id_subgerencia
        $areas = self::getAreasBySubgerencia($id_subgerencia);
        // Convertir el array de áreas a una cadena separada por comas
        $areasString = implode(',', $areas);

        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_area_especifica',
            'area.nom_area as nombre_area',
            DB::raw("IF(users.usuario_apater IS NOT NULL AND users.usuario_apater != '', CONCAT(users.usuario_nombres, ' ', users.usuario_apater), users.usuario_nombres) as usuario_nombre_completo"),
            'users.centro_labores as base',
            DB::raw("
                CASE 
                    WHEN soporte.activo_tipo = 1 THEN 
                        CASE 
                            WHEN soporte.tipo_otros IS NULL THEN 'Otro'
                            WHEN soporte.tipo_otros = 0 THEN 'Otro'
                            WHEN soporte.tipo_otros = 1 THEN 'Requerimiento'
                            WHEN soporte.tipo_otros = 2 THEN 'Incidente'
                            ELSE st.nombre 
                        END 
                    ELSE st.nombre 
                END as nombre_tipo
            "),
            DB::raw("CASE WHEN soporte.id_responsable IS NULL AND soporte.id_segundo_responsable IS NOT NULL THEN us2.usuario_nombres WHEN soporte.id_responsable IS NOT NULL AND soporte.id_segundo_responsable IS NULL THEN us.usuario_nombres WHEN soporte.id_responsable IS NOT NULL AND soporte.id_segundo_responsable IS NOT NULL THEN CONCAT(us.usuario_nombres, ' / ', us2.usuario_nombres) ELSE 'SIN DESIGNAR' END as nombre_responsable")
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
            ->leftJoin('users as us2', 'soporte.id_segundo_responsable', '=', 'us2.id_usuario')
            ->leftJoin('soporte_tipo as st', 'sa.idsoporte_tipo', '=', 'st.idsoporte_tipo')
            ->where('soporte.estado', 1)
            ->where(function ($query) use ($areas, $areasString) {
                $query
                    // Filtrar cuando activo_tipo = 1 y el id_area está en soporte(FILTROS PARA CUANDO ASUNTO ES "OTROS")
                    ->where(function ($subQuery) use ($areas) {
                        $subQuery->where('soporte.activo_tipo', 1)
                            ->whereIn('soporte.id_area', $areas);
                    })
                    // Filtrar cuando activo_tipo = 0 y el id_area está en soporte_asunto (FILTRO PARA CUANDO SI HAY ASUNTO)
                    ->orWhere(function ($subQuery) use ($areasString) {
                        $subQuery->where('soporte.activo_tipo', 0)
                            ->whereExists(function ($existsQuery) use ($areasString) {
                                $existsQuery->select(DB::raw(1))
                                    ->from('soporte_asunto as sa')
                                    ->whereColumn('sa.idsoporte_asunto', 'soporte.id_asunto')
                                    ->whereRaw("FIND_IN_SET(sa.id_area, ?)", [$areasString]);
                            });
                    });
            })
            // Mostrar siempre el soporte cuando responsable_multiple es igual a 1 en soporte_asunto (FILTRO PARA AMBAS AREAS)
            ->orWhereExists(function ($existsQuery) {
                $existsQuery->select(DB::raw(1))
                    ->from('soporte_asunto as sa')
                    ->whereColumn('sa.idsoporte_asunto', 'soporte.id_asunto')
                    ->where('sa.responsable_multiple', 1);
            })
            ->orderBy('soporte.fec_reg', 'DESC')
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
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_ejecutor.nombre_proyecto as nombre_proyecto',
            'soporte_ejecutor.proveedor as proveedor',
            'soporte_ejecutor.nombre_contratista as nombre_contratista',
            'soporte_ejecutor.dni_prestador_servicio as dni_prestador_servicio',
            'soporte_ejecutor.ruc as ruc',
            'soporte_ejecutor.fec_inicio_proyecto as fec_inicio_proyecto',
            'soporte_ejecutor.idejecutor_responsable as idejecutor_responsable',
            'soporte_area_especifica.nombre as nombre_area_especifica',
            'soporte_solucion.archivo1 as archivo1',
            'soporte_solucion.archivo2 as archivo2',
            'soporte_solucion.archivo3 as archivo3',
            'soporte_solucion.archivo4 as archivo4',
            'soporte_solucion.archivo5 as archivo5',
            'soporte_solucion.documento1 as documento1',
            'soporte_solucion.documento2 as documento2',
            'soporte_solucion.documento3 as documento3',
            'area.nom_area as nombre_area',
            'area_cancelacion.cod_area as cod_area',
            'users.usuario_nombres as usuario_nombre',
            'users.usuario_email as usuario_email',
            'users.centro_labores as base',
            DB::raw("
                CASE 
                    WHEN soporte.activo_tipo = 1 THEN 
                        CASE 
                            WHEN soporte.tipo_otros IS NULL THEN 'Otro'
                            WHEN soporte.tipo_otros = 0 THEN 'Otro'
                            WHEN soporte.tipo_otros = 1 THEN 'Requerimiento'
                            WHEN soporte.tipo_otros = 2 THEN 'Incidente'
                            ELSE st.nombre 
                        END 
                    ELSE st.nombre 
                END as nombre_tipo
            "),
            DB::raw("CASE
                WHEN soporte.id_responsable IS NULL
                THEN 'SIN DESIGNAR'
                ELSE CONCAT(us.usuario_nombres, ' ', us.usuario_apater, ' ', us.usuario_amater) END as nombre_responsable_asignado"),
            DB::raw("CASE 
                WHEN se.idejecutor_responsable IS NULL 
                THEN 'POR DESIGNAR' 
                WHEN se.idejecutor_responsable REGEXP '^[0-9]+$' 
                THEN se.nombre 
                WHEN se.idejecutor_responsable REGEXP '^[0-9]+(,[0-9]+)*,$' 
                THEN 'AREA' 
                ELSE se.nombre 
            END as nombre_ejecutor_responsable"),
            DB::raw("CASE 
                WHEN se.idejecutor_responsable IS NULL 
                THEN 'POR DESIGNAR' 
                WHEN se.idejecutor_responsable REGEXP '^[0-9]+$' 
                THEN se.nombre 
                WHEN se.idejecutor_responsable REGEXP '^[0-9]+(,[0-9]+)*,$' 
                THEN 'AREA' 
                ELSE se.nombre 
            END as nombre_ejecutor_responsable"),
            // Agregar la validación para la existencia de comentarios
            DB::raw("CASE 
                WHEN sc.idsoporte_comentarios IS NOT NULL THEN true
                ELSE false
            END as comentario_existe"),
        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('soporte_solucion', 'soporte.idsoporte_solucion', '=', 'soporte_solucion.idsoporte_solucion')
            ->leftJoin('soporte_comentarios as sc', 'soporte_solucion.idsoporte_solucion', '=', 'sc.idsoporte_solucion')
            ->leftJoin('soporte_ejecutor', 'soporte.idsoporte_ejecutor', '=', 'soporte_ejecutor.idsoporte_ejecutor')
            ->leftJoin('soporte_motivo_cancelacion', 'soporte.idsoporte_motivo_cancelacion', '=', 'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area as area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('area as area_cancelacion', 'soporte.area_cancelacion', '=', 'area_cancelacion.id_area')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->leftJoin('soporte_asunto as sa', 'soporte.id_asunto', '=', 'sa.idsoporte_asunto')
            ->leftJoin('users as us', 'soporte.id_responsable', '=', 'us.id_usuario')
            ->leftJoin('ejecutor_responsable as se', 'soporte_ejecutor.idejecutor_responsable', '=', 'se.idejecutor_responsable')
            ->leftJoin('soporte_tipo as st', 'sa.idsoporte_tipo', '=', 'st.idsoporte_tipo')
            ->where('soporte.id_soporte', $id_soporte)
            ->where('soporte.estado', 1)
            ->first();
    }




    public static function obtenerListadoAreasInvolucradas($id_soporte)
    {
        $query = DB::table('soporte')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto') // Primer LEFT JOIN con soporte_asunto
            ->leftJoin('users as user1', 'soporte.id_responsable', '=', 'user1.id_usuario') // JOIN para el primer responsable
            ->leftJoin('users as user2', 'soporte.id_segundo_responsable', '=', 'user2.id_usuario') // JOIN para el segundo responsable
            ->where('soporte.id_soporte', $id_soporte)
            ->select(
                'soporte.*',
                'soporte_asunto.*',
                DB::raw("CONCAT(user1.usuario_nombres, ' ', user1.usuario_apater) as nom_responsable_1"), // Nombre completo primer responsable
                DB::raw("CONCAT(user2.usuario_nombres, ' ', user2.usuario_apater) as nom_responsable_2")  // Nombre completo segundo responsable
            )
            ->first();

        if (!empty($query->id_area)) {
            $id_areas = $query->id_area;
            $areasArray = explode(',', $id_areas);
            $resultado = [];
            // Primer área responsable
            $area1 = DB::table('area')
                ->leftJoin('soporte', 'area.id_area', '=', DB::raw($areasArray[0])) // LEFT JOIN con la tabla area
                ->select('area.nom_area', 'area.id_departamento', 'area.cod_area')
                ->where('soporte.id_soporte', $id_soporte)
                ->first();

            $resultado[] = [
                "area_responsable" => $area1 ? $area1->nom_area : null,
                "cod_area_responsable" => $area1 ? $area1->cod_area : null,
                "id_departamento" => $area1 ? $area1->id_departamento : null,
                "id_responsable" => $query->id_responsable,
                "nom_responsable" => $query->nom_responsable_1, // Nombre completo primer responsable
                "fec_cierre" => $query->fec_cierre,
                "estado_registro" => $query->estado_registro
            ];

            // Segundo área responsable
            if (isset($areasArray[1])) {
                $area2 = DB::table('area')
                    ->leftJoin('soporte', 'area.id_area', '=', DB::raw($areasArray[1])) // LEFT JOIN con la tabla area
                    ->select('area.nom_area', 'area.id_departamento', 'area.cod_area')
                    ->where('soporte.id_soporte', $id_soporte)
                    ->first();
                $resultado[] = [
                    "area_responsable" => $area2 ? $area2->nom_area : null,
                    "cod_area_responsable" => $area2 ? $area2->cod_area : null,
                    "id_departamento" => $area2 ? $area2->id_departamento : null,
                    "id_responsable" => $query->id_segundo_responsable,
                    "nom_responsable" => $query->nom_responsable_2, // Nombre completo segundo responsable
                    "fec_cierre" => $query->fec_cierre_sr,
                    "estado_registro" => $query->estado_registro_sr
                ];
            }
            return $resultado;
        }
        return [];
    }



    public static function getAreasBySubgerencia($id_subgerencia)
    {
        return DB::table('area')
            ->select('id_area')
            ->where('id_departamento', $id_subgerencia)
            ->pluck('id_area')
            ->toArray();
    }

    public static function getResponsableMultipleByAsunto($id_asunto)
    {
        // Realiza el LEFT JOIN y obtiene el campo responsable_multiple
        $responsable = DB::table('soporte')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->select('soporte_asunto.responsable_multiple')
            ->where('soporte.id_asunto', $id_asunto)
            ->first();

        // Retorna el campo responsable_multiple, o null si no se encuentra
        return $responsable ? $responsable->responsable_multiple : null;
    }
    public static function getCodAreaByAsunto($id_asunto)
    {
        // Obtén el registro de soporte_asunto directamente sin unirte a soporte
        $result = DB::table('soporte_asunto')
            ->select('responsable_multiple', 'id_area')
            ->where('idsoporte_asunto', $id_asunto)
            ->first();
        if (!$result) {
            return null;
        }
        $idAreas = explode(',', $result->id_area);
        $codAreas = DB::table('area')
            ->whereIn('id_area', $idAreas)
            ->pluck('cod_area')
            ->toArray();

        return [
            'responsable_multiple' => $result->responsable_multiple,
            'cod_area' => implode('-', $codAreas) // Formato "TI -MTO"
        ];
    }

    public static function getCodAreaByIdArea($id_area)
    {
        $result = DB::table('soporte')
            ->leftJoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->select('area.cod_area')
            ->where('soporte.id_area', $id_area)
            ->first();

        // Si no se encuentra el resultado, retornar null
        if (!$result) {
            return null;
        }
        return [
            'cod_area' => $result->cod_area, // Se devuelve el valor de cod_area de la tabla area
        ];
    }



    public static function listTablaGeneralSoporte()
    {
        return self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_area_especifica',
            'users.centro_labores as base',
            'users.usuario_nombres as usuario_nombre',
            'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion as idsoporte_motivo_cancelacion',
            DB::raw("
                CASE 
                    WHEN soporte.id_area = 0 THEN (
                        SELECT GROUP_CONCAT(area.nom_area SEPARATOR ', ')
                        FROM area
                        WHERE FIND_IN_SET(area.id_area, soporte_asunto.id_area) > 0
                    )
                    ELSE area.nom_area
                END as nombre_area
            "),
            DB::raw("
                CASE 
                    WHEN responsable.id_usuario IS NULL AND segundo_responsable.id_usuario IS NULL THEN 'SIN ASIGNAR'
                    WHEN responsable.id_usuario IS NULL THEN CONCAT(segundo_responsable.usuario_nombres, ' ', segundo_responsable.usuario_apater)
                    WHEN segundo_responsable.id_usuario IS NULL THEN CONCAT(responsable.usuario_nombres, ' ', responsable.usuario_apater)
                    ELSE CONCAT(responsable.usuario_nombres, ' ', responsable.usuario_apater, ' / ', segundo_responsable.usuario_nombres, ' ', segundo_responsable.usuario_apater)
                END as nombres_responsables
            "),
            DB::raw("
            CASE 
                    WHEN soporte_asunto.idsoporte_tipo = 1 THEN 'Requerimiento'
                    WHEN soporte_asunto.idsoporte_tipo = 2 THEN 'Incidente'
                    ELSE 'Desconocido'
                END as tipo_soporte
            ")
        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_motivo_cancelacion', 'soporte.idsoporte_motivo_cancelacion', '=', 'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('users as responsable', 'soporte.id_responsable', '=', 'responsable.id_usuario')
            ->leftJoin('users as segundo_responsable', 'soporte.id_segundo_responsable', '=', 'segundo_responsable.id_usuario')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->where('soporte.estado', 1)
            ->orderBy('soporte.fec_reg', 'DESC')
            ->get();
    }


    public static function listTablaGeneralSoporteFiltro($dato)
    {
        $query = self::select(
            'soporte.*',
            'soporte_elemento.nombre as nombre_elemento',
            'especialidad.nombre as nombre_especialidad',
            'soporte_asunto.nombre as nombre_asunto',
            'sede_laboral.descripcion as nombre_sede',
            'soporte_nivel.nombre as nombre_ubicacion',
            'soporte_area_especifica.nombre as nombre_area_especifica',
            'users.centro_labores as base',
            'users.usuario_nombres as usuario_nombre',
            'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion as idsoporte_motivo_cancelacion',
            DB::raw("CASE 
                        WHEN soporte.id_area = 0 THEN (
                            SELECT GROUP_CONCAT(area.nom_area SEPARATOR ', ')
                            FROM area
                            WHERE FIND_IN_SET(area.id_area, soporte_asunto.id_area) > 0
                        )
                        ELSE area.nom_area
                    END as nombre_area"),
            DB::raw("CASE 
                        WHEN responsable.id_usuario IS NULL AND segundo_responsable.id_usuario IS NULL THEN 'SIN ASIGNAR'
                        WHEN responsable.id_usuario IS NULL THEN CONCAT(segundo_responsable.usuario_nombres, ' ', segundo_responsable.usuario_apater)
                        WHEN segundo_responsable.id_usuario IS NULL THEN CONCAT(responsable.usuario_nombres, ' ', responsable.usuario_apater)
                        ELSE CONCAT(responsable.usuario_nombres, ' ', responsable.usuario_apater, ' / ', segundo_responsable.usuario_nombres, ' ', segundo_responsable.usuario_apater)
                    END as nombres_responsables"),
            DB::raw("CASE 
                        WHEN soporte_asunto.idsoporte_tipo = 1 THEN 'Requerimiento'
                        WHEN soporte_asunto.idsoporte_tipo = 2 THEN 'Incidente'
                        ELSE 'Desconocido'
                    END as tipo_soporte")
        )
            ->leftJoin('especialidad', 'soporte.id_especialidad', '=', 'especialidad.id')
            ->leftJoin('soporte_elemento', 'soporte.id_elemento', '=', 'soporte_elemento.idsoporte_elemento')
            ->leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
            ->leftJoin('sede_laboral', 'soporte.id_sede', '=', 'sede_laboral.id')
            ->leftJoin('soporte_motivo_cancelacion', 'soporte.idsoporte_motivo_cancelacion', '=', 'soporte_motivo_cancelacion.idsoporte_motivo_cancelacion')
            ->leftJoin('soporte_nivel', 'soporte.idsoporte_nivel', '=', 'soporte_nivel.idsoporte_nivel')
            ->leftJoin('soporte_area_especifica', 'soporte.idsoporte_area_especifica', '=', 'soporte_area_especifica.idsoporte_area_especifica')
            ->leftJoin('area', 'soporte.id_area', '=', 'area.id_area')
            ->leftJoin('users as responsable', 'soporte.id_responsable', '=', 'responsable.id_usuario')
            ->leftJoin('users as segundo_responsable', 'soporte.id_segundo_responsable', '=', 'segundo_responsable.id_usuario')
            ->leftJoin('users', 'soporte.user_reg', '=', 'users.id_usuario')
            ->where('soporte.estado', 1);

        // Filtrar por fechas si están presentes en los datos
        if (!empty($dato['fecha_iniciob'])) {
            $query->whereDate('soporte.fec_reg', '>=', $dato['fecha_iniciob']);
        }

        if (!empty($dato['fecha_finb'])) {
            $query->whereDate('soporte.fec_reg', '<=', $dato['fecha_finb']);
        }
        $query->where(function ($q) use ($dato) {
            if ($dato['cpiniciar'] == 1) {
                $q->orWhere('soporte.estado_registro', 1); // "Por Iniciar"
            }
            if ($dato['cproceso'] == 1) {
                $q->orWhere('soporte.estado_registro', 2); // "En Proceso"
            }
            if ($dato['ccompletado'] == 1) {
                $q->orWhere('soporte.estado_registro', 3); // "Completado"
            }
            if ($dato['cstandby'] == 1) {
                $q->orWhere('soporte.estado_registro', 4); // "Stand By"
            }
            if ($dato['ccancelado'] == 1) {
                $q->orWhere('soporte.estado_registro', 5); // "Cancelado"
            }
        });
        return $query->orderBy('soporte.fec_reg', 'DESC')->get();
    }



    public static function userExistsInAreaWithPuesto($id_area, $id_usuario)
    {

        $user = DB::table('users')
            ->select('users.*', 'puesto.*')
            ->leftJoin('puesto', 'puesto.id_puesto', '=', 'users.id_puesto')
            ->where('users.estado', 1)
            ->where('puesto.id_area', $id_area)
            ->where('users.id_usuario', $id_usuario)
            ->first();

        return $user ? true : false;
    }
}
