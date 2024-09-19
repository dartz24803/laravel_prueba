<?php

namespace App\Http\Controllers;

use App\Models\MotivoCprenda;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class CambioPrendaConfController extends Controller
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
        return view('caja.administracion.cambio_prenda.index', compact('list_notificacion','list_subgerencia'));
    }

    public function index_mo()
    {
        return view('caja.administracion.cambio_prenda.motivo.index');
    }

    public function list_mo()
    {
        $list_motivo = MotivoCprenda::select('id_motivo', 'nom_motivo')->where('estado', 1)->get();
        return view('caja.administracion.cambio_prenda.motivo.lista', compact('list_motivo'));
    }

    public function create_mo()
    {
        return view('caja.administracion.cambio_prenda.motivo.modal_registrar');
    }

    public function store_mo(Request $request)
    {
        $request->validate([
            'nom_motivo' => 'required',
        ], [
            'nom_motivo.required' => 'Debe ingresar nombre.',
        ]);

        $valida = MotivoCprenda::where('nom_motivo', $request->nom_motivo)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            MotivoCprenda::create([
                'nom_motivo' => $request->nom_motivo,
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
        $get_id = MotivoCprenda::findOrFail($id);
        return view('caja.administracion.cambio_prenda.motivo.modal_editar', compact('get_id'));
    }

    public function update_mo(Request $request, $id)
    {
        $request->validate([
            'nom_motivoe' => 'required',
        ], [
            'nom_motivoe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = MotivoCprenda::where('nom_motivo', $request->nom_motivoe)->where('estado', 1)->where('id_motivo', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            MotivoCprenda::findOrFail($id)->update([
                'nom_motivo' => $request->nom_motivoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_mo($id)
    {
        MotivoCprenda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
