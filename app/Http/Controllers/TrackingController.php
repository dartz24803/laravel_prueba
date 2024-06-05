<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Tracking;
use App\Models\BaseModel;
use App\Models\TrackingArchivo;
use App\Models\TrackingDetalleEstado;
use App\Models\TrackingDetalleProceso;

class TrackingController extends Controller
{
    protected $modelo;
    protected $modelobase;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
        $this->modelo = new Tracking();
        $this->modelobase = new BaseModel();
    }

    public function index()
    {
        return view('tracking.index');
    }

    public function list()
    {
        $list_tracking = $this->modelo->get_list_tracking();
        return view('tracking.lista', compact('list_tracking'));
    }

    public function create()
    {
        $list_base = $this->modelobase->get_list_base_tracking();
        return view('tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
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

    public function detalle_transporte($id)
    {
        $get_id = $this->modelo->get_list_tracking($id);
        return view('tracking.detalle_transporte', compact('get_id'));
    }

    public function insert_mercaderia_transito(Request $request)
    {
        $tracking = Tracking::findOrfail($request->id);
        $tracking->peso = $request->peso;
        $tracking->paquetes = $request->paquetes;
        $tracking->sobres = $request->sobres;
        $tracking->fardos = $request->fardos;
        $tracking->caja = $request->caja;
        $tracking->transporte = $request->transporte;
        $tracking->nombre_transporte = $request->nombre_transporte;
        $tracking->importe_transporte = $request->importe_transporte;
        $tracking->factura_transporte = $request->factura_transporte;
        $tracking->fec_act = now();
        $tracking->user_act = session('usuario')->id;
        $tracking->save();

        if($_FILES["archivo_transporte"]["name"] != ""){
            $dato['tipo'] = 1;
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $fecha = date('YmdHis');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_".$request->id."_".$fecha;
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $dato['archivo'] = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                    $tracking_a = new TrackingArchivo();
                    $tracking_a->id_tracking = $request->id;
                    $tracking_a->tipo = 1;
                    $tracking_a->archivo = $dato['archivo'];
                    $tracking_a->save();
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        $tracking_dp = new TrackingDetalleProceso();
        $tracking_dp->id_tracking = $request->id;
        $tracking_dp->id_proceso = 2;
        $tracking_dp->fecha = now();
        $tracking_dp->estado = 1;
        $tracking_dp->fec_reg = now();
        $tracking_dp->user_reg = session('usuario')->id;
        $tracking_dp->fec_act = now();
        $tracking_dp->user_act = session('usuario')->id;
        $tracking_dp->save();

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $tracking_dp->id;
        $tracking_de->id_estado = 4;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();
    }

    public function insert_llegada_tienda(Request $request)
    {
        $tracking_dp = new TrackingDetalleProceso();
        $tracking_dp->id_tracking = $request->id;
        $tracking_dp->id_proceso = 3;
        $tracking_dp->fecha = now();
        $tracking_dp->estado = 1;
        $tracking_dp->fec_reg = now();
        $tracking_dp->user_reg = session('usuario')->id;
        $tracking_dp->fec_act = now();
        $tracking_dp->user_act = session('usuario')->id;
        $tracking_dp->save();

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $tracking_dp->id;
        $tracking_de->id_estado = 5;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();
    }

    public function insert_confirmacion_llegada(Request $request)
    {
        $get_id = $this->modelo->get_list_tracking($request->id);

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id;
        $tracking_de->id_estado = 6;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id;
        $tracking_de->id_estado = 7;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();
    }

    public function insert_verificacion_fardos(Request $request)
    {
        $get_id = $this->modelo->get_list_tracking($request->id);

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id;
        $tracking_de->id_estado = 6;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id;
        $tracking_de->id_estado = 7;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();
    }

    public function verificacion_fardos($id)
    {
        $get_id = $this->modelo->get_list_tracking($id);
        return view('tracking.verificacion_fardos', compact('get_id'));
    }
}
