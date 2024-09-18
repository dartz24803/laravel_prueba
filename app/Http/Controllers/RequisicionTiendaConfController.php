<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class RequisicionTiendaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();          
        return view('caja.administracion.requisicion_tienda.index',compact('list_notificacion'));
    }

    public function index_ma()
    {
        return view('caja.administracion.requisicion_tienda.marca.index');
    }

    public function list_ma()
    {
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)
                    ->where('estado', 1)
                    ->orderBy('nom_marca','ASC')->get();
        return view('caja.administracion.requisicion_tienda.marca.lista', compact('list_marca'));
    }

    public function create_ma()
    {
        return view('caja.administracion.requisicion_tienda.marca.modal_registrar');
    }

    public function store_ma(Request $request)
    {
        $request->validate([
            'nom_marca' => 'required',
        ],[
            'nom_marca.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Marca::where('id_marca_mae',2)->where('nom_marca', $request->nom_marca)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Marca::create([
                'id_marca_mae' => 2,
                'nom_marca' => $request->nom_marca,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ma($id)
    {
        $get_id = Marca::findOrFail($id);
        return view('caja.administracion.requisicion_tienda.marca.modal_editar', compact('get_id'));
    }

    public function update_ma(Request $request, $id)
    {
        $request->validate([
            'nom_marcae' => 'required',
        ],[
            'nom_marcae.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Marca::where('id_marca_mae',2)->where('nom_marca', $request->nom_marcae)
                ->where('estado', 1)->where('id_marca', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Marca::findOrFail($id)->update([
                'nom_marca' => $request->nom_marcae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ma($id)
    {
        Marca::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_mo()
    {
        return view('caja.administracion.requisicion_tienda.modelo.index');
    }

    public function list_mo()
    {
        $list_modelo = Modelo::from('modelo AS mo')
                    ->select('mo.id_modelo','ma.nom_marca','mo.nom_modelo')
                    ->join('marca AS ma','ma.id_marca','=','mo.id_marca')
                    ->where('mo.id_modelo_mae',2)
                    ->where('mo.estado', 1)
                    ->orderBy('ma.nom_marca','ASC')->orderBy('mo.nom_modelo','ASC')->get();
        return view('caja.administracion.requisicion_tienda.modelo.lista', compact('list_modelo'));
    }

    public function create_mo()
    {
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)
                    ->where('estado', 1)
                    ->orderBy('nom_marca','ASC')->get();
        return view('caja.administracion.requisicion_tienda.modelo.modal_registrar',compact('list_marca'));
    }

    public function store_mo(Request $request)
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

    public function edit_mo($id)
    {
        $get_id = Modelo::findOrFail($id);
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)
                    ->where('estado', 1)
                    ->orderBy('nom_marca','ASC')->get();
        return view('caja.administracion.requisicion_tienda.modelo.modal_editar', compact('get_id','list_marca'));
    }

    public function update_mo(Request $request, $id)
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

    public function destroy_mo($id)
    {
        Modelo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
