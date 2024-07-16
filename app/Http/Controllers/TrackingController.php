<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Tracking;
use App\Models\Base;
use App\Models\MercaderiaSurtida;
use App\Models\TrackingArchivo;
use App\Models\TrackingArchivoTemporal;
use App\Models\TrackingDetalleEstado;
use App\Models\TrackingDetalleProceso;
use App\Models\TrackingDevolucion;
use App\Models\TrackingDevolucionTemporal;
use App\Models\TrackingEvaluacionTemporal;
use App\Models\TrackingGuiaRemisionDetalle;
use App\Models\TrackingGuiaRemisionDetalleTemporal;
use App\Models\TrackingNotificacion;
use App\Models\TrackingTemporal;
use App\Models\TrackingToken;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except(['index','detalle_operacion_diferencia','evaluacion_devolucion','iniciar_tracking','llegada_tienda_automatico']);
        $token = TrackingToken::where('base','B06')->first();
        $this->token = $token->token;
    }

    public function iniciar_tracking()
    {
        /*TrackingGuiaRemisionDetalleTemporal::truncate();
        TrackingTemporal::truncate();
        $list_tracking = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?', ['T']);
        foreach($list_tracking as $list){
            TrackingTemporal::create([
                'n_requerimiento' => $list->n_requerimiento,
                'n_guia_remision' => $list->n_guia_remision,
                'semana' => $list->semana,
                'id_origen_desde' => $list->id_origen_desde,
                'desde' => $list->desde,
                'id_origen_hacia' => $list->id_origen_hacia,
                'hacia' => $list->hacia,
                'bultos' => $list->bultos
            ]);
        }
        $list_guia = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?', ['G']);
        foreach($list_guia as $list){
            TrackingGuiaRemisionDetalleTemporal::create([
                'n_requerimiento' => $list->n_requerimiento,
                'n_guia_remision' => $list->n_guia_remision,
                'sku' => $list->sku,
                'color' => $list->color,
                'estilo' => $list->estilo,
                'talla' => $list->talla,
                'descripcion' => $list->descripcion,
                'cantidad' => $list->cantidad
            ]);
        }
        DB::statement('CALL insert_tracking()');

        $list_tracking = Tracking::select('tracking.id','tracking.n_requerimiento','tracking.semana',DB::raw('base.cod_base AS hacia'))
                                    ->join('base','base.id_base','=','tracking.id_origen_hacia')
                                    ->where('tracking.iniciar',0)->get();

        foreach($list_tracking as $tracking){
            Tracking::findOrFail($tracking->id)->update([
                'iniciar' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $tracking->id,
                'id_proceso' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
    
            //ALERTA 1
            $dato = [
                'id_tracking' => $tracking->id,
                'token' => $this->token,
                'titulo' => 'MERCADERÍA POR SALIR',
                'contenido' => 'Hola '.$tracking->hacia.' tu requerimiento n° '.$tracking->n_requerimiento.' está listo',
            ];
            $this->sendNotification($dato);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
    
            //MENSAJE 1
            $list_detalle = TrackingGuiaRemisionDetalle::where('n_requerimiento', $tracking->n_requerimiento)->get();
    
            $mail = new PHPMailer(true);
    
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       =  'mail.lanumero1.com.pe';
                $mail->SMTPAuth   =  true;
                $mail->Username   =  'intranet@lanumero1.com.pe';
                $mail->Password   =  'lanumero1$1';
                $mail->SMTPSecure =  'tls';
                $mail->Port     =  587; 
                $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');
    
                $mail->addAddress('dpalomino@lanumero1.com.pe');
    
                $mail->isHTML(true);
    
                $mail->Subject = "SDM-SEM".$tracking->semana."-".substr(date('Y'),-2)." RQ-".$tracking->n_requerimiento." (".$tracking->hacia.")";
            
                $mail->Body =  '<FONT SIZE=3>
                                    Buen día '.$tracking->hacia.'.<br><br>
                                    Se envia el reporte de la salida de Mercaderia, de la guía de remisión '.$tracking->n_requerimiento.'.<br><br>
                                    <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                        <thead>
                                            <tr align="center" style="background-color:#0093C6;">
                                                <th width="10%"><b>SKU</b></th>
                                                <th width="18%"><b>Color</b></th>
                                                <th width="15%"><b>Estilo</b></th>
                                                <th width="15%"><b>Talla</b></th>
                                                <th width="32%"><b>Descripción</b></th>
                                                <th width="10%"><b>Cantidad</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                    foreach($list_detalle as $list){
                $mail->Body .=  '            <tr align="left">
                                                <td align="center">'.$list->sku.'</td>
                                                <td>'.$list->color.'</td>
                                                <td>'.$list->estilo.'</td>
                                                <td>'.$list->talla.'</td>
                                                <td>'.$list->descripcion.'</td>
                                                <td align="center">'.$list->cantidad.'</td>
                                            </tr>';
                                    }
                $mail->Body .=  '        </tbody>
                                    </table>
                                </FONT SIZE>';
            
                $mail->CharSet = 'UTF-8';
                $mail->send();
    
                TrackingDetalleEstado::create([
                    'id_detalle' => $tracking_dp->id,
                    'id_estado' => 2,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }*/
    }

    public function llegada_tienda_automatico()
    {
        $list_tracking = Tracking::get_list_tracking(['llegada_tienda'=>1]);

        foreach($list_tracking as $tracking){
            //ALERTA 3
            $dato = [
                'id_tracking' => $tracking->id,
                'token' => $this->token,
                'titulo' => 'LLEGADA A TIENDA',
                'contenido' => 'Hola '.$tracking->hacia.' confirma que tu mercadería haya llegado a tienda',
            ];
            $this->sendNotification($dato);

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $tracking->id,
                'id_proceso' => 3,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
    
            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 5,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
        }
    }

    public function getAccessToken()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(base_path('firebase_credentials.json'));
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        return $accessToken;
    }

    public function sendNotification($dato)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/370214896421/messages:send';            
        $accessToken = $this->getAccessToken();
        $headers = array("Authorization: Bearer ".$accessToken,"content-type: application/json;UTF-8");

        $fields["message"] = array(
            'token' => $dato['token'],
            'notification' => [
                'title' => $dato['titulo'],
                'body' => $dato['contenido'],
                //'image' => '',
            ],
        );

        // Open curl connection
        $curl = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($curl);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($curl));
        }
        curl_close($curl);

        $valida = TrackingNotificacion::where('id_tracking',$dato['id_tracking'])
                                        ->where('titulo',$dato['titulo'])->exists();

        if(!$valida){
            TrackingNotificacion::create([
                'id_tracking' => $dato['id_tracking'],
                'titulo' => $dato['titulo'],
                'contenido' => $dato['contenido'],
                'fecha' => now()
            ]);
        }
    }

    public function index()
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }
            $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
            return view('logistica.tracking.index', compact('list_mercaderia_nueva'));
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function list()
    {
        $list_tracking = Tracking::get_list_tracking();
        return view('logistica.tracking.lista', compact('list_tracking'));
    }

    public function create()
    {
        $list_base = Base::get_list_base_tracking();
        return view('logistica.tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
        $tracking = Tracking::create([
            'n_requerimiento' => $request->n_requerimiento,
            'n_guia_remision' => $request->n_requerimiento,
            'semana' => $request->semana,
            'id_origen_desde' => $request->id_origen_desde,
            'id_origen_hacia' => $request->id_origen_hacia,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $tracking->id,
            'id_proceso' => 1,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        TrackingDetalleEstado::create([
            'id_detalle' => $tracking_dp->id,
            'id_estado' => 1,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //ALERTA 1
        $get_id = Tracking::get_list_tracking(['id'=>$tracking->id]);

        $dato = [
            'id_tracking' => $get_id->id,
            'token' => $this->token,
            'titulo' => 'MERCADERÍA POR SALIR',
            'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
        ];
        $this->sendNotification($dato);

        //MENSAJE 1
        $list_detalle = TrackingGuiaRemisionDetalle::where('n_guia_remision', $request->n_requerimiento)->get();

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "SDM-SEM".$get_id->semana."-".substr(date('Y'),-2)." RQ-".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Buen día '.$get_id->hacia.'.<br><br>
                                Se envia el reporte de la salida de Mercaderia, de la guía de remisión '.$get_id->n_requerimiento.'.<br><br>
                                <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                    <thead>
                                        <tr align="center" style="background-color:#0093C6;">
                                            <th width="10%"><b>SKU</b></th>
                                            <th width="18%"><b>Color</b></th>
                                            <th width="15%"><b>Estilo</b></th>
                                            <th width="15%"><b>Talla</b></th>
                                            <th width="32%"><b>Descripción</b></th>
                                            <th width="10%"><b>Cantidad</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                foreach($list_detalle as $list){
            $mail->Body .=  '            <tr align="left">
                                            <td align="center">'.$list->sku.'</td>
                                            <td>'.$list->color.'</td>
                                            <td>'.$list->estilo.'</td>
                                            <td>'.$list->talla.'</td>
                                            <td>'.$list->descripcion.'</td>
                                            <td align="center">'.$list->cantidad.'</td>
                                        </tr>';
                                }
            $mail->Body .=  '        </tbody>
                                </table>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 2,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_salida_mercaderia(Request $request,$id)
    {
        //ALERTA 2
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'SALIDA DE MERCADERÍA',
            'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está en camino',
        ];
        $this->sendNotification($dato);

        TrackingDetalleEstado::create([
            'id_detalle' => $get_id->id_detalle,
            'id_estado' => 3,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function detalle_transporte($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.detalle_transporte', compact('get_id'));
    }

    public function insert_mercaderia_transito(Request $request,$id)
    {
        $request->validate([
            'peso' => 'required',
            'transporte' => 'gt:0'
        ],[
            'peso.required' => 'Debe ingresar peso.',
            'transporte.gt' => 'Debe seleccionar transporte.',
        ]);

        Tracking::findOrFail($id)->update([
            'guia_transporte' => $request->guia_transporte,
            'peso' => $request->peso,
            'paquetes' => $request->paquetes,
            'sobres' => $request->sobres,
            'fardos' => $request->fardos,
            'caja' => $request->caja,
            'transporte' => $request->transporte,
            'nombre_transporte' => $request->nombre_transporte,
            'importe_transporte' => $request->importe_transporte,
            'factura_transporte' => $request->factura_transporte,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($_FILES["archivo_transporte"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;
                    TrackingArchivo::create([
                        'id_tracking' => $id,
                        'tipo' => 1,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $id,
            'id_proceso' => 2,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        TrackingDetalleEstado::create([
            'id_detalle' => $tracking_dp->id,
            'id_estado' => 4,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function insert_llegada_tienda(Request $request,$id)
    {
        //ALERTA 3
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'LLEGADA A TIENDA',
            'contenido' => 'Hola '.$get_id->hacia.' confirma que tu mercadería haya llegado a tienda',
        ];
        $this->sendNotification($dato);

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $id,
            'id_proceso' => 3,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        TrackingDetalleEstado::create([
            'id_detalle' => $tracking_dp->id,
            'id_estado' => 5,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function insert_confirmacion_llegada(Request $request,$id)
    {
        //ALERTA 4
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'CONFIRMACIÓN DE LLEGADA',
            'contenido' => 'Hola '.$get_id->desde.', se ha confirmado que la mercadería llegó a tienda',
        ];
        $this->sendNotification($dato);

        TrackingDetalleEstado::create([
            'id_detalle' => $get_id->id_detalle,
            'id_estado' => 6,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //MENSAJE 2
        $estado_5 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$get_id->id_detalle,'id_estado'=>5]);
        $estado_6 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$get_id->id_detalle,'id_estado'=>6]);
        $list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();

        $fecha1 = new \DateTime($estado_5->fecha);
        $fecha2 = new \DateTime($estado_6->fecha);
        $intervalo = $fecha1->diff($fecha2);
        $diferencia = $intervalo->days;

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "IDM-SEM".$get_id->semana."-".substr(date('Y'),-2)." RQ-".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->desde.', la mercadería ha llegado a tienda.<br><br>
                                <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">     
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Despacho</td>
                                        <td style="text-align:right;">SEM-'.$get_id->semana.'-'.substr(date('Y'),-2).'</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="font-weight:bold;">Guía Remisión</td>
                                        <td style="font-weight:bold;">Nuestra</td>
                                        <td style="text-align:right;">'.$get_id->n_guia_remision.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Transporte.</td>
                                        <td style="text-align:right;">'.$get_id->guia_transporte.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td style="text-align:right;">-</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">N° Factura</td>
                                        <td style="text-align:right;">'.$get_id->factura_transporte.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Paquetes</td>
                                        <td style="text-align:right;">'.$get_id->paquetes.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Sobres</td>
                                        <td style="text-align:right;">'.$get_id->sobres.'</td>
                                    </tr>          
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Fardos</td>
                                        <td style="text-align:right;">'.$get_id->fardos.'</td>
                                    </tr>           
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Bultos</td>
                                        <td style="text-align:right;">'.$get_id->bultos.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Caja</td>
                                        <td style="text-align:right;">'.$get_id->caja.'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Importe Pagado</td>
                                        <td style="text-align:right;">S/'.$get_id->importe_formateado.'</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3" style="font-weight:bold;">Fecha</td>
                                        <td style="font-weight:bold;">Partida</td>
                                        <td style="text-align:right;">'.$estado_5->fecha_formateada.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Llegada</td>
                                        <td style="text-align:right;">'.$estado_6->fecha_formateada.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Diferencia.</td>
                                        <td style="text-align:center;">'.$diferencia.' Día(s)</td>
                                    </tr>
                                </table><br>
                                <a href="'.route('tracking').'" 
                                title="Verificar Fardo"
                                target="_blank" 
                                style="background-color: red;
                                color: white;
                                border: 1px solid transparent;
                                padding: 7px 12px;
                                font-size: 13px;
                                text-decoration: none !important;
                                border-radius: 10px;">
                                    Verificar Fardo
                                </a><br>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            foreach($list_archivo as $list){
                $archivo_contenido = file_get_contents($list->archivo);
                $nombre_archivo = basename($list->archivo);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $get_id->id_detalle,
                'id_estado' => 7,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_cierre_inspeccion_fardos(Request $request,$id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        if($get_id->transporte==2 || ($get_id->transporte==1 && $get_id->importe_transporte>0)){
            //ALERTA 8
            $dato = [
                'id_tracking' => $id,
                'token' => $this->token,
                'titulo' => 'INSPECCIÓN DE MERCADERÍA',
                'contenido' => 'Hola '.$get_id->desde.', se ha recepcionado la mercadería correcta',
            ];
            $this->sendNotification($dato);

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $id,
                'id_proceso' => 6,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 12,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            if($request->validacion==1){
                $id_detalle = $get_id->id_detalle;
                $contenido_mensaje = 'Hola '.$get_id->desde.', se ha dado el cierre a las irregularidades de los fardos';
            }else{
                $tracking_dp = TrackingDetalleProceso::create([
                    'id_tracking' => $id,
                    'id_proceso' => 4,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                $id_detalle = $tracking_dp->id;
                $contenido_mensaje = 'Hola '.$get_id->desde.', se ha dado el cierre a la verificación de fardos';
            }

            //ALERTA 5 o 6
            $dato = [
                'id_tracking' => $id,
                'token' => $this->token,
                'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                'contenido' => $contenido_mensaje,
            ];
            $this->sendNotification($dato);

            TrackingDetalleEstado::create([
                'id_detalle' => $id_detalle,
                'id_estado' => 9,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function verificacion_fardos($id)
    {
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>2]);
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "TRACKING/".$list->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.verificacion_fardos', compact('get_id'));
    }

    public function list_archivo(Request $request)
    {
        if($request->tipo=="3"){
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id_producto'=>$request->id_producto]);
        }else{
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>$request->tipo]);
        }
        return view('logistica.tracking.lista_archivo', compact('list_archivo'));
    }

    public function previsualizacion_captura(Request $request)
    {
        $valida = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>$request->tipo]);

        if(count($valida)==3){
            echo "error";
        }else{
            if($_FILES["photo"]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $path = $_FILES["photo"]["name"];
                    $source_file = $_FILES['photo']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "temporal_".session('usuario')->id_usuario."_".date('YmdHis');
                    $nombre = $nombre_soli.".".strtolower($ext);

                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                    ftp_pasv($con_id,true); 
                    $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        if($request->tipo=="3"){
                            TrackingArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'tipo' => $request->tipo,
                                'id_producto' => $request->id_producto,
                                'archivo' => $archivo
                            ]);
                        }else{
                            TrackingArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'tipo' => $request->tipo,
                                'archivo' => $archivo
                            ]);
                        }
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }
        }
    }

    public function delete_archivo_temporal($id)
    {
        $get_id = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id'=>$id]);
        if($get_id->archivo!=""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "TRACKING/".$get_id->nom_archivo;
                if (ftp_delete($con_id, $file_to_delete)) {
                    TrackingArchivoTemporal::destroy($id);
                }
            }
        }
    }

    public function insert_reporte_inspeccion_fardo(Request $request)
    {
        Tracking::findOrFail($request->id)->update([
            'observacion_inspf' => $request->observacion_inspf,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($_FILES["archivo_inspf"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $path = $_FILES["archivo_inspf"]["name"];
                $source_file = $_FILES['archivo_inspf']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Evidencia_".$request->id."_".date('YmdHis')."_0";
                $nombre = $nombre_soli.".".strtolower($ext);

                $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    TrackingArchivo::create([
                        'id_tracking' => $request->id,
                        'tipo' => 2,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>2]);

        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $i = 1;
                foreach($list_archivo as $list){
                    $nombre_actual = "TRACKING/".$list->nom_archivo;
                    $nuevo_nombre = "TRACKING/Evidencia_".$request->id."_".date('YmdHis')."_".$i.".jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;

                    TrackingArchivo::create([
                        'id_tracking' => $request->id,
                        'tipo' => 2,
                        'archivo' => $archivo
                    ]);

                    $i++;
                }
            }
            TrackingArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->where('tipo', 2)->delete();
        }

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $request->id,
            'id_proceso' => 4,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //MENSAJE 3
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);
        $list_archivo = TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 2)->get();

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "REPORTE INSPECCIÓN FARDOS: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->desde.', los fardos han llegado con las siguientes 
                                observaciones:<br><br>
                                '.$get_id->observacion_inspf.'
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            foreach($list_archivo as $list){
                $archivo_contenido = file_get_contents($list->archivo);
                $nombre_archivo = basename($list->archivo);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 8,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function pago_transporte($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.pago_transporte', compact('get_id'));
    }

    public function insert_confirmacion_pago_transporte(Request $request, $id)
    {
        $request->validate([
            'nombre_transporte' => 'required',
            'importe_transporte' => 'gt:0',
            'factura_transporte' => 'required',
            'archivo_transporte' => 'required_without:archivo_transporte_actual',
        ],[
            'nombre_transporte.required' => 'Debe ingresar nombre de empresa.',
            'importe_transporte.gt' => 'Debe ingresar importe a pagar.',
            'factura_transporte.required' => 'Debe ingresar n° de factura.',
            'archivo_transporte.required_without' => 'Debe ingresar PDF de factura.',
        ]);

        Tracking::findOrFail($id)->update([
            'nombre_transporte' => $request->nombre_transporte,
            'importe_transporte' => $request->importe_transporte,
            'factura_transporte' => $request->factura_transporte,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($_FILES["archivo_transporte"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                //ELIMINAR ARCHIVO SI ES QUE EXISTE
                if($request->archivo_transporte_actual!=""){
                    $get_id = TrackingArchivo::get_list_tracking_archivo(['id_tracking'=>$id,'tipo'=>1]);
                    $file_to_delete = "TRACKING/".$get_id->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->delete();
                    }
                }
                //
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_".$id."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;
                    TrackingArchivo::create([
                        'id_tracking' => $id,
                        'tipo' => 1,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        //ALERTA 7
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'CONFIRMACIÓN DE PAGO A TRANSPORTE',
            'contenido' => 'Hola '.$get_id->desde.', se ha pagado a la agencia',
        ];
        $this->sendNotification($dato);

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $id,
            'id_proceso' => 5,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //PASAR PARA CONFIRMACIÓN DE PAGO DE TRANSPORTE
        TrackingDetalleEstado::create([
            'id_detalle' => $tracking_dp->id,
            'id_estado' => 10,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //MENSAJE 4
        $list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "MERCADERÍA PAGADA: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->desde.', se ha pagado a la agencia
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            foreach($list_archivo as $list){
                $archivo_contenido = file_get_contents($list->archivo);
                $nombre_archivo = basename($list->archivo);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }
            $mail->send();

            //PASAR PARA MERCADERÍA PAGADA
            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 11,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            //PASAR PARA INSPECCIÓN DE MERCADERÍA
            //ALERTA 8
            $dato = [
                'id_tracking' => $id,
                'token' => $this->token,
                'titulo' => 'INSPECCIÓN DE MERCADERÍA',
                'contenido' => 'Hola '.$get_id->desde.', se ha recepcionado la mercadería correcta',
            ];
            $this->sendNotification($dato);

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $id,
                'id_proceso' => 6,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 12,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_conteo_mercaderia(Request $request,$id)
    {
        //ALERTA 9
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'CONTEO DE MERCADERÍA',
            'contenido' => 'Hola '.$get_id->desde.', se está realizando el conteo de la mercadería',
        ];
        $this->sendNotification($dato);

        TrackingDetalleEstado::create([
            'id_detalle' => $get_id->id_detalle,
            'id_estado' => 13,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function insert_mercaderia_entregada($id)
    {
        //ALERTA 9.3
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'MERCADERÍA ENTREGADA',
            'contenido' => 'Hola '.$get_id->desde.', la mercadería fue distribuida',
        ];
        $this->sendNotification($dato);

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $id,
            'id_proceso' => 9,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        TrackingDetalleEstado::create([
            'id_detalle' => $tracking_dp->id,
            'id_estado' => 21,
            'fecha' => now(),
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function reporte_mercaderia($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.reporte_mercaderia', compact('get_id'));
    }

    public function insert_reporte_mercaderia(Request $request,$id)
    {
        $rules = [
            'diferencia' => 'required_without:devolucion|boolean',
            'devolucion' => 'required_without:diferencia|boolean',
        ];
        $messages = [
            'diferencia.required_without' => 'Al menos una opción debe estar seleccionada.',
            'devolucion.required_without' => 'Al menos una opción debe estar seleccionada.',
        ];
        $request->validate($rules, $messages);

        Tracking::findOrFail($id)->update([
            'diferencia' => $request->diferencia,
            'devolucion' => $request->devolucion,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if(($request->diferencia=="1" && $request->devolucion=="1") || $request->diferencia=="1"){
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $id,
                'id_proceso' => 7,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
    
            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 14,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $id,
                'id_proceso' => 8,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
    
            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 17,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function cuadre_diferencia($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);
        return view('logistica.tracking.cuadre_diferencia', compact('get_id','list_diferencia'));
    }

    public function insert_reporte_diferencia(Request $request,$id)
    {
        //ALERTA 9.1
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'REPORTE DE DIFERENCIAS',
            'contenido' => 'Hola '.$get_id->hacia.', regularizar los sobrantes-faltantes indicados',
        ];
        $this->sendNotification($dato);

        //MENSAJE 5
        $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "DIFERENCIAS EN LA RECEPCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->hacia.', regularizar los sobrantes y/o faltantes indicados.<br><br>
                                <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                    <thead>
                                        <tr align="center" style="background-color:#0093C6;">
                                            <th width="20%"><b>Estilo</b></th>
                                            <th width="20%"><b>Col_Tal</b></th>
                                            <th width="10%"><b>Bulto</b></th>
                                            <th width="10%"><b>Enviado</b></th>
                                            <th width="10%"><b>Recibido</b></th>
                                            <th width="10%"><b>Dif</b></th>
                                            <th width="20%"><b>Orden de Regularización</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                foreach($list_diferencia as $list){
            $mail->Body .=  '            <tr align="left">
                                            <td>'.$list->Estilo.'</td>
                                            <td>'.$list->Col_Tal.'</td>
                                            <td>'.$list->Bulto.'</td>
                                            <td>'.$list->Enviado.'</td>
                                            <td>'.$list->Recibido.'</td>
                                            <td>'.($list->Recibido-$list->Enviado).'</td>
                                            <td>'.$list->Observacion.'</td>
                                        </tr>';
                                }
            $mail->Body .=  '        </tbody>
                                </table><br>
                                <a href="'.route('tracking.detalle_operacion_diferencia', $id).'" 
                                title="Detalle Operación de Diferencias"
                                target="_blank" 
                                style="background-color: red;
                                color: white;
                                border: 1px solid transparent;
                                padding: 7px 12px;
                                font-size: 13px;
                                text-decoration: none !important;
                                border-radius: 10px;">
                                    Detalle de Operación de Diferencias
                                </a><br>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $get_id->id_detalle,
                'id_estado' => 15,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function detalle_operacion_diferencia($id)
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }
            $get_id = Tracking::get_list_tracking(['id'=>$id]);
            if($get_id->id_estado==15){
                return view('logistica.tracking.detalle_operacion_diferencia', compact('get_id'));
            }else{
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
                return view('logistica.tracking.index', compact('list_mercaderia_nueva'));
            }
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function insert_diferencia_regularizada(Request $request,$id)
    {
        $rules = [
            'guia_diferencia' => 'required|max:20',
        ];
        $messages = [
            'guia_diferencia.required' => 'Debe ingresar Nro. Gr.',
            'guia_diferencia.max' => 'Nro. Gr debe tener como máximo 20 carácteres.',
        ];
        $request->validate($rules, $messages);

        Tracking::findOrFail($id)->update([
            'guia_diferencia' => $request->guia_diferencia,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //ALERTA 9.1.1
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $dato = [
            'id_tracking' => $id,
            'token' => $this->token,
            'titulo' => 'DIFERENCIAS REGULARIZADAS',
            'contenido' => 'Hola '.$get_id->desde.', '.$get_id->hacia.' se regularizó el Nro. Req. '.$get_id->guia_diferencia,
        ];
        $this->sendNotification($dato);

        //MENSAJE 6
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "REGULARIZADO - DIFERENCIAS EN LA RECEPCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->desde.', '.$get_id->hacia.' acaba de regularizar con la 
                                GR '.$request->guia_diferencia.'. 
                                El archivo ya se encuentra en su carpeta.
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $get_id->id_detalle,
                'id_estado' => 16,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if($get_id->devolucion=="1"){
                $tracking_dp = TrackingDetalleProceso::create([
                    'id_tracking' => $id,
                    'id_proceso' => 8,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
        
                TrackingDetalleEstado::create([
                    'id_detalle' => $tracking_dp->id,
                    'id_estado' => 17,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }else{
                //ALERTA 9.3
                $this->insert_mercaderia_entregada($id);
            }
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function solicitud_devolucion($id)
    {
        TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>3]);
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "TRACKING/".$list->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        $list_guia_remision = TrackingGuiaRemisionDetalle::select('id','sku','descripcion','cantidad')->where('n_guia_remision',$get_id->n_guia_remision)->get();
        return view('logistica.tracking.solicitud_devolucion', compact('get_id','list_guia_remision'));
    }

    public function modal_solicitud_devolucion($id)
    {
        $get_producto = TrackingGuiaRemisionDetalle::findOrFail($id);
        $get_id = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)
                                            ->where('id_producto',$id)->first();
        return view('logistica.tracking.modal_solicitud_devolucion', compact('get_producto','get_id'));
    }

    public function insert_devolucion_temporal(Request $request,$id)
    {
        $request->validate([
            'tipo_falla' => 'required',
            'cantidad' => 'gt:0',
        ],[
            'tipo_falla.required' => 'Debe ingresar tipo de falla.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
        ]);

        $get_producto = TrackingGuiaRemisionDetalle::findOrFail($id);

        if($get_producto->cantidad>=$request->cantidad){
            TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)
                                        ->where('id_producto',$id)->delete();
            TrackingDevolucionTemporal::create([
                'id_usuario' => session('usuario')->id_usuario,
                'id_producto' => $id,
                'tipo_falla' => $request->tipo_falla,
                'cantidad' => $request->cantidad
            ]);
        }else{
            echo "error";
        }
    }

    public function insert_reporte_devolucion(Request $request, $id)
    {
        $request->validate([
            'devolucion' => 'required',
        ],[
            'devolucion.required' => 'Debe seleccionar al menos un ítem.',
        ]);

        $valida = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)->exists();

        if($valida){
            //ALERTA 9.2
            $get_id = Tracking::get_list_tracking(['id'=>$id]);

            $dato = [
                'id_tracking' => $id,
                'token' => $this->token,
                'titulo' => 'SOLICITUD DE DEVOLUCIÓN',
                'contenido' => 'Hola Andrea, se ha encontrado mercadería para devolución, revisar correo',
            ];
            $this->sendNotification($dato);

            $list_devolucion = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)->get();

            foreach($list_devolucion as $list){
                TrackingDevolucion::create([
                    'id_tracking' => $id,
                    'id_producto' => $list->id_producto,
                    'tipo_falla' => $list->tipo_falla,
                    'cantidad' => $list->cantidad,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
            TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();

            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>3]);

            if(count($list_archivo)>0){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $i = 1;
                    foreach($list_archivo as $list){
                        $nombre_actual = "TRACKING/".$list->nom_archivo;
                        $nuevo_nombre = "TRACKING/Evidencia_".$id."_".date('YmdHis')."_".$i.".jpg";
                        ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                        $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;
    
                        TrackingArchivo::create([
                            'id_tracking' => $id,
                            'tipo' => 3,
                            'id_producto' => $list->id_producto,
                            'archivo' => $archivo
                        ]);
    
                        $i++;
                    }
                }
                TrackingArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->where('tipo', 3)->delete();
            }

            //MENSAJE 7
            $mail = new PHPMailer(true);
    
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       =  'mail.lanumero1.com.pe';
                $mail->SMTPAuth   =  true;
                $mail->Username   =  'intranet@lanumero1.com.pe';
                $mail->Password   =  'lanumero1$1';
                $mail->SMTPSecure =  'tls';
                $mail->Port     =  587; 
                $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');
    
                $mail->addAddress('dpalomino@lanumero1.com.pe');
    
                $mail->isHTML(true);
    
                $mail->Subject = "SOLICITUD DE DEVOLUCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
            
                $mail->Body =  '<FONT SIZE=3>
                                    Hola Andrea, tienes una solicitud de devolución por evaluar.
                                    <br><br>
                                    <a href="'.route('tracking.evaluacion_devolucion', $id).'" 
                                    title="Autorización de Devolución"
                                    target="_blank" 
                                    style="background-color: red;
                                    color: white;
                                    border: 1px solid transparent;
                                    padding: 7px 12px;
                                    font-size: 13px;
                                    text-decoration: none !important;
                                    border-radius: 10px;">
                                        Autorización de Devolución
                                    </a><br>
                                </FONT SIZE>';
            
                $mail->CharSet = 'UTF-8';
                $mail->send();
    
                TrackingDetalleEstado::create([
                    'id_detalle' => $get_id->id_detalle,
                    'id_estado' => 18,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }else{
            echo "error";
        }
    }

    public function evaluacion_devolucion($id)
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }

            $get_id = Tracking::get_list_tracking(['id'=>$id]);
            if($get_id->id_estado==18){
                TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
                $list_devolucion = TrackingDevolucion::select('tracking_devolucion.id','tracking_guia_remision_detalle.sku',
                                                        'tracking_guia_remision_detalle.descripcion',
                                                        'tracking_devolucion.cantidad')
                                                        ->join('tracking_guia_remision_detalle','tracking_guia_remision_detalle.id','=','tracking_devolucion.id_producto')
                                                        ->where('tracking_devolucion.id_tracking',$id)
                                                        ->where('tracking_devolucion.estado',1)->get();
                return view('logistica.tracking.evaluacion_devolucion', compact('get_id','list_devolucion'));
            }else{
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
                return view('logistica.tracking.index', compact('list_mercaderia_nueva'));
            }
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function modal_evaluacion_devolucion($id)
    {
        $get_devolucion = TrackingDevolucion::findOrFail($id);
        $list_archivo = TrackingArchivo::select('archivo')->where('id_producto',$get_devolucion->id_producto)->where('tipo',3)->get();
        $get_id = TrackingEvaluacionTemporal::where('id_usuario',session('usuario')->id_usuario)
                                            ->where('id_devolucion',$id)->first();
        return view('logistica.tracking.modal_evaluacion_devolucion', compact('get_devolucion','list_archivo','get_id'));
    }

    public function insert_evaluacion_temporal(Request $request,$id)
    {
        $request->validate([
            'aprobacion' => 'required',
            'sustento_respuesta' => 'required',
            'forma_proceder' => 'required',
        ],[
            'aprobacion.required' => 'Debe seleccionar aprobación.',
            'sustento_respuesta.required' => 'Debe ingresar sustento de respuesta.',
            'forma_proceder.required' => 'Debe ingresar forma de proceder.',
        ]);

        TrackingEvaluacionTemporal::create([
            'id_usuario' => session('usuario')->id_usuario,
            'id_devolucion' => $id,
            'aprobacion' => $request->aprobacion,
            'sustento_respuesta' => $request->sustento_respuesta,
            'forma_proceder' => $request->forma_proceder
        ]);
    }

    public function insert_autorizacion_devolucion(Request $request,$id)
    {
        $valida_t = TrackingEvaluacionTemporal::where('id_usuario',session('usuario')->id_usuario)->count();
        $valida = TrackingDevolucion::where('id_tracking',$id)->where('estado',1)->count();

        if($valida_t==$valida){
            $list_evaluacion = TrackingEvaluacionTemporal::where('id_usuario',session('usuario')->id_usuario)->get();

            foreach($list_evaluacion as $list){
                TrackingDevolucion::findOrFail($list->id_devolucion)->update([
                    'aprobacion' => $list->aprobacion,
                    'sustento_respuesta' => $list->sustento_respuesta,
                    'forma_proceder' => $list->forma_proceder,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
            TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();

            $get_id = Tracking::get_list_tracking(['id'=>$id]);
            $list_evaluacion = TrackingDevolucion::select('tracking_guia_remision_detalle.sku','tracking_guia_remision_detalle.descripcion',
                                                    'tracking_devolucion.cantidad','tracking_devolucion.sustento_respuesta',
                                                    DB::raw('CASE WHEN tracking_devolucion.aprobacion=1 THEN "Aprobada" 
                                                    WHEN tracking_devolucion.aprobacion=2 THEN "Denegada" ELSE "" END AS devolucion'),
                                                    'tracking_devolucion.forma_proceder')
                                                    ->join('tracking_guia_remision_detalle','tracking_guia_remision_detalle.id','=','tracking_devolucion.id_producto')
                                                    ->where('tracking_devolucion.id_tracking',$id)
                                                    ->where('tracking_devolucion.estado',1)->get();

            //MENSAJE 8
            $mail = new PHPMailer(true);
    
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       =  'mail.lanumero1.com.pe';
                $mail->SMTPAuth   =  true;
                $mail->Username   =  'intranet@lanumero1.com.pe';
                $mail->Password   =  'lanumero1$1';
                $mail->SMTPSecure =  'tls';
                $mail->Port     =  587; 
                $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');
    
                $mail->addAddress('dpalomino@lanumero1.com.pe');
    
                $mail->isHTML(true);
    
                $mail->Subject = "RESPUESTA A SOLICITUD DE DEVOLUCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
            
                $mail->Body =  '<FONT SIZE=3>
                                    Hola '.$get_id->hacia.' - '.$get_id->desde.', a continuación respuesta de la solicitud de 
                                    devolución:<br><br>
                                    <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                        <thead>
                                            <tr align="center" style="background-color:#0093C6;">
                                                <th width="10%"><b>SKU</b></th>
                                                <th width="22%"><b>Descripción</b></th>
                                                <th width="6%"><b>Cant.</b></th>
                                                <th width="10%"><b>Devolución</b></th>
                                                <th width="26%"><b>Motivo</b></th>
                                                <th width="26%"><b>Forma de proceder</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            foreach($list_evaluacion as $list){
                $mail->Body .=  '               <tr align="left">
                                                    <td align="center">'.$list->sku.'</td>
                                                    <td>'.$list->descripcion.'</td>
                                                    <td align="center">'.$list->cantidad.'</td>
                                                    <td align="center">'.$list->devolucion.'</td>
                                                    <td>'.$list->sustento_respuesta.'</td>
                                                    <td>'.$list->forma_proceder.'</td>
                                                </tr>';
                                }
                $mail->Body .=  '       </tbody>
                                    </table>
                                </FONT SIZE>';
            
                $mail->CharSet = 'UTF-8';
                $mail->send(); 
    
                TrackingDetalleEstado::create([
                    'id_detalle' => $get_id->id_detalle,
                    'id_estado' => 19,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
    
            //ALERTA 9.2.1
            $dato = [
                'id_tracking' => $id,
                'token' => $this->token,
                'titulo' => 'CIERRE DE INCONFORMIDADES DE DEVOLUCIÓN',
                'contenido' => 'Hola '.$get_id->hacia.', revisar respuesta de la solicitud de la devolución para el Nro. Req',
            ];
            $this->sendNotification($dato);

            TrackingDetalleEstado::create([
                'id_detalle' => $get_id->id_detalle,
                'id_estado' => 20,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            //ALERTA 9.3
            $this->insert_mercaderia_entregada($id);
        }else{
            echo "error";
        }
    }
    //MERCADERIA NUEVA
    public function mercaderia_nueva()
    {
        $list_base = Base::get_list_bases_tienda();
        $list_usuario = DB::connection('sqlsrv')->table('vw_usuarios')
                        ->select('par_codusuario','par_desusuario')->orderBy('par_desusuario','ASC')->get();
        $list_tipo_prenda = DB::connection('sqlsrv')->table('tge_sub_familias')
                            ->select('sfa_codigo','sfa_descrip')->orderBy('sfa_descrip','ASC')->get();
        return view('logistica.tracking.mercaderia_nueva.index', compact('list_base','list_usuario','list_tipo_prenda'));
    }

    public function list_mercaderia_nueva(Request $request)
    {
        $list_mercaderia_nueva = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva ?,?,?,?', [NULL,date('Y'),date('W'),$request->cod_base]);
        return view('logistica.tracking.mercaderia_nueva.lista', compact('list_mercaderia_nueva'));
    }

    public function modal_mercaderia_nueva($sku)
    {
        return view('logistica.tracking.mercaderia_nueva.modal_editar', compact('sku'));
    }

    public function insert_mercaderia_surtida(Request $request,$sku)
    {
        $request->validate([
            'cantidad' => 'gt:0',
        ],[
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
        ]);

        $resultados = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva ?,?,?,?', [$sku,date('Y'),date('W'),$request->cod_base]);
        $get_id = $resultados[0];

        if($request->cantidad>$get_id->cantidad){
            echo "error";
        }else{
            MercaderiaSurtida::create([
                'base' => $request->cod_base,
                'anio' => date('Y'),
                'semana' => date('W'),
                'sku' => $sku,
                'estilo' => $get_id->estilo,
                'tipo_usuario' => $get_id->tipo_usuario,
                'tipo_prenda' => $get_id->tipo_prenda,
                'color' => $get_id->color,
                'talla' => $get_id->talla,
                'descripcion' => $get_id->decripcion,
                'cantidad' => $request->cantidad,
                'fecha' => now(),
                'usuario' => session('usuario')->id_usuario
            ]);
        }
    }
}