<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContenidoSupervisionTienda;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_conf()
    {
        return view('tienda.administracion.administrador.index');
    }

    public function index_conf_st()
    {
        return view('tienda.administracion.administrador.supervision_tienda.index');
    }

    public function list_conf_st(Request $request)
    {
        $list_c_supervision_tienda = ContenidoSupervisionTienda::select('id','descripcion')->where('estado', 1)->get();
        return view('tienda.administracion.administrador.supervision_tienda.lista', compact('list_c_supervision_tienda'));
    }

    public function create_conf_st($validador=null)
    {
        $validador = $validador;
        return view('tienda.administracion.administrador.supervision_tienda.modal_registrar', compact('validador'));
    }

    public function store_conf_st(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            ContenidoSupervisionTienda::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_conf_st($id)
    {
        $get_id = ContenidoSupervisionTienda::findOrFail($id);
        return view('tienda.administracion.administrador.supervision_tienda.modal_editar', compact('get_id'));
    }

    public function update_conf_st(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ContenidoSupervisionTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ContenidoSupervisionTienda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_conf_st($id)
    {
        ContenidoSupervisionTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_conf_sc()
    {
        return view('tienda.administracion.administrador.seguimiento_coordinador.index');
    }

    public function create_conf_sc($validador=null)
    {
        $validador = $validador;
        return view('tienda.administracion.administrador.seguimiento_coordinador.modal_registrar', compact('validador'));
    }
}