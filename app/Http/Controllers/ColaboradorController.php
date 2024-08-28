<?php

namespace App\Http\Controllers;

use App\Models\Gerencia;
use App\Models\Organigrama;
use App\Models\Usuario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ColaboradorController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('rrhh.colaborador.index');
    }

    public function index_co()
    {
        $list_gerencia = Gerencia::where('estado',1)->orderBy('nom_gerencia','ASC')->get();
        return view('rrhh.colaborador.colaborador.index', compact('list_gerencia'));
    }

    public function list_co(Request $request)
    {
        $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia'=>$request->id_gerencia]);
        return view('rrhh.colaborador.colaborador.lista', compact('list_colaborador'));
    }

    public function mail_co(Request $request)
    {
        $get_id = Usuario::findOrFail($request->id_usuario);

        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena = strlen($cadena);
        $password = "";
        $longitudPass = 6;
    
        for($i=1 ; $i<=$longitudPass ; $i++){
            $pos = rand(0,$longitudCadena-1);
            $password .= substr($cadena,$pos,1);
        }

        $mail = new PHPMailer(true);
    
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       =  'mail.lanumero1.com.pe';
            $mail->SMTPAuth   =  true;
            $mail->Username   =  'intranet@lanumero1.com.pe';
            $mail->Password   =  'lanumero1$1';
            $mail->SMTPSecure =  'tls';
            $mail->Port     =  587; 
            $mail->setFrom('intranet@lanumero1.com.pe','La Número 1');

            $mail->addAddress($get_id->usuario_email);

            $mail->isHTML(true);

            $mail->Subject = "Actualización de contraseña";
        
            $mail->Body =  "<h1> Hola, ".$get_id->usuario_nombres." ".$get_id->usuario_apater."</h1>
                            <p>Te damos la bienvenida a la gran familia La Número 1.</p>
                            <p>A continuación deberás colocar tu nueva contraseña para ingresar a nuestro 
                            portal: $password</p>
                            <p>Gracias.<br>Atte. Grupo La Número 1</p>";
            $mail->CharSet = 'UTF-8';
            $mail->send();

            Usuario::findOrFail($request->id_usuario)->update([
                'verif_email' => 1,
                'acceso' => 0,
                'usuario_password' => password_hash($password, PASSWORD_DEFAULT),
                'password_desencriptado' => $password,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            
            echo 'Nombre y Apellidos '.$get_id->usuario_nombres.' '.$get_id->usuario_apater.' '.
            $get_id->usuario_amater.'<br>Correo: '.$get_id->usuario_email;
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function edit_co($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.colaborador.modal_editar',compact('get_id'));
    }

    public function update_co(Request $request,$id)
    {
        $request->validate([
            'usuario_codigoe' => 'required'
        ],[
            'usuario_codigoe.required' => 'Debe ingresar usuario.'
        ]);

        $valida = Usuario::where('usuario_codigo',$request->usuario_codigoe)->where('id_usuario', '!=', $id)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->usuario_passworde){
                Usuario::findOrFail($id)->update([
                    'usuario_codigo' => $request->usuario_codigoe,
                    'usuario_password' => password_hash($request->usuario_passworde, PASSWORD_DEFAULT),
                    'password_desencriptado' => $request->usuario_passworde,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }else{
                Usuario::findOrFail($id)->update([
                    'usuario_codigo' => $request->usuario_codigoe,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }
    }
    
    public function download_co($id)
    {
        $get_id = Usuario::findOrFail($id);

        // URL del archivo
        $url = $get_id->foto;

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

    public function index_ce()
    {
        $list_gerencia = Gerencia::where('estado',1)->orderBy('nom_gerencia','ASC')->get();
        return view('rrhh.colaborador.cesado.index', compact('list_gerencia'));
    }

    public function list_ce(Request $request)
    {
        $list_cesado = Usuario::get_list_cesado(['id_gerencia'=>$request->id_gerencia]);
        return view('rrhh.colaborador.cesado.lista', compact('list_cesado'));
    }

    public function edit_ce($id)
    {
        $get_id = Usuario::findOrFail($id);
        return view('rrhh.colaborador.cesado.modal_editar',compact('get_id'));
    }
}
