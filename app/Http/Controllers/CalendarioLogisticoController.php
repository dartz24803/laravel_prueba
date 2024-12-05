<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\CalendarioLogistico;
use App\Models\Notificacion;
use App\Models\TipoCalendarioLogistico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $list_tipo_calendario_todo = TipoCalendarioLogistico::all();
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_calendario = CalendarioLogistico::from('calendario_logistico AS cl')
                        ->select('cl.*','tc.color','pr.nombre_proveedor')
                        ->join('tipo_calendario_logistico AS tc','tc.id_tipo_calendario','=','cl.id_tipo_calendario')
                        ->leftjoin('proveedor AS pr','cl.id_proveedor','=','pr.id_proveedor')
                        ->where(DB::raw("YEAR(cl.fec_de)"),"=",DB::raw("YEAR(CURDATE())"))->where('cl.invitacion',0)
                        ->where('cl.estado',1)->get();
        if(session('usuario')->id_nivel=="1"){
            $list_tipo_calendario = TipoCalendarioLogistico::all();
        }elseif(session('usuario')->id_puesto=="83" ||
        session('usuario')->id_puesto=="122" ||
        session('usuario')->id_puesto=="195"){
            $list_tipo_calendario = TipoCalendarioLogistico::where('id_tipo_calendario',3)->get();
        }elseif(session('usuario')->id_puesto=="75"){
            $list_tipo_calendario = TipoCalendarioLogistico::whereIn('id_tipo_calendario',[1,2])->get();
        }
        return view('calendario_logistico.index',compact(
            'list_notificacion',
            'list_tipo_calendario_todo',
            'list_base',
            'list_tipo_calendario',
            'list_calendario'
        ));
    }
}
