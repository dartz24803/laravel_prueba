<?php

namespace App\Http\Controllers;

use App\Models\AsignacionJefatura;
use App\Models\Base;
use App\Models\Config;
use App\Models\ExamenEntrenamiento;
use App\Models\GradoInstruccion;
use App\Models\Horario;
use App\Models\HorarioDia;
use App\Models\Model_Perfil;
use App\Models\Puesto;
use App\Models\Notificacion;
use App\Models\SolicitudPuesto;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MiEquipoController extends Controller
{
    protected $input;
    protected $Model_Asignacion;
    // protected $Model_Permiso;
    protected $Model_Perfil;

    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Asignacion = new AsignacionJefatura();
        // $this->Model_Permiso = new PermisoPapeletasSalida();
        $this->Model_Perfil = new Model_Perfil();
    }
    public function ListaMiequipo()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.Mi_equipo.index', compact('list_subgerencia', 'list_notificacion'));
    }

    public function Cargar_Mi_Equipo()
    {
        $dato['lista_bases'] = Base::select('cod_base')
            ->where('estado', '1')
            ->distinct()
            ->orderBy('cod_base', 'asc')
            ->get();
        return view('rrhh.Mi_equipo.mi_equipo', $dato);
    }

    public function Cargar_Bases_Equipo($busq_base)
    {
        $id_centro_labor = session('usuario')->id_centro_labor;
        $id_puesto = session('usuario')->id_puesto;

        $dato['list_ajefatura'] = $this->Model_Asignacion->get_list_ajefatura_puesto($id_puesto);

        $result = "";

        foreach ($dato['list_ajefatura'] as $char) {
            $result .= $char['id_puesto_permitido'] . ",";
        }

        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(" . $cadena . ")";

        $data['base'] = $busq_base;
        $dato['colaborador_porcentaje'] = Usuario::colaborador_porcentaje(0, $id_centro_labor, $dato, $data);


        return view('rrhh.Mi_equipo.lista_equipo', $dato);
    }

    public function Excel_Mi_Equipo($base)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Mi Equipo');
        $sheet->setCellValue('A1', 'ESTADO');
        $sheet->setCellValue('B1', 'FECHA DE INGRESO');
        $sheet->setCellValue('C1', 'CENTRO DE LABORES');
        $sheet->setCellValue('D1', 'APELLIDO PATERNO');
        $sheet->setCellValue('E1', 'APELLIDO MATERNO');
        $sheet->setCellValue('F1', 'NOMBRES');

        $sheet->setCellValue('G1', 'CARGO');
        $sheet->setCellValue('H1', 'TIPO DOCUMENTO');
        $sheet->setCellValue('I1', 'NUM. DOCUMENTO');
        $sheet->setCellValue('J1', 'FECHA DE NACIMIENTO');
        $sheet->setCellValue('K1', 'CORREO ELECTRÓNICO');
        $sheet->setCellValue('L1', 'TELÉFONO CELULAR');

        $sheet->setCellValue('M1', 'DOMICILIO ACTUAL');

        $sheet->setCellValue('N1', 'DISTRITO');
        $sheet->setCellValue('O1', 'PROVINCIA');
        $sheet->setCellValue('P1', 'DEPARTAMENTO');
        $sheet->setCellValue('Q1', 'ANTIGUEDAD EN AÑOS');
        $sheet->setCellValue('R1', 'ANTIGUEDAD EN MESES');
        $sheet->setCellValue('S1', 'SITUACIÓN LABORAL');
        $sheet->setCellValue('T1', 'GENERACIÓN');

        $spreadsheet->getActiveSheet()->setAutoFilter('A1:T1');
        //Le aplicamos color a la cabecera
        $spreadsheet->getActiveSheet()->getStyle("A1:T1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('657099');

        //border
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        //Font BOLD
        $sheet->getStyle('A1:T1')->getFont()->setBold(true);

        $id_centro_labor = session('usuario')->id_centro_labor;
        $id_puesto = session('usuario')->id_puesto;

        $dato['list_ajefatura'] = $this->Model_Asignacion->get_list_ajefatura_puesto($id_puesto);

        $result = "";

        foreach ($dato['list_ajefatura'] as $char) {
            $result .= $char['id_puesto_permitido'] . ",";
        }

        $cadena = substr($result, 0, -1);

        $dato['cadena'] = "(" . $cadena . ")";
        $parametro['base'] = $base;
        $data = Usuario::colaborador_porcentaje(0, $id_centro_labor, $dato, $parametro);
        //$slno = 1;
        $start = 1;
        foreach ($data as $d) {
            $start = $start + 1;

            $spreadsheet->getActiveSheet()->setCellValue("A{$start}", $d['nom_estado_usuario']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$start}", $d['ini_funciones']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$start}", $d['centro_labores']);
            $spreadsheet->getActiveSheet()->setCellValue("D{$start}", $d['usuario_apater']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$start}", $d['usuario_amater']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$start}", $d['usuario_nombres']);

            $spreadsheet->getActiveSheet()->setCellValue("G{$start}", $d['nom_cargo']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$start}", $d['cod_tipo_documento']);
            $spreadsheet->getActiveSheet()->setCellValue("I{$start}", $d['num_doc']);
            $spreadsheet->getActiveSheet()->setCellValue("J{$start}", $d['fec_nac']);
            $spreadsheet->getActiveSheet()->setCellValue("K{$start}", $d['usuario_email']);
            $spreadsheet->getActiveSheet()->setCellValue("L{$start}", $d['num_celp']);

            $spreadsheet->getActiveSheet()->setCellValue("M{$start}", $d['nom_via'] . ' ' . $d['num_via']);

            $spreadsheet->getActiveSheet()->setCellValue("N{$start}", $d['nombre_distrito']);
            $spreadsheet->getActiveSheet()->setCellValue("O{$start}", $d['nombre_provincia']);
            $spreadsheet->getActiveSheet()->setCellValue("P{$start}", $d['nombre_departamento']);
            $diferencia = date_diff(date_create($d['ini_funciones']), date_create(date('d-m-Y')));
            $anio = $diferencia->y;
            $mes = $diferencia->m;

            if ($d['ini_funciones'] == null) {
                $spreadsheet->getActiveSheet()->setCellValue("Q{$start}", $d['ini_funciones']);
            } else {
                $spreadsheet->getActiveSheet()->setCellValue("Q{$start}", $anio);
            }
            if ($d['ini_funciones'] == null) {
                $spreadsheet->getActiveSheet()->setCellValue("R{$start}", $d['ini_funciones']);
            } else {
                $spreadsheet->getActiveSheet()->setCellValue("R{$start}", $mes);
            }

            $spreadsheet->getActiveSheet()->setCellValue("S{$start}", $d['nom_situacion_laboral']);
            $spreadsheet->getActiveSheet()->setCellValue("T{$start}", $d['generacion']);

            //border
            $sheet->getStyle("A{$start}:S{$start}")->applyFromArray($styleThinBlackBorderOutline);
        }
        //Alignment
        //fONT SIZE
        $sheet->getStyle("A{$start}:T{$start}")->getFont()->setSize(12);
        $sheet->getStyle('A1:T1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(60);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(35);
        $sheet->getColumnDimension('J')->setWidth(35);
        $sheet->getColumnDimension('K')->setWidth(35);
        $sheet->getColumnDimension('L')->setWidth(35);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(20);
        $sheet->getColumnDimension('R')->setWidth(35);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(25);

        //final part
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista_Miequipo_' . $curdate;
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Modal_Marcacion_Mi_Equipo($id_usuario)
    {
        $get_id = $this->Model_Perfil->get_id_usuario($id_usuario);
        $dato['list_marcacion'] = $this->Model_Asignacion->get_list_marcacion_mi_equipo($get_id[0]['num_doc']);
        $dato['foto_nombre'] = $get_id[0]['foto_nombre'];
        $dato['nom_usuario'] = ucwords(strtolower($get_id[0]['usuario_nombres'] . " " . $get_id[0]['usuario_apater'] . " " . $get_id[0]['usuario_amater']));
        return view('rrhh.Mi_equipo.modal_marcacion', $dato);
    }

    public function Modal_Horario_Mi_Equipo($id_usuario)
    {
        $get_id = $this->Model_Perfil->get_list_usuario($id_usuario);
        $get_horario = Horario::where('id_horario', $get_id[0]['id_horario'])
            ->where('estado', 1)
            ->orderBy('id_horario', 'DESC')
            ->limit('1')
            ->first();

        if ($get_horario) {
            $dato['get_id'] = $this->Model_Perfil->get_list_horario($get_horario->id_horario);
            $dato['get_detalle'] = HorarioDia::where('id_horario', $get_horario->id_horario)
                ->where('estado', 1)
                ->orderBy('dia', 'ASC')
                ->get();
            $dato['funciona'] = 1;
        } else {
            $dato['funciona'] = 0;
        }
        return view('rrhh.Mi_equipo.modal_horario', $dato);
    }

    public function Modal_Update_ListaMiequipo($id_usuario)
    {
        $dato['get_id'] = $this->Model_Perfil->get_list_usuario($id_usuario);
        return view('rrhh.Mi_equipo.modal_update', $dato);
    }

    public function Update_Miequipo()
    {
        $dato['id_usuario'] = $this->input->post("id_usuario");
        $dato['usuario_codigo'] = $this->input->post("usuario_codigo");
        $dato['password'] = $this->input->post("usuario_password");
        $dato['usuario_password'] = password_hash($dato['password'], PASSWORD_DEFAULT);

        $user = Usuario::where('id_usuario', $dato['id_usuario']);

        $updateData = [
            'usuario_codigo' => $dato['usuario_codigo'],
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
        ];

        if (!empty($dato['password'])) {
            $updateData['usuario_password'] = $dato['usuario_password'];
            $updateData['password_desencriptado'] = $dato['password'];
        }

        $user->update($updateData);
    }

    public function Modal_Update_Baja($id_usuario)
    {
        $dato['get_id'] = $this->Model_Perfil->get_list_usuario($id_usuario);
        $dato['list_motivo'] = DB::table('motivo_baja_rrhh')->get();
        $dato['url'] = Config::where('descrip_config', 'Bajas_Colaborador')->get();
        return view('rrhh.Mi_equipo.modal_baja', $dato);
    }

    public function Update_Fecha_Baja()
    {
        $this->input->validate([
            'fec_baja' => [
                'required_if:cancelar_baja,0',
                'date',
            ],
            'id_motivo' => 'required_if:cancelar_baja,0|not_in:0',
        ], [
            'fec_baja.date' => 'Debe ingresar fecha de Baja',
            'fec_baja.required_if' => 'Debe ingresar fecha de Baja',
            'id_motivo.required_if' => 'Debe seleccionar motivo de baja',
            'id_motivo.not_in' => 'Debe seleccionar un motivo de baja válido',
        ]);

        $dato['id_usuario'] = $this->input->post("id_usuario");
        $dato['fec_baja'] = $this->input->post("fec_baja");
        $dato['id_motivo'] = $this->input->post("id_motivo");
        $dato['cancelar_baja'] = $this->input->post("cancelar_baja");
        $dato['observaciones_baja'] = $this->input->post("observaciones_baja");
        $dato['motivo_renuncia'] = $this->input->post("motivo_renuncia");

        $dato['fec_baja'] = $dato['fec_baja'] ?: '0000-00-00'; // Set default if empty

        $valida = Usuario::where('id_usuario', $dato['id_usuario'])
            ->where('ini_funciones', '<', $dato['fec_baja'])
            ->get();

        $dato['documento'] = null;
        if ($valida) {
            // Process the file upload
            if ($_FILES['documento']['name'] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ((!$con_id) || (!$lr)) {
                    echo "No se conecto";
                } else {
                    echo "Se conecto";
                    if ($_FILES['documento']['name'] != "") {
                        $path = $_FILES['documento']['name'];
                        $temp = explode(".", $_FILES['documento']['name']);
                        $source_file = $_FILES['documento']['tmp_name'];

                        $fecha = date('Y-m-d H:i');
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $nombre_soli = "Documento_" . $fecha . "_" . rand(10, 199);
                        $nombre = $nombre_soli . "." . $ext;

                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "MiEquipo_ComunicarBaja/" . $nombre, $source_file, FTP_BINARY);
                        if ($subio) {
                            $dato['documento'] = $nombre;
                            echo "Archivo subido correctamente";
                        } else {
                            echo "Archivo no subido correctamente";
                        }
                    }
                }
            }

            Usuario::where('id_usuario', $dato['id_usuario'])
                ->update([
                    'fec_baja' => ($dato['fec_baja'] === '0000-00-00') ? null : $dato['fec_baja'],
                    'cancelar_baja' => $dato['cancelar_baja'],
                    'id_motivo_baja' => $dato['id_motivo'],
                    'observaciones_baja' => $dato['observaciones_baja'],
                    'motivo_renuncia' => $dato['motivo_renuncia'],
                    'documento' => $dato['documento'],
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            //comunicado de baja si el check no esta marcado; con envio de correo
            if ($dato['cancelar_baja'] != "1") {
                $get_id = $this->Model_Perfil->get_id_usuario($dato['id_usuario']);

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
                    $mail->setFrom('intranet@lanumero1.com.pe', 'SOLICITUD DE BAJA');

                    // $mail->addAddress('pcardenas@lanumero1.com.pe');
                    $mail->addAddress('rrhh@lanumero1.com.pe');
                    $mail->addAddress('fclaverias@lanumero1.com.pe');

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "Solicitud de baja - " . $get_id[0]['usuario_nombres'] . " " . $get_id[0]['usuario_apater'] . " " . $get_id[0]['usuario_amater'];

                    $mail->Body = "<FONT SIZE=3>¡Hola!<br><br>
                                        Se ha registrado la siguiente solicitud de baja:<br><br>
                                        Centro de labores: " . $get_id[0]['centro_labores'] . "<br>
                                        N° Documento: " . $get_id[0]['num_doc'] . "<br>
                                        F. de Nacimiento: " . $get_id[0]['fec_nac_baja'] . "<br>
                                        Nombres: " . $get_id[0]['usuario_nombres'] . "<br>
                                        Apellido paterno: " . $get_id[0]['usuario_apater'] . "<br>
                                        Apellido materno: " . $get_id[0]['usuario_amater'] . "<br>
                                        Puesto: " . $get_id[0]['nom_puesto'] . "<br>
                                        Fecha de inicio: " . $get_id[0]['ini_funciones_baja'] . "<br>
                                        Fecha de baja: " . $get_id[0]['fec_baja_baja'] . "<br>
                                        Situación laboral : " . $get_id[0]['nom_situacion_laboral'] . "
                                    </FONT SIZE>";
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
            }
        } else {
            echo "error";
        }
    }

    public function Modal_Update_CoordinadorJr($id_usuario)
    {
        $dato['get_id'] = $this->Model_Perfil->get_list_usuario($id_usuario);
        return view('rrhh.Mi_equipo.modal_coordinador', $dato);
    }

    public function Update_Asignacion_Coordinador_Jr()
    {
        $this->input->validate([
            'fec_asignacionjr' => [
                'required_if:cancelar_asignacionjr,0', // Obligatorio si 'cancelar_baja' no está marcado
                'date'
            ],
        ], [
            'fec_asignacionjr.date' => 'Debe ingresar fecha de asignacion',
        ]);
        //asigna como coordinador 
        $dato['id_usuario'] = $this->input->post("id_usuarioa");
        $dato['fec_asignacionjr'] = $this->input->post("fec_asignacionjr");
        $dato['cancelar_asignacionjr'] = $this->input->post("cancelar_asignacionjr");

        Usuario::where('id_usuario', $dato['id_usuario'])->update([
            'fec_asignacionjr' => $dato['fec_asignacionjr'],
            'cancelar_asignacionjr' => $dato['cancelar_asignacionjr'],
            'id_puestojr' => 29,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
        ]);
    }

    public function Solicitud_Puesto()
    {
        $dato['id_usuario'] = $this->input->post("id_usuario");
        $valida = Usuario::where('id_usuario', $dato['id_usuario'])
            ->where('ini_funciones', '<', now()->subMonth())
            ->get()
            ->toArray();

        if (empty($valida)) {
            echo "permanencia";
        } else {
            $valida = SolicitudPuesto::where('id_usuario', $dato['id_usuario'])
                ->where('estado_s', 1)
                ->where('estado', 1)
                ->get();

            if (count($valida) > 0) {
                echo "evaluacion";
            } else {
                $valida = ExamenEntrenamiento::valida_entrenamiento_pendiente($dato['id_usuario']);

                if (count($valida) > 0) {
                    echo "evaluacion";
                }
            }
        }
    }

    public function Modal_Solicitud_Puesto($id_usuario, $tipo)
    {
        $dato['id_usuario'] = $id_usuario;
        $dato['tipo'] = $tipo;
        $dato['list_grado_instruccion'] = GradoInstruccion::where('estado', 1)
            ->get();
        return view('rrhh.Mi_equipo.modal_solicitud_puesto', $dato);
    }

    public function Update_Solicitud_Puesto()
    {
        $dato['grado_instruccion'] = $this->input->post("grado_instruccionsp");
        $dato['id_usuario'] = $this->input->post("id_usuario");
        $dato['tipo'] = $this->input->post("tipo");

        $get_id = $this->Model_Perfil->get_id_usuario($dato['id_usuario']);
        $dato['base'] = $get_id[0]['centro_labores'];
        $dato['id_puesto'] = $get_id[0]['id_puesto'];

        if ($dato['tipo'] == 1) {
            $dato['id_puesto_aspirado'] = 33;
        } else if ($dato['tipo'] == 2) {
            $dato['id_puesto_aspirado'] = 35;
        } else if ($dato['tipo'] == 3) {
            $dato['id_puesto_aspirado'] = 167;
        } else if ($dato['tipo'] == 4) {
            $dato['id_puesto_aspirado'] = 32;
        } else if ($dato['tipo'] == 5) {
            $dato['id_puesto_aspirado'] = 31;
        } else if ($dato['tipo'] == 6) {
            $dato['id_puesto_aspirado'] = 30;
        } else if ($dato['tipo'] == 7) {
            $dato['id_puesto_aspirado'] = 29;
        }

        $valida_obs = SolicitudPuesto::where('id_usuario', $dato['id_usuario'])
            ->where('estado_s', 1)
            ->where('estado', 1)
            ->count();

        if ($valida_obs > 0) {
            $dato['observacion'] = 1;
        } else {
            $dato['observacion'] = 0;
        }

        $get_puesto = Puesto::select('*', DB::raw('LOWER(nom_puesto) AS nom_puesto_min'))
            ->where('id_puesto', $dato['id_puesto_aspirado'])
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
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

            // $mail->addAddress('pcardenas@lanumero1.com.pe');
            $mail->addAddress('rrhh@lanumero1.com.pe');
            $mail->addAddress('ksanz@lanumero1.com.pe');

            $mail->isHTML(true);

            $mail->Subject = "Solicitud de entrenamiento al puesto";

            $mail->Body =  '<FONT SIZE=3>
                                    Buen día, se solicita entrenamiento para el siguiente personal:
                                    <ul>
                                        <li>Colaborador: <b>' . ucwords($get_id[0]['nombre_completo']) . '</b></li>
                                        <li>Base: <b>' . $get_id[0]['centro_labores'] . '</b></li>
                                        <li>Puesto Actual: <b>' . ucfirst($get_id[0]['nom_puesto_min']) . '</b></li>
                                        <li>Puesto Aspirado: <b>' . ucfirst($get_puesto[0]['nom_puesto_min']) . '</b></li>
                                    </ul>
                                </FONT SIZE>';

            $mail->CharSet = 'UTF-8';
            $mail->send();

            SolicitudPuesto::create([
                'fecha' => now(),
                'base' => $dato['base'],
                'id_puesto' => $dato['id_puesto'],
                'id_puesto_aspirado' => $dato['id_puesto_aspirado'],
                'id_usuario' => $dato['id_usuario'],
                'grado_instruccion' => $dato['grado_instruccion'],
                'observacion' => $dato['observacion'],
                'estado_s' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        } catch (Exception $e) {
            echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }
}
