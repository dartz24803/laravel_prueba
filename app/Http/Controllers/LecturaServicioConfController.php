<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\DatosServicio;
use App\Models\ProveedorServicio;
use App\Models\SegLugarServicio;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturaServicioConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.administracion.lectura_servicio.index');
    }

    public function index_se()
    {
        return view('seguridad.administracion.lectura_servicio.servicio.index');
    }

    public function list_se()
    {
        $list_servicio = Servicio::select('id_servicio','nom_servicio',DB::raw('CASE WHEN lectura=1 THEN "SI" ELSE "NO" END AS lectura'))
                        ->where('tipodeed',NULL)->where('estado', 1)->get();
        return view('seguridad.administracion.lectura_servicio.servicio.lista', compact('list_servicio'));
    }

    public function create_se()
    {
        return view('seguridad.administracion.lectura_servicio.servicio.modal_registrar');
    }

    public function store_se(Request $request)
    {
        $request->validate([
            'nom_servicio' => 'required',
            'lectura' => 'gt:0'
        ],[
            'nom_servicio.required' => 'Debe ingresar nombre.',
            'lectura.gt' => 'Debe seleccionar lectura.'
        ]);

        $valida = Servicio::where('nom_servicio', $request->nom_servicio)->where('lectura', $request->lectura)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Servicio::create([
                'nom_servicio' => $request->nom_servicio,
                'lectura' => $request->lectura,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_se($id)
    {
        $get_id = Servicio::findOrFail($id);
        return view('seguridad.administracion.lectura_servicio.servicio.modal_editar', compact('get_id'));
    }

    public function update_se(Request $request, $id)
    {
        $request->validate([
            'nom_servicioe' => 'required',
            'lecturae' => 'gt:0'
        ],[
            'nom_servicioe.required' => 'Debe ingresar nombre.',
            'lecturae.gt' => 'Debe seleccionar lectura.'
        ]);

        $valida = Servicio::where('nom_servicio', $request->nom_servicioe)->where('lectura', $request->lecturae)
                ->where('estado', 1)->where('id_servicio', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Servicio::findOrFail($id)->update([
                'nom_servicio' => $request->nom_servicioe,
                'lectura' => $request->lecturae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_se($id)
    {
        Servicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
    
    public function index_pr()
    {
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.index');
    }

    public function list_pr()
    {
        $list_proveedor_servicio = ProveedorServicio::select('proveedor_servicio.id_proveedor_servicio',
                                'proveedor_servicio.cod_base','servicio.nom_servicio',
                                'proveedor_servicio.nom_proveedor_servicio',
                                'proveedor_servicio.ruc_proveedor_servicio',
                                'proveedor_servicio.dir_proveedor_servicio',
                                'proveedor_servicio.tel_proveedor_servicio',
                                'proveedor_servicio.contacto_proveedor_servicio',
                                'proveedor_servicio.telefono_contacto')
                                ->join('servicio','servicio.id_servicio','=','proveedor_servicio.id_servicio')
                                ->where('proveedor_servicio.estado', 1)->get();
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.lista', compact('list_proveedor_servicio'));
    }

    public function create_pr()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_servicio = Servicio::select('id_servicio','nom_servicio')->where('tipodeed',NULL)->where('estado',1)
                        ->orderBy('nom_servicio','ASC')->get();
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.modal_registrar', compact(['list_base','list_servicio']));
    }

    public function store_pr(Request $request)
    {
        $request->validate([
            'cod_base' => 'not_in:0',
            'id_servicio' => 'gt:0',
            'nom_proveedor_servicio' => 'required',
        ],[
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_servicio.gt' => 'Debe seleccionar servicio.',
            'nom_proveedor_servicio.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ProveedorServicio::where('cod_base', $request->cod_base)->where('id_servicio', $request->id_servicio)
                ->where('nom_proveedor_servicio', $request->nom_proveedor_servicio)->where('estado', 1)
                ->exists();
        if($valida){
            echo "error";
        }else{
            ProveedorServicio::create([
                'cod_base' => $request->cod_base,
                'id_servicio' => $request->id_servicio,
                'nom_proveedor_servicio' => $request->nom_proveedor_servicio,
                'ruc_proveedor_servicio' => $request->ruc_proveedor_servicio,
                'dir_proveedor_servicio' => $request->dir_proveedor_servicio,
                'tel_proveedor_servicio' => $request->tel_proveedor_servicio,
                'contacto_proveedor_servicio' => $request->contacto_proveedor_servicio,
                'telefono_contacto' => $request->telefono_contacto,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_pr($id)
    {
        $get_id = ProveedorServicio::findOrFail($id);
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_servicio = Servicio::select('id_servicio','nom_servicio')->where('tipodeed',NULL)->where('estado',1)
                        ->orderBy('nom_servicio','ASC')->get();
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.modal_editar', compact('get_id','list_base','list_servicio'));
    }

    public function update_pr(Request $request, $id)
    {
        $request->validate([
            'cod_basee' => 'not_in:0',
            'id_servicioe' => 'gt:0',
            'nom_proveedor_servicioe' => 'required',
        ],[
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'id_servicioe.gt' => 'Debe seleccionar servicio.',
            'nom_proveedor_servicioe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ProveedorServicio::where('cod_base', $request->cod_basee)->where('id_servicio', $request->id_servicioe)
                ->where('nom_proveedor_servicio', $request->nom_proveedor_servicioe)->where('estado', 1)
                ->where('id_proveedor_servicio', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ProveedorServicio::findOrFail($id)->update([
                'cod_base' => $request->cod_basee,
                'id_servicio' => $request->id_servicioe,
                'nom_proveedor_servicio' => $request->nom_proveedor_servicioe,
                'ruc_proveedor_servicio' => $request->ruc_proveedor_servicioe,
                'dir_proveedor_servicio' => $request->dir_proveedor_servicioe,
                'tel_proveedor_servicio' => $request->tel_proveedor_servicioe,
                'contacto_proveedor_servicio' => $request->contacto_proveedor_servicioe,
                'telefono_contacto' => $request->telefono_contactoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_pr($id)
    {
        ProveedorServicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_da()
    {
        return view('seguridad.administracion.lectura_servicio.datos_servicio.index');
    }

    public function list_da()
    {
        $list_datos_servicio = DatosServicio::leftJoin('proveedor_servicio', 'datos_servicio.id_proveedor_servicio', '=', 'proveedor_servicio.id_proveedor_servicio')
                                ->select('datos_servicio.id_datos_servicio','seg_lugar_servicio.nom_lugar_servicio',
                                'datos_servicio.cod_base','servicio.nom_servicio',
                                'proveedor_servicio.nom_proveedor_servicio',
                                'datos_servicio.contrato_servicio','datos_servicio.medidor',
                                'datos_servicio.suministro','datos_servicio.ruta',
                                'datos_servicio.cliente','datos_servicio.doc_cliente')
                                ->join('servicio','servicio.id_servicio','=','datos_servicio.id_servicio')
                                ->join('seg_lugar_servicio','seg_lugar_servicio.id_lugar_servicio','=','datos_servicio.id_lugar_servicio')
                                ->where('datos_servicio.estado', 1)->get();
        return view('seguridad.administracion.lectura_servicio.datos_servicio.lista', compact('list_datos_servicio'));
    }

    public function create_da()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_lugar = SegLugarServicio::all();
        return view('seguridad.administracion.lectura_servicio.datos_servicio.modal_registrar', compact(['list_lugar','list_base']));
    }

    public function traer_servicio_da(Request $request)
    {
        $list_servicio = ProveedorServicio::select('proveedor_servicio.id_servicio','servicio.nom_servicio')
                        ->join('servicio','servicio.id_servicio','=','proveedor_servicio.id_servicio')
                        ->where('proveedor_servicio.cod_base',$request->cod_base)->where('proveedor_servicio.estado',1)
                        ->groupBy('proveedor_servicio.id_servicio','servicio.nom_servicio')
                        ->orderBy('servicio.nom_servicio','ASC')->get();
        return view('seguridad.administracion.lectura_servicio.datos_servicio.servicio',compact('list_servicio'));
    }

    public function traer_proveedor_servicio_da(Request $request)
    {
        $list_proveedor_servicio = ProveedorServicio::select('id_proveedor_servicio','nom_proveedor_servicio')
                                    ->where('cod_base',$request->cod_base)->where('id_servicio',$request->id_servicio)
                                    ->where('estado',1)->orderBy('nom_proveedor_servicio','ASC')->get();
        return view('seguridad.administracion.lectura_servicio.datos_servicio.proveedor_servicio',compact('list_proveedor_servicio'));
    }

    public function store_da(Request $request)
    {
        $request->validate([
            'id_lugar_servicio' => 'gt:0',
            'cod_base' => 'not_in:0',
            'id_servicio' => 'gt:0',
        ],[
            'id_lugar_servicio.gt' => 'Debe seleccionar lugar.',
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_servicio.gt' => 'Debe seleccionar servicio.',
        ]);

        $valida = DatosServicio::where('cod_base', $request->cod_base)->where('id_servicio', $request->id_servicio)
                ->where('id_proveedor_servicio', $request->id_proveedor_servicio)
                ->where('contrato_servicio', $request->contrato_servicio)
                ->where('medidor', $request->medidor)->where('suministro', $request->suministro)
                ->where('id_lugar_servicio', $request->id_lugar_servicio)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            DatosServicio::create([
                'cod_base' => $request->cod_base,
                'id_servicio' => $request->id_servicio,
                'id_proveedor_servicio' => $request->id_proveedor_servicio,
                'id_lugar_servicio' => $request->id_lugar_servicio,
                'contrato_servicio' => $request->contrato_servicio,
                'medidor' => $request->medidor,
                'suministro' => $request->suministro,
                'ruta' => $request->ruta,
                'cliente' => $request->cliente,
                'doc_cliente' => $request->doc_cliente,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_da($id)
    {
        $get_id = DatosServicio::findOrFail($id);
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_lugar = SegLugarServicio::all();
        $list_servicio = ProveedorServicio::select('proveedor_servicio.id_servicio','servicio.nom_servicio')
                        ->join('servicio','servicio.id_servicio','=','proveedor_servicio.id_servicio')
                        ->where('proveedor_servicio.cod_base',$get_id->cod_base)->where('proveedor_servicio.estado',1)
                        ->groupBy('proveedor_servicio.id_servicio','servicio.nom_servicio')
                        ->orderBy('servicio.nom_servicio','ASC')->get();
        $list_proveedor_servicio = ProveedorServicio::select('id_proveedor_servicio','nom_proveedor_servicio')
                        ->where('cod_base',$get_id->cod_base)->where('id_servicio',$get_id->id_servicio)
                        ->where('estado',1)->orderBy('nom_proveedor_servicio','ASC')->get();
        return view('seguridad.administracion.lectura_servicio.datos_servicio.modal_editar', compact('get_id','list_lugar','list_base','list_servicio','list_proveedor_servicio'));
    }

    public function update_da(Request $request, $id)
    {
        $request->validate([
            'id_lugar_servicioe' => 'gt:0',
            'cod_basee' => 'not_in:0',
            'id_servicioe' => 'gt:0',
        ],[
            'id_lugar_servicioe.gt' => 'Debe seleccionar lugar.',
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'id_servicioe.gt' => 'Debe seleccionar servicio.',
        ]);

        $valida = DatosServicio::where('cod_base', $request->cod_basee)->where('id_servicio', $request->id_servicioe)
                ->where('id_proveedor_servicio', $request->id_proveedor_servicioe)
                ->where('contrato_servicio', $request->contrato_servicioe)
                ->where('medidor', $request->medidore)->where('suministro', $request->suministroe)
                ->where('id_lugar_servicio', $request->id_lugar_servicioe)->where('estado', 1)
                ->where('id_datos_servicio', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            DatosServicio::findOrFail($id)->update([
                'cod_base' => $request->cod_basee,
                'id_servicio' => $request->id_servicioe,
                'id_proveedor_servicio' => $request->id_proveedor_servicioe,
                'id_lugar_servicio' => $request->id_lugar_servicioe,
                'contrato_servicio' => $request->contrato_servicioe,
                'medidor' => $request->medidore,
                'suministro' => $request->suministroe,
                'ruta' => $request->rutae,
                'cliente' => $request->clientee,
                'doc_cliente' => $request->doc_clientee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_da($id)
    {
        DatosServicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
