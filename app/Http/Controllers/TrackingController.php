<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tracking;
use App\Models\BaseModel;
use App\Models\TrackingDetalleEstado;
use App\Models\TrackingDetalleProceso;

class TrackingController extends Controller
{
    protected $modelo;
    protected $modelobase;

    public function __construct()
    {
        $this->modelo = new Tracking();
        $this->modelobase = new BaseModel();
    }

    public function index()
    {
        if (session('usuario')) {
            return view('tracking.index');
        }else{
            return redirect('/');
        }
    }

    public function list()
    {
        if (session('usuario')) {
            $list_tracking = $this->modelo->get_list_tracking();
            return view('tracking.lista', compact('list_tracking'));
        }else{
            return redirect('/');
        }
    }

    public function create()
    {
        if (session('usuario')) {
            $list_base = $this->modelobase->get_list_base_tracking();
            return view('tracking.modal_registrar', compact('list_base'));
        }else{
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        if (session('usuario')) {
            $tracking = new Tracking();
            $tracking->n_requerimiento = $request->n_requerimiento;
            $tracking->semana = $request->semana;
            $tracking->desde = $request->desde;
            $tracking->hacia = $request->hacia;
            $tracking->estado = 1;
            $tracking->fec_reg = now();
            $tracking->save();

            $tracking_dp = new TrackingDetalleProceso();
            $tracking_dp->id_tracking = $tracking->id;
            $tracking_dp->id_proceso = 1;
            $tracking_dp->fecha = now();
            $tracking_dp->estado = 1;
            $tracking_dp->fec_reg = now();
            $tracking_dp->user_reg = session('usuario')->id;
            $tracking_dp->fec_act = now();
            $tracking_dp->user_act = session('usuario')->id;
            $tracking_dp->save();

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $tracking_dp->id;
            $tracking_de->id_estado = 1;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $tracking_dp->id;
            $tracking_de->id_estado = 2;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();
        }else{
            return redirect('/');
        }
    }

    public function insert_salida_mercaderia(Request $request)
    {
        $get_id = $this->modelo->get_list_tracking($request->id);

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id_detalle;
        $tracking_de->id_estado = 3;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();
    }
}
