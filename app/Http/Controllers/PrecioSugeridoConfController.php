<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Notificacion;
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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();          
        return view('control_interno.administracion.precio_sugerido.index',compact('list_notificacion'));
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

    public function index_do()
    {
        return view('control_interno.administracion.precio_sugerido.precio_dos.index');
    }

    public function list_do()
    {
        $list_precio_dos = PrecioSugerido::select('precio_sugerido.id','base.cod_base','precio_sugerido.precio_1',
                            'precio_sugerido.precio_2')
                            ->join('base','base.id_base','=','precio_sugerido.id_base')
                            ->where('precio_sugerido.tipo', 2)
                            ->where('precio_sugerido.estado', 1)->get();
        return view('control_interno.administracion.precio_sugerido.precio_dos.lista', compact('list_precio_dos'));
    }

    public function create_do()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_dos.modal_registrar', compact('list_base'));
    }

    public function store_do(Request $request)
    {
        $request->validate([
            'id_base' => 'gt:0',
            'precio_1' => 'required|gt:0',
            'precio_2' => 'required|gt:0'
        ],[
            'id_base.gt' => 'Debe seleccionar base.',
            'precio_1.required' => 'Debe ingresar precio x 1.',
            'precio_1.gt' => 'Debe ingresar precio x 1 mayor a 0.',
            'precio_2.required' => 'Debe ingresar precio x 2.',
            'precio_2.gt' => 'Debe ingresar precio x 2 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_base)->where('precio_1', $request->precio_1)
                ->where('precio_2', $request->precio_2)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::create([
                'tipo' => 2,
                'id_base' => $request->id_base,
                'precio_1' => $request->precio_1,
                'precio_2' => $request->precio_2,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_do($id)
    {
        $get_id = PrecioSugerido::findOrFail($id);
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_dos.modal_editar', compact('get_id','list_base'));
    }

    public function update_do(Request $request, $id)
    {
        $request->validate([
            'id_basee' => 'gt:0',
            'precio_1e' => 'required|gt:0',
            'precio_2e' => 'required|gt:0'
        ],[
            'id_basee.gt' => 'Debe seleccionar base.',
            'precio_1e.required' => 'Debe ingresar precio x 1.',
            'precio_1e.gt' => 'Debe ingresar precio x 1 mayor a 0.',
            'precio_2e.required' => 'Debe ingresar precio x 2.',
            'precio_2e.gt' => 'Debe ingresar precio x 2 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_basee)->where('precio_1', $request->precio_1e)
                ->where('precio_2', $request->precio_2e)->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::findOrFail($id)->update([
                'id_base' => $request->id_basee,
                'precio_1' => $request->precio_1e,
                'precio_2' => $request->precio_2e,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_do($id)
    {
        PrecioSugerido::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
    
    public function index_tr()
    {
        return view('control_interno.administracion.precio_sugerido.precio_tres.index');
    }

    public function list_tr()
    {
        $list_precio_tres = PrecioSugerido::select('precio_sugerido.id','base.cod_base','precio_sugerido.precio_1',
                            'precio_sugerido.precio_2','precio_sugerido.precio_3')
                            ->join('base','base.id_base','=','precio_sugerido.id_base')
                            ->where('precio_sugerido.tipo', 3)
                            ->where('precio_sugerido.estado', 1)->get();
        return view('control_interno.administracion.precio_sugerido.precio_tres.lista', compact('list_precio_tres'));
    }

    public function create_tr()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_tres.modal_registrar', compact('list_base'));
    }

    public function store_tr(Request $request)
    {
        $request->validate([
            'id_base' => 'gt:0',
            'precio_1' => 'required|gt:0',
            'precio_2' => 'required|gt:0',
            'precio_3' => 'required|gt:0'
        ],[
            'id_base.gt' => 'Debe seleccionar base.',
            'precio_1.required' => 'Debe ingresar precio x 1.',
            'precio_1.gt' => 'Debe ingresar precio x 1 mayor a 0.',
            'precio_2.required' => 'Debe ingresar precio x 2.',
            'precio_2.gt' => 'Debe ingresar precio x 2 mayor a 0.',
            'precio_3.required' => 'Debe ingresar precio x 3.',
            'precio_3.gt' => 'Debe ingresar precio x 3 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_base)->where('precio_1', $request->precio_1)
                ->where('precio_2', $request->precio_2)->where('precio_3', $request->precio_3)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::create([
                'tipo' => 3,
                'id_base' => $request->id_base,
                'precio_1' => $request->precio_1,
                'precio_2' => $request->precio_2,
                'precio_3' => $request->precio_3,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_tr($id)
    {
        $get_id = PrecioSugerido::findOrFail($id);
        $list_base = Base::get_list_bases_tienda();
        return view('control_interno.administracion.precio_sugerido.precio_tres.modal_editar', compact('get_id','list_base'));
    }

    public function update_tr(Request $request, $id)
    {
        $request->validate([
            'id_basee' => 'gt:0',
            'precio_1e' => 'required|gt:0',
            'precio_2e' => 'required|gt:0',
            'precio_3e' => 'required|gt:0'
        ],[
            'id_basee.gt' => 'Debe seleccionar base.',
            'precio_1e.required' => 'Debe ingresar precio x 1.',
            'precio_1e.gt' => 'Debe ingresar precio x 1 mayor a 0.',
            'precio_2e.required' => 'Debe ingresar precio x 2.',
            'precio_2e.gt' => 'Debe ingresar precio x 2 mayor a 0.',
            'precio_3e.required' => 'Debe ingresar precio x 3.',
            'precio_3e.gt' => 'Debe ingresar precio x 3 mayor a 0.',
        ]);

        $valida = PrecioSugerido::where('id_base', $request->id_basee)->where('precio_1', $request->precio_1e)
                ->where('precio_2', $request->precio_2e)->where('precio_3', $request->precio_3e)
                ->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            PrecioSugerido::findOrFail($id)->update([
                'id_base' => $request->id_basee,
                'precio_1' => $request->precio_1e,
                'precio_2' => $request->precio_2e,
                'precio_3' => $request->precio_3e,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_tr($id)
    {
        PrecioSugerido::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
