<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Tracking;
use App\Models\Base;
use App\Models\MercaderiaSurtida;
use App\Models\MercaderiaSurtidaPadre;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TrackingArchivo;
use App\Models\TrackingArchivoTemporal;
use App\Models\TrackingComentario;
use App\Models\TrackingDetalleEstado;
use App\Models\TrackingDetalleProceso;
use App\Models\TrackingDevolucion;
use App\Models\TrackingDevolucionTemporal;
use App\Models\TrackingDiferencia;
use App\Models\TrackingEvaluacionTemporal;
use App\Models\TrackingGuiaRemisionDetalle;
use App\Models\TrackingNotificacion;
use App\Models\TrackingTemporal;
use App\Models\TrackingToken;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\DB;
use App\Models\TrackingEstado;
use Mpdf\Mpdf;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except([
            'index',
            'detalle_operacion_diferencia',
            'evaluacion_devolucion',
            'iniciar_tracking',
            'llegada_tienda',
            'list_notificacion',
            'list_mercaderia_nueva_app',
            'insert_mercaderia_nueva_app',
            'list_surtido_mercaderia_nueva',
            'insert_requerimiento_reposicion_app',
            'insert_requerimiento_reposicion_estilo_app',
            'list_requerimiento_reposicion_app',
            'update_requerimiento_reposicion_app',
            'delete_mercaderia_surtida_app',
            'list_mercaderia_nueva_vendedor_app',
            'list_requerimiento_reposicion_vendedor_app'
        ]);
    }

    public function iniciar_tracking()
    {
        //NO OLVIDAR COMENTAR EL CORREO
        /*TrackingTemporal::truncate();
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
        DB::statement('CALL insert_tracking()');

        $list_tracking = Tracking::select('tracking.id','tracking.n_requerimiento','tracking.n_guia_remision',
                                    'tracking.semana',DB::raw('base.cod_base AS hacia'))
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
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $tracking->id,
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA POR SALIR',
                    'contenido' => 'Hola '.$tracking->hacia.' tu requerimiento n° '.$tracking->n_requerimiento.' está listo',
                ];
                $this->sendNotification($dato);
            }

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
    
            //EMAIL 1
            //$list_detalle = TrackingGuiaRemisionDetalle::where('n_requerimiento', $tracking->n_requerimiento)->get();
            $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R',$tracking->n_requerimiento]);

            $mpdf = new Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial'
            ]);
            $html = view('logistica.tracking.pdf', compact('get_id','list_detalle'))->render();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);
    
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
    
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$tracking->hacia]);
                foreach($list_td as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }
    
                $mail->isHTML(true);
    
                $mail->Subject = "SDM-SEM".$tracking->semana."-".substr(date('Y'),-2)." RQ-".$tracking->n_requerimiento." (".$tracking->hacia.")";
            
                $mail->Body =  '<FONT SIZE=3>
                                    Buen día '.$tracking->hacia.'.<br><br>
                                    Se envia el reporte de la salida de Mercaderia, de la guía de remisión '.$tracking->n_guia_remision.'.<br><br>
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
                $mail->addStringAttachment($pdfContent, 'Guia_Remision.pdf');
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

    public function llegada_tienda()
    {
        $list_tracking = Tracking::get_list_tracking(['llegada_tienda'=>1]);

        foreach($list_tracking as $tracking){
            //ALERTA 3
            $list_token = TrackingToken::whereIn('base', ['CD', $tracking->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $tracking->id,
                    'token' => $token->token,
                    'titulo' => 'LLEGADA A TIENDA',
                    'contenido' => 'Hola '.$tracking->hacia.' confirma que tu mercadería haya llegado a tienda',
                ];
                $this->sendNotification($dato);
            }

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

    public function list_notificacion(Request $request)
    {
        if($request->id_tracking){
            try {
                $query = TrackingNotificacion::select('titulo','contenido','fecha')
                                                ->where('id_tracking',$request->id_tracking)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }elseif($request->cod_base){
            try {
                if($request->cod_base=="OFI"){
                    $query = TrackingNotificacion::select('tracking_notificacion.id_tracking',
                            'tracking.n_requerimiento')
                            ->join('tracking','tracking.id','=','tracking_notificacion.id_tracking')
                            ->join('base','base.id_base','=','tracking.id_origen_hacia')
                            ->groupBy('tracking_notificacion.id_tracking')->get();
                }else{
                    $query = TrackingNotificacion::select('tracking_notificacion.id_tracking',
                            'tracking.n_requerimiento')
                            ->join('tracking','tracking.id','=','tracking_notificacion.id_tracking')
                            ->join('base','base.id_base','=','tracking.id_origen_hacia')
                            ->where('base.cod_base',$request->cod_base)
                            ->groupBy('tracking_notificacion.id_tracking')->get();
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            return response()->json($query, 200);
        }else{
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();   
        $list_subgerencia = SubGerencia::list_subgerencia(7);         
        return view('logistica.tracking.index',compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_tra()
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }
            $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
            return view('logistica.tracking.tracking.index', compact('list_mercaderia_nueva'));
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function list(){
        $estado = TrackingEstado::get_list_estado_proceso();
        $list_tracking = Tracking::get_list_tracking();
        return view('logistica.tracking.tracking.lista', compact('list_tracking', 'estado'));
    }

    //FORMA MANUAL
    public function create()
    {
        $list_base = Base::get_list_base_tracking();
        return view('logistica.tracking.tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $valida = Tracking::where('n_requerimiento',$request->n_requerimiento)
                ->where('estado', 1)->exists();
        if($valida){
            echo "error";
        }else{
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

            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $get_id->id,
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA POR SALIR',
                    'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
                ];
                $this->sendNotification($dato);
            }

            //MENSAJE 1
            //$list_detalle = TrackingGuiaRemisionDetalle::where('n_guia_remision', $request->n_requerimiento)->get();
            $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R',$get_id->n_requerimiento]);

            $mpdf = new Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial'
            ]);
            $html = view('logistica.tracking.tracking.pdf', compact('get_id','list_detalle'))->render();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);

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

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
                foreach($list_td as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/

                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "SDM-SEM".$get_id->semana."-".substr(date('Y'),-2)." RQ-".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
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
                $mail->addStringAttachment($pdfContent, 'Guia_Remision.pdf');
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
    }
    //END FORMA MANUAL

    public function insert_salida_mercaderia(Request $request,$id)
    {
        //ALERTA 2
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $list_token = TrackingToken::whereIn('base', [$get_id->hacia])->get();
        foreach($list_token as $token){
            $dato = [
                'id_tracking' => $id,
                'token' => $token->token,
                'titulo' => 'SALIDA DE MERCADERÍA',
                'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está en camino',
            ];
            $this->sendNotification($dato);
        }

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

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R',$get_id->n_requerimiento]);
        foreach($list_detalle as $list){
            TrackingGuiaRemisionDetalle::create([
                'n_requerimiento' => $get_id->n_requerimiento,
                'n_guia_remision' => $get_id->n_requerimiento,
                'sku' => $list->sku,
                'color' => $list->color,
                'estilo' => $list->estilo,
                'talla' => $list->talla,
                'descripcion' => $list->descripcion,
                'cantidad' => $list->cantidad,
            ]);
        }
    }

    public function detalle_transporte($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.tracking.detalle_transporte', compact('list_notificacion','list_subgerencia','get_id'));
    }

    public function insert_mercaderia_transito(Request $request,$id)
    {
        $request->validate([
            'guia_transporte' => 'required',
            'peso' => 'required',
            'paquetes' => 'required_without_all:sobres,fardos,caja|nullable',
            'sobres' => 'required_without_all:paquetes,fardos,caja|nullable',
            'fardos' => 'required_without_all:paquetes,sobres,caja|nullable',
            'caja' => 'required_without_all:paquetes,sobres,fardos|nullable',
            'tiempo_llegada' => 'required',
            'nombre_transporte' => 'required_if:transporte,1,2',
            'importe_transporte' => 'required_if:transporte,1,2',
            'factura_transporte' => 'required_if:tipo_pago,1',
            'archivo_transporte' => 'required_if:tipo_pago,1',
        ],[
            'guia_transporte.required' => 'Debe ingresar nro. gr transporte.',
            'peso.required' => 'Debe ingresar peso.',
            'required_without_all' => 'Debe ingresar paquetes o sobres o fardos o caja.',
            'tiempo_llegada.required' => 'Debe ingresar tiempo de llegada', 
            'nombre_transporte.required_if' => 'Debe ingresar nombre de empresa.',
            'importe_transporte.required_if' => 'Debe ingresar importe a pagar.',
            'factura_transporte.required_if' => 'Debe ingresar n° factura.',
            'archivo_transporte.required_if' => 'Debe ingresar PDF de factura.'
        ]);

        $errors = [];
        if (($request->transporte=="1" || $request->transporte=="2") && $request->importe_transporte=="0") {
            $errors['importe_transporte'] = ['Debe ingresar importe a pagar mayor a 0.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        if($request->transporte=="3"){
            $tipo_pago = 0;
        }else{
            $tipo_pago = $request->tipo_pago;
        }

        Tracking::findOrFail($id)->update([
            'guia_transporte' => $request->guia_transporte,
            'peso' => $request->peso,
            'paquetes' => $request->paquetes,
            'sobres' => $request->sobres,
            'fardos' => $request->fardos,
            'caja' => $request->caja,
            'transporte' => $request->transporte,
            'tiempo_llegada' => $request->tiempo_llegada,
            'tipo_pago' => $tipo_pago,
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

        if($request->comentario){
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'DETALLE_TRANSPORTE',
                'comentario' => $request->comentario
            ]);
        }
    }

    public function insert_confirmacion_llegada(Request $request,$id)
    {
        //ALERTA 4
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        if($get_id->id_estado=="4"){
            $id_detalle_4 = $get_id->id_detalle;
        }else{
            $id_detalle_4 = $get_id->id_dos;
        }

        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach($list_token as $token){
            $dato = [
                'id_tracking' => $id,
                'token' => $token->token,
                'titulo' => 'CONFIRMACIÓN DE LLEGADA',
                'contenido' => 'Hola '.$get_id->desde.', se ha confirmado que la mercadería llegó a tienda',
            ];
            $this->sendNotification($dato);
        }

        if($get_id->id_estado=="4"){
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $id,
                'id_proceso' => 3,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 6,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            $id_detalle_6 = $tracking_dp->id;
        }else{
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
            $id_detalle_6 = $get_id->id_detalle;
        }

        //MENSAJE 2
        $estado_4 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$id_detalle_4,'id_estado'=>4]);
        $estado_6 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$id_detalle_6,'id_estado'=>6]);
        $list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();

        $fecha1 = new \DateTime($estado_4->fecha);
        $fecha2 = new \DateTime($estado_6->fecha);
        $intervalo = $fecha1->diff($fecha2);
        $diferencia = $intervalo->days;

        $t_comentario = TrackingComentario::where('id_tracking',$id)->where('pantalla','DETALLE_TRANSPORTE')->first();

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

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            $mail->addAddress('ogutierrez@lanumero1.com.pe');
            $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            /*$list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
            foreach($list_td as $list){
                $mail->addAddress($list->emailp);
            }
            $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
            foreach($list_cd as $list){
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
            foreach($list_cc as $list){
                $mail->addCC($list->emailp);
            }*/

            $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "IDM-SEM".$get_id->semana."-".substr(date('Y'),-2)." RQ-".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
        
            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> '.$get_id->semana.'<br>
                                <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                <b>Base:</b> '.$get_id->hacia.'<br>
                                <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                Hola, la mercadería ha llegado a tienda.<br><br>
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
                                        <td colspan="2" style="font-weight:bold;">Tipo de transporte</td>
                                        <td style="text-align:right;">'.$get_id->tipo_transporte.'</td>
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
                                        <td rowspan="4" style="font-weight:bold;">Fecha</td>
                                        <td style="font-weight:bold;">Partida</td>
                                        <td style="text-align:right;">'.$estado_4->fecha_formateada.'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Tiempo estimado de llegada</td>
                                        <td style="text-align:right;">'.$get_id->tiempo_llegada.'</td>
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
                                </a><br>';
                            if($t_comentario){
            $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                            </FONT SIZE>';
                            }
        
            $mail->CharSet = 'UTF-8';
            foreach($list_archivo as $list){
                $archivo_contenido = file_get_contents($list->archivo);
                $nombre_archivo = basename($list->archivo);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }
            $mail->send();

            TrackingDetalleEstado::create([
                'id_detalle' => $id_detalle_6,
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

        if($get_id->transporte=="3" || $get_id->tipo_pago=="1"){
            //ALERTA 5 (SI)
            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                    'contenido' => 'Hola '.$get_id->desde.', se ha dado el cierre a la inspección de fardos',
                ];
                $this->sendNotification($dato);
            }

            //ALERTA 7
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'INSPECCION DE MERCADERÍA',
                    'contenido' => 'Hola '.$get_id->desde.', se realizará la inspección de mercadería',
                ];
                $this->sendNotification($dato);
            }

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
                $contenido_mensaje = 'Hola '.$get_id->hacia.', se ha dado el cierre a las irregularidades de los fardos';
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
                $contenido_mensaje = 'Hola '.$get_id->desde.', se ha dado el cierre a la inspección de fardos';
            }

            //ALERTA 5 (SI) o (NO)
            if($request->validacion==1){
                $list_token = TrackingToken::whereIn('base', [$get_id->hacia])->get();
            }else{
                $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            }
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                    'contenido' => $contenido_mensaje,
                ];
                $this->sendNotification($dato);
            }

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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.tracking.verificacion_fardos', compact('list_notificacion','list_subgerencia','get_id'));
    }

    public function list_archivo(Request $request)
    {
        if($request->tipo=="3"){
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id_producto'=>$request->id_producto]);
        }else{
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>$request->tipo]);
        }
        return view('logistica.tracking.tracking.lista_archivo', compact('list_archivo'));
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
        $request->validate([
            'observacion_inspf' => 'required'
        ],[
            'observacion_inspf.required' => 'Debe ingresar observación.'
        ]);

        $list_temporal = TrackingArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->where('tipo',2)->count();
        $errors = [];
        if ($_FILES["archivo_inspf"]["name"]=="" && $list_temporal==0) {
            $errors['archivo'] = ['Debe adjuntar o capturar con la cámara la evidencia.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

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

        if($request->comentario){
            TrackingComentario::create([
                'id_tracking' => $request->id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'VERIFICACION_FARDO',
                'comentario' => $request->comentario
            ]);
        }

        //MENSAJE 3
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);
        $list_archivo = TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 2)->get();
        $t_comentario = TrackingComentario::where('id_tracking',$request->id)->where('pantalla','VERIFICACION_FARDO')->first();

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

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            $mail->addAddress('ogutierrez@lanumero1.com.pe');
            $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
            foreach($list_cd as $list){
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
            foreach($list_cc as $list){
                $mail->addCC($list->emailp);
            }*/

            $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "REPORTE INSPECCIÓN FARDOS: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
        
            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> '.$get_id->semana.'<br>
                                <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                <b>Base:</b> '.$get_id->hacia.'<br>
                                <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                Hola '.$get_id->desde.', los fardos han llegado con las siguientes 
                                observaciones:<br><br>
                                '.nl2br($get_id->observacion_inspf).'<br>';
                            if($t_comentario){
            $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                            </FONT SIZE>';
                            }
        
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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();   
        $list_subgerencia = SubGerencia::list_subgerencia(7);     
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.tracking.pago_transporte', compact('list_notificacion','list_subgerencia','get_id'));
    }

    public function previsualizacion_captura_pago()
    {
        if($_FILES["photo"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if(file_exists('https://lanumerounocloud.com/intranet/TRACKING/temporal_pm_'.session('usuario')->id_usuario.'.jpg')){
                    ftp_delete($con_id, 'TRACKING/temporal_pm_'.session('usuario')->id_usuario.'.jpg');
                }

                $path = $_FILES["photo"]["name"];
                $source_file = $_FILES['photo']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_pm_".session('usuario')->id_usuario;
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if (!$subio) {
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }
    }

    public function insert_confirmacion_pago_transporte(Request $request, $id)
    {
        $request->validate([
            'factura_transporte' => 'required'
        ],[
            'factura_transporte.required' => 'Debe ingresar n° de factura.'
        ]);

        $errors = [];
        if ($_FILES["archivo_transporte"]["name"]=="" && $request->captura=="0") {
            $errors['archivo'] = ['Debe adjuntar o capturar con la cámara la factura.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        Tracking::findOrFail($id)->update([
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

        if($request->captura=="1"){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $nombre_actual = "TRACKING/temporal_pm_".session('usuario')->id_usuario.".jpg";
                $nuevo_nombre = "TRACKING/Factura_".$id."_".date('YmdHis')."_captura.jpg";
                ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;
                
                TrackingArchivo::create([
                    'id_tracking' => $id,
                    'tipo' => 1,
                    'archivo' => $archivo
                ]);
            }else{
                echo "No se conecto";
            }
        }

        //ALERTA 6
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach($list_token as $token){
            $dato = [
                'id_tracking' => $id,
                'token' => $token->token,
                'titulo' => 'CONFIRMACIÓN DE PAGO A TRANSPORTE',
                'contenido' => 'Hola '.$get_id->desde.', se ha pagado a la agencia',
            ];
            $this->sendNotification($dato);
        }

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
        
        if($request->comentario){
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'PAGO_TRANSPORTE',
                'comentario' => $request->comentario
            ]);
        }

        //MENSAJE 4
        $list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();
        $t_comentario = TrackingComentario::where('id_tracking',$id)->where('pantalla','PAGO_TRANSPORTE')->first();

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

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            $mail->addAddress('ogutierrez@lanumero1.com.pe');
            $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
            foreach($list_cd as $list){
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
            foreach($list_cc as $list){
                $mail->addCC($list->emailp);
            }*/

            $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "MERCADERÍA PAGADA: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
        
            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> '.$get_id->semana.'<br>
                                <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                <b>Base:</b> '.$get_id->hacia.'<br>
                                <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                Hola '.$get_id->desde.', se ha pagado a la agencia.<br>
                                Empresa: '.$get_id->nombre_transporte.'<br>
                                Monto: '.$get_id->importe_transporte.'<br>
                                N° factura: '.$get_id->factura_transporte.'<br>';
                            if($t_comentario){
            $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                            </FONT SIZE>';
                            }
        
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
            //ALERTA 7
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'INSPECCION DE MERCADERÍA',
                    'contenido' => 'Hola '.$get_id->desde.', se realizará la inspección de mercadería',
                ];
                $this->sendNotification($dato);
            }

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
        //ALERTA 8
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach($list_token as $token){
            $dato = [
                'id_tracking' => $id,
                'token' => $token->token,
                'titulo' => 'CONTEO DE MERCADERÍA',
                'contenido' => 'Hola '.$get_id->desde.', se está realizando el conteo de la mercadería',
            ];
            $this->sendNotification($dato);
        }

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
        //ALERTA 13
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
        foreach($list_token as $token){
            $dato = [
                'id_tracking' => $id,
                'token' => $token->token,
                'titulo' => 'MERCADERÍA ENTREGADA',
                'contenido' => 'La mercadería fue distribuida con éxito',
            ];
            $this->sendNotification($dato);
        }

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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();   
        $list_subgerencia = SubGerencia::list_subgerencia(7);     
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.tracking.reporte_mercaderia', compact('list_notificacion','list_subgerencia','get_id'));
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
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();    
        $list_subgerencia = SubGerencia::list_subgerencia(7);    
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        try {
            $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);
        } catch (\Throwable $th) {
            $list_diferencia = [];
        }
        return view('logistica.tracking.tracking.cuadre_diferencia', compact('list_notificacion','list_subgerencia','get_id','list_diferencia'));
    }

    public function insert_reporte_diferencia(Request $request,$id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        try {
            $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);
        } catch (\Throwable $th) {
            $list_diferencia = [];
        }

        foreach($list_diferencia as $list){
            TrackingDiferencia::create([
                'id_tracking' => $id,
                'estilo' => $list->Estilo,
                'bulto' => $list->Bulto,
                'color_talla' => $list->Col_Tal,
                'enviado' => $list->Enviado,
                'recibido' => $list->Recibido
            ]);
        }
                
        if($request->comentario){
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'CUADRE_DIFERENCIA',
                'comentario' => $request->comentario
            ]);
        }

        $list_sobrante = TrackingDiferencia::select('estilo','color_talla','bulto','enviado',
                        'recibido',DB::raw('enviado-recibido AS diferencia'),
                        DB::raw("CASE WHEN enviado<recibido THEN 'Sobrante' 
                        WHEN enviado>recibido THEN 'Faltante' ELSE '' END AS observacion"))
                        ->where('id_tracking',$id)->whereColumn('enviado','<','recibido')
                        ->get();
        $list_faltante = TrackingDiferencia::select('estilo','color_talla','bulto','enviado',
                        'recibido',DB::raw('enviado-recibido AS diferencia'),
                        DB::raw("CASE WHEN enviado<recibido THEN 'Sobrante' 
                        WHEN enviado>recibido THEN 'Faltante' ELSE '' END AS observacion"))
                        ->where('id_tracking',$id)->whereColumn('enviado','>','recibido')
                        ->get();

        //ALERTA 9
        if($list_sobrante){
            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'REPORTE DE DIFERENCIAS',
                    'contenido' => 'Hola '.$get_id->desde.', regularizar los sobrantes indicados',
                ];
                $this->sendNotification($dato);
            }
        }
        if($list_faltante){
            $list_token = TrackingToken::whereIn('base', [$get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'REPORTE DE DIFERENCIAS',
                    'contenido' => 'Hola '.$get_id->hacia.', regularizar los faltantes indicados',
                ];
                $this->sendNotification($dato);
            }
        }

        //MENSAJE 5
        $t_comentario = TrackingComentario::where('id_tracking',$id)->where('pantalla','CUADRE_DIFERENCIA')->first();

        if($list_sobrante){
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
    
                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/
    
                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
    
                $mail->isHTML(true);
    
                $mail->Subject = "DIFERENCIAS EN LA RECEPCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                    Hola '.$get_id->desde.', regularizar los sobrantes indicados.<br><br>
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
                                    foreach($list_sobrante as $list){
                $mail->Body .=  '            <tr align="left">
                                                <td>'.$list->estilo.'</td>
                                                <td>'.$list->color_talla.'</td>
                                                <td>'.$list->bulto.'</td>
                                                <td>'.$list->enviado.'</td>
                                                <td>'.$list->recibido.'</td>
                                                <td>'.$list->diferencia.'</td>
                                                <td>'.$list->observacion.'</td>
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
                                    </a><br>';
                                if($t_comentario){
                $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                                </FONT SIZE>';
                                }                                
            
                $mail->CharSet = 'UTF-8';
                $mail->send();
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
        if($list_faltante){
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
    
                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
                foreach($list_td as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/
    
                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
    
                $mail->isHTML(true);
    
                $mail->Subject = "DIFERENCIAS EN LA RECEPCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                    Hola '.$get_id->hacia.', regularizar los faltantes indicados.<br><br>
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
                                    foreach($list_faltante as $list){
                $mail->Body .=  '            <tr align="left">
                                                <td>'.$list->estilo.'</td>
                                                <td>'.$list->color_talla.'</td>
                                                <td>'.$list->bulto.'</td>
                                                <td>'.$list->enviado.'</td>
                                                <td>'.$list->recibido.'</td>
                                                <td>'.$list->diferencia.'</td>
                                                <td>'.$list->observacion.'</td>
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
                                    </a><br>';
                                if($t_comentario){
                $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                                </FONT SIZE>';
                                }                                
            
                $mail->CharSet = 'UTF-8';
                $mail->send();
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }

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
    }

    public function detalle_operacion_diferencia($id)
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }        
            //NOTIFICACIONES
            $list_notificacion = Notificacion::get_list_notificacion();
            $list_subgerencia = SubGerencia::list_subgerencia(7);
            $get_id = Tracking::get_list_tracking(['id'=>$id]);
            if($get_id->id_estado==15){
                return view('logistica.tracking.tracking.detalle_operacion_diferencia', compact('list_notificacion','list_subgerencia','get_id'));
            }else{
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
                return view('logistica.tracking.tracking.index', compact('list_notificacion','list_mercaderia_nueva'));
            }
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function insert_diferencia_regularizada(Request $request,$id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        if($get_id->sobrantes>0 && 
        $get_id->faltantes>0 &&
        session('usuario')->id_nivel==1){
            $request->validate([
                'guia_sobrante' => 'required|max:20',
                'guia_faltante' => 'required|max:20'
            ],[
                'guia_sobrante.required' => 'Debe ingresar Nro. Gr (Sobrante).',
                'guia_sobrante.max' => 'Nro. Gr (Sobrante) debe tener como máximo 20 carácteres.',
                'guia_faltante.required' => 'Debe ingresar Nro. Gr (Faltante).',
                'guia_faltante.max' => 'Nro. Gr (Faltante) debe tener como máximo 20 carácteres.'
            ]);
            
            Tracking::findOrFail($id)->update([
                'guia_sobrante' => $request->guia_sobrante,
                'guia_faltante' => $request->guia_faltante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }elseif($get_id->sobrantes>0 &&
        (session('usuario')->id_puesto==76 ||
        session('usuario')->id_nivel==1)){
            $request->validate([
                'guia_sobrante' => 'required|max:20'
            ],[
                'guia_sobrante.required' => 'Debe ingresar Nro. Gr (Sobrante).',
                'guia_sobrante.max' => 'Nro. Gr (Sobrante) debe tener como máximo 20 carácteres.'
            ]);

            Tracking::findOrFail($id)->update([
                'guia_sobrante' => $request->guia_sobrante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }elseif($get_id->faltantes>0 &&
        (session('usuario')->id_puesto==29 || 
        session('usuario')->id_puesto==30 || 
        session('usuario')->id_puesto==31 || 
        session('usuario')->id_puesto==32 || 
        session('usuario')->id_puesto==33 || 
        session('usuario')->id_puesto==34 || 
        session('usuario')->id_puesto==35 || 
        session('usuario')->id_puesto==161 || 
        session('usuario')->id_puesto==167 || 
        session('usuario')->id_puesto==168 ||
        session('usuario')->id_puesto==197 || 
        session('usuario')->id_puesto==311 || 
        session('usuario')->id_puesto==314 ||
        session('usuario')->id_nivel==1)){
            $request->validate([
                'guia_faltante' => 'required|max:20'
            ],[
                'guia_faltante.required' => 'Debe ingresar Nro. Gr (Faltante).',
                'guia_faltante.max' => 'Nro. Gr (Faltante) debe tener como máximo 20 carácteres.'
            ]);

            Tracking::findOrFail($id)->update([
                'guia_faltante' => $request->guia_faltante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }

        if($request->comentario){
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'DETALLE_OPERACION_DIFERENCIA',
                'comentario' => $request->comentario
            ]);
        }

        $get_id = Tracking::get_list_tracking(['id'=>$id]);

        $valida = 0;
        $mensaje = "";
        if($get_id->sobrantes>0 && $get_id->faltantes>0){
            if($get_id->guia_sobrante!="" && $get_id->guia_faltante!=""){
                $valida = 1;
                $mensaje = " con las GR (Sobrante): ".$get_id->guia_sobrante." y GR (Faltante): ".$get_id->guia_faltante;
            }
        }elseif($get_id->sobrantes>0){
            if($get_id->guia_sobrante!=""){
                $valida = 1;
                $mensaje = " con la GR (Sobrante): ".$get_id->guia_sobrante;
            }
        }elseif($get_id->faltantes>0){
            if($get_id->guia_faltante!=""){
                $valida = 1;
                $mensaje = " con la GR (Faltante): ".$get_id->guia_faltante;
            }
        }else{
            $valida = 1;
        }

        if($valida==1){
            //ALERTA 10
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'DIFERENCIAS REGULARIZADAS',
                    'contenido' => 'Hola '.$get_id->desde.' - '.$get_id->hacia.', se regularizó el Nro. Req. '.$get_id->n_requerimiento.$mensaje,
                ];
                $this->sendNotification($dato);
            }

            //MENSAJE 6
            $t_comentario = TrackingComentario::from('tracking_comentario AS tc')
                            ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                            us.usuario_apater) AS nombre"),'tc.comentario')
                            ->join('users AS us','us.id_usuario','=','tc.id_usuario')
                            ->where('tc.id_tracking',$id)
                            ->where('tc.pantalla','DETALLE_OPERACION_DIFERENCIA')->get();

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

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
                foreach($list_td as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/

                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "REGULARIZADO - DIFERENCIAS EN LA RECEPCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                    Hola '.$get_id->desde.' - '.$get_id->hacia.', se acaba de 
                                    regularizar'.$mensaje.'.
                                    El archivo ya se encuentra en su carpeta.<br>';
                                if(count($t_comentario)>0){
                $mail->Body .=      '<br>Comentario:<br>';
                                foreach($t_comentario as $list){
                $mail->Body .=      '- '.$list->nombre.': '.nl2br($list->comentario).'<br>';
                                }
                $mail->Body .= '</FONT SIZE>';
                                }
            
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
                    //ALERTA 13
                    $this->insert_mercaderia_entregada($id);
                }
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }   
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

        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        $list_guia_remision = TrackingGuiaRemisionDetalle::select('id','sku','descripcion','cantidad')->where('n_guia_remision',$get_id->n_guia_remision)->get();
        return view('logistica.tracking.tracking.solicitud_devolucion', compact('list_notificacion','list_subgerencia','get_id','list_guia_remision'));
    }

    public function modal_solicitud_devolucion($id)
    {
        $get_producto = TrackingGuiaRemisionDetalle::findOrFail($id);
        $get_id = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)
                                            ->where('id_producto',$id)->first();
        return view('logistica.tracking.tracking.modal_solicitud_devolucion', compact('get_producto','get_id'));
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

        $list_temporal = TrackingArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->where('tipo',3)->where('id_producto',$id)->count();
        $errors = [];
        if ($list_temporal==0) {
            $errors['archivo'] = ['Debe capturar con la cámara la evidencia.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

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

        $cantidad = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)->count();
        $array = explode(",",substr($request->devoluciones,1));

        if($cantidad>=count($array)){
            //ALERTA 11
            $get_id = Tracking::get_list_tracking(['id'=>$id]);

            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'SOLICITUD DE DEVOLUCIÓN',
                    'contenido' => 'Hola Andrea, se ha encontrado mercadería para devolución, revisar correo',
                ];
                $this->sendNotification($dato);
            }

            $list_devolucion = TrackingDevolucionTemporal::where('id_usuario',session('usuario')->id_usuario)
                                ->whereIn('id_producto',$array)->get();

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
            
            if($request->comentario){
                TrackingComentario::create([
                    'id_tracking' => $id,
                    'id_usuario' => session('usuario')->id_usuario,
                    'pantalla' => 'SOLICITUD_DEVOLUCION',
                    'comentario' => $request->comentario
                ]);
            }

            //MENSAJE 7
            $t_comentario = TrackingComentario::where('id_tracking',$id)->where('pantalla','SOLICITUD_DEVOLUCION')->first();

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
    
                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/

                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
    
                $mail->isHTML(true);
    
                $mail->Subject = "SOLICITUD DE DEVOLUCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
                                    Hola Andrea, tienes una solicitud de devolución por evaluar.
                                    <br><br>
                                    <a href="'.route('tracking.evaluacion_devolucion', $id).'" 
                                    title="Evaluación de Devolución"
                                    target="_blank" 
                                    style="background-color: red;
                                    color: white;
                                    border: 1px solid transparent;
                                    padding: 7px 12px;
                                    font-size: 13px;
                                    text-decoration: none !important;
                                    border-radius: 10px;">
                                        Evaluación de Devolución
                                    </a><br>';
                                if($t_comentario){
                $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                                </FONT SIZE>';
                                }
            
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
            //NOTIFICACIONES
            $list_notificacion = Notificacion::get_list_notificacion();
            $list_subgerencia = SubGerencia::list_subgerencia(7);
            $get_id = Tracking::get_list_tracking(['id'=>$id]);
            if($get_id->id_estado==18){
                TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
                $list_devolucion = TrackingDevolucion::select('tracking_devolucion.id','tracking_guia_remision_detalle.sku',
                                                        'tracking_guia_remision_detalle.descripcion',
                                                        'tracking_devolucion.cantidad')
                                                        ->join('tracking_guia_remision_detalle','tracking_guia_remision_detalle.id','=','tracking_devolucion.id_producto')
                                                        ->where('tracking_devolucion.id_tracking',$id)
                                                        ->where('tracking_devolucion.estado',1)->get();
                return view('logistica.tracking.tracking.evaluacion_devolucion', compact(
                    'list_notificacion',
                    'list_subgerencia',
                    'get_id',
                    'list_devolucion'
                ));
            }else{
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
                return view('logistica.tracking.tracking.index', compact('list_notificacion','list_subgerencia','list_mercaderia_nueva'));
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
        return view('logistica.tracking.tracking.modal_evaluacion_devolucion', compact('get_devolucion','list_archivo','get_id'));
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

        TrackingEvaluacionTemporal::where('id_usuario',session('usuario')->id_usuario)
        ->where('id_devolucion',$id)->delete();
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

            if($request->comentario){
                TrackingComentario::create([
                    'id_tracking' => $id,
                    'id_usuario' => session('usuario')->id_usuario,
                    'pantalla' => 'EVALUACION_DEVOLUCION',
                    'comentario' => $request->comentario
                ]);
            }                                                    

            //MENSAJE 8
            $t_comentario = TrackingComentario::where('id_tracking',$id)->where('pantalla','EVALUACION_DEVOLUCION')->first();

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
    
                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                /*$list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD','']);
                foreach($list_cd as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
                foreach($list_td as $list){
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC','']);
                foreach($list_cc as $list){
                    $mail->addCC($list->emailp);
                }*/

                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
    
                $mail->isHTML(true);
    
                $mail->Subject = "RESPUESTA A SOLICITUD DE DEVOLUCIÓN: RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha:</b> '.$fecha_formateada.'<br><br>
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
                                    </table>';
                                if($t_comentario){
                $mail->Body .=      '<br>Comentario:<br>'.nl2br($t_comentario->comentario).'
                                </FONT SIZE>';
                                }
            
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
    
            //ALERTA 12
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'id_tracking' => $id,
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INCONFORMIDADES DE DEVOLUCIÓN',
                    'contenido' => 'Hola, '.$get_id->desde.' - '.$get_id->hacia.' revisar respuesta de la solicitud de la devolución para el Nro. Req',
                ];
                $this->sendNotification($dato);
            }

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

            //ALERTA 13
            $this->insert_mercaderia_entregada($id);
        }else{
            echo "error";
        }
    }
    //MERCADERIA NUEVA
    public function mercaderia_nueva()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $list_base = Base::get_list_bases_tienda();
        return view('logistica.tracking.tracking.mercaderia_nueva.index', compact(
            'list_notificacion',
            'list_subgerencia',
            'list_base'
        ));
    }

    public function list_mercaderia_nueva(Request $request)
    {
        $cod_base = $request->cod_base;
        $list_mercaderia_nueva = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_app ?,?,?', [
            $request->cod_base,
            $request->tipo_usuario,
            $request->tipo_prenda
        ]);
        return view('logistica.tracking.tracking.mercaderia_nueva.lista', compact('cod_base','list_mercaderia_nueva'));
    }

    public function mercaderia_nueva_tusu($cod_base)
    {
        $list_tipo_usuario = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_tusuario_app ?', [
            $cod_base
        ]);
        return view('logistica.tracking.tracking.mercaderia_nueva.tipo_usuario', compact('list_tipo_usuario'));
    }

    public function mercaderia_nueva_tpre($cod_base)
    {
        $list_tipo_prenda = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_tprenda_app ?', [
            $cod_base
        ]);
        return view('logistica.tracking.tracking.mercaderia_nueva.tipo_prenda', compact('list_tipo_prenda'));
    }

    public function modal_mercaderia_nueva($cod_base,$estilo)
    {
        $list_mercaderia_nueva = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?', [
            $cod_base,
            $estilo
        ]);
        return view('logistica.tracking.tracking.mercaderia_nueva.modal_detalle', compact(
            'estilo',
            'list_mercaderia_nueva'
        ));
    }

    public function list_mercaderia_nueva_app(Request $request)
    {
        try { 
            if($request->estilo){
                $query = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?', [
                    $request->cod_base,
                    $request->estilo
                ]);
            }else{
                $query = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_app ?,?,?', [
                    $request->cod_base,
                    $request->tipo_usuario,
                    $request->tipo_prenda
                ]);

                $query_tu = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_tusuario_app ?', [
                    $request->cod_base
                ]);

                $query_tp = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_tprenda_app ?', [
                    $request->cod_base
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if (count($query)==0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        if($request->estilo){
            return response()->json($query, 200);
        }else{
            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu,
                'tipo_prenda' => $query_tp
            ];

            return response()->json($response, 200);
        }
    }

    public function insert_mercaderia_nueva_app(Request $request, $sku)
    {
        $request->validate([
            'cod_base' => 'required',
            'cantidad' => 'required|gt:0',
        ],[
            'cantidad.cod_base' => 'Debe ingresar base.',
            'cantidad.required' => 'Debe ingresar cantidad.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
        ]);

        try {
            $resultados = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_sku ?,?', [
                $request->cod_base,
                $sku
            ]);
            $get_id = $resultados[0];

            $stock = DB::connection('sqlsrv')->select('EXEC usp_movil_ver_stock_precios_sku ?', [
                $sku
            ]);
            $get_stock = $stock[0];
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if($request->cantidad>$get_id->cantidad){
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);  
        }else{
            try {
                MercaderiaSurtida::create([
                    'tipo' => 1,
                    'base' => $request->cod_base,
                    'anio' => date('Y'),
                    'semana' => date('W'),
                    'sku' => $sku,
                    'estilo' => $get_id->estilo,
                    'tipo_usuario' => $get_id->tipo_usuario,
                    'tipo_prenda' => $get_id->tipo_prenda,
                    'color' => $get_id->color,
                    'talla' => $get_id->talla,
                    'descripcion' => $get_id->descripcion,
                    'cantidad' => $request->cantidad,
                    'stk_almacen' => $get_stock->stk_almacen,
                    'stk_tienda' => $get_stock->stk_tienda,
                    'estado' => 0,
                    'fecha' => now()
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
        }
    }

    public function list_surtido_mercaderia_nueva(Request $request)
    {
        try {
            if($request->estilo){
                $query = MercaderiaSurtida::get_list_mercaderia_surtida(['cod_base'=>$request->cod_base,'estilo'=>$request->estilo]);
            }else{
                $query = MercaderiaSurtida::select('estilo','tipo_usuario','descripcion')
                        ->where('tipo',1)->where('anio',date('Y'))->where('semana',date('W'))
                        ->where('base',$request->cod_base)->where('estado',0)
                        ->groupBy('estilo','tipo_usuario','descripcion')->get();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if (count($query)==0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        return response()->json($query, 200);
    }

    public function list_mercaderia_nueva_vendedor_app(Request $request)
    {
        try {
            if($request->estilo){
                $query = MercaderiaSurtida::get_list_mercaderia_surtida_vendedor(['cod_base'=>$request->cod_base,'estilo'=>$request->estilo]);
            }else{
                $query = MercaderiaSurtida::select('estilo','tipo_usuario','descripcion')
                        ->where('tipo',1)->where('anio',date('Y'))->where('semana',date('W'))
                        ->where('base',$request->cod_base)
                        ->groupBy('estilo','tipo_usuario','descripcion')->get();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if (count($query)==0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        return response()->json($query, 200);
    }
    //REQUERIMIENTO DE REPOSICIÓN
    public function insert_requerimiento_reposicion_app(Request $request,$sku)
    {
        $request->validate([
            'cantidad' => 'required|gt:0',
            'cod_base' => 'required',
        ],[
            'cantidad.required' => 'Debe ingresar cantidad.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
            'cod_base.required' => 'Debe ingresar base.',
        ]);

        try {
            MercaderiaSurtida::create([
                'tipo' => 2,
                'base' => $request->cod_base,
                'anio' => date('Y'),
                'semana' => date('W'),
                'sku' => $sku,
                'estilo' => $request->estilo,
                'tipo_usuario' => $request->tipo_usuario,
                'tipo_prenda' => $request->tipo_prenda,
                'color' => $request->color,
                'talla' => $request->talla,
                'descripcion' => $request->descripcion,
                'cantidad' => $request->cantidad,
                'estado' => 0,
                'fecha' => now()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }
    }

    public function insert_requerimiento_reposicion_estilo_app(Request $request)
    {
        $request->validate([
            'cod_base' => 'required',
            'estilo' => 'required',
        ],[
            'cod_base.required' => 'Debe ingresar base.',
            'estilo.required' => 'Debe ingresar estilo.',
        ]);

        try {
            $padre = MercaderiaSurtidaPadre::create([
                'base' => $request->cod_base,
                'estilo' => $request->estilo,
                'fecha' => now()
            ]);

            foreach ($request->detalle as $list) {
                MercaderiaSurtida::create([
                    'id_padre' => $padre->id,
                    'tipo' => 3,
                    'base' => $request->cod_base,
                    'anio' => date('Y'),
                    'semana' => date('W'),
                    'estilo' => $request->estilo,
                    'tipo_usuario' => $list['tipo_usuario'],
                    'descripcion' => $list['descripcion'],
                    'color'=> $list['color'],
                    'talla' => $list['talla'],
                    'cantidad' => $list['cantidad'],
                    'stk_almacen' => $list['stk_almacen'],
                    'stk_tienda' => $list['stk_tienda'],
                    'estado' => 0,
                    'fecha' => now()
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }
    }

    public function list_requerimiento_reposicion_app(Request $request)
    {
        if($request->tipo=="sku"){
            try {
                $query = MercaderiaSurtida::where('tipo',2)->where('base',$request->cod_base)
                                            ->where('estado',0)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }else if($request->tipo=="estilo"){
            try {
                $query = MercaderiaSurtidaPadre::get_list_mercaderia_surtida_padre(['cod_base'=>$request->cod_base]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }elseif($request->id_padre){
            try {
                $query = MercaderiaSurtida::where('id_padre', $request->id_padre)
                                            ->where('estado',0)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }else{
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }
    }

    public function list_requerimiento_reposicion_vendedor_app(Request $request)
    {
        if($request->tipo=="sku"){
            try {
                $query = MercaderiaSurtida::get_list_requerimiento_reposicion_vendedor([
                    'cod_base'=>$request->cod_base
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }else if($request->tipo=="estilo"){
            try {
                $query = MercaderiaSurtidaPadre::get_list_mercaderia_surtida_padre_vendedor([
                    'cod_base'=>$request->cod_base
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }elseif($request->id_padre){
            try {
                $query = MercaderiaSurtida::get_list_requerimiento_reposicion_vendedor([
                    'id_padre'=>$request->id_padre
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }
    
            if (count($query)==0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }
    
            return response()->json($query, 200);
        }else{
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }
    }

    public function update_requerimiento_reposicion_app($id)
    {
        try {
            MercaderiaSurtida::findOrFail($id)->update([
                'estado' => 1,
                'fecha' => now()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }
    }

    public function delete_mercaderia_surtida_app($id)
    {
        try {
            MercaderiaSurtida::destroy($id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }
    }
    //BD TRACKING
    public function index_bd()
    {      
        return view('logistica.tracking.bd_tracking.index');
    }

    public function list_bd()
    {
        $list_bd_tracking = Tracking::get_list_bd_tracking();
        return view('logistica.tracking.bd_tracking.lista', compact('list_bd_tracking'));
    }
}