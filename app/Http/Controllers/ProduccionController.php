<?php

namespace App\Http\Controllers;

use App\Models\AsignacionVisita;
use App\Models\Gerencia;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_gerencia = Gerencia::where('estado', 1)->orderBy('nom_gerencia', 'ASC')->get();

        return view('manufactura.produccion.asignacion_visitas.index', compact('list_notificacion', 'list_gerencia'));
    }

    public function index_av()
    {
        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.index');
    }


    public function list_av()
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_asignacion = AsignacionVisita::select(
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
            'asignacion_visita.observacion_otros',
            'asignacion_visita.id_tipo_transporte',
            'asignacion_visita.costo',
            'asignacion_visita.inspector_acompaniante',
            'asignacion_visita.observacion',
            'asignacion_visita.fec_ini_visita',
            'asignacion_visita.fec_fin_visita',
            'asignacion_visita.ch_alm',
            'asignacion_visita.ini_alm',
            'asignacion_visita.fin_alm',
            'asignacion_visita.estado_registro',
            'asignacion_visita.estado'
        )
            ->where('asignacion_visita.estado', 1) // Ejemplo de filtro por estado
            ->orderBy('asignacion_visita.fecha', 'DESC') // Ejemplo de ordenamiento
            ->get();



        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.lista', compact('list_asignacion'));
    }
}
