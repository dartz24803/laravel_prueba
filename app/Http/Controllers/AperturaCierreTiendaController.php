<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AperturaCierreTienda;
use App\Models\ArchivosAperturaCierreTienda;
use App\Models\Base;
use App\Models\TiendaMarcacionDia;
use Illuminate\Http\Request;

class AperturaCierreTiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('seguridad.apertura_cierre.index', compact('list_base'));
    }

    public function list(Request $request)
    {
        $list_apertura_cierre_tienda = AperturaCierreTienda::get_list_apertura_cierre_tienda(['cod_base'=>$request->cod_base,'fec_ini'=>$request->fec_ini,'fec_fin'=>$request->fec_fin]);
        return view('seguridad.apertura_cierre.lista', compact('list_apertura_cierre_tienda'));
    }

    public function create()
    {
        $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_ingreso')
                                        ->join('tienda_marcacion','tienda_marcacion.id_tienda_marcacion','=','tienda_marcacion_dia.id_tienda_marcacion')
                                        ->where('tienda_marcacion.cod_base',session('usuario')->centro_labores)
                                        ->where('tienda_marcacion.estado',1)
                                        ->where('tienda_marcacion_dia.dia',date('j'))
                                        ->first();
        return view('seguridad.apertura_cierre.modal_registrar', compact('get_hora'));
    }

    public function previsualizacion_captura()
    {
        if($_FILES["photo"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if(file_exists('https://lanumerounocloud.com/intranet/APERTURA_CIERRE_TIENDA/temporal_'.session('usuario')->id_usuario.'.jpg')){
                    ftp_delete($con_id, 'APERTURA_CIERRE_TIENDA/temporal_'.session('usuario')->id_usuario.'.jpg');
                }

                $path = $_FILES["photo"]["name"];
                $source_file = $_FILES['photo']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "temporal_".session('usuario')->id_usuario;
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true); 
                $subio = ftp_put($con_id,"APERTURA_CIERRE_TIENDA/".$nombre,$source_file,FTP_BINARY);
                if (!$subio) {
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }
    }

    public function store(Request $request)
    {
        $valida = AperturaCierreTienda::where('fecha', date('Y-m-d'))
                                        ->where('cod_base', session('usuario')->centro_labores)
                                        ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_ingreso')
                                        ->join('tienda_marcacion','tienda_marcacion.id_tienda_marcacion','=','tienda_marcacion_dia.id_tienda_marcacion')
                                        ->where('tienda_marcacion.cod_base',session('usuario')->centro_labores)
                                        ->where('tienda_marcacion.estado',1)
                                        ->where('tienda_marcacion_dia.dia',date('j'))
                                        ->first();

            $apertura = AperturaCierreTienda::create([
                'fecha' => date('Y-m-d'),
                'cod_base' => session('usuario')->centro_labores,
                'ingreso_horario' => $get_hora->hora_ingreso,
                'ingreso' => now(),
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);                                        

            if($request->captura=="1"){
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
                if($con_id && $lr){
                    $nombre_actual = "APERTURA_CIERRE_TIENDA/temporal_".session('usuario')->id_usuario.".jpg";
                    $nuevo_nombre = "APERTURA_CIERRE_TIENDA/Evidencia_".$apertura->id_apertura_cierre."_".date('YmdHis').".jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $archivo = "https://lanumerounocloud.com/intranet/".$nuevo_nombre;
                    
                    ArchivosAperturaCierreTienda::create([
                        'id_apertura_cierre' => $apertura->id_apertura_cierre,
                        'archivo' => $archivo
                    ]);
                }else{
                    echo "No se conecto";
                }
            }
        }
    }

    public function edit($id)
    {
        $get_id = AperturaCierreTienda::get_list_apertura_cierre_tienda(['id_apertura_cierre'=>$id]);
        if($get_id->tipo_apertura=="2"){
            $minuscula = "apertura";
            $titulo = "Apertura de tienda";
        }elseif($get_id->tipo_apertura=="3"){
            $minuscula = "cierre";
            $titulo = "Cierre de tienda";
        }elseif($get_id->tipo_apertura=="4"){
            $minuscula = "salida";
            $titulo = "Salida de personal";
        }
        $get_hora = TiendaMarcacionDia::select('tienda_marcacion_dia.hora_'.$minuscula.' AS hora_programada')
                                        ->join('tienda_marcacion','tienda_marcacion.id_tienda_marcacion','=','tienda_marcacion_dia.id_tienda_marcacion')
                                        ->where('tienda_marcacion.cod_base',session('usuario')->centro_labores)
                                        ->where('tienda_marcacion.estado',1)
                                        ->where('tienda_marcacion_dia.dia',date('j'))
                                        ->first();
        return view('seguridad.apertura_cierre.modal_editar', compact('get_id','get_hora','titulo'));
    }
}