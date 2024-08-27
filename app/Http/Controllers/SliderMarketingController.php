<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Base;
use App\Models\Config;


class SliderMarketingController extends Controller
{
    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);
    }
    public function index() {
        $dato["slider"] = Slide::where('estado', 1)
                        ->where('id_area', 7)
                        ->get();
        $dato['list_base'] = Base::where('nom_base', 'LIKE', 'BASE%')
                        ->orderBy('nom_base', 'ASC')
                        ->get();
        $dato["config"] = Config::where('descrip_config', 'Slidecomercial')
                        ->get();
        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/

        return view("marketing/slider/body", $dato);
    }
    
    public function Buscar_Base_Slide_Comercial(Request $request){
        $base_slide = $request->input("base");
        $base = base64_decode($base_slide);
        $dato['url'] = Config::where('descrip_config', 'Slide_Comercial')
                        ->where('estado', 1)
                        ->get();
        $dato['slider'] = Slide::where('estado', 1)
                        ->where('id_area', 7)
                        ->where('base', $base)
                        ->orderBy('orden', 'ASC')
                        ->get();
        return view('marketing/slider/lista', $dato);
    }
    
    public function Modal_Slide_Insertar_Comercial(){
        //$data["data_posted"] = posted();
        $dato['list_base'] = Base::where('nom_base', 'LIKE', 'BASE%')
                        ->orderBy('nom_base', 'ASC')
                        ->get();
        return view('marketing/slider/modal_registrar', $dato);   
    }

    public function Insert_Slide_Comercial(Request $request){
        $dato['tipo_slide']= $request->input("tipo_slide");
        $valida = Slide::where('orden', $request->orden)
                    ->where('id_area', 7)
                    ->where('tipo_slide', $request->tipo_slide)
                    ->where('base', $request->base)
                    ->where('estado', 1)
                    ->exists();
        
        if ($valida){
            echo "error";
        }else{
            $dato['id_area']= 7;
            $dato['orden']= $request->input("orden");
            $dato['entrada_slide']= $request->input("entrada_slide");
            $dato['base']= $request->input("base");
            $dato['salida_slide']= $request->input("salida_slide");
            $dato['duracion']= $request->input("duracion");
            $dato['titulo']= $request->input("titulo");
            $dato['descripcion']= $request->input("descripcion");
            $dato['tipo_slide']= $request->input("tipo_slide");
            $dato['estado']= 1;
            $dato['fec_reg']= now();
            $dato['user_reg']= session('usuario')->id_usuario;
            $dato['archivoslide']="";
            if($dato['tipo_slide']==1){
                if($_FILES['archivoslide']['name']!=""){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        if($_FILES['archivoslide']['name']!=""){
                            $path = $_FILES['archivoslide']['name'];
                            $temp = explode(".",$_FILES['archivoslide']['name']);
                            $source_file = $_FILES['archivoslide']['tmp_name'];
    
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Slide_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;
                            $dato['archivoslide'] = $nombre;
    
                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"slide/marketing/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }   
                }
            }else{
                if($_FILES['archivoslidevideo']['name']!=""){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if((!$con_id) || (!$lr)){
                        echo "No se conecto";
                    }else{
                        echo "Se conecto";
                        if($_FILES['archivoslidevideo']['name']!=""){
                            $path = $_FILES['archivoslidevideo']['name'];
                            $temp = explode(".",$_FILES['archivoslidevideo']['name']);
                            $source_file = $_FILES['archivoslidevideo']['tmp_name'];
    
                            $fecha=date('Y-m-d');
                            $ext = pathinfo($path, PATHINFO_EXTENSION);
                            $nombre_soli="Slide_".$fecha."_".rand(10,199);
                            $nombre = $nombre_soli.".".$ext;


                            $dato['archivoslide'] = $nombre;
    
                            ftp_pasv($con_id,true);
                            $subio = ftp_put($con_id,"slide/marketing/".$nombre,$source_file,FTP_BINARY);
                            if($subio){
                                echo "Archivo subido correctamente";
                            }else{
                                echo "Archivo no subido correctamente";
                            }
                        }
                    }   
                }
            }
            Slide::create($dato);
        }
    }

    public function Modal_Update_Slide_Comercial($id_slide){
        $dato['get_id'] = Slide::where('id_slide', $id_slide)
                        ->get();

        $dato['list_base'] = Base::where('nom_base', 'LIKE', 'BASE%')
                        ->orderBy('nom_base', 'ASC')
                        ->get();
        $dato['url'] = Config::where('descrip_config', 'Slide_Comercial')
                        ->get();
        return view('marketing/slider/modal_editar',$dato);
    }

    public function Update_slide_Comercial(Request $request){
        $dato['orden']= $request->input("orden_e");
        $id_slide= $request->input("id_slide");
        $dato['id_area']= 7;
        $dato['entrada_slide']= $request->input("entrada_slide_e");
        $dato['base']= $request->input("base_e");
        $dato['salida_slide']= $request->input("salida_slide_e");
        $dato['duracion']= $request->input("duracion_e");
        $dato['titulo']= $request->input("titulo_e");
        $dato['descripcion']= $request->input("descripcion_e");

        $dato['estado']= $request->input("estado_e");
        $dato['tipo_slide']= $request->input("tipo_slide_e");
        $dato['fec_act']= now();
        $dato['user_act']= session('usuario')->id_usuario;
        $get_id = Slide::where('id_slide', $id_slide)
                        ->get();

        $dato['archivoslide'] = $get_id[0]['archivoslide'];
        if($dato['tipo_slide']==1){
            if($_FILES['archivoslideimagen']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    if($_FILES['archivoslideimagen']['name']!=""){
                        $path = $_FILES['archivoslideimagen']['name'];
                        $temp = explode(".",$_FILES['archivoslideimagen']['name']);
                        $source_file = $_FILES['archivoslideimagen']['tmp_name'];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="Slide_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        $dato['archivoslide'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"slide/marketing/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }   
            }
        }else{
            if($_FILES['archivoslidevideodos']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if((!$con_id) || (!$lr)){
                    echo "No se conecto";
                }else{
                    echo "Se conecto";
                    if($_FILES['archivoslidevideodos']['name']!=""){
                        $path = $_FILES['archivoslidevideodos']['name'];
                        $temp = explode(".",$_FILES['archivoslidevideodos']['name']);
                        $source_file = $_FILES['archivoslidevideodos']['tmp_name'];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="Slide_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;
                        $dato['archivoslide'] = $nombre;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"slide/marketing/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            echo "Archivo subido correctamente";
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }   
            }
        }
        Slide::findOrFail($id_slide)->update($dato);
    }
    
    public function Slider_Vista_Comercial() {
        $dato['url'] = Config::where('descrip_config', 'Slide_Comercial')
                        ->get();
        $dato["slider"] = Slide::where('estado', 1)
                        ->where('id_area', 7)
                        ->where('tipo_slide', '!=', 2)
                        ->orderBy('orden', 'ASC')
                        ->get();
        return view("marketing/slider/index", $dato);
    }
}
