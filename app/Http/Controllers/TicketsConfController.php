<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class TicketsConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(3);
        return view('interna.administracion.sistemas.index',compact(
            'list_notificacion',
            'list_subgerencia'
        ));
    }

    public function index_mo()
    {
        return view('interna.administracion.sistemas.modulo.index');
    }

    public function list_mo()
    {
        $list_modulo = Modulo::select('id_modulo','cod_modulo','nom_modulo')->where('estado', 1)->get();
        return view('interna.administracion.sistemas.modulo.lista', compact('list_modulo'));
    }

    public function create_mo()
    {
        return view('interna.administracion.sistemas.modulo.modal_registrar');
    }

    public function store_mo(Request $request)
    {
        $request->validate([
            'cod_modulo' => 'required',
            'nom_modulo' => 'required'
        ],[
            'cod_modulo.required' => 'Debe ingresar código.',
            'nom_modulo.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Modulo::where('cod_modulo', $request->cod_modulo)
                ->where('nom_modulo', $request->nom_modulo)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Modulo::create([
                'cod_modulo' => $request->cod_modulo,
                'nom_modulo' => $request->nom_modulo,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_mo($id)
    {
        $get_id = Modulo::findOrFail($id);
        return view('interna.administracion.sistemas.modulo.modal_editar', compact('get_id'));
    }

    public function update_mo(Request $request, $id)
    {
        $request->validate([
            'cod_moduloe' => 'required',
            'nom_moduloe' => 'required'
        ],[
            'cod_moduloe.required' => 'Debe ingresar código.',
            'nom_moduloe.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Modulo::where('cod_modulo', $request->cod_moduloe)
                ->where('nom_modulo', $request->nom_moduloe)->where('estado', 1)
                ->where('id_modulo', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Modulo::findOrFail($id)->update([
                'cod_modulo' => $request->cod_moduloe,
                'nom_modulo' => $request->nom_moduloe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_mo($id)
    {
        Modulo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_co()
    {
        return view('interna.administracion.sistemas.complejidad.index');
    }

    public function list_co()
    {
        $list_modelo = Modelo::from('modelo AS mo')
                    ->select('mo.id_modelo','ma.nom_marca','mo.nom_modelo')
                    ->join('marca AS ma','ma.id_marca','=','mo.id_marca')
                    ->where('mo.id_modelo_mae',2)
                    ->where('mo.estado', 1)
                    ->orderBy('ma.nom_marca','ASC')->orderBy('mo.nom_modelo','ASC')->get();
        return view('interna.administracion.sistemas.complejidad.lista', compact('list_modelo'));
    }

    public function create_co()
    {
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)
                    ->where('estado', 1)
                    ->orderBy('nom_marca','ASC')->get();
        return view('interna.administracion.sistemas.complejidad.modal_registrar',compact('list_marca'));
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'id_marca' => 'gt:0',
            'nom_modelo' => 'required'
        ],[
            'id_marca.gt' => 'Debe seleccionar marca.',
            'nom_modelo.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Modelo::where('id_modelo_mae',2)->where('id_marca', $request->id_marca)
                ->where('nom_modelo', $request->nom_modelo)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Modelo::create([
                'id_modelo_mae' => 2,
                'id_marca' => $request->id_marca,
                'nom_modelo' => $request->nom_modelo,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_co($id)
    {
        $get_id = Modelo::findOrFail($id);
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)
                    ->where('estado', 1)
                    ->orderBy('nom_marca','ASC')->get();
        return view('interna.administracion.sistemas.complejidad.modal_editar', compact('get_id','list_marca'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'id_marcae' => 'gt:0',
            'nom_modeloe' => 'required'
        ],[
            'id_marcae.gt' => 'Debe seleccionar marca.',
            'nom_modeloe.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Modelo::where('id_modelo_mae',2)->where('id_marca', $request->id_marcae)
                ->where('nom_modelo', $request->nom_modeloe)->where('estado', 1)
                ->where('id_modelo', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Modelo::findOrFail($id)->update([
                'id_marca' => $request->id_marcae,
                'nom_modelo' => $request->nom_modeloe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        Modelo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
