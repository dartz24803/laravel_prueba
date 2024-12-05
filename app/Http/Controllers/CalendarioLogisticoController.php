<?php

namespace App\Http\Controllers;

use App\Models\CalendarioLogistico;
use App\Models\Notificacion;
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
        $list_notificacion = Notificacion::get_list_notificacion();    
        $list_tipo_calendario = TipoCalendarioLogistico::all();
        $list_calendario = CalendarioLogistico::from('calendario_logistico AS cl')
                        ->select('cl.*','tc.color','pr.nombre_proveedor')
                        ->join('tipo_calendario_logistico AS tc','tc.id_tipo_calendario','=','cl.id_tipo_calendario')
                        ->leftjoin('proveedor AS pr','cl.id_proveedor','=','pr.id_proveedor')
                        ->where('cl.estado',1)->where('cl.invitacion',0)->get();
        return view('calendario_logistico.index',compact(
            'list_notificacion',
            'list_tipo_calendario',
            'list_calendario'
        ));
    }
}
