<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\ProveedorGeneral;
use App\Models\SubGerencia;
use App\Models\TipoTransporteProduccion;
use Illuminate\Http\Request;

class AsignacionVisitaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        return view('manufactura.produccion.administracion.asignacion_visita.index', compact(
            'list_notificacion', 
            'list_subgerencia'
        ));
    }

    public function index_pr(Request $request)
    {
        $tipo = $request->tipo;
        return view('manufactura.produccion.administracion.asignacion_visita.proveedor.index', compact(
            'tipo'
        ));
    }

    public function list_pr(Request $request)
    {
        $list_proveedor = ProveedorGeneral::select('id_proveedor','ruc_proveedor','nombre_proveedor',
                        'responsable','celular_proveedor','email_proveedor','direccion_proveedor',
                        'coordsltd','coordslgt')->where('id_proveedor_mae',$request->tipo)
                        ->where('estado',1)->get();
        return view('manufactura.produccion.administracion.asignacion_visita.proveedor.lista', compact(
            'list_proveedor'
        ));
    }

    public function index_tt()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.index');
    }

    public function list_tt()
    {
        $list_tipo_transporte = TipoTransporteProduccion::select('id_tipo_transporte',
                                'nom_tipo_transporte')->where('estado',1)->get();
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.lista', compact(
            'list_tipo_transporte'
        ));
    }

    public function create_tt()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.modal_registrar');
    }

    public function store_tt(Request $request)
    {
        $request->validate([
            'nom_tipo_transporte' => 'required'
        ], [
            'nom_tipo_transporte.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoTransporteProduccion::where('nom_tipo_transporte', $request->nom_tipo_transporte)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoTransporteProduccion::create([
                'nom_tipo_transporte' => $request->nom_tipo_transporte,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_tt($id)
    {
        $get_id = TipoTransporteProduccion::findOrFail($id);
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.modal_editar', compact(
            'get_id'
        ));
    }

    public function update_tt(Request $request, $id)
    {
        $request->validate([
            'nom_tipo_transportee' => 'required'
        ], [
            'nom_tipo_transportee.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoTransporteProduccion::where('nom_tipo_transporte', $request->nom_tipo_transportee)
                ->where('estado', 1)->where('id_tipo_transporte', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoTransporteProduccion::findOrFail($id)->update([
                'nom_tipo_transporte' => $request->nom_tipo_transportee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_tt($id)
    {
        TipoTransporteProduccion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
