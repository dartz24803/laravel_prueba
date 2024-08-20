<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\SeguridadAsistencia;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsistenciaSegController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('seguridad.asistencia.index');
    }

    public function index_lec()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('seguridad.asistencia.lectora.index',compact('list_base'));
    }

    public function list_lec(Request $request)
    {
        $list_lectora = SeguridadAsistencia::get_list_lectora();
        return view('seguridad.asistencia.lectora.lista', compact('list_lectora'));
    }

    public function store_lec(Request $request)
    {
        $request->validate([
            'num_doc' => 'required'
        ],[
            'num_doc.required' => 'Debe ingresar n° documento.'
        ]);

        $valida = Usuario::where('num_doc',$request->num_doc)->where('estado',1)->exists();

        if($valida){
            $get_id = Usuario::select('users.id_usuario','users.foto',
                    DB::raw('LOWER(users.usuario_nombres) AS nombre_minuscula'),
                    DB::raw('LOWER(CONCAT(users.usuario_apater," ",users.usuario_amater)) AS apellido_minuscula'),
                    DB::raw('LOWER(puesto.nom_puesto) AS puesto_minuscula'),'users.centro_labores')
                    ->join('puesto','puesto.id_puesto','=','users.id_puesto')
                    ->where('users.num_doc',$request->num_doc)->where('users.estado',1)->first();
            if($request->horario_registro=="2"){ 
                $valida = SeguridadAsistencia::where('id_usuario',$get_id->id_usuario)->where('estado',1)
                        ->where('fecha',date('Y-m-d'))->exists();
                if($valida){
                    if($request->cod_base){
                        $cod_base = $request->cod_base;
                    }else{
                        $cod_base = session('usuario')->centro_labores;
                    }
                    SeguridadAsistencia::where('id_usuario',$get_id->id_usuario)->where('estado',1)
                    ->where('fecha',date('Y-m-d'))->orderBy('id_seguridad_asistencia','DESC')->first()
                    ->update([
                        'cod_sedes' => $cod_base,
                        'fecha_salida' => now(),
                        'h_salida' => now(),
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                    echo $get_id->foto."*".ucwords($get_id->nombre_minuscula)."*".ucwords($get_id->apellido_minuscula)."*".ucwords($get_id->puesto_minuscula)."*".$get_id->centro_labores;
                }else{
                    echo "sin_ingreso";
                }
            }else{
                if($request->cod_base){
                    $cod_base = $request->cod_base;
                }else{
                    $cod_base = session('usuario')->centro_labores;
                }
                SeguridadAsistencia::create([
                    'id_usuario' => $get_id->id_usuario,
                    'base' => $cod_base,
                    'cod_sede' => $cod_base,
                    'fecha' => now(),
                    'h_ingreso' => now(),
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                echo $get_id->foto."*".ucwords($get_id->nombre_minuscula)."*".ucwords($get_id->apellido_minuscula)."*".ucwords($get_id->puesto_minuscula)."*".$get_id->centro_labores;
            }
        }else{
            echo "error";
        }
    }

    public function edit_lec($id,$tipo)
    {
        $get_id = SeguridadAsistencia::get_list_lectora(['id_seguridad_asistencia'=>$id]);
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('seguridad.asistencia.lectora.modal_editar',compact('get_id','tipo','list_base'));
    }

    public function update_lec(Request $request,$id,$tipo)
    {
        if($tipo=="ingreso"){
            $request->validate([
                'cod_sedee' => 'not_in:0',
                'h_ingresoe' => 'required'
            ],[
                'cod_sedee.not_in' => 'Debe seleccionar sede.',
                'h_ingresoe.required' => 'Debe ingresar hora ingreso.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'cod_sede' => $request->cod_sedee,
                'h_ingreso' => $request->h_ingresoe,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            $request->validate([
                'fecha_salidae' => 'required',
                'cod_sedese' => 'not_in:0',
                'h_salidae' => 'required'
            ],[
                'fecha_salidae.required' => 'Debe ingresar fecha.',
                'cod_sedese.not_in' => 'Debe seleccionar sede.',
                'h_salidae.required' => 'Debe ingresar hora salida.'
            ]);

            SeguridadAsistencia::findOrFail($id)->update([
                'fecha_salida' => $request->fecha_salidae,
                'cod_sedes' => $request->cod_sedese,
                'h_salida' => $request->h_salidae,
                'observacion' => $request->observacione,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function image_lec($id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);
        return view('seguridad.asistencia.lectora.modal_imagen',compact('get_id'));
    }

    public function download_lec($id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);

        // URL del archivo
        $url = $get_id->imagen;

        // Crear un cliente Guzzle
        $client = new Client();

        // Realizar la solicitud GET para obtener el archivo
        $response = $client->get($url);

        // Obtener el contenido del archivo
        $content = $response->getBody()->getContents();

        // Obtener el nombre del archivo desde la URL
        $filename = basename($url);

        // Devolver el contenido del archivo en la respuesta
        return response($content, 200)
                    ->header('Content-Type', $response->getHeaderLine('Content-Type'))
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function update_image_lec(Request $request,$id)
    {
        $get_id = SeguridadAsistencia::findOrFail($id);

        $archivo = "";
        if($_FILES["imagene"]["name"] != ""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                if($get_id->imagen!=""){
                    ftp_delete($con_id, 'SEGURIDAD/ASISTENCIA/'.basename($get_id->imagen));
                }
                $path = $_FILES["imagene"]["name"];
                $source_file = $_FILES['imagene']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Evidencia_".$get_id->id_seguridad_asistencia."_".date('YmdHis');
                $nombre = $nombre_soli.".".strtolower($ext);

                ftp_pasv($con_id,true);
                $subio = ftp_put($con_id,"SEGURIDAD/ASISTENCIA/".$nombre,$source_file,FTP_BINARY);
                if($subio){
                    $archivo = "https://lanumerounocloud.com/intranet/SEGURIDAD/ASISTENCIA/".$nombre;
                }else{
                    echo "Archivo no subido correctamente";
                }
            }else{
                echo "No se conecto";
            }
        }

        SeguridadAsistencia::findOrFail($id)->update([
            'imagen' => $archivo,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_lec($id)
    {
        SeguridadAsistencia::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
