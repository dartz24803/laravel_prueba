<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\ProveedorServicio;
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
                    ->where('estado', 1)->get();
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
                                'proveedor_servicio.nombre_proveedor_servicio',
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
        $list_servicio = Servicio::select('id_servicio','nom_servicio')->where('estado',1)->orderBy('nom_servicio','ASC')
                        ->get();
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.modal_registrar', compact(['list_base','list_servicio']));
    }

    public function store_pr(Request $request)
    {
        $request->validate([
            'cod_base' => 'not_in:0',
            'id_servicio' => 'gt:0',
            'nombre_proveedor_servicio' => 'required',
        ],[
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_servicio.gt' => 'Debe seleccionar servicio.',
            'nombre_proveedor_servicio.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ProveedorServicio::where('cod_base', $request->cod_base)->where('id_servicio', $request->id_servicio)
                ->where('nombre_proveedor_servicio', $request->nombre_proveedor_servicio)->where('estado', 1)
                ->exists();
        if($valida){
            echo "error";
        }else{
            ProveedorServicio::create([
                'cod_base' => $request->cod_base,
                'id_servicio' => $request->id_servicio,
                'nombre_proveedor_servicio' => $request->nombre_proveedor_servicio,
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
        $list_servicio = Servicio::select('id_servicio','nom_servicio')->where('estado',1)->orderBy('nom_servicio','ASC')
                        ->get();
        return view('seguridad.administracion.lectura_servicio.proveedor_servicio.modal_editar', compact('get_id','list_base','list_servicio'));
    }

    public function update_pr(Request $request, $id)
    {
        $request->validate([
            'cod_basee' => 'not_in:0',
            'id_servicioe' => 'gt:0',
            'nombre_proveedor_servicioe' => 'required',
        ],[
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'id_servicioe.gt' => 'Debe seleccionar servicio.',
            'nombre_proveedor_servicioe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ProveedorServicio::where('cod_base', $request->cod_basee)->where('id_servicio', $request->id_servicioe)
                ->where('nombre_proveedor_servicio', $request->nombre_proveedor_servicioe)->where('estado', 1)
                ->where('id_proveedor_servicio', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ProveedorServicio::findOrFail($id)->update([
                'cod_base' => $request->cod_basee,
                'id_servicio' => $request->id_servicioe,
                'nombre_proveedor_servicio' => $request->nombre_proveedor_servicioe,
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
}
