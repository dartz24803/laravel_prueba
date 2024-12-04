<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BiReporte extends Model
{
    // Nombre de la tabla asociada al modelo
    protected $table = 'acceso_bi_reporte';
    protected $primaryKey = 'id_acceso_bi_reporte';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    // Definir los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nom_bi',
        'nom_intranet',
        'actividad',
        'id_area',
        'id_area_destino',
        'estado_valid',
        'id_usuario',
        'frecuencia_act',
        'objetivo',
        'img1',
        'img2',
        'img3',
        'iframe',
        'acceso_todo',
        'estado',
        'filtro_area',
        'filtro_sede',
        'filtro_ubicaciones',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli',
    ];

    // Configurar los campos de fecha
    protected $dates = [
        'fec_reg',
        'fec_act',
        'fec_eli',
    ];

    public static function getByAreaDestino($id_area_destino, $id_puesto, $id_centro_labor)
    {
        // Construir la consulta base
        $query = self::select('acceso_bi_reporte.*')
            ->distinct()
            ->join('bi_puesto_acceso', 'acceso_bi_reporte.id_acceso_bi_reporte', '=', 'bi_puesto_acceso.id_acceso_bi_reporte')
            ->where('acceso_bi_reporte.id_area_destino', $id_area_destino)
            ->where('acceso_bi_reporte.estado', 1)
            ->where('acceso_bi_reporte.actividad', 1)
            ->where('acceso_bi_reporte.estado_valid', 1)
            ->where('bi_puesto_acceso.id_puesto', $id_puesto);

        // Añadir condición `FIND_IN_SET` solo si `filtro_ubicaciones` no está vacío
        $query->where(function ($subQuery) use ($id_centro_labor) {
            $subQuery->where('acceso_bi_reporte.filtro_ubicaciones', '=', '')
                ->orWhereRaw("FIND_IN_SET(?, acceso_bi_reporte.filtro_ubicaciones) > 0", [$id_centro_labor]);
        });
        // dd($query);
        return $query->get();
    }




    public static function getBiReportesxIndicador()
    {
        return self::select(
            'acceso_bi_reporte.id_acceso_bi_reporte',
            'acceso_bi_reporte.nom_bi',
            'acceso_bi_reporte.nom_intranet',
            'acceso_bi_reporte.iframe',
            'acceso_bi_reporte.actividad',
            'acceso_bi_reporte.id_area',
            'acceso_bi_reporte.objetivo',
            'acceso_bi_reporte.frecuencia_act',
            'acceso_bi_reporte.id_usuario',
            'acceso_bi_reporte.estado',
            'acceso_bi_reporte.fec_act',
            'acceso_bi_reporte.fec_reg',
            'acceso_bi_reporte.fec_valid',
            'acceso_bi_reporte.estado_valid',
            'indicadores_bi.nom_indicador',
            'indicadores_bi.descripcion',
            'indicadores_bi.idtipo_indicador',
            'indicadores_bi.presentacion',
            'indicadores_bi.npagina',
            'tipo_indicador.nom_indicador as tipo_indicador_nombre',
        )
            ->leftJoin('indicadores_bi', 'acceso_bi_reporte.id_acceso_bi_reporte', '=', 'indicadores_bi.id_acceso_bi_reporte')
            ->leftJoin('tipo_indicador', 'indicadores_bi.idtipo_indicador', '=', 'tipo_indicador.idtipo_indicador')
            ->leftJoin('tablas_bi', 'acceso_bi_reporte.id_acceso_bi_reporte', '=', 'tablas_bi.id_acceso_bi_reporte')
            ->where('acceso_bi_reporte.estado', 1)
            ->where('acceso_bi_reporte.estado_valid', 1)
            ->groupBy(
                'acceso_bi_reporte.id_acceso_bi_reporte',
                'acceso_bi_reporte.nom_bi',
                'acceso_bi_reporte.nom_intranet',
                'acceso_bi_reporte.iframe',
                'acceso_bi_reporte.actividad',
                'acceso_bi_reporte.id_area',
                'acceso_bi_reporte.objetivo',
                'acceso_bi_reporte.frecuencia_act',
                'acceso_bi_reporte.id_usuario',
                'acceso_bi_reporte.estado',
                'acceso_bi_reporte.fec_act',
                'acceso_bi_reporte.fec_reg',
                'acceso_bi_reporte.fec_valid',
                'acceso_bi_reporte.estado_valid',
                'indicadores_bi.nom_indicador',
                'indicadores_bi.descripcion',
                'indicadores_bi.npagina',
                'indicadores_bi.idtipo_indicador',
                'indicadores_bi.presentacion',
                'tipo_indicador.nom_indicador'
            )
            ->orderBy('acceso_bi_reporte.fec_reg', 'ASC')
            ->get();
    }

    public static function getBiReportesxTablas()
    {
        return self::select(
            'acceso_bi_reporte.id_acceso_bi_reporte',
            'acceso_bi_reporte.nom_bi',
            'acceso_bi_reporte.nom_intranet',
            'acceso_bi_reporte.iframe',
            'acceso_bi_reporte.actividad',
            'acceso_bi_reporte.id_area',
            'acceso_bi_reporte.objetivo',
            'acceso_bi_reporte.frecuencia_act',
            'acceso_bi_reporte.id_usuario',
            'acceso_bi_reporte.estado',
            'acceso_bi_reporte.fec_act',
            'acceso_bi_reporte.fec_reg',
            'acceso_bi_reporte.fec_valid',
            'acceso_bi_reporte.estado_valid',
            'tablas_db.nombre as nom_tabla',
            'tablas_db.cod_db',
            'sistema_tablas.nom_sistema',
            'sistema_tablas.nom_db'
        )
            // Mantener el leftJoin con tablas_bi
            ->leftJoin('tablas_bi', 'acceso_bi_reporte.id_acceso_bi_reporte', '=', 'tablas_bi.id_acceso_bi_reporte')
            // Agregar innerJoin con tablas_db usando idtablas_db
            ->join('tablas_db', 'tablas_bi.idtablas_db', '=', 'tablas_db.idtablas_db')
            // Relacionar con sistema_tablas
            ->leftJoin('sistema_tablas', 'tablas_db.cod_db', '=', 'sistema_tablas.cod_db')

            ->where('acceso_bi_reporte.estado', 1)
            ->where('acceso_bi_reporte.estado_valid', 1)

            ->groupBy(
                'acceso_bi_reporte.id_acceso_bi_reporte',
                'acceso_bi_reporte.nom_bi',
                'acceso_bi_reporte.nom_intranet',
                'acceso_bi_reporte.iframe',
                'acceso_bi_reporte.actividad',
                'acceso_bi_reporte.id_area',
                'acceso_bi_reporte.objetivo',
                'acceso_bi_reporte.frecuencia_act',
                'acceso_bi_reporte.id_usuario',
                'acceso_bi_reporte.estado',
                'acceso_bi_reporte.fec_act',
                'acceso_bi_reporte.fec_reg',
                'acceso_bi_reporte.fec_valid',
                'acceso_bi_reporte.estado_valid',
                'tablas_db.nombre', // Agrupar por el nombre de tablas_db
                'tablas_db.cod_db', // Agrupar por el código de tablas_db
                'sistema_tablas.nom_sistema',
                'sistema_tablas.nom_db'
            )
            ->orderBy('acceso_bi_reporte.fec_reg', 'ASC')
            ->get();
    }
}
