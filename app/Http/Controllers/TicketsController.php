<?php

namespace App\Http\Controllers;

use App\Models\ArchivosTickets;
use App\Models\ArchivosTicketsSoporte;
use App\Models\Area;
use App\Models\Base;
use App\Models\Complejidad;
use App\Models\Model_Perfil;
use App\Models\Modulo;
use App\Models\Notificacion;
use App\Models\Tickets;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class TicketsController extends Controller
{
    protected $input;
    protected $modelo;
    protected $modelomodulo;
    protected $modeloarea;
    protected $modelobase;
    protected $Model_Perfil;/*
    protected $modelomotivoa;
    protected $modelotipoa;*/

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->modelo = new Tickets();
        $this->modelomodulo = new Modulo();
        $this->modeloarea = new Area();
        $this->modelobase = new Base();
        $this->Model_Perfil = new Model_Perfil();/*
        $this->modelomotivoa = new Motivo_Amonestacion();
        $this->modelotipoa = new Tipo_Amonestacion();*/
    }

    public function Tickets_Vista(){
            $dato['list_plataforma'] = $this->modelomodulo::select('id_modulo AS id_plataforma', 'nom_modulo AS nom_plataforma')
                                    ->where('estado', 1)
                                    ->get();
            $dato['list_base'] = $this->modelobase->get_list_base_only();
            $dato['list_area'] = $this->modeloarea->get_list_area();

            // print_r($dato['list_plataforma']);
            //NOTIFICACIÓN-NO BORRAR
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('Tickets.index',$dato);
    }

    public function Busqueda_Tickets_Admin($busq_plataforma,$busq_base,$busq_area,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
        $dato['plataforma']=$busq_plataforma;
        $dato['base']=$busq_base;
        $dato['area']=$busq_area;
        $dato['cpiniciar']=$cpiniciar;
        $dato['cproceso']=$cproceso;
        $dato['cfinalizado']=$cfinalizado;
        $dato['cstandby']=$cstandby;
        $dato['list_tickets'] = $this->modelo->get_list_tickets($dato);

        return view('Tickets.lista_tickets_admin',$dato);
    }

    public function Busqueda_Tickets($busq_plataforma,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
            $dato['plataforma']=$busq_plataforma;
            $dato['cpiniciar']=$cpiniciar;
            $dato['cproceso']=$cproceso;
            $dato['cfinalizado']=$cfinalizado;
            $dato['cstandby']=$cstandby;
            $dato['list_tickets_usu'] = $this->modelo->get_list_tickets_usuario($dato);

            return view('Tickets.lista_tickets',$dato);
    }

    public function Excel_Tickets_Admin($plataforma,$base,$area,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
        $dato['plataforma'] = $plataforma;
        $dato['base'] = $base;
        $dato['area'] = $area;
        $dato['cpiniciar']=$cpiniciar;
        $dato['cproceso']=$cproceso;
        $dato['cfinalizado']=$cfinalizado;
        $dato['cstandby']=$cstandby;

        $list_tickets = $this->modelo->get_list_tickets($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tickets');

        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(50);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(22);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(22);

        $sheet->getStyle('A1:O1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:O1")->getFill()
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

        $sheet->getStyle("A1:O1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha de registro');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Tipo');
        $sheet->setCellValue("E1", 'Plataforma');
        $sheet->setCellValue("F1", 'Área');
        $sheet->setCellValue("G1", 'Solicitado por');
        $sheet->setCellValue("H1", 'Título');
        $sheet->setCellValue("I1", 'Descripción');
        $sheet->setCellValue("J1", 'Soporte');
        $sheet->setCellValue("K1", 'Fecha de vencimiento');
        $sheet->setCellValue("L1", 'Estado');
        $sheet->setCellValue("M1", 'Fecha de termino');
        $sheet->setCellValue("N1", 'Dificultad');
        $sheet->setCellValue("O1", 'Días sin atención');

        $contador=1;

        foreach($list_tickets as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['fecha_tabla']);
            $sheet->setCellValue("B{$contador}", $list['cod_base']);
            $sheet->setCellValue("C{$contador}", $list['cod_tickets']);
            $sheet->setCellValue("D{$contador}", $list['tipo']);
            $sheet->setCellValue("E{$contador}", $list['nom_plataforma']);
            $sheet->setCellValue("F{$contador}", ucfirst($list['nom_area_min']));
            $sheet->setCellValue("G{$contador}", ucwords($list['solicitante']));
            $sheet->setCellValue("H{$contador}", ucfirst($list['titulo_min']));
            $sheet->setCellValue("I{$contador}", $list['descrip_ticket']);
            $sheet->setCellValue("J{$contador}", ucwords($list['soporte']));
            $sheet->setCellValue("K{$contador}", $list['vence']);
            $sheet->setCellValue("L{$contador}", $list['nom_estado_tickets']);
            $sheet->setCellValue("M{$contador}", $list['termino']);
            $sheet->setCellValue("N{$contador}", $list['dificultad']);
            $sheet->setCellValue("O{$contador}", $list['diferencia_dias']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tickets';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Excel_Tickets_Usuario($plataforma,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
        $dato['plataforma'] = $plataforma;
        $dato['cpiniciar']=$cpiniciar;
        $dato['cproceso']=$cproceso;
        $dato['cfinalizado']=$cfinalizado;
        $dato['cstandby']=$cstandby;

        $list_tickets = $this->modelo->get_list_tickets_usuario($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:O1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:O1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tickets');

        $sheet->setAutoFilter('A1:O1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(50);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(22);
        $sheet->getColumnDimension('N')->setWidth(18);
        $sheet->getColumnDimension('O')->setWidth(22);

        $sheet->getStyle('A1:O1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:O1")->getFill()
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

        $sheet->getStyle("A1:O1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha de registro');
        $sheet->setCellValue("B1", 'Sede');
        $sheet->setCellValue("C1", 'Código');
        $sheet->setCellValue("D1", 'Tipo');
        $sheet->setCellValue("E1", 'Plataforma');
        $sheet->setCellValue("F1", 'Área');
        $sheet->setCellValue("G1", 'Solicitado por');
        $sheet->setCellValue("H1", 'Título');
        $sheet->setCellValue("I1", 'Descripción');
        $sheet->setCellValue("J1", 'Soporte');
        $sheet->setCellValue("K1", 'Fecha de vencimiento');
        $sheet->setCellValue("L1", 'Estado');
        $sheet->setCellValue("M1", 'Fecha de termino');
        $sheet->setCellValue("N1", 'Dificultad');
        $sheet->setCellValue("O1", 'Días sin atención');

        $contador=1;

        foreach($list_tickets as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("F{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}:O{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:O{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:O{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['fecha_tabla']);
            $sheet->setCellValue("B{$contador}", $list['cod_base']);
            $sheet->setCellValue("C{$contador}", $list['cod_tickets']);
            $sheet->setCellValue("D{$contador}", $list['tipo']);
            $sheet->setCellValue("E{$contador}", $list['nom_plataforma']);
            $sheet->setCellValue("F{$contador}", ucfirst($list['nom_area_min']));
            $sheet->setCellValue("G{$contador}", ucwords($list['solicitante']));
            $sheet->setCellValue("H{$contador}", ucfirst($list['titulo_min']));
            $sheet->setCellValue("I{$contador}", $list['descrip_ticket']);
            $sheet->setCellValue("J{$contador}", ucwords($list['soporte']));
            $sheet->setCellValue("K{$contador}", $list['vence']);
            $sheet->setCellValue("L{$contador}", $list['nom_estado_tickets']);
            $sheet->setCellValue("M{$contador}", $list['termino']);
            $sheet->setCellValue("N{$contador}", $list['dificultad']);
            $sheet->setCellValue("O{$contador}", $list['diferencia_dias']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tickets';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Modal_Tickets(){
        $dato['list_plataforma'] = $this->modelomodulo::select('id_modulo AS id_plataforma', 'nom_modulo AS nom_plataforma')
                                ->where('estado', 1)
                                ->get();

        $dato['list_plataforma']= json_decode(json_encode($dato['list_plataforma']), true);
        $dato['list_area'] = $this->modeloarea->get_list_area();
        $dato['list_usuario'] = Usuario::where('estado',1)
                            ->get();
        $dato['list_tipo_tickets'] = DB::table('tipo_tickets')
                                ->where('estado', 1)
                                ->orderBy('nom_tipo_tickets', 'ASC')
                                ->get();

        $dato['list_tipo_tickets'] = json_decode(json_encode($dato['list_tipo_tickets']), true);
        return view('Tickets.modal_registrar',$dato);
    }

    public function Insert_Tickets(){
        $rules = [
            'id_colaborador_i' => 'not_in:0',
            'id_tipo_tickets_i' => 'required|not_in:0',
            'plataforma_i'      => 'required|not_in:0',
            'titulo_tickets_i'  => 'required|string',
            'descrip_ticket_i'  => 'required|string',
        ];

        $messages = [
            'id_colaborador_i' => 'Debe seleccionar un colaborador.',
            'id_tipo_tickets_i.not_in' => 'Debe seleccionar un tipo.',
            'plataforma_i.not_in'      => 'Debe seleccionar una plataforma.',
            'titulo_tickets_i.required' => 'Debe ingresar un título.',
            'descrip_ticket_i.required' => 'Debe ingresar una descripción.',
        ];

        // Validar los datos
        $this->input->validate($rules, $messages);
            $dato['id_usuario']= $this->input->post("id_colaborador_i");
            $dato['id_tipo_tickets']= $this->input->post("id_tipo_tickets_i");
            $dato['plataforma']= $this->input->post("plataforma_i");
            $dato['titulo_tickets']= $this->input->post("titulo_tickets_i");
            $dato['descrip_ticket']= $this->input->post("descrip_ticket_i");

            $dato['aniodereg']= date('Y');
            if($dato['id_tipo_tickets'] == 1){
                $requerimiento = "REQ";
            }else{
                $requerimiento = "INC";
            }
            if($dato['plataforma'] == 1){
                $plataforma = "INT";
            }elseif($dato['plataforma'] == 3){
                $plataforma = "SIS";
            }else{
                $plataforma = "INF";
            }
            $anio=date('Y');
            $totalRows_t = Tickets::whereYear('fec_reg', $dato['aniodereg'])
                    ->where('plataforma', $dato['plataforma'])
                    ->where('id_tipo_tickets', $dato['id_tipo_tickets'])
                    ->count();
            $aniof=substr($anio, 2,2);
            if($totalRows_t<9){
                $codigofinal=$requerimiento.$aniof.$plataforma."0000".($totalRows_t+1);
            }
            if($totalRows_t>8 && $totalRows_t<99){
                    $codigofinal=$requerimiento.$aniof.$plataforma."000".($totalRows_t+1);
            }
            if($totalRows_t>98 && $totalRows_t<999){
                $codigofinal=$requerimiento.$aniof.$plataforma."00".($totalRows_t+1);
            }
            if($totalRows_t>998 && $totalRows_t<9999){
                $codigofinal=$requerimiento.$aniof.$plataforma."0".($totalRows_t+1);
            }
            if($totalRows_t>9998)
            {
                $codigofinal=$requerimiento.$aniof.$plataforma.($totalRows_t+1);
            }
            $dato['cod_tickets']=$codigofinal;

            $total = Tickets::where('cod_tickets', $dato['cod_tickets'])
                ->where('titulo_tickets', $dato['titulo_tickets'])
                ->where('estado', 1)
                ->count();

            if ($total>0){
                echo "error";
            }else{
                $id_usuario = session('usuario')->id_usuario; // Obtener usuario de la sesión

                $ticket = Tickets::create([
                    'id_usuario_solic' => $dato['id_usuario'],
                    'id_usuario_soporte' => 0,
                    'link' => 0,
                    'verif_email' => 0,
                    'dificultad' => 0,
                    'finalizado_por' => 0,
                    'cod_tickets' => $dato['cod_tickets'],
                    'id_tipo_tickets' => $dato['id_tipo_tickets'],
                    'plataforma' => $dato['plataforma'],
                    'titulo_tickets' => $dato['titulo_tickets'],
                    'descrip_ticket' => $dato['descrip_ticket'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => $id_usuario,
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ]);
                $lastId = $ticket->id_tickets;

                if($this->input->hasFile("files_i")){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        for($count = 0; $count<count($_FILES["files_i"]["name"]); $count++){
                            $path = $_FILES["files_i"]["name"][$count];
                            $temp = explode(".",$_FILES['files_i']['name'][$count]);
                            $source_file = $_FILES['files_i']['tmp_name'][$count];

                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Ticket_".$dato['cod_tickets']."_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".strtolower($ext);

                            $dato['ruta'] = "https://lanumerounocloud.com/intranet/TICKET/".$nombre;
                            $dato['ruta_nombre'] = $nombre;

                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"TICKET/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                ArchivosTickets::create([
                                    'id_usuario_solic' => $dato['id_usuario'],
                                    'cod_tickets' => $dato['cod_tickets'],//borrar al dar de baja intranet antiguo
                                    'id_ticket' => $lastId,
                                    'archivos' => $dato['ruta'],
                                    'nom_archivos' => $dato['ruta_nombre'],
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'user_reg' => $id_usuario,
                                ]);
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }

                $mail = new PHPMailer(true);

                $usuario_mail=$this->Model_Perfil->get_id_usuario($dato['id_usuario']);
                $plataforma_mail = Modulo::where('id_modulo', $dato['plataforma'])
                            ->get();

                $list_correos = Usuario::query();
                if ($dato['plataforma'] == 1) {
                    $list_correos->where('id_usuario', 2655);
                } elseif ($dato['plataforma'] == 2) {
                    $list_correos->where('id_usuario', 629);
                } elseif ($dato['plataforma'] == 3) {
                    $list_correos->where('id_usuario', 173);
                }

                $list_correos = $list_correos->get();

                if($dato['id_tipo_tickets'] == 1){
                    $tipo_correo="requerimiento";
                }else{
                    $tipo_correo="incidente";
                }

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Port     =  587;
                    $mail->setFrom('intranet@lanumero1.com.pe','TICKET POR INICIAR');

                    $mail->addAddress($usuario_mail[0]['emailp']);
                    foreach($list_correos as $list){
                        $mail->addAddress($list['emailp']);
                    }

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $dato['cod_tickets']." - ".$dato['titulo_tickets'];

                    $mail->Body = "<h1><span style='color:#70BADB'>TICKET POR INICIAR</span></h1>
                                    <p>¡Hola ".$usuario_mail[0]['usuario_nombres']."!</p>
                                    <p>Tu ".$tipo_correo." ha sido registrado exitosamente.</p>
                                    <p>Plataforma: ".$plataforma_mail[0]['nom_modulo'].".</p>
                                    <p>Título: ".$dato['titulo_tickets'].".</p>
                                    <p>Descripción: ".$dato['descrip_ticket'].".</p>";

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

    }

    public function Modal_Update_Tickets($id_tickets){
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['list_tipo_tickets'] = DB::table('tipo_tickets')
                            ->where('estado', 1)
                            ->orderBy('nom_tipo_tickets', 'ASC')
                            ->get();

        $dato['list_tipo_tickets'] = json_decode(json_encode($dato['list_tipo_tickets']), true);
        $dato['list_plataforma'] = $this->modelomodulo::select('id_modulo AS id_plataforma', 'nom_modulo AS nom_plataforma')
                            ->where('estado', 1)
                            ->get();

        $dato['list_plataforma']= json_decode(json_encode($dato['list_plataforma']), true);
        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado', 1)
                                ->where('id_ticket', $dato['get_id'][0]['id_tickets'])
                                ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                                ->get();
        // print_r($dato['get_id_files_tickets']);
        return view('Tickets.modal_editar',$dato);
    }

    public function Update_Tickets(){
        $this->input->validate([
            'id_tipo_tickets_u' => 'required|not_in:0',
            'plataforma_u' => 'required|not_in:0',
            'titulo_tickets_u' => 'required|string|max:255',
            'descrip_ticket_u' => 'required|string',
        ], [
            // Mensajes de validación personalizados
            'id_tipo_tickets_u.not_in' => 'Debe seleccionar tipo.',
            'plataforma_u.not_in' => 'Debe seleccionar plataforma.',
            'titulo_tickets_u.required' => 'Debe ingresar título.',
            'descrip_ticket_u.required' => 'Debe ingresar una descripción.',
        ]);
            $dato['id_tickets']= $this->input->post("id_tickets");
            $dato['id_tipo_tickets']= $this->input->post("id_tipo_tickets_u");
            $dato['plataforma']= $this->input->post("plataforma_u");
            $dato['titulo_tickets']= $this->input->post("titulo_tickets_u");
            $dato['descrip_ticket']= $this->input->post("descrip_ticket_u");
            Tickets::where('id_tickets', $dato['id_tickets'])
            ->update([
                'id_tipo_tickets' => $dato['id_tipo_tickets'],
                'plataforma' => $dato['plataforma'],
                'titulo_tickets' => addslashes($dato['titulo_tickets']),
                'descrip_ticket' => addslashes($dato['descrip_ticket']),
                'fec_act' => Carbon::now(),
                'user_act' => session('usuario')->id_usuario,
            ]);

            $get_id = $this->modelo->get_id_ticket($dato['id_tickets']);
            $dato['cod_tickets'] = $get_id[0]['cod_tickets'];
            $dato['id_usuario'] = $get_id[0]['id_usuario_solic'];

            if($this->input->hasFile("files_u")){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    for($count = 0; $count<count($_FILES["files_u"]["name"]); $count++){
                        $path = $_FILES["files_u"]["name"][$count];
                        $temp = explode(".",$_FILES['files_u']['name'][$count]);
                        $source_file = $_FILES['files_u']['tmp_name'][$count];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="Ticket_".$dato['cod_tickets']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".strtolower($ext);

                        $dato['ruta'] = "https://lanumerounocloud.com/intranet/TICKET/".$nombre;
                        $dato['ruta_nombre'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"TICKET/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            // Crear un nuevo registro en la tabla `archivos_tickets`
                            ArchivosTickets::create([
                                'id_usuario_solic' => $dato['id_usuario'],
                                'cod_tickets' => $dato['cod_tickets'],
                                'id_ticket' => $dato['id_tickets'],
                                'archivos' => $dato['ruta'],
                                'nom_archivos' => $dato['ruta_nombre'],
                                'estado' => 1,
                                'fec_reg' => Carbon::now(),
                                'user_reg' => session('usuario')->id_usuario,
                            ]);
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }
    }

    public function Descargar_Archivo_Ticket($id_archivo){
        // Obtiene el archivo y la URL de la configuración
        $getFile = ArchivosTickets::where('id_archivos_tickets', $id_archivo)->first();

        // Verifica que los datos existan
        if (!$getFile) {
            return response()->json(['error' => 'Archivo o configuración no encontrados'], 404);
        }

        // Construye la URL completa del archivo
        $fileUrl = $getFile->archivos;
        $fileName = basename($fileUrl);

        // Usa una función para descargar el archivo desde el FTP
        try {
            $fileContent = file_get_contents($fileUrl); // Descarga el archivo desde el FTP
            if ($fileContent === false) {
                throw new \Exception("No se pudo acceder al archivo en la URL: $fileUrl");
            }

            // Devuelve el archivo como una descarga
            return response($fileContent)
                ->header('Content-Type', 'application/octet-stream')
                ->header('Content-Disposition', "attachment; filename=\"$fileName\"");
        } catch (\Exception $e) {
            // Error al descargar el archivo
            return response()->json(['error' => 'No se pudo descargar el archivo: ' . $e->getMessage()], 500);
        }
    }
    
    public function Delete_Archivo_Ticket(){
        $id_archivo = $this->input->post('image_id');
        $dato['get_file'] = ArchivosTickets::where('id_archivos_tickets', $id_archivo)->get();
        ArchivosTickets::where('id_archivos_tickets', $id_archivo)->delete();
        
        if (file_exists($dato['get_file'][0]->archivo)) {
            unlink($dato['get_file'][0]->archivo);
        }
    }

    public function Modal_Ver_Tickets($id_tickets){
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['list_tipo_tickets'] = DB::table('tipo_tickets')
                            ->where('estado', 1)
                            ->orderBy('nom_tipo_tickets', 'ASC')
                            ->get();

        $dato['list_tipo_tickets'] = json_decode(json_encode($dato['list_tipo_tickets']), true);
        $dato['list_plataforma'] = $this->modelomodulo::select('id_modulo AS id_plataforma', 'nom_modulo AS nom_plataforma')
                            ->where('estado', 1)
                            ->get();

        $dato['list_plataforma']= json_decode(json_encode($dato['list_plataforma']), true);
        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado', 1)
                                ->where('cod_tickets', $dato['get_id'][0]['cod_tickets'])
                                ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                                ->get();
        return view('Tickets.modal_ver',$dato);
    }

    public function Delete_Tickets_Vista(){
        $dato['id_tickets']= $this->input->post("id_tickets");
        // Actualizar el estado del ticket
        Tickets::where('id_tickets', $dato['id_tickets'])
            ->update([
                'estado' => 5,
                'fec_eli' => Carbon::now(),
                'user_eli' => session('usuario')->id_usuario,
            ]);
    }

    public function Modal_Ver_Tickets_Admin($id_tickets){
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado', 1)
                                ->where('cod_tickets', $dato['get_id'][0]['cod_tickets'])
                                ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                                ->get();
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['list_encargado'] = $this->modelo->get_list_encargados_tickets();
        $dato['list_estado'] = DB::table('estado_tickets')
                        ->where('estado', 1)
                        ->orderBy('id_estado_tickets', 'ASC')
                        ->get();
        $dato['list_estado']= json_decode(json_encode($dato['list_estado']), true);

        $dato['list_complejidad'] = Complejidad::select('complejidad.*', 'modulo.nom_modulo')
                        ->leftJoin('modulo', 'complejidad.id_modulo', '=', 'modulo.id_modulo')
                        ->where('complejidad.estado', 1)
                        ->get();
        $dato['list_complejidad']= json_decode(json_encode($dato['list_complejidad']), true);

        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado',1)
                            ->where('id_ticket', $dato['get_id'][0]['id_tickets'])
                            ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                            ->get();

        $dato['get_id_files_tickets_soporte'] = ArchivosTicketsSoporte::where('id_ticket', $dato['get_id'][0]['id_tickets'])
                            ->orderBy('id_archivos_tickets_soporte', 'ASC')
                            ->get();
        return view('Tickets.modal_ver_admin',$dato);
    }

    public function delete_archivos_tickets() {
        $id_archivos_tickets = $this->input->post('image_id');
        $get_file = $this->Model_Corporacion->get_id_archivos_tickets($id_archivos_tickets);

        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
        if((!$con_id) || (!$lr)){
            echo "No se conecto";
        }else{
            echo "Se conecto";

            // Eliminar el archivo en el servidor FTP
            $file_to_delete = "TICKET/".$get_file[0]['nom_archivos']; // Ruta del archivo que deseas eliminar

            if (ftp_delete($con_id, $file_to_delete)) {
                // El archivo se eliminó exitosamente
                echo "Archivo eliminado correctamente.";

                $this->Model_Corporacion->delete_archivos_tickets($id_archivos_tickets);
            } else {
                // No se pudo eliminar el archivo
                echo "Error al eliminar el archivo.";
            }
        }
    }

    public function delete_archivos_tickets_soporte() {
        $id_archivos_tickets_soporte = $this->input->post('image_id');
        $get_file = $this->Model_Corporacion->get_id_archivos_tickets_soporte($id_archivos_tickets_soporte);

        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
        if((!$con_id) || (!$lr)){
            echo "No se conecto";
        }else{
            echo "Se conecto";

            // Eliminar el archivo en el servidor FTP
            $file_to_delete = "TICKET/".$get_file[0]['nom_archivos']; // Ruta del archivo que deseas eliminar

            if (ftp_delete($con_id, $file_to_delete)) {
                // El archivo se eliminó exitosamente
                echo "Archivo eliminado correctamente.";

                $this->Model_Corporacion->delete_archivos_tickets_soporte($id_archivos_tickets_soporte);
            } else {
                // No se pudo eliminar el archivo
                echo "Error al eliminar el archivo.";
            }
        }
    }

    public function Modal_Update_Tickets_Admin($id_tickets){
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado', 1)
                                ->where('cod_tickets', $dato['get_id'][0]['cod_tickets'])
                                ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                                ->get();
        $dato['get_id'] = $this->modelo->get_id_ticket($id_tickets);
        $dato['list_encargado'] = $this->modelo->get_list_encargados_tickets();
        $dato['list_estado'] = DB::table('estado_tickets')
                        ->where('estado', 1)
                        ->orderBy('id_estado_tickets', 'ASC')
                        ->get();
        $dato['list_estado']= json_decode(json_encode($dato['list_estado']), true);

        $dato['list_complejidad'] = Complejidad::select('complejidad.*', 'modulo.nom_modulo')
                        ->leftJoin('modulo', 'complejidad.id_modulo', '=', 'modulo.id_modulo')
                        ->where('complejidad.estado', 1)
                        ->orderBy('descripcion', 'ASC')
                        ->get();
        $dato['list_complejidad']= json_decode(json_encode($dato['list_complejidad']), true);

        $dato['get_id_files_tickets'] = ArchivosTickets::where('estado',1)
                            ->where('id_ticket', $dato['get_id'][0]['id_tickets'])
                            ->where('id_usuario_solic', $dato['get_id'][0]['id_usuario_solic'])
                            ->get();

        $dato['get_id_files_tickets_soporte'] = ArchivosTicketsSoporte::where('id_ticket', $dato['get_id'][0]['id_tickets'])
                            ->orderBy('id_archivos_tickets_soporte', 'ASC')
                            ->get();
        return view('Tickets.modal_editar_admin', $dato);
    }

    public function Update_Tickets_Admin(){
        // print_r($this->input->post('estado'));
        $rules = [
            'finalizado_por' => 'required|not_in:0',
            'f_fin' => 'required',
            'estado' => 'required|not_in:0',
            'dificultad' => 'required|not_in:0',
        ]; 
        $messages = [
            // Mensajes de validación personalizados
            'finalizado_por.not_in' => 'Debe seleccionar soporte.',
            'f_fin.required' => 'Debe ingresar fecha.',
            'estado.required' => 'Debe escoger estado.',
            'dificultad.not_in' => 'Debe escoger dificultad.',
        ];
        if ($this->input->post('estado')==3) {
            $rules = ['f_fin_real' => 'required||date'];
            $messages = ['f_fin_real.required' => 'Debe ingresar fecha de termino'];
        }
        $this->input->validate($rules, $messages);
            $dato['id_tickets']= $this->input->post("id_tickets");
            $dato['finalizado_por']= $this->input->post("finalizado_por");
            $dato['f_fin']= $this->input->post("f_fin");
            $dato['estado']= $this->input->post("estado");
            $dato['f_fin_real']= $this->input->post("f_fin_real");
            $dato['dificultad']= $this->input->post("dificultad");
            $dato['coment_ticket']= $this->input->post("coment_ticket");

            $dato['get_bd'] = $this->modelo->get_id_ticket($dato['id_tickets']);
            $dato['cod_tickets'] = $dato['get_bd'][0]['cod_tickets'];

            if($dato['get_bd'][0]['fecha_vencimiento']==NULL ||
            $dato['get_bd'][0]['fecha_vencimiento']=="0000-00-00" ||
            $dato['get_bd'][0]['fecha_vencimiento']==""){
                $dato['fecha_vencimiento'] = $this->input->post("f_fin");
            }else{
                $dato['fecha_vencimiento'] = "";
            }

            // Construye los datos para actualizar
            $updateData = [
                'finalizado_por' => $dato['finalizado_por'],
                'f_fin' => $dato['f_fin'],
                'f_fin_real' => $dato['f_fin_real'],
                'dificultad' => $dato['dificultad'],
                'coment_ticket' => $dato['coment_ticket'],
                'estado' => $dato['estado'],
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ];

            // Agrega 'fecha_vencimiento' solo si no está vacío
            if (!empty($dato['fecha_vencimiento'])) {
                $updateData['fecha_vencimiento'] = $dato['fecha_vencimiento'];
            }
            // Realiza la actualización en la tabla 'tickets'
            Tickets::where('id_tickets', $dato['id_tickets'])->update($updateData);

            if($this->input->hasFile("filesoporte")){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    for($count = 0; $count<count($_FILES["filesoporte"]["name"]); $count++){
                        $path = $_FILES["filesoporte"]["name"][$count];
                        $temp = explode(".",$_FILES['filesoporte']['name'][$count]);
                        $source_file = $_FILES['filesoporte']['tmp_name'][$count];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="Ticket_".$dato['cod_tickets']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".strtolower($ext);

                        $dato['ruta'] = "https://lanumerounocloud.com/intranet/TICKET/".$nombre;
                        $dato['ruta_nombre'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"TICKET/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            $id_usuario = session('usuario')->id_usuario;

                            ArchivosTicketsSoporte::create([
                                'id_usuario_soporte' => $id_usuario,
                                'cod_tickets' => $dato['cod_tickets'],
                                'id_ticket' => $dato['id_tickets'],
                                'archivos' => $dato['ruta'],
                                'nom_archivos' => $dato['ruta_nombre'],
                                'estado' => 1,
                                'fec_reg' => now(),
                                'user_reg' => $id_usuario,
                            ]);

                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }
            
            if(($dato['estado']==2 || $dato['estado']==3) && $dato['get_bd'][0]['estado']!=$dato['estado']){
                $mail = new PHPMailer(true);

                $get_id = $this->modelo->get_id_ticket($dato['id_tickets']);
                
                $list_correos = Usuario::query();
                if ($get_id[0]['plataforma'] == 1) {
                    $list_correos->where('id_usuario', 2655);
                } elseif ($get_id[0]['plataforma'] == 2) {
                    $list_correos->where('id_usuario', 629);
                } elseif ($get_id[0]['plataforma'] == 3) {
                    $list_correos->where('id_usuario', 173);
                }

                $list_correos = $list_correos->get();

                if($get_id[0]['id_tipo_tickets']==1){
                    $tipo_correo="requerimiento";
                }else{
                    $tipo_correo="incidente";
                }

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Port     =  587;
                    if($dato['estado']==2){
                        $mail->setFrom('intranet@lanumero1.com.pe','TICKET EN PROCESO');
                    }else{
                        $mail->setFrom('intranet@lanumero1.com.pe','TICKET ATENDIDO');
                    }

                    $mail->addAddress($get_id[0]['emailp']);
                    foreach($list_correos as $list){
                        $mail->addAddress($list['emailp']);
                    }

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $get_id[0]['cod_tickets']." - ".$get_id[0]['titulo_tickets'];

                    if($dato['estado']==2){
                        $mail->Body = "<h1><span style='color:#70BADB'>TICKET EN PROCESO<span></h1>
                                        <p>¡Hola ".$get_id[0]['usuario_nombres']."!</p>
                                        <p>Tu ".$tipo_correo." registrado el día ".$get_id[0]['fecha_correo']." se encuentra en proceso de Atención.</p>";
                    }else{
                        $mail->Body = "<h1><span style='color:#70BADB'>TICKET ATENDIDO</span></h1>
                                        <p>¡Hola ".$get_id[0]['usuario_nombres']."!</p>
                                        <p>Tu ".$tipo_correo." registrado el día ".$get_id[0]['fecha_correo']." se encuentra en atendido.</p>
                                        <p>Solución:</p>
                                        <p>".$get_id[0]['coment_ticket']."</p>
                                        <p>Atendido por: ".$get_id[0]['encargado']."</p>";
                    }

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
    }
}
