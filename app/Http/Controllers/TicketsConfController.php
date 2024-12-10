<?php

namespace App\Http\Controllers;

use App\Models\Complejidad;
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
        $list_complejidad = Complejidad::from('complejidad AS co')
                            ->select('co.id_complejidad','mo.nom_modulo','co.descripcion',
                            'co.dificultad')
                            ->join('modulo AS mo','mo.id_modulo','=','co.id_modulo')
                            ->where('co.estado', 1)->get();
        return view('interna.administracion.sistemas.complejidad.lista', compact('list_complejidad'));
    }

    public function create_co()
    {
        $list_modulo = Modulo::select('id_modulo','nom_modulo')->where('estado', 1)->get();
        return view('interna.administracion.sistemas.complejidad.modal_registrar',compact(
            'list_modulo'
        ));
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'id_modulo' => 'gt:0',
            'dificultad' => 'gt:0',
            'descripcion' => 'required'
        ],[
            'id_modulo.gt' => 'Debe seleccionar módulo.',
            'dificultad.gt' => 'Debe seleccionar dificultad.',
            'descripcion.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Complejidad::where('id_modulo', $request->id_modulo)
                ->where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Complejidad::create([
                'id_modulo' => $request->id_modulo,
                'dificultad' => $request->dificultad,
                'descripcion' => $request->descripcion,
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
        $get_id = Complejidad::findOrFail($id);
        $list_modulo = Modulo::select('id_modulo','nom_modulo')->where('estado', 1)->get();
        return view('interna.administracion.sistemas.complejidad.modal_editar', compact(
            'get_id',
            'list_modulo'
        ));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'id_moduloe' => 'gt:0',
            'dificultade' => 'gt:0',
            'descripcione' => 'required'
        ],[
            'id_moduloe.gt' => 'Debe seleccionar módulo.',
            'dificultade.gt' => 'Debe seleccionar dificultad.',
            'descripcione.required' => 'Debe ingresar descripción.'
        ]);

        $valida = Complejidad::where('id_modulo', $request->id_moduloe)
                ->where('descripcion', $request->descripcione)->where('estado', 1)
                ->where('id_complejidad', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Complejidad::findOrFail($id)->update([
                'id_modulo' => $request->id_moduloe,
                'dificultad' => $request->dificultade,
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        Complejidad::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
