<?php

namespace App\Http\Controllers;

use App\Models\AperturaCierreTienda;
use App\Models\ControlCamara;
use App\Models\ControlCamaraArchivo;
use App\Models\ControlCamaraArchivoTemporal;
use App\Models\ControlCamaraRonda;
use App\Models\Horas;
use App\Models\OcurrenciasCamaras;
use App\Models\Sedes;
use App\Models\Tiendas;
use App\Models\TiendasRonda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControlCamaraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.control_camara.index');
    }

    public function index_reg()
    {
        return view('seguridad.control_camara.registro.index');
    }

    public function list_reg(Request $request)
    {
        $list_control_camara = ControlCamara::get_list_control_camara();
        return view('seguridad.control_camara.registro.lista', compact('list_control_camara'));
    }

    public function create_reg()
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)->get();
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "CONTROL_CAMARA/".basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }
        $list_sede = Sedes::select('id_sede','nombre_sede')->where('estado',1)->get();
        return view('seguridad.control_camara.registro.modal_registrar', compact('list_sede'));
    }

    public function traer_hora_programada_reg(Request $request)
    {
        $cantidad = ControlCamara::where('id_sede',$request->id_sede)->where('fecha',date('Y-m-d'))
                                    ->where('estado',1)->count();                                    
        $ultimo = Horas::select('hora')->where('id_sede',$request->id_sede)->where('orden',($cantidad+1))
                        ->where('estado',1)->first();
        echo $ultimo->hora;
    }

    public function traer_tienda_reg(Request $request)
    {
        $list_archivo = ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)->get();
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "CONTROL_CAMARA/".basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        ControlCamaraArchivoTemporal::where('id', $list->id)->delete();
                    }
                }
            }
        }

        $list_tienda_base = Tiendas::select('tiendas.id_tienda','local.descripcion')
                                    ->join('local','local.id_local','=','tiendas.id_local')
                                    ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda',NULL)
                                    ->where('tiendas.estado', 1)
                                    ->get();
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda','local.descripcion')
                                    ->join('local','local.id_local','=','tiendas.id_local')
                                    ->where('tiendas.id_sede', $request->id_sede)->where('tiendas.ronda',1)
                                    ->where('tiendas.estado', 1)
                                    ->get();
        $list_ocurrencia = OcurrenciasCamaras::select('id_ocurrencias_camaras','descripcion')
                                                ->where('estado',1)->get();                                           
        return view('seguridad.control_camara.registro.tienda', compact('list_tienda_base','list_tienda_sede','list_ocurrencia'));
    }
    
    public function modal_imagen_reg($id_tienda)
    {
        $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                ->where('id_tienda',$id_tienda)->first();
        return view('seguridad.control_camara.registro.modal_imagen', compact('id_tienda','get_id'));
    }

    public function insert_imagen_reg(Request $request,$id_tienda)
    {
        $request->validate([
            'archivo_base' => 'required',
        ],[
            'archivo_base.required' => 'Debe ingresar imagen.',
        ]);

        if($_FILES["archivo_base"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $valida = ControlCamaraArchivoTemporal::select('archivo')
                                                        ->where('id_usuario',session('usuario')->id_usuario)
                                                        ->where('id_tienda',$id_tienda)->exists();
                if($valida){
                    $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                            ->where('id_usuario',session('usuario')->id_usuario)
                                                            ->where('id_tienda',$id_tienda)->first();
                    ftp_delete($con_id, 'CONTROL_CAMARA/'.basename($get_id->archivo));
                    ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                                                ->where('id_tienda',$id_tienda)->delete();
                }

                $path = $_FILES["archivo_base"]["name"];
                $source_file = $_FILES['archivo_base']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_".$id_tienda."_".session('usuario')->id_usuario;
                $nombre = $nombre_soli.".".strtolower($ext);
                $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/".$nombre;

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"CONTROL_CAMARA/".$nombre,$source_file,FTP_BINARY);
                if ($subio) {
                    ControlCamaraArchivoTemporal::create([
                        'id_usuario' => session('usuario')->id_usuario,
                        'id_tienda' => $id_tienda,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }
    }

    public function modal_ronda_reg($id_tienda)
    {
        $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                ->where('id_tienda',$id_tienda)->first();
        $get_sede = Tiendas::select('sedes.nombre_sede')
                    ->join('sedes','sedes.id_sede','=','tiendas.id_sede')
                    ->where('id_tienda',$id_tienda)->first();
        $list_ronda = TiendasRonda::select('tiendas_ronda.id','control_camara_ronda.descripcion')
                        ->join('control_camara_ronda','control_camara_ronda.id','=','tiendas_ronda.id_ronda')
                        ->where('tiendas_ronda.id_tienda',$id_tienda)->get();
        return view('seguridad.control_camara.registro.modal_ronda', compact('id_tienda','get_id','get_sede','list_ronda'));
    }

    public function insert_ronda_reg(Request $request,$id_tienda)
    {
        $rules = [
            'archivo_ronda' => 'required',
        ];
        $messages = [
            'archivo_ronda.required' => 'Debe ingresar imagen.',
        ];

        $list_ronda = TiendasRonda::select('tiendas_ronda.id','control_camara_ronda.descripcion')
                        ->join('control_camara_ronda','control_camara_ronda.id','=','tiendas_ronda.id_ronda')
                        ->where('tiendas_ronda.id_tienda',$id_tienda)->get();
        foreach($list_ronda as $list){
            $rules['archivo_ronda_'.$list->id] = 'required';
            $messages['archivo_ronda_'.$list->id.'.required'] = 'Debe ingresar imagen para '.$list->descripcion.'.';
        }

        $request->validate($rules, $messages);

        if($_FILES["archivo_ronda"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $valida = ControlCamaraArchivoTemporal::select('archivo')
                                                        ->where('id_usuario',session('usuario')->id_usuario)
                                                        ->where('id_tienda',$id_tienda)->exists();
                if($valida){
                    $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                            ->where('id_usuario',session('usuario')->id_usuario)
                                                            ->where('id_tienda',$id_tienda)->first();
                    ftp_delete($con_id, 'CONTROL_CAMARA/'.basename($get_id->archivo));
                    ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                                                ->where('id_tienda',$id_tienda)->delete();
                }

                $path = $_FILES["archivo_ronda"]["name"];
                $source_file = $_FILES['archivo_ronda']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_".$id_tienda."_".session('usuario')->id_usuario;
                $nombre = $nombre_soli.".".strtolower($ext);
                $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/".$nombre;

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"CONTROL_CAMARA/".$nombre,$source_file,FTP_BINARY);
                if ($subio) {
                    ControlCamaraArchivoTemporal::create([
                        'id_usuario' => session('usuario')->id_usuario,
                        'id_tienda' => $id_tienda,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "Archivo no subido correctamente 0";
                }

                //CAPTURAS DE RONDAS
                foreach($list_ronda as $list){
                    if($_FILES["archivo_ronda_".$list->id]["name"] != ""){
                        $valida = ControlCamaraArchivoTemporal::select('archivo')
                                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                                ->where('id_tienda',$id_tienda)
                                                                ->where('id_ronda',$list->id)->exists();
                        if($valida){
                            $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                        ->where('id_usuario',session('usuario')->id_usuario)
                                                        ->where('id_tienda',$id_tienda)
                                                        ->where('id_ronda',$list->id)->first();
                            ftp_delete($con_id, 'CONTROL_CAMARA/'.basename($get_id->archivo));
                            ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                                            ->where('id_tienda',$id_tienda)
                                            ->where('id_ronda',$list->id)->delete();
                        }

                        $path = $_FILES["archivo_ronda_".$list->id]["name"];
                        $source_file = $_FILES['archivo_ronda_'.$list->id]['tmp_name'];

                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "temporal_".$id_tienda."_".$list->id."_".session('usuario')->id_usuario;
                        $nombre = $nombre_soli.".".strtolower($ext);
                        $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/".$nombre;

                        ftp_pasv($con_id,true); 
                        $subio = ftp_put($con_id,"CONTROL_CAMARA/".$nombre,$source_file,FTP_BINARY);
                        if ($subio) {
                            ControlCamaraArchivoTemporal::create([
                                'id_usuario' => session('usuario')->id_usuario,
                                'id_tienda' => $id_tienda,
                                'id_ronda' => $list->id,
                                'archivo' => $archivo
                            ]);
                        }else{
                            echo "Archivo no subido correctamente ".$list->id;
                        }
                    }
                }
            }else{
                echo "No se conecto";
            }
        }

        /*foreach($list_ronda as $list){
            if($_FILES["archivo_ronda_".$list->id]["name"] != ""){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $valida = ControlCamaraArchivoTemporal::select('archivo')
                                                            ->where('id_usuario',session('usuario')->id_usuario)
                                                            ->where('id_tienda',$id_tienda)
                                                            ->where('id_ronda',$list->id)->exists();
                    if($valida){
                        $get_id = ControlCamaraArchivoTemporal::select('archivo')
                                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                                ->where('id_tienda',$id_tienda)
                                                                ->where('id_ronda',$list->id)->first();
                        ftp_delete($con_id, 'CONTROL_CAMARA/'.basename($get_id->archivo));
                        ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                                                    ->where('id_tienda',$id_tienda)
                                                    ->where('id_ronda',$list->id)->delete();
                    }
    
                    $path = $_FILES["archivo_ronda_".$list->id]["name"];
                    $source_file = $_FILES['archivo_ronda_'.$list->id]['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "temporal_".$id_tienda."_".$list->id."_".session('usuario')->id_usuario;
                    $nombre = $nombre_soli.".".strtolower($ext);
                    $archivo = "https://lanumerounocloud.com/intranet/CONTROL_CAMARA/".$nombre;
    
                    ftp_pasv($con_id,true); 
                    $subio = ftp_put($con_id,"CONTROL_CAMARA/".$nombre,$source_file,FTP_BINARY);
                    if ($subio) {
                        ControlCamaraArchivoTemporal::create([
                            'id_usuario' => session('usuario')->id_usuario,
                            'id_tienda' => $id_tienda,
                            'id_ronda' => $list->id,
                            'archivo' => $archivo
                        ]);
                    }else{
                        echo "Archivo no subido correctamente";
                    }
                }else{
                    echo "No se conecto";
                }
            }
        }*/
    }

    public function valida_captura_reg(Request $request)
    {
        $valida = ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)
                                                ->where('id_tienda',$request->id_tienda)->exists();
        if($valida){
            $cantidad_tienda = Tiendas::where('id_sede',$request->id_sede)->count();
            $cantidad_ronda = 0;
            $tienda = Tiendas::select('id_tienda')->where('id_sede',$request->id_sede)->where('ronda',1)
                    ->where('estado',1)->first();
            if($tienda->id_tienda){
                $cantidad_ronda = TiendasRonda::where('id_tienda',$tienda->id_tienda)->count();
            }
            $cantidad = $cantidad_tienda+$cantidad_ronda;
            $valida = ControlCamaraArchivoTemporal::where('id_usuario',session('usuario')->id_usuario)->count();
            if($valida==$cantidad){
                echo "habilitar";
            }
        }
    }
    
    public function store_reg(Request $request)
    {
        $cantidad = ControlCamara::where('id_sede',$request->id_sede)->where('fecha',date('Y-m-d'))
                                    ->where('estado',1)->count();                                    
        $ultimo = Horas::select('hora')->where('id_sede',$request->id_sede)->where('orden',($cantidad+1))
                        ->where('estado',1)->first();

        $list_tienda_base = Tiendas::select('id_tienda')
                                    ->where('id_sede', $request->id_sede)->where('ronda',NULL)
                                    ->where('estado', 1)
                                    ->get();
        if(count($list_tienda_base)>0){
            foreach($list_tienda_base as $list){
                $id_ocurrencia = $request->input('id_ocurrencia_'.$list->id_tienda);
                if($request->input('id_ocurrencia_'.$list->id_tienda)=="0"){
                    $id_ocurrencia = 12;
                }

                $control_camara = ControlCamara::create([
                    'id_usuario' => session('usuario')->id_usuario,
                    'id_sede' => $request->id_sede,
                    'fecha' => now(),
                    'hora_programada' => $ultimo->hora,
                    'hora_registro' => now(),
                    'id_tienda' => $list->id_tienda,
                    'id_ocurrencia' => $id_ocurrencia,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $list_temporal = ControlCamaraArchivoTemporal::select('id','archivo')
                                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                                ->where('id_tienda',$list->id_tienda)->get();
                
                if(count($list_temporal)>0){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if($con_id && $lr){
                        foreach($list_temporal as $temporal){
                            $nombre_actual = ltrim($temporal->archivo,'https://lanumerounocloud.com/intranet');
                            $nuevo_nombre = "CONTROL_CAMARA/Evidencia_".$control_camara->id."_".date('YmdHis').".".pathinfo($temporal->archivo,PATHINFO_EXTENSION);
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;

                            ControlCamaraArchivo::create([
                                'id_control_camara' => $control_camara->id,
                                'archivo' => $archivo
                            ]);
                            ControlCamaraArchivoTemporal::where('id',$temporal->id)->delete();
                        }
                    }else{
                        echo "No se conecto";
                    }
                }
            }
        }
        $list_tienda_sede = Tiendas::select('id_tienda')
                                    ->where('id_sede', $request->id_sede)->where('ronda',1)
                                    ->where('estado', 1)
                                    ->get();
        if(count($list_tienda_sede)>0){
            foreach($list_tienda_sede as $list){
                $id_ocurrencia = $request->input('id_ocurrencia_'.$list->id_tienda);
                if($request->input('id_ocurrencia_'.$list->id_tienda)=="0"){
                    $id_ocurrencia = 12;
                }

                $control_camara = ControlCamara::create([
                    'id_usuario' => session('usuario')->id_usuario,
                    'id_sede' => $request->id_sede,
                    'fecha' => now(),
                    'hora_programada' => $ultimo->hora,
                    'hora_registro' => now(),
                    'id_tienda' => $list->id_tienda,
                    'id_ocurrencia' => $id_ocurrencia,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $list_temporal = ControlCamaraArchivoTemporal::select('id','id_ronda','archivo')
                                                                ->where('id_usuario',session('usuario')->id_usuario)
                                                                ->where('id_tienda',$list->id_tienda)->get();
                
                if(count($list_temporal)>0){
                    $ftp_server = "lanumerounocloud.com";
                    $ftp_usuario = "intranet@lanumerounocloud.com";
                    $ftp_pass = "Intranet2022@";
                    $con_id = ftp_connect($ftp_server);
                    $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                    if($con_id && $lr){
                        foreach($list_temporal as $temporal){
                            $nombre_actual = ltrim($temporal->archivo,'https://lanumerounocloud.com/intranet');
                            $nuevo_nombre = "CONTROL_CAMARA/Evidencia_".$control_camara->id."_".$temporal->id_ronda."_".date('YmdHis').".".pathinfo($temporal->archivo,PATHINFO_EXTENSION);
                            ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                            $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;

                            ControlCamaraArchivo::create([
                                'id_control_camara' => $control_camara->id,
                                'id_ronda' => $temporal->id_ronda,
                                'archivo' => $archivo
                            ]);
                            ControlCamaraArchivoTemporal::where('id',$temporal->id)->delete();
                        }
                    }else{
                        echo "No se conecto";
                    }
                }
            }
        }                                    
    }
}