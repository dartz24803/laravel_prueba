<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\DetalleExamenEntrenamiento;
use App\Models\DetalleExamenEntrenamientoTmp;
use App\Models\Entrenamiento;
use App\Models\ExamenEntrenamiento;
use App\Models\Notificacion;
use App\Models\Organigrama;
use App\Models\Pregunta;
use App\Models\Puesto;
use App\Models\SolicitudPuesto;
use App\Models\SubGerencia;
use App\Models\Suceso;
use App\Models\UsersHistoricoPuesto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class LineaCarreraController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario')->except([
            'update_estado_entrenamiento'
        ]);
    }

    public function update_estado_entrenamiento(){
        $list_entrenamiento = Entrenamiento::get_list_entrenamiento_terminado();

        foreach($list_entrenamiento as $list){
            Entrenamiento::findOrFail($list->id)->update([
                'estado_e' => 2,
                'fec_act' => now()
            ]);

            DB::connection('sqlsrv')->statement('EXEC usp_web_upt_rol_usuario_intranet ?,?,?,?,?,?,?,?', [
                $list->usuario_nombres,
                $list->usuario_apater,
                $list->usuario_amater,
                $list->num_doc,
                $list->perfil_infosap,
                $list->id_usuario,
                $list->id_puesto,
                $list->id_base
            ]);

            if($list->examen_asignado==0 && $list->examen_acceso==1){
                $examen = ExamenEntrenamiento::create([
                    'id_entrenamiento' => $list->id,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now()
                ]);
                Notificacion::create([
                    'id_usuario' => $list->id_usuario,
                    'solicitante' => $examen->id,
                    'id_tipo' => 46,
                    'leido' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'fec_act' => now()
                ]); 
            }

            echo $list->examen_asignado."_".$list->examen_acceso;
        }
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();      
        $list_subgerencia = SubGerencia::list_subgerencia(13);    
        return view('caja.linea_carrera.index',compact('list_notificacion','list_subgerencia'));
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

        //CORREO RRHH
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
            //$mail->addAddress('dpalomino@lanumero1.com.pe');

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

                DB::connection('sqlsrv')->statement('EXEC usp_web_upt_rol_usuario_intranet ?,?,?,?,?,?,?,?', [
                    $get_id->usuario_nombres,
                    $get_id->usuario_apater,
                    $get_id->usuario_amater,
                    $get_id->num_doc,
                    $get_id->perfil_infosap,
                    $get_id->id_usuario,
                    $get_id->id_puesto_aspirado,
                    $get_id->id_base
                ]);
            }
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }

        //CORREO BASE
        if($request->estado=="2"){
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

                $mail->addAddress('base'.$get_id->base_correo.'@lanumero1.com.pe');
                //$mail->addAddress('dpalomino@lanumero1.com.pe');

                $mail->isHTML(true);

                $mail->Subject = "Inicio de entrenamiento al puesto";
            
                $mail->Body =  '<FONT SIZE=3>
                                    Buen día, '.ucwords($get_id->nombre_completo).'.<br>
                                    Acaba de iniciar su proceso de entrenamiento para el puesto de 
                                    <b>'.ucfirst($get_id->nom_puesto_aspirado).'</b>.<br>
                                </FONT SIZE>';
            
                $mail->CharSet = 'UTF-8';
                $mail->send();
            }catch(Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
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

    public function evaluacion_en($id)
    {
        $get_id = Entrenamiento::get_list_entrenamiento(['id'=>$id]);
        $get_usuario = Usuario::select('centro_labores',
                    DB::raw('LOWER(CONCAT(SUBSTRING_INDEX(usuario_nombres," ",1)," ",usuario_apater)) AS nom_usuario'))
                    ->where('id_usuario',$get_id->id_usuario)->first();
        $list_evaluacion = ExamenEntrenamiento::select(DB::raw('DATE_FORMAT(fecha,"%d-%m-%Y") AS fecha'),
                            'nota',DB::raw('DATE_FORMAT(fecha_revision,"%d-%m-%Y %H:%i:%s") AS fecha_revision'),
                            'fec_reg AS orden',DB::raw('CASE WHEN nota>=14 THEN "Aprobado" 
                            WHEN nota<14 THEN "Desaprobado" ELSE "Pendiente de revisión" END AS nom_estado'))
                            ->where('id_entrenamiento',$id)->where('estado',1)->get();
        return view('caja.linea_carrera.entrenamiento.modal_evaluacion',compact('get_usuario','list_evaluacion'));
    }

    public function update_en($id)
    {
        $get_id = Entrenamiento::get_list_entrenamiento(['id'=>$id]);
        $examen = ExamenEntrenamiento::create([
            'id_entrenamiento' => $id,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        Notificacion::create([
            'id_usuario' => $get_id->id_usuario,
            'solicitante' => $examen->id,
            'id_tipo' => 46,
            'leido' => 0,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function evaluacion_ev($id)
    {
        $get_id = ExamenEntrenamiento::get_list_examen_entrenamiento(['id'=>$id]);
        return view('caja.linea_carrera.evaluacion.index', compact('get_id'));
    }

    public function iniciar_evaluacion_ev(Request $request, $id)
    {
        $get_id = ExamenEntrenamiento::get_list_examen_entrenamiento(['id'=>$id]);
        $list_pregunta = Pregunta::get_list_pregunta_evaluacion(['id_puesto'=>$get_id->id_puesto_aspirado]);
        foreach($list_pregunta as $list){
            DetalleExamenEntrenamientoTmp::create([
                'id_usuario' => session('usuario')->id_usuario,
                'id_pregunta' => $list->id
            ]);
        }
        ExamenEntrenamiento::findOrFail($id)->update([
            'fecha' => now(),
            'hora_inicio' => now(),
            'hora_fin' => date('H:i:s', strtotime('+ 45 minutes')),
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function examen_en(Request $request)
    {
        $get_id = ExamenEntrenamiento::get_list_examen_entrenamiento(['id'=>$request->id]);
        $hora = substr($get_id->hora_fin,0,2);
        $minuto = substr($get_id->hora_fin,3,2);
        $segundo = substr($get_id->hora_fin,6,2);
        $list_pregunta = DetalleExamenEntrenamientoTmp::get_list_detalle_examen_entrenamiento_tmp();
        return view('caja.linea_carrera.evaluacion.examen', compact('hora','minuto','segundo','list_pregunta'));
    }

    public function terminar_evaluacion_ev(Request $request, $id)
    {
        // Validar si ya se guardaron las respuestas de la evaluación
        $valida = DetalleExamenEntrenamiento::get_list_detalle_examen_entrenamiento(['id_examen'=>$id]);
        if(count($valida)==0){
            // Actualizar hora real de finalización de evaluación
            ExamenEntrenamiento::findOrFail($id)->update([
                'hora_fin_real' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            // Registrar las respuestas de cada pregunta de la evaluación
            $list_pregunta = DetalleExamenEntrenamientoTmp::get_list_detalle_examen_entrenamiento_tmp();
            foreach($list_pregunta as $list){
                DetalleExamenEntrenamiento::create([
                    'id_examen' => $id,
                    'id_pregunta' => $list->id_pregunta,
                    'respuesta' => $request->input('respuesta_'.$list->id_pregunta),
                ]);
            }
            // Eliminar las preguntas asignadas en la tabla temporal
            DetalleExamenEntrenamientoTmp::where('id_usuario', session('usuario')->id_usuario)->delete();
            // Desactivar notificación al colaborador
            $get_id = ExamenEntrenamiento::get_list_examen_entrenamiento(['id'=>$id]);
            Notificacion::findOrFail($get_id->id_notificacion)->update([
                'leido' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            // Enviar notificación a Kattia para la revisión
            Notificacion::create([
                'id_usuario' => 172,
                'solicitante' => $get_id->id_usuario,
                'id_tipo' => 47,
                'leido' => 0,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function index_re()
    {
        return view('caja.linea_carrera.revision_evaluacion.index');
    }

    public function list_re()
    {
        $list_examen_entrenamiento = ExamenEntrenamiento::get_list_examen_entrenamiento();
        return view('caja.linea_carrera.revision_evaluacion.lista', compact('list_examen_entrenamiento'));
    }

    public function edit_re($id)
    {
        $get_id = ExamenEntrenamiento::findOrFail($id);
        $list_detalle = DetalleExamenEntrenamiento::get_list_detalle_examen_entrenamiento(['id_examen' => $id]);
        return view('caja.linea_carrera.revision_evaluacion.modal_editar', compact('get_id','list_detalle'));
    }

    public function update_re(Request $request, $id)
    {
        $request->validate([
            'notae' => 'required'
        ],[
            'notae.required' => 'Debe ingresar nota.'
        ]);

        $get_id = ExamenEntrenamiento::get_list_examen_entrenamiento(['id' => $id]);
        $get_id = Entrenamiento::get_list_entrenamiento(['id' => $get_id->id_entrenamiento]);

        if($request->notae>=14){
            $texto = "aprobado";
        }else{
            $texto = "desaprobado";
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

            $mail->addAddress('rrhh@lanumero1.com.pe');
            $mail->addAddress('base'.$get_id->base.'@lanumero1.com.pe');
            //$mail->addAddress('dpalomino@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "Evaluación de entrenamiento al puesto";
        
            $mail->Body =  '<FONT SIZE=3>
                                Buen día, <br>
                                Mediante la presente evaluación en Intranet, el siguiente colaborador ha 
                                sido '.$texto.' según los requisitos del puesto a entrenar.<br>
                                <b>Datos del colaborador:</b>
                                <ul>
                                    <li>Nombres Completos: '.ucwords($get_id->nombre_completo).'</li>
                                    <li>Puesto Actual: '.ucfirst($get_id->nom_puesto_actual).'</li>
                                    <li>Puesto Aspirado: '.ucfirst($get_id->nom_puesto_aspirado).'</li>
                                    <li>Fecha de evaluación: '.date('d-m-Y').'</li>
                                </ul>
                            </FONT SIZE>';
        
            $mail->CharSet = 'UTF-8';
            $mail->send();

            if($get_id->estado_e==1){
                Entrenamiento::findOrFail($get_id->id)->update([
                    'fecha_fin' => now(),
                    'estado_e' => 2,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
            ExamenEntrenamiento::findOrFail($id)->update([
                'nota' => $request->notae,
                'fecha_revision' => now(),
                'usuario_revision' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            if($request->notae>=14){
                $get_puesto = Puesto::findOrFail($get_id->id_puesto_aspirado);

                UsersHistoricoPuesto::create([
                    'id_usuario' => $get_id->id_usuario,
                    'id_direccion' => $get_puesto->id_direccion,
                    'id_gerencia' => $get_puesto->id_gerencia,
                    'id_sub_gerencia' => $get_puesto->id_departamento,
                    'id_area' => $get_puesto->id_area,
                    'id_puesto' => $get_puesto->id_puesto,
                    'fec_inicio' => now(),
                    'id_tipo_cambio' => 1,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                Usuario::findOrFail($get_id->id_usuario)->update([
                    'id_puesto' => $get_puesto->id_puesto,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
                Notificacion::create([
                    'id_usuario' => $get_id->id_usuario,
                    'solicitante' => $get_id->id_puesto_aspirado,
                    'id_tipo' => 45,
                    'leido' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);

                $get_org = Organigrama::where('id_usuario',$get_id->id_usuario)->first();
                if($get_org){
                    Organigrama::findOrFail($get_org->id)->update([
                        'id_usuario' => 0,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }

                $get_org = Organigrama::where('id_puesto',$get_id->id_puesto_aspirado)->where('id_usuario',0)
                        ->first();
                if($get_org){
                    Organigrama::findOrFail($get_org->id)->update([
                        'id_usuario' => $get_id->id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }else{
                    Organigrama::create([
                        'id_puesto' => $get_id->id_puesto_aspirado,
                        'id_centro_labor' => $get_id->id_centro_labor,
                        'id_usuario' => $get_id->id_usuario,
                        'fecha' => now(),
                        'usuario' => session('usuario')->id_usuario
                    ]);
                }

                DB::connection('sqlsrv')->statement('EXEC usp_web_upt_rol_usuario_intranet ?,?,?,?,?,?,?,?', [
                    $get_id->usuario_nombres,
                    $get_id->usuario_apater,
                    $get_id->usuario_amater,
                    $get_id->num_doc,
                    $get_id->perfil_infosap,
                    $get_id->id_usuario,
                    $get_id->id_puesto_aspirado,
                    $get_id->id_base
                ]);
            }else{
                $valida = ExamenEntrenamiento::where('id_entrenamiento',$get_id->id)->where('estado',1)
                        ->count();
                        
                if($valida<2){
                    if($request->notae>10){
                        $dias = 5;
                    }else{
                        $dias = 10;
                    }
                    Entrenamiento::findOrFail($get_id->id)->update([
                        'fecha_fin' => date('Y-m-d', strtotime('+'.$dias.' days')),
                        'estado_e' => 1,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }
            }
        }catch(Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function show_re($id)
    {
        $get_id = ExamenEntrenamiento::findOrFail($id);
        $list_detalle = DetalleExamenEntrenamiento::get_list_detalle_examen_entrenamiento(['id_examen' => $id]);
        return view('caja.linea_carrera.revision_evaluacion.modal_detalle', compact('get_id','list_detalle'));
    }
}
