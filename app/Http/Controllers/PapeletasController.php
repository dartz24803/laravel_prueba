<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Destino;
use App\Models\HorarioDia;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\PermisoPapeletasSalida;
use App\Models\SolicitudesUser;
use App\Models\SubGerencia;
use App\Models\Tramite;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PapeletasController extends Controller
{

    protected $input;
    protected $Model_Solicitudes;
    protected $Model_Permiso;
    protected $Model_Perfil;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario')->except(['Aprobar_Papeleta_Salida']);
        $this->input = $request;
        $this->Model_Solicitudes = new SolicitudesUser();
        $this->Model_Permiso = new PermisoPapeletasSalida();
        $this->Model_Perfil = new Model_Perfil();
    }

    public function Lista_Papeletas_Salida_seguridad(){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
                return view('rrhh.Papeletas_Salida.index',$dato);
    }

    public function Buscar_Papeleta_Registro(){
        $dato['list_base'] = Base::get_list_base_only();
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1);
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());

        if(session('usuario')->id_puesto!=23 || session('usuario')->id_puesto!=26 || session('usuario')->id_puesto!=128 ||
        session('usuario')->id_nivel!=1 || session('usuario')->id_nivel!=21 || session('usuario')->id_nivel!=19 ||
        session('usuario')->centro_labores!=="CD" || session('usuario')->centro_labores!=="OFC" || session('usuario')->centro_labores!=="AMT"){
            $dato['list_colaborador_control'] = Usuario::where('centro_labores', session('usuario')->centro_labores)
                                            ->where('estado', 1)
                                            ->get();
        }
        return view('papeletas.index', $dato);
    }

    public function Buscar_Estado_Solicitud_Papeletas_Salida_Usuario(){
            $estado_solicitud = $this->input->post("estado_solicitud");

            $this->Model_Solicitudes->verificacion_papeletas();

            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida($estado_solicitud);

            return view('papeletas.lista_colaborador', $dato);
    }

    public function Modal_Papeletas_Salida($parametro){
            $dato['parametro']=$parametro;
            $centro_labores = session('usuario')->centro_labores;
            $lista_puesto_gest_array = $this->Model_Permiso->permiso_pps_puestos_gest_dinamico();
            $separado_por_comas_puestos = implode(",", array_column($lista_puesto_gest_array, 'id_puesto_permitido'));

            if($dato['parametro']==1){
                $dato['list_vendedor'] = Usuario::get_list_vendedor($centro_labores, $separado_por_comas_puestos);
            }

            return view('papeletas.modal_registrar', $dato);
    }

    public function Cambiar_Motivo(){
            $dato['id_motivo'] = $this->input->post("id_motivo");
            $dato['list_destino'] = Destino::where('id_motivo', $dato['id_motivo'])
                                ->get();
            return view('papeletas.destino', $dato);
    }

    public function Traer_Tramite(){
            $id_destino = $this->input->post("id_destino");
            $dato['list_tramite'] = Tramite::where('id_destino', $id_destino)
                                ->get();
            return view('papeletas.tramite', $dato);
    }

    public function Buscar_Base_Papeletas_Seguridad(){
            $this->Model_Solicitudes->verificacion_papeletas();

            $id_puesto = session('usuario')->id_puesto;
            $estado_solicitud = $this->input->post("estado_solicitud");
            $fecha_revision = $this->input->post("fecha_revision");
            $fecha_revision_fin = $this->input->post("fecha_revision_fin");
            $num_doc = $this->input->post("num_doc");
            $id_nivel = session('usuario')->id_nivel;
            $centro_labores = session('usuario')->centro_labores;

            if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){
                $base=$this->input->post("base");
            }else{
                $base = session('usuario')->centro_labores;
            }
            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc);

            return view('rrhh.Papeletas_Salida_seguridad.lista_colaborador', $dato);
    }

    public function Insert_or_Update_Papeletas_Salida() {
        $this->input->validate([
            'id_motivo' => 'required',
            'fec_solicitud' => 'required',
            'destino' => 'not_in:0',
            'tramite' => 'not_in:0',
        ],[
            'id_motivo.required' => 'Debe seleccionar motivo.',
            'fec_solicitud.required' => 'Debe ingresar fecha de solictud.',
            'destino.not_in' => 'Debe seleccionar destino',
            'tramite.not_in' => 'Debe seleccionar tramite',
        ]);

            $id_solicitudes_user= $this->input->post("id_solicitudes_user");
            $dato['parametro']= $this->input->post("parametro");
            $colaborador= $this->input->post("colaborador_p");

            if($id_solicitudes_user == null && $dato['parametro']!=1){
                //USUARIOS PARA NOTIFICACION
                $get_gerente = Usuario::select('users.id_usuario', 'users.usuario_nombres', 'users.usuario_apater', 'users.usuario_amater', 'users.emailp'/*, 'users.id_gerencia'*/, 'puesto.nom_puesto')
                        ->leftJoin('puesto', 'puesto.id_puesto', '=', 'users.id_puesto')
                        ->where('users.estado', 1)
                        //->where('users.id_gerencia', session('usuario')->id_gerencia)
                        ->where('puesto.nom_puesto', 'LIKE', 'GERENTE %')
                        ->get()
                        ->toArray();
                $dato['id_responsable']=$get_gerente[0]['id_usuario'];
                Notificacion::create([
                    'id_usuario' => $dato['id_responsable'],
                    'solicitante' => session('usuario')->id_usuario,
                    'id_tipo' => 7,
                    'leido' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);

                $get_puestos = $this->Model_Permiso::where('id_puesto_permitido')
                            ->get();
                $i=0;
                while($i<count($get_puestos)){
                    $dato['id_puesto_jefe']=$get_puestos[$i]['id_puesto_jefe'];
                    $get_usuarios = Usuario::where('id_puesto', $dato['id_puesto_jefe'])
                                ->get();
                    $j=0;
                    while($j<count($get_usuarios)){
                        $dato['id_responsable']=$get_usuarios[$j]['id_usuario'];
                        Notificacion::create([
                            'id_usuario' => $dato['id_responsable'],
                            'solicitante' => session('usuario')->id_usuario,
                            'id_tipo' => 7,
                            'leido' => 0,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                        ]);
                        $j++;
                    }
                    $i++;
                }
            }

            if ($id_solicitudes_user == null){
                $dato['id_motivo']= $this->input->post("id_motivo");
                $dato['destino']= $this->input->post("destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_destino']= $this->input->post("especificacion_destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_tramite']= $this->input->post("especificacion_tramite");
                $dato['hora_retorno']= $this->input->post("hora_retorno");
                $dato['hora_salida']= $this->input->post("hora_salida");
                $dato['fec_solicitud']= $this->input->post("fec_solicitud");
                $dato['sin_ingreso'] = $this->input->post("sin_ingreso") ?: 0;
                $dato['sin_retorno'] = $this->input->post("sin_retorno") ?: 0;
                $dato['otros']= $this->input->post("otros");

                if($dato['parametro']==0){
                    $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
                        ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
                        ->count();

                    $aniof=date('Y');
                    if($totalt<9){
                        $codigofinal='PP'.$aniof."0000".($totalt+1);
                    }
                    if($totalt>8 && $totalt<99){
                        $codigofinal='PP'.$aniof."000".($totalt+1);
                    }
                    if($totalt>98 && $totalt<999){
                        $codigofinal='PP'.$aniof."00".($totalt+1);
                    }
                    if($totalt>998 && $totalt<9999){
                        $codigofinal='PP'.$aniof."0".($totalt+1);
                    }
                    if($totalt>9998){
                        $codigofinal='PP'.$aniof.($totalt+1);
                    }
                    $dato['cod_solicitud']=$codigofinal;

                    $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                    $validar_insert = $this->Model_Solicitudes->validar_insert_papeletas_salida($dato);

                    if(count($validar_insert)>=$get_tramite[0]['cantidad_uso']){
                        echo "error";
                    }else{
                        $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                    }
                }else{
                    $ico= count($colaborador);
                    $co=0;

                    do{
                        $dato['colaborador']=$colaborador[$co];

                        $traer_datos = $this->Model_Perfil->get_id_usuario($dato['colaborador']);

                        $dato['centro_labores'] = $traer_datos[0]['centro_labores'];

                        $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
                            ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
                            ->count();
                        $aniof=date('Y');
                        if($totalt<9){
                            $codigofinal='PP'.$aniof."0000".($totalt+1);
                        }
                        if($totalt>8 && $totalt<99){
                            $codigofinal='PP'.$aniof."000".($totalt+1);
                        }
                        if($totalt>98 && $totalt<999){
                            $codigofinal='PP'.$aniof."00".($totalt+1);
                        }
                        if($totalt>998 && $totalt<9999){
                            $codigofinal='PP'.$aniof."0".($totalt+1);
                        }
                        if($totalt>9998){
                            $codigofinal='PP'.$aniof.($totalt+1);
                        }
                        $dato['cod_solicitud']=$codigofinal;

                        $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                        $validar_insert = $this->Model_Solicitudes->validar_insert_papeletas_salida($dato);

                        if(count($validar_insert)>=$get_tramite[0]['cantidad_uso']){
                            echo "error";
                        }else{
                            $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                        }

                        $co=$co + 1;
                    }while($co < $ico);
                }
            }else{
                $get_id = $this->Model_Solicitudes->get_id_papeletas_salida($id_solicitudes_user);
                $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
                $dato['id_motivo']= $this->input->post("id_motivo");
                $dato['destino']= $this->input->post("destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_destino']= $this->input->post("especificacion_destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_tramite']= $this->input->post("especificacion_tramite");
                $dato['hora_salida']= $this->input->post("hora_salida");
                $dato['hora_retorno']= $this->input->post("hora_retorno");
                $dato['fec_solicitud']= $this->input->post("fec_solicitud");
                $dato['sin_ingreso']= $this->input->post("sin_ingreso");
                $dato['sin_retorno']= $this->input->post("sin_retorno");
                $dato['otros']= $this->input->post("otros");

                if($dato['id_motivo']==3){
                    $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                }else{
                    $dato['id_usuario'] = $get_id[0]['id_usuario'];
                    $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                    $validar_update = SolicitudesUser::where('id_solicitudes_user', '!=', $dato['id_solicitudes_user'])
                                ->where('id_usuario', $dato['id_usuario'])
                                ->where('fec_solicitud', $dato['fec_solicitud'])
                                ->where('tramite', $dato['tramite'])
                                ->where('estado', 1)
                                ->get();

                    if(count($validar_update)>=$get_tramite[0]['cantidad_uso']){
                        echo "error";
                    }else{
                        $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                    }
                }
            }
    }

    public function Buscar_Papeleta_Aprobacion(){
        if(session('usuario')->id_puesto != 314){
            $dato['list_colaborador'] = Usuario::get_list_colaboradort(null,1);
        }else{
            $dato['list_colaborador'] = Usuario::get_list_colaboradorct(1);
        }
        return view('rrhh.Papeletas_Salida.Aprobacion.index', $dato);
    }

    public function Buscar_Papeletas_Salida_Aprobacion(){
        // PAPELETAS ESTADOS
        // 1=PROCESO;
        // 2=APROBADO;
        // 3=DENEGADO;
        // 4=EN PROCESO-APROBACION GERENCIA (AL REGISTRAR NUEVA PAPELETA PASA AQUI));
        // 5=EM PROCESO-APROBACION RRHH;
            $estado_solicitud = $this->input->post("estado_solicitud");
            $fecha_revision = $this->input->post("fecha_revision");
            $fecha_revision_fin = $this->input->post("fecha_revision_fin");
            $lista_puesto_gest_array = $this->Model_Permiso->permiso_pps_puestos_gest_dinamico();
            $separado_por_comas_puestos = implode(",", array_column($lista_puesto_gest_array, 'id_puesto_permitido'));

            $this->Model_Solicitudes->verificacion_papeletas();

            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida_gestion($estado_solicitud,$fecha_revision, $fecha_revision_fin, $separado_por_comas_puestos);
            $dato['acciones']=1;

            return view('rrhh.Papeletas_Salida.Aprobacion.lista_colaborador', $dato);
    }

    public function Aprobado_solicitud_papeletas_1(){
            $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
            $obt=$this->Model_Solicitudes->get_id_papeletas_salida($dato['id_solicitudes_user']);
            $dato['sin_ingreso']=$obt[0]['sin_ingreso'];
            $dato['sin_retorno']=$obt[0]['sin_retorno'];
            $dato['id_modalidad_laboral']=$obt[0]['id_modalidad_laboral'];
            $dato['estado_solicitud'] = $obt[0]['estado_solicitud'];
            $dato['id_horario'] = $obt[0]['id_horario'];
            $dato['num_doc'] = $obt[0]['num_doc'];
            $dato['id_motivo'] = $obt[0]['id_motivo'];

            $dato['dia']=date('N');
            $dato['horario'] = HorarioDia::where('id_horario', $dato['id_horario'])
                            ->where('dia', $dato['dia'])
                            ->where('estado', 1)
                            ->get();
            $this->Model_Solicitudes->aprobado_papeletas_salida($dato);

            if($dato['estado_solicitud']==4){
                $list_correos = Usuario::where('estado', 1)
                            ->whereIn('id_puesto', [19, 21, 279])
                            ->get();

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
                    $mail->setFrom('intranet@lanumero1.com.pe','PAPELETA DE SALIDA EN PROCESO DE APROBACIÓN');

                    //$mail->addAddress('pcardenas@lanumero1.com.pe');
                    foreach($list_correos as $list){
                        $mail->addAddress($list['emailp']);
                    }

                    $mail->isHTML(true);// Set email format to HTML

                    $mail->Subject = $obt[0]['cod_solicitud']." - ".$obt[0]['tramite'];

                    $mail->Body = "<h1><span style='color:#70BADB'>PAPELETA DE SALIDA EN PROCESO DE APROBACIÓN<span></h1>
                                    <p>Hola el colaborador ".$obt[0]['nombres']." hizo su papeleta de salida y se necesita su aprobación.</p>
                                    Destino: ".$obt[0]['destino'].".<br>
                                    Especificación Destino: ".$obt[0]['especificacion_destino'].".<br>
                                    Trámite: ".$obt[0]['tramite'].".<br>
                                    Especificación Trámite: ".$obt[0]['especificacion_tramite'].".<br><br>
                                    <a href='" . url("/Papeletas/Aprobar_Papeleta_Salida/{$obt[0]['id_solicitudes_user']}") . "'
                                    style='display: inline-block;text-decoration:none;position:relative;color:#fff;background-color: #00CC00;
                                    font-size:15px;padding: 5px 0;text-align: center;border: none;margin-right: 20px;outline: 0;width: 10%;'>Aprobar</a>";
                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
    }

    public function Aprobar_Papeleta_Salida($id_solicitudes_user){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            $dato['get_id'] = $this->Model_Solicitudes->get_id_papeletas_salida($id_solicitudes_user);
            return view('rrhh.Papeletas_Salida.Aprobacion.index_rrhh',$dato);
    }

    public function Anular_solicitud_papeletas_1(){
            $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
            $obt=$this->Model_Solicitudes->get_id_papeletas_salida($dato['id_solicitudes_user']);
            $dato['sin_ingreso']=$obt[0]['sin_ingreso'];
            $this->Model_Solicitudes->anulado_papeletas_salida($dato);
    }

    public function Buscar_Papeleta_Control(){
        $dato['list_colaborador_control'] = Usuario::where('centro_labores', session('usuario')->centro_labores)
                                    ->where('estado', 1)
                                    ->get();
        $dato['list_base'] = Base::get_list_base_only();
        return view('rrhh.Papeletas_Salida.Control.index', $dato);
    }

    public function Buscar_Base_Papeletas_Seguiridad(){
            $this->Model_Solicitudes->verificacion_papeletas();

            $id_puesto = session('usuario')->id_puesto;
            $estado_solicitud = $this->input->post("estado_solicitud");
            $fecha_revision = $this->input->post("fecha_revision");
            $fecha_revision_fin = $this->input->post("fecha_revision_fin");
            $num_doc = $this->input->post("num_doc");
            $id_nivel=session('usuario')->id_nivel;
            $centro_labores=session('usuario')->centro_labores;

            if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){
                $base=$this->input->post("base");
            }else{
                $base=session('usuario')->centro_labores;
            }
            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc);

            return view('rrhh.Papeletas_Salida.Control.lista_colaborador', $dato);
    }

    public function Busca_Colaborador_Control(){
            $cod_base = $this->input->post("base");
            $dato['list_colaborador'] = Usuario::get_list_usuarios_x_base($cod_base);

            return view('rrhh.Papeletas_Salida.Control.cmb_colaborador_control', $dato);
    }

    public function Excel_Estado_Solicitud_Papeletas_Salida_Seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc){
        $data = $this->Model_Solicitudes->get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc);

		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Lista_Estado_Solicitud_Salida');

        $sheet->setCellValue('A1', 'Base');
        $sheet->setCellValue('B1', 'Colaborador');
        $sheet->setCellValue('C1', 'Motivo');
		$sheet->setCellValue('D1', 'Destino');
        $sheet->setCellValue('E1', 'Especificación');
		$sheet->setCellValue('F1', 'Trámite');
        $sheet->setCellValue('G1', 'Especificación');
        $sheet->setCellValue('H1', 'Fecha');
        $sheet->setCellValue('I1', 'H. Salida');
        $sheet->setCellValue('J1', 'H. Retorno');
        $sheet->setCellValue('K1', 'H. Real Salida');
        $sheet->setCellValue('L1', 'H. Real Retorno');
        $sheet->setCellValue('M1', 'Estado');
        $sheet->setCellValue('N1', 'Aprobado Por');
        $sheet->setCellValue('O1', 'Hora');

        $spreadsheet->getActiveSheet()->setAutoFilter('A1:O1');
        $sheet->getStyle('A1:O1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        //Le aplicamos color a la cabecera
        $spreadsheet->getActiveSheet()->getStyle("A1:O1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C8C8C8');
        //border
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        //fONT SIZE
		$sheet->getStyle("A1:O1")->getFont()->setSize(12);

        //Font BOLD
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);

		$start = 1;
		foreach($data as $d){
            $start = $start+1;

            $sheet->getStyle("A{$start}:O{$start}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


            //border
            $sheet->getStyle("A{$start}:O{$start}")->applyFromArray($styleThinBlackBorderOutline);

            //Ajustar celda

            $sheet->getStyle("A{$start}:O{$start}")->getAlignment()->setWrapText(true);

            $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['centro_labores']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $d['usuario_apater']." ".$d['usuario_amater']." ".$d['usuario_nombres']);
            if( $d['id_motivo']==1){
                $spreadsheet->getActiveSheet()->setCellValue("C{$start}", "Laboral" );
            }else if ($d['id_motivo']==2){
                $spreadsheet->getActiveSheet()->setCellValue("C{$start}", "Personal" );
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['motivo'] );
            }

            $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['destino']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['especificacion_destino']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['tramite']);
            $spreadsheet->getActiveSheet()->setCellValue("G{$start}", $d['especificacion_tramite']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$start}", date_format(date_create($d['fec_solicitud']), "d/m/Y"));

            if($d['sin_ingreso'] == 1 ){
                $spreadsheet->getActiveSheet()->setCellValue("I{$start}", "Sin Ingreso");
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("I{$start}", $d['hora_salida']);
            }

            if($d['sin_retorno'] == 1 ){
                $spreadsheet->getActiveSheet()->setCellValue("J{$start}", "Sin Retorno");
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("J{$start}", $d['hora_retorno']);
            }

            if($d['sin_ingreso'] == 1 ){
                $spreadsheet->getActiveSheet()->setCellValue("K{$start}", "Sin Ingreso");
            }else{
                if($d['horar_salida']!="00:00:00"){
                    $spreadsheet->getActiveSheet()->setCellValue("K{$start}", $d['horar_salida']);
                }

            }

            if($d['sin_retorno'] == 1 ){
                $spreadsheet->getActiveSheet()->setCellValue("L{$start}", "Sin Retorno");
            }else{
                if($d['horar_retorno']!="00:00:00"){
                    $spreadsheet->getActiveSheet()->setCellValue("L{$start}", $d['horar_retorno']);
                }

            }

            if($d['estado_solicitud']=='1'){

                $spreadsheet->getActiveSheet()->setCellValue("M{$start}", "En Proceso");
            }else if ($d['estado_solicitud']=='2'){

                $spreadsheet->getActiveSheet()->setCellValue("M{$start}", "Aprobado");
            }else if ($d['estado_solicitud']=='3'){
                $spreadsheet->getActiveSheet()->setCellValue("M{$start}", "Denegado");
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("M{$start}", "Error");
            }

            $spreadsheet->getActiveSheet()->setCellValue("N{$start}", $d['apater_apro']." ".$d['amater_apro']." ".$d['nom_apro']);
            $spreadsheet->getActiveSheet()->setCellValue("O{$start}", date_format(date_create($d['fec_apro']), "H:i:s"));
		}

		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getColumnDimension('C')->setWidth(14);
		$sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(40);
        $sheet->getColumnDimension('O')->setWidth(15);

        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Lista_Estado_Solicitud_Salida_'.$curdate;
		if (ob_get_contents()) ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Update_Papeletas_Salida_seguridad_Retorno() {
        $this->Model_Solicitudes->where('id_solicitudes_user', $this->input->post("id_solicitudes_user"))
            ->update([
                'horar_retorno' => DB::raw('CURTIME()'),
                'user_horar_entrada' => session('usuario')->id_usuario
            ]);
    }

    public function Cambiar_solicitud_papeletas_seguridad() {
        $this->Model_Solicitudes->where('id_solicitudes_user', $this->input->post("id_solicitudes_user"))
            ->update([
                'sin_retorno' => 1,
                'user_horar_entrada' => session('usuario')->id_usuario
            ]);
    }

    public function Update_Papeletas_Salida_seguridad_Salida() {
            $this->Model_Solicitudes->verificacion_papeletas();

            $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");

            $get_id= $this->Model_Solicitudes::where('id_solicitudes_user', $dato['id_solicitudes_user'])
                ->get();
            $motivo=$get_id[0]['id_motivo'];
            if($get_id[0]['estado_solicitud']==3){
                echo "error";
            }else{
                if($motivo==1){
                    $this->Model_Solicitudes->where('id_solicitudes_user', $this->input->post("id_solicitudes_user"))
                        ->update([
                            'horar_salida' => DB::raw('CURTIME()'),
                            'user_horar_entrada' => session('usuario')->id_usuario
                        ]);
                }
                else{
                    $valida = $this->Model_Solicitudes::where('id_solicitudes_user', $dato['id_solicitudes_user'])
                        ->where('hora_salida', '<', DB::raw('TIME(NOW())'))
                        ->exists();

                    if($valida>0){
                        $this->Model_Solicitudes->where('id_solicitudes_user', $this->input->post("id_solicitudes_user"))
                            ->update([
                                'horar_salida' => DB::raw('CURTIME()'),
                                'user_horar_entrada' => session('usuario')->id_usuario
                            ]);
                    }else{
                        echo "falta";
                    }
                }
            }
    }

    public function Papeletas_Apps(){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        $dato['list_base'] = Base::get_list_base_only();
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1);
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());

        if(session('usuario')->id_puesto!=23 || session('usuario')->id_puesto!=26 || session('usuario')->id_puesto!=128 ||
        session('usuario')->id_nivel!=1 || session('usuario')->id_nivel!=21 || session('usuario')->id_nivel!=19 ||
        session('usuario')->centro_labores!=="CD" || session('usuario')->centro_labores!=="OFC" || session('usuario')->centro_labores!=="AMT"){
            $dato['list_colaborador_control'] = Usuario::where('centro_labores', session('usuario')->centro_labores)
                                            ->where('estado', 1)
                                            ->get();
        }
        return view('papeletas.Registro.index', $dato);
    }

    public function Delete_Papeletas_Salida(){
            $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");

        $this->Model_Solicitudes::where('id_solicitudes_user', $dato['id_solicitudes_user'])
        ->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario,
        ]);
    }
}
