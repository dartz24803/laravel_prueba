<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\SalidaContometro;
use App\Models\StockSalidaInsumo;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalidaInsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();  
        $list_subgerencia = SubGerencia::list_subgerencia(13);  
        return view('caja.salida_insumo.index', compact('list_notificacion','list_subgerencia'));
    }

    public function list_izquierda()
    {
        $list_stock_salida_insumo = StockSalidaInsumo::where('cod_base',session('usuario')->centro_labores)->get();
        return view('caja.salida_insumo.lista_izquierda', compact('list_stock_salida_insumo'));
    }

    public function list_derecha()
    {
        $list_salida_contometro = SalidaContometro::from('salida_contometro AS sc')
                                ->select('sc.fecha AS orden',DB::raw('DATE_FORMAT(sc.fecha,"%d-%m-%Y %H:%i:%s") AS fecha'),
                                'iu.nom_insumo','sc.cantidad_salida',DB::raw('CASE WHEN sc.flag_acceso=1 THEN sc.cod_base 
                                ELSE CONCAT(us.usuario_nombres," ",us.usuario_apater," ",us.usuario_amater) END AS nom_usuario'))
                                ->join('insumo AS iu','iu.id_insumo','=','sc.id_insumo')
                                ->leftjoin('users AS us','us.id_usuario','=','sc.id_usuario')
                                ->where('sc.cod_base',session('usuario')->centro_labores)->where('sc.estado',1)
                                ->get();
        return view('caja.salida_insumo.lista_derecha', compact('list_salida_contometro'));
    }

    public function create()
    { 
        $list_insumo = StockSalidaInsumo::select('id_insumo','nom_insumo')
                        ->where('cod_base',session('usuario')->centro_labores)
                        ->orderBy('nom_insumo','ASC')->get();
        return view('caja.salida_insumo.modal_registrar',compact('list_insumo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_insumo' => 'gt:0',
            'cantidad_salida' => 'required|gt:0'
        ], [
            'id_insumo.gt' => 'Debe seleccionar insumo.',
            'cantidad_salida.required' => 'Debe ingresar cantidad.',
            'cantidad_salida.gt' => 'Debe ingresar cantidad mayor a 0.'
        ]);

        $stock = StockSalidaInsumo::where('cod_base',session('usuario')->centro_labores)
                ->where('id_insumo',$request->id_insumo)->first();

        if(!isset($stock) || $request->cantidad_salida>$stock->total){
            echo "error";
        }else{
            SalidaContometro::create([
                'id_insumo' => $request->id_insumo,
                'cantidad_salida' => $request->cantidad_salida,
                'cod_base' => session('usuario')->centro_labores,
                'flag_acceso' => 0,
                'fecha' => now(),
                'id_usuario' => session('usuario')->id_usuario,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }
}
