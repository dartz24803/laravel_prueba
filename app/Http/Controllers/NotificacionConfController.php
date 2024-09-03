<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Notificacion;
use Illuminate\Http\Request;

class NotificacionConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.administracion.notificacion.index', compact('list_notificacion'));
    }

    public function index_ti()
    {
        return view('interna.administracion.notificacion.tipo.index');
    }

    public function list_ti()
    {
        $list_tipo = Config::select('id_config','descrip_config','mensaje','icono')
                    ->where('tipo','Notificacion')->where('estado', 1)->get();
        return view('interna.administracion.notificacion.tipo.lista', compact('list_tipo'));
    }

    public function create_ti()
    {
        return view('interna.administracion.notificacion.tipo.modal_registrar');
    }

    public function store_ti(Request $request)
    {
        $request->validate([
            'descrip_config' => 'required',
            'mensaje' => 'required',
            'icono' => 'required'
        ],[
            'descrip_config.required' => 'Debe ingresar nombre.',
            'mensaje.required' => 'Debe ingresar mensaje.',
            'icono.required' => 'Debe ingresar ícono.'
        ]);

        $valida = Config::where('descrip_config', $request->descrip_config)->where('tipo', 'Notificacion')
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Config::create([
                'descrip_config' => $request->descrip_config,
                'mensaje' => $request->mensaje,
                'icono' => $request->icono,
                'tipo' => 'Notificacion',
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ti($id)
    {
        $get_id = Config::findOrFail($id);
        return view('interna.administracion.notificacion.tipo.modal_editar', compact('get_id'));
    }

    public function update_ti(Request $request, $id)
    {
        $request->validate([
            'descrip_confige' => 'required',
            'mensajee' => 'required',
            'iconoe' => 'required'
        ],[
            'descrip_confige.required' => 'Debe ingresar nombre.',
            'mensajee.required' => 'Debe ingresar mensaje.',
            'iconoe.required' => 'Debe ingresar ícono.'
        ]);

        $valida = Config::where('descrip_config', $request->descrip_confige)->where('tipo', 'Notificacion')
                ->where('estado', 1)->where('id_config', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Config::findOrFail($id)->update([
                'descrip_config' => $request->descrip_confige,
                'mensaje' => $request->mensajee,
                'icono' => $request->iconoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ti($id)
    {
        Config::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
