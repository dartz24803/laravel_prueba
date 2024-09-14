<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function getListAsignacion()
    {
        return self::select(
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
            DB::raw("SUM(asignacion_visita_transporte.costo) as costo_total"),
            'asignacion_visita.inspector_acompaniante',
            'asignacion_visita.fec_ini_visita',
            'asignacion_visita.fec_fin_visita',
            'asignacion_visita.ch_alm',
            'asignacion_visita.ini_alm',
            'asignacion_visita.fin_alm',
            'asignacion_visita.estado_registro',
            'asignacion_visita.estado',
            DB::raw("CONCAT(users.usuario_apater, ' ', users.usuario_amater, ' ', users.usuario_nombres) AS nombre_completo"),
            'proveedor_partida.responsable as proveedor_responsable_partida',
            'proveedor_llegada.responsable as proveedor_responsable_llegada',
            'ficha_tecnica_produccion.modelo as nom_modelo',
            'proceso_visita.nom_proceso as nom_proceso',
            DB::raw("GROUP_CONCAT(tipo_transporte_produccion.nom_tipo_transporte SEPARATOR ', ') as nom_tipo_transporte")
        )
            ->join('users', 'asignacion_visita.id_inspector', '=', 'users.id_usuario')
            ->join('proveedor_general as proveedor_partida', 'asignacion_visita.punto_partida', '=', 'proveedor_partida.id_proveedor')
            ->join('proveedor_general as proveedor_llegada', 'asignacion_visita.punto_llegada', '=', 'proveedor_llegada.id_proveedor')
            ->join('ficha_tecnica_produccion', 'asignacion_visita.id_modelo', '=', 'ficha_tecnica_produccion.id_ft_produccion')
            ->join('proceso_visita', 'asignacion_visita.id_proceso', '=', 'proceso_visita.id_procesov')
            ->join('asignacion_visita_transporte', 'asignacion_visita.id_asignacion_visita', '=', 'asignacion_visita_transporte.id_asignacion_visita')
            ->join('tipo_transporte_produccion', 'asignacion_visita_transporte.id_tipo_transporte', '=', 'tipo_transporte_produccion.id_tipo_transporte')
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
                'proveedor_partida.responsable',
                'proveedor_llegada.responsable',
                'ficha_tecnica_produccion.modelo',
                'proceso_visita.nom_proceso',
                'users.usuario_apater',
                'users.usuario_amater',
                'users.usuario_nombres'
            )
            ->orderBy('asignacion_visita.fecha', 'DESC')
            ->get();
    }
}
