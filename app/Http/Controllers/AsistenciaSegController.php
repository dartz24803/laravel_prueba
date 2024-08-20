<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsistenciaSegController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.asistencia.index');
    }

    public function index_reg()
    {
        $list_servicio = Servicio::where('lectura',1)->where('estado',1)->get();
        $list_mes = Mes::select('cod_mes','nom_mes')->where('estado',1)->get();
        $list_anio = Anio::select('cod_anio')->where('estado',1)->orderBy('cod_anio','DESC')->get();
        return view('seguridad.asistencia.lectora.index',compact('list_servicio','list_mes','list_anio'));
    }

    public function list_reg(Request $request)
    {
        $list_lectura_servicio = LecturaServicio::get_list_lectura_servicio(['id_servicio'=>$request->id_servicio,'mes'=>$request->mes,'anio'=>$request->anio]);
        return view('seguridad.asistencia.lectora.lista', compact('list_lectura_servicio'));
    }
}
