<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Color;
use App\Models\Estado;
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

    public function index_co()
    {
        return view('caja.administracion.requisicion_tienda.color.index');
    }

    public function list_co()
    {
        $list_color = Color::select('id_color','nom_color')->where('id_color_mae',1)
                    ->where('estado', 1)
                    ->orderBy('nom_color','ASC')->get();
        return view('caja.administracion.requisicion_tienda.color.lista', compact('list_color'));
    }

    public function create_co()
    {
        return view('caja.administracion.requisicion_tienda.color.modal_registrar');
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'nom_color' => 'required',
        ],[
            'nom_color.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Color::where('id_color_mae',1)->where('nom_color', $request->nom_color)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Color::create([
                'id_color_mae' => 1,
                'nom_color' => $request->nom_color,
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
        $get_id = Color::findOrFail($id);
        return view('caja.administracion.requisicion_tienda.color.modal_editar', compact('get_id'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'nom_colore' => 'required',
        ],[
            'nom_colore.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Color::where('id_color_mae',1)->where('nom_color', $request->nom_colore)
                ->where('estado', 1)->where('id_color', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Color::findOrFail($id)->update([
                'nom_color' => $request->nom_colore,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        Color::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_es()
    {
        return view('caja.administracion.requisicion_tienda.estado.index');
    }

    public function list_es()
    {
        $list_estado = Estado::select('id_estado','nom_estado')->where('id_estado_mae',3)
                        ->where('estado', 1)
                        ->orderBy('nom_estado','ASC')->get();
        return view('caja.administracion.requisicion_tienda.estado.lista', compact('list_estado'));
    }

    public function create_es()
    {
        return view('caja.administracion.requisicion_tienda.estado.modal_registrar');
    }

    public function store_es(Request $request)
    {
        $request->validate([
            'nom_estado' => 'required',
        ],[
            'nom_estado.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Estado::where('id_estado_mae',3)->where('nom_estado', $request->nom_estado)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Estado::create([
                'id_estado_mae' => 3,
                'nom_estado' => $request->nom_estado,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_es($id)
    {
        $get_id = Estado::findOrFail($id);
        return view('caja.administracion.requisicion_tienda.estado.modal_editar', compact('get_id'));
    }

    public function update_es(Request $request, $id)
    {
        $request->validate([
            'nom_estadoe' => 'required',
        ],[
            'nom_estadoe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Estado::where('id_estado_mae',3)->where('nom_estado', $request->nom_estadoe)
                ->where('estado', 1)->where('id_estado', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Estado::findOrFail($id)->update([
                'nom_estado' => $request->nom_estadoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_es($id)
    {
        Estado::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ca()
    {
        return view('caja.administracion.requisicion_tienda.categoria.index');
    }

    public function list_ca()
    {
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',2)
                        ->where('estado', 1)
                        ->orderBy('nom_categoria','ASC')->get();
        return view('caja.administracion.requisicion_tienda.categoria.lista', compact('list_categoria'));
    }

    public function create_ca()
    {
        return view('caja.administracion.requisicion_tienda.categoria.modal_registrar');
    }

    public function store_ca(Request $request)
    {
        $request->validate([
            'nom_categoria' => 'required',
        ],[
            'nom_categoria.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Categoria::where('id_categoria_mae',2)->where('nom_categoria', $request->nom_categoria)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Categoria::create([
                'id_categoria_mae' => 2,
                'nom_categoria' => $request->nom_categoria,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ca($id)
    {
        $get_id = Categoria::findOrFail($id);
        return view('caja.administracion.requisicion_tienda.categoria.modal_editar', compact('get_id'));
    }

    public function update_ca(Request $request, $id)
    {
        $request->validate([
            'nom_categoriae' => 'required',
        ],[
            'nom_categoriae.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Categoria::where('id_categoria_mae',2)->where('nom_categoria', $request->nom_categoriae)
                ->where('estado', 1)->where('id_categoria', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Categoria::findOrFail($id)->update([
                'nom_categoria' => $request->nom_categoriae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ca($id)
    {
        Categoria::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
