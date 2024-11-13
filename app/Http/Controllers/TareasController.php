<?php

namespace App\Http\Controllers;

use App\Models\ArchivoGestionPendiente;
use App\Models\ArchivoPendiente;
use App\Models\ArchivoTemporalPendiente;
use App\Models\Area;
use App\Models\Base;
use App\Models\Config;
use App\Models\CotizacionPendiente;
use App\Models\CotizacionPendienteTemporal;
use App\Models\Especialidad;
use App\Models\MiCalendario;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\Pendiente;
use App\Models\PendienteHistorialC;
use App\Models\Subitem;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TareasController extends Controller
{
    protected $input;
    protected $modelo;
    protected $modelobase;
    protected $Model_Perfil;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->modelo = new Pendiente();
        $this->modelobase = new Base();
        $this->Model_Perfil = new Model_Perfil();
        // $this->modeloccvh = new CuadroControlVisualHorario();
        // $this->modelousuarios = new Usuario();
    }
    //----------------------------------------GESTIÓN DE PENDIENTES---------------------------------------
    public function Gestion_Pendiente(){
            //NOTIFICACIÓN-NO BORRAR
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('Gestion_Pendiente.index',$dato);
    }

    public function Cargar_Mis_Tareas(){
            $dato['list_area'] = $this->modelo->get_list_area_pendiente();
            $dato['list_base'] = json_decode(json_encode($this->modelobase->get_list_todas_bases_agrupadas()), true);
            $dato['get_id_resp'] = $this->modelo->get_id_responsable_gestion_pendiente();
            $dato['list_responsable'] = $this->modelo->get_list_responsable_gestion_pendiente($dato);
            return view('Gestion_Pendiente.mis_tareas',$dato);
    }

    public function Lista_Mis_Tareas(){
            $dato['id_area']= $this->input->post("id_area");
            $dato['base']= $this->input->post("base");
            $dato['cpiniciar']= $this->input->post("cpiniciar");
            $dato['cproceso']= $this->input->post("cproceso");
            $dato['cfinalizado']= $this->input->post("cfinalizado");
            $dato['cstandby']= $this->input->post("cstandby");
            $dato['mis_tareas']= $this->input->post("mis_tareas");
            $dato['mi_equipo']= $this->input->post("mi_equipo");
            $dato['responsablei']= $this->input->post("responsablei");
            $dato['list_gestion_pendiente'] = $this->modelo->get_list_gestion_pendiente($dato);
            return view('Gestion_Pendiente.lista_pendientes',$dato);
    }

    public function Modal_Update_Gestion_Pendiente($id_pendiente){
        $dato['get_id'] = $this->modelo->get_list_pendiente($id_pendiente);
        $dato['list_responsable'] = Usuario::get_list_responsable_area($dato['get_id'][0]['id_area']);
        $dato['list_estado'] = DB::table('estado_tickets')
                            ->where('estado', 1)
                            ->orderBy('id_estado_tickets', 'ASC')
                            ->get();
        $dato['list_archivo'] = ArchivoPendiente::where('id_pendiente', $id_pendiente)
                            ->get();
        $dato['list_gestion_archivo'] = ArchivoGestionPendiente::where('id_pendiente', $id_pendiente)
                            ->get();
        $dato['historial_comentarios'] = PendienteHistorialC::get_list_historial_comentario_pendiente($id_pendiente);
        $dato['url'] = Config::where('descrip_config', 'Pendientes_Doc')
                    ->where('estado', 1)
                    ->get();
        $get_id = $this->Model_Perfil->get_id_usuario($dato['get_id'][0]['id_usuario']);

        if($get_id[0]['nom_area']=="TIENDAS"){
            $dato['mostrar'] = 1;
            $dato['list_subitem'] = Subitem::select('subitem.id_subitem', 'subitem.nom_subitem')
                            ->leftJoin('item', 'item.id_item', '=', 'subitem.id_item')
                            ->where('item.id_area', $dato['get_id'][0]['id_area'])
                            ->where('subitem.estado', 1)
                            ->get();
        }else{
            $dato['mostrar'] = 0;
        }

        return view('Gestion_Pendiente.modal_editar',$dato);
    }

    public function Update_Gestion_Pendiente(){
            $dato['id_pendiente']= $this->input->post("id_pendiente");
            $dato['id_subitem']= $this->input->post("id_subitem");
            $dato['id_responsable']= $this->input->post("id_responsable");
            $dato['f_inicio']= $this->input->post("f_inicio");
            $dato['estado']= $this->input->post("estado");
            $dato['f_entrega']= $this->input->post("f_entrega");
            $dato['dificultad']= $this->input->post("dificultad");
            $dato['comentario']= $this->input->post("comentario");

            $dato['get_bd'] = $this->modelo->get_list_pendiente($dato['id_pendiente']);

            if($dato['get_bd'][0]['fecha_vencimiento']==NULL ||
            $dato['get_bd'][0]['fecha_vencimiento']=="0000-00-00" ||
            $dato['get_bd'][0]['fecha_vencimiento']==""){
                $dato['fecha_vencimiento'] = $this->input->post("f_inicio");
            }else{
                $dato['fecha_vencimiento'] = "";
            }
    
            // Preparar los datos para la actualización
            $data = [
                'id_subitem' => $dato['id_subitem'],
                'id_responsable' => $dato['id_responsable'],
                'f_inicio' => $dato['f_inicio'],
                'estado' => $dato['estado'],
                'f_entrega' => $dato['f_entrega'],
                'dificultad' => $dato['dificultad'],
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ];
            
            // Agregar fecha_vencimiento solo si tiene valor
            if (!empty($dato['fecha_vencimiento'])) {
                $data['fecha_vencimiento'] = $dato['fecha_vencimiento'];
            }
            
            Pendiente::where('id_pendiente', $dato['id_pendiente'])->update($data);

            $get_id = $this->modelo->get_list_pendiente($dato['id_pendiente']);

            $get_area = Area::where('id_area', $get_id[0]['id_area']);
            $cod_base= $get_id[0]['cod_base'];

            if (isset($_FILES['files_u']) && $_FILES['files_u']['error'] == 0) {
                if($_FILES['files_u']['name']!=""){
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
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Gestion_Pendiente_".$fecha."_".rand(10,999);
                            $nombre = $nombre_soli.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["files_u"]["type"][$count];
                            $source_file = $_FILES["files_u"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["files_u"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["files_u"]["size"][$count];
                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"PENDIENTES/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato['ruta'] = $nombre;
                                ArchivoGestionPendiente::create([
                                    'id_pendiente' => $dato['id_pendiente'],
                                    'archivo' => $dato['ruta'],
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'user_reg' => session('usuario')->id_usuario,
                                ]);
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }
                }
            } else {
                echo "Error en la carga del archivo.";
            }

            $dato['get_pendiente'] = $this->modelo->get_list_pendiente($dato['id_pendiente']);

            if(($dato['estado']==2 || $dato['estado']==3) && $dato['get_bd'][0]['estado']!=$dato['estado']){
                $dato['get_ticket'] = $this->modelo->get_list_pendiente($dato['id_pendiente']);
                $dato['list_comentario'] = PendienteHistorialC::get_list_historial_comentario_pendiente($dato['id_pendiente']);

                //Solicitante
                $id_usuario= $dato['get_pendiente'][0]['id_usuario'];
                $soli = $this->Model_Perfil->get_id_usuario($id_usuario);

                //Responsable
                $id_usuario2= $dato['get_bd'][0]['id_responsable'];
                $resp = $this->Model_Perfil->get_id_usuario($id_usuario2);

                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Puerto     =  587;
                    $mail->setFrom('intranet@lanumero1.com.pe','PENDIENTE');

                    if($soli[0]['encargado_p']=="SI"){
                        $cod_base=$soli[0]['centro_labores'];
                        if($cod_base[0]=="B"){
                            $correo1="base".substr($cod_base, 1, 2)."@lanumero1.com.pe";
                            $mail->addAddress($correo1);
                        }

                    }
                    $correo=$soli[0]['emailp'];
                    $mail->addAddress($correo);
                    $mail->addAddress($resp[0]['emailp']);
                    $data = $this->Model_Corporacion->get_data_usuario_activo_xid('174');
                    if(count($data)>0){
                        $mail->addCC($data[0]['emailp']);
                    }

                    $mail->isHTML(true);

                    if($dato['estado']==2){
                        $mail->Subject = "En proceso";
                        $mailContent = $this->load->view('Pendiente/mail_en_proceso', $dato, TRUE);
                    }elseif($dato['estado']==3){
                        $mail->Subject = "Completado";
                        $mailContent = $this->load->view('Pendiente/mail_completado', $dato, TRUE);
                    }

                    $mail->Body= $mailContent;

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

            if($dato['comentario']!=""){
                ArchivoGestionPendiente::create([
                    'id_pendiente' => $dato['id_pendiente'],
                    'archivo' => $dato['ruta'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);

                $dato['get_ticket'] = $this->modelo->get_list_pendiente($dato['id_pendiente']);
                $dato['list_comentario'] = PendienteHistorialC::get_list_historial_comentario_pendiente($dato['id_pendiente']);
                $id_usuario= $get_id[0]['id_responsable'];
                $resp = $this->Model_Perfil->get_id_usuario($get_id[0]['id_responsable']);
/*
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
                    $mail->setFrom('intranet@lanumero1.com.pe','PENDIENTE');

                    $mail->addAddress($resp[0]['emailp']);

                    $mail->isHTML(true);

                    $mail->Subject = "Nuevo Comentario";

                    $mailContent = view('Pendiente.mail_comentario', $dato, TRUE);
                    $mail->Body= $mailContent;

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }*/
            }

            $validar = MiCalendario::where('id_pendiente', $dato['id_pendiente'])
                    ->where('estado', 1)
                    ->exists();

            if($validar){
                $get_id = $this->modelo->get_list_pendiente($dato['id_pendiente']);
                $dato['id_usuario']= $get_id[0]['id_responsable'];
                $dato['titulo']= $get_id[0]['cod_pendiente'];
                $dato['fec_de']= $dato['f_inicio']." 00:00:00";
                $dato['fec_hasta']= $dato['f_entrega']." 23:59:00";
                $dato['descripcion']= $get_id[0]['descripcion'];

                MiCalendario::create([
                    'id_usuario' => $dato['id_usuario'],
                    'titulo' => $dato['titulo'],
                    'fec_de' => $dato['fec_de'],
                    'fec_hasta' => $dato['fec_hasta'],
                    'descripcion' => $dato['descripcion'],
                    'id_pendiente' => $dato['id_pendiente'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);
            }
    }
/*
    public function Descargar_Archivo_Gestion_Pendiente($id_archivo) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Corporacion->get_id_archivo_gestion_pendiente($id_archivo);
            $image = $dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo_Gestion_Pendiente() {
        $id_archivo = $this->input->post('image_id');
        $dato['get_file'] = $this->Model_Corporacion->get_id_archivo_gestion_pendiente($id_archivo);

        if (file_exists($dato['get_file'][0]['archivo'])) {
            unlink($dato['get_file'][0]['archivo']);
        }
        $this->Model_Corporacion->delete_archivo_gestion_pendiente($id_archivo);
    }
*/
    public function Modal_Ver_Gestion_Pendiente($id_pendiente){
            $dato['get_id'] = $this->modelo->get_list_pendiente($id_pendiente);
            $dato['list_responsable'] = Usuario::get_list_responsable_area($dato['get_id'][0]['id_area']);
            $dato['list_estado'] = DB::table('estado_tickets')
                                ->where('estado', 1)
                                ->orderBy('id_estado_tickets', 'ASC')
                                ->get();
            $dato['list_archivo'] = ArchivoPendiente::where('id_pendiente', $id_pendiente)
                                ->get();
            $dato['list_gestion_archivo'] = ArchivoGestionPendiente::where('id_pendiente', $id_pendiente)
                                ->get();
            $dato['historial_comentarios'] = PendienteHistorialC::get_list_historial_comentario_pendiente($id_pendiente);
            $dato['url'] = Config::where('descrip_config', 'Pendientes_Doc')
                        ->where('estado', 1)
                        ->get();
            $get_id = $this->Model_Perfil->get_id_usuario($dato['get_id'][0]['id_usuario']);

            if($get_id[0]['nom_area']=="TIENDAS"){
                $dato['mostrar'] = 1;
                $dato['list_subitem'] = Subitem::select('subitem.id_subitem', 'subitem.nom_subitem')
                                ->leftJoin('item', 'item.id_item', '=', 'subitem.id_item')
                                ->where('item.id_area', $dato['get_id'][0]['id_area'])
                                ->where('subitem.estado', 1)
                                ->get();
            }else{
                $dato['mostrar'] = 0;
            }

            return view('Gestion_Pendiente.modal_ver',$dato);
    }

    public function Excel_Gestion_Pendiente($id_area=null,$base=null,$cpiniciar,$cproceso,$cfinalizado,$cstandby,$mis_tareas,$mi_equipo,$responsablei){
        $dato['id_area']= $id_area;
        $dato['base']= $base;
        $dato['cpiniciar']= $cpiniciar;
        $dato['cproceso']= $cproceso;
        $dato['cfinalizado']= $cfinalizado;
        $dato['cstandby']= $cstandby;
        $dato['mis_tareas']= $mis_tareas;
        $dato['mi_equipo']= $mi_equipo;
        $dato['responsablei']= $responsablei;
        $list_gestion_pendiente = $this->modelo->get_list_gestion_pendiente($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Gestión de Pendientes');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(22);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(50);
        $sheet->getColumnDimension('H')->setWidth(50);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(25);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(22);

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
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

        $sheet->getStyle("A1:M1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Fecha de registro');
        $sheet->setCellValue('B1', 'Sede');
        $sheet->setCellValue('C1', 'Código');
        $sheet->setCellValue('D1', 'Tipo');
        $sheet->setCellValue('E1', 'Area');
        $sheet->setCellValue('F1', 'Título');
        $sheet->setCellValue('G1', 'Descripción');
        $sheet->setCellValue('H1', 'Etiqueta');
        $sheet->setCellValue('I1', 'Solicitante');
        $sheet->setCellValue('J1', 'Asignado a');
        $sheet->setCellValue('K1', 'Fecha de vencimiento');
        $sheet->setCellValue('L1', 'Estado');
        $sheet->setCellValue('M1', 'Fecha de termino');

        $contador=1;

        foreach($list_gestion_pendiente as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['fec_reg']);
            $sheet->setCellValue("B{$contador}", $list['cod_base']);
            $sheet->setCellValue("C{$contador}", $list['cod_pendiente']);
            $sheet->setCellValue("D{$contador}", ucfirst($list['nom_tipo_tickets']));
            $sheet->setCellValue("E{$contador}", ucfirst($list['nom_area_min']));
            $sheet->setCellValue("F{$contador}", ucfirst($list['titulo_min']));
            $sheet->setCellValue("G{$contador}", $list['descripcion']);
            $sheet->setCellValue("H{$contador}", $list['nom_subitem']);
            $sheet->setCellValue("I{$contador}", ucwords($list['solicitante']));
            $sheet->setCellValue("J{$contador}", ucwords($list['responsable']));
            $sheet->setCellValue("K{$contador}", $list['vence']);
            $sheet->setCellValue("L{$contador}", $list['nom_estado_tickets']);
            $sheet->setCellValue("M{$contador}", $list['termino']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista_Gestión_Pendientes';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function Cargar_Tareas_Solicitadas(){
            $dato['list_area'] = $this->modelo->get_list_area_pendiente();
            return view('Gestion_Pendiente.tareas_solicitadas',$dato);
    }

    public function Lista_Tareas_Solicitadas(){
            $dato['piniciar']= $this->input->post("cpiniciar");
            $dato['proceso']= $this->input->post("cproceso");
            $dato['finalizado']= $this->input->post("cfinalizado");
            $dato['standby']= $this->input->post("cstandby");
            $dato['area']= $this->input->post("area");
            $dato['list_pendiente'] = $this->modelo->busqueda_list_pendiente($dato);
            return view('Pendiente.lista_pendiente',$dato);
    }

    public function Modal_Pendiente(){
        $dato['list_base'] = json_decode(json_encode($this->modelobase->get_list_todas_bases_agrupadas()), true);
        $dato['list_tipo_tickets'] = json_decode(json_encode(DB::table('tipo_tickets')
                            ->where('estado', 1)
                            ->orderBy('nom_tipo_tickets', 'ASC')
                            ->get()), true );
            $dato['list_area'] = $this->modelo->get_list_area_pendiente();
            CotizacionPendienteTemporal::where('id', session('usuario')->id_usuario)->delete();
            ArchivoTemporalPendiente::where('id_usuario', session('usuario')->id_usuario)->delete();
            return view('Pendiente.modal_registrar',$dato);
    }

    public function obtenerImagenes() {
        // Obtiene las imágenes desde el modelo
        $imagenes = ArchivoTemporalPendiente::where('id_usuario', session('usuario')->id_usuario)->get();

        // Prepara los datos para ser enviados como respuesta AJAX
        $data = array();
        foreach ($imagenes as $imagen) {
            $data[] = array(
                'ruta' => $imagen['ruta'],
                'id' => $imagen['id']
            );
        }

        // Devuelve los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function Traer_Usuarios_Pendiente(){
            if(session('usuario')->grupo_puestos==""){
                $puestos = "16,20,26,27,98,128,29,30,31,32";
            }else{
                if(substr(session('usuario')->grupo_puestos,-1)==","){
                    $puestos = session('usuario')->grupo_puestos."16,20,26,27,98,128,29,30,31,32";
                }else{
                    $puestos = session('usuario')->grupo_puestos.",16,20,26,27,98,128,29,30,31,32";
                }
            }
            $cod_base = $this->input->post("cod_base");
            $dato['list_usuario'] = $this->modelo->get_list_usuario_pendiente($puestos,$cod_base);
            return view('Pendiente.usuarios_base',$dato);
    }

    public function Responsable_Pendiente(){
            $id_area = $this->input->post("id_area");
            $dato['list_responsable'] = Usuario::get_list_responsable_area($id_area);
            return view('Pendiente.responsable',$dato);
    }

    public function Area_Infraestructura(){
            $id_area = $this->input->post("id_area");
            if($id_area=="10" || $id_area=="41"){
                $dato['list_especialidad'] = Especialidad::get();
                return view('Pendiente.especialidad',$dato);
            }else{
                $dato['list_subitem'] = Subitem::select('subitem.id_subitem', 'subitem.nom_subitem')
                                ->leftJoin('item', 'item.id_item', '=', 'subitem.id_item')
                                ->where('item.id_area', $id_area)
                                ->where('subitem.estado', 1)
                                ->get();
                return view('Pendiente.subitem',$dato);
            }
    }

    public function Delete_Toda_Cotizacion_Pendiente(){
        CotizacionPendienteTemporal::where('id_usuario', session('usuario')->id_usuario)->delete();
    }

    public function Insert_Pendiente(){
            $dato['id_area']= $this->input->post("id_area_i");
            $dato['id_mantenimiento']= $this->input->post("id_mantenimiento");
            if(session('usuario')->id_nivel==1){
                $array = explode("-", $this->input->post("id_usuario_i"));
                $dato['id_usuario']= $array[0];
                $dato['cod_base']= $array[1];
            }else{
                $dato['id_usuario']= session('usuario')->id_usuario;
                $dato['cod_base']= session('usuario')->centro_labores;
            }

            $valida = CotizacionPendienteTemporal::where('id_usuario', session('usuario')->id_usuario)
                    ->count();

            if($dato['cod_base']!="AMT" && $dato['cod_base']!="CD" && $dato['cod_base']!="OFC" && ($dato['id_area']=="10" || $dato['id_area']=="41") && $dato['id_mantenimiento']=="1" && $valida<3){
                echo "recurrente";
            }elseif($dato['cod_base']!="AMT" && $dato['cod_base']!="CD" && $dato['cod_base']!="OFC" && ($dato['id_area']=="10" || $dato['id_area']=="41") && $dato['id_mantenimiento']=="2" && $valida<2){
                echo "emergencia";
            }else{
                $id_puesto = session('usuario')->id_puesto;
                $responsable_area = DB::table('area')
                    ->select(DB::raw("
                        CASE 
                            WHEN (
                                SELECT COUNT(*) 
                                FROM area ar 
                                WHERE CONCAT(',', ar.puestos, ',') LIKE CONCAT('%,', $id_puesto, ',%')
                            ) > 0 
                            THEN 'SI' 
                            ELSE 'NO' 
                        END AS encargado_p
                    "))->first(); // Obtener un solo resultado
                
                //echo $responsable_area->encargado_p;
                
                $dato['id_tipo']= $this->input->post("id_tipo_i");
                $dato['id_responsable']= $this->input->post("id_responsable_i");
                $dato['costo']= $this->input->post("costo_i");
                $dato['id_especialidad']= $this->input->post("id_especialidad");
                $dato['titulo']= $this->input->post("titulo_i");
                $dato['descripcion']= $this->input->post("descripcion_i");
                $dato['id_subitem']= $this->input->post("id_subitem_i");
                $dato['id_item']= $this->input->post("id_item");
                $dato['equipo_i']= $this->input->post("equipo_i");     

                if($dato['id_tipo']==1){
                    $requerimiento = "REQ";
                }elseif($dato['id_tipo']==2){
                    $requerimiento = "INC";
                }elseif($dato['id_tipo']==3){
                    $requerimiento = "TAR";
                }elseif($dato['id_tipo']==4){
                    $requerimiento = "INI";
                }

                $get_id = Area::where('id_area', $dato['id_area'])
                        ->get();
                $cod_area = $get_id[0]['cod_area'];

                $query_id = Pendiente::where('id_tipo', $dato['id_tipo'])
                        ->where('id_area', $dato['id_area'])
                        ->where('estado', 1)
                        ->count();
                $totalRows_t = $query_id;

                if($totalRows_t<9){
                    $codigofinal=$requerimiento."-".$cod_area."-00000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                    $codigofinal=$requerimiento."-".$cod_area."-0000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal=$requerimiento."-".$cod_area."-000".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal=$requerimiento."-".$cod_area."-00".($totalRows_t+1);
                }
                if($totalRows_t>9998){
                    $codigofinal=$requerimiento."-".$cod_area."-0".($totalRows_t+1);
                }

                $dato['cod_pendiente']=$codigofinal;
                $pendiente = Pendiente::create([
                    'id_usuario' => $dato['id_usuario'],
                    'cod_base' => $dato['cod_base'],
                    'cod_pendiente' => $dato['cod_pendiente'],
                    'id_tipo' => $dato['id_tipo'],
                    'id_area' => $dato['id_area'],
                    'id_responsable' => $dato['id_responsable'],
                    'id_mantenimiento' => $dato['id_mantenimiento'],
                    'id_especialidad' => $dato['id_especialidad'],
                    'titulo' => $dato['titulo'],
                    'descripcion' => $dato['descripcion'],
                    'id_subitem' => $dato['id_subitem'],
                    'equipo_i' => $dato['equipo_i'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);

                $dato['id_pendiente'] = $pendiente->id;

                CotizacionPendienteTemporal::insert_cotizacion_pendiente($dato);
                
                if($this->input->hasFile('files_u')){
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
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Pendiente_".$fecha."_".rand(10,999);
                            $nombre = $nombre_soli.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["files_i"]["type"][$count];
                            $source_file = $_FILES["files_i"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["files_i"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["files_i"]["size"][$count];
                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"PENDIENTES/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato['ruta'] = $nombre;
                                ArchivoPendiente::insert([
                                    'id_pendiente' => $dato['id_pendiente'],
                                    'archivo' => $dato['ruta'],
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'user_reg' => session('usuario')->id_usuario
                                ]);
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }   
                }

                //subir fotos de la cámara
                $dato['id_pendiente'] = $pendiente->id_pendiente;
                $data = ArchivoTemporalPendiente::where('id_usuario', session('usuario')->id_usuario)
                    ->get();
                //print_r($data);

                if(!$data->isEmpty()){
                    $data = ArchivoTemporalPendiente::where('id_usuario', session('usuario')->id_usuario)
                        ->count();

                    $contador = $data;
                    for ($i = 1; $i <= $contador+1; $i++) {
            
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        
                        if ((!$con_id) || (!$lr)) {
                            echo "No se pudo conectar al servidor FTP";
                        } else {
                            echo "Conexión FTP establecida";
                            $nombre_actual = "PENDIENTES/temporal_pendiente_". session('usuario')->id_usuario ."_" . $i . ".jpg";
                            $nuevo_nombre = "PENDIENTES/Evidencia_".$dato['id_pendiente']."_".date('Y-m-d')."_" . $i . "_captura.jpg";
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $nombre = "Evidencia_".$dato['id_pendiente']."_".date('Y-m-d')."_" . $i . "_captura.jpg";        
                            $dato['ruta'] = $nombre;
                            ArchivoPendiente::insert([
                                'id_pendiente' => $dato['id_pendiente'],
                                'archivo' => $dato['ruta'],
                                'estado' => 1,
                                'fec_reg' => now(),
                                'user_reg' => session('usuario')->id_usuario,
                                'fec_act' => now(),
                                'user_act' => session('usuario')->id_usuario,
                            ]);
                            echo "Foto $i subida correctamente<br>";
                        }
                    }
                }
                
                //Solicitante
                // $id_usuario= session('usuario')->id_usuario;
                // $soli = $this->Model_Perfil->get_id_usuario($id_usuario);
            
                $dato['get_ticket'] = $this->modelo->get_list_pendiente($dato['id_pendiente']);
                $dato['list_cotizacion'] = CotizacionPendiente::where('id_pendiente', $dato['id_pendiente'])
                                    ->get();
            
                $id_usuario2= $dato['id_responsable'];
                $resp = $this->Model_Perfil->get_id_usuario($id_usuario2);

                $cod_base = $this->input->post("cod_base");
                
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
                    $mail->setFrom('intranet@lanumero1.com.pe','PENDIENTE');

                    if($responsable_area=="SI"){
                        $correo = session('usuario')->emailp;
                        $mail->addAddress($correo);

                        if($cod_base[0]=="B"){
                            $correo2="base".substr($cod_base, 1, 2)."@lanumero1.com.pe";
                            $mail->addAddress($correo2);
                        }
                    }else{
                        if($cod_base[0]=="B"){
                            $correo3="base".substr($cod_base, 1, 3)."@lanumero1.com.pe";
                            $mail->addAddress($correo3);
                        }else{
                            $correo4 = session('usuario')->emailp;
                            $mail->addAddress($correo4);
                        }
                    }
                    $mail->addAddress($resp[0]['emailp']);
                    $data = Usuario::where('id_usuario', '174')
                        ->get();
                    if(count($data)>0){
                        $mail->addCC($data[0]['emailp']);
                    }
                    $mail->isHTML(true);

                    if($dato['get_ticket'][0]['id_mantenimiento']==2){
                        $mail->Subject = "Alerta";
                    }else{
                        $mail->Subject = "Por iniciar";
                    }
                
                    $mailContent = view('Pendiente/mail_por_iniciar', $dato, TRUE);
                    $mail->Body= $mailContent;
                
                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
    }
    
    public function Delete_Pendiente(){
            $dato['id_pendiente']= $this->input->post("id_pendiente");
            $idUsuario = session('usuario')->id_usuario;

            // Actualizar el estado en la tabla `pendiente`
            Pendiente::where('id_pendiente', $dato['id_pendiente'])
                ->update([
                    'estado' => 5,
                    'fec_eli' => now(),
                    'user_eli' => $idUsuario
                ]);
            
            // Actualizar el estado en la tabla `pendiente_historial_c`
            PendienteHistorialC::where('id_pendiente', $dato['id_pendiente'])
                ->update([
                    'estado' => 5,
                    'fec_eli' => now(),
                    'user_eli' => $idUsuario
                ]);
    }
    
    public function Modal_Update_Pendiente($id_pendiente){
            $dato['get_id'] = $this->modelo->get_list_pendiente($id_pendiente);
            $dato['list_tipo_tickets'] = json_decode(json_encode(DB::table('tipo_tickets')
                            ->where('estado', 1)
                            ->orderBy('nom_tipo_tickets', 'ASC')
                            ->get()), true );
            $dato['list_area'] = $this->modelo->get_list_area_pendiente();
            $dato['list_complejidad'] = DB::table('complejidad as c')
                            ->leftJoin('modulo as m', 'c.id_modulo', '=', 'm.id_modulo')
                            ->select('c.*', 'm.nom_modulo')
                            ->where('c.estado', 1)
                            ->get();
            $dato['list_responsable'] = Usuario::get_list_responsable_area($dato['get_id'][0]['id_area']);
            if($dato['get_id'][0]['id_area']=="10" || $dato['get_id'][0]['id_area']=="41"){
                $dato['list_especialidad'] = Especialidad::get();
                $dato['list_titulo'] = DB::table('titulo')
                            ->where('id_especialidad', $dato['get_id'][0]['id_especialidad'])
                            ->get();
            }
            if($dato['get_id'][0]['area_usuario']=="14"){
                $dato['list_subitem'] = Subitem::get_list_area_subitem($dato['get_id'][0]['id_area']);
            }else{
            }
            $dato['list_archivo'] = ArchivoPendiente::where('id_pendiente', $id_pendiente)
                                ->get();
            $dato['url'] = Config::where('descrip_config', 'Pendientes_Doc')
                        ->where('estado', 1)
                        ->get();
            return view('Pendiente.modal_editar',$dato);
    }
    
    public function Modal_Ver_Pendiente($id_pendiente){
            $dato['get_id'] = $this->modelo->get_list_pendiente($id_pendiente);
            $dato['list_tipo_tickets'] = json_decode(json_encode(DB::table('tipo_tickets')
                            ->where('estado', 1)
                            ->orderBy('nom_tipo_tickets', 'ASC')
                            ->get()), true );
            $dato['list_area'] = $this->modelo->get_list_area_pendiente();
            $dato['list_complejidad'] = DB::table('complejidad as c')
                            ->leftJoin('modulo as m', 'c.id_modulo', '=', 'm.id_modulo')
                            ->select('c.*', 'm.nom_modulo')
                            ->where('c.estado', 1)
                            ->get();
            $dato['list_responsable'] = Usuario::get_list_responsable_area($dato['get_id'][0]['id_area']);
            $dato['list_especialidad'] = Especialidad::get();
            $dato['list_titulo'] = DB::table('titulo')
                        ->where('id_especialidad', $dato['get_id'][0]['id_especialidad'])
                        ->get();
            $dato['list_archivo'] = ArchivoPendiente::where('id_pendiente', $id_pendiente)
                        ->get();
            $dato['url'] = Config::where('descrip_config', 'Pendientes_Doc')
                        ->where('estado', 1)
                        ->get();
                        
            $get_id = $this->Model_Perfil->get_id_usuario($dato['get_id'][0]['id_usuario']);

            if($get_id[0]['nom_area']=="TIENDAS" && $dato['get_id'][0]['id_area']!="10" && $dato['get_id'][0]['id_area']!="41"){
                $dato['mostrar'] = 1;
                $dato['list_subitem'] = Subitem::get_list_area_subitem($dato['get_id'][0]['id_area']);
            }else{
                $dato['mostrar'] = 0;
            }

            return view('Pendiente.modal_ver',$dato);
    }

    public function Update_Pendiente(){
            $dato['id_pendiente']= $this->input->post("id_pendiente");
            $dato['id_tipo']= $this->input->post("id_tipo_u");
            $dato['id_area']= $this->input->post("id_area_u");
            $dato['id_responsable']= $this->input->post("id_responsable_u");
            $dato['id_mantenimiento']= $this->input->post("id_mantenimientoe");
            $dato['id_especialidad']= $this->input->post("id_especialidade");
            $dato['titulo']= $this->input->post("titulo_u");
            $dato['descripcion']= $this->input->post("descripcion_u");
            $dato['id_subitem']= $this->input->post("id_subitem_u");
            $dato['equipo_i']= $this->input->post("equipo_i");                
            
            Pendiente::where('id_pendiente', $dato['id_pendiente'])
            ->update([
                'id_tipo' => $dato['id_tipo'],
                'id_area' => $dato['id_area'],
                'id_responsable' => $dato['id_responsable'],
                'id_mantenimiento' => $dato['id_mantenimiento'],
                'id_especialidad' => $dato['id_especialidad'],
                'titulo' => $dato['titulo'],
                'descripcion' => $dato['descripcion'],
                'id_subitem' => $dato['id_subitem'],
                'equipo_i' => $dato['equipo_i'],
                'user_act' => session('usuario')->id_usuario,
                'fec_act' => now(),
            ]);
            // if(!empty($_FILES['files_u']['name']) && !empty($_FILES['files_u']['name'][0])){
                if ($this->input->hasFile('files_u')) {
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
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Pendiente_".$fecha."_".rand(10,999);
                            $nombre = $nombre_soli.".".$ext;
                            $_FILES["file"]["name"] =  $nombre;
                            $_FILES["file"]["type"] = $_FILES["files_u"]["type"][$count];
                            $source_file = $_FILES["files_u"]["tmp_name"][$count];
                            $_FILES["file"]["error"] = $_FILES["files_u"]["error"][$count];
                            $_FILES["file"]["size"] = $_FILES["files_u"]["size"][$count];
                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"PENDIENTES/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                $dato['ruta'] = $nombre;
                                ArchivoPendiente::insert([
                                    'id_pendiente' => $dato['id_pendiente'],
                                    'archivo' => $dato['ruta'],
                                    'estado' => 1,
                                    'fec_reg' => now(),
                                    'user_reg' => session('usuario')->id_usuario,
                                    'fec_act' => now(),
                                    'user_act' => session('usuario')->id_usuario,
                                ]);
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }   
                }
            // }
    }

    public function Descargar_Archivo_Pendiente($id_archivo){
        // Obtiene el archivo y la URL de la configuración
        $getFile = ArchivoPendiente::where('id_archivo', $id_archivo)->first();
        $configUrl = Config::where('descrip_config', 'Pendientes_Doc')
                        ->where('estado', 1)
                        ->first();
    
        // Verifica que los datos existan
        if (!$getFile || !$configUrl) {
            return response()->json(['error' => 'Archivo o configuración no encontrados'], 404);
        }
    
        // Construye la URL completa del archivo
        $fileUrl = $configUrl->url_config . $getFile->archivo;
        $fileName = $getFile->archivo;
    
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
    
    public function Delete_Archivo_Pendiente() {
        $id_archivo = $this->input->post('image_id');
        $dato['get_file'] = ArchivoPendiente::where('id_archivo', $id_archivo);
        ArchivoPendiente::where('id_archivo', $id_archivo)->delete();
    }
    
    public function Previsualizacion_Captura() {
        $cont = ArchivoTemporalPendiente::where('id_usuario', session('usuario')->id_usuario)
            ->count();
        $i = $cont+1;
            $max_fotos = 10;
            // $max_fotos = 3;
            $fotos_subidas = 0;
            if($cont<3){
                //for ($i = 1; $i <= $max_fotos; $i++) {
                    //print_r($cont);
                    $foto_key = "photo" . $i;
                    if ($_FILES[$foto_key]["name"] != "") {
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        
                        if ((!$con_id) || (!$lr)) {
                            echo "No se pudo conectar al servidor FTP";
                        } else {
                            //echo "Conexión FTP establecida";
                            ftp_delete($con_id, 'PENDIENTES/temporal_pendiente_'.session('usuario')->id_usuario. "_" . $i .'.jpg');
                            $nombre_soli = "temporal_pendiente_" . session('usuario')->id_usuario . "_" . $i;
                            $path = $_FILES[$foto_key]["name"];
                            $source_file = $_FILES[$foto_key]['tmp_name'];
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre = $nombre_soli . "." . strtolower($ext);
        
                            ftp_pasv($con_id, true); 
                            $subio = ftp_put($con_id, "PENDIENTES/" . $nombre, $source_file, FTP_BINARY);
        
                            if ($subio) {
                                $dato['ruta'] = $nombre;
                                ArchivoTemporalPendiente::create([
                                    'ruta' => $dato['ruta'],
                                    'id_usuario' => session('usuario')->id_usuario
                                ]);
                                $msj = "Foto $i subida correctamente";
                                $fotos_subidas++;
                                return response()->json(['message' => $msj], 200);
                            } else {
                                echo "Error al subir la foto $i";
                            }
                        }
                    }
                //}
            }else{
                echo "error";
            }
    }
    
    public function Delete_Imagen_Temporal(){
        $id = $this->input->post("id");
        ArchivoTemporalPendiente::where('id', $id)->delete();
    }
    
    public function Excel_Pendiente($cpiniciar,$cproceso,$cfinalizado,$cstandby,$area){
        $dato['piniciar']= $cpiniciar;
        $dato['proceso']= $cproceso; 
        $dato['finalizado']= $cfinalizado;
        $dato['standby']= $cstandby;
        $dato['area']= $area;

        $list_pendiente = $this->modelo->busqueda_list_pendiente($dato);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if(session('usuario')->id_nivel){
            $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Tareas solicitadas');
    
            $sheet->setAutoFilter('A1:K1');
    
            $sheet->getColumnDimension('A')->setWidth(22);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(24);
            $sheet->getColumnDimension('D')->setWidth(60);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(30);
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(45);
    
            $sheet->getStyle('A1:K1')->getFont()->setBold(true);  
    
            $spreadsheet->getActiveSheet()->getStyle("A1:K1")->getFill()
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
    
            $sheet->getStyle("A1:K1")->applyFromArray($styleThinBlackBorderOutline);
    
            $sheet->setCellValue('A1', 'Fecha de registro');
            $sheet->setCellValue('B1', 'Base');
            $sheet->setCellValue('C1', 'Usuario de registro');
            $sheet->setCellValue('D1', 'Título');
            $sheet->setCellValue('E1', 'Asignado a');
            $sheet->setCellValue('F1', 'Área');
            $sheet->setCellValue('G1', 'Vence en');
            $sheet->setCellValue('H1', 'Estado');
            $sheet->setCellValue('I1', 'Tipo');        
            $sheet->setCellValue('J1', 'Etiquetas');
            $sheet->setCellValue('K1', 'Descripcion');   
    
            $contador=1;
            
            foreach($list_pendiente as $list){ 
                $contador++;
    
                $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline); 
    
                $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_reg']));
                $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue("B{$contador}", $list['cod_base']);
                $sheet->setCellValue("C{$contador}", ucwords($list['usuario_solicitante']));
                $sheet->setCellValue("D{$contador}", ucfirst($list['titulo_min']));
                $sheet->setCellValue("E{$contador}", ucwords($list['responsable']));
                $sheet->setCellValue("F{$contador}", ucfirst($list['nom_area_min']));
                if($list['vence_excel']=="Por definir"){
                    $sheet->setCellValue("G{$contador}", $list['vence_excel']);
                }else{
                    $sheet->setCellValue("G{$contador}", Date::PHPToExcel($list['vence_excel']));
                    $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }
                $sheet->setCellValue("H{$contador}", $list['nom_estado_tickets']);
                $sheet->setCellValue("I{$contador}", $list['nom_tipo_tickets']);
                $sheet->setCellValue("J{$contador}", $list['nom_subitem']);
                $sheet->setCellValue("K{$contador}", $list['descripcion']);
            }
        }else{
            $sheet->getStyle("A1:F1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:F1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    
            $spreadsheet->getActiveSheet()->setTitle('Tareas solicitadas');
    
            $sheet->setAutoFilter('A1:F1');
    
            $sheet->getColumnDimension('A')->setWidth(22);
            $sheet->getColumnDimension('B')->setWidth(60);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(15);
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
    
            $sheet->setCellValue('A1', 'Fecha de registro');
            $sheet->setCellValue('B1', 'Título');
            $sheet->setCellValue('C1', 'Asignado a');
            $sheet->setCellValue('D1', 'Área');
            $sheet->setCellValue('E1', 'Vence en');
            $sheet->setCellValue('F1', 'Estado');        
    
            $contador=1;
            
            foreach($list_pendiente as $list){ 
                $contador++;
    
                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("B{$contador}:D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle("A{$contador}:F{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:F{$contador}")->applyFromArray($styleThinBlackBorderOutline); 
    
                $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list['fec_reg']));
                $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                $sheet->setCellValue("B{$contador}", ucfirst($list['titulo_min']));
                $sheet->setCellValue("C{$contador}", ucwords($list['responsable']));
                $sheet->setCellValue("D{$contador}", ucfirst($list['nom_area_min']));
                if($list['vence_excel']=="Por definir"){
                    $sheet->setCellValue("E{$contador}", $list['vence_excel']);
                }else{
                    $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['vence_excel']));
                    $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }
                $sheet->setCellValue("F{$contador}", $list['nom_estado_tickets']);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista_Tareas_Solicitadas';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
