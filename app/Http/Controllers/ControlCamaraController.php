<?php

namespace App\Http\Controllers;

use App\Models\AperturaCierreTienda;
use App\Models\ControlCamaraArchivoTemporal;
use App\Models\Horas;
use App\Models\OcurrenciasCamaras;
use App\Models\Sedes;
use App\Models\Tiendas;
use Google\Service\ServiceConsumerManagement\Control;
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
        $list_control_camara = AperturaCierreTienda::get_list_apertura_cierre_tienda(['cod_base'=>$request->cod_base,'fec_ini'=>$request->fec_ini,'fec_fin'=>$request->fec_fin]);
        return view('seguridad.control_camara.registro.lista', compact('list_control_camara'));
    }

    public function create_reg()
    {
        $list_sede = Sedes::select('id_sede','nombre_sede')->get();                                     
        return view('seguridad.control_camara.registro.modal_registrar', compact('list_sede'));
    }

    public function traer_hora_programada_reg(Request $request)
    {
        $ultimo = Horas::select('hora')->where('id_sede',$request->id_sede)->where('hora','>','18:00:00')->where('estado',1)->orderBy('hora','ASC')->first();
        echo $ultimo->hora;
    }

    public function traer_tienda_reg(Request $request)
    {
        $list_tienda_base = Tiendas::select('tiendas.id_tienda','local.descripcion')
                                    ->join('local','local.id_local','=','tiendas.id_local')
                                    ->where('tiendas.id_sede', $request->id_sede)->where('local.sede',NULL)
                                    ->where('tiendas.estado', 1)
                                    ->get();
        $list_tienda_sede = Tiendas::select('tiendas.id_tienda','local.descripcion')
                                    ->join('local','local.id_local','=','tiendas.id_local')
                                    ->where('tiendas.id_sede', $request->id_sede)->where('local.sede',1)
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

    public function insert_captura_reg(Request $request,$id_tienda){
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
}