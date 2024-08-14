<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\PrecioSugerido;
use Illuminate\Http\Request;

class PrecioSugeridoConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('control_interno.administracion.precio_sugerido.index');
    }

    public function index_un()
    {
        return view('control_interno.administracion.precio_sugerido.precio_uno.index');
    }

    public function list_un()
    {
        $list_precio_uno = PrecioSugerido::select('precio_sugerido.id','base.cod_base','precio_sugerido.precio_1')
                            ->join('base','base.id_base','=','precio_sugerido.id_base')
                            ->where('precio_sugerido.tipo', 1)
                            ->where('precio_sugerido.estado', 1)->get();
        return view('control_interno.administracion.precio_sugerido.precio_uno.lista', compact('list_precio_uno'));
    }

    public function create_un()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_uno.modal_registrar', compact('list_base'));
    }

    public function store_un(Request $request)
    {
        $request->validate([
            'id_base' => 'gt:0',
            'precio_1' => 'required|gt:0'
        ],[
            'id_base.gt' => 'Debe seleccionar base.',
            'precio_1.required' => 'Debe ingresar precio x 1.',
            'precio_1.gt' => 'Debe ingresar precio x 1 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_base)->where('precio_1', $request->precio_1)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::create([
                'tipo' => 1,
                'id_base' => $request->id_base,
                'precio_1' => $request->precio_1,
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
        $get_id = PrecioSugerido::findOrFail($id);
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_uno.modal_editar', compact('get_id','list_base'));
    }

    public function update_un(Request $request, $id)
    {
        $request->validate([
            'id_basee' => 'gt:0',
            'precio_1e' => 'required|gt:0'
        ],[
            'id_basee.gt' => 'Debe seleccionar base.',
            'precio_1e.required' => 'Debe ingresar precio x 1.',
            'precio_1e.gt' => 'Debe ingresar precio x 1 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_basee)->where('precio_1', $request->precio_1e)
                ->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::findOrFail($id)->update([
                'id_base' => $request->id_basee,
                'precio_1' => $request->precio_1e,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_un($id)
    {
        PrecioSugerido::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
