<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Color;
use App\Models\Estado;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Notificacion;
use App\Models\ProductoCaja;
use App\Models\SubGerencia;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Tag\Q;

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
        $list_subgerencia = SubGerencia::list_subgerencia(13);
        return view('caja.administracion.requisicion_tienda.index',compact('list_notificacion','list_subgerencia'));
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

    public function index_um()
    {
        return view('caja.administracion.requisicion_tienda.unidad_medida.index');
    }

    public function list_um()
    {
        $list_unidad_medida = Unidad::select('id_unidad','cod_unidad','descripcion_unidad')
                            ->where('id_unidad_mae',2)
                            ->where('estado', 1)
                            ->orderBy('cod_unidad','ASC')->orderBy('descripcion_unidad','ASC')->get();
        return view('caja.administracion.requisicion_tienda.unidad_medida.lista', compact('list_unidad_medida'));
    }

    public function create_um()
    {
        return view('caja.administracion.requisicion_tienda.unidad_medida.modal_registrar');
    }

    public function store_um(Request $request)
    {
        $request->validate([
            'cod_unidad' => 'required',
            'descripcion_unidad' => 'required'
        ],[
            'cod_unidad.required' => 'Debe ingresar código.',
            'descripcion_unidad.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Unidad::where('id_unidad_mae',2)->where('cod_unidad', $request->cod_unidad)
                ->where('descripcion_unidad', $request->descripcion_unidad)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Unidad::create([
                'id_unidad_mae' => 2,
                'cod_unidad' => $request->cod_unidad,
                'descripcion_unidad' => $request->descripcion_unidad,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_um($id)
    {
        $get_id = Unidad::findOrFail($id);
        return view('caja.administracion.requisicion_tienda.unidad_medida.modal_editar', compact('get_id'));
    }

    public function update_um(Request $request, $id)
    {
        $request->validate([
            'cod_unidade' => 'required',
            'descripcion_unidade' => 'required'
        ],[
            'cod_unidade.required' => 'Debe ingresar código.',
            'descripcion_unidade.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Unidad::where('id_unidad_mae',2)->where('cod_unidad', $request->cod_unidade)
                ->where('descripcion_unidad', $request->descripcion_unidade)
                ->where('estado', 1)->where('id_unidad', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Unidad::findOrFail($id)->update([
                'cod_unidad' => $request->cod_unidade,
                'descripcion_unidad' => $request->descripcion_unidade,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_um($id)
    {
        Unidad::findOrFail($id)->update([
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

    public function index_pr()
    {
        return view('caja.administracion.requisicion_tienda.producto.index');
    }

    public function list_pr()
    {
        $list_producto = ProductoCaja::from('producto_caja AS pr')
                        ->select('pr.id_producto','ma.nom_marca','mo.nom_modelo','co.nom_color',
                        'ca.nom_categoria','un.cod_unidad','pr.nom_producto','es.nom_estado')
                        ->join('marca AS ma','ma.id_marca','=','pr.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pr.id_modelo')
                        ->leftjoin('color AS co','co.id_color','=','pr.id_color')
                        ->leftjoin('categoria AS ca','ca.id_categoria','=','pr.id_categoria')
                        ->join('unidad AS un','un.id_unidad','=','pr.id_unidad')
                        ->leftjoin('estado AS es','es.id_estado','=','pr.id_estado')
                        ->where('pr.estado', 1)->get();
        return view('caja.administracion.requisicion_tienda.producto.lista', compact('list_producto'));
    }

    public function create_pr()
    {
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)->where('estado',1)
                    ->orderBy('nom_marca','ASC')->get();
        $list_color = Color::select('id_color','nom_color')->where('id_color_mae',1)->where('estado',1)
                    ->orderBy('nom_color','ASC')->get();
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',2)
                        ->where('estado',1)->orderBy('nom_categoria','ASC')->get();
        $list_unidad = Unidad::select('id_unidad',
                        DB::raw('CONCAT(descripcion_unidad," (",cod_unidad,")") AS nom_unidad'))
                        ->where('id_unidad_mae',2)->where('estado',1)
                        ->orderBy('descripcion_unidad','ASC')->get();
        $list_estado = Estado::select('id_estado','nom_estado')->where('id_estado_mae',3)
                        ->where('estado',1)->orderBy('nom_estado','ASC')->get();                        
        return view('caja.administracion.requisicion_tienda.producto.modal_registrar',compact(
            'list_marca',
            'list_color',
            'list_categoria',
            'list_unidad',
            'list_estado'
        ));
    }

    public function traer_modelo_pr(Request $request){
        $list_modelo = Modelo::select('id_modelo','nom_modelo')->where('id_modelo_mae',2)
                        ->where('id_marca',$request->id_marca)->where('estado',1)
                        ->orderBy('nom_modelo','ASC')->get();
        return view('caja.administracion.requisicion_tienda.producto.modelo', compact('list_modelo'));
    }

    public function store_pr(Request $request)
    {
        $request->validate([
            'id_marca' => 'gt:0',
            'id_unidad' => 'gt:0',
            'nom_producto' => 'required'
        ],[
            'id_marca.gt' => 'Debe seleccionar marca.',
            'id_unidad.gt' => 'Debe seleccionar unidad.',
            'nom_producto.required' => 'Debe ingresar nombre.'
        ]);

        $valida = ProductoCaja::where('id_marca', $request->id_marca)
                ->where('id_modelo', $request->id_modelo)->where('id_color', $request->id_color)
                ->where('id_unidad', $request->id_unidad)->where('id_estado', $request->id_estado)
                ->where('id_categoria', $request->id_categoria)
                ->where('nom_producto', $request->nom_producto)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            ProductoCaja::create([
                'id_marca' => $request->id_marca,
                'id_modelo' => $request->id_modelo,
                'id_color' => $request->id_color,
                'id_categoria' => $request->id_categoria,
                'id_unidad' => $request->id_unidad,
                'id_estado' => $request->id_estado,
                'nom_producto' => $request->nom_producto,
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
        $get_id = ProductoCaja::findOrFail($id);
        $list_marca = Marca::select('id_marca','nom_marca')->where('id_marca_mae',2)->where('estado',1)
                    ->orderBy('nom_marca','ASC')->get();
        $list_modelo = Modelo::select('id_modelo','nom_modelo')->where('id_modelo_mae',2)
                        ->where('id_marca',$get_id->id_marca)->where('estado',1)
                        ->orderBy('nom_modelo','ASC')->get();                    
        $list_color = Color::select('id_color','nom_color')->where('id_color_mae',1)->where('estado',1)
                    ->orderBy('nom_color','ASC')->get();
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',2)
                        ->where('estado',1)->orderBy('nom_categoria','ASC')->get();
        $list_unidad = Unidad::select('id_unidad',
                        DB::raw('CONCAT(descripcion_unidad," (",cod_unidad,")") AS nom_unidad'))
                        ->where('id_unidad_mae',2)->where('estado',1)
                        ->orderBy('descripcion_unidad','ASC')->get();
        $list_estado = Estado::select('id_estado','nom_estado')->where('id_estado_mae',3)
                        ->where('estado',1)->orderBy('nom_estado','ASC')->get();           
        return view('caja.administracion.requisicion_tienda.producto.modal_editar', compact(
            'get_id',
            'list_marca',
            'list_modelo',
            'list_color',
            'list_categoria',
            'list_unidad',
            'list_estado'
        ));
    }

    public function update_pr(Request $request, $id)
    {
        $request->validate([
            'id_marcae' => 'gt:0',
            'id_unidade' => 'gt:0',
            'nom_productoe' => 'required'
        ],[
            'id_marcae.gt' => 'Debe seleccionar marca.',
            'id_unidade.gt' => 'Debe seleccionar unidad.',
            'nom_productoe.required' => 'Debe ingresar nombre.'
        ]);

        $valida = ProductoCaja::where('id_marca', $request->id_marcae)
                ->where('id_modelo', $request->id_modeloe)->where('id_color', $request->id_colore)
                ->where('id_unidad', $request->id_unidade)->where('id_estado', $request->id_estadoe)
                ->where('id_categoria', $request->id_categoriae)
                ->where('nom_producto', $request->nom_productoe)
                ->where('estado', 1)->where('id_producto', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ProductoCaja::findOrFail($id)->update([
                'id_marca' => $request->id_marcae,
                'id_modelo' => $request->id_modeloe,
                'id_color' => $request->id_colore,
                'id_categoria' => $request->id_categoriae,
                'id_unidad' => $request->id_unidade,
                'id_estado' => $request->id_estadoe,
                'nom_producto' => $request->nom_productoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_pr($id)
    {
        ProductoCaja::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
