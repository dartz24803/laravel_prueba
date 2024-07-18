<?php

namespace App\Http\Controllers;

use App\Models\ControlCamaraRonda;
use App\Models\Horas;
use App\Models\Local;
use App\Models\OcurrenciasCamaras;
use App\Models\Sedes;
use App\Models\Tiendas;
use App\Models\TiendasRonda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function index_ro()
    {
        return view('seguridad.administracion.control_camara.ronda.index');
    }

    public function list_ro()
    {
        $list_ronda = ControlCamaraRonda::select('id','descripcion')->where('estado', 1)->get();
        return view('seguridad.administracion.control_camara.ronda.lista', compact('list_ronda'));
    }

    public function create_ro()
    {
        return view('seguridad.administracion.control_camara.ronda.modal_registrar');
    }

    public function store_ro(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ControlCamaraRonda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            ControlCamaraRonda::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ro($id)
    {
        $get_id = ControlCamaraRonda::findOrFail($id);
        return view('seguridad.administracion.control_camara.ronda.modal_editar', compact('get_id'));
    }

    public function update_ro(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = ControlCamaraRonda::where('descripcion', $request->descripcione)->where('estado', 1)
                        ->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            ControlCamaraRonda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ro($id)
    {
        ControlCamaraRonda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ti()
    {
        return view('seguridad.administracion.control_camara.tienda.index');
    }

    public function list_ti()
    {
        $list_tienda = Tiendas::select('tiendas.id_tienda','sedes.nombre_sede','local.descripcion',
                                DB::raw('(SELECT GROUP_CONCAT(cr.descripcion SEPARATOR ", ")
                                FROM tiendas_ronda tr
                                INNER JOIN control_camara_ronda cr ON cr.id=tr.id_ronda
                                WHERE tr.id_tienda=tiendas.id_tienda) AS ronda'))
                                ->join('sedes','sedes.id_sede','=','tiendas.id_sede')
                                ->join('local','local.id_local','=','tiendas.id_local')
                                ->where('tiendas.estado', 1)->get();
        return view('seguridad.administracion.control_camara.tienda.lista', compact('list_tienda'));
    }

    public function create_ti()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->orderBy('nombre_sede','ASC')
                            ->get();
        $list_local = Local::select('id_local','descripcion')->where('estado',1)->orderBy('descripcion','ASC')
                            ->get();
        return view('seguridad.administracion.control_camara.tienda.modal_registrar', compact(['list_sede','list_local']));
    }

    public function store_ti(Request $request)
    {
        $request->validate([
            'id_sede' => 'gt:0',
            'id_local' => 'required',
        ],[
            'id_sede.gt' => 'Debe seleccionar sede.',
            'id_local.required' => 'Debe seleccionar al menos un local.',
        ]);

        if(is_array($request->id_local) && count($request->id_local)>0){
            $cadena = "";
            foreach($request->id_local as $local){
                $valida = Tiendas::where('id_sede', $request->id_sede)
                                    ->where('id_local',$local)->where('estado', 1)->exists();
                if($valida){
                    $get_local = Local::findOrFail($local);
                    $cadena = $cadena.$get_local->descripcion.", ";
                }
            }
            if($cadena!=""){
                $cadena = "Ya se seleccionó el(los) local(es) ".substr($cadena,0,-2)." para está sede.";
                echo $cadena;
            }else{
                foreach($request->id_local as $local){
                    Tiendas::create([
                        'id_sede' => $request->id_sede,
                        'id_local' => $local,
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }
            }
        }
    }

    public function edit_ti($id)
    {
        $get_id = Tiendas::findOrFail($id);
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->orderBy('nombre_sede','ASC')
                            ->get();
        $list_local = Local::select('id_local','descripcion')->where('estado',1)->orderBy('descripcion','ASC')
                            ->get();
        $list_ronda = ControlCamaraRonda::select('id','descripcion')->where('estado',1)
                            ->orderBy('descripcion','ASC')->get(); 
        $list_tienda_ronda = TiendasRonda::select('id_ronda')->where('id_tienda',$id)->get()->toArray();                                                       
        return view('seguridad.administracion.control_camara.tienda.modal_editar', compact('get_id','list_sede','list_local','list_ronda','list_tienda_ronda'));
    }

    public function traer_ronda_ti()
    {
        $list_ronda = ControlCamaraRonda::select('id','descripcion')->where('estado',1)
                                        ->orderBy('descripcion','ASC')->get();
        return view('seguridad.administracion.control_camara.tienda.rondas', compact('list_ronda'));
    }

    public function update_ti(Request $request, $id)
    {
        $request->validate([
            'id_sedee' => 'gt:0',
            'id_locale' => 'gt:0',
            'rondas' => 'required_if:ronda,1'
        ],[
            'id_sedee.gt' => 'Debe seleccionar sede.',
            'id_locale.gt' => 'Debe seleccionar local.',
            'rondas.required_if' => 'Debe seleccionar al menos una ronda',
        ]);

        $valida = Tiendas::where('id_sede', $request->id_sedee)->where('id_local', $request->id_locale)
                            ->where('estado', 1)->where('id_tienda', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            Tiendas::findOrFail($id)->update([
                'id_sede' => $request->id_sedee,
                'id_local' => $request->id_locale,
                'ronda' => $request->ronda,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if($request->ronda=="1"){
                if(is_array($request->rondas) && count($request->rondas)>0){
                    TiendasRonda::where('id_tienda',$id)->delete();
                    foreach($request->rondas as $ronda){
                        TiendasRonda::create([
                            'id_tienda' => $id,
                            'id_ronda' => $ronda,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    }
                }
            }else{
                TiendasRonda::where('id_tienda',$id)->delete();
            }
        }
    }

    public function destroy_ti($id)
    {
        Tiendas::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_oc()
    {
        return view('seguridad.administracion.control_camara.ocurrencia.index');
    }

    public function list_oc()
    {
        $list_ocurrencia = OcurrenciasCamaras::select('id_ocurrencias_camaras','descripcion')->where('estado', 1)->get();
        return view('seguridad.administracion.control_camara.ocurrencia.lista', compact('list_ocurrencia'));
    }

    public function create_oc()
    {
        return view('seguridad.administracion.control_camara.ocurrencia.modal_registrar');
    }

    public function store_oc(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = OcurrenciasCamaras::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciasCamaras::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_oc($id)
    {
        $get_id = OcurrenciasCamaras::findOrFail($id);
        return view('seguridad.administracion.control_camara.ocurrencia.modal_editar', compact('get_id'));
    }

    public function update_oc(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = OcurrenciasCamaras::where('descripcion', $request->descripcione)->where('estado', 1)
                        ->where('id_ocurrencias_camaras', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            OcurrenciasCamaras::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_oc($id)
    {
        OcurrenciasCamaras::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}