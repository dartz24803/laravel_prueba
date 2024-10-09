<?php

namespace App\Http\Controllers;

use App\Models\ConceptoCheque;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class RegistroChequeConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        return view('finanzas.tesoreria.administracion.registro_cheque.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_co()
    {
        return view('finanzas.tesoreria.administracion.registro_cheque.concepto.index');
    }

    public function list_co()
    {
        $list_concepto = ConceptoCheque::select('id_concepto_cheque','nom_concepto_cheque')
                    ->where('estado', 1)->get();
        return view('finanzas.tesoreria.administracion.registro_cheque.concepto.lista', compact('list_concepto'));
    }

    public function create_co()
    {
        return view('finanzas.tesoreria.administracion.registro_cheque.concepto.modal_registrar');
    }

    public function store_co(Request $request)
    {
        $request->validate([
            'nom_concepto_cheque' => 'required',
        ],[
            'nom_concepto_cheque.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ConceptoCheque::where('nom_concepto_cheque', $request->nom_concepto_cheque)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            ConceptoCheque::create([
                'id_marca_mae' => 2,
                'nom_concepto_cheque' => $request->nom_concepto_cheque,
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
        $get_id = ConceptoCheque::findOrFail($id);
        return view('finanzas.tesoreria.administracion.registro_cheque.concepto.modal_editar', compact('get_id'));
    }

    public function update_co(Request $request, $id)
    {
        $request->validate([
            'nom_concepto_chequee' => 'required',
        ],[
            'nom_concepto_chequee.required' => 'Debe ingresar nombre.',
        ]);

        $valida = ConceptoCheque::where('nom_concepto_cheque', $request->nom_concepto_chequee)
                ->where('estado', 1)->where('id_concepto_cheque', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ConceptoCheque::findOrFail($id)->update([
                'nom_concepto_cheque' => $request->nom_concepto_chequee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_co($id)
    {
        ConceptoCheque::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
