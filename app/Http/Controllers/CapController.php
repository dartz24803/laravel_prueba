<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Cap;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\Organigrama;
use App\Models\SubGerencia;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CapController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();      
        $list_subgerencia = SubGerencia::list_subgerencia(5);    
        return view('rrhh.cap.index',compact('list_notificacion','list_subgerencia'));
    }

    public function index_reg()
    {
        if(session('usuario')->id_puesto=="30" ||
        session('usuario')->id_puesto=="31" ||
        session('usuario')->id_puesto=="32" ||
        session('usuario')->id_puesto=="161" ||
        session('usuario')->id_puesto=="311" ||
        session('usuario')->id_puesto=="314"){
            $list_ubicacion = Ubicacion::where('id_ubicacion',session('usuario')->id_centro_labor)
                            ->where('estado',1)->get();
        }else{
            $list_ubicacion = Ubicacion::get_list_ubicacion_tienda();
        }
        return view('rrhh.cap.registro.index', compact('list_ubicacion'));
    }

    public function list_reg(Request $request)
    {
        $list_cap = DB::select('CALL lista_cap (?, ?)', [
            $request->id_ubicacion, 
            $request->fecha
        ]);
        return view('rrhh.cap.registro.lista', compact('list_cap'));
    }

    public function store_reg(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'fecha' => 'required'
        ],[
            'id_ubicacion.gt' => 'Debe seleccionar centro de labor.',
            'fecha.required' => 'Debe ingresar fecha.'
        ]);

        Cap::where('id_ubicacion',$request->id_ubicacion)->where('fecha',$request->fecha)->delete();
        $list_puesto = Organigrama::from('organigrama AS og')->select('og.id_puesto',
                        DB::raw('COUNT(1) AS cantidad'))
                        ->join('puesto as pu', function($join) {
                            $join->on('pu.id_puesto', '=', 'og.id_puesto')
                            ->whereIn('pu.id_area', [14,44]);
                        })
                        ->where('og.id_centro_labor',$request->id_ubicacion)
                        ->groupBy('og.id_puesto')->get();
        foreach($list_puesto as $list){
            $asistencia = $request->input('asistencia_'.$list->id_puesto);
            if($asistencia==""){
                $asistencia = 0;
            }
            $libre = $request->input('libre_'.$list->id_puesto);
            if($libre==""){
                $libre = 0;
            }
            $falta = $request->input('falta_'.$list->id_puesto);
            if($falta==""){
                $falta = 0;
            }
            Cap::create([
                'fecha' => $request->fecha,
                'id_ubicacion' => $request->id_ubicacion,
                'id_puesto' => $list->id_puesto,
                'aprobado' => $list->cantidad,
                'asistencia' => $asistencia,
                'libre' => $libre,
                'falta' => $falta,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario
            ]);
        }
    }

    public function index_ges(Request $request)
    {
        $mes = date('m');
        $anio = date('Y');
        if(isset($request->mes)){
            $mes = $request->mes;
        }
        if(isset($request->anio)){
            $anio = $request->anio;
        }
        $list_mes = Mes::all();
        $list_anio = Anio::orderBy('cod_anio','DESC')->get();
        return view('rrhh.cap.gestion.index', compact(
            'list_mes',
            'list_anio',
            'mes',
            'anio'
        ));
    }

    public function list_ges(Request $request)
    {
        $dias = cal_days_in_month(CAL_GREGORIAN, $request->mes, $request->anio);
        $mes = $request->mes;
        $anio = $request->anio;
        $list_gestion = DB::select('CALL lista_gestion_cap  (?, ?, ?)', [
            $dias,
            $mes, 
            $anio
        ]);
        return view('rrhh.cap.gestion.lista', compact('list_gestion','mes','anio'));
    }
    
    public function detalle_ges(Request $request, $id_centro_labor)
    {
        $mes = $request->mes;
        $anio = $request->anio;
        return view('rrhh.cap.gestion.detalle', compact(
            'id_centro_labor',
            'mes',
            'anio'
        ));
    }

    public function list_detalle_ges(Request $request, $id_centro_labor)
    {
        $dias = cal_days_in_month(CAL_GREGORIAN, $request->mes, $request->anio);
        $mes = $request->mes;
        $anio = $request->anio;
        $list_detalle_gestion = DB::select('CALL lista_detalle_gestion_cap  (?, ?, ?, ?, ?)', [
            $dias,
            $mes, 
            $anio,
            $request->tipo,
            $id_centro_labor
        ]);
        return view('rrhh.cap.gestion.lista_detalle', compact(
            'list_detalle_gestion',
            'mes',
            'anio'
        ));
    }
}
