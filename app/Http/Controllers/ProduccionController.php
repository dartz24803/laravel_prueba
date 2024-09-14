<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AsignacionVisita;
use App\Models\FichaTecnicaProduccion;
use App\Models\Gerencia;
use App\Models\Notificacion;
use App\Models\ProcesoVisita;
use App\Models\ProveedorGeneral;
use App\Models\User;
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
        $list_asignacion = AsignacionVisita::getListAsignacion();
        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.lista', compact('list_asignacion'));
    }

    public function create_av()
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_inspector = User::select(
            'id_usuario',
            DB::raw("CONCAT(usuario_apater, ' ', usuario_amater, ' ', usuario_nombres) AS nombre_completo")
        )
            ->where('estado', 1)
            ->where('id_area', 2)
            ->orderBy('usuario_nombres', 'ASC')
            ->distinct('usuario_nombres')
            ->get();

        $list_proveedor = ProveedorGeneral::select(
            'id_proveedor',
            DB::raw("CONCAT(nombre_proveedor, ' - ', ruc_proveedor, ' - ', responsable) AS nombre_proveedor_completo")
        )
            ->where('estado', 1)
            ->where('id_proveedor_mae', 2)
            ->orderBy('ruc_proveedor', 'ASC')
            ->distinct('ruc_proveedor')
            ->get();

        $list_ficha_tecnica = FichaTecnicaProduccion::select('id_ft_produccion', 'modelo')
            ->where('estado', 1)
            ->orderBy('modelo', 'ASC')
            ->distinct('modelo')
            ->get();


        $list_proceso_visita = ProcesoVisita::select('id_procesov', 'nom_proceso')
            ->where('estado', 1)
            ->orderBy('nom_proceso', 'ASC')
            ->distinct('nom_proceso')
            ->get();

        return view('manufactura.produccion.asignacion_visitas.asignacion_visitas.modal_registrar', compact('list_area', 'list_inspector', 'list_proveedor', 'list_ficha_tecnica', 'list_proceso_visita'));
    }
}
