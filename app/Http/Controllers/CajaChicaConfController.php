<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Notificacion;
use App\Models\SubCategoria;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use App\Models\SubGerencia;
use App\Models\Unidad;

class CajaChicaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('finanzas.tesoreria.administracion.caja_chica.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_ca()
    {
        return view('finanzas.tesoreria.administracion.caja_chica.categoria.index');
    }

    public function list_ca()
    {
        $list_categoria = Categoria::from('categoria AS ca')
                        ->select('ca.id_categoria','ub.cod_ubi','ca.nom_categoria')
                        ->join('ubicacion AS ub','ub.id_ubicacion','=','ca.id_ubicacion')
                        ->where('ca.id_categoria_mae',3)
                        ->where('ca.estado', 1)->get();
        return view('finanzas.tesoreria.administracion.caja_chica.categoria.lista', compact('list_categoria'));
    }

    public function create_ca()
    {
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)->orderBy('cod_ubi','ASC')
                        ->get();
        return view('finanzas.tesoreria.administracion.caja_chica.categoria.modal_registrar', compact('list_ubicacion'));
    }

    public function store_ca(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'nom_categoria' => 'required',
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'nom_categoria.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Categoria::where('id_ubicacion', $request->id_ubicacion)->where('nom_categoria', $request->nom_categoria)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Categoria::create([
                'id_categoria_mae' => 3,
                'id_ubicacion' => $request->id_ubicacion,
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
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)->orderBy('cod_ubi','ASC')
                        ->get();
        return view('finanzas.tesoreria.administracion.caja_chica.categoria.modal_editar', compact('get_id','list_ubicacion'));
    }

    public function update_ca(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'nom_categoriae' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'nom_categoriae.required' => 'Debe ingresar nombre.'
        ]);

        $valida = Categoria::where('id_ubicacion', $request->id_ubicacione)->where('nom_categoria', $request->nom_categoriae)
                ->where('estado', 1)->where('id_categoria', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            Categoria::findOrFail($id)->update([
                'id_ubicacion' => $request->id_ubicacione,
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

    public function index_sc()
    {
        return view('finanzas.tesoreria.administracion.caja_chica.sub_categoria.index');
    }

    public function list_sc()
    {
        $list_sub_categoria = SubCategoria::from('sub_categoria AS sc')
                            ->select('sc.id','ub.cod_ubi','ca.nom_categoria','sc.nombre')
                            ->join('categoria AS ca','ca.id_categoria','=','sc.id_categoria')
                            ->join('ubicacion AS ub','ub.id_ubicacion','=','ca.id_ubicacion')
                            ->where('ca.id_categoria_mae',3)->where('sc.estado', 1)->get();
        return view('finanzas.tesoreria.administracion.caja_chica.sub_categoria.lista', compact('list_sub_categoria'));
    }

    public function traer_categoria_sc(Request $request){
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                        ->where('id_ubicacion',$request->id_ubicacion)->where('estado',1)->orderBy('nom_categoria','ASC')->get();
        return view('finanzas.tesoreria.administracion.caja_chica.sub_categoria.categoria', compact('list_categoria'));
    }

    public function create_sc()
    {
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)->orderBy('cod_ubi','ASC')
                        ->get();
        return view('finanzas.tesoreria.administracion.caja_chica.sub_categoria.modal_registrar', compact('list_ubicacion'));
    }

    public function store_sc(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'id_categoria' => 'gt:0',
            'nombre' => 'required'
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'id_categoria.gt' => 'Debe seleccionar categoría.',
            'nombre.required' => 'Debe ingresar nombre.'
        ]);

        $valida = SubCategoria::where('id_categoria', $request->id_categoria)->where('nombre', $request->nombre)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            SubCategoria::create([
                'id_categoria' => $request->id_categoria,
                'nombre' => $request->nombre,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_sc($id) 
    {
        $get_id = SubCategoria::from('sub_categoria AS sc')
                ->select('sc.id','ca.id_ubicacion','sc.id_categoria','sc.nombre')
                ->join('categoria AS ca','ca.id_categoria','=','sc.id_categoria')
                ->where('id',$id)->first();
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)->orderBy('cod_ubi','ASC')
                        ->get();
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                        ->where('id_ubicacion',$get_id->id_ubicacion)->where('estado',1)->orderBy('nom_categoria','ASC')->get();                        
        return view('finanzas.tesoreria.administracion.caja_chica.sub_categoria.modal_editar', compact('get_id','list_ubicacion','list_categoria'));
    }

    public function update_sc(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'id_categoriae' => 'gt:0',
            'nombree' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'id_categoriae.gt' => 'Debe seleccionar categoría.',
            'nombree.required' => 'Debe ingresar nombre.'
        ]);

        $valida = SubCategoria::where('id_categoria', $request->id_categoriae)->where('nombre', $request->nombree)
                ->where('estado', 1)->where('id', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            SubCategoria::findOrFail($id)->update([
                'id_categoria' => $request->id_categoriae,
                'nombre' => $request->nombree,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_sc($id)
    {
        SubCategoria::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_un()
    {
        return view('finanzas.tesoreria.administracion.caja_chica.unidad.index');
    }

    public function list_un()
    {
        $list_unidad = Unidad::select('id_unidad','cod_unidad','descripcion_unidad')
                        ->where('id_unidad_mae',3)->where('estado', 1)->get();
        return view('finanzas.tesoreria.administracion.caja_chica.unidad.lista', compact('list_unidad'));
    }

    public function create_un()
    {
        return view('finanzas.tesoreria.administracion.caja_chica.unidad.modal_registrar');
    }

    public function store_un(Request $request)
    {
        $request->validate([
            'cod_unidad' => 'required',
            'descripcion_unidad' => 'required'
        ], [
            'cod_unidad.required' => 'Debe ingresar sigla.',
            'descripcion_unidad.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Unidad::where('id_unidad_mae',3)->where('cod_unidad', $request->cod_unidad)
                ->where('descripcion_unidad', $request->descripcion_unidad)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Unidad::create([
                'id_unidad_mae' => 3,
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

    public function edit_un($id)
    {
        $get_id = Unidad::findOrFail($id);
        return view('finanzas.tesoreria.administracion.caja_chica.unidad.modal_editar', compact('get_id'));
    }

    public function update_un(Request $request, $id)
    {
        $request->validate([
            'cod_unidade' => 'required',
            'descripcion_unidade' => 'required'
        ], [
            'cod_unidade.required' => 'Debe ingresar sigla.',
            'descripcion_unidade.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Unidad::where('id_unidad_mae',3)->where('cod_unidad', $request->cod_unidade)
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

    public function destroy_un($id)
    {
        Unidad::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
