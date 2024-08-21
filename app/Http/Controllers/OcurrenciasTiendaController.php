<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\Ocurrencias;

class OcurrenciasTiendaController extends Controller{
    protected $request;
    
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function Ocurrencia_Tienda(){
        $list_base = Base::get_list_base_only();
        
        //$list_tipo_ocurrencia = $this->Model_Corporacion->get_combo_tipo_ocurrencia('Todo');
        $list_colaborador = Ocurrencias::get_combo_colaborador_ocurrencia();

        //$dato['list_ocurrencia_usu'] = $this->Model_Corporacion->get_list_ocurrencia_usuario();

        $cantidad_revisadas = Ocurrencias::where('revisado', 0)
                    ->whereDate('fec_ocurrencia', now())
                    ->where('estado', 1)
                    ->count();
                    
        
        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/
        return view('seguridad.ocurrencias_tienda.index', compact('cantidad_revisadas', 'list_base', 'list_colaborador'));
    }
/*
    public function Traer_Tipo_Ocurrencia_Busq(){
        if ($this->session->userdata('usuario')) {
            $dato['cod_base'] = $this->input->post("cod_base"); 
            $dato['list_tipo_ocurrencia'] = $this->Model_Corporacion->get_combo_tipo_ocurrencia($dato['cod_base']);
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/tipo_ocurrencia',$dato);
        }else{
            redirect('');
        }
    }*/

