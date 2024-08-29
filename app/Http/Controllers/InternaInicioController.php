<?php

namespace App\Http\Controllers;

use App\Models\Amonestacion;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class InternaInicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('interna.index');

        /*$list_usuario = Amonestacion::select('users.emailp')->where('amonestacion.fecha','2024-08-28')
                        ->join('users','users.id_usuario','=','amonestacion.id_colaborador')->get();

        foreach($list_usuario as $list){
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
    
                //$mail->addAddress($get_id->usuario_email);
                $mail->addAddress($list->emailp);
    
                $mail->isHTML(true);
    
                $mail->Subject = "Amonestación por incumplimiento de funciones";
            
                $mail->Body =  "<FONT SIZE=3>
                                    Como es de su conocimiento, es responsabilidad de cada colaborador mantener 
                                    sus datos actualizados en nuestra Intranet.
                                    <br>
                                    En vista del incumplimiento de 
                                    esta tarea se ha procedido a emitir este llamado de atención.
                                    <br>
                                    Se le exhorta a regularizar esta solicitud en un plazo máximo de 24 horas de 
                                    emitido este documento.
                                    <br>
                                    De no hacerlo, se aplicará la suspensión de un (01) día sin goce de haber 
                                    el cual le será comunicado.
                                </FONT SIZE>";
                $mail->CharSet = 'UTF-8';

                $mail->send();
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }*/
    }
}
