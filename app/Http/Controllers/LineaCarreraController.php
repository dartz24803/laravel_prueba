<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Entrenamiento;
use App\Models\SolicitudPuesto;
use App\Models\Suceso;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class LineaCarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        return view('caja.linea_carrera.index');
    }

    public function index_so()
    {
        $list_base = Base::get_list_bases_tienda();
        return view('caja.linea_carrera.solicitud_puesto.index', compact('list_base'));
    }

    public function list_so(Request $request)
    {
        $list_solicitud_puesto = SolicitudPuesto::get_list_solicitud_puesto(['base'=>$request->cod_base]);
        return view('caja.linea_carrera.solicitud_puesto.lista', compact('list_solicitud_puesto'));
    }

    public function obs_so($id)
    {
        $get_id = Usuario::select('centro_labores',
                    DB::raw('LOWER(CONCAT(SUBSTRING_INDEX(usuario_nombres," ",1)," ",usuario_apater)) AS nom_usuario'))
                    ->where('id_usuario',$id)->first();
        $list_observacion = Suceso::from('suceso AS su')
                            ->select('te.nom_tipo_error','er.nom_error','su.monto','su.nom_suceso')
                            ->join('tipo_error AS te','te.id_tipo_error','=','su.id_tipo_error')
                            ->join('error AS er','er.id_error','=','su.id_error')
                            ->where('su.user_suceso',$id)->where('su.estado',1)->get();
        return view('caja.linea_carrera.solicitud_puesto.modal_obs',compact('get_id','list_observacion'));
    }

    public function edit_so($id)
    {
        return view('caja.linea_carrera.solicitud_puesto.modal_editar',compact('id'));
    }

    public function update_so(Request $request, $id)
    {
        if($request->estado=="2"){
            $request->validate([
                'diase' => 'required|gt:0'
            ],[
                'diase.required' => 'Debe ingresar días.',
                'diase.gt' => 'Debe ingresar días mayor a 0.'
            ]);
        }

        if($request->estado=="2"){
            $texto_1 = "Aprobación";
            $texto_2 = "aprobado";
        }else{
            $texto_1 = "Rechazo";
            $texto_2 = "rechazado";
        }

        $get_id = SolicitudPuesto::get_list_solicitud_puesto(['id'=>$id]);

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

            $mail->addAddress('rrhh@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = $texto_1." de entrenamiento al puesto";
        
            $mail->Body =  '<FONT SIZE=3>
                                Buen día, <br>
                                El área de caja ha <b>'.$texto_2.'</b> la solicitud de entrenamiento para el 
                                siguiente puesto:
                                <ul>
                                    <li>Colaborador: <b>'.ucwords($get_id->nombre_completo).'</b></li>
                                    <li>Base: <b>'.$get_id->base.'</b></li>
                                    <li>Puesto Actual: <b>'.ucfirst($get_id->nom_puesto_actual).'</b></li>
                                    <li>Puesto Aspirado: <b>'.ucfirst($get_id->nom_puesto_aspirado).'</b></li>
                                    <li>Observación: <b>'.$get_id->observacion.'</b></li>
                                </ul>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();

            SolicitudPuesto::findOrFail($id)->update([
                'estado_s' => $request->estado,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if($request->estado=="2"){
                Entrenamiento::create([
                    'id_solicitud_puesto' => $id,
                    'fecha_inicio' => now(),
                    'fecha_fin' => date('Y-m-d', strtotime('+'.$request->diase.' days')),
                    'estado_e' => 1,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                DB::connection('sqlsrv')->select('EXEC usp_web_upt_rol_usuario_intranet ?,?,?,?,?,?,?,?', [
                    $get_id->usuario_nombres,
                    $get_id->usuario_apater,
                    $get_id->usuario_amater,
                    $get_id->num_doc,
                    $get_id->perfil_infosap,
                    $get_id->id_usuario,
                    $get_id->id_puesto,
                    $get_id->id_base
                ]);
            }
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function index_en()
    {
        return view('caja.linea_carrera.entrenamiento.index');
    }

    public function list_en(Request $request)
    {
        $list_entrenamiento = Entrenamiento::get_list_entrenamiento();
        return view('caja.linea_carrera.entrenamiento.lista', compact('list_entrenamiento'));
    }
}
