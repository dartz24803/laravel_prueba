<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\CObservacionAperturaCierreTienda;
use App\Models\TiendaMarcacion;
use Illuminate\Http\Request;

class AperturaCierreTiendaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.administracion.apertura_cierre.index');
    }

    public function index_ho()
    {
        return view('seguridad.administracion.apertura_cierre.horario_programado.index');
    }

    public function list_ho()
    {
        $list_horario_programado = TiendaMarcacion::get_list_tienda_marcacion();
        return view('seguridad.administracion.apertura_cierre.horario_programado.lista', compact('list_horario_programado'));
    }

    public function create_ho()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('seguridad.administracion.apertura_cierre.horario_programado.modal_registrar',compact('list_base'));
    }

    public function store_ho(Request $request)
    {
        $request->validate([
            'cod_base' => 'not_in:0',
            'ch_lu' => 'required_without:ch_ma,ch_mi,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_ma' => 'required_without:ch_lu,ch_mi,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_mi' => 'required_without:ch_lu,ch_ma,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_ju' => 'required_without:ch_lu,ch_ma,ch_mi,ch_vi,ch_sa,ch_do|boolean',
            'ch_vi' => 'required_without:ch_lu,ch_ma,ch_mi,ch_ju,ch_sa,ch_do|boolean',
            'ch_sa' => 'required_without:ch_lu,ch_ma,ch_mi,ch_ju,ch_vi,ch_do|boolean',
            'ch_do' => 'required_without:ch_lu,ch_ma,ch_mi,ch_ju,ch_vi,ch_sa|boolean',
            'hora_ingreso_lu' => 'required_if:ch_lu,1',
            'hora_apertura_lu' => 'required_if:ch_lu,1',
            'hora_cierre_lu' => 'required_if:ch_lu,1',
            'hora_salida_lu' => 'required_if:ch_lu,1',
            'hora_ingreso_ma' => 'required_if:ch_ma,1',
            'hora_apertura_ma' => 'required_if:ch_ma,1',
            'hora_cierre_ma' => 'required_if:ch_ma,1',
            'hora_salida_ma' => 'required_if:ch_ma,1',
            'hora_ingreso_mi' => 'required_if:ch_mi,1',
            'hora_apertura_mi' => 'required_if:ch_mi,1',
            'hora_cierre_mi' => 'required_if:ch_mi,1',
            'hora_salida_mi' => 'required_if:ch_mi,1',
            'hora_ingreso_ju' => 'required_if:ch_ju,1',
            'hora_apertura_ju' => 'required_if:ch_ju,1',
            'hora_cierre_ju' => 'required_if:ch_ju,1',
            'hora_salida_ju' => 'required_if:ch_ju,1',
            'hora_ingreso_vi' => 'required_if:ch_vi,1',
            'hora_apertura_vi' => 'required_if:ch_vi,1',
            'hora_cierre_vi' => 'required_if:ch_vi,1',
            'hora_salida_vi' => 'required_if:ch_vi,1',
            'hora_ingreso_sa' => 'required_if:ch_sa,1',
            'hora_apertura_sa' => 'required_if:ch_sa,1',
            'hora_cierre_sa' => 'required_if:ch_sa,1',
            'hora_salida_sa' => 'required_if:ch_sa,1',
            'hora_ingreso_do' => 'required_if:ch_do,1',
            'hora_apertura_do' => 'required_if:ch_do,1',
            'hora_cierre_do' => 'required_if:ch_do,1',
            'hora_salida_do' => 'required_if:ch_do,1',
        ],[
            'cod_base.not_in' => 'Debe seleccionar base.',
            'ch_lu.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_ma.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_mi.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_ju.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_vi.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_sa.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'ch_do.required_without' => 'Debe seleccionar al menos un día de la semana.',
            'hora_ingreso_lu.required_if' => 'Debe ingresar hora de ingreso para el día lunes.',
            'hora_apertura_lu.required_if' => 'Debe ingresar hora de apertura para el día lunes.',
            'hora_cierre_lu.required_if' => 'Debe ingresar hora de cierre para el día lunes.',
            'hora_salida_lu.required_if' => 'Debe ingresar hora de salida para el día lunes.',
            'hora_ingreso_ma.required_if' => 'Debe ingresar hora de ingreso para el día martes.',
            'hora_apertura_ma.required_if' => 'Debe ingresar hora de apertura para el día martes.',
            'hora_cierre_ma.required_if' => 'Debe ingresar hora de cierre para el día martes.',
            'hora_salida_ma.required_if' => 'Debe ingresar hora de salida para el día martes.',
            'hora_ingreso_mi.required_if' => 'Debe ingresar hora de ingreso para el día miércoles.',
            'hora_apertura_mi.required_if' => 'Debe ingresar hora de apertura para el día miércoles.',
            'hora_cierre_mi.required_if' => 'Debe ingresar hora de cierre para el día miércoles.',
            'hora_salida_mi.required_if' => 'Debe ingresar hora de salida para el día miércoles.',
            'hora_ingreso_ju.required_if' => 'Debe ingresar hora de ingreso para el día jueves.',
            'hora_apertura_ju.required_if' => 'Debe ingresar hora de apertura para el día jueves.',
            'hora_cierre_ju.required_if' => 'Debe ingresar hora de cierre para el día jueves.',
            'hora_salida_ju.required_if' => 'Debe ingresar hora de salida para el día jueves.',
            'hora_ingreso_vi.required_if' => 'Debe ingresar hora de ingreso para el día viernes.',
            'hora_apertura_vi.required_if' => 'Debe ingresar hora de apertura para el día viernes.',
            'hora_cierre_vi.required_if' => 'Debe ingresar hora de cierre para el día viernes.',
            'hora_salida_vi.required_if' => 'Debe ingresar hora de salida para el día viernes.',
            'hora_ingreso_sa.required_if' => 'Debe ingresar hora de ingreso para el día sábado.',
            'hora_apertura_sa.required_if' => 'Debe ingresar hora de apertura para el día sábado.',
            'hora_cierre_sa.required_if' => 'Debe ingresar hora de cierre para el día sábado.',
            'hora_salida_sa.required_if' => 'Debe ingresar hora de salida para el día sábado.',
            'hora_ingreso_do.required_if' => 'Debe ingresar hora de ingreso para el día domino.',
            'hora_apertura_do.required_if' => 'Debe ingresar hora de apertura para el día domino.',
            'hora_cierre_do.required_if' => 'Debe ingresar hora de cierre para el día domino.',
            'hora_salida_do.required_if' => 'Debe ingresar hora de salida para el día domino.',
        ]);

        echo "Gaaa";

        /*$valida = TiendaMarcacion::where('cod_base', $request->cod_base)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            TiendaMarcacion::create([
                'cod_base' => $request->cod_base,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }*/
    }

    public function edit_ho($id)
    {
        $get_id = CObservacionAperturaCierreTienda::findOrFail($id);
        return view('seguridad.administracion.apertura_cierre.horario_programado.modal_editar', compact('get_id'));
    }

    public function update_ho(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = CObservacionAperturaCierreTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            CObservacionAperturaCierreTienda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ho($id)
    {
        CObservacionAperturaCierreTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_ob()
    {
        return view('seguridad.administracion.apertura_cierre.observacion.index');
    }

    public function list_ob()
    {
        $list_observacion = CObservacionAperturaCierreTienda::select('id','descripcion')->where('estado', 1)->get();
        return view('seguridad.administracion.apertura_cierre.observacion.lista', compact('list_observacion'));
    }

    public function create_ob()
    {
        return view('seguridad.administracion.apertura_cierre.observacion.modal_registrar');
    }

    public function store_ob(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
        ],[
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = CObservacionAperturaCierreTienda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
            CObservacionAperturaCierreTienda::create([
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ob($id)
    {
        $get_id = CObservacionAperturaCierreTienda::findOrFail($id);
        return view('seguridad.administracion.apertura_cierre.observacion.modal_editar', compact('get_id'));
    }

    public function update_ob(Request $request, $id)
    {
        $request->validate([
            'descripcione' => 'required',
        ],[
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = CObservacionAperturaCierreTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if($valida){
            echo "error";
        }else{
            CObservacionAperturaCierreTienda::findOrFail($id)->update([
                'descripcion' => $request->descripcione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ob($id)
    {
        CObservacionAperturaCierreTienda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
