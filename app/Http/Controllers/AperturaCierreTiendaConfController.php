<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\CObservacionAperturaCierreTienda;
use App\Models\Notificacion;
use App\Models\TiendaMarcacion;
use App\Models\TiendaMarcacionDia;
use Illuminate\Http\Request;
use App\Models\SubGerencia;

class AperturaCierreTiendaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(1);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('seguridad.administracion.apertura_cierre.index', compact('list_notificacion', 'list_subgerencia'));
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
        return view('seguridad.administracion.apertura_cierre.horario_programado.modal_registrar', compact('list_base'));
    }

    public function store_ho(Request $request)
    {
        $request->validate([
            'cod_base' => 'not_in:0',
            'cant_foto_ingreso' => 'required',
            'cant_foto_apertura' => 'required',
            'cant_foto_cierre' => 'required',
            'cant_foto_salida' => 'required',
            'ch_lu' => 'required_without_all:ch_ma,ch_mi,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_ma' => 'required_without_all:ch_lu,ch_mi,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_mi' => 'required_without_all:ch_lu,ch_ma,ch_ju,ch_vi,ch_sa,ch_do|boolean',
            'ch_ju' => 'required_without_all:ch_lu,ch_ma,ch_mi,ch_vi,ch_sa,ch_do|boolean',
            'ch_vi' => 'required_without_all:ch_lu,ch_ma,ch_mi,ch_ju,ch_sa,ch_do|boolean',
            'ch_sa' => 'required_without_all:ch_lu,ch_ma,ch_mi,ch_ju,ch_vi,ch_do|boolean',
            'ch_do' => 'required_without_all:ch_lu,ch_ma,ch_mi,ch_ju,ch_vi,ch_sa|boolean',
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
        ], [
            'cod_base.not_in' => 'Debe seleccionar base.',
            'cant_foto_ingreso.required' => 'Debe ingresar cantidad de fotos (ingreso).',
            'cant_foto_apertura.required' => 'Debe ingresar cantidad de fotos (apertura).',
            'cant_foto_cierre.required' => 'Debe ingresar cantidad de fotos (cierre).',
            'cant_foto_salida.required' => 'Debe ingresar cantidad de fotos (salida).',
            'ch_lu.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_ma.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_mi.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_ju.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_vi.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_sa.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_do.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
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
            'hora_ingreso_do.required_if' => 'Debe ingresar hora de ingreso para el día domingo.',
            'hora_apertura_do.required_if' => 'Debe ingresar hora de apertura para el día domingo.',
            'hora_cierre_do.required_if' => 'Debe ingresar hora de cierre para el día domingo.',
            'hora_salida_do.required_if' => 'Debe ingresar hora de salida para el día domingo.',
        ]);

        $valida = TiendaMarcacion::where('cod_base', $request->cod_base)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            $tienda_marcacion = TiendaMarcacion::create([
                'cod_base' => $request->cod_base,
                'cant_foto_ingreso' => $request->cant_foto_ingreso,
                'cant_foto_apertura' => $request->cant_foto_apertura,
                'cant_foto_cierre' => $request->cant_foto_cierre,
                'cant_foto_salida' => $request->cant_foto_salida,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);


            if ($request->ch_lu == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 1,
                    'nom_dia' => "Lunes",
                    'hora_ingreso' => $request->hora_ingreso_lu,
                    'hora_apertura' => $request->hora_apertura_lu,
                    'hora_cierre' => $request->hora_cierre_lu,
                    'hora_salida' => $request->hora_salida_lu
                ]);
            }
            if ($request->ch_ma == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 2,
                    'nom_dia' => "Martes",
                    'hora_ingreso' => $request->hora_ingreso_ma,
                    'hora_apertura' => $request->hora_apertura_ma,
                    'hora_cierre' => $request->hora_cierre_ma,
                    'hora_salida' => $request->hora_salida_ma
                ]);
            }
            if ($request->ch_mi == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 3,
                    'nom_dia' => "Miércoles",
                    'hora_ingreso' => $request->hora_ingreso_mi,
                    'hora_apertura' => $request->hora_apertura_mi,
                    'hora_cierre' => $request->hora_cierre_mi,
                    'hora_salida' => $request->hora_salida_mi
                ]);
            }
            if ($request->ch_ju == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 4,
                    'nom_dia' => "Jueves",
                    'hora_ingreso' => $request->hora_ingreso_ju,
                    'hora_apertura' => $request->hora_apertura_ju,
                    'hora_cierre' => $request->hora_cierre_ju,
                    'hora_salida' => $request->hora_salida_ju
                ]);
            }
            if ($request->ch_vi == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 5,
                    'nom_dia' => "Viernes",
                    'hora_ingreso' => $request->hora_ingreso_vi,
                    'hora_apertura' => $request->hora_apertura_vi,
                    'hora_cierre' => $request->hora_cierre_vi,
                    'hora_salida' => $request->hora_salida_vi
                ]);
            }
            if ($request->ch_sa == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 6,
                    'nom_dia' => "Sábado",
                    'hora_ingreso' => $request->hora_ingreso_sa,
                    'hora_apertura' => $request->hora_apertura_sa,
                    'hora_cierre' => $request->hora_cierre_sa,
                    'hora_salida' => $request->hora_salida_sa
                ]);
            }
            if ($request->ch_do == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $tienda_marcacion->id_tienda_marcacion,
                    'dia' => 7,
                    'nom_dia' => "Domingo",
                    'hora_ingreso' => $request->hora_ingreso_do,
                    'hora_apertura' => $request->hora_apertura_do,
                    'hora_cierre' => $request->hora_cierre_do,
                    'hora_salida' => $request->hora_salida_do
                ]);
            }
        }
    }

    public function edit_ho($id)
    {
        $get_id = TiendaMarcacion::findOrFail($id);
        $list_base = Base::get_list_bases_tienda();
        $list_detalle = TiendaMarcacionDia::select('dia', 'hora_ingreso', 'hora_apertura', 'hora_cierre', 'hora_salida')->where('id_tienda_marcacion', $id)->get();
        return view('seguridad.administracion.apertura_cierre.horario_programado.modal_editar', compact('get_id', 'list_base', 'list_detalle'));
    }

    public function update_ho(Request $request, $id)
    {
        $request->validate([
            'cod_basee' => 'not_in:0',
            'cant_foto_ingresoe' => 'required',
            'cant_foto_aperturae' => 'required',
            'cant_foto_cierree' => 'required',
            'cant_foto_salidae' => 'required',
            'ch_lue' => 'required_without_all:ch_mae,ch_mie,ch_jue,ch_vie,ch_sae,ch_doe|boolean',
            'ch_mae' => 'required_without_all:ch_lue,ch_mie,ch_jue,ch_vie,ch_sae,ch_doe|boolean',
            'ch_mie' => 'required_without_all:ch_lue,ch_mae,ch_jue,ch_vie,ch_sae,ch_doe|boolean',
            'ch_jue' => 'required_without_all:ch_lue,ch_mae,ch_mie,ch_vie,ch_sae,ch_doe|boolean',
            'ch_vie' => 'required_without_all:ch_lue,ch_mae,ch_mie,ch_jue,ch_sae,ch_doe|boolean',
            'ch_sae' => 'required_without_all:ch_lue,ch_mae,ch_mie,ch_jue,ch_vie,ch_doe|boolean',
            'ch_doe' => 'required_without_all:ch_lue,ch_mae,ch_mie,ch_jue,ch_vie,ch_sae|boolean',
            'hora_ingreso_lue' => 'required_if:ch_lu,1',
            'hora_apertura_lue' => 'required_if:ch_lu,1',
            'hora_cierre_lue' => 'required_if:ch_lu,1',
            'hora_salida_lue' => 'required_if:ch_lu,1',
            'hora_ingreso_mae' => 'required_if:ch_ma,1',
            'hora_apertura_mae' => 'required_if:ch_ma,1',
            'hora_cierre_mae' => 'required_if:ch_ma,1',
            'hora_salida_mae' => 'required_if:ch_ma,1',
            'hora_ingreso_mie' => 'required_if:ch_mi,1',
            'hora_apertura_mie' => 'required_if:ch_mi,1',
            'hora_cierre_mie' => 'required_if:ch_mi,1',
            'hora_salida_mie' => 'required_if:ch_mi,1',
            'hora_ingreso_jue' => 'required_if:ch_ju,1',
            'hora_apertura_jue' => 'required_if:ch_ju,1',
            'hora_cierre_jue' => 'required_if:ch_ju,1',
            'hora_salida_jue' => 'required_if:ch_ju,1',
            'hora_ingreso_vie' => 'required_if:ch_vi,1',
            'hora_apertura_vie' => 'required_if:ch_vi,1',
            'hora_cierre_vie' => 'required_if:ch_vi,1',
            'hora_salida_vie' => 'required_if:ch_vi,1',
            'hora_ingreso_sae' => 'required_if:ch_sa,1',
            'hora_apertura_sae' => 'required_if:ch_sa,1',
            'hora_cierre_sae' => 'required_if:ch_sa,1',
            'hora_salida_sae' => 'required_if:ch_sa,1',
            'hora_ingreso_doe' => 'required_if:ch_do,1',
            'hora_apertura_doe' => 'required_if:ch_do,1',
            'hora_cierre_doe' => 'required_if:ch_do,1',
            'hora_salida_doe' => 'required_if:ch_do,1',
        ], [
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'cant_foto_ingresoe.required' => 'Debe ingresar cantidad de fotos (ingreso).',
            'cant_foto_aperturae.required' => 'Debe ingresar cantidad de fotos (apertura).',
            'cant_foto_cierree.required' => 'Debe ingresar cantidad de fotos (cierre).',
            'cant_foto_salidae.required' => 'Debe ingresar cantidad de fotos (salida).',
            'ch_lue.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_mae.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_mie.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_jue.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_vie.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_sae.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'ch_doe.required_without_all' => 'Debe seleccionar al menos un día de la semana.',
            'hora_ingreso_lue.required_if' => 'Debe ingresar hora de ingreso para el día lunes.',
            'hora_apertura_lue.required_if' => 'Debe ingresar hora de apertura para el día lunes.',
            'hora_cierre_lue.required_if' => 'Debe ingresar hora de cierre para el día lunes.',
            'hora_salida_lue.required_if' => 'Debe ingresar hora de salida para el día lunes.',
            'hora_ingreso_mae.required_if' => 'Debe ingresar hora de ingreso para el día martes.',
            'hora_apertura_mae.required_if' => 'Debe ingresar hora de apertura para el día martes.',
            'hora_cierre_mae.required_if' => 'Debe ingresar hora de cierre para el día martes.',
            'hora_salida_mae.required_if' => 'Debe ingresar hora de salida para el día martes.',
            'hora_ingreso_mie.required_if' => 'Debe ingresar hora de ingreso para el día miércoles.',
            'hora_apertura_mie.required_if' => 'Debe ingresar hora de apertura para el día miércoles.',
            'hora_cierre_mie.required_if' => 'Debe ingresar hora de cierre para el día miércoles.',
            'hora_salida_mie.required_if' => 'Debe ingresar hora de salida para el día miércoles.',
            'hora_ingreso_jue.required_if' => 'Debe ingresar hora de ingreso para el día jueves.',
            'hora_apertura_jue.required_if' => 'Debe ingresar hora de apertura para el día jueves.',
            'hora_cierre_jue.required_if' => 'Debe ingresar hora de cierre para el día jueves.',
            'hora_salida_jue.required_if' => 'Debe ingresar hora de salida para el día jueves.',
            'hora_ingreso_vie.required_if' => 'Debe ingresar hora de ingreso para el día viernes.',
            'hora_apertura_vie.required_if' => 'Debe ingresar hora de apertura para el día viernes.',
            'hora_cierre_vie.required_if' => 'Debe ingresar hora de cierre para el día viernes.',
            'hora_salida_vie.required_if' => 'Debe ingresar hora de salida para el día viernes.',
            'hora_ingreso_sae.required_if' => 'Debe ingresar hora de ingreso para el día sábado.',
            'hora_apertura_sae.required_if' => 'Debe ingresar hora de apertura para el día sábado.',
            'hora_cierre_sae.required_if' => 'Debe ingresar hora de cierre para el día sábado.',
            'hora_salida_sae.required_if' => 'Debe ingresar hora de salida para el día sábado.',
            'hora_ingreso_doe.required_if' => 'Debe ingresar hora de ingreso para el día domingo.',
            'hora_apertura_doe.required_if' => 'Debe ingresar hora de apertura para el día domingo.',
            'hora_cierre_doe.required_if' => 'Debe ingresar hora de cierre para el día domingo.',
            'hora_salida_doe.required_if' => 'Debe ingresar hora de salida para el día domingo.',
        ]);

        $valida = TiendaMarcacion::where('cod_base', $request->cod_basee)->where('estado', 1)->where('id_tienda_marcacion', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            TiendaMarcacion::findOrFail($id)->update([
                'cod_base' => $request->cod_basee,
                'cant_foto_ingreso' => $request->cant_foto_ingresoe,
                'cant_foto_apertura' => $request->cant_foto_aperturae,
                'cant_foto_cierre' => $request->cant_foto_cierree,
                'cant_foto_salida' => $request->cant_foto_salidae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            TiendaMarcacionDia::where('id_tienda_marcacion', $id)->delete();
            if ($request->ch_lue == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 1,
                    'nom_dia' => "Lunes",
                    'hora_ingreso' => $request->hora_ingreso_lue,
                    'hora_apertura' => $request->hora_apertura_lue,
                    'hora_cierre' => $request->hora_cierre_lue,
                    'hora_salida' => $request->hora_salida_lue
                ]);
            }
            if ($request->ch_mae == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 2,
                    'nom_dia' => "Martes",
                    'hora_ingreso' => $request->hora_ingreso_mae,
                    'hora_apertura' => $request->hora_apertura_mae,
                    'hora_cierre' => $request->hora_cierre_mae,
                    'hora_salida' => $request->hora_salida_mae
                ]);
            }
            if ($request->ch_mie == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 3,
                    'nom_dia' => "Miércoles",
                    'hora_ingreso' => $request->hora_ingreso_mie,
                    'hora_apertura' => $request->hora_apertura_mie,
                    'hora_cierre' => $request->hora_cierre_mie,
                    'hora_salida' => $request->hora_salida_mie
                ]);
            }
            if ($request->ch_jue == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 4,
                    'nom_dia' => "Jueves",
                    'hora_ingreso' => $request->hora_ingreso_jue,
                    'hora_apertura' => $request->hora_apertura_jue,
                    'hora_cierre' => $request->hora_cierre_jue,
                    'hora_salida' => $request->hora_salida_jue
                ]);
            }
            if ($request->ch_vie == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 5,
                    'nom_dia' => "Viernes",
                    'hora_ingreso' => $request->hora_ingreso_vie,
                    'hora_apertura' => $request->hora_apertura_vie,
                    'hora_cierre' => $request->hora_cierre_vie,
                    'hora_salida' => $request->hora_salida_vie
                ]);
            }
            if ($request->ch_sae == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 6,
                    'nom_dia' => "Sábado",
                    'hora_ingreso' => $request->hora_ingreso_sae,
                    'hora_apertura' => $request->hora_apertura_sae,
                    'hora_cierre' => $request->hora_cierre_sae,
                    'hora_salida' => $request->hora_salida_sae
                ]);
            }
            if ($request->ch_doe == "1") {
                TiendaMarcacionDia::create([
                    'id_tienda_marcacion' => $id,
                    'dia' => 7,
                    'nom_dia' => "Domingo",
                    'hora_ingreso' => $request->hora_ingreso_doe,
                    'hora_apertura' => $request->hora_apertura_doe,
                    'hora_cierre' => $request->hora_cierre_doe,
                    'hora_salida' => $request->hora_salida_doe
                ]);
            }
        }
    }

    public function destroy_ho($id)
    {
        TiendaMarcacion::findOrFail($id)->update([
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
        $list_observacion = CObservacionAperturaCierreTienda::select('id', 'descripcion')->where('estado', 1)->get();
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
        ], [
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        $valida = CObservacionAperturaCierreTienda::where('descripcion', $request->descripcion)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
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
        ], [
            'descripcione.required' => 'Debe ingresar descripción.',
        ]);

        $valida = CObservacionAperturaCierreTienda::where('descripcion', $request->descripcione)->where('estado', 1)->where('id', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
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
