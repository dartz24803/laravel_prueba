<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amonestacion;
use App\Models\Usuario;
use App\Models\Puesto;
use App\Models\Config;
use App\Models\Gravedad_Amonestacion;
use App\Models\Motivo_Amonestacion;
use App\Models\Tipo_Amonestacion;

class AmonestacionController extends Controller
{
    
    protected $request;
    protected $modelo;
    protected $modelousuarios;
    protected $modelopuesto;
    protected $modeloconfig;
    protected $modelogravedada;
    protected $modelomotivoa;
    protected $modelotipoa;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Amonestacion();
        $this->modelousuarios = new Usuario();
        $this->modelopuesto = new Puesto();
        $this->modeloconfig = new Config();
        $this->modelogravedada = new Gravedad_Amonestacion();
        $this->modelomotivoa = new Motivo_Amonestacion();
        $this->modelotipoa = new Tipo_Amonestacion();
    }
    
    public function Amonestacion(){
        //NOTIFICACIÓN-NO BORRAR
        //$dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        //$dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();
        return view('rrhh.Amonestacion.index');
    }

    public function Amonestaciones_Emitidas(){
        return view('rrhh.Amonestacion.Emitidas.index');
    }
    
    public function Lista_Amonestaciones_Emitidas(){
        $url = $this->modeloconfig->where('descrip_config', 'Documentos_Amonestacion')->where('estado', 1)->get();
        if(Session('usuario')->id_nivel==1 || Session('usuario')->id_nivel==2 ||
        Session('usuario')->id_puesto==128 || Session('usuario')->id_puesto==22 ||
        Session('usuario')->id_puesto==133 || Session('usuario')->id_puesto==209 ||
        Session('usuario')->visualizar_amonestacion!="sin_acceso_amonestacion"){
            $id_area="";
        }else{
            $id_area=Session('usuario')->id_area;
        }
        
        $list_amonestacion = $this->modelo->get_list_amonestacion($id_amonestacion=null,$id_area);
        return view('rrhh.Amonestacion.Emitidas.lista', compact('url', 'list_amonestacion'));
    }
    
    public function Amonestaciones_Recibidas(){
        return view('rrhh.Amonestacion.Recibidas.index');
    }

    public function Modal_Amonestacion(){
            //$menu_gestion_pendiente=explode(",",$_SESSION['usuario'][0]['grupo_puestos']);
            //$mostrar_menu=in_array($_SESSION['usuario'][0]['id_puesto'],$menu_gestion_pendiente);
            
            if(session('usuario')->id_nivel==1 || session('usuario')->id_nivel==2
            || session('usuario')->id_puesto==133){
                $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
                //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
                $list_responsables = $this->modelousuarios->list_usuarios_responsables($dato);
            }else{
                $dato['id_area']=$_SESSION['usuario'][0]['id_area'];
                //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador_xarea($dato);
            }
            
            $list_colaborador = $this->modelousuarios->get_list_colaborador();
            
            $list_tipo_amonestacion = $this->modelotipoa->where('estado',1)->get();
            $list_gravedad_amonestacion = $this->modelogravedada->where('estado',1)->get();
            $list_motivo_amonestacion = $this->modelomotivoa->where('estado',1)->get();
            
            return view('rrhh.Amonestacion.Emitidas.modal_registrar', compact('list_responsables','list_colaborador','list_tipo_amonestacion','list_gravedad_amonestacion','list_motivo_amonestacion'));
        }

    public function Insert_Amonestacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_solicitante']=$this->input->post("id_solicitante");
            $dato['fecha']= $this->input->post("fecha");
            $dato['tipo']= $this->input->post("tipo");
            $dato['id_gravedad_amonestacion']= $this->input->post("id_gravedad_amonestacion");
            $dato['motivo']= $this->input->post("motivo");
            $dato['detalle']= $this->input->post("detalle");
            $dato['estado_amonestacion']= $this->input->post("estado_amonestacion");
            $dato['mod']=1;
            
            $lista_maestra= $this->input->post("id_usuario");
            
            $ico= count($lista_maestra);
            $dato['usuarios']="";
            $co = 0;
            $insertados=0;
            $denegados=0;
            $lista_colab_error="";
            $lista_colab_tipo="";
            do{
                $dato['id_colaborador']=$lista_maestra[$co];
                
                $co=$co + 1;
                //$valida=count($this->Model_Corporacion->valida_amonestacion($dato));
                $colab=$this->Model_Corporacion->get_data_usuario_activo_xid($dato['id_colaborador']);
                /*if($valida<1){
                    $valida_tipo=count($this->Model_Corporacion->valida_tipo_amonestacion_colaborador($dato));
                    $max=1;
                    if($dato['tipo']==1){
                        $max=2;
                    }
                    if($valida_tipo<$max){*/
                        $anio=date('Y');
                        $totalRows_t = count($this->Model_Corporacion->cant_amonestacion($anio));
                        $aniof=substr($anio, 2,2);
                        if($totalRows_t<9){
                            $codigofinal="A".$aniof."0000".($totalRows_t+1);
                        }
                        if($totalRows_t>8 && $totalRows_t<99){
                                $codigofinal="A".$aniof."000".($totalRows_t+1);
                        }
                        if($totalRows_t>98 && $totalRows_t<999){
                            $codigofinal="A".$aniof."00".($totalRows_t+1);
                        }
                        if($totalRows_t>998 && $totalRows_t<9999){
                            $codigofinal="A".$aniof."0".($totalRows_t+1);
                        }
                        if($totalRows_t>9998)
                        {
                            $codigofinal="A".$aniof.($totalRows_t+1);
                        }
                        $dato['cod_amonestacion']=$codigofinal;
                        $this->Model_Corporacion->insert_amonestacion($dato);
                        $insertados++;
                    /*}else{
                        $lista_colab_tipo=$lista_colab_tipo.$colab[0]['usuario_nombres']." ".$colab[0]['usuario_apater']." ".$colab[0]['usuario_amater']."<br>";
                        $denegados++;
                    }*/
                /*}else{
                    $lista_colab_error=$lista_colab_error.$colab[0]['usuario_nombres']." ".$colab[0]['usuario_apater']." ".$colab[0]['usuario_amater']."<br>";
                    $denegados++;
                }*/
            }while($co < $ico);
            $titulo="";
            if($lista_colab_error!="" || $lista_colab_tipo!=""){
                $titulo="<h4>Colaboradores no registrados por:</h4>";
            }
            if($lista_colab_error!=""){
                $lista_colab_error='<span><u>Duplicados</u></span><h6>'.$lista_colab_error.'</h6><br>';
            }
            if($lista_colab_tipo!=""){
                $lista_colab_tipo='<span><u>Tipo de amonestación existente</u></span><h6>'.$lista_colab_tipo.'</h6><br>';
            }
            echo $insertados."-".$denegados.'-'.$titulo.$lista_colab_error.$lista_colab_tipo;
        }else{
            redirect(''); 
        }
    }

    public function Modal_Update_Amonestacion($id_amonestacion,$modal){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_amonestacion($id_amonestacion);
            //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
            $dato['list_tipo_amonestacion'] = $this->Model_Corporacion->list_tipo_amonestacion();
            $dato['list_gravedad_amonestacion'] = $this->Model_Corporacion->get_list_gravedad_amonestacion();
            $dato['id_gravedad_amonestacion']=$dato['get_id'][0]['id_gravedad_amonestacion'];
            $dato['list_motivo_amonestacion'] = $this->Model_Corporacion->get_list_motivo_amonestacion();
            //$dato['list_motivo_amonestacion'] = $this->Model_Corporacion->get_list_motivo_amonestacion_xgravedad($dato);

            $dato['get_user'] = $this->Model_Corporacion->get_list_colaborador($dato['get_id'][0]['id_solicitante']);
            $dato['id_area']=$dato['get_user'][0]['id_area'];

            if($_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_nivel']==2 ||
            $_SESSION['usuario'][0]['id_puesto']==133){
                $dato['puestos_jefes'] = $this->Model_Corporacion->list_puestos_jefes();
                //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
                $dato['list_responsables'] = $this->Model_Corporacion->list_usuarios_responsables($dato);
            }else{
                $dato['id_area']=$_SESSION['usuario'][0]['id_area'];
                
            }
            //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador_xarea($dato);
            $dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
            $dato['modal']=$modal;
            $this->load->view('Recursos_Humanos/Amonestacion/modal_editar',$dato); 
            
              
        }else{
            redirect('');
        }
    }

    public function Update_Amonestacion(){
        if ($this->session->userdata('usuario')) {
            $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
            $dato['id_amonestacion']= $this->input->post("id_amonestacion");
            $dato['estado_amonestacion_bd']= $this->input->post("estado_amonestacion_bd");
            $dato['modal']= $this->input->post("modal");
            
            if($dato['modal']!=2){
                if($_SESSION['usuario'][0]['id_nivel']==1 || $id_puesto==23 || $id_puesto==128 || $dato['estado_amonestacion_bd']==1){
                    $dato['id_solicitante']= $this->input->post("id_solicitantee");
                    $dato['fecha']= $this->input->post("fechae");
                    $dato['id_colaborador']= $this->input->post("id_usuarioe");
                    $dato['tipo']= $this->input->post("tipoe");
                    $dato['id_gravedad_amonestacion']= $this->input->post("id_gravedad_amonestacione");
                    $dato['motivo']= $this->input->post("motivoe");
                    $dato['detalle']= $this->input->post("detallee");
                    $dato['documento']= $this->input->post("documento");
                    $dato['estado_amonestacion']= $this->input->post("estado_amonestacion");
                    
                    $dato['mod']=2;
                    /*$cant=count($this->Model_Corporacion->valida_amonestacion($dato));
                    if($cant>0){
                        echo "error";
                    }else{
                        $cant=count($this->Model_Corporacion->valida_tipo_amonestacion_colaborador($dato));
                        if($cant>0){
                            echo "error";
                        }else{*/
                            $this->Model_Corporacion->update_amonestacion($dato);
                        /*}
                    }  */
                }else{
                    if($dato['estado_amonestacion_bd']==3){
                        $dato['estado_amonestacion']=$dato['estado_amonestacion_bd'];
                    }else{
                        $dato['estado_amonestacion']= $this->input->post("estado_amonestacion");
                    }
                    $dato['estado_amonestacion']= $this->input->post("estado_amonestacion");
                    $this->Model_Corporacion->update_amonestacion_estado($dato);
                }
            }
            
        }else{
            redirect('');
        }
    }

    public function Delete_Amonestacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_amonestacion']= $this->input->post("id_amonestacion");
            $this->Model_Corporacion->delete_amonestacion($dato);
            
        }else{
            redirect('');
        }
    }

    public function Aprobacion_Amonestacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_amonestacion']= $this->input->post("id_amonestacion");
            $dato['tipo']= $this->input->post("tipo");
            if($dato['tipo']==1){
                $dato['estado_amonestacion']=2;
            }else{
                $dato['estado_amonestacion']=3;
            }
            $this->Model_Corporacion->aprobacion_amonestacion($dato);
        }else{
            redirect('');
        }
    }

    public function Modal_Documento_Amonestacion($id_amonestacion){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_amonestacion($id_amonestacion);
            $dato['url'] = $this->Model_Configuracion->ruta_archivos_config('Documentos_Amonestacion');
            $this->load->view('Recursos_Humanos/Amonestacion/modal_documento',$dato);   
        }
        else{
            redirect('');
        }
    }

    public function Update_Documento_Amonestacion(){
        if ($this->session->userdata('usuario')) {
            $dato['id_amonestacion']= $this->input->post("id_amonestacion");
            $dato['documento']=$this->input->post("documento_bd");
            $dato['cod_amonestacion']=$this->input->post("cod_amonestacion");
            
            if($_FILES["documentoe"]["name"]!= ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    if($_FILES["documentoe"]["name"] != ""){
                        $path = $_FILES["documentoe"]["name"];
                        $temp = explode(".",$_FILES['documentoe']['name']);
                        $source_file = $_FILES['documentoe']['tmp_name'];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="Documento_".$dato['cod_amonestacion']."_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        //$dato['ruta'] = "https://lanumerounocloud.com/intranet/PERFIL/DOCUMENTACION/".$nombre;
                        
                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"AMONESTACION/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            $dato['documento'] = "AMONESTACION/".$nombre;
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }   
            }
            $this->Model_Corporacion->update_documento_amonestacion($dato);
            
        }else{
            redirect('');
        }
    }

    public function Pdf_Amonestacion($id_amonestacion){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_amonestacion($id_amonestacion);   
            $dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
            $dato['list_tipo_amonestacion'] = $this->Model_Corporacion->list_tipo_amonestacion();
            $mpdf = new \Mpdf\Mpdf([
                "format" =>"A4",
                'default_font' => 'gothic',

            ]);
            $html = $this->load->view('Recursos_Humanos/Amonestacion/pdf',$dato,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
        else{
            redirect('');
        }
    }
}
