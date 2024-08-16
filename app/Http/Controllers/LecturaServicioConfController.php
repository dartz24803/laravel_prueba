<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturaServicioConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.administracion.lectura_servicio.index');
    }

    public function index_se()
    {
        return view('seguridad.administracion.lectura_servicio.servicio.index');
    }

    public function list_se()
    {
        $list_servicio = Servicio::select('id_servicio','nom_servicio',DB::raw('CASE WHEN lectura=1 THEN "SI" ELSE "NO" END AS lectura'))
                    ->where('estado', 1)->get();
        return view('seguridad.administracion.lectura_servicio.servicio.lista', compact('list_servicio'));
    }

    public function create_se()
    {
        return view('seguridad.administracion.lectura_servicio.servicio.modal_registrar');
    }

    public function store_se(Request $request)
    {
        $request->validate([
            'nom_servicio' => 'required',
            'lectura' => 'gt:0'
        ],[
            'nom_servicio.required' => 'Debe ingresar nombre.',
            'lectura.gt' => 'Debe seleccionar lectura.'
        ]);

        $valida = Servicio::where('nom_servicio', $request->nom_servicio)->where('lectura', $request->lectura)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            Servicio::create([
                'nom_servicio' => $request->nom_servicio,
                'lectura' => $request->lectura,
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
        $get_id = Servicio::findOrFail($id);
        return view('seguridad.administracion.lectura_servicio.servicio.modal_editar', compact('get_id'));
    }

    public function update_se(Request $request, $id)
    {
        $request->validate([
            'nom_servicioe' => 'required',
            'lecturae' => 'gt:0'
        ],[
            'nom_servicioe.required' => 'Debe ingresar nombre.',
            'lecturae.gt' => 'Debe seleccionar lectura.'
        ]);

        $valida = Servicio::where('nom_servicio', $request->nom_servicioe)->where('lectura', $request->lecturae)
                ->where('estado', 1)->where('id_servicio', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Servicio::findOrFail($id)->update([
                'nom_servicio' => $request->nom_servicioe,
                'lectura' => $request->lecturae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_se($id)
    {
        Servicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
    
    /*public function index_ho()
    {
        return view('seguridad.administracion.lectura_servicio.hora_programada.index');
    }

    public function list_ho()
    {
        $list_hora_programada = Horas::select('horas.id_hora','sedes.nombre_sede','horas.hora','horas.orden')
                            ->join('sedes','sedes.id_sede','=','horas.id_sede')
                            ->where('horas.estado', 1)->get();
        return view('seguridad.administracion.lectura_servicio.hora_programada.lista', compact('list_hora_programada'));
    }

    public function create_ho()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->orderBy('nombre_sede','ASC')
                            ->get();
        return view('seguridad.administracion.lectura_servicio.hora_programada.modal_registrar', compact(['list_sede']));
    }

    public function store_ho(Request $request)
    {
        $request->validate([
            'id_sede' => 'gt:0',
            'hora' => 'required',
            'orden' => 'required',
        ],[
            'id_sede.gt' => 'Debe seleccionar sede.',
            'hora.required' => 'Debe ingresar hora.',
            'orden.required' => 'Debe ingresar orden.',
        ]);

        $valida = Horas::where('id_sede', $request->id_sede)->where('orden', $request->orden)->where('estado', 1)
                        ->exists();
        if($valida){
            echo "error";
        }else{
            Horas::create([
                'id_sede' => $request->id_sede,
                'hora' => $request->hora,
                'orden' => $request->orden,
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
        return view('seguridad.administracion.lectura_servicio.hora_programada.modal_editar', compact('get_id','list_sede'));
    }

    public function update_ho(Request $request, $id)
    {
        $request->validate([
            'id_sedee' => 'gt:0',
            'horae' => 'required',
            'ordene' => 'required',
        ],[
            'id_sedee.gt' => 'Debe seleccionar sede.',
            'horae.required' => 'Debe ingresar hora.',
            'ordene.required' => 'Debe ingresar orden.',
        ]);

        $valida = Horas::where('id_sede', $request->id_sedee)->where('orden', $request->ordene)
                        ->where('estado', 1)->where('id_hora', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Horas::findOrFail($id)->update([
                'id_sede' => $request->id_sedee,
                'hora' => $request->horae,
                'orden' => $request->ordene,
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
    }*/
}
