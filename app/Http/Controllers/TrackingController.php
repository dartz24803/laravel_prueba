<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Tracking;
use App\Models\Base;
use App\Models\TrackingArchivo;
use App\Models\TrackingArchivoTemporal;
use App\Models\TrackingDetalleEstado;
use App\Models\TrackingDetalleProceso;
use App\Models\TrackingGuiaRemisionDetalle;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except(['index','detalle_operacion_diferencia']);
    }

    public function index()
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }
            return view('logistica.tracking.index');
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
            'desde' => $request->desde,
            'hacia' => $request->hacia,
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

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "mercaderia_por_salir",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$request->hacia.'"
                                },
                                {
                                    "type": "text",
                                    "text": "'.$request->n_requerimiento.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

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

        //ENVÍO DE CORREO
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

            $mail->Subject = "SDM-SEM".$request->semana."-".substr(date('Y'),-2)." RQ-".$request->n_requerimiento." (".$request->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Buen día '.$request->hacia.'.<br><br>
                                Se envia el reporte de la salida de Mercaderia, de la guía de remisión '.$request->n_requerimiento.'.<br><br>
                                <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                    <thead>
                                        <tr align="center" style="background-color:#0093C6;">
                                            <th width="18%"><b>Color</b></th>
                                            <th width="18%"><b>Estilo</b></th>
                                            <th width="18%"><b>Talla</b></th>
                                            <th width="36%"><b>Descripción</b></th>
                                            <th width="10%"><b>Cantidad</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                foreach($list_detalle as $list){
            $mail->Body .=  '            <tr align="left">
                                            <td>'.$list->color.'</td>
                                            <td>'.$list->estilo.'</td>
                                            <td>'.$list->talla.'</td>
                                            <td>'.$list->descripcion.'</td>
                                            <td style="text-align:center;">'.$list->cantidad.'</td>
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
        //END
    }

    public function insert_salida_mercaderia(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "salida_mercaderia",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$get_id->hacia.'"
                                },
                                {
                                    "type": "text",
                                    "text": "'.$get_id->n_requerimiento.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

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

    public function insert_mercaderia_transito(Request $request)
    {
        Tracking::findOrFail($request->id)->update([
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

                $fecha = date('YmdHis');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_".$request->id."_".$fecha;
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;
                    TrackingArchivo::create([
                        'id_tracking' => $request->id,
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
            'id_tracking' => $request->id,
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

    public function insert_llegada_tienda(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "llegada_tienda",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$get_id->hacia.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $request->id,
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

    public function insert_confirmacion_llegada(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "confirmacion_llegada",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$get_id->desde.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

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

        //ENVÍO DE CORREO
        $estado_5 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$get_id->id_detalle,'id_estado'=>5]);
        $estado_6 = TrackingDetalleEstado::get_list_tracking_detalle_estado(['id_detalle'=>$get_id->id_detalle,'id_estado'=>6]);
        $list_archivo = TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 1)->get();

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
        //END
    }

    public function insert_cierre_inspeccion_fardos(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        if($get_id->transporte==2 || ($get_id->transporte==1 && $get_id->importe_transporte>0)){
            //ENVÍO DE WHATSAPP
            /*$curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "messaging_product": "whatsapp",
                    "to": "51956897977",
                    "type": "template",
                    "template": {
                        "name": "inspeccion_mercaderia",
                        "language": {
                            "code": "es_MX"
                        },
                        "components": [
                            {
                                "type": "body",
                                "parameters": [
                                    {
                                        "type": "text",
                                        "text": "'.$get_id->desde.'"
                                    }
                                ]
                            }
                        ]
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                    'Content-Type: application/json'
                ),
            ));
            curl_exec($curl);
            curl_close($curl);*/
            //END

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $request->id,
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
                $tipo_mensaje = "cierre_inspeccion_fardo_indirecto";
            }else{
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
                $id_detalle = $tracking_dp->id;
                $tipo_mensaje = "cierre_inspeccion_fardo_directo";
            }

            //ENVÍO DE WHATSAPP
            /*$curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "messaging_product": "whatsapp",
                    "to": "51956897977",
                    "type": "template",
                    "template": {
                        "name": "'.$tipo_mensaje.'",
                        "language": {
                            "code": "es_MX"
                        },
                        "components": [
                            {
                                "type": "body",
                                "parameters": [
                                    {
                                        "type": "text",
                                        "text": "'.$get_id->desde.'"
                                    }
                                ]
                            }
                        ]
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                    'Content-Type: application/json'
                ),
            ));
            curl_exec($curl);
            curl_close($curl);*/
            //END

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

    public function list_archivo_inspf()
    {
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>2]);
        return view('logistica.tracking.lista_archivo_inspf', compact('list_archivo'));
    }

    public function previsualizacion_captura()
    {
        $valida = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo'=>2]);

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

                    $fecha = date('YmdHis');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "temporal_inpsf_".session('usuario')->id."_".$fecha;
                    $nombre = $nombre_soli.".".strtolower($ext);

                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                    ftp_pasv($con_id,true); 
                    $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        TrackingArchivoTemporal::create([
                            'id_usuario' => session('usuario')->id_usuario,
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
        }
    }

    public function delete_archivo_temporal_inspf($id)
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
                $nombre_soli = "Evidencia_".$request->id."_0";
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
                    $nuevo_nombre = "TRACKING/Evidencia_".$request->id."_".$i.".jpg";
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
            TrackingArchivoTemporal::where('id_usuario', session('usuario')->id)->where('tipo', 2)->delete();
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

        //ENVÍO DE CORREO
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
        //END
    }

    public function pago_transporte($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.pago_transporte', compact('get_id'));
    }

    public function insert_confirmacion_pago_transporte(Request $request)
    {
        Tracking::findOrFail($request->id)->update([
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
                    $get_id = TrackingArchivo::get_list_tracking_archivo(['id_tracking'=>$request->id,'tipo'=>1]);
                    $file_to_delete = "TRACKING/".$get_id->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 1)->delete();
                    }
                }
                //
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $fecha = date('YmdHis');
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_".$request->id."_".$fecha;
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;
                    TrackingArchivo::create([
                        'id_tracking' => $request->id,
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

        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "confirmacion_pago_mercaderia",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$get_id->desde.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $request->id,
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

        //ENVÍO DE CORREO
        $list_archivo = TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 1)->get();

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
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $request->id,
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
        //END
    }

    public function insert_conteo_mercaderia(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        //ENVÍO DE WHATSAPP
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.facebook.com/v19.0/238326042708442/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "messaging_product": "whatsapp",
                "to": "51956897977",
                "type": "template",
                "template": {
                    "name": "conteo_mercaderia",
                    "language": {
                        "code": "es_MX"
                    },
                    "components": [
                        {
                            "type": "body",
                            "parameters": [
                                {
                                    "type": "text",
                                    "text": "'.$get_id->desde.'"
                                }
                            ]
                        }
                    ]
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer EAAKZBi44f9U8BO2GfSXEpkvkZCVGxxvGjVLQ7KpsPA9yksGvjx5Au6535ZBukULZAwCN4s1m0TmZAzSt61O3f2pJP1sZBhcKvINSi4yCgtZB2EqdvBodkrMG4n4FALzkx0yvZCFgkQaC3AfDvLqWgMuZCHoMkdM5EgXy58TLGDS7a7TZBwLIcA9UV80VeuSHQmSnts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);*/
        //END

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

    public function insert_mercaderia_entregada(Request $request)
    {
        //ALERTA 9.3

        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $request->id,
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

    public function insert_reporte_mercaderia(Request $request)
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

        Tracking::findOrFail($request->id)->update([
            'diferencia' => $request->diferencia,
            'devolucion' => $request->devolucion,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if(($request->diferencia=="1" && $request->devolucion=="1") || $request->diferencia=="1"){
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $request->id,
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
                'id_tracking' => $request->id,
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
        $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [2987]);
        return view('logistica.tracking.cuadre_diferencia', compact('get_id','list_diferencia'));
    }

    public function insert_reporte_diferencia(Request $request)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);
        $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [2987]);

        //ALERTA 9.1. 

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
                                Hola '.$get_id->desde.'-'.$get_id->hacia.', regularizar los sobrantes y/o faltantes indicados.<br><br>
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
                                <a href="'.route('tracking.detalle_operacion_diferencia', $request->id).'" 
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
            return view('logistica.tracking.detalle_operacion_diferencia', compact('get_id'));
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function insert_diferencia_regularizada(Request $request)
    {
        $rules = [
            'guia_diferencia' => 'required|max:20',
        ];
        $messages = [
            'guia_diferencia.required' => 'Debe ingresar Nro. Gr.',
            'guia_diferencia.max' => 'Nro. Gr debe tener como máximo 20 carácteres.',
        ];
        $request->validate($rules, $messages);

        Tracking::findOrFail($request->id)->update([
            'guia_diferencia' => $request->guia_diferencia,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        //ALERTA 9.1.1.

        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

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
                    'id_tracking' => $request->id,
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
                $tracking_dp = TrackingDetalleProceso::create([
                    'id_tracking' => $request->id,
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
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function solicitud_devolucion($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.solicitud_devolucion', compact('get_id'));
    }

    public function insert_reporte_devolucion(Request $request)
    {
        //ALERTA 9.2

        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

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
                                Hola Andrea, se ha encontrado mercadería para devolución. 
                                Nro. Req. + Marca del producto + Estilo + Tipo de falla + Cantidad
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
    }

    public function evaluacion_devolucion($id)
    {
        $get_id = Tracking::get_list_tracking(['id'=>$id]);
        return view('logistica.tracking.evaluacion_devolucion', compact('get_id'));
    }

    public function insert_autorizacion_devolucion(Request $request)
    {
        $rules = [
            'evaluacion' => 'required',
            'explicacion' => 'required',
            'proceder' => 'required',
        ];
        $messages = [
            'evaluacion.required' => 'Debe seleccionar una opción en devolución.',
            'explicacion.required' => 'Debe ingresar explicación.',
            'proceder.required' => 'Debe ingresar como se procederá.',
        ];
        $request->validate($rules, $messages);

        Tracking::findOrFail($request->id)->update([
            'evaluacion' => $request->evaluacion,
            'explicacion' => $request->explicacion,
            'proceder' => $request->proceder,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $get_id = Tracking::get_list_tracking(['id'=>$request->id]);

        if($request->evaluacion=="1"){
            $asunto = "APROBADA";
            $contenido = "autoriza";
        }else{
            $asunto = "DENEGADA";
            $contenido = "deniega";
        }

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

            $mail->Subject = "DEVOLUCIÓN ".$asunto.": RQ. ".$get_id->n_requerimiento." (".$get_id->hacia.")";
        
            $mail->Body =  '<FONT SIZE=3>
                                Hola '.$get_id->hacia.', se '.$contenido.' la devolución para el Nro. Req.<br><br>
                                Explicación:<br>'.$request->explicacion.'<br><br>
                                Proceder:<br>'.$request->proceder.'<br>
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

        //ALERTA 9.2.1.
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
        $tracking_dp = TrackingDetalleProceso::create([
            'id_tracking' => $request->id,
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
}