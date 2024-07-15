<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Base;
use App\Models\Config;
use App\Models\BolsaTrabajo;
class ComunicadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $request;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }
    public function index(){
        return view('rrhh.Comunicado.index');
    }

    public function Cargar_Slider_Rrhh(){
        $list_base = Base::select('cod_base')
                        ->where('estado', 1)
                        ->groupBy('cod_base')
                        ->orderBy('cod_base', 'ASC')->get();
        //print_r($list_base);
        return view("rrhh.Comunicado.slider_rrhh", compact('list_base'));
    }

    public function Lista_Slider_Rrhh(Request $request){
        $dato['tipo']= $request->input("tipo");
        $dato['url'] = Config::where('descrip_config', 'Slide_Rrhh')
                        ->where('estado', 1)
                        ->get();
        $dato['list_slider_rrhh'] = Slide::get_list_slider_rrhh($dato);
        return view("rrhh.Comunicado.list_sr", $dato);
    }

    public function Modal_Slider_Rrhh(){
        $list_base = Base::select('cod_base')
                    ->where('estado',1)
                    ->groupBy('cod_base')
                    ->orderBy('cod_base', 'ASC')
                    ->get();
        return view('rrhh.Comunicado.modal_registrar_sr', compact('list_base'));
    }

    public function Insert_Slider_Rrhh(Request $request){
        $request->validate([
            'tipo' => 'not_in:0',
            'orden' => 'not_in:0',
            'entrada_slide' => 'required',
            'salida_slide' => 'required',
            'tipo_slide' => 'not_in:0',
            'titulo' => 'required',
            'descripcion' => 'required',
        ],[
            'tipo.not_in' => 'Debe seleccionar tipo.',
            'orden.not_in' => 'Debe seleccionar orden.',
            'entrada_slide.required' => 'Debe ingresar tiempo de entrada.',
            'salida_slide.required' => 'Debe ingresar tiempo de salida.',
            'tipo_slide.not_in' => 'Debe seleccionar tipo de slide',
            'titulo.required' => 'Debe ingresar descripcion.',
            'descripcion.required' => 'Debe ingresar descripcion.',
        ]);

        $valida = Slide::where('base', $request->input)
                    ->where('orden', $request->orden)
                    ->where('id_area', session('usuario')->id_area)
                    ->where('tipo_slide', $request->tipo_slide)
                    ->where('estado', 1)
                    ->exists();

        if ($valida){
            echo "error";
        }else{
            $archivoslide = "";
            if($_FILES['archivoslide']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $path = $_FILES['archivoslide']['name'];
                    $source_file = $_FILES['archivoslide']['tmp_name'];

                    $fecha = date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli="Slide_".$fecha."_".rand(10,199);
                    $nombre = $nombre_soli.".".$ext;

                    ftp_pasv($con_id,true);
                    $subio = ftp_put($con_id,"slide/rrhh/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $archivoslide = "https://lanumerounocloud.com/intranet/slide/rrhh/".$nombre;
                        Slide::create([
                            'id_area' => 11,
                            'base' => $request->input("tipo"),
                            'orden' => $request->input("orden"),
                            'entrada_slide' => $request->input("entrada_slide"),
                            'salida_slide' => $request->input("salida_slide"),
                            'duracion' => $request->input("duracion"),
                            'tipo_slide' => $request->input("tipo_slide"),
                            'titulo' => $request->input("titulo"),
                            'descripcion' => $request->input("descripcion"),
                            'archivoslide' => $archivoslide,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
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

    public function Modal_Update_Slider_Rrhh($id_slide){
        $dato['id_slide']= $id_slide;
        $get_id = Slide::get_list_slider_rrhh($dato);
        $list_base = Base::select('cod_base')
                    ->where('estado',1)
                    ->groupBy('cod_base')
                    ->orderBy('cod_base', 'ASC')
                    ->get();
        return view('rrhh.Comunicado.modal_editar_sr', compact('list_base','get_id'));
    }

    public function Update_Slider_Rrhh(Request $request){
        $request->validate([
            'tipoe' => 'not_in:0',
            'ordene' => 'not_in:0',
            'entrada_slidee' => 'required',
            'salida_slidee' => 'required',
            'tipo_slidee' => 'not_in:0',
            'tituloe' => 'required',
            'descripcione' => 'required',
        ],[
            'tipoe.not_in' => 'Debe seleccionar tipo.',
            'ordene.not_in' => 'Debe seleccionar orden.',
            'entrada_slidee.required' => 'Debe ingresar tiempo de entrada.',
            'salida_slidee.required' => 'Debe ingresar tiempo de salida.',
            'tipo_slidee.not_in' => 'Debe seleccionar tipo de slide',
            'tituloe.required' => 'Debe ingresar descripcion.',
            'descripcione.required' => 'Debe ingresar descripcion.',
        ]);

        $valida = Slide::where('base', $request->input)
                    ->where('orden', $request->orden)
                    ->where('id_area', session('usuario')->id_area)
                    ->where('tipo_slide', $request->tipo_slide)
                    ->where('estado', 1)
                    ->exists();

        if ($valida){
            echo "error";
        }else{
            $dato['id_slide']= $request->input("id_slide");
            $get_id = Slide::get_list_slider_rrhh($dato);
            $archivoslide = $get_id[0]['archivoslide'];

            if($_FILES['archivoslidee']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    ftp_delete($con_id, 'slide/rrhh/'.basename($archivoslide));

                    $path = $_FILES['archivoslidee']['name'];
                    $source_file = $_FILES['archivoslidee']['tmp_name'];

                    $fecha = date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli="Slide_".$fecha."_".rand(10,199);
                    $nombre = $nombre_soli.".".$ext;

                    ftp_pasv($con_id,true);
                    $subio = ftp_put($con_id,"slide/rrhh/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $archivoslide = "https://lanumerounocloud.com/intranet/slide/rrhh/".$nombre;
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }
            Slide::findOrFail($request->id_slide)->update([
                'id_area' => 11,
                'base' => $request->tipoe,
                'orden' => $request->ordene,
                'entrada_slide' => $request->entrada_slidee,
                'salida_slide' => $request->salida_slidee,
                'duracion' => $request->duracione,
                'tipo_slide' => $request->tipo_slidee,
                'titulo' => $request->tituloe,
                'descripcion' => $request->descripcione,
                'archivoslide' => $archivoslide,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }
    }

    public function Delete_Slider_Rrhh(Request $request){
        $dato['id_slide']= $request->input("id_slide");
        $get_file = Slide::get_list_slider_rrhh($dato);

        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
        if($con_id && $lr){
            $file_to_delete = "slide/rrhh/".basename($get_file[0]['archivoslide']);

            if (ftp_delete($con_id, $file_to_delete)) {
                Slide::findOrFail($request->id_slide)->update([
                    'estado' => 2,
                    'fec_eli' => now(),
                    'user_eli' => session('usuario')->id_usuario,
                ]);
            }else{
                echo "Error al eliminar el archivo.";
            }
        }else{
            echo "No se conecto";
        }
    }

    public function Cargar_Anuncio_Intranet(){
        return view("rrhh.Comunicado.anuncio_intranet");
    }

    public function Lista_Anuncio_Intranet(){
        $list_anuncio_intranet = BolsaTrabajo::get_list_anuncio_intranet();
        return view("rrhh.Comunicado.lista_ai", compact('list_anuncio_intranet'));
    }

    public function Modal_Anuncio_Intranet(){
        $list_base = Base::select('cod_base')
                    ->where('estado',1)
                    ->groupBy('cod_base')
                    ->orderBy('cod_base', 'ASC')
                    ->get();
        return view('rrhh.Comunicado.modal_registrar_ai', compact('list_base'));
    }

    public function Insert_Anuncio_Intranet(Request $request){
        $request->validate([
            'cod_base' => 'not_in:0',
            'orden' => 'required',
            'url' => 'required',
            'imagen' => 'required',
        ],[
            'cod_base.not_in' => 'Debe seleccionar tipo.',
            'orden.required' => 'Debe ingresar orden.',
            'url.required' => 'Debe ingresar url.',
            'imagen.required' => 'Debe ingresar imagen.',
        ]);

        $valida = BolsaTrabajo::select('id_bolsa_trabajo')
                    ->where('estado', 1)
                    ->where('orden',$request->orden)
                    ->where('cod_base',$request->cod_base)
                    ->exists();

        if($valida){
            echo "error";
        }else{
            if($_FILES['imagen']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    if($_FILES['imagen']['name']!=""){
                        $path = $_FILES['imagen']['name'];
                        $temp = explode(".",$_FILES['imagen']['name']);
                        $source_file = $_FILES['imagen']['tmp_name'];

                        $fecha=date('Y-m-d');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli="BT_".$fecha."_".rand(10,199);
                        $nombre = $nombre_soli.".".$ext;

                        ftp_pasv($con_id,true);
                        $subio = ftp_put($con_id,"Bolsa_Trabajo/".$nombre,$source_file,FTP_BINARY);
                        if($subio){
                            $imagen = "https://lanumerounocloud.com/intranet/Bolsa_Trabajo/".$nombre;
                            BolsaTrabajo::create([
                                'cod_base' => $request->cod_base,
                                'orden' => $request->orden,
                                'url' => $request->url,
                                'imagen' => $imagen,
                                'publicado' => $request->publicado,
                                'estado' => 1,
                                'fec_reg' => now(),
                                'user_reg' => session('usuario')->id_usuario,
                                'fec_act' => now(),
                                'user_act' => session('usuario')->id_usuario,
                            ]);
                        }else{
                            echo "Archivo no subido correctamente";
                        }
                    }
                }else{
                    echo "No se conecto";
                }
            }
        }
    }

    public function Modal_Update_Anuncio_Intranet($id_bolsa_trabajo){
        $get_id = BolsaTrabajo::where('id_bolsa_trabajo', $id_bolsa_trabajo)
                                ->get();
        $list_base = Base::select('cod_base')
        ->where('estado',1)
        ->groupBy('cod_base')
        ->orderBy('cod_base', 'ASC')
        ->get();
        return view('rrhh.Comunicado.modal_editar_ai', compact('get_id', 'list_base'));
    }

    public function Update_Anuncio_Intranet(Request $request){
        $id_bolsa_trabajo = $request->input("id_bolsa_trabajo");
        $get_id = BolsaTrabajo::where('id_bolsa_trabajo', $id_bolsa_trabajo)
                                ->get();
        $dato['imagen'] = $get_id[0]['imagen'];

        $request->validate([
            'cod_basee' => 'not_in:0',
            'ordene' => 'required',
            'urle' => 'required',
            'imagene' => 'required',
        ],[
            'cod_basee.not_in' => 'Debe seleccionar tipo.',
            'ordene.required' => 'Debe ingresar orden.',
            'urle.required' => 'Debe ingresar url.',
            'imagene.required' => 'Debe ingresar imagen.',
        ]);

        $valida = BolsaTrabajo::select('id_bolsa_trabajo')
                    ->where('estado', 1)
                    ->where('orden',$request->ordene)
                    ->where('cod_base',$request->cod_basee)
                    ->exists();

        if($valida){
            echo "error";
        }else{
            if($_FILES['imagene']['name']!=""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    ftp_delete($con_id, 'Bolsa_Trabajo/'.basename($dato['imagen']));

                    $path = $_FILES['imagene']['name'];
                    $temp = explode(".",$_FILES['imagene']['name']);
                    $source_file = $_FILES['imagene']['tmp_name'];

                    $fecha=date('Y-m-d');
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli="BT_".$fecha."_".rand(10,199);
                    $nombre = $nombre_soli.".".$ext;

                    ftp_pasv($con_id,true);
                    $subio = ftp_put($con_id,"Bolsa_Trabajo/".$nombre,$source_file,FTP_BINARY);
                    if($subio){
                        $imagen = "https://lanumerounocloud.com/intranet/Bolsa_Trabajo/".$nombre;
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }
            BolsaTrabajo::findOrFail($id_bolsa_trabajo)->update([
                'cod_base' => $request->cod_basee,
                'orden' => $request->ordene,
                'url' => $request->urle,
                'imagen' => $imagen,
                'publicado' => $request->publicadoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function Delete_Anuncio_Intranet(Request $request){
            $id_bolsa_trabajo = $request->input("id_bolsa_trabajo");
            $get_file = BolsaTrabajo::where('id_bolsa_trabajo', $id_bolsa_trabajo)
            ->get();

            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "Bolsa_Trabajo/".basename($get_file[0]['imagen']);

                if (ftp_delete($con_id, $file_to_delete)) {
                    BolsaTrabajo::findOrFail($id_bolsa_trabajo)->update([
                        'estado' => 2,
                        'fec_eli' => now(),
                        'user_eli' => session('usuario')->id_usuario
                    ]);
                }else{
                    echo "Error al eliminar el archivo.";
                }
            }else{
                echo "No se conecto";
            }
    }
}
