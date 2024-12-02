<?php

namespace App\Http\Controllers;

use App\Models\TipoCalendarioLogistico;
use Illuminate\Http\Request;

class CalendarioLogisticoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_tipo_calendario = TipoCalendarioLogistico::all();    
        $list_subgerencia = SubGerencia::list_subgerencia(3);      
        return view('comercial.requerimiento_tienda.index',compact(
            'list_tipo_calendario',
            'list_subgerencia'
        ));
    }

    public function index_re()
    {
        $list_base = BaseActiva::all();
        $list_anio = Anio::select('cod_anio')->where('estado',1)
                    ->where('cod_anio','>=','2024')->get();
        return view('comercial.requerimiento_tienda.reposicion.index', compact(
            'list_base',
            'list_anio'
        ));
    }

    public function list_re(Request $request)
    {
        $list_requerimiento_resposicion = MercaderiaSurtida::get_list_requerimiento_reposicion([
            'anio'=>$request->anio,
            'semana'=>$request->semana,
            'base'=>$request->base
        ]);
        return view('comercial.requerimiento_tienda.reposicion.lista', compact('list_requerimiento_resposicion'));
    }
}
