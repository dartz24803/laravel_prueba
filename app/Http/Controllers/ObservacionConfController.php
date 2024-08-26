<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\TipoError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObservacionConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('caja.administracion.observacion.index');
    }

    public function index_terr()
    {
        return view('caja.administracion.observacion.tipo_error.index');
    }

    public function list_terr()
    {
        $list_tipo_error = TipoError::select('id_tipo_error','nom_tipo_error')->where('estado', 1)->get();
        return view('caja.administracion.observacion.tipo_error.lista', compact('list_tipo_error'));
    }

    public function create_terr()
    {
        return view('caja.administracion.observacion.tipo_error.modal_registrar');
    }

    public function store_terr(Request $request)
    {
        $request->validate([
            'nom_tipo_error' => 'required',
        ],[
            'nom_tipo_error.required' => 'Debe ingresar nombre.',
        ]);

        $valida = TipoError::where('nom_tipo_error', $request->nom_tipo_error)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            TipoError::create([
                'nom_tipo_error' => $request->nom_tipo_error,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_terr($id)
    {
        $get_id = TipoError::findOrFail($id);
        return view('caja.administracion.observacion.tipo_error.modal_editar', compact('get_id'));
    }

    public function update_terr(Request $request, $id)
    {
        $request->validate([
            'nom_tipo_errore' => 'required',
        ],[
            'nom_tipo_errore.required' => 'Debe ingresar dirección.',
        ]);

        $valida = TipoError::where('nom_tipo_error', $request->nom_tipo_errore)->where('estado', 1)->where('id_tipo_error', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            TipoError::findOrFail($id)->update([
                'nom_tipo_error' => $request->nom_tipo_errore,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_terr($id)
    {
        TipoError::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_err()
    {
        return view('caja.administracion.observacion.error.index');
    }

    public function list_err()
    {
        $list_error = Error::select('error.id_error','tipo_error.nom_tipo_error','error.nom_error',
                    DB::raw('CASE WHEN error.monto=1 THEN "SI" ELSE "NO" END AS monto'),
                    DB::raw('CASE WHEN error.automatico=1 THEN "SI" ELSE "NO" END AS automatico'),
                    DB::raw('CASE WHEN error.archivo=1 THEN "SI" ELSE "NO" END AS archivo'))
                    ->join('tipo_error','tipo_error.id_tipo_error','=','error.id_tipo_error')
                    ->where('error.estado', 1)->get();
        return view('caja.administracion.observacion.error.lista', compact('list_error'));
    }

    public function create_err()
    {
        $list_tipo_error = TipoError::select('id_tipo_error','nom_tipo_error')->where('estado', 1)->orderBy('nom_tipo_error','ASC')->get();
        return view('caja.administracion.observacion.error.modal_registrar', compact('list_tipo_error'));
    }

    public function store_err(Request $request)
    {
        $request->validate([
            'id_tipo_error' => 'gt:0',
            'nom_error' => 'required',
        ],[
            'id_tipo_error.gt' => 'Debe seleccionar tipo de error.',
            'nom_error.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Error::where('id_tipo_error', $request->id_tipo_error)->where('nom_error', $request->nom_error)
                ->where('monto', $request->monto)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Error::create([
                'id_tipo_error' => $request->id_tipo_error,
                'nom_error' => $request->nom_error,
                'monto' => $request->monto,
                'automatico' => $request->automatico,
                'archivo' => $request->archivo,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_err($id)
    {
        $get_id = Error::findOrFail($id);
        $list_tipo_error = TipoError::select('id_tipo_error','nom_tipo_error')->where('estado', 1)->orderBy('nom_tipo_error','ASC')->get();
        return view('caja.administracion.observacion.error.modal_editar', compact('get_id','list_tipo_error'));
    }

    public function update_err(Request $request, $id)
    {
        $request->validate([
            'id_tipo_errore' => 'gt:0',
            'nom_errore' => 'required',
        ],[
            'id_tipo_errore.gt' => 'Debe seleccionar tipo de error.',
            'nom_errore.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Error::where('id_tipo_error', $request->id_tipo_errore)->where('nom_error', $request->nom_errore)
                ->where('monto', $request->montoe)->where('estado', 1)->where('id_error', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Error::findOrFail($id)->update([
                'id_tipo_error' => $request->id_tipo_errore,
                'nom_error' => $request->nom_errore,
                'monto' => $request->montoe,
                'automatico' => $request->automaticoe,
                'archivo' => $request->archivoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_err($id)
    {
        Error::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
