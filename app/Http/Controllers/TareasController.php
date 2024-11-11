<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Pendiente;
use Illuminate\Http\Request;

class TareasController extends Controller
{
    protected $request;
    protected $modelo;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Pendiente();
        // $this->modelodiasemana = new DiaSemana();
        // $this->modelopuestos = new Puesto();
        // $this->modeloccvh = new CuadroControlVisualHorario();
        // $this->modelousuarios = new Usuario();
    }
    //----------------------------------------GESTIÓN DE PENDIENTES---------------------------------------
    public function Gestion_Pendiente(){
            //NOTIFICACIÓN-NO BORRAR
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('Gestion_Pendiente/index',$dato);
    }
/*
    public function Cargar_Mis_Tareas(){
        if ($this->session->userdata('usuario')) {
            $dato['list_area'] = $this->Model_Corporacion->get_list_area_pendiente();
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_gestion_pendiente();
            $dato['get_id_resp'] = $this->Model_Corporacion->get_id_responsable_gestion_pendiente();
            $dato['list_responsable'] = $this->Model_Corporacion->get_list_responsable_gestion_pendiente($dato);
            $this->load->view('Gestion_Pendiente/mis_tareas',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Lista_Mis_Tareas(){
        if ($this->session->userdata('usuario')) {
            $dato['id_area']= $this->input->post("id_area");
            $dato['base']= $this->input->post("base");
            $dato['cpiniciar']= $this->input->post("cpiniciar");
            $dato['cproceso']= $this->input->post("cproceso");
            $dato['cfinalizado']= $this->input->post("cfinalizado");
            $dato['cstandby']= $this->input->post("cstandby");
            $dato['mis_tareas']= $this->input->post("mis_tareas");
            $dato['mi_equipo']= $this->input->post("mi_equipo");
            $dato['responsablei']= $this->input->post("responsablei");
            $dato['list_gestion_pendiente'] = $this->Model_Corporacion->get_list_gestion_pendiente($dato);
            $this->load->view('Gestion_Pendiente/lista_pendientes',$dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Gestion_Pendiente($id_pendiente){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_pendiente($id_pendiente);
            $dato['list_responsable']=$this->Model_Corporacion->get_list_responsable_area($dato['get_id'][0]['id_area']);
            $dato['list_estado'] = $this->Model_Corporacion->get_list_estado_tickets();
            $dato['list_complejidad'] = $this->Model_Corporacion->get_list_complejidad();
            $dato['list_archivo'] = $this->Model_Corporacion->get_list_archivo_pendiente($id_pendiente);
            $dato['list_gestion_archivo'] = $this->Model_Corporacion->get_list_archivo_gestion_pendiente($id_pendiente);
            $dato['historial_comentarios'] = $this->Model_Corporacion->get_list_historial_comentario_pendiente($id_pendiente);
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Pendientes_Doc');
            $get_id = $this->Model_Corporacion->get_id_usuario($dato['get_id'][0]['id_usuario']);

            if($get_id[0]['nom_area']=="TIENDAS"){
                $dato['mostrar'] = 1;
                $dato['list_subitem'] = $this->Model_Corporacion->get_list_area_subitem($dato['get_id'][0]['id_area']);
            }else{
                $dato['mostrar'] = 0;
            }

            $this->load->view('Gestion_Pendiente/modal_editar',$dato);
        }else{
            redirect('');
        }
    }

    public function Update_Gestion_Pendiente(){
        if ($this->session->userdata('usuario')) {
            $dato['id_pendiente']= $this->input->post("id_pendiente");
            $dato['id_subitem']= $this->input->post("id_subitem");
            $dato['id_responsable']= $this->input->post("id_responsable");
            $dato['f_inicio']= $this->input->post("f_inicio");
            $dato['estado']= $this->input->post("estado");
            $dato['f_entrega']= $this->input->post("f_entrega");
            $dato['dificultad']= $this->input->post("dificultad");
            $dato['comentario']= $this->input->post("comentario");

            $dato['get_bd'] = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);

            if($dato['get_bd'][0]['fecha_vencimiento']==NULL ||
            $dato['get_bd'][0]['fecha_vencimiento']=="0000-00-00" ||
            $dato['get_bd'][0]['fecha_vencimiento']==""){
                $dato['fecha_vencimiento'] = $this->input->post("f_inicio");
            }else{
                $dato['fecha_vencimiento'] = "";
            }

            $this->Model_Corporacion->update_gestion_pendiente($dato);

            $get_id = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);

            $get_area = $this->Model_Corporacion->get_id_area($get_id[0]['id_area']);
            $cod_area = $get_area[0]['cod_area'];
            $cod_base= $get_id[0]['cod_base'];

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
                        //$_FILES["file"]["tmp_name"] = $_FILES["files_u"]["tmp_name"][$count];
                        $source_file = $_FILES["files_u"]["tmp_name"][$count];
                        $_FILES["file"]["error"] = $_FILES["files_u"]["error"][$count];
                        $_FILES["file"]["size"] = $_FILES["files_u"]["size"][$count];
                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"PENDIENTES/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            $dato['ruta'] = $nombre;
                            //$this->Model_Corporacion->insert_archivo_pendiente($dato);
                            $this->Model_Corporacion->insert_archivo_gestion_pendiente($dato);
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }

            $dato['get_pendiente'] = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);

            if(($dato['estado']==2 || $dato['estado']==3) && $dato['get_bd'][0]['estado']!=$dato['estado']){
                $dato['get_ticket'] = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);
                $dato['list_comentario'] = $this->Model_Corporacion->get_list_historial_comentario_pendiente($dato['id_pendiente']);

                //Solicitante
                $id_usuario= $dato['get_pendiente'][0]['id_usuario'];
                $soli = $this->Model_Corporacion->get_id_usuario($id_usuario);

                //Responsable
                $id_usuario2= $dato['get_bd'][0]['id_responsable'];
                $resp = $this->Model_Corporacion->get_id_usuario($id_usuario2);

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
                $this->Model_Corporacion->insert_comentario_historico_pendiente($dato);

                $dato['get_ticket'] = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);
                $dato['list_comentario'] = $this->Model_Corporacion->get_list_historial_comentario_pendiente($dato['id_pendiente']);
                $id_usuario= $get_id[0]['id_responsable'];
                $resp = $this->Model_Corporacion->get_id_usuario($get_id[0]['id_responsable']);

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

                    $mail->addAddress($resp[0]['emailp']);

                    $mail->isHTML(true);

                    $mail->Subject = "Nuevo Comentario";

                    $mailContent = $this->load->view('Pendiente/mail_comentario', $dato, TRUE);
                    $mail->Body= $mailContent;

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }

            $validar = $this->Model_Corporacion->valida_pendiente_calendario($dato['id_pendiente']);

            if(count($validar)==0){
                $get_id = $this->Model_Corporacion->get_list_pendiente($dato['id_pendiente']);
                $dato['id_usuario']= $get_id[0]['id_responsable'];
                $dato['titulo']= $get_id[0]['cod_pendiente'];
                $dato['fec_de']= $dato['f_inicio']." 00:00:00";
                $dato['fec_hasta']= $dato['f_entrega']." 23:59:00";
                $dato['descripcion']= $get_id[0]['descripcion'];
                $this->Model_Corporacion->insert_pendiente_calendario($dato);
            }
        }else{
            redirect('');
        }
    }

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

    public function Modal_Ver_Gestion_Pendiente($id_pendiente){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_pendiente($id_pendiente);
            $dato['list_responsable']=$this->Model_Corporacion->get_list_responsable_area($dato['get_id'][0]['id_area']);
            $dato['list_estado'] = $this->Model_Corporacion->get_list_estado_tickets();
            $dato['list_archivo'] = $this->Model_Corporacion->get_list_archivo_pendiente($id_pendiente);
            $dato['list_gestion_archivo'] = $this->Model_Corporacion->get_list_archivo_gestion_pendiente($id_pendiente);
            $dato['historial_comentarios'] = $this->Model_Corporacion->get_list_historial_comentario_pendiente($id_pendiente);
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Pendientes_Doc');
            $get_id = $this->Model_Corporacion->get_id_usuario($dato['get_id'][0]['id_usuario']);

            if($get_id[0]['nom_area']=="TIENDAS"){
                $dato['mostrar'] = 1;
                $dato['list_subitem'] = $this->Model_Corporacion->get_list_area_subitem($dato['get_id'][0]['id_area']);
            }else{
                $dato['mostrar'] = 0;
            }

            $this->load->view('Gestion_Pendiente/modal_ver',$dato);
        }else{
            redirect('');
        }
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
        $list_gestion_pendiente = $this->Model_Corporacion->get_list_gestion_pendiente($dato);

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
        if ($this->session->userdata('usuario')) {
            $dato['list_area'] = $this->Model_Corporacion->get_list_area_pendiente();
            $this->load->view('Gestion_Pendiente/tareas_solicitadas',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Lista_Tareas_Solicitadas(){
        if ($this->session->userdata('usuario')) {
            $dato['piniciar']= $this->input->post("cpiniciar");
            $dato['proceso']= $this->input->post("cproceso");
            $dato['finalizado']= $this->input->post("cfinalizado");
            $dato['standby']= $this->input->post("cstandby");
            $dato['area']= $this->input->post("area");
            $dato['list_pendiente'] = $this->Model_Corporacion->busqueda_list_pendiente($dato);
            $this->load->view('Pendiente/lista_pendiente',$dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Pendiente(){
        if ($this->session->userdata('usuario')) {
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_pendiente();
            $dato['list_tipo_tickets'] = $this->Model_Corporacion->get_list_tipo_tickets();
            $dato['list_area'] = $this->Model_Corporacion->get_list_area_pendiente();
            $this->Model_Corporacion->delete_cotizacion_pendiente_temporal();
            $this->Model_Corporacion->drop_table_archivo_temporal();
            $this->load->view('Pendiente/modal_registrar',$dato);
        }else{
            redirect('');
        }
    }

    public function Traer_Usuarios_Pendiente(){
        if ($this->session->userdata('usuario')) {
            if($_SESSION['usuario'][0]['grupo_puestos']==""){
                $puestos = "16,20,26,27,98,128,29,30,31,32";
            }else{
                if(substr($_SESSION['usuario'][0]['grupo_puestos'],-1)==","){
                    $puestos = $_SESSION['usuario'][0]['grupo_puestos']."16,20,26,27,98,128,29,30,31,32";
                }else{
                    $puestos = $_SESSION['usuario'][0]['grupo_puestos'].",16,20,26,27,98,128,29,30,31,32";
                }
            }
            $cod_base = $this->input->post("cod_base");
            $dato['list_usuario'] = $this->Model_Corporacion->get_list_usuario_pendiente($puestos,$cod_base);
            $this->load->view('Pendiente/usuarios_base',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Responsable_Pendiente(){
        if ($this->session->userdata('usuario')) {
            $id_area = $this->input->post("id_area");
            $dato['list_responsable'] = $this->Model_Corporacion->get_list_responsable_area($id_area);
            $this->load->view('Pendiente/responsable',$dato);
        }else{
            redirect('');
        }
    }

    public function Area_Infraestructura(){
        if ($this->session->userdata('usuario')) {
            $id_area = $this->input->post("id_area");
            if($id_area=="10" || $id_area=="41"){
                $dato['list_especialidad'] = $this->Model_Corporacion->get_list_especialidad();
                $this->load->view('Pendiente/especialidad',$dato);
            }else{
                $dato['list_subitem'] = $this->Model_Corporacion->get_list_area_subitem($id_area);
                $this->load->view('Pendiente/subitem',$dato);
            }
        }else{
            redirect('');
        }
    }

    public function Delete_Toda_Cotizacion_Pendiente(){
        if ($this->session->userdata('usuario')) {
            $this->Model_Corporacion->delete_cotizacion_pendiente_temporal();
        }else{
            redirect('');
        }
    }
*/
}