    public function ListaOcurrencia($cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador){
        $list_ocurrencia = Ocurrencias::get_list_ocurrencia($id_ocurrencia=null,$cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador);
        return view('seguridad.ocurrencias_tienda.lista_ocurrencia', compact('list_ocurrencia'));
    }
/*
    public function Confirmar_Revision_Ocurrencia(){
        if ($this->session->userdata('usuario')) {
            $dato['base']= $this->input->post("base");
            $cant=count($this->Model_Corporacion->valida_ocurrencias_revisadas($dato));
            if($cant==0){
                echo "error";
            }else{
                $this->Model_Corporacion->confirmar_revision_ocurrencia($dato);
            }
            
        }else{
            redirect('');
        }
    }
    
    public function Modal_Ocurrencia_Tienda(){
        if ($this->session->userdata('usuario')) { 
            $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
            $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
            $dato['list_conclusion'] = $this->Model_Corporacion->get_list_conclusion();
            $dato['list_gestion'] = $this->Model_Corporacion->get_list_gestion_ocurrencia();
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_reg_agente();
            $id_usuario=$_SESSION['usuario'][0]['id_usuario'];
            $dato['get_id'] = $this->Model_Corporacion->get_id_usuario($id_usuario);
            $dato['base']=$dato['get_id'][0]['centro_labores'];
            $dato['list_tipo']=$this->Model_Corporacion->buscar_tipo_ocurrencia($dato);
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/modal_registrar',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Insert_Ocurrencia_Tienda(){
        if ($this->session->userdata('usuario')) {
            $dato['id_usuario'] = $_SESSION['usuario'][0]['id_usuario'];
            $dato['fec_ocurrencia']= $this->input->post("fec_ocurrencia");
            $dato['hora']= date('H:i:s');
            $dato['id_tipo']= $this->input->post("id_tipo");
            $dato['id_zona']= $this->input->post("id_zona_i");
            $dato['id_estilo']= $this->input->post("id_estilo_i");
            $dato['id_conclusion']= $this->input->post("id_conclusion");
            $dato['id_gestion']= $this->input->post("id_gestion");
            $dato['cantidad'] = $this->input->post("cantidad"); 
            $dato['monto'] = $this->input->post("monto");
            $dato['descripcion'] = $this->input->post("descripcion");
            $dato['cod_base'] = $this->input->post("cod_base");
            $dato['validador']=2;
            $total=count($this->Model_Corporacion->valida_ocurrencia_tienda($dato));
            if ($total>0){
                echo "error";
            }else{
                $dato['aniodereg']= date('Y');
                $anio=date('Y');
                $query_id = $this->Model_Corporacion->ultimo_anio_cod_ocurrencia($dato);
                $totalRows_t = count($query_id);
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal="OC".$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal="OC".$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal="OC".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal="OC".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998){
                    $codigofinal="OC".$aniof.($totalRows_t+1);
                }
                $dato['cod_ocurrencia']=$codigofinal;

                $this->Model_Corporacion->insert_ocurrencia_tienda($dato);

                $ultimo=$this->Model_Corporacion->ultimo_id_ocurrencia($dato);
                $dato['id_ocurrencia']=$ultimo[0]['id_ocurrencia'];

                if (isset($_FILES["files_reg"])) {
                    $files = $_FILES["files_reg"];
                    $filtered_files = array_filter($files["name"]);
                    if (!empty($filtered_files)) {
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                        if((!$con_id) || (!$lr)){
                            echo "No se conecto";
                        }else{
                            echo "Se conecto";
                            $dato['ruta']="";
                            $files = $_FILES["files_reg"];
                            foreach ($files["name"] as $count => $name) {
                                $path = $files["name"][$count];
                                $file_type = $files["type"][$count];
                                $source_file = $files["tmp_name"][$count];
                                $file_error = $files["error"][$count];
                                $file_size = $files["size"][$count];

                                $fecha=date('Y-m-d_His');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_soli="Ocurrencia_Tienda_".$fecha."_".rand(10,199);
                                $nombre = $nombre_soli.".".$ext;
                                $dato['ruta']=$nombre;

                                ftp_pasv($con_id,true);
                                $subio = ftp_put($con_id,"SEGURIDAD/OCURRENCIAS/".$nombre,$source_file,FTP_BINARY);
                                if($subio){
                                    $this->Model_Corporacion->insert_archivos_ocurrencia_tienda($dato);
                                    echo "Archivo subido correctamente";
                                }else{
                                    echo "Archivo no subido correctamente";
                                }
                            }
                        }
                    }
                }
                
            }
         
        }
        else{
            redirect('');
        }
    }

    public function Modal_Ocurrencia_Tienda_Admin(){
        if ($this->session->userdata('usuario')) { 
            $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
            $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
            $dato['list_tipo'] = $this->Model_Corporacion->get_list_tipo_ocurrencia();
            $dato['list_conclusion'] = $this->Model_Corporacion->get_list_conclusion();
            $dato['list_gestion'] = $this->Model_Corporacion->get_list_gestion_ocurrencia();
            $dato['list_usuario'] = $this->Model_Corporacion->get_list_usuarios_ocurrencia();
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_reg_agente();
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/modal_registrar_admin',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Tipo_Piocha(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tipo'] =  $this->input->post("id_tipo");
            $dato['list_tipo']=$this->Model_Corporacion->buscar_tipo_ocurrencia_piocha($dato['id_tipo']);
            if(count($dato['list_tipo'])>0){
                echo "Si";
            }
        }else{
            redirect('');
        }
    }

    public function Insert_Ocurrencia_Tienda_Admin(){ 
        if ($this->session->userdata('usuario')) {
            $id_nivel= $_SESSION['usuario'][0]['id_nivel'];
            $dato['id_usuario'] =  $this->input->post("id_usuario");
            $dato['fec_ocurrencia']=  $this->input->post("fec_ocurrencia");
            $dato['hora']= date('H:i:s');
            $dato['id_tipo']= $this->input->post("id_tipo");
            $dato['id_zona']= $this->input->post("id_zona_i");
            $dato['id_estilo']= $this->input->post("id_estilo_i");
            $dato['id_conclusion']= $this->input->post("id_conclusion");
            $dato['id_gestion']= $this->input->post("id_gestion");
            $dato['cantidad'] = $this->input->post("cantidad"); 
            $dato['monto'] = $this->input->post("monto");
            $dato['cod_base'] = $this->input->post("cod_base");
            $dato['hora'] = $this->input->post("hora");
            $dato['descripcion'] = $this->input->post("descripcion");

            $dato['validador']=1;

            $total=count($this->Model_Corporacion->valida_ocurrencia_tienda_adm($dato));

            if ($total>0){
                echo "error";
            }else{
                $dato['aniodereg']= date('Y');
                $anio=date('Y');
                $query_id = $this->Model_Corporacion->ultimo_anio_cod_ocurrencia($dato);
                $totalRows_t = count($query_id);
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal="OC".$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal="OC".$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal="OC".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal="OC".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998){
                    $codigofinal="OC".$aniof.($totalRows_t+1);
                }
                $dato['cod_ocurrencia']=$codigofinal;

                $this->Model_Corporacion->insert_ocurrencia_tienda($dato);

                $ultimo=$this->Model_Corporacion->ultimo_id_ocurrencia($dato);
                $dato['id_ocurrencia']=$ultimo[0]['id_ocurrencia'];
                if (isset($_FILES["files"])) {
                    $files = $_FILES["files"];
                    $filtered_files = array_filter($files["name"]);
                    if (!empty($filtered_files)) {
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                        if((!$con_id) || (!$lr)){
                            echo "No se conecto";
                        }else{
                            echo "Se conecto";
                            $dato['ruta']="";
                            $files = $_FILES["files"];
                            foreach ($files["name"] as $count => $name) {
                                $path = $files["name"][$count];
                                $file_type = $files["type"][$count];
                                $source_file = $files["tmp_name"][$count];
                                $file_error = $files["error"][$count];
                                $file_size = $files["size"][$count];

                                $fecha=date('Y-m-d_His');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_soli="Ocurrencia_Tienda_".$fecha."_".rand(10,199);
                                $nombre = $nombre_soli.".".$ext;
                                $dato['ruta']=$nombre;

                                ftp_pasv($con_id,true);
                                $subio = ftp_put($con_id,"SEGURIDAD/OCURRENCIAS/".$nombre,$source_file,FTP_BINARY);
                                if($subio){
                                    $this->Model_Corporacion->insert_archivos_ocurrencia_tienda($dato);
                                    echo "Archivo subido correctamente";
                                }else{
                                    echo "Archivo no subido correctamente";
                                }
                            }
                        }
                    }
                }
            }
         
        }
        else{
            redirect('');
        }
    }

    public function Modal_Update_Ocurrencia_Tienda_Admin($id_ocurrencia){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_ocurrencia($id_ocurrencia);    
            $dato['get_id_files_ocurrencia'] = $this->Model_Corporacion->get_list_archivos_ocurrencia($id_ocurrencia);
            $dato['list_usuario'] = $this->Model_Corporacion->get_list_usuarios_ocurrencia();
            $dato['base']=$dato['get_id'][0]['cod_base'];
            $dato['list_tipo']=$this->Model_Corporacion->buscar_tipo_ocurrencia($dato);
            //$dato['list_tipo'] = $this->Model_Corporacion->get_list_tipo_ocurrencia();
            $dato['list_conclusion'] = $this->Model_Corporacion->get_list_conclusion();
            $dato['list_gestion'] = $this->Model_Corporacion->get_list_gestion_ocurrencia();
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_reg_agente();
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Ocurrencia_Tienda');
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/modal_editar_admin',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Modal_Update_Ocurrencia_Tienda($id_ocurrencia){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_ocurrencia($id_ocurrencia);    
            $dato['get_id_files_ocurrencia'] = $this->Model_Corporacion->get_list_archivos_ocurrencia($id_ocurrencia);
            $dato['list_usuario'] = $this->Model_Corporacion->get_list_usuarios_ocurrencia();
            //$dato['list_tipo'] = $this->Model_Corporacion->get_list_tipo_ocurrencia();
            $dato['list_conclusion'] = $this->Model_Corporacion->get_list_conclusion();
            $dato['list_gestion'] = $this->Model_Corporacion->get_list_gestion_ocurrencia();
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_reg_agente();
            $dato['base']=$dato['get_id'][0]['cod_base'];
            $dato['list_tipo']=$this->Model_Corporacion->buscar_tipo_ocurrencia($dato);
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Ocurrencia_Tienda');
            $this->load->view('Admin/Configuracion/Ocurrencia_Tienda/modal_editar',$dato);
        }
        else{
            redirect('');
        }
    }

    public function Descargar_Archivo_Ocurrencia($id_ocurrencia_archivo) {
        if ($this->session->userdata('usuario')) {
            $dato['get_file'] = $this->Model_Corporacion->get_id_archivos_ocurrencia($id_ocurrencia_archivo);
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Ocurrencia_Tienda');
            $image = $dato['url'][0]['url_config'].$dato['get_file'][0]['archivo'];
            $name     = basename($image);
            $ext      = pathinfo($image, PATHINFO_EXTENSION);
            force_download($name , file_get_contents($dato['url'][0]['url_config'].$dato['get_file'][0]['archivo']));
        }
        else{
            redirect('');
        }
    }

    public function Delete_Archivo_Ocurrencia() {
        $id_ocurrencia_archivo = $this->input->post('image_id');
        $this->Model_Corporacion->delete_archivo_ocurrencia($id_ocurrencia_archivo);
    }

    public function Update_Ocurrencia_Tienda(){
        if ($this->session->userdata('usuario')) {
            $id_nivel= $_SESSION['usuario'][0]['id_nivel'];

            $dato['id_ocurrencia']= $this->input->post("id_ocurrencia");
            $dato['cod_ocurrencia']= $this->input->post("cod_ocurrencia");
            $dato['fec_ocurrencia'] = $this->input->post("fec_ocurrenciae");
            $dato['id_usuario'] = $this->input->post("id_usuarioe");
            $dato['id_tipo']= $this->input->post("id_tipoe");
            $dato['id_zona']= $this->input->post("id_zona_u");
            $dato['id_estilo']= $this->input->post("id_estilo_u");
            $dato['id_conclusion']= $this->input->post("id_conclusione");
            $dato['id_gestion']= $this->input->post("id_gestione");
            $dato['cantidad'] = $this->input->post("cantidade"); 
            $dato['monto'] = $this->input->post("montoe");
            $dato['descripcion'] = $this->input->post("descripcione");
            $dato['cod_base'] = $this->input->post("cod_basee");
            $dato['hora'] = $this->input->post("horae");
            $dato['validador']=0;

            if($id_nivel==1){
                $dato['validador']=1;
                //$dato['get_id'] = $this->Model_Corporacion->get_id_usuario($dato['id_usuario']);
                //$dato['cod_base']=$dato['get_id'][0]['centro_labores'];
            }

            $total=count($this->Model_Corporacion->valida_ocurrencia_tienda_edit($dato));

            if ($total>0){
                echo "error";
            }else{
                $this->Model_Corporacion->update_ocurrencia_tienda($dato);
                if (isset($_FILES["files_u_admin"])) {
                    $files = $_FILES["files_u_admin"];
                    $filtered_files = array_filter($files["name"]);
                    if (!empty($filtered_files)) {
                        $ftp_server = "lanumerounocloud.com";
                        $ftp_usuario = "intranet@lanumerounocloud.com";
                        $ftp_pass = "Intranet2022@";
                        $con_id = ftp_connect($ftp_server);
                        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                        if((!$con_id) || (!$lr)){
                            echo "No se conecto";
                        }else{
                            echo "Se conecto";
                            $dato['ruta']="";
                            $files = $_FILES["files_u_admin"];
                            foreach ($files["name"] as $count => $name) {
                                $path = $files["name"][$count];
                                $file_type = $files["type"][$count];
                                $source_file = $files["tmp_name"][$count];
                                $file_error = $files["error"][$count];
                                $file_size = $files["size"][$count];

                                $fecha=date('Y-m-d_His');
                                $ext = pathinfo($path, PATHINFO_EXTENSION);
                                $nombre_soli="Ocurrencia_Tienda_".$fecha."_".rand(10,199);
                                $nombre = $nombre_soli.".".$ext;
                                $dato['ruta']=$nombre;

                                ftp_pasv($con_id,true);
                                $subio = ftp_put($con_id,"SEGURIDAD/OCURRENCIAS/".$nombre,$source_file,FTP_BINARY);
                                if($subio){
                                    $this->Model_Corporacion->insert_archivos_ocurrencia_tienda($dato);
                                    echo "Archivo subido correctamente";
                                }else{
                                    echo "Archivo no subido correctamente";
                                }
                            }
                        }
                    }
                }
            }
         
        }
        else{
            redirect('');
        }
    }

    public function Delete_Ocurrencia(){ 
        if ($this->session->userdata('usuario')) {
            $dato['id_ocurrencia']= $this->input->post("id_ocurrencia");
            $this->Model_Corporacion->delete_ocurrencia_tienda($dato); 
        }else{
            redirect('');
        }
    }

    public function Excel_Ocurrencia($cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador){  
        $fecha = substr($fecha,0,4)."-".substr($fecha,4,2)."-".substr($fecha,-2);
        $fecha_fin = substr($fecha_fin,0,4)."-".substr($fecha_fin,4,2)."-".substr($fecha_fin,-2);
        $list_ocurrencia = $this->Model_Corporacion->get_list_ocurrencia($id_ocurrencia=null,$cod_base,$fecha,$fecha_fin,$id_tipo_ocurrencia,$id_colaborador);

        $spreadsheet = new Spreadsheet(); 
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Ocurrencia Tienda');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(15);
		$sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
		$sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(30);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(85);
        $sheet->getColumnDimension('N')->setWidth(15);

        $sheet->getStyle('A1:N1')->getFont()->setBold(true);  

        $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
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

        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Fecha');
        $sheet->setCellValue('C1', 'Base');
		$sheet->setCellValue('D1', 'Colaborador');
		$sheet->setCellValue('E1', 'Ocurrencia');
        $sheet->setCellValue('F1', 'Zona');
        $sheet->setCellValue('G1', 'Estilo');
        $sheet->setCellValue('H1', 'Conclusión');
        $sheet->setCellValue('I1', 'Gestión');
        $sheet->setCellValue('J1', 'Cantidad');
        $sheet->setCellValue('K1', 'Monto');
        $sheet->setCellValue('L1', 'Hora');
        $sheet->setCellValue('M1', 'Descripción');
        $sheet->setCellValue('N1', 'Revisado');

        $contador=1;
        
        foreach($list_ocurrencia as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $list['cod_ocurrencia']);
            $sheet->setCellValue("B{$contador}", $list['fecha_ocurrencia']);
            $sheet->setCellValue("C{$contador}", $list['cod_base']);
            $sheet->setCellValue("D{$contador}", $list['colaborador']);
            $sheet->setCellValue("E{$contador}", $list['nom_tipo_ocurrencia']);
            $sheet->setCellValue("F{$contador}", $list['nom_zona']);
            $sheet->setCellValue("G{$contador}", $list['nom_estilo']);
            $sheet->setCellValue("H{$contador}", $list['nom_conclusion']);
            $sheet->setCellValue("I{$contador}", $list['nom_gestion']);
            $sheet->setCellValue("J{$contador}", $list['cantidad']);
            $sheet->setCellValue("K{$contador}", "S/. ".$list['monto']);
            $sheet->setCellValue("L{$contador}", $list['hora']);
            $sheet->setCellValue("M{$contador}", $list['descripcion']);
            $sheet->setCellValue("N{$contador}", $list['v_revisado']);
        }

        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista_Ocurrencia_'.$curdate;
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); 
    }*/
}