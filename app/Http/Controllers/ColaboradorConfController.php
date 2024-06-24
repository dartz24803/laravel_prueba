<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\Gerencia;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class ColaboradorConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('rrhh.administracion.colaborador.index');
    }

    public function traer_gerencia(Request $request)
    {
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$request->id_direccion)->where('estado',1)->get();
        return view('rrhh.administracion.colaborador.gerencia',compact('list_gerencia'));
    }

    public function index_di()
    {
        return view('rrhh.administracion.colaborador.direccion.index');
    }

    public function list_di()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.direccion.lista', compact('list_direccion'));
    }

    public function create_di()
    {
        return view('rrhh.administracion.colaborador.direccion.modal_registrar');
    }

    public function store_di(Request $request)
    {
        $request->validate([
            'direccion' => 'required',
        ],[
            'direccion.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Direccion::create([
                'direccion' => $request->direccion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_di($id)
    {
        $get_id = Direccion::findOrFail($id);
        return view('rrhh.administracion.colaborador.direccion.modal_editar', compact('get_id'));
    }

    public function update_di(Request $request, $id)
    {
        $request->validate([
            'direccione' => 'required',
        ],[
            'direccione.required' => 'Debe ingresar dirección.',
        ]);

        $valida = Direccion::where('direccion', $request->direccione)->where('estado', 1)->where('id_direccion', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Direccion::findOrFail($id)->update([
                'direccion' => $request->direccione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_di($id)
    {
        Direccion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ge()
    {
        return view('rrhh.administracion.colaborador.gerencia.index');
    }

    public function list_ge()
    {
        $list_gerencia = Gerencia::select('gerencia.id_gerencia','direccion.direccion','gerencia.nom_gerencia')
                                    ->join('direccion','direccion.id_direccion','=','gerencia.id_direccion')
                                    ->where('gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.lista', compact('list_gerencia'));
    }

    public function create_ge()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_ge(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'nom_gerencia' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'nom_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccion)->where('nom_gerencia', $request->nom_gerencia)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Gerencia::create([
                'id_direccion' => $request->id_direccion,
                'nom_gerencia' => $request->nom_gerencia,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ge($id)
    {
        $get_id = Gerencia::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.gerencia.modal_editar', compact('get_id','list_direccion'));
    }

    public function update_ge(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'nom_gerenciae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'nom_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Gerencia::where('id_direccion', $request->id_direccione)->where('nom_gerencia', $request->nom_gerenciae)->where('estado', 1)->where('id_gerencia', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Gerencia::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'nom_gerencia' => $request->nom_gerenciae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ge($id)
    {
        Gerencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_sg()
    {
        return view('rrhh.administracion.colaborador.sub_gerencia.index');
    }

    public function list_sg()
    {
        $list_sub_gerencia = SubGerencia::select('sub_gerencia.id_sub_gerencia','direccion.direccion','gerencia.nom_gerencia','sub_gerencia.nom_sub_gerencia')
                                    ->join('direccion','direccion.id_direccion','=','sub_gerencia.id_direccion')
                                    ->join('gerencia','gerencia.id_gerencia','=','sub_gerencia.id_gerencia')
                                    ->where('sub_gerencia.estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.lista', compact('list_sub_gerencia'));
    }

    public function create_sg()
    {
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_registrar', compact('list_direccion'));
    }

    public function store_sg(Request $request)
    {
        $request->validate([
            'id_direccion' => 'gt:0',
            'id_gerencia' => 'gt:0',
            'nom_sub_gerencia' => 'required',
        ],[
            'id_direccion.gt' => 'Debe seleccionar dirección.',
            'id_gerencia.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerencia.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccion)->where('id_gerencia', $request->id_gerencia)
                                ->where('nom_sub_gerencia', $request->nom_sub_gerencia)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            SubGerencia::create([
                'id_direccion' => $request->id_direccion,
                'id_gerencia' => $request->id_gerencia,
                'nom_sub_gerencia' => $request->nom_sub_gerencia,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_sg($id)
    {
        $get_id = SubGerencia::findOrFail($id);
        $list_direccion = Direccion::select('id_direccion','direccion')->where('estado', 1)->get();
        $list_gerencia = Gerencia::select('id_gerencia','nom_gerencia')->where('id_direccion',$get_id->id_direccion)->where('estado', 1)->get();
        return view('rrhh.administracion.colaborador.sub_gerencia.modal_editar', compact('get_id','list_direccion','list_gerencia'));
    }

    public function update_sg(Request $request, $id)
    {
        $request->validate([
            'id_direccione' => 'gt:0',
            'id_gerenciae' => 'gt:0',
            'nom_sub_gerenciae' => 'required',
        ],[
            'id_direccione.gt' => 'Debe seleccionar dirección.',
            'id_gerenciae.gt' => 'Debe seleccionar gerencia.',
            'nom_sub_gerenciae.required' => 'Debe ingresar descripción.',
        ]);

        $valida = SubGerencia::where('id_direccion', $request->id_direccione)->where('id_gerencia', $request->id_gerenciae)
                            ->where('nom_sub_gerencia', $request->nom_sub_gerenciae)->where('estado', 1)->where('id_sub_gerencia', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            SubGerencia::findOrFail($id)->update([
                'id_direccion' => $request->id_direccione,
                'id_gerencia' => $request->id_gerenciae,
                'nom_sub_gerencia' => $request->nom_sub_gerenciae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_sg($id)
    {
        SubGerencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
