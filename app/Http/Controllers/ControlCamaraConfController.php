<?php

namespace App\Http\Controllers;

use App\Models\Horas;
use App\Models\Local;
use App\Models\Sedes;
use Illuminate\Http\Request;

class ControlCamaraConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.administracion.control_camara.index');
    }

    public function index_se()
    {
        return view('seguridad.administracion.control_camara.sede.index');
    }

    public function list_se()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado', 1)->get();
        return view('seguridad.administracion.control_camara.sede.lista', compact('list_sede'));
    }

    public function create_se()
    {
        return view('seguridad.administracion.control_camara.sede.modal_registrar');
    }

    public function store_se(Request $request)
    {
        $request->validate([
            'nombre_sede' => 'required',
        ],[
            'nombre_sede.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Sedes::where('nombre_sede', $request->nombre_sede)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Sedes::create([
                'nombre_sede' => $request->nombre_sede,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_se($id)
    {
        $get_id = Sedes::findOrFail($id);
        return view('seguridad.administracion.control_camara.sede.modal_editar', compact('get_id'));
    }

    public function update_se(Request $request, $id)
    {
        $request->validate([
            'nombre_sedee' => 'required',
        ],[
            'nombre_sedee.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Sedes::where('nombre_sede', $request->nombre_sedee)->where('estado', 1)->where('id_sede', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Sedes::findOrFail($id)->update([
                'nombre_sede' => $request->nombre_sedee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_se($id)
    {
        Sedes::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
    
    public function index_ho()
    {
        return view('seguridad.administracion.control_camara.hora_programada.index');
    }

    public function list_ho()
    {
        $list_hora_programada = Horas::select('horas.id_hora','sedes.nombre_sede','horas.hora')
                            ->join('sedes','sedes.id_sede','=','horas.id_sede')
                            ->where('horas.estado', 1)->get();
        return view('seguridad.administracion.control_camara.hora_programada.lista', compact('list_hora_programada'));
    }

    public function create_ho()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->orderBy('nombre_sede','ASC')
                            ->get();
        return view('seguridad.administracion.control_camara.hora_programada.modal_registrar', compact(['list_sede']));
    }

    public function store_ho(Request $request)
    {
        $request->validate([
            'id_sede' => 'gt:0',
            'hora' => 'required',
        ],[
            'id_sede.gt' => 'Debe seleccionar sede.',
            'hora.required' => 'Debe ingresar hora.',
        ]);

        $valida = Horas::where('id_sede', $request->id_sede)->where('hora', $request->hora)->where('estado', 1)
                        ->exists();
        if($valida){
            echo "error";
        }else{
            Horas::create([
                'id_sede' => $request->id_sede,
                'hora' => $request->hora,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ho($id)
    {
        $get_id = Horas::findOrFail($id);
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->orderBy('nombre_sede','ASC')
                            ->get();
        return view('seguridad.administracion.control_camara.hora_programada.modal_editar', compact('get_id','list_sede'));
    }

    public function update_ho(Request $request, $id)
    {
        $request->validate([
            'id_sedee' => 'gt:0',
            'horae' => 'required',
        ],[
            'id_sedee.gt' => 'Debe seleccionar sede.',
            'horae.required' => 'Debe ingresar hora.',
        ]);

        $valida = Horas::where('id_sede', $request->id_sedee)->where('hora', $request->horae)
                        ->where('estado', 1)->where('id_hora', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Horas::findOrFail($id)->update([
                'id_sede' => $request->id_sedee,
                'hora' => $request->horae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ho($id)
    {
        Horas::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_lo()
    {
        return view('seguridad.administracion.control_camara.local.index');
    }

    public function list_lo()
    {
        $list_local = Local::select('id_local','descripcion')->where('estado', 1)->get();
        return view('seguridad.administracion.control_camara.local.lista', compact('list_local'));
    }

    public function create_lo()
    {
        return view('seguridad.administracion.control_camara.local.modal_registrar');
    }

    public function store_lo(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Local::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Local::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_lo($id)
    {
        $get_id = Local::findOrFail($id);
        return view('seguridad.administracion.control_camara.local.modal_editar', compact('get_id'));
    }

    public function update_lo(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = Local::where('descripcion', $request->descripcione)->where('estado', 1)
                        ->where('id_local', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Local::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_lo($id)
    {
        Local::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}