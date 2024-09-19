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
use App\Models\Notificacion;
use App\Models\SubGerencia;

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
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.Amonestacion.index', compact('list_notificacion', 'list_subgerencia'));
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

    public function Lista_Amonestaciones_Recibidas(){
        $list_recibidas = $this->modelo->get_list_amonestaciones_recibidas();
        return view('rrhh.Amonestacion.Recibidas.lista', compact('list_recibidas'));
    }

    public function Modal_Amonestacion(){
        if(session('usuario')->id_nivel==1 || session('usuario')->id_nivel==2
        || session('usuario')->id_puesto==133){
            $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
            $list_responsables = $this->modelousuarios->list_usuarios_responsables($dato);
        }else{
            $dato['id_area']=$_SESSION['usuario'][0]['id_area'];
        }
        
        $list_colaborador = $this->modelousuarios->get_list_colaborador();
        
        $list_tipo_amonestacion = $this->modelotipoa->where('estado',1)->get();
        $list_gravedad_amonestacion = $this->modelogravedada->where('estado',1)->get();
        $list_motivo_amonestacion = $this->modelomotivoa->where('estado',1)->get();
        
        return view('rrhh.Amonestacion.Emitidas.modal_registrar', compact('list_responsables','list_colaborador','list_tipo_amonestacion','list_gravedad_amonestacion','list_motivo_amonestacion'));
    }

    public function Insert_Amonestacion(Request $request){
        $dato['id_solicitante'] = $request->input("id_solicitante");
        $dato['fecha'] = $request->input("fecha");
        $dato['tipo'] = $request->input("tipo");
        $dato['id_gravedad_amonestacion'] = $request->input("id_gravedad_amonestacion");
        $dato['motivo'] = $request->input("motivo");
        $dato['detalle'] = $request->input("detalle");
        $dato['estado_amonestacion'] = $request->input("estado_amonestacion");
        $dato['id_revisor'] = session('usuario')->id_usuario;
        $dato['fec_aprobacion'] = now();
        $dato['estado'] = 1;
        $dato['fec_reg'] = now();
        $dato['user_reg'] = session('usuario')->id_usuario;
        
        $lista_maestra= $request->input("id_usuario");
        
        $ico= count($lista_maestra);
        $data['usuarios']="";
        $co = 0;
        $insertados=0;
        $denegados=0;
        $lista_colab_error="";
        $lista_colab_tipo="";
        do{
            $dato['id_colaborador']=$lista_maestra[$co];
            
            $co=$co + 1;

                    $anio=date('Y');
                    $totalRows_t = count($this->modelo->whereYear('fec_reg',$anio)->get());
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
                    //print_r($dato);
                    $this->modelo->insert($dato);
                    $insertados++;

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
    }

    public function Modal_Update_Amonestacion($id_amonestacion,$modal){
            $get_id = $this->modelo->get_list_amonestacion($id_amonestacion);

            $dato['id_gravedad_amonestacion']=$get_id[0]['id_gravedad_amonestacion'];
            
            $list_tipo_amonestacion = $this->modelotipoa->where('estado',1)->get();
            $list_gravedad_amonestacion = $this->modelogravedada->where('estado',1)->get();
            $list_motivo_amonestacion = $this->modelomotivoa->where('estado',1)->get();
            //$dato['list_motivo_amonestacion'] = $this->Model_Corporacion->get_list_motivo_amonestacion_xgravedad($dato);

            $get_user = $this->modelousuarios->get_list_colaborador($get_id[0]['id_solicitante']);
            $dato['id_area']=$get_user[0]['id_area'];

            if(session('usuario')->id_nivel==1 || session('usuario')->id_nivel==2 || session('usuario')->id_puesto==133){
                $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
                $list_responsables = $this->modelousuarios->list_usuarios_responsables($dato);
            }else{
                $dato['id_area'] = session('usuario')->id_area;
                
            }
            $list_colaborador = $this->modelousuarios->get_list_colaborador();
            //$dato['modal']=$modal;
            return view('rrhh.Amonestacion.Emitidas.modal_editar', compact('list_responsables','list_colaborador','list_tipo_amonestacion','list_gravedad_amonestacion','list_motivo_amonestacion','modal','get_id'));
    }

    public function Update_Amonestacion(Request $request){
            $id_puesto = session('usuario')->id_puesto;
           //$id_amonestacion = $request->input("id_amonestacion");
            $dato['id_amonestacion'] = $request->input("id_amonestacion");
            $estado_amonestacion_bd = $request->input("estado_amonestacion_bd");
            $modal= $request->input("modal");
            
            if($modal!=2){
                if(session('usuario')->id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $estado_amonestacion_bd==1){
                    $dato['id_solicitante']= $request->input("id_solicitantee");
                    $dato['fecha']= $request->input("fechae");
                    $dato['id_colaborador']= $request->input("id_usuarioe");
                    $dato['tipo']= $request->input("tipoe");
                    $dato['id_gravedad_amonestacion']= $request->input("id_gravedad_amonestacione");
                    $dato['motivo']= $request->input("motivoe");
                    $dato['detalle']= $request->input("detallee");
                    $dato['documento']= $request->input("documento");
                    $dato['estado_amonestacion']= $request->input("estado_amonestacion");
                    $dato['fec_act']= now();
                    $dato['user_act']= session('usuario')->id_usuario;
                    
                    //print_r($dato);
                    $this->modelo->Update_Amonestacion($dato);
                }else{
                    if($estado_amonestacion_bd==3){
                        $dato['estado_amonestacion']=$estado_amonestacion_bd;
                    }else{
                        $dato['estado_amonestacion']= $request->input("estado_amonestacion");
                    }
                    $dato['estado_amonestacion']= $request->input("estado_amonestacion");
                    //print_r($dato);
                    $this->modelo->Update_amonestacion($dato);
                }
            }
    }

    public function Delete_Amonestacion(Request $request){
        $id_amonestacion = $request->input("id_amonestacion");
        $dato = [
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario,
        ];
        $this->modelo->where('id_amonestacion', $id_amonestacion)->update($dato);
    }

    public function Aprobacion_Amonestacion(Request $request){
        $dato['id_amonestacion']= $request->input("id_amonestacion");
        $dato['tipo']= $request->input("tipo");
        if($dato['tipo']==1){
            $dato['estado_amonestacion']=2;
        }else{
            $dato['estado_amonestacion']=3;
        }
        $this->modelo->aprobacion_amonestacion($dato);
    }

    public function Modal_Documento_Amonestacion($id_amonestacion){
        $get_id = $this->modelo->get_list_amonestacion($id_amonestacion);
        $url = $this->modeloconfig->where('descrip_config', 'Documentos_Amonestacion')->where('estado', 1)->get();
        return view('rrhh.Amonestacion.Emitidas.modal_documento',compact('get_id','url'));   
    }

    public function Update_Documento_Amonestacion(Request $request){
        $id_amonestacion= $request->input("id_amonestacion");
        $dato['documento']=$request->input("documento_bd");
        $dato['cod_amonestacion']=$request->input("cod_amonestacion");
        
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
        $this->modelo->where('id_amonestacion',$id_amonestacion)->update($dato);
    }

    public function Pdf_Amonestacion($id_amonestacion){
        // Obtener los datos de amonestación
        $get_id = $this->modelo->get_list_amonestacion($id_amonestacion);
        if (!$get_id) {
            // Manejar el error si no se encuentra la amonestación
            return response()->json(['error' => 'Amonestación no encontrada'], 404);
        }

        // Obtener la lista de colaboradores
        $list_colaborador = $this->modelousuarios->get_list_colaborador();
        if (!$list_colaborador) {
            // Manejar el error si no se encuentran colaboradores
            return response()->json(['error' => 'No se encontraron colaboradores'], 404);
        }

        // Obtener la lista de tipos de amonestación
        $list_tipo_amonestacion = $this->modelotipoa->where('estado', 1)->get();
        if (!$list_tipo_amonestacion) {
            // Manejar el error si no se encuentran tipos de amonestación
            return response()->json(['error' => 'No se encontraron tipos de amonestación'], 404);
        }

        // Asignar los datos a la vista
        $dato = [
            'get_id' => $get_id,
            'list_colaborador' => $list_colaborador,
            'list_tipo_amonestacion' => $list_tipo_amonestacion,
        ];
        $tmp = base_path('vendor/mpdf');

        // Crear una instancia de Mpdf con las configuraciones necesarias
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'default_font' => 'gothic',
            'tempDir' => $tmp, // Ruta absoluta del nuevo directorio temporal
        ]);

        // Generar el contenido HTML
        $html = view('rrhh.Amonestacion.Emitidas.pdf', $dato)->render();

        // Escribir el contenido HTML en el archivo PDF
        $mpdf->WriteHTML($html);

        // Salida del archivo PDF al navegador
        $mpdf->Output();
    }

}
