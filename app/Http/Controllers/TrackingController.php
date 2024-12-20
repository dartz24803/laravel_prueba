<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anio;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Tracking;
use App\Models\Base;
use App\Models\BaseActiva;
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
use App\Models\TrackingProceso;
use App\Models\TrackingTransporte;
use App\Models\TrackingTransporteArchivo;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
            'list_mercaderia_nueva_app_new',
            'insert_mercaderia_nueva_app',
            'list_surtido_mercaderia_nueva',
            'insert_requerimiento_reposicion_app',
            'insert_requerimiento_reposicion_estilo_app',
            'list_requerimiento_reposicion_app',
            'list_requerimiento_reposicion_app_new',
            'update_requerimiento_reposicion_app',
            'delete_mercaderia_surtida_app',
            'list_mercaderia_nueva_vendedor_app',
            'list_requerimiento_reposicion_vendedor_app'
        ]);
    }

    public function list_notificacion(Request $request)
    {
        if ($request->id_tracking) {
            try {
                $query = TrackingNotificacion::select('titulo', 'contenido', 'fecha')
                    ->where('id_tracking', $request->id_tracking)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            return response()->json($query, 200);
        } elseif ($request->cod_base) {
            try {
                if ($request->cod_base == "OFI") {
                    $query = TrackingNotificacion::from('tracking_notificacion AS tn')
                        ->select(
                            'tn.id_tracking',
                            DB::raw("CONCAT(tr.n_requerimiento,' - ',ba.cod_base) AS n_requerimiento")
                        )
                        ->join('tracking AS tr', function ($join) {
                            $join->on('tr.id', '=', 'tn.id_tracking')
                                ->where('tr.estado', 1);
                        })
                        ->join('base AS ba', 'ba.id_base', '=', 'tr.id_origen_hacia')
                        ->groupBy('tn.id_tracking')->get();
                } else {
                    $query = TrackingNotificacion::from('tracking_notificacion AS tn')
                        ->select('tn.id_tracking', 'tr.n_requerimiento')
                        ->join('tracking AS tr', function ($join) {
                            $join->on('tr.id', '=', 'tn.id_tracking')
                                ->where('tr.estado', 1);
                        })
                        ->join('base AS ba', 'ba.id_base', '=', 'tr.id_origen_hacia')
                        ->where('ba.cod_base', $request->cod_base)
                        ->groupBy('tn.id_tracking')->get();
                }
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            return response()->json($query, 200);
        } else {
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
        $headers = array("Authorization: Bearer " . $accessToken, "content-type: application/json;UTF-8");

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
    }

    public function insert_notificacion($dato)
    {
        $valida = TrackingNotificacion::where('id_tracking', $dato['id_tracking'])
            ->where('titulo', $dato['titulo'])->exists();

        if (!$valida) {
            TrackingNotificacion::create([
                'id_tracking' => $dato['id_tracking'],
                'titulo' => $dato['titulo'],
                'contenido' => $dato['contenido'],
                'fecha' => now()
            ]);
        }
    }

    public function iniciar_tracking()
    {
        /*TrackingTemporal::truncate();
        $list_tracking = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?', ['T']);
        foreach($list_tracking as $list){
            if($list->id_origen_hacia=="4" || $list->id_origen_hacia=="6" || $list->id_origen_hacia=="10"){
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
        }
        DB::statement('CALL insert_tracking()');

        $list_tracking = Tracking::from('tracking AS tr')
                        ->select('tr.id','tr.n_requerimiento','tr.n_guia_remision',
                        'tr.semana',DB::raw('base.cod_base AS hacia'),'distrito.nombre_distrito')
                        ->join('base','base.id_base','=','tr.id_origen_hacia')
                        ->leftjoin('distrito','distrito.id_distrito','=','base.id_distrito')
                        ->where('tr.iniciar',0)->take(1)->get();

        foreach($list_tracking as $get_id){
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $get_id->id,
                'id_proceso' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
    
            ALERTA 1
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach($list_token as $token){
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA POR SALIR',
                    'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'MERCADERÍA POR SALIR',
                'contenido' => 'Hola '.$get_id->hacia.' tu requerimiento n° '.$get_id->n_requerimiento.' está listo',
            ];
            $this->insert_notificacion($dato);

            TrackingDetalleEstado::create([
                'id_detalle' => $tracking_dp->id,
                'id_estado' => 1,
                'fecha' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'fec_act' => now(),
            ]);
    
            MENSAJE 1
            $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R',$get_id->n_requerimiento]);

            GENERACIÓN DE EXCEL
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Guía remisión');
    
            $sheet->setAutoFilter('A1:F1');
    
            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(100);
            $sheet->getColumnDimension('F')->setWidth(15);
    
            $sheet->getStyle('A1:F1')->getFont()->setBold(true);
    
            $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('C8C8C8');
    
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
    
            $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);
    
            $sheet->setCellValue("A1", 'SKU');
            $sheet->setCellValue("B1", 'Color');
            $sheet->setCellValue("C1", 'Estilo');
            $sheet->setCellValue("D1", 'Talla');
            $sheet->setCellValue("E1", 'Descripción');
            $sheet->setCellValue("F1", 'Cantidad');

            $contador = 1;

            foreach ($list_detalle as $list) {
                $contador++;
    
                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);
    
                $sheet->setCellValue("A{$contador}", $list->sku);
                $sheet->setCellValue("B{$contador}", $list->color);
                $sheet->setCellValue("C{$contador}", $list->estilo);
                $sheet->setCellValue("D{$contador}", $list->talla);
                $sheet->setCellValue("E{$contador}", $list->descripcion);
                $sheet->setCellValue("F{$contador}", $list->cantidad);
            }

            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $excelContent = ob_get_clean();

            /*$mpdf = new Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial'
            ]);
            $html = view('logistica.tracking.tracking.pdf', compact('get_id','list_detalle'))->render();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);*/

        /*$mail = new PHPMailer(true);

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
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD',$get_id->hacia]);
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

                $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "MPS-SEM".$get_id->semana."-".substr(date('Y'),-2)." RQ-".$get_id->n_requerimiento." (".$get_id->hacia.") - PRUEBA";
            
                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> '.$get_id->semana.'<br>
                                    <b>Nro. Req.:</b> '.$get_id->n_requerimiento.'<br>
                                    <b>Base:</b> '.$get_id->hacia.'<br>
                                    <b>Distrito:</b> '.$get_id->nombre_distrito.'<br>
                                    <b>Fecha - Mercadería por salir:</b> '.$fecha_formateada.'<br><br>
                                    Buen día '.$get_id->hacia.'.<br><br>
                                    Se envia el reporte de mercadería por salir del requerimiento '.$get_id->n_requerimiento.'.<br><br>
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
                $mail->addStringAttachment($excelContent, 'Guia_Remision.xlsx', 'base64', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $mail->send();

                TrackingDetalleEstado::create([
                    'id_detalle' => $tracking_dp->id,
                    'id_estado' => 2,
                    'fecha' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now()
                ]);
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }

            Tracking::findOrFail($get_id->id)->update([
                'iniciar' => 1,
                'fec_act' => now()
            ]);
        }*/
    }

    public function llegada_tienda()
    {
        $list_tracking = Tracking::get_list_tracking(['llegada_tienda' => 1]);

        foreach ($list_tracking as $get_id) {
            //ALERTA 3
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'LLEGADA A TIENDA',
                    'contenido' => 'Hola ' . $get_id->hacia . ' confirma que tu mercadería haya llegado a tienda',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'LLEGADA A TIENDA',
                'contenido' => 'Hola ' . $get_id->hacia . ' confirma que tu mercadería haya llegado a tienda',
            ];
            $this->insert_notificacion($dato);

            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $get_id->id,
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

    public function index()
    {
        if (session('usuario')) {
            if (session('redirect_url')) {
                session()->forget('redirect_url');
            }
            //NOTIFICACIONES
            $list_notificacion = Notificacion::get_list_notificacion();
            $list_subgerencia = SubGerencia::list_subgerencia(7);
            return view('logistica.tracking.index', compact('list_notificacion', 'list_subgerencia'));
        } else {
            session(['redirect_url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function index_tra()
    {
        //$list_mercaderia_nueva = MercaderiaSurtida::where('anio',date('Y'))->where('semana',date('W'))->exists();
        return view('logistica.tracking.tracking.index'/*, compact('list_mercaderia_nueva')*/);
    }

    public function list()
    {
        $list_tracking = Tracking::get_list_tracking();
        $estado = TrackingEstado::get_list_estado_proceso();
        return view('logistica.tracking.tracking.lista', compact(
            'list_tracking',
            'estado'
        ));
    }

    //FORMA MANUAL
    public function create()
    {
        $list_base = Base::get_list_base_tracking();
        return view('logistica.tracking.tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
        $valida = Tracking::where('n_requerimiento', $request->n_requerimiento)
            ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            $tracking = Tracking::create([
                'n_requerimiento' => $request->n_requerimiento,
                'n_guia_remision' => $request->n_requerimiento,
                'semana' => $request->semana,
                'id_origen_desde' => $request->id_origen_desde,
                'id_origen_hacia' => $request->id_origen_hacia,
                'iniciar' => 1,
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
            $get_id = Tracking::get_list_tracking(['id' => $tracking->id]);

            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA POR SALIR',
                    'contenido' => 'Hola ' . $get_id->hacia . ' tu requerimiento n° ' . $get_id->n_requerimiento . ' está listo',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'MERCADERÍA POR SALIR',
                'contenido' => 'Hola ' . $get_id->hacia . ' tu requerimiento n° ' . $get_id->n_requerimiento . ' está listo',
            ];
            $this->insert_notificacion($dato);

            //MENSAJE 1
            $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R', $get_id->n_requerimiento]);

            //GENERACIÓN DE EXCEL
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Lectura Servicio');

            $sheet->setAutoFilter('A1:F1');

            $sheet->getColumnDimension('A')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(25);
            $sheet->getColumnDimension('C')->setWidth(25);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(100);
            $sheet->getColumnDimension('F')->setWidth(15);

            $sheet->getStyle('A1:F1')->getFont()->setBold(true);

            $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('C8C8C8');

            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A1", 'SKU');
            $sheet->setCellValue("B1", 'Color');
            $sheet->setCellValue("C1", 'Estilo');
            $sheet->setCellValue("D1", 'Talla');
            $sheet->setCellValue("E1", 'Descripción');
            $sheet->setCellValue("F1", 'Cantidad');

            $contador = 1;

            foreach ($list_detalle as $list) {
                $contador++;

                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", $list->sku);
                $sheet->setCellValue("B{$contador}", $list->color);
                $sheet->setCellValue("C{$contador}", $list->estilo);
                $sheet->setCellValue("D{$contador}", $list->talla);
                $sheet->setCellValue("E{$contador}", $list->descripcion);
                $sheet->setCellValue("F{$contador}", $list->cantidad);
            }

            $writer = new Xlsx($spreadsheet);
            ob_start();
            $writer->save('php://output');
            $excelContent = ob_get_clean();

            /*$mpdf = new Mpdf([
                'format' => 'A4',
                'default_font' => 'Arial'
            ]);
            $html = view('logistica.tracking.tracking.pdf', compact('get_id','list_detalle'))->render();
            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('', \Mpdf\Output\Destination::STRING_RETURN);*/

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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                $mail->addAddress('dpalomino@lanumero1.com.pe');
                //$mail->addAddress('ogutierrez@lanumero1.com.pe');
                //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');

                $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "MPS-SEM" . $get_id->semana . "-" . substr(date('Y'), -2) . " RQ-" . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> ' . $get_id->semana . '<br>
                                    <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                    <b>Base:</b> ' . $get_id->hacia . '<br>
                                    <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                    <b>Fecha - Mercadería por salir:</b> ' . $fecha_formateada . '<br><br>
                                    Buen día ' . $get_id->hacia . '.<br><br>
                                    Se envia el reporte de mercadería por salir del requerimiento ' . $get_id->n_requerimiento . '.<br><br>
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
                foreach ($list_detalle as $list) {
                    $mail->Body .=  '            <tr align="left">
                                                <td align="center">' . $list->sku . '</td>
                                                <td>' . $list->color . '</td>
                                                <td>' . $list->estilo . '</td>
                                                <td>' . $list->talla . '</td>
                                                <td>' . $list->descripcion . '</td>
                                                <td align="center">' . $list->cantidad . '</td>
                                            </tr>';
                }
                $mail->Body .=  '        </tbody>
                                    </table>
                                </FONT SIZE>';

                $mail->CharSet = 'UTF-8';
                //$mail->addStringAttachment($pdfContent, 'Guia_Remision.pdf');
                $mail->addStringAttachment($excelContent, 'Guia_Remision.xlsx', 'base64', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
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
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }
    //END FORMA MANUAL

    public function detalle_transporte_inicial()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $list_base = Base::get_list_bases_tienda();
        return view('logistica.tracking.tracking.detalle_transporte_inicial', compact(
            'list_notificacion',
            'list_subgerencia',
            'list_base'
        ));
    }

    public function insert_detalle_transporte_inicial(Request $request)
    {
        $request->validate([
            'id_base' => 'gt:0',
            'tiempo_llegada' => 'required',
            'recepcion' => 'gt:0',
            'receptor' => 'required',
            'nombre_transporte' => 'required_if:transporte,1,2',
            'guia_transporte' => 'required_if:tipo_pago,1',
            'importe_transporte' => 'required_if:tipo_pago,1',
            'factura_transporte' => 'required_if:tipo_pago,1',
            'archivo_transporte' => 'required_if:tipo_pago,1'
        ], [
            'id_base.gt' => 'Debe seleccionar base.',
            'tiempo_llegada.required' => 'Debe ingresar tiempo de llegada',
            'recepcion.gt' => 'Debe seleccionar recepción.',
            'receptor.required' => 'Debe ingresar receptor.',
            'nombre_transporte.required_if' => 'Debe ingresar nombre de empresa.',
            'guia_transporte.required_if' => 'Debe ingresar nro. gr transporte..',
            'importe_transporte.required_if' => 'Debe ingresar importe a pagar.',
            'factura_transporte.required_if' => 'Debe ingresar n° factura.',
            'archivo_transporte.required_if' => 'Debe ingresar PDF de factura.'
        ]);

        $errors = [];
        if ($request->tipo_pago == "1" && $request->importe_transporte == "0") {
            $errors['importe_transporte'] = ['Debe ingresar importe a pagar mayor a 0.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $valida = TrackingTransporte::where('id_base', $request->id_base)->where('anio', date('Y'))
            ->where('semana', date('W'))->exists();
        if ($valida) {
            echo "error";
        } else {
            if ($request->transporte == "3") {
                $tipo_pago = 0;
            } else {
                $tipo_pago = $request->tipo_pago;
            }

            $tracking_transporte = TrackingTransporte::create([
                'id_base' => $request->id_base,
                'anio' => date('Y'),
                'semana' => date('W'),
                'transporte' => $request->transporte,
                'tiempo_llegada' => $request->tiempo_llegada,
                'recepcion' => $request->recepcion,
                'receptor' => $request->receptor,
                'tipo_pago' => $tipo_pago,
                'nombre_transporte' => $request->nombre_transporte,
                'guia_transporte' => $request->guia_transporte,
                'importe_transporte' => $request->importe_transporte,
                'factura_transporte' => $request->factura_transporte,
                'fecha' => now(),
                'usuario' => session('usuario')->id_usuario
            ]);

            $archivo = "";
            if ($_FILES["archivo_transporte"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["archivo_transporte"]["name"];
                    $source_file = $_FILES['archivo_transporte']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Factura_" . $request->id_base . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingTransporteArchivo::create([
                            'id_tracking_transporte' => $tracking_transporte->id,
                            'archivo' => $archivo
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        }
    }

    public function modal_guia_transporte()
    {
        if (
            session('usuario')->id_puesto == 76 ||
            session('usuario')->id_puesto == 97 ||
            session('usuario')->id_nivel == 1
        ) {
            $list_base = Base::get_list_bases_tienda();
        } else {
            $list_base = Base::where('cod_base', session('usuario')->centro_labores)->where('estado', 1)
                ->get();
        }
        return view('logistica.tracking.tracking.modal_guia_transporte', compact('list_base'));
    }

    public function traer_guia_transporte(Request $request)
    {
        $get_id = TrackingTransporte::where('id_base', $request->id_base)
            ->where('anio', date('Y'))->where('semana', $request->semana)->first();
        if (isset($get_id->guia_remision)) {
            echo '<a href="' . $get_id->guia_remision . '" title="Guía de remisión" target="_blank">
                <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                    <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                    <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                    <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                    <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                    <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                </svg>
            </a>';
        } else {
            echo "";
        }
    }

    public function insert_guia_transporte(Request $request)
    {
        $request->validate([
            'id_base' => 'gt:0',
            'semana' => 'gt:0',
            'guia_remision' => 'required'
        ], [
            'id_base.gt' => 'Debe seleccionar base.',
            'semana.gt' => 'Debe seleccionar semana.',
            'guia_remision.required' => 'Debe adjuntar guía de remisión.'
        ]);

        $get_id = TrackingTransporte::where('id_base', $request->id_base)->where('anio', date('Y'))
            ->where('semana', $request->semana)->first();
        if (isset($get_id->id)) {
            if ($_FILES["guia_remision"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if ($get_id->guia_remision != "") {
                        ftp_delete($con_id, "TRACKING/" . basename($get_id->guia_remision));
                    }

                    $path = $_FILES["guia_remision"]["name"];
                    $source_file = $_FILES['guia_remision']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "GR_Transporte_" . $request->id_base . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingTransporte::findOrFail($get_id->id)->update([
                            'guia_remision' => $archivo,
                            'fecha' => now(),
                            'usuario' => session('usuario')->id_usuario
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        } else {
            echo "error";
        }
    }

    public function pago_transporte_general()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        if (
            session('usuario')->id_puesto == 30 ||
            session('usuario')->id_puesto == 31 ||
            session('usuario')->id_puesto == 32 ||
            session('usuario')->id_puesto == 33 ||
            session('usuario')->id_puesto == 35 ||
            session('usuario')->id_puesto == 161 ||
            session('usuario')->id_puesto == 167 ||
            session('usuario')->id_puesto == 168 ||
            session('usuario')->id_puesto == 311 ||
            session('usuario')->id_puesto == 314
        ) {
            $list_base = Base::where('cod_base', session('usuario')->centro_labores)->where('estado', 1)
                ->get();
        } else {
            $list_base = Base::get_list_bases_tienda();
        }
        return view('logistica.tracking.tracking.pago_transporte_general', compact(
            'list_notificacion',
            'list_subgerencia',
            'list_base'
        ));
    }

    public function traer_pago_general(Request $request)
    {
        $get_id = TrackingTransporte::where('id_base', $request->id_base)
            ->where('anio', date('Y'))->where('semana', $request->semana)->first();
        if (isset($get_id->id)) {
            if ($get_id->guia_remision == "") {
                echo "guia_remision";
            } elseif ($get_id->factura_transporte != "") {
                echo "factura";
            } else {
                return view('logistica.tracking.tracking.detalle_pago_transporte_general', compact(
                    'get_id'
                ));
            }
        } else {
            echo "sin_data";
        }
    }

    public function insert_confirmacion_pago_transporte_general(Request $request, $id)
    {
        $request->validate([
            'nombre_transporte' => 'required',
            'guia_transporte' => 'required',
            'importe_transporte' => 'required|gt:0',
            'factura_transporte' => 'required'
        ], [
            'nombre_transporte.required' => 'Debe ingresar nombre de empresa.',
            'guia_transporte.required' => 'Debe ingresar nro. GR transporte.',
            'importe_transporte.required' => 'Debe ingresar importe a pagar.',
            'importe_transporte.gt' => 'Debe ingresar importe a pagar mayor a 0.',
            'factura_transporte.required' => 'Debe ingresar n° de factura.'
        ]);

        $errors = [];
        if ($_FILES["archivo_transporte"]["name"] == "" && $request->captura == "0") {
            $errors['archivo'] = ['Debe adjuntar o capturar con la cámara la factura.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        if ($_FILES["archivo_transporte"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_" . $id . "_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                    TrackingTransporteArchivo::create([
                        'id_tracking_transporte' => $id,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        if ($request->captura == "1") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $nombre_actual = "TRACKING/temporal_pm_" . session('usuario')->id_usuario . ".jpg";
                $nuevo_nombre = "TRACKING/Factura_" . $id . "_" . date('YmdHis') . "_captura.jpg";
                ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                TrackingTransporteArchivo::create([
                    'id_tracking_transporte' => $id,
                    'archivo' => $archivo
                ]);
            } else {
                echo "No se conecto";
            }
        }

        TrackingTransporte::findOrFail($id)->update([
            'nombre_transporte' => $request->nombre_transporte,
            'guia_transporte' => $request->guia_transporte,
            'importe_transporte' => $request->importe_transporte,
            'factura_transporte' => $request->factura_transporte,
            'fecha' => now(),
            'usuario' => session('usuario')->id_usuario
        ]);

        $get_id = TrackingTransporte::select(
            '*',
            DB::raw("CASE WHEN transporte='1'
                THEN 'Agencia - Terrestre'
                WHEN transporte='2' THEN 'Agencia - Aérea' 
                WHEN transporte='3' THEN 'Propio' ELSE '' END AS tipo_transporte"),
            DB::raw("CASE WHEN recepcion=1 THEN 'Agencia' 
                WHEN recepcion=2 THEN 'Domicilio' ELSE '' END AS recepcion"),
            DB::raw("CASE WHEN tipo_pago=1 THEN 'Si pago' WHEN tipo_pago=2 THEN 'Por pagar' 
                ELSE '' END AS nom_tipo_pago"),
            DB::raw('IFNULL(importe_transporte,0) AS importe_formateado')
        )
            ->where('id', $id)->first();
        $list_tracking = Tracking::select('id')->where('id_origen_hacia', $get_id->id_base)
            ->where(DB::raw('YEAR(fec_reg)'), $get_id->anio)
            ->where('semana', $get_id->semana)->where('estado', 1)->get();
        $list_archivo = TrackingTransporteArchivo::where('id_tracking_transporte', $id)->get();

        foreach ($list_tracking as $tracking) {
            $tracking = Tracking::get_list_tracking(['id' => $tracking->id]);
            $tracking_dp = TrackingDetalleProceso::create([
                'id_tracking' => $tracking->id,
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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                //$mail->addAddress('ogutierrez@lanumero1.com.pe');
                //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD', $get_id->hacia]);
                foreach ($list_td as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
                foreach ($list_cd as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
                foreach ($list_cc as $list) {
                    $mail->addCC($list->emailp);
                }

                $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "MERCADERÍA PAGADA: RQ. " . $tracking->n_requerimiento . " (" . $tracking->hacia . ") - PRUEBA";

                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> ' . $tracking->semana . '<br>
                                    <b>Nro. Req.:</b> ' . $tracking->n_requerimiento . '<br>
                                    <b>Base:</b> ' . $tracking->hacia . '<br>
                                    <b>Distrito:</b> ' . $tracking->nombre_distrito . '<br>
                                    <b>Fecha - Mercadería pagada:</b> ' . $fecha_formateada . '<br><br>
                                    Hola ' . $tracking->desde . ', se ha pagado a la agencia.<br>
                                    Envío el reporte de la salida de mercadería <b>(completo)</b>.<br><br>
                                    <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">     
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Despacho</td>
                                            <td style="text-align:right;">SEM-' . $tracking->semana . '-' . substr(date('Y'), -2) . '</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2" style="font-weight:bold;">Guía Remisión</td>
                                            <td style="font-weight:bold;">Nuestra</td>
                                            <td style="text-align:right;">' . $tracking->n_guia_remision . '</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Transporte.</td>
                                            <td style="text-align:right;">' . $get_id->guia_transporte . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Tipo de transporte</td>
                                            <td style="text-align:right;">' . $get_id->tipo_transporte . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Nombre de transporte</td>
                                            <td style="text-align:right;">' . $get_id->nombre_transporte . '</td>
                                        </tr>                                    
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">N° Factura</td>
                                            <td style="text-align:right;">' . $get_id->factura_transporte . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Peso</td>
                                            <td style="text-align:right;">' . $tracking->peso . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Paquetes</td>
                                            <td style="text-align:right;">' . $tracking->paquetes . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Sobres</td>
                                            <td style="text-align:right;">' . $tracking->sobres . '</td>
                                        </tr>          
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Fardos</td>
                                            <td style="text-align:right;">' . $tracking->fardos . '</td>
                                        </tr>           
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Caja</td>
                                            <td style="text-align:right;">' . $tracking->caja . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Bultos</td>
                                            <td style="text-align:right;">' . $tracking->bultos . '</td>
                                        </tr>                                 
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Recepción</td>
                                            <td style="text-align:right;">' . $get_id->recepcion . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Mercadería total</td>
                                            <td style="text-align:right;">' . $tracking->mercaderia_total . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Flete por prenda</td>
                                            <td style="text-align:right;">S/' . $tracking->flete_prenda_formateado . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Receptor</td>
                                            <td style="text-align:right;">' . $get_id->receptor . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Tipo pago</td>
                                            <td style="text-align:right;">' . $get_id->nom_tipo_pago . '</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" style="font-weight:bold;">Importe Pagado</td>
                                            <td style="text-align:right;">S/' . $get_id->importe_formateado . '</td>
                                        </tr>
                                        <tr>
                                            <td rowspan="3" style="font-weight:bold;">Fecha</td>
                                            <td style="font-weight:bold;">Partida</td>
                                            <td style="text-align:right;">' . $tracking->fecha_partida . '</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Tiempo estimado de llegada</td>
                                            <td style="text-align:right;">' . $get_id->tiempo_llegada . '</td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight:bold;">Llegada</td>
                                            <td style="text-align:right;">' . $tracking->fecha_llegada . '</td>
                                        </tr>
                                    </table>
                                </FONT SIZE>';

                $mail->CharSet = 'UTF-8';
                foreach ($list_archivo as $list) {
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
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }

    public function detalle_transporte($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        return view('logistica.tracking.tracking.detalle_transporte', compact('list_notificacion', 'list_subgerencia', 'get_id'));
    }

    public function insert_detalle_transporte(Request $request, $id)
    {
        $request->validate([
            'peso' => 'required',
            'paquetes' => 'required_without_all:sobres,fardos,caja|nullable',
            'sobres' => 'required_without_all:paquetes,fardos,caja|nullable',
            'fardos' => 'required_without_all:paquetes,sobres,caja|nullable',
            'caja' => 'required_without_all:paquetes,sobres,fardos|nullable',
            'mercaderia_total' => 'required|gt:0'
        ], [
            'peso.required' => 'Debe ingresar peso.',
            'required_without_all' => 'Debe ingresar paquetes o sobres o fardos o caja.',
            'mercaderia_total.required' => 'Debe ingresar mercadería total.',
            'mercaderia_total.gt' => 'Debe ingresar mercadería total mayor a 0.'
        ]);

        $get_id = Tracking::get_list_tracking(['id' => $id]);
        $get_transporte = TrackingTransporte::select(
            '*',
            DB::raw("CASE WHEN transporte='1'
                        THEN 'Agencia - Terrestre'
                        WHEN transporte='2' THEN 'Agencia - Aérea' 
                        WHEN transporte='3' THEN 'Propio' ELSE '' END AS tipo_transporte"),
            DB::raw("CASE WHEN recepcion=1 THEN 'Agencia' 
                        WHEN recepcion=2 THEN 'Domicilio' ELSE '' END AS recepcion"),
            DB::raw("CASE WHEN tipo_pago=1 THEN 'Si pago' WHEN tipo_pago=2 THEN 'Por pagar' 
                        ELSE '' END AS nom_tipo_pago"),
            DB::raw('IFNULL(importe_transporte,0) AS importe_formateado')
        )
            ->where('id_base', $get_id->id_origen_hacia)
            ->where('anio', $get_id->anio)->where('semana', $get_id->semana)->first();

        /*$errors = [];
        if ($get_transporte->tipo_pago=="1" && $request->guia_transporte=="") {
            $errors['guia_transporte'] = ['Debe ingresar nro. gr transporte.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }*/

        Tracking::findOrFail($id)->update([
            //'guia_transporte' => $request->guia_transporte,
            'peso' => $request->peso,
            'paquetes' => $request->paquetes,
            'sobres' => $request->sobres,
            'fardos' => $request->fardos,
            'caja' => $request->caja,
            /*'transporte' => $get_transporte->transporte,
            'tiempo_llegada' => $get_transporte->tiempo_llegada,
            'recepcion' => $get_transporte->recepcion,*/
            'mercaderia_total' => $request->mercaderia_total,
            /*'receptor' => $get_transporte->receptor,
            'tipo_pago' => $get_transporte->tipo_pago,
            'nombre_transporte' => $get_transporte->nombre_transporte,
            'importe_transporte' => $get_transporte->importe_transporte,
            'factura_transporte' => $get_transporte->factura_transporte,*/
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if ($request->comentario) {
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'DETALLE_TRANSPORTE',
                'comentario' => $request->comentario
            ]);
        }

        /*if($get_transporte->archivo_transporte != ""){
            TrackingArchivo::create([
                'id_tracking' => $id,
                'tipo' => 1,
                'archivo' => $get_transporte->archivo_transporte
            ]);
        }*/

        //MENSAJE 2
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        $t_comentario = TrackingComentario::where('id_tracking', $id)->where('pantalla', 'DETALLE_TRANSPORTE')->first();
        //$list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();

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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            //$mail->addAddress('ogutierrez@lanumero1.com.pe');
            //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD', $get_id->hacia]);
            foreach ($list_td as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
            foreach ($list_cd as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
            foreach ($list_cc as $list) {
                $mail->addCC($list->emailp);
            }

            $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $fecha_partida =  date('d') . " de " . date('F') . " del " . date('Y');
            $fecha_partida = str_replace($meses_ingles, $meses_espanol, $fecha_partida);

            $mail->isHTML(true);

            $mail->Subject = "SDM-SEM" . $get_id->semana . "-" . substr(date('Y'), -2) . " RQ-" . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> ' . $get_id->semana . '<br>
                                <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                <b>Base:</b> ' . $get_id->hacia . '<br>
                                <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                <b>Fecha - Salida de mercadería:</b> ' . $fecha_formateada . '<br><br>
                                Envío el reporte de la salida de mercadería. La guías electrónicas ya se encuentran en su carpeta.<br><br>
                                <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">     
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Despacho</td>
                                        <td style="text-align:right;">SEM-' . $get_id->semana . '-' . substr(date('Y'), -2) . '</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="font-weight:bold;">Guía Remisión</td>
                                        <td style="font-weight:bold;">Nuestra</td>
                                        <td style="text-align:right;">' . $get_id->n_guia_remision . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Transporte.</td>
                                        <td style="text-align:right;">' . $get_transporte->guia_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Tipo de transporte</td>
                                        <td style="text-align:right;">' . $get_transporte->tipo_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Nombre de transporte</td>
                                        <td style="text-align:right;">' . $get_transporte->nombre_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">N° Factura</td>
                                        <td style="text-align:right;">' . $get_transporte->factura_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Peso</td>
                                        <td style="text-align:right;">' . $get_id->peso . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Paquetes</td>
                                        <td style="text-align:right;">' . $get_id->paquetes . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Sobres</td>
                                        <td style="text-align:right;">' . $get_id->sobres . '</td>
                                    </tr>          
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Fardos</td>
                                        <td style="text-align:right;">' . $get_id->fardos . '</td>
                                    </tr>           
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Caja</td>
                                        <td style="text-align:right;">' . $get_id->caja . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Bultos</td>
                                        <td style="text-align:right;">' . $get_id->bultos . '</td>
                                    </tr>                                 
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Recepción</td>
                                        <td style="text-align:right;">' . $get_transporte->recepcion . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Mercadería total</td>
                                        <td style="text-align:right;">' . $get_id->mercaderia_total . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Flete por prenda</td>
                                        <td style="text-align:right;">S/' . $get_id->flete_prenda_formateado . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Receptor</td>
                                        <td style="text-align:right;">' . $get_transporte->receptor . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Tipo pago</td>
                                        <td style="text-align:right;">' . $get_transporte->nom_tipo_pago . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Importe Pagado</td>
                                        <td style="text-align:right;">S/' . $get_transporte->importe_formateado . '</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="font-weight:bold;">Fecha</td>
                                        <td style="font-weight:bold;">Partida</td>
                                        <td style="text-align:right;">' . $fecha_partida . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Tiempo estimado de llegada</td>
                                        <td style="text-align:right;">' . $get_transporte->tiempo_llegada . '</td>
                                    </tr>                                  
                                </table><br>';
            if ($t_comentario) {
                $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
                            </FONT SIZE>';
            }

            $mail->CharSet = 'UTF-8';
            /*foreach($list_archivo as $list){
                $archivo_contenido = file_get_contents($list->archivo);
                $nombre_archivo = basename($list->archivo);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }*/
            if ($get_transporte->archivo_transporte != "") {
                $archivo_contenido = file_get_contents($get_transporte->archivo_transporte);
                $nombre_archivo = basename($get_transporte->archivo_transporte);
                $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
            }
            $mail->send();

            //SALIDA DE MERCADERÍA
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

            //MERCADERÍA EN TRÁNSITO
            $list_token = TrackingToken::whereIn('base', [$get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'SALIDA DE MERCADERÍA',
                    'contenido' => 'Hola ' . $get_id->hacia . ' tu requerimiento n° ' . $get_id->n_requerimiento . ' está en camino',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'SALIDA DE MERCADERÍA',
                'contenido' => 'Hola ' . $get_id->hacia . ' tu requerimiento n° ' . $get_id->n_requerimiento . ' está en camino',
            ];
            $this->insert_notificacion($dato);

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
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_confirmacion_llegada(Request $request, $id)
    {
        //ALERTA 4
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach ($list_token as $token) {
            $dato = [
                'token' => $token->token,
                'titulo' => 'CONFIRMACIÓN DE LLEGADA',
                'contenido' => 'Hola ' . $get_id->desde . ', se ha confirmado que la mercadería llegó a tienda',
            ];
            $this->sendNotification($dato);
        }
        $dato = [
            'id_tracking' => $get_id->id,
            'titulo' => 'CONFIRMACIÓN DE LLEGADA',
            'contenido' => 'Hola ' . $get_id->desde . ', se ha confirmado que la mercadería llegó a tienda',
        ];
        $this->insert_notificacion($dato);

        if ($get_id->id_estado == "4") {
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
        } else {
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

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R', $get_id->n_requerimiento]);
        foreach ($list_detalle as $list) {
            TrackingGuiaRemisionDetalle::create([
                'n_requerimiento' => $get_id->n_requerimiento,
                'n_guia_remision' => $list->n_guia_remision,
                'sku' => $list->sku,
                'color' => $list->color,
                'estilo' => $list->estilo,
                'talla' => $list->talla,
                'descripcion' => $list->descripcion,
                'cantidad' => $list->cantidad,
            ]);
        }
    }

    public function insert_cierre_inspeccion_fardos(Request $request, $id)
    {
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        if ($get_id->transporte == "3" || $get_id->tipo_pago == "1") {
            //ALERTA 5 (SI)
            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                    'contenido' => 'Hola ' . $get_id->desde . ', se ha dado el cierre a la inspección de fardos',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                'contenido' => 'Hola ' . $get_id->desde . ', se ha dado el cierre a la inspección de fardos',
            ];
            $this->insert_notificacion($dato);

            //ALERTA 7
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'INSPECCION DE MERCADERÍA',
                    'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'INSPECCION DE MERCADERÍA',
                'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
            ];
            $this->insert_notificacion($dato);

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
        } else {
            if ($request->validacion == 1) {
                $id_detalle = $get_id->id_detalle;
                $contenido_mensaje = 'Hola ' . $get_id->hacia . ', se ha dado el cierre a las irregularidades de los fardos';
            } else {
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
                $contenido_mensaje = 'Hola ' . $get_id->desde . ', se ha dado el cierre a la inspección de fardos';
            }

            //ALERTA 5 (SI) o (NO)
            if ($request->validacion == 1) {
                $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            } else {
                $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            }
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                    'contenido' => $contenido_mensaje,
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $get_id->id,
                'titulo' => 'CIERRE DE INSPECCIÓN DE FARDOS',
                'contenido' => $contenido_mensaje,
            ];
            $this->insert_notificacion($dato);

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

            //EVITAR EL PROCESO DE PAGO
            //ALERTA 7
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'INSPECCION DE MERCADERÍA',
                    'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'INSPECCION DE MERCADERÍA',
                'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
            ];
            $this->insert_notificacion($dato);

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
        }
    }

    public function verificacion_fardos($id)
    {
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo' => 2]);
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "TRACKING/" . $list->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        return view('logistica.tracking.tracking.verificacion_fardos', compact('list_notificacion', 'list_subgerencia', 'get_id'));
    }

    public function list_archivo(Request $request)
    {
        if ($request->tipo == "5") {
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id_producto' => $request->id_producto]);
        } else {
            $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo' => $request->tipo]);
        }
        return view('logistica.tracking.tracking.lista_archivo', compact('list_archivo'));
    }

    public function previsualizacion_captura(Request $request)
    {
        if ($request->id_producto) {
            $valida = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id_producto' => $request->id_producto]);
        } else {
            $valida = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo' => $request->tipo]);
        }

        if (count($valida) == 3) {
            echo "error";
        } else {
            if ($_FILES["photo"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["photo"]["name"];
                    $source_file = $_FILES['photo']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "temporal_" . session('usuario')->id_usuario . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        if ($request->tipo == "5") {
                            TrackingArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'tipo' => $request->tipo,
                                'id_producto' => $request->id_producto,
                                'archivo' => $archivo
                            ]);
                        } else {
                            TrackingArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'tipo' => $request->tipo,
                                'archivo' => $archivo
                            ]);
                        }
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        }
    }

    public function delete_archivo_temporal($id)
    {
        $get_id = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id' => $id]);
        if ($get_id->archivo != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $file_to_delete = "TRACKING/" . $get_id->nom_archivo;
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
        ], [
            'observacion_inspf.required' => 'Debe ingresar observación.'
        ]);

        $list_temporal = TrackingArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('tipo', 2)->count();
        $errors = [];
        if ($_FILES["archivo_inspf"]["name"] == "" && $list_temporal == 0) {
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

        if ($_FILES["archivo_inspf"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["archivo_inspf"]["name"];
                $source_file = $_FILES['archivo_inspf']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Evidencia_" . $request->id . "_" . date('YmdHis') . "_0";
                $nombre = $nombre_soli . "." . strtolower($ext);

                $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    TrackingArchivo::create([
                        'id_tracking' => $request->id,
                        'tipo' => 2,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo' => 2]);

        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $i = 1;
                foreach ($list_archivo as $list) {
                    $nombre_actual = "TRACKING/" . $list->nom_archivo;
                    $nuevo_nombre = "TRACKING/Evidencia_" . $request->id . "_" . date('YmdHis') . "_" . $i . ".jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

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

        if ($request->comentario) {
            TrackingComentario::create([
                'id_tracking' => $request->id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'VERIFICACION_FARDO',
                'comentario' => $request->comentario
            ]);
        }

        //MENSAJE 3
        $get_id = Tracking::get_list_tracking(['id' => $request->id]);
        $list_archivo = TrackingArchivo::where('id_tracking', $request->id)->where('tipo', 2)->get();
        $t_comentario = TrackingComentario::where('id_tracking', $request->id)->where('pantalla', 'VERIFICACION_FARDO')->first();

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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            //$mail->addAddress('ogutierrez@lanumero1.com.pe');
            //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
            foreach ($list_cd as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
            foreach ($list_cc as $list) {
                $mail->addCC($list->emailp);
            }

            $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "REPORTE INSPECCIÓN FARDOS: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> ' . $get_id->semana . '<br>
                                <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                <b>Base:</b> ' . $get_id->hacia . '<br>
                                <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                <b>Fecha - Reporte de inspección de fardos:</b> ' . $fecha_formateada . '<br><br>
                                Hola ' . $get_id->desde . ', los fardos han llegado con las siguientes 
                                observaciones:<br><br>
                                ' . nl2br($get_id->observacion_inspf) . '<br>';
            if ($t_comentario) {
                $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
                            </FONT SIZE>';
            }

            $mail->CharSet = 'UTF-8';
            foreach ($list_archivo as $list) {
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
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function pago_transporte($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        return view('logistica.tracking.tracking.pago_transporte', compact('list_notificacion', 'list_subgerencia', 'get_id'));
    }

    public function previsualizacion_captura_pago()
    {
        if ($_FILES["photo"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if (file_exists('https://lanumerounocloud.com/intranet/TRACKING/temporal_pm_' . session('usuario')->id_usuario . '.jpg')) {
                    ftp_delete($con_id, 'TRACKING/temporal_pm_' . session('usuario')->id_usuario . '.jpg');
                }

                $path = $_FILES["photo"]["name"];
                $source_file = $_FILES['photo']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_pm_" . session('usuario')->id_usuario;
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                if (!$subio) {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }
    }

    public function insert_confirmacion_pago_transporte(Request $request, $id)
    {
        $request->validate([
            'guia_transporte' => 'required',
            'importe_transporte' => 'required|gt:0',
            'factura_transporte' => 'required'
        ], [
            'guia_transporte.required' => 'Debe ingresar nro. GR transporte.',
            'importe_transporte.required' => 'Debe ingresar importe a pagar.',
            'importe_transporte.gt' => 'Debe ingresar importe a pagar mayor a 0.',
            'factura_transporte.required' => 'Debe ingresar n° de factura.'
        ]);

        $errors = [];
        if ($_FILES["archivo_transporte"]["name"] == "" && $request->captura == "0") {
            $errors['archivo'] = ['Debe adjuntar o capturar con la cámara la factura.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        Tracking::findOrFail($id)->update([
            'guia_transporte' => $request->guia_transporte,
            'importe_transporte' => $request->importe_transporte,
            'factura_transporte' => $request->factura_transporte,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if ($_FILES["archivo_transporte"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["archivo_transporte"]["name"];
                $source_file = $_FILES['archivo_transporte']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Factura_" . $id . "_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                    TrackingArchivo::create([
                        'id_tracking' => $id,
                        'tipo' => 1,
                        'archivo' => $archivo
                    ]);
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        if ($request->captura == "1") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $nombre_actual = "TRACKING/temporal_pm_" . session('usuario')->id_usuario . ".jpg";
                $nuevo_nombre = "TRACKING/Factura_" . $id . "_" . date('YmdHis') . "_captura.jpg";
                ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                TrackingArchivo::create([
                    'id_tracking' => $id,
                    'tipo' => 1,
                    'archivo' => $archivo
                ]);
            } else {
                echo "No se conecto";
            }
        }

        //ALERTA 6
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach ($list_token as $token) {
            $dato = [
                'token' => $token->token,
                'titulo' => 'CONFIRMACIÓN DE PAGO A TRANSPORTE',
                'contenido' => 'Hola ' . $get_id->desde . ', se ha pagado a la agencia',
            ];
            $this->sendNotification($dato);
        }
        $dato = [
            'id_tracking' => $get_id->id,
            'titulo' => 'CONFIRMACIÓN DE PAGO A TRANSPORTE',
            'contenido' => 'Hola ' . $get_id->desde . ', se ha pagado a la agencia',
        ];
        $this->insert_notificacion($dato);

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

        if ($request->comentario) {
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'PAGO_TRANSPORTE',
                'comentario' => $request->comentario
            ]);
        }

        //MENSAJE 4
        $list_archivo = TrackingArchivo::where('id_tracking', $id)->where('tipo', 1)->get();
        $t_comentario = TrackingComentario::where('id_tracking', $id)->where('pantalla', 'PAGO_TRANSPORTE')->first();

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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            //$mail->addAddress('ogutierrez@lanumero1.com.pe');
            //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
            foreach ($list_cd as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
            foreach ($list_cc as $list) {
                $mail->addCC($list->emailp);
            }

            $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "MERCADERÍA PAGADA: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> ' . $get_id->semana . '<br>
                                <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                <b>Base:</b> ' . $get_id->hacia . '<br>
                                <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                <b>Fecha - Mercadería pagada:</b> ' . $fecha_formateada . '<br><br>
                                Hola ' . $get_id->desde . ', se ha pagado a la agencia.<br>
                                Envío el reporte de la salida de mercadería <b>(completo)</b>.<br><br>
                                <table cellpadding="3" cellspacing="0" border="1" style="width:100%;">     
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Despacho</td>
                                        <td style="text-align:right;">SEM-' . $get_id->semana . '-' . substr(date('Y'), -2) . '</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="font-weight:bold;">Guía Remisión</td>
                                        <td style="font-weight:bold;">Nuestra</td>
                                        <td style="text-align:right;">' . $get_id->n_guia_remision . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Transporte.</td>
                                        <td style="text-align:right;">' . $get_id->guia_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Tipo de transporte</td>
                                        <td style="text-align:right;">' . $get_id->tipo_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Nombre de transporte</td>
                                        <td style="text-align:right;">' . $get_id->nombre_transporte . '</td>
                                    </tr>                                    
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">N° Factura</td>
                                        <td style="text-align:right;">' . $get_id->factura_transporte . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Peso</td>
                                        <td style="text-align:right;">' . $get_id->peso . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Paquetes</td>
                                        <td style="text-align:right;">' . $get_id->paquetes . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Sobres</td>
                                        <td style="text-align:right;">' . $get_id->sobres . '</td>
                                    </tr>          
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Fardos</td>
                                        <td style="text-align:right;">' . $get_id->fardos . '</td>
                                    </tr>           
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Caja</td>
                                        <td style="text-align:right;">' . $get_id->caja . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Bultos</td>
                                        <td style="text-align:right;">' . $get_id->bultos . '</td>
                                    </tr>                                 
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Recepción</td>
                                        <td style="text-align:right;">' . $get_id->recepcion . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Mercadería total</td>
                                        <td style="text-align:right;">' . $get_id->mercaderia_total . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Flete por prenda</td>
                                        <td style="text-align:right;">S/' . $get_id->flete_prenda_formateado . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Receptor</td>
                                        <td style="text-align:right;">' . $get_id->receptor . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Tipo pago</td>
                                        <td style="text-align:right;">' . $get_id->nom_tipo_pago . '</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Importe Pagado</td>
                                        <td style="text-align:right;">S/' . $get_id->importe_formateado . '</td>
                                    </tr>
                                    <tr>
                                        <td rowspan="3" style="font-weight:bold;">Fecha</td>
                                        <td style="font-weight:bold;">Partida</td>
                                        <td style="text-align:right;">' . $get_id->fecha_partida . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Tiempo estimado de llegada</td>
                                        <td style="text-align:right;">' . $get_id->tiempo_llegada . '</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Llegada</td>
                                        <td style="text-align:right;">' . $get_id->fecha_llegada . '</td>
                                    </tr>
                                </table><br>';
            if ($t_comentario) {
                $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
                            </FONT SIZE>';
            }

            $mail->CharSet = 'UTF-8';
            foreach ($list_archivo as $list) {
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
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'INSPECCION DE MERCADERÍA',
                    'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'INSPECCION DE MERCADERÍA',
                'contenido' => 'Hola ' . $get_id->desde . ', se realizará la inspección de mercadería',
            ];
            $this->insert_notificacion($dato);

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
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function insert_conteo_mercaderia(Request $request, $id)
    {
        //ALERTA 8
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        $list_token = TrackingToken::whereIn('base', ['CD'])->get();
        foreach ($list_token as $token) {
            $dato = [
                'token' => $token->token,
                'titulo' => 'CONTEO DE MERCADERÍA',
                'contenido' => 'Hola ' . $get_id->desde . ', se está realizando el conteo de la mercadería',
            ];
            $this->sendNotification($dato);
        }
        $dato = [
            'id_tracking' => $id,
            'titulo' => 'CONTEO DE MERCADERÍA',
            'contenido' => 'Hola ' . $get_id->desde . ', se está realizando el conteo de la mercadería',
        ];
        $this->insert_notificacion($dato);

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

    public function insert_mercaderia_entregada(Request $request = null, $id)
    {
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        /*Cuando el estado es CONTEO DE MERCADERÍA (13), se va escoger si hay devolución 
        o no, en cualquier de los casos se va validar si hay diferencias o no según la data de INFOSAP.
        Por otro lado, se se accede a está función sin ser estado CONTEO DE MERCADERÍA directamente 
        se finaliza el proceso pasando a estado MERCADERÍA ENTREGADA (21)*/
        if ($get_id->id_estado == "13") {
            /*Insertar datos de diferencia de INFOSAP*/
            TrackingDiferencia::where('id_tracking', $id)->delete();
            try {
                $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);
            } catch (\Throwable $th) {
                $list_diferencia = [];
            }

            foreach ($list_diferencia as $list) {
                TrackingDiferencia::create([
                    'id_tracking' => $id,
                    'sku' => $list->SKU,
                    'estilo' => $list->Estilo,
                    'bulto' => $list->Bulto,
                    'color_talla' => $list->Col_Tal,
                    'enviado' => $list->Enviado,
                    'recibido' => $list->Recibido,
                    'observacion' => $list->Observacion
                ]);
            }
            $v_diferencia = TrackingDiferencia::where('id_tracking', $id)
                ->whereIn('observacion', ['Sobrante', 'Faltante'])->count();
            /*Validar si hay diferencia, en caso si pasa a estado SOLICITUD DE DIFERENCIA (14), 
            sino se termina el proceso pasando a estado MERCADERÍA ENTREGADA (21)*/
            if ($v_diferencia > 0) {
                /*Si se escogió la opción que si hay devolución se va actualizar en la tabla 
                'tracking' el campo devolucion a 1 sino no se hace nada*/
                if ($request->devolucion == "1") {
                    Tracking::findOrFail($id)->update([
                        'diferencia' => 1,
                        'devolucion' => 1,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                } else {
                    Tracking::findOrFail($id)->update([
                        'diferencia' => 1,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }

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

                echo "diferencia";
            } else {
                /*Si se escogió la opción que si hay devolución se pasa a estado SOLICITUD DE 
                DEVOLUCIÓN (17) sino se termina el proceso, pasando a estado 
                MERCADERÍA ENTREGADA (21)*/
                if ($request->devolucion == "1") {
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
                } else {
                    //ALERTA 13
                    $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
                    foreach ($list_token as $token) {
                        $dato = [
                            'token' => $token->token,
                            'titulo' => 'MERCADERÍA ENTREGADA',
                            'contenido' => 'La mercadería fue distribuida con éxito',
                        ];
                        $this->sendNotification($dato);
                    }
                    $dato = [
                        'id_tracking' => $id,
                        'titulo' => 'MERCADERÍA ENTREGADA',
                        'contenido' => 'La mercadería fue distribuida con éxito',
                    ];
                    $this->insert_notificacion($dato);

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
            }
        } else {
            //ALERTA 13
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'MERCADERÍA ENTREGADA',
                    'contenido' => 'La mercadería fue distribuida con éxito',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'MERCADERÍA ENTREGADA',
                'contenido' => 'La mercadería fue distribuida con éxito',
            ];
            $this->insert_notificacion($dato);

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
    }

    public function cuadre_diferencia($id)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        try {
            $list_diferencia = DB::connection('sqlsrv')->select('EXEC usp_web_ver_dif_bultos_x_req ?', [$get_id->n_requerimiento]);
        } catch (\Throwable $th) {
            $list_diferencia = [];
        }
        return view('logistica.tracking.tracking.cuadre_diferencia', compact('list_notificacion', 'list_subgerencia', 'get_id', 'list_diferencia'));
    }

    public function insert_reporte_diferencia(Request $request, $id)
    {
        Tracking::findOrFail($id)->update([
            'v_sobrante' => 1,
            'v_faltante' => 1
        ]);

        if ($request->comentario) {
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'CUADRE_DIFERENCIA',
                'comentario' => $request->comentario
            ]);
        }

        $list_sobrante = TrackingDiferencia::select(
            'sku',
            'estilo',
            'color_talla',
            'bulto',
            'enviado',
            'recibido',
            DB::raw('recibido-enviado AS diferencia'),
            'observacion'
        )
            ->where('id_tracking', $id)->where('observacion', 'Sobrante')
            ->whereColumn('enviado', '<', 'recibido')->get();
        $list_faltante = TrackingDiferencia::select(
            'sku',
            'estilo',
            'color_talla',
            'bulto',
            'enviado',
            'recibido',
            DB::raw('recibido-enviado AS diferencia'),
            'observacion'
        )
            ->where('id_tracking', $id)->where('observacion', 'Faltante')
            ->whereColumn('enviado', '>', 'recibido')->get();
        $list_diferencia = TrackingDiferencia::select(
            'sku',
            'estilo',
            'color_talla',
            'bulto',
            'enviado',
            'recibido',
            DB::raw('recibido-enviado AS diferencia'),
            'observacion'
        )
            ->where('id_tracking', $id)->whereIn('observacion', ['Faltante', 'Sobrante'])->get();

        //ALERTA 9
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        if (count($list_sobrante) > 0) {
            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'REPORTE DE DIFERENCIAS (SOBRANTE)',
                    'contenido' => 'Hola ' . $get_id->desde . ', regularizar los sobrantes indicados',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'REPORTE DE DIFERENCIAS (SOBRANTE)',
                'contenido' => 'Hola ' . $get_id->desde . ', regularizar los sobrantes indicados',
            ];
            $this->insert_notificacion($dato);

            Tracking::findOrFail($id)->update([
                'v_sobrante' => 0
            ]);
        }
        if (count($list_faltante) > 0) {
            $list_token = TrackingToken::whereIn('base', [$get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'REPORTE DE DIFERENCIAS (FALTANTE)',
                    'contenido' => 'Hola ' . $get_id->hacia . ', regularizar los faltantes indicados',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'REPORTE DE DIFERENCIAS (FALTANTE)',
                'contenido' => 'Hola ' . $get_id->hacia . ', regularizar los faltantes indicados',
            ];
            $this->insert_notificacion($dato);

            Tracking::findOrFail($id)->update([
                'v_faltante' => 0
            ]);
        }

        //MENSAJE 5
        $t_comentario = TrackingComentario::where('id_tracking', $id)
            ->where('pantalla', 'CUADRE_DIFERENCIA')->orderBy('id', 'DESC')->first();

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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            //$mail->addAddress('dpalomino@lanumero1.com.pe');
            //$mail->addAddress('ogutierrez@lanumero1.com.pe');
            //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
            $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
            foreach ($list_cd as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD', $get_id->hacia]);
            foreach ($list_td as $list) {
                $mail->addAddress($list->emailp);
            }
            $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
            foreach ($list_cc as $list) {
                $mail->addCC($list->emailp);
            }

            $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
            $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
            $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
            $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
            $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

            $mail->isHTML(true);

            $mail->Subject = "DIFERENCIAS EN LA RECEPCIÓN: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

            $mail->Body =  '<FONT SIZE=3>
                                <b>Semana:</b> ' . $get_id->semana . '<br>
                                <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                <b>Base:</b> ' . $get_id->hacia . '<br>
                                <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                <b>Fecha - Reporte de diferencias:</b> ' . $fecha_formateada . '<br><br>
                                Hola ' . $get_id->hacia . ' - ' . $get_id->desde . ', regularizar los sobrantes y faltantes indicados.<br><br>
                                <table CELLPADDING="6" CELLSPACING="0" border="2" style="width:100%;border: 1px solid black;">
                                    <thead>
                                        <tr align="center" style="background-color:#0093C6;">
                                            <th><b>SKU</b></th>
                                            <th><b>Estilo</b></th>
                                            <th><b>Col_Tal</b></th>
                                            <th><b>Bulto</b></th>
                                            <th><b>Enviado</b></th>
                                            <th><b>Recibido</b></th>
                                            <th><b>Dif</b></th>
                                            <th><b>Orden de Regularización</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            foreach ($list_diferencia as $list) {
                $mail->Body .=  '            <tr align="left">
                                            <td>' . $list->sku . '</td>
                                            <td>' . $list->estilo . '</td>
                                            <td>' . $list->color_talla . '</td>
                                            <td>' . $list->bulto . '</td>
                                            <td>' . $list->enviado . '</td>
                                            <td>' . $list->recibido . '</td>
                                            <td>' . $list->diferencia . '</td>
                                            <td>' . $list->observacion . '</td>
                                        </tr>';
            }
            $mail->Body .=  '        </tbody>
                                </table><br>
                                <a href="' . route('tracking.detalle_operacion_diferencia', $id) . '" 
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
            if ($t_comentario) {
                $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
                            </FONT SIZE>';
            }

            $mail->CharSet = 'UTF-8';
            $mail->send();
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
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
            if (session('redirect_url')) {
                session()->forget('redirect_url');
            }
            //NOTIFICACIONES
            $list_notificacion = Notificacion::get_list_notificacion();
            $list_subgerencia = SubGerencia::list_subgerencia(7);
            $get_id = Tracking::get_list_tracking(['id' => $id]);
            if ($get_id->id_estado == 15) {
                return view('logistica.tracking.tracking.detalle_operacion_diferencia', compact('list_notificacion', 'list_subgerencia', 'get_id'));
            } else {
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio', date('Y'))->where('semana', date('W'))->exists();
                return view('logistica.tracking.tracking.index', compact('list_notificacion', 'list_mercaderia_nueva'));
            }
        } else {
            session(['redirect_url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function insert_diferencia_regularizada(Request $request, $id)
    {
        $get_id = Tracking::get_list_tracking(['id' => $id]);

        if (
            $get_id->sobrantes > 0 &&
            $get_id->faltantes > 0 &&
            session('usuario')->id_nivel == 1
        ) {
            $request->validate([
                'guia_sobrante' => 'required|max:20',
                'guia_faltante' => 'required|max:20'
            ], [
                'guia_sobrante.required' => 'Debe ingresar Nro. Gr (Sobrante).',
                'guia_sobrante.max' => 'Nro. Gr (Sobrante) debe tener como máximo 20 carácteres.',
                'guia_faltante.required' => 'Debe ingresar Nro. Gr (Faltante).',
                'guia_faltante.max' => 'Nro. Gr (Faltante) debe tener como máximo 20 carácteres.'
            ]);

            $errors = [];
            if (!isset($get_id->archivo_sobrante)) {
                if ($request->archivo_sobrante == "") {
                    $errors['sobrante'] = ['Debe adjuntar GR (Sobrante).'];
                }
            }
            if (!isset($get_id->archivo_faltante)) {
                if ($request->archivo_faltante == "") {
                    $errors['faltante'] = ['Debe adjuntar GR (Faltante).'];
                }
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            Tracking::findOrFail($id)->update([
                'guia_sobrante' => $request->guia_sobrante,
                'guia_faltante' => $request->guia_faltante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if ($_FILES["archivo_sobrante"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if ($get_id->archivo_sobrante != "") {
                        ftp_delete($con_id, "TRACKING/" . basename($get_id->archivo_sobrante));
                        TrackingArchivo::where('id_tracking', $id)->where('tipo', 3)->delete();
                    }

                    $path = $_FILES["archivo_sobrante"]["name"];
                    $source_file = $_FILES['archivo_sobrante']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "GR_Sobrante_" . $id . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingArchivo::create([
                            'id_tracking' => $id,
                            'tipo' => 3,
                            'archivo' => $archivo
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            if ($_FILES["archivo_faltante"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if ($get_id->archivo_faltante != "") {
                        ftp_delete($con_id, "TRACKING/" . basename($get_id->archivo_faltante));
                        TrackingArchivo::where('id_tracking', $id)->where('tipo', 4)->delete();
                    }

                    $path = $_FILES["archivo_faltante"]["name"];
                    $source_file = $_FILES['archivo_faltante']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "GR_Faltante_" . $id . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingArchivo::create([
                            'id_tracking' => $id,
                            'tipo' => 4,
                            'archivo' => $archivo
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        } elseif (
            $get_id->sobrantes > 0 &&
            (session('usuario')->id_puesto == 76 ||
                session('usuario')->id_nivel == 1)
        ) {
            $request->validate([
                'guia_sobrante' => 'required|max:20'
            ], [
                'guia_sobrante.required' => 'Debe ingresar Nro. Gr (Sobrante).',
                'guia_sobrante.max' => 'Nro. Gr (Sobrante) debe tener como máximo 20 carácteres.'
            ]);

            $errors = [];
            if (!isset($get_id->archivo_sobrante)) {
                if ($request->archivo_sobrante == "") {
                    $errors['sobrante'] = ['Debe adjuntar GR (Sobrante).'];
                }
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            Tracking::findOrFail($id)->update([
                'guia_sobrante' => $request->guia_sobrante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if ($_FILES["archivo_sobrante"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if ($get_id->archivo_sobrante != "") {
                        ftp_delete($con_id, "TRACKING/" . basename($get_id->archivo_sobrante));
                        TrackingArchivo::where('id_tracking', $id)->where('tipo', 3)->delete();
                    }

                    $path = $_FILES["archivo_sobrante"]["name"];
                    $source_file = $_FILES['archivo_sobrante']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "GR_Sobrante_" . $id . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingArchivo::create([
                            'id_tracking' => $id,
                            'tipo' => 3,
                            'archivo' => $archivo
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        } elseif (
            $get_id->faltantes > 0 &&
            (session('usuario')->id_puesto == 30 ||
                session('usuario')->id_puesto == 31 ||
                session('usuario')->id_puesto == 32 ||
                session('usuario')->id_puesto == 33 ||
                session('usuario')->id_puesto == 35 ||
                session('usuario')->id_puesto == 161 ||
                session('usuario')->id_puesto == 167 ||
                session('usuario')->id_puesto == 168 ||
                session('usuario')->id_puesto == 311 ||
                session('usuario')->id_puesto == 314 ||
                session('usuario')->id_nivel == 1)
        ) {
            $request->validate([
                'guia_faltante' => 'required|max:20'
            ], [
                'guia_faltante.required' => 'Debe ingresar Nro. Gr (Faltante).',
                'guia_faltante.max' => 'Nro. Gr (Faltante) debe tener como máximo 20 carácteres.'
            ]);

            $errors = [];
            if (!isset($get_id->archivo_faltante)) {
                if ($request->archivo_faltante == "") {
                    $errors['faltante'] = ['Debe adjuntar GR (Faltante).'];
                }
            }
            if (!empty($errors)) {
                return response()->json(['errors' => $errors], 422);
            }

            Tracking::findOrFail($id)->update([
                'guia_faltante' => $request->guia_faltante,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if ($_FILES["archivo_faltante"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if ($get_id->archivo_faltante != "") {
                        ftp_delete($con_id, "TRACKING/" . basename($get_id->archivo_faltante));
                        TrackingArchivo::where('id_tracking', $id)->where('tipo', 4)->delete();
                    }

                    $path = $_FILES["archivo_faltante"]["name"];
                    $source_file = $_FILES['archivo_faltante']['tmp_name'];

                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "GR_Faltante_" . $id . "_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TRACKING/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/TRACKING/" . $nombre;
                        TrackingArchivo::create([
                            'id_tracking' => $id,
                            'tipo' => 4,
                            'archivo' => $archivo
                        ]);
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
        }

        if ($request->comentario) {
            TrackingComentario::create([
                'id_tracking' => $id,
                'id_usuario' => session('usuario')->id_usuario,
                'pantalla' => 'DETALLE_OPERACION_DIFERENCIA',
                'comentario' => $request->comentario
            ]);
        }

        $get_id = Tracking::get_list_tracking(['id' => $id]);

        $valida = 0;
        $mensaje = "";
        if ($get_id->sobrantes > 0 && $get_id->faltantes > 0) {
            if ($get_id->guia_sobrante != "" && $get_id->guia_faltante != "") {
                $valida = 1;
                $mensaje = " con las GR (Sobrante): " . $get_id->guia_sobrante . " y GR (Faltante): " . $get_id->guia_faltante;
            }
        } elseif ($get_id->sobrantes > 0) {
            if ($get_id->guia_sobrante != "") {
                $valida = 1;
                $mensaje = " con la GR (Sobrante): " . $get_id->guia_sobrante;
            }
        } elseif ($get_id->faltantes > 0) {
            if ($get_id->guia_faltante != "") {
                $valida = 1;
                $mensaje = " con la GR (Faltante): " . $get_id->guia_faltante;
            }
        } else {
            $valida = 1;
        }

        if ($valida == 1) {
            //ALERTA 10
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'DIFERENCIAS REGULARIZADAS',
                    'contenido' => 'Hola ' . $get_id->desde . ' - ' . $get_id->hacia . ', se regularizó el Nro. Req. ' . $get_id->n_requerimiento . $mensaje,
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'DIFERENCIAS REGULARIZADAS',
                'contenido' => 'Hola ' . $get_id->desde . ' - ' . $get_id->hacia . ', se regularizó el Nro. Req. ' . $get_id->n_requerimiento . $mensaje,
            ];
            $this->insert_notificacion($dato);

            //MENSAJE 6
            $list_archivo = TrackingArchivo::where('id_tracking', $id)->whereIn('tipo', [3, 4])->get();
            $t_comentario = TrackingComentario::from('tracking_comentario AS tc')
                ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                            us.usuario_apater) AS nombre"), 'tc.comentario')
                ->join('users AS us', 'us.id_usuario', '=', 'tc.id_usuario')
                ->where('tc.id_tracking', $id)
                ->where('tc.pantalla', 'DETALLE_OPERACION_DIFERENCIA')->get();

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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                //$mail->addAddress('ogutierrez@lanumero1.com.pe');
                //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
                foreach ($list_cd as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD', $get_id->hacia]);
                foreach ($list_td as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
                foreach ($list_cc as $list) {
                    $mail->addCC($list->emailp);
                }

                $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "REGULARIZADO - DIFERENCIAS EN LA RECEPCIÓN: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> ' . $get_id->semana . '<br>
                                    <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                    <b>Base:</b> ' . $get_id->hacia . '<br>
                                    <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                    <b>Fecha - Diferencias regularizadas:</b> ' . $fecha_formateada . '<br><br>
                                    Hola ' . $get_id->desde . ' - ' . $get_id->hacia . ', se acaba de 
                                    regularizar' . $mensaje . '.
                                    El archivo ya se encuentra en su carpeta.<br>';
                if (count($t_comentario) > 0) {
                    $mail->Body .=      '<br>Comentario:<br>';
                    foreach ($t_comentario as $list) {
                        $mail->Body .=      '- ' . $list->nombre . ': ' . nl2br($list->comentario) . '<br>';
                    }
                    $mail->Body .= '</FONT SIZE>';
                }

                $mail->CharSet = 'UTF-8';
                foreach ($list_archivo as $list) {
                    $archivo_contenido = file_get_contents($list->archivo);
                    $nombre_archivo = basename($list->archivo);
                    $mail->addStringAttachment($archivo_contenido, $nombre_archivo);
                }
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

                $valida = Tracking::where('id', $id)->where('v_sobrante', 1)->where('v_faltante', 1)->count();

                if ($valida > 0) {
                    if ($get_id->devolucion == "1") {
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
                    } else {
                        //ALERTA 13
                        $this->insert_mercaderia_entregada(null, $id);
                    }
                } else {
                    TrackingDetalleEstado::create([
                        'id_detalle' => $get_id->id_detalle,
                        'id_estado' => 22,
                        'fecha' => now(),
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
    }

    public function validacion_diferencia(Request $request, $id)
    {
        if ($request->tipo == "sobrante") {
            Tracking::findOrFail($id)->update([
                'v_sobrante' => 1
            ]);
        }
        if ($request->tipo == "faltante") {
            Tracking::findOrFail($id)->update([
                'v_faltante' => 1
            ]);
        }

        $valida = Tracking::where('id', $id)->where('v_sobrante', 1)->where('v_faltante', 1)->count();

        if ($valida > 0) {
            $get_id = Tracking::get_list_tracking(['id' => $id]);

            if ($get_id->devolucion == "1") {
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
            } else {
                //ALERTA 13
                $this->insert_mercaderia_entregada(null, $id);
            }
        }
    }

    public function solicitud_devolucion($id)
    {
        TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
        $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['tipo' => 5]);
        if (count($list_archivo) > 0) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                foreach ($list_archivo as $list) {
                    $file_to_delete = "TRACKING/" . $list->nom_archivo;
                    if (ftp_delete($con_id, $file_to_delete)) {
                        TrackingArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        $list_guia_remision = TrackingGuiaRemisionDetalle::select('id', 'sku', 'descripcion', 'cantidad')->where('n_requerimiento', $get_id->n_requerimiento)->get();
        return view('logistica.tracking.tracking.solicitud_devolucion', compact('list_notificacion', 'list_subgerencia', 'get_id', 'list_guia_remision'));
    }

    public function modal_solicitud_devolucion($id)
    {
        $get_producto = TrackingGuiaRemisionDetalle::findOrFail($id);
        $get_id = TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('id_producto', $id)->first();
        return view('logistica.tracking.tracking.modal_solicitud_devolucion', compact('get_producto', 'get_id'));
    }

    public function insert_devolucion_temporal(Request $request, $id)
    {
        $request->validate([
            'tipo_falla' => 'required',
            'cantidad' => 'gt:0',
        ], [
            'tipo_falla.required' => 'Debe ingresar tipo de falla.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
        ]);

        $list_temporal = TrackingArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('tipo', 5)->where('id_producto', $id)->count();
        $errors = [];
        if ($list_temporal == 0) {
            $errors['archivo'] = ['Debe capturar con la cámara la evidencia.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_producto = TrackingGuiaRemisionDetalle::findOrFail($id);

        if ($get_producto->cantidad >= $request->cantidad) {
            TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)
                ->where('id_producto', $id)->delete();
            TrackingDevolucionTemporal::create([
                'id_usuario' => session('usuario')->id_usuario,
                'id_producto' => $id,
                'tipo_falla' => $request->tipo_falla,
                'cantidad' => $request->cantidad
            ]);
        } else {
            echo "error";
        }
    }

    public function insert_reporte_devolucion(Request $request, $id)
    {
        $request->validate([
            'devolucion' => 'required',
        ], [
            'devolucion.required' => 'Debe seleccionar al menos un ítem.',
        ]);

        $cantidad = TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)->count();
        $array = explode(",", substr($request->devoluciones, 1));

        if ($cantidad >= count($array)) {
            //ALERTA 11
            $get_id = Tracking::get_list_tracking(['id' => $id]);

            $list_token = TrackingToken::whereIn('base', ['CD'])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'SOLICITUD DE DEVOLUCIÓN',
                    'contenido' => 'Hola Andrea, se ha encontrado mercadería para devolución, revisar correo',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'SOLICITUD DE DEVOLUCIÓN',
                'contenido' => 'Hola Andrea, se ha encontrado mercadería para devolución, revisar correo',
            ];
            $this->insert_notificacion($dato);

            $list_devolucion = TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)
                ->whereIn('id_producto', $array)->get();

            foreach ($list_devolucion as $list) {
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

                $list_archivo = TrackingArchivoTemporal::get_list_tracking_archivo_temporal(['id_producto' => $list->id_producto]);
                if (count($list_archivo) > 0) {
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                    if ($con_id && $lr) {
                        $i = 1;
                        foreach ($list_archivo as $archivo) {
                            $nombre_actual = "TRACKING/" . $archivo->nom_archivo;
                            $nuevo_nombre = "TRACKING/Evidencia_" . $id . "_" . date('YmdHis') . "_" . $i . ".jpg";
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $archivo = "https://lanumerounocloud.com/intranet/" . $nuevo_nombre;

                            TrackingArchivo::create([
                                'id_tracking' => $id,
                                'tipo' => 5,
                                'id_producto' => $list->id_producto,
                                'archivo' => $archivo
                            ]);

                            $i++;
                        }
                    }
                }
            }
            TrackingDevolucionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
            TrackingArchivoTemporal::where('id_usuario', session('usuario')->id_usuario)->where('tipo', 5)->delete();

            if ($request->comentario) {
                TrackingComentario::create([
                    'id_tracking' => $id,
                    'id_usuario' => session('usuario')->id_usuario,
                    'pantalla' => 'SOLICITUD_DEVOLUCION',
                    'comentario' => $request->comentario
                ]);
            }

            //MENSAJE 7
            $t_comentario = TrackingComentario::where('id_tracking', $id)->where('pantalla', 'SOLICITUD_DEVOLUCION')->first();

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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                //$mail->addAddress('ogutierrez@lanumero1.com.pe');
                //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
                foreach ($list_cd as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
                foreach ($list_cc as $list) {
                    $mail->addCC($list->emailp);
                }

                $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "SOLICITUD DE DEVOLUCIÓN: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> ' . $get_id->semana . '<br>
                                    <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                    <b>Base:</b> ' . $get_id->hacia . '<br>
                                    <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                    <b>Fecha - Solicitud de devolución:</b> ' . $fecha_formateada . '<br><br>
                                    Hola Andrea, tienes una solicitud de devolución por evaluar.
                                    <br><br>
                                    <a href="' . route('tracking.evaluacion_devolucion', $id) . '" 
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
                if ($t_comentario) {
                    $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
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
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        } else {
            echo "error";
        }
    }

    public function evaluacion_devolucion($id)
    {
        if (session('usuario')) {
            if (session('redirect_url')) {
                session()->forget('redirect_url');
            }
            //NOTIFICACIONES
            $list_notificacion = Notificacion::get_list_notificacion();
            $list_subgerencia = SubGerencia::list_subgerencia(7);
            $get_id = Tracking::get_list_tracking(['id' => $id]);
            if ($get_id->id_estado == 18) {
                TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
                $list_devolucion = TrackingDevolucion::select(
                    'tracking_devolucion.id',
                    'tracking_guia_remision_detalle.sku',
                    'tracking_guia_remision_detalle.descripcion',
                    'tracking_devolucion.cantidad'
                )
                    ->join('tracking_guia_remision_detalle', 'tracking_guia_remision_detalle.id', '=', 'tracking_devolucion.id_producto')
                    ->where('tracking_devolucion.id_tracking', $id)
                    ->where('tracking_devolucion.estado', 1)->get();
                return view('logistica.tracking.tracking.evaluacion_devolucion', compact(
                    'list_notificacion',
                    'list_subgerencia',
                    'get_id',
                    'list_devolucion'
                ));
            } else {
                $list_mercaderia_nueva = MercaderiaSurtida::where('anio', date('Y'))->where('semana', date('W'))->exists();
                return view('logistica.tracking.tracking.index', compact('list_notificacion', 'list_subgerencia', 'list_mercaderia_nueva'));
            }
        } else {
            session(['redirect_url' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']]);
            return redirect('/');
        }
    }

    public function modal_evaluacion_devolucion($id)
    {
        $get_devolucion = TrackingDevolucion::findOrFail($id);
        $list_archivo = TrackingArchivo::select('archivo')->where('id_producto', $get_devolucion->id_producto)->where('tipo', 5)->get();
        $get_id = TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('id_devolucion', $id)->first();
        return view('logistica.tracking.tracking.modal_evaluacion_devolucion', compact('get_devolucion', 'list_archivo', 'get_id'));
    }

    public function insert_evaluacion_temporal(Request $request, $id)
    {
        $request->validate([
            'aprobacion' => 'required',
            'sustento_respuesta' => 'required',
            'forma_proceder' => 'required',
        ], [
            'aprobacion.required' => 'Debe seleccionar aprobación.',
            'sustento_respuesta.required' => 'Debe ingresar sustento de respuesta.',
            'forma_proceder.required' => 'Debe ingresar forma de proceder.',
        ]);

        TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)
            ->where('id_devolucion', $id)->delete();
        TrackingEvaluacionTemporal::create([
            'id_usuario' => session('usuario')->id_usuario,
            'id_devolucion' => $id,
            'aprobacion' => $request->aprobacion,
            'sustento_respuesta' => $request->sustento_respuesta,
            'forma_proceder' => $request->forma_proceder
        ]);
    }

    public function insert_autorizacion_devolucion(Request $request, $id)
    {
        $valida_t = TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->count();
        $valida = TrackingDevolucion::where('id_tracking', $id)->where('estado', 1)->count();

        if ($valida_t == $valida) {
            $list_evaluacion = TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->get();

            foreach ($list_evaluacion as $list) {
                TrackingDevolucion::findOrFail($list->id_devolucion)->update([
                    'aprobacion' => $list->aprobacion,
                    'sustento_respuesta' => $list->sustento_respuesta,
                    'forma_proceder' => $list->forma_proceder,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
            TrackingEvaluacionTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();

            $get_id = Tracking::get_list_tracking(['id' => $id]);
            $list_evaluacion = TrackingDevolucion::select(
                'tracking_guia_remision_detalle.sku',
                'tracking_guia_remision_detalle.descripcion',
                'tracking_devolucion.cantidad',
                'tracking_devolucion.sustento_respuesta',
                DB::raw('CASE WHEN tracking_devolucion.aprobacion=1 THEN "Aprobada" 
                                                    WHEN tracking_devolucion.aprobacion=2 THEN "Denegada" ELSE "" END AS devolucion'),
                'tracking_devolucion.forma_proceder'
            )
                ->join('tracking_guia_remision_detalle', 'tracking_guia_remision_detalle.id', '=', 'tracking_devolucion.id_producto')
                ->where('tracking_devolucion.id_tracking', $id)
                ->where('tracking_devolucion.estado', 1)->get();

            if ($request->comentario) {
                TrackingComentario::create([
                    'id_tracking' => $id,
                    'id_usuario' => session('usuario')->id_usuario,
                    'pantalla' => 'EVALUACION_DEVOLUCION',
                    'comentario' => $request->comentario
                ]);
            }

            //MENSAJE 8
            $t_comentario = TrackingComentario::where('id_tracking', $id)->where('pantalla', 'EVALUACION_DEVOLUCION')->first();

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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                //$mail->addAddress('dpalomino@lanumero1.com.pe');
                //$mail->addAddress('ogutierrez@lanumero1.com.pe');
                //$mail->addAddress('asist1.procesosyproyectos@lanumero1.com.pe');
                $list_cd = DB::select('CALL usp_correo_tracking (?,?)', ['CD', '']);
                foreach ($list_cd as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_td = DB::select('CALL usp_correo_tracking (?,?)', ['TD', $get_id->hacia]);
                foreach ($list_td as $list) {
                    $mail->addAddress($list->emailp);
                }
                $list_cc = DB::select('CALL usp_correo_tracking (?,?)', ['CC', '']);
                foreach ($list_cc as $list) {
                    $mail->addCC($list->emailp);
                }

                $fecha_formateada =  date('l d') . " de " . date('F') . " del " . date('Y');
                $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
                $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
                $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
                $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
                $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);

                $mail->isHTML(true);

                $mail->Subject = "RESPUESTA A SOLICITUD DE DEVOLUCIÓN: RQ. " . $get_id->n_requerimiento . " (" . $get_id->hacia . ") - PRUEBA";

                $mail->Body =  '<FONT SIZE=3>
                                    <b>Semana:</b> ' . $get_id->semana . '<br>
                                    <b>Nro. Req.:</b> ' . $get_id->n_requerimiento . '<br>
                                    <b>Base:</b> ' . $get_id->hacia . '<br>
                                    <b>Distrito:</b> ' . $get_id->nombre_distrito . '<br>
                                    <b>Fecha - Autorización de devolución:</b> ' . $fecha_formateada . '<br><br>
                                    Hola ' . $get_id->hacia . ' - ' . $get_id->desde . ', a continuación respuesta de la solicitud de 
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
                foreach ($list_evaluacion as $list) {
                    $mail->Body .=  '               <tr align="left">
                                                    <td align="center">' . $list->sku . '</td>
                                                    <td>' . $list->descripcion . '</td>
                                                    <td align="center">' . $list->cantidad . '</td>
                                                    <td align="center">' . $list->devolucion . '</td>
                                                    <td>' . $list->sustento_respuesta . '</td>
                                                    <td>' . $list->forma_proceder . '</td>
                                                </tr>';
                }
                $mail->Body .=  '       </tbody>
                                    </table>';
                if ($t_comentario) {
                    $mail->Body .=      '<br>Comentario:<br>' . nl2br($t_comentario->comentario) . '
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
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }

            //ALERTA 12
            $list_token = TrackingToken::whereIn('base', ['CD', $get_id->hacia])->get();
            foreach ($list_token as $token) {
                $dato = [
                    'token' => $token->token,
                    'titulo' => 'CIERRE DE INCONFORMIDADES DE DEVOLUCIÓN',
                    'contenido' => 'Hola, ' . $get_id->desde . ' - ' . $get_id->hacia . ' revisar respuesta de la solicitud de la devolución para el Nro. Req',
                ];
                $this->sendNotification($dato);
            }
            $dato = [
                'id_tracking' => $id,
                'titulo' => 'CIERRE DE INCONFORMIDADES DE DEVOLUCIÓN',
                'contenido' => 'Hola, ' . $get_id->desde . ' - ' . $get_id->hacia . ' revisar respuesta de la solicitud de la devolución para el Nro. Req',
            ];
            $this->insert_notificacion($dato);

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
            $this->insert_mercaderia_entregada(null, $id);
        } else {
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
        return view('logistica.tracking.tracking.mercaderia_nueva.lista', compact('cod_base', 'list_mercaderia_nueva'));
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

    public function modal_mercaderia_nueva($cod_base, $estilo)
    {
        $list_mercaderia_nueva = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?,?,?', [
            $cod_base,
            $estilo,
            '',
            ''
        ]);
        return view('logistica.tracking.tracking.mercaderia_nueva.modal_detalle', compact(
            'estilo',
            'list_mercaderia_nueva'
        ));
    }

    public function list_mercaderia_nueva_app(Request $request)
    {
        try {
            if ($request->estilo) {
                $query_co = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?,?,?', [
                    $request->cod_base,
                    $request->estilo,
                    'CO',
                    ''
                ]);

                $query = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?,?,?', [
                    $request->cod_base,
                    $request->estilo,
                    '',
                    ''
                ]);
            } else {
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

        if (count($query) == 0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        if ($request->estilo) {
            // Convierte los resultados de la primera consulta en un array de colores únicos
            $colores = collect($query_co)->pluck('color')->unique();

            // Crea un array para almacenar los datos finales
            $data = [];

            // Itera sobre cada color y agrupa los elementos de la segunda consulta
            foreach ($colores as $color) {
                $data[$color] = collect($query)->filter(function ($item) use ($color) {
                    return $item->color === $color;
                })->map(function ($item) {
                    return [
                        'codigo_barra' => $item->codigo_barra,
                        'talla' => $item->talla,
                        'color' => $item->color,
                        'cantidad' => $item->cantidad,
                    ];
                })->values()->toArray();
            }

            return response()->json($data, 200);
        } else {
            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu,
                'tipo_prenda' => $query_tp
            ];

            return response()->json($response, 200);
        }
    }

    public function list_mercaderia_nueva_app_new(Request $request)
    {
        try {
            if ($request->color) {
                $query = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?,?,?', [
                    $request->cod_base,
                    $request->estilo,
                    'SI',
                    $request->color
                ]);
            } elseif ($request->estilo) {
                $query = DB::connection('sqlsrv')->select('EXEC usp_mercaderia_nueva_x_estilo ?,?,?,?', [
                    $request->cod_base,
                    $request->estilo,
                    'NO',
                    ''
                ]);
            } else {
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

        if (count($query) == 0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        if ($request->estilo) {
            return response()->json($query, 200);
        } else {
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
        ], [
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

        if ($request->cantidad > $get_id->cantidad) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        } else {
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
            if ($request->estilo) {
                $query = MercaderiaSurtida::get_list_mercaderia_surtida([
                    'cod_base' => $request->cod_base,
                    'estilo' => $request->estilo
                ]);
            } else {
                $query = MercaderiaSurtida::select('estilo', 'tipo_usuario', 'descripcion')
                    ->where('tipo', 1)->where('anio', date('Y'))->where('semana', date('W'))
                    ->where('base', $request->cod_base)->where('estado', 0)
                    ->groupBy('estilo', 'tipo_usuario', 'descripcion')->get();

                $query_tu = MercaderiaSurtida::select('tipo_usuario')
                    ->where('tipo', 1)->where('anio', date('Y'))->where('semana', date('W'))
                    ->where('base', $request->cod_base)->where('estado', 0)
                    ->groupBy('tipo_usuario')->get();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if (count($query) == 0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        if ($request->estilo) {
            return response()->json($query, 200);
        } else {
            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        }
    }

    public function list_mercaderia_nueva_vendedor_app(Request $request)
    {
        try {
            if ($request->estilo) {
                $query = MercaderiaSurtida::get_list_merc_surt_vendedor([
                    'cod_base' => $request->cod_base,
                    'estilo' => $request->estilo
                ]);

                $query_tu = MercaderiaSurtida::get_list_tusu_merc_surt_vendedor([
                    'cod_base' => $request->cod_base,
                    'estilo' => $request->estilo
                ]);
            } else {
                $query = MercaderiaSurtida::select('estilo', 'tipo_usuario', 'descripcion')
                    ->where('tipo', 1)->where('anio', date('Y'))->where('semana', date('W'))
                    ->where('base', $request->cod_base)
                    ->groupBy('estilo', 'tipo_usuario', 'descripcion')->get();

                $query_tu = MercaderiaSurtida::select('tipo_usuario')
                    ->where('tipo', 1)->where('anio', date('Y'))->where('semana', date('W'))
                    ->where('base', $request->cod_base)
                    ->groupBy('tipo_usuario')->get();
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => "Error procesando base de datos.",
            ], 500);
        }

        if (count($query) == 0) {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }

        $response = [
            'data' => $query,
            'tipo_usuario' => $query_tu
        ];

        return response()->json($response, 200);
    }
    //REQUERIMIENTO DE REPOSICIÓN
    public function insert_requerimiento_reposicion_app(Request $request, $sku)
    {
        $request->validate([
            'cantidad' => 'required|gt:0',
            'cod_base' => 'required',
        ], [
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
        ], [
            'cod_base.required' => 'Debe ingresar base.',
            'estilo.required' => 'Debe ingresar estilo.',
        ]);

        $valida = MercaderiaSurtida::where('tipo', 3)->where('base', $request->cod_base)
            ->where('estilo', $request->estilo)->where('estado', 0)->exists();
        if ($valida) {
            return response()->json([
                'existe_rq_previo' => true
            ], 404);
        } else {
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
                        'color' => $list['color'],
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
    }

    public function list_requerimiento_reposicion_app(Request $request)
    {
        //YA NO SE USA EL TIPO="SKU"
        if ($request->tipo == "sku") {
            try {
                $query = MercaderiaSurtida::where('tipo', 2)->where('base', $request->cod_base)
                    ->where('estado', 0)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            return response()->json($query, 200);
        } else if ($request->tipo == "estilo") {
            try {
                $query = MercaderiaSurtida::get_list_req_repo_alma([
                    'cod_base' => $request->cod_base,
                    'tipo_usuario' => $request->tipo_usuario
                ]);

                $query_tu = MercaderiaSurtida::get_list_tusu_req_repo_alma([
                    'cod_base' => $request->cod_base
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        } elseif ($request->id_padre) {
            try {
                $query = MercaderiaSurtida::where('id_padre', $request->id_padre)
                    ->where('estado', 0)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            return response()->json($query, 200);
        } else {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }
    }

    public function list_requerimiento_reposicion_app_new(Request $request)
    {
        //YA NO SE USA EL TIPO="SKU"
        if ($request->tipo == "sku") {
            try {
                if ($request->tipo_usuario == "0") {
                    $query = MercaderiaSurtida::where('tipo', 2)->where('base', $request->cod_base)
                        ->where('estado', 0)->get();
                } else {
                    $query = MercaderiaSurtida::where('tipo', 2)->where('base', $request->cod_base)
                        ->where('tipo_usuario', $request->tipo_usuario)
                        ->where('estado', 0)->get();
                }

                $query_tu = MercaderiaSurtida::select('tipo_usuario')->where('tipo', 2)->where('base', $request->cod_base)
                    ->where('estado', 0)->groupBy('tipo_usuario')->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        } else if ($request->tipo == "estilo") {
            try {
                $query = MercaderiaSurtida::get_list_req_repo_alma([
                    'cod_base' => $request->cod_base,
                    'tipo_usuario' => $request->tipo_usuario
                ]);

                $query_tu = MercaderiaSurtida::get_list_tusu_req_repo_alma([
                    'cod_base' => $request->cod_base
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        } elseif ($request->id_padre) {
            try {
                $query = MercaderiaSurtida::where('id_padre', $request->id_padre)
                    ->where('estado', 0)->get();
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            return response()->json($query, 200);
        } else {
            return response()->json([
                'message' => 'Sin resultados.',
            ], 404);
        }
    }

    public function list_requerimiento_reposicion_vendedor_app(Request $request)
    {
        //YA NO SE USA EL TIPO="SKU"
        if ($request->tipo == "sku") {
            try {
                $query = MercaderiaSurtida::get_list_req_repo_vend([
                    'cod_base' => $request->cod_base
                ]);

                $query_tu = MercaderiaSurtida::get_list_tusu_req_repo_vend([
                    'cod_base' => $request->cod_base
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        } else if ($request->tipo == "estilo") {
            try {
                $query = MercaderiaSurtida::get_list_req_repo_vend([
                    'cod_base' => $request->cod_base,
                    'tipo_usuario' => $request->tipo_usuario,
                    'estilo' => 'estilo'
                ]);

                $query_tu = MercaderiaSurtida::get_list_tusu_req_repo_vend([
                    'cod_base' => $request->cod_base,
                    'estilo' => 'estilo'
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            $response = [
                'data' => $query,
                'tipo_usuario' => $query_tu
            ];

            return response()->json($response, 200);
        } elseif ($request->id_padre) {
            try {
                $query = MercaderiaSurtida::get_list_req_repo_vend([
                    'id_padre' => $request->id_padre
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => "Error procesando base de datos.",
                ], 500);
            }

            if (count($query) == 0) {
                return response()->json([
                    'message' => 'Sin resultados.',
                ], 404);
            }

            return response()->json($query, 200);
        } else {
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
    //DETALLE TRACKING
    public function index_det()
    {
        if (substr(session('usuario')->centro_labores, 0, 1) == "B") {
            $list_base = BaseActiva::where('cod_base', session('usuario')->centro_labores)->get();
        } else {
            $list_base = BaseActiva::all();
        }
        $list_anio = Anio::select('cod_anio')->where('estado', 1)
            ->where('cod_anio', '>=', '2024')->get();
        $list_proceso = TrackingProceso::all();
        $list_estado = TrackingEstado::orderBy('id_proceso', 'ASC')->get();
        return view('logistica.tracking.detalle_tracking.index', compact(
            'list_base',
            'list_anio',
            'list_proceso',
            'list_estado'
        ));
    }

    public function traer_estado_det(Request $request)
    {
        $list_estado = TrackingEstado::where('id_proceso', $request->proceso)->get();
        return view('logistica.tracking.detalle_tracking.estado', compact('list_estado'));
    }

    public function list_det(Request $request)
    {
        $list_detalle = Tracking::get_list_detalle_tracking([
            'base' => $request->base,
            'anio' => $request->anio,
            'semana' => $request->semana,
            'estado' => $request->estado,
            'progreso' => $request->progreso
        ]);
        return view('logistica.tracking.detalle_tracking.lista', compact('list_detalle'));
    }

    public function detalle_det($id)
    {
        $get_id = Tracking::get_list_tracking(['id' => $id]);
        $get_transporte = TrackingTransporte::where('id_base', $get_id->id_origen_hacia)
            ->where('anio', $get_id->anio)->where('semana', $get_id->semana)->first();
        $list_comentario_despacho = TrackingComentario::from('tracking_comentario AS tc')
            ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                                us.usuario_apater) AS nombre"), 'tc.comentario')
            ->join('users AS us', 'us.id_usuario', '=', 'tc.id_usuario')
            ->where('tc.id_tracking', $get_id->id)
            ->where('tc.pantalla', 'DETALLE_TRANSPORTE')
            ->orderBy('tc.id', 'DESC')->get();
        $list_archivo_fardo = TrackingArchivo::where('id_tracking', $get_id->id)->where('tipo', 2)->get();
        $list_comentario_fardo = TrackingComentario::from('tracking_comentario AS tc')
            ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                                us.usuario_apater) AS nombre"), 'tc.comentario')
            ->join('users AS us', 'us.id_usuario', '=', 'tc.id_usuario')
            ->where('tc.id_tracking', $get_id->id)
            ->where('tc.pantalla', 'VERIFICACION_FARDO')
            ->orderBy('tc.id', 'DESC')->get();
        if (isset($get_transporte->id)) {
            $list_archivo_pago = TrackingTransporteArchivo::where('id_tracking_transporte', $get_transporte->id)
                ->get();
        } else {
            $list_archivo_pago = [];
        }
        $list_diferencia = TrackingDiferencia::where('id_tracking', $get_id->id)->get();
        $list_comentario_diferencia = TrackingComentario::from('tracking_comentario AS tc')
            ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                                    us.usuario_apater) AS nombre"), 'tc.comentario')
            ->join('users AS us', 'us.id_usuario', '=', 'tc.id_usuario')
            ->where('tc.id_tracking', $get_id->id)
            ->whereIn('tc.pantalla', [
                'CUADRE_DIFERENCIA',
                'DETALLE_OPERACION_DIFERENCIA'
            ])
            ->orderBy('tc.id', 'DESC')->get();
        $list_devolucion = TrackingDevolucion::from('tracking_devolucion AS td')
            ->select(
                'tg.sku',
                'tg.descripcion',
                'td.cantidad',
                'td.sustento_respuesta',
                DB::raw('CASE WHEN td.aprobacion=1 THEN "Aprobada" 
                            WHEN td.aprobacion=2 THEN "Denegada" ELSE "" END AS devolucion'),
                'td.forma_proceder',
                DB::raw("(SELECT GROUP_CONCAT(ta.archivo SEPARATOR '@@@')
                            FROM tracking_archivo ta
                            WHERE ta.id_tracking=td.id_tracking AND 
                            ta.id_producto=td.id_producto) AS archivos")
            )
            ->join('tracking_guia_remision_detalle AS tg', 'tg.id', '=', 'td.id_producto')
            ->where('td.id_tracking', $id)
            ->where('td.estado', 1)->get();
        $list_comentario_devolucion = TrackingComentario::from('tracking_comentario AS tc')
            ->select(DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres,' ',1),' ',
                            us.usuario_apater) AS nombre"), 'tc.comentario')
            ->join('users AS us', 'us.id_usuario', '=', 'tc.id_usuario')
            ->where('tc.id_tracking', $get_id->id)
            ->whereIn('tc.pantalla', [
                'SOLICITUD_DEVOLUCION',
                'EVALUACION_DEVOLUCION'
            ])
            ->orderBy('tc.id', 'DESC')->get();
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(7);
        return view('logistica.tracking.detalle_tracking.detalle', compact(
            'get_id',
            'get_transporte',
            'list_comentario_despacho',
            'list_archivo_fardo',
            'list_comentario_fardo',
            'list_archivo_pago',
            'list_diferencia',
            'list_comentario_diferencia',
            'list_devolucion',
            'list_comentario_devolucion',
            'list_notificacion',
            'list_subgerencia'
        ));
    }

    public function excel_guia_despacho($id)
    {
        $get_id = Tracking::findOrFail($id);
        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_ver_despachos_tracking ?,?', ['R', $get_id->n_requerimiento]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Guía de remisión');

        $sheet->setAutoFilter('A1:F1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(100);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:F1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:F1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'SKU');
        $sheet->setCellValue("B1", 'Color');
        $sheet->setCellValue("C1", 'Estilo');
        $sheet->setCellValue("D1", 'Talla');
        $sheet->setCellValue("E1", 'Descripción');
        $sheet->setCellValue("F1", 'Cantidad');

        $contador = 1;

        foreach ($list_detalle as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list->sku);
            $sheet->setCellValue("B{$contador}", $list->color);
            $sheet->setCellValue("C{$contador}", $list->estilo);
            $sheet->setCellValue("D{$contador}", $list->talla);
            $sheet->setCellValue("E{$contador}", $list->descripcion);
            $sheet->setCellValue("F{$contador}", $list->cantidad);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Guia de Remisión';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
