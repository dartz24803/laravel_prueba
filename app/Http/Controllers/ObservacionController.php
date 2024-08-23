<?php

namespace App\Http\Controllers;

use App\Models\Base;
use Illuminate\Http\Request;

class ObservacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_reg()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('caja.observacion.index',compact('list_base'));
    }

    public function list_reg(Request $request)
    {
        $list_observacion = [];//LecturaServicio::get_list_lectura_servicio(['id_servicio'=>$request->id_servicio,'cod_base'=>session('usuario')->centro_labores,'mes'=>$request->mes,'anio'=>$request->anio]);
        return view('caja.observacion.lista', compact('list_observacion'));
    }

    public function create_reg()
    {
        $list_servicio = Servicio::where('lectura',1)->where('estado',1)->get();
        return view('caja.observacion.modal_registrar',compact('list_servicio'));
    }
}
