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

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except('index');
    }

    public function index()
    {
        if (session('usuario')) {
            if(session('redirect_url')){
                session()->forget('redirect_url');
            }
            return view('tracking.index');
        }else{
            session(['redirect_url' => 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function list()
    {
        $list_tracking = Tracking::get_list_tracking();
        return view('tracking.lista', compact('list_tracking'));
    }

    public function create()
    {
        $list_base = Base::get_list_base_tracking();
        return view('tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
        $tracking = new Tracking();
        $tracking->n_requerimiento = $request->n_requerimiento;
        $tracking->n_guia_remision = $request->n_requerimiento;
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
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_salida_mercaderia(Request $request)
    {
        $get_id = Tracking::get_list_tracking($request->id);

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
        $get_id = Tracking::get_list_tracking($id);
        return view('tracking.detalle_transporte', compact('get_id'));
    }

    public function insert_mercaderia_transito(Request $request)
    {
        $tracking = Tracking::findOrfail($request->id);
        $tracking->guia_transporte = $request->guia_transporte;
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
        $get_id = Tracking::get_list_tracking($request->id);

        $tracking_de = new TrackingDetalleEstado();
        $tracking_de->id_detalle = $get_id->id_detalle;
        $tracking_de->id_estado = 6;
        $tracking_de->fecha = now();
        $tracking_de->estado = 1;
        $tracking_de->fec_reg = now();
        $tracking_de->user_reg = session('usuario')->id;
        $tracking_de->fec_act = now();
        $tracking_de->user_act = session('usuario')->id;
        $tracking_de->save();

        //ENVÍO DE CORREO
        $estado_5 = TrackingDetalleEstado::get_list_tracking_detalle_estado($get_id->id_detalle,5);
        $estado_6 = TrackingDetalleEstado::get_list_tracking_detalle_estado($get_id->id_detalle,6);
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

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $get_id->id_detalle;
            $tracking_de->id_estado = 7;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_cierre_inspeccion_fardos(Request $request)
    {
        $get_id = Tracking::get_list_tracking($request->id);

        if($get_id->transporte==2 || ($get_id->transporte==1 && $get_id->importe_transporte>0)){
            $tracking_dp = new TrackingDetalleProceso();
            $tracking_dp->id_tracking = $request->id;
            $tracking_dp->id_proceso = 6;
            $tracking_dp->fecha = now();
            $tracking_dp->estado = 1;
            $tracking_dp->fec_reg = now();
            $tracking_dp->user_reg = session('usuario')->id;
            $tracking_dp->fec_act = now();
            $tracking_dp->user_act = session('usuario')->id;
            $tracking_dp->save();

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $tracking_dp->id;
            $tracking_de->id_estado = 12;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();
        }else{
            if($request->validacion==1){
                $id_detalle = $get_id->id_detalle;
            }else{
                $tracking_dp = new TrackingDetalleProceso();
                $tracking_dp->id_tracking = $request->id;
                $tracking_dp->id_proceso = 4;
                $tracking_dp->fecha = now();
                $tracking_dp->estado = 1;
                $tracking_dp->fec_reg = now();
                $tracking_dp->user_reg = session('usuario')->id;
                $tracking_dp->fec_act = now();
                $tracking_dp->user_act = session('usuario')->id;
                $tracking_dp->save();
                $id_detalle = $tracking_dp->id;
            }

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $id_detalle;
            $tracking_de->id_estado = 9;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();
        }
    }

    public function verificacion_fardos($id)
    {
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(null,2);
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

        $get_id = Tracking::get_list_tracking($id);
        return view('tracking.verificacion_fardos', compact('get_id'));
    }

    public function list_archivo_inspf()
    {
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(null,2);
        return view('tracking.lista_archivo_inspf', compact('list_archivo'));
    }

    public function previsualizacion_captura()
    {
        $valida = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(null,2);

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

                    $dato['archivo'] = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                    ftp_pasv($con_id,true); 
                    $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $tracking_at = new TrackingArchivoTemporal();
                        $tracking_at->id_usuario = session('usuario')->id;
                        $tracking_at->tipo = 2;
                        $tracking_at->archivo = $dato['archivo'];
                        $tracking_at->save();
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
        $get_id = TrackingArchivoTemporal::get_list_tracking_archivo_temporal($id);
        if($get_id->archivo!=""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "TRACKING/".$get_id->nom_archivo;
                if (ftp_delete($con_id, $file_to_delete)) {
                    TrackingArchivoTemporal::where('id', $id)->delete();
                }
            }
        }
    }

    public function insert_reporte_inspeccion_fardo(Request $request)
    {
        $tracking = Tracking::findOrfail($request->id);
        $tracking->observacion_inspf = $request->observacion_inspf;
        $tracking->fec_act = now();
        $tracking->user_act = session('usuario')->id;
        $tracking->save();

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

                $dato['archivo'] = "https://lanumerounocloud.com/intranet/TRACKING/".$nombre;

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"TRACKING/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $tracking_a = new TrackingArchivo();
                    $tracking_a->id_tracking = $request->id;
                    $tracking_a->tipo = 2;
                    $tracking_a->archivo = $dato['archivo'];
                    $tracking_a->save();
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(null,2);

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
                    $dato['archivo'] = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;

                    $tracking_a = new TrackingArchivo();
                    $tracking_a->id_tracking = $request->id;
                    $tracking_a->tipo = 2;
                    $tracking_a->archivo = $dato['archivo'];
                    $tracking_a->save();

                    $i++;
                }
            }
            TrackingArchivoTemporal::where('id_usuario', session('usuario')->id)->where('tipo', 2)->delete();
        }

        $tracking_dp = new TrackingDetalleProceso();
        $tracking_dp->id_tracking = $request->id;
        $tracking_dp->id_proceso = 4;
        $tracking_dp->fecha = now();
        $tracking_dp->estado = 1;
        $tracking_dp->fec_reg = now();
        $tracking_dp->user_reg = session('usuario')->id;
        $tracking_dp->fec_act = now();
        $tracking_dp->user_act = session('usuario')->id;
        $tracking_dp->save();

        //ENVÍO DE CORREO
        $get_id = Tracking::get_list_tracking($request->id);
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

            $tracking_de = new TrackingDetalleEstado();
            $tracking_de->id_detalle = $tracking_dp->id;
            $tracking_de->id_estado = 8;
            $tracking_de->fecha = now();
            $tracking_de->estado = 1;
            $tracking_de->fec_reg = now();
            $tracking_de->user_reg = session('usuario')->id;
            $tracking_de->fec_act = now();
            $tracking_de->user_act = session('usuario')->id;
            $tracking_de->save();
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}