<?php

namespace App\Http\Controllers;

use App\Models\AsignacionJefatura;
use App\Models\AsistenciaColaborador;
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
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class AsistenciaColaboradoresController extends Controller
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


    // BRYAN - ASISTENCIA COLABORADORES
    public function ListaAsistenciaColaboradores()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('rrhh.AsistenciaColaboradores.index', compact('list_subgerencia', 'list_notificacion'));
    }

    // ASISTENCIAS
    public function index_asistencia()
    {
        if (session('usuario')->id_usuario) {
            $data['list_mes'] = AsistenciaColaborador::get_list_mes();
            $data['list_area'] = AsistenciaColaborador::get_list_area();
            $data['list_base'] = AsistenciaColaborador::get_list_base_general();
            $dato['centro_labores'] = 0;
            $dato['id_area'] = 0;
            $data['list_colaborador'] = AsistenciaColaborador::get_list_colaborador_rrhh_xbase($dato);
            $data['list_semanas'] = AsistenciaColaborador::get_list_semanas();
            $data['list_noti'] = AsistenciaColaborador::get_list_notificacion();
            $data['list_nav_evaluaciones'] = AsistenciaColaborador::get_list_nav_evaluaciones();
            $list_asistencia = [];
        } else {
            redirect('');
        }
        return view('rrhh.AsistenciaColaboradores.asistencia.index', compact('list_asistencia', 'data'));
    }

    public function list_asistencia_colaborador(Request $request)
    {
        $dato['base'] = $this->input->post("base");
        $dato['area'] = $this->input->post("area");
        $dato['usuario'] = $this->input->post("usuario");
        $dato['tipo_fecha'] = $this->input->post("tipo_fecha");
        $dato['dia'] = $this->input->post("dia");
        $dato['mes'] = $this->input->post("mes");
        // dd($dato);
        // Llamar al método para obtener la lista de asistencia
        $list_asistencia = AsistenciaColaborador::getListAsistenciaColaborador(0, $dato);

        // Retornar la vista con los datos
        return view('rrhh.AsistenciaColaboradores.asistencia.lista', compact('list_asistencia'));
    }

    public function edit_estado_asistencia($id_asistencia_colaborador)
    {
        $dato['id_asistencia_colaborador'] = $id_asistencia_colaborador;
        $get_id = AsistenciaColaborador::get_list_asistencia_colaborador($dato['id_asistencia_colaborador'], 0);
        // dd($get_id);
        // $list_estado = AsistenciaColaborador::get_list_estado_asistencia_ausencia();
        return view('rrhh.AsistenciaColaboradores.asistencia.modal_editar', compact('get_id'));
    }

    public function update_estado_asistencia()
    {
        $dato['id_asistencia_colaborador'] = $this->input->post("id_asistencia_colaborador_a");
        $dato['flag_diatrabajado'] = $this->input->post("flag_diatrabajado_a");
        AsistenciaColaborador::update_asistencia_colaborador_dia_trabajado($dato);
    }

    public function Excel_Asistencia_Colaborador($base, $area, $usuario, $tipo_fecha, $dia, $mes)
    {
        $dato['base'] = $base;
        $dato['area'] = $area;
        $dato['usuario'] = $usuario;
        $dato['tipo_fecha'] = $tipo_fecha;
        $dato['dia'] = $dia;
        $dato['mes'] = $mes;
        $list_asistencia = AsistenciaColaborador::get_list_asistencia_colaborador(0, $dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencias');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(18);

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:K1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:K1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Colaborador');
        $sheet->setCellValue('B1', 'DNI');
        $sheet->setCellValue('C1', 'Base');
        $sheet->setCellValue('D1', 'Fecha');
        $sheet->setCellValue('E1', 'Turno');
        $sheet->setCellValue('F1', 'Entrada');
        $sheet->setCellValue('G1', 'Salida a refrigerio');
        $sheet->setCellValue('H1', 'Entrada de refrigerio');
        $sheet->setCellValue('I1', 'Salida');
        $sheet->setCellValue('J1', 'Registro');
        $sheet->setCellValue('K1', 'Dia Laborado');

        $contador = 1;
        foreach ($list_asistencia as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $spreadsheet->getActiveSheet()->setCellValue("A{$contador}", $list['usuario_nombres'] . " " . $list['usuario_apater'] . " " . $list['usuario_amater']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$contador}", $list['num_doc']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$contador}", $list['centro_labores']);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $spreadsheet->getActiveSheet()->setCellValue("E{$contador}", $list['turno']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$contador}", $list['marcacion_entrada']);
            $spreadsheet->getActiveSheet()->setCellValue("G{$contador}", $list['marcacion_idescanso']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$contador}", $list['marcacion_fdescanso']);
            $spreadsheet->getActiveSheet()->setCellValue("I{$contador}", $list['marcacion_salida']);
            $spreadsheet->getActiveSheet()->setCellValue("J{$contador}", $list['nom_estado']);
            $spreadsheet->getActiveSheet()->setCellValue("K{$contador}", $list['flag_diatrabajado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencias';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }



    public function Excel_Control_Mensual_Asistencia_Colaborador($base, $area, $usuario, $tipo_fecha, $dia, $mes)
    {
        $dato['base'] = $base;
        $dato['area'] = $area;
        $dato['usuario'] = $usuario;
        $dato['tipo_fecha'] = $tipo_fecha;
        $dato['dia'] = $dia;
        $dato['mes'] = $mes;
        $list_asistencia = AsistenciaColaborador::get_list_asistencia_colaborador(0, $dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencia Mensual');

        $sheet->setAutoFilter('A1:K1');

        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(18);

        $sheet->getStyle('A1:K1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:K1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:K1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Colaborador');
        $sheet->setCellValue('B1', 'DNI');
        $sheet->setCellValue('C1', 'Base');
        $sheet->setCellValue('D1', 'Fecha');
        $sheet->setCellValue('E1', 'Turno');
        $sheet->setCellValue('F1', 'Entrada');
        $sheet->setCellValue('G1', 'Salida a refrigerio');
        $sheet->setCellValue('H1', 'Entrada de refrigerio');
        $sheet->setCellValue('I1', 'Salida');
        $sheet->setCellValue('J1', 'Registro');
        $sheet->setCellValue('K1', 'Dia Laborado');

        $contador = 1;
        foreach ($list_asistencia as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:K{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:K{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $spreadsheet->getActiveSheet()->setCellValue("A{$contador}", $list['usuario_nombres'] . " " . $list['usuario_apater'] . " " . $list['usuario_amater']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$contador}", $list['num_doc']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$contador}", $list['centro_labores']);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $spreadsheet->getActiveSheet()->setCellValue("E{$contador}", $list['turno']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$contador}", $list['marcacion_entrada']);
            $spreadsheet->getActiveSheet()->setCellValue("G{$contador}", $list['marcacion_idescanso']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$contador}", $list['marcacion_fdescanso']);
            $spreadsheet->getActiveSheet()->setCellValue("I{$contador}", $list['marcacion_salida']);
            $spreadsheet->getActiveSheet()->setCellValue("J{$contador}", $list['nom_estado']);
            $spreadsheet->getActiveSheet()->setCellValue("K{$contador}", $list['flag_diatrabajado']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencia Mensual';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }













    // INCONSISTENCIAS
    public function index_inconsistencia()
    {
        if (session('usuario')->id_usuario) {
            $data['list_mes'] = AsistenciaColaborador::get_list_mes();
            $data['list_area'] = AsistenciaColaborador::get_list_area();
            $data['list_base'] = AsistenciaColaborador::get_list_base_general();
            $dato['centro_labores'] = 0;
            $dato['id_area'] = 0;
            $data['list_colaborador'] = AsistenciaColaborador::get_list_colaborador_rrhh_xbase($dato);
            $data['list_semanas'] = AsistenciaColaborador::get_list_semanas();
            $data['list_noti'] = AsistenciaColaborador::get_list_notificacion();
            $data['list_nav_evaluaciones'] = AsistenciaColaborador::get_list_nav_evaluaciones();
            // dd($data['list_colaborador']);
            $list_asistencia = [];
            // $list_asistencia = AsistenciaColaborador::getListAsistenciaColaborador(0, $dato);

        } else {
            redirect('');
        }
        return view('rrhh.AsistenciaColaboradores.inconsistencia.index', compact('list_asistencia', 'data'));
    }


    public function list_inconsistencias_colaborador(Request $request)
    {
        $dato['base'] = $request->input("base");
        $dato['area'] = $request->input("area");
        $dato['usuario'] = $request->input("usuario");
        $dato['tipo_fecha'] = $request->input("tipo_fecha");
        $dato['dia'] = $request->input("dia");
        $dato['semana'] = $request->input("semana");
        $dato['get_semana'] = AsistenciaColaborador::get_list_semanas($dato['semana']);
        $list_asistenciai = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias(0, (object) $dato);
        return view('rrhh.AsistenciaColaboradores.inconsistencia.lista', compact('list_asistenciai', 'dato'));
    }

    public function marcaciones_inconsistencias_colaborador($id_asistencia_inconsistencia)
    {

        $dato['id_asistencia_inconsistencia'] = $id_asistencia_inconsistencia;
        $dato['get_asist'] = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia, 0);
        $list_marcacionesh = AsistenciaColaborador::get_list_detalle_marcacion_inconsistencia($dato);


        $dato['get_id'] = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias_2($id_asistencia_inconsistencia, 0);
        $dato['cod_base'] = $dato['get_id'][0]['centro_labores'];
        $list_turno = AsistenciaColaborador::get_list_turno_xbase($dato);
        $get_asist = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia, 0);
        $get_id = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias_2($id_asistencia_inconsistencia, 0);

        // dd($get_asist);
        // dd($dato);
        return view('rrhh.AsistenciaColaboradores.inconsistencia.marcaciones_inconsistencia', compact('get_asist', 'get_id', 'list_marcacionesh', 'id_asistencia_inconsistencia', 'list_turno'));
    }


    public function marcaciones_reg_inconsistencias_colaborador($id_asistencia_inconsistencia, $tipo_marcacion)
    {
        $dato['id_asistencia_inconsistencia'] = $id_asistencia_inconsistencia;
        $dato['tipo_marcacion'] = $tipo_marcacion;
        $get_marca = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia, 0);
        // dd($get_marca);
        return view('rrhh.AsistenciaColaboradores.inconsistencia.marcaciones_reg_inconsistencia', compact('get_marca', 'tipo_marcacion', 'id_asistencia_inconsistencia'));
    }

    public function insert_asistencia_inconsistencia()
    {
        $dato['id_asistencia_inconsistencia'] = $this->input->post("id_asistencia_inconsistencia");
        $dato['marcacion'] = $this->input->post("marcacion");
        $dato['tipo_marcacion'] = $this->input->post("tipo_marcacion");
        $dato['obs_marcacion'] = $this->input->post("obs_marcacion");
        // dd($dato);
        AsistenciaColaborador::insert_asistencia_inconsistencia($dato);
    }

    public function update_asistencia_inconsistencia()
    {
        $dato['marcacion'] = $this->input->post("marcacion");
        $dato['obs_marcacion'] = $this->input->post("obs_marcacion");
        $dato['id_asistencia_detalle'] = $this->input->post("id_asistencia_detalle");
        $dato['visible'] = $this->input->post("visible");
        $dato['tipo_marcacion'] = $this->input->post("tipo_marcacion");
        AsistenciaColaborador::update_marcacion_inconsistencia($dato);
    }


    public function Validar_Asistencia_Inconsistencia()
    {

        $dato['id_asistencia_inconsistencia'] = $this->input->post("id_asistencia_inconsistencia");
        $dato['observacion_inconsistencia'] = $this->input->post("observacion_inconsistencia");
        $dato['d_dias'] = $this->input->post("d_dias");
        $dato['medio_dia'] = $this->input->post("medio_dia");

        AsistenciaColaborador::update_obs_asistencia_inconsistencia($dato);

        $dato['get_asist'] = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias_2($dato['id_asistencia_inconsistencia'], 0);
        $dato['get_marc'] = AsistenciaColaborador::get_list_detalle_marcacion_inconsistencia_visible($dato);
        $total_marc = AsistenciaColaborador::get_list_detalle_marcacion_inconsistencia_total($dato);
        $dato['nom_horario'] = $dato['get_asist'][0]['nom_horario'];
        $dato['observacion'] = $dato['get_asist'][0]['observacion'];

        $hora_entrada = $dato['get_asist'][0]['hora_entrada'];
        $max_hora_entrada = $dato['get_asist'][0]['max_hora_entrada'];
        $hora_entrada_desde = $dato['get_asist'][0]['hora_entrada_desde'];
        $hora_entrada_hasta = $dato['get_asist'][0]['hora_entrada_hasta'];
        $hora_descanso_e = $dato['get_asist'][0]['hora_descanso_e'];
        $hora_descanso_e_desde = $dato['get_asist'][0]['hora_descanso_e_desde'];
        $hora_descanso_e_hasta = $dato['get_asist'][0]['hora_descanso_e_hasta'];
        $hora_descanso_s = $dato['get_asist'][0]['hora_descanso_s'];
        $hora_descanso_s_desde = $dato['get_asist'][0]['hora_descanso_s_desde'];
        $hora_descanso_s_hasta = $dato['get_asist'][0]['hora_descanso_s_hasta'];
        $hora_salida = $dato['get_asist'][0]['hora_salida'];
        $hora_salida_desde = $dato['get_asist'][0]['hora_salida_desde'];
        $hora_salida_hasta = $dato['get_asist'][0]['hora_salida_hasta'];

        if ($dato['get_asist'][0]['id_turno'] != 0) {
            if ($dato['get_asist'][0]['con_descanso'] == 1) {
                if ($dato['d_dias'] == 1 || $dato['medio_dia'] == 1) {
                    if (count($dato['get_marc']) > 1) {
                        $dato['marcacion1'] = null;
                        $dato['marcacion2'] = null;
                        $dato['marcacion3'] = null;
                        $dato['marcacion4'] = null;

                        $dato['obs_marcacion1'] = null;
                        $dato['obs_marcacion2'] = null;
                        $dato['obs_marcacion3'] = null;
                        $dato['obs_marcacion4'] = null;
                        foreach ($dato['get_marc'] as $row) {
                            $punch_time = $row['marcacion'];
                            $work_code = $row['obs_marcacion'];

                            // Verifica si la marcación está dentro del rango de entrada
                            if ($row['tipo_marcacion'] == 1) {
                                //if ($punch_time >= $hora_entrada_desde && $punch_time <= $hora_entrada_hasta) {
                                if ($dato['marcacion1'] === null || $punch_time < $dato['marcacion1']) {
                                    $dato['marcacion1'] = $punch_time;
                                    $dato['obs_marcacion1'] = $work_code;
                                }
                                //}
                            }

                            //idescanso
                            if ($row['tipo_marcacion'] == 2) {
                                //if ($punch_time >= $hora_descanso_e_desde && $punch_time <= $hora_descanso_e_hasta) {
                                if ($dato['marcacion2'] === null || $punch_time < $dato['marcacion2']) {
                                    $dato['marcacion2'] = $punch_time;
                                    $dato['obs_marcacion2'] = $work_code;
                                }
                                //}
                            }
                            //fdescanso
                            if ($row['tipo_marcacion'] == 3) {
                                //if ($punch_time >= $hora_descanso_s_desde && $punch_time <= $hora_descanso_s_hasta) {
                                if ($dato['marcacion3'] === null || $punch_time < $dato['marcacion3']) {
                                    $dato['marcacion3'] = $punch_time;
                                    $dato['obs_marcacion3'] = $work_code;
                                }
                                //}
                            }
                            //salida
                            if ($row['tipo_marcacion'] == 4) {
                                //if ($punch_time >= $hora_salida_desde) {
                                if ($dato['marcacion4'] === null || $punch_time < $dato['marcacion4']) {
                                    $dato['marcacion4'] = $punch_time;
                                    $dato['obs_marcacion4'] = $work_code;
                                }
                                //}
                            }
                        }

                        if ($dato['marcacion1'] !== null && $dato['marcacion4'] !== null) {

                            $dato['registro'] = "";
                            $dato['estado_registro'] = 0;
                            if ($dato['marcacion1'] < $max_hora_entrada) {
                                $dato['registro'] = "Puntual";
                                $dato['estado_registro'] = 1;
                            } else {
                                $dato['registro'] = "Tardanza";
                                $dato['estado_registro'] = 2;
                            }

                            $dato['id_usuario'] = $dato['get_asist'][0]['id_usuario'];
                            $dato['fecha'] = $dato['get_asist'][0]['fecha'];
                            $dato['id_horario'] = $dato['get_asist'][0]['id_horario'];
                            $dato['con_descanso'] = $dato['get_asist'][0]['con_descanso'];
                            $dato['dia'] = $dato['get_asist'][0]['dia'];
                            $dato['centro_labores'] = $dato['get_asist'][0]['centro_labores'];
                            $dato['id_area'] = $dato['get_asist'][0]['id_area'];
                            $dato['hora_entrada'] = $dato['get_asist'][0]['hora_entrada'];
                            $dato['hora_entrada_desde'] = $dato['get_asist'][0]['hora_entrada_desde'];
                            $dato['hora_entrada_hasta'] = $dato['get_asist'][0]['hora_entrada_hasta'];
                            $dato['hora_salida'] = $dato['get_asist'][0]['hora_salida'];
                            $dato['hora_salida_desde'] = $dato['get_asist'][0]['hora_salida_desde'];
                            $dato['hora_salida_hasta'] = $dato['get_asist'][0]['hora_salida_hasta'];
                            $dato['hora_descanso_e'] = $dato['get_asist'][0]['hora_descanso_e'];
                            $dato['hora_descanso_e_desde'] = $dato['get_asist'][0]['hora_descanso_e_desde'];
                            $dato['hora_descanso_e_hasta'] = $dato['get_asist'][0]['hora_descanso_e_hasta'];
                            $dato['hora_descanso_s'] = $dato['get_asist'][0]['hora_descanso_s'];
                            $dato['hora_descanso_s_desde'] = $dato['get_asist'][0]['hora_descanso_s_desde'];
                            $dato['hora_descanso_s_hasta'] = $dato['get_asist'][0]['hora_descanso_s_hasta'];

                            if ($dato['medio_dia'] == 1) {
                                $dato['flag_diatrabajado'] = 0.5;
                            } else {
                                $dato['flag_diatrabajado'] = 1;
                            }
                            AsistenciaColaborador::validar_marcacion_inconsistencia($dato);
                            echo "1Validación Exitosa";
                        } else {
                            echo "2Marcaciones no coinciden con rangos de horario";
                        }
                    } else {
                        echo "2Cantidad de marcaciones";
                    }
                } else {
                    if (count($dato['get_marc']) == 4) {
                        if (
                            $total_marc[0]['total_marcaciones'] == 4 && $total_marc[0]['t_entrada'] == 1 && $total_marc[0]['t_srefri'] == 1 &&
                            $total_marc[0]['t_erefri'] == 1 && $total_marc[0]['t_salida'] == 1
                        ) {
                            $dato['marcacion1'] = null;
                            $dato['marcacion2'] = null;
                            $dato['marcacion3'] = null;
                            $dato['marcacion4'] = null;

                            $dato['obs_marcacion1'] = null;
                            $dato['obs_marcacion2'] = null;
                            $dato['obs_marcacion3'] = null;
                            $dato['obs_marcacion4'] = null;
                            foreach ($dato['get_marc'] as $row) {
                                $punch_time = $row['marcacion'];
                                $work_code = $row['obs_marcacion'];

                                // Verifica si la marcación está dentro del rango de entrada
                                if ($row['tipo_marcacion'] == 1) {
                                    //if ($punch_time >= $hora_entrada_desde && $punch_time <= $hora_entrada_hasta) {
                                    if ($dato['marcacion1'] === null || $punch_time < $dato['marcacion1']) {
                                        $dato['marcacion1'] = $punch_time;
                                        $dato['obs_marcacion1'] = $work_code;
                                    }
                                    //}
                                }

                                //idescanso
                                if ($row['tipo_marcacion'] == 2) {
                                    //if ($punch_time >= $hora_descanso_e_desde && $punch_time <= $hora_descanso_e_hasta) {
                                    if ($dato['marcacion2'] === null || $punch_time < $dato['marcacion2']) {
                                        $dato['marcacion2'] = $punch_time;
                                        $dato['obs_marcacion2'] = $work_code;
                                    }
                                    //}
                                }
                                //fdescanso
                                if ($row['tipo_marcacion'] == 3) {
                                    //if ($punch_time >= $hora_descanso_s_desde && $punch_time <= $hora_descanso_s_hasta) {
                                    if ($dato['marcacion3'] === null || $punch_time < $dato['marcacion3']) {
                                        $dato['marcacion3'] = $punch_time;
                                        $dato['obs_marcacion3'] = $work_code;
                                    }
                                    //}
                                }
                                //salida
                                if ($row['tipo_marcacion'] == 4) {
                                    //if ($punch_time >= $hora_salida_desde) {
                                    if ($dato['marcacion4'] === null || $punch_time < $dato['marcacion4']) {
                                        $dato['marcacion4'] = $punch_time;
                                        $dato['obs_marcacion4'] = $work_code;
                                    }
                                    //}
                                }
                            }

                            if (
                                $dato['marcacion1'] !== null && $dato['marcacion2'] !== null &&
                                $dato['marcacion3'] !== null && $dato['marcacion4'] !== null
                            ) {

                                $dato['registro'] = "";
                                $dato['estado_registro'] = 0;
                                if ($dato['marcacion1'] < $max_hora_entrada) {
                                    $dato['registro'] = "Puntual";
                                    $dato['estado_registro'] = 1;
                                } else {
                                    $dato['registro'] = "Tardanza";
                                    $dato['estado_registro'] = 2;
                                }

                                $dato['id_usuario'] = $dato['get_asist'][0]['id_usuario'];
                                $dato['fecha'] = $dato['get_asist'][0]['fecha'];
                                $dato['id_horario'] = $dato['get_asist'][0]['id_horario'];
                                $dato['con_descanso'] = $dato['get_asist'][0]['con_descanso'];
                                $dato['dia'] = $dato['get_asist'][0]['dia'];
                                $dato['centro_labores'] = $dato['get_asist'][0]['centro_labores'];
                                $dato['id_area'] = $dato['get_asist'][0]['id_area'];
                                $dato['hora_entrada'] = $dato['get_asist'][0]['hora_entrada'];
                                $dato['hora_entrada_desde'] = $dato['get_asist'][0]['hora_entrada_desde'];
                                $dato['hora_entrada_hasta'] = $dato['get_asist'][0]['hora_entrada_hasta'];
                                $dato['hora_salida'] = $dato['get_asist'][0]['hora_salida'];
                                $dato['hora_salida_desde'] = $dato['get_asist'][0]['hora_salida_desde'];
                                $dato['hora_salida_hasta'] = $dato['get_asist'][0]['hora_salida_hasta'];
                                $dato['hora_descanso_e'] = $dato['get_asist'][0]['hora_descanso_e'];
                                $dato['hora_descanso_e_desde'] = $dato['get_asist'][0]['hora_descanso_e_desde'];
                                $dato['hora_descanso_e_hasta'] = $dato['get_asist'][0]['hora_descanso_e_hasta'];
                                $dato['hora_descanso_s'] = $dato['get_asist'][0]['hora_descanso_s'];
                                $dato['hora_descanso_s_desde'] = $dato['get_asist'][0]['hora_descanso_s_desde'];
                                $dato['hora_descanso_s_hasta'] = $dato['get_asist'][0]['hora_descanso_s_hasta'];

                                $dato['flag_diatrabajado'] = 1;
                                AsistenciaColaborador::validar_marcacion_inconsistencia($dato);
                                echo "1Validación Exitosa";
                            } else {
                                echo "2Marcaciones no coinciden con rangos de horario";
                            }
                        } else {
                            echo "2Existe marcaciones sin Tipo o Tipos duplicados";
                        }
                    } else {
                        echo "2Cantidad de marcaciones";
                    }
                }
            } else {
                if (count($dato['get_marc']) == 2) {
                    if (
                        $total_marc[0]['total_marcaciones'] == 2 && $total_marc[0]['t_entrada'] == 1 &&
                        $total_marc[0]['t_salida'] == 1
                    ) {
                        $dato['marcacion1'] = null;
                        $dato['marcacion2'] = null;
                        $dato['marcacion3'] = null;
                        $dato['marcacion4'] = null;

                        $dato['obs_marcacion1'] = null;
                        $dato['obs_marcacion2'] = null;
                        $dato['obs_marcacion3'] = null;
                        $dato['obs_marcacion4'] = null;
                        foreach ($dato['get_marc'] as $row) {
                            $punch_time = $row['marcacion'];
                            $work_code = $row['obs_marcacion'];

                            // Verifica si la marcación está dentro del rango de entrada
                            if ($row['tipo_marcacion'] == 1) {
                                //if ($punch_time >= $hora_entrada_desde && $punch_time <= $hora_entrada_hasta) {
                                if ($dato['marcacion1'] === null || $punch_time < $dato['marcacion1']) {
                                    $dato['marcacion1'] = $punch_time;
                                    $dato['obs_marcacion1'] = $work_code;
                                }
                                //}
                            }
                            //salida
                            if ($row['tipo_marcacion'] == 4) {
                                //if ($punch_time >= $hora_salida_desde) {
                                if ($dato['marcacion4'] === null || $punch_time < $dato['marcacion4']) {
                                    $dato['marcacion4'] = $punch_time;
                                    $dato['obs_marcacion4'] = $work_code;
                                }
                                //}
                            }
                        }

                        if ($dato['marcacion1'] !== null && $dato['marcacion4'] !== null) {

                            $dato['registro'] = "";
                            $dato['estado_registro'] = 0;
                            if ($dato['marcacion1'] < $max_hora_entrada) {
                                $dato['registro'] = "Puntual";
                                $dato['estado_registro'] = 1;
                            } else {
                                $dato['registro'] = "Tardanza";
                                $dato['estado_registro'] = 2;
                            }

                            $dato['id_usuario'] = $dato['get_asist'][0]['id_usuario'];
                            $dato['fecha'] = $dato['get_asist'][0]['fecha'];
                            $dato['id_horario'] = $dato['get_asist'][0]['id_horario'];
                            $dato['con_descanso'] = $dato['get_asist'][0]['con_descanso'];
                            $dato['dia'] = $dato['get_asist'][0]['dia'];
                            $dato['centro_labores'] = $dato['get_asist'][0]['centro_labores'];
                            $dato['id_area'] = $dato['get_asist'][0]['id_area'];
                            $dato['hora_entrada'] = $dato['get_asist'][0]['hora_entrada'];
                            $dato['hora_entrada_desde'] = $dato['get_asist'][0]['hora_entrada_desde'];
                            $dato['hora_entrada_hasta'] = $dato['get_asist'][0]['hora_entrada_hasta'];
                            $dato['hora_salida'] = $dato['get_asist'][0]['hora_salida'];
                            $dato['hora_salida_desde'] = $dato['get_asist'][0]['hora_salida_desde'];
                            $dato['hora_salida_hasta'] = $dato['get_asist'][0]['hora_salida_hasta'];
                            $dato['hora_descanso_e'] = $dato['get_asist'][0]['hora_descanso_e'];
                            $dato['hora_descanso_e_desde'] = $dato['get_asist'][0]['hora_descanso_e_desde'];
                            $dato['hora_descanso_e_hasta'] = $dato['get_asist'][0]['hora_descanso_e_hasta'];
                            $dato['hora_descanso_s'] = $dato['get_asist'][0]['hora_descanso_s'];
                            $dato['hora_descanso_s_desde'] = $dato['get_asist'][0]['hora_descanso_s_desde'];
                            $dato['hora_descanso_s_hasta'] = $dato['get_asist'][0]['hora_descanso_s_hasta'];

                            $dato['flag_diatrabajado'] = 1;
                            AsistenciaColaborador::validar_marcacion_inconsistencia($dato);
                            echo "1Validación Exitosa";
                        } else {
                            echo "2Marcaciones no coinciden con rangos de horario";
                        }
                    } else {
                        echo "2Existe marcaciones sin Tipo o Tipos duplicados";
                    }
                } else {
                    echo "2Cantidad de marcaciones";
                }
            }
        } else {
            echo "2Debe asignar turno para continuar";
        }
    }

    public function updateturno_asistencia_inconsistencia()
    {

        $dato['id_asistencia_inconsistencia'] = $this->input->post("id_asistencia_inconsistencia_t");
        $dato['id_turno'] = $this->input->post("id_turnot");
        $dato['get_id'] = AsistenciaColaborador::get_list_turno($dato['id_turno']);
        $dato['entrada'] = $dato['get_id'][0]['entrada'];
        $dato['salida'] = $dato['get_id'][0]['salida'];
        $dato['con_descanso'] = $dato['get_id'][0]['t_refrigerio'];
        $dato['ini_refri'] = $dato['get_id'][0]['ini_refri'];
        $dato['fin_refri'] = $dato['get_id'][0]['fin_refri'];

        $data = AsistenciaColaborador::consulta_tolerancia_horario_activo();

        $minutos = 0;
        if (count($data) > 0) {
            $minutos = $data[0]['minutos'];
        }
        // dd($dato);
        AsistenciaColaborador::update_turno_inconsistencia($dato, $minutos);
    }


    public function divturno_inconsistencias($id_asistencia_inconsistencia)
    {
        $dato['id_asistencia_inconsistencia'] = $id_asistencia_inconsistencia;
        $dato['get_asist'] = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia, 0);
        return view('rrhh.AsistenciaColaboradores.asistencia.div_turno_inconsistencia', compact('get_asist'));
    }

    public function Excel_Inconsistencias_Colaborador($base, $area, $usuario, $tipo_fecha, $dia, $semana)
    {
        $dato['base'] = $base;
        $dato['area'] = $area;
        $dato['usuario'] = $usuario;
        $dato['tipo_fecha'] = $tipo_fecha;
        $dato['dia'] = $dia;
        $dato['semana'] = $semana;
        $dato['get_semana'] = AsistenciaColaborador::get_list_semanas_excel($dato['semana']);
        // dd($dato);
        $list_asistenciai = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias_excel(0, $dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:I1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:I1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Asistencias - Inconsistencias');

        $sheet->setAutoFilter('A1:I1');

        $sheet->getColumnDimension('A')->setWidth(50);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'Colaborador');
        $sheet->setCellValue('B1', 'DNI');
        $sheet->setCellValue('C1', 'Base');
        $sheet->setCellValue('D1', 'Fecha');
        $sheet->setCellValue('E1', 'Turno');
        $sheet->setCellValue('F1', 'Entrada');
        $sheet->setCellValue('G1', 'Salida a refrigerio');
        $sheet->setCellValue('H1', 'Entrada de refrigerio');
        $sheet->setCellValue('I1', 'Salida');

        $contador = 1;
        foreach ($list_asistenciai as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $spreadsheet->getActiveSheet()->setCellValue("A{$contador}", $list['usuario_nombres'] . " " . $list['usuario_apater'] . " " . $list['usuario_amater']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$contador}", $list['num_doc']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$contador}", $list['centro_labores']);
            $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $spreadsheet->getActiveSheet()->setCellValue("E{$contador}", $list['turno']);
            $marcaciones = explode(', ', $list['entrada']);
            $marca = "";
            if (count($marcaciones) == 1 && $marcaciones[0] != "") {
                $marca = $marcaciones[0];
            } elseif (count($marcaciones) > 0 && $marcaciones[0] != "") {
                foreach ($marcaciones as $marcacion) {
                    $marca = $marca . $marcacion . ", ";
                }
                $marca = substr($marca, 0, -2);
            } else {
                $marca = "--:--";
            }
            $spreadsheet->getActiveSheet()->setCellValue("F{$contador}", $marca);

            $marcaciones = explode(', ', $list['salidaarefrigerio']);
            $marca = "";
            if ($list['con_descanso'] == 1) {
                if (count($marcaciones) == 1 && $marcaciones[0] != "") {
                    $marca = $marcaciones[0];
                } elseif (count($marcaciones) > 0 && $marcaciones[0] != "") {
                    foreach ($marcaciones as $marcacion) {
                        $marca = $marca . $marcacion . ", ";
                    }
                    $marca = substr($marca, 0, -2);
                } else {
                    $marca = "--:--";
                }
            } else {
                $marca = "-";
            }

            $spreadsheet->getActiveSheet()->setCellValue("G{$contador}", $marca);

            $marcaciones = explode(', ', $list['entradaderefrigerio']);
            $marca = "";
            if ($list['con_descanso'] == 1) {
                if (count($marcaciones) == 1 && $marcaciones[0] != "") {
                    $marca = $marcaciones[0];
                } elseif (count($marcaciones) > 0 && $marcaciones[0] != "") {
                    foreach ($marcaciones as $marcacion) {
                        $marca = $marca . $marcacion . ", ";
                    }
                    $marca = substr($marca, 0, -2);
                } else {
                    $marca = "--:--";
                }
            } else {
                $marca = "-";
            }
            $spreadsheet->getActiveSheet()->setCellValue("H{$contador}", $marca);

            $marcaciones = explode(', ', $list['salida']);
            $marca = "";
            if (count($marcaciones) == 1 && $marcaciones[0] != "") {
                $marca = $marcaciones[0];
            } elseif (count($marcaciones) > 0 && $marcaciones[0] != "") {
                foreach ($marcaciones as $marcacion) {
                    $marca = $marca . $marcacion . ", ";
                }
                $marca = substr($marca, 0, -2);
            } else {
                $marca = "--:--";
            }
            $spreadsheet->getActiveSheet()->setCellValue("I{$contador}", $marca);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencias - Inconsistencias';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Listar_Asistencia_Inconsistencia()
    {

        $dato['id_asistencia_inconsistencia'] = $this->input->post("id_asistencia_inconsistencia");
        $list_marcacionesh = AsistenciaColaborador::get_list_detalle_marcacion_inconsistencia_2($dato);
        // dd($list_marcacionesh);
        return view('rrhh.AsistenciaColaboradores.inconsistencia.lista_marcaciones', compact('list_marcacionesh'));
    }















    // AUSENCIAS
    public function index_ausencias()
    {
        if (session('usuario')->id_usuario) {
            $data['list_mes'] = AsistenciaColaborador::get_list_mes();
            $data['list_area'] = AsistenciaColaborador::get_list_area();
            $data['list_base'] = AsistenciaColaborador::get_list_base_general();
            $dato['centro_labores'] = 0;
            $dato['id_area'] = 0;
            $data['list_colaborador'] = AsistenciaColaborador::get_list_colaborador_rrhh_xbase($dato);
            $data['list_semanas'] = AsistenciaColaborador::get_list_semanas();
            $data['list_noti'] = AsistenciaColaborador::get_list_notificacion();
            $data['list_nav_evaluaciones'] = AsistenciaColaborador::get_list_nav_evaluaciones();
            // dd($data['list_colaborador']);
            $list_ausencias = [];
            // $list_asistencia = AsistenciaColaborador::getListAsistenciaColaborador(0, $dato);

        } else {
            redirect('');
        }
        return view('rrhh.AsistenciaColaboradores.ausencias.index', compact('list_ausencias', 'data'));
    }

    public function list_ausencia_colaborador(Request $request)
    {
        $dato['base'] = $this->input->post("base");
        $dato['area'] = $this->input->post("area");
        $dato['usuario'] = $this->input->post("usuario");
        $dato['tipo_fecha'] = $this->input->post("tipo_fecha");
        $dato['dia'] = $this->input->post("dia");
        $dato['semana'] = $this->input->post("semana");

        $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($dato['semana']);
        // dd($dato['get_semana']);
        $list_ausenciai = AsistenciaColaborador::get_list_marcacion_colaborador_ausencia(0, $dato);
        // dd($dato);


        // Retornar la vista con los datos
        return view('rrhh.AsistenciaColaboradores.ausencias.lista', compact('list_ausenciai'));
    }

    public function edit_estado_ausencia($id_asistencia_inconsistencia)
    {
        $dato['id_asistencia_inconsistencia'] = $id_asistencia_inconsistencia;
        $get_id = AsistenciaColaborador::get_list_marcacion_colaborador_ausencia_2($dato['id_asistencia_inconsistencia'], 0);
        $list_estado = AsistenciaColaborador::get_list_estado_asistencia_ausencia();
        return view('rrhh.AsistenciaColaboradores.ausencias.modal_editar', compact('list_estado', 'get_id'));
    }

    public function update_estado_ausencia()
    {
        $dato['id_asistencia_inconsistencia'] = $this->input->post("id_asistencia_inconsistencia");
        $dato['estado_registro'] = $this->input->post("estado");
        $dato['observacion'] = $this->input->post("observacion");

        $dato['get_asist'] = AsistenciaColaborador::get_list_marcacion_colaborador_ausencia_2($dato['id_asistencia_inconsistencia'], 0);
        $dato['nom_horario'] = $dato['get_asist'][0]['nom_horario'];
        $dato['id_usuario'] = $dato['get_asist'][0]['id_usuario'];
        $dato['fecha'] = $dato['get_asist'][0]['fecha'];
        $dato['id_horario'] = $dato['get_asist'][0]['id_horario'];
        $dato['con_descanso'] = $dato['get_asist'][0]['con_descanso'];
        $dato['dia'] = $dato['get_asist'][0]['dia'];
        $dato['centro_labores'] = $dato['get_asist'][0]['centro_labores'];
        $dato['id_area'] = $dato['get_asist'][0]['id_area'];
        $dato['hora_entrada'] = $dato['get_asist'][0]['hora_entrada'];
        $dato['hora_entrada_desde'] = $dato['get_asist'][0]['hora_entrada_desde'];
        $dato['hora_entrada_hasta'] = $dato['get_asist'][0]['hora_entrada_hasta'];
        $dato['hora_salida'] = $dato['get_asist'][0]['hora_salida'];
        $dato['hora_salida_desde'] = $dato['get_asist'][0]['hora_salida_desde'];
        $dato['hora_salida_hasta'] = $dato['get_asist'][0]['hora_salida_hasta'];
        $dato['hora_descanso_e'] = $dato['get_asist'][0]['hora_descanso_e'];
        $dato['hora_descanso_e_desde'] = $dato['get_asist'][0]['hora_descanso_e_desde'];
        $dato['hora_descanso_e_hasta'] = $dato['get_asist'][0]['hora_descanso_e_hasta'];
        $dato['hora_descanso_s'] = $dato['get_asist'][0]['hora_descanso_s'];
        $dato['hora_descanso_s_desde'] = $dato['get_asist'][0]['hora_descanso_s_desde'];
        $dato['hora_descanso_s_hasta'] = $dato['get_asist'][0]['hora_descanso_s_hasta'];
        $data = AsistenciaColaborador::get_list_estado_asistencia($dato['estado_registro']);
        $dato['flag_diatrabajado'] = $data[0]['contabilizar_dia'];
        $dato['registro'] = "";

        $dato['id_asistencia_colaborador'] = AsistenciaColaborador::update_estado_ausencia($dato);
        AsistenciaColaborador::delete_inconsistencia_ausencia($dato);
    }










    // DOTACIÓN
    public function index_dotacion()
    {
        if (session('usuario')->id_usuario) {
            $data['list_mes'] = AsistenciaColaborador::get_list_mes();
            $data['list_area'] = AsistenciaColaborador::get_list_area();
            $data['list_base'] = AsistenciaColaborador::get_list_base_general();
            $dato['centro_labores'] = 0;
            $dato['id_area'] = 0;
            $data['list_colaborador'] = AsistenciaColaborador::get_list_colaborador_rrhh_xbase($dato);
            $data['list_semanas'] = AsistenciaColaborador::get_list_semanas();
            $data['list_noti'] = AsistenciaColaborador::get_list_notificacion();
            $data['list_nav_evaluaciones'] = AsistenciaColaborador::get_list_nav_evaluaciones();
            $list_ausencias = [];
        } else {
            redirect('');
        }
        return view('rrhh.AsistenciaColaboradores.dotacion.index', compact('list_ausencias', 'data'));
    }
    public function list_dotacion_colaborador(Request $request)
    {
        $fecha = $this->input->post("fecha");
        $list_dotacion =  AsistenciaColaborador::get_list_dotacion($fecha);
        // dd($list_dotacion);
        return view('rrhh.AsistenciaColaboradores.dotacion.lista', compact('list_dotacion', 'fecha'));
    }

    public function edit_dotacion_colaborador($centro_labores, $fecha)
    {
        $dato['centro_labores'] = $centro_labores;
        $dato['fecha'] = $fecha;

        $list_marcaciones = AsistenciaColaborador::get_list_dotacion_marcaciones($dato);
        $list_ausentes = AsistenciaColaborador::get_list_dotacion_ausentes($dato);
        $centro_labores = $centro_labores;

        // dd($dato);

        return view('rrhh.AsistenciaColaboradores.dotacion.modal_marcaciones', compact('list_marcaciones', 'list_ausentes', 'fecha', 'centro_labores'));
    }









    // TARDANZAS
    public function index_tardanza()
    {
        if (session('usuario')->id_usuario) {
            $data['list_mes'] = AsistenciaColaborador::get_list_mes();
            $data['list_area'] = AsistenciaColaborador::get_list_area();
            $data['list_base'] = AsistenciaColaborador::get_list_base_general();
            $dato['centro_labores'] = 0;
            $dato['id_area'] = 0;
            $data['list_colaborador'] = AsistenciaColaborador::get_list_colaborador_rrhh_xbase($dato);
            $data['list_semanas'] = AsistenciaColaborador::get_list_semanas();
            $data['list_noti'] = AsistenciaColaborador::get_list_notificacion();
            $data['list_nav_evaluaciones'] = AsistenciaColaborador::get_list_nav_evaluaciones();
            $list_ausencias = [];
        } else {
            redirect('');
        }
        return view('rrhh.AsistenciaColaboradores.tardanza.index', compact('list_ausencias', 'data'));
    }

    public function list_tardanza_colaborador(Request $request)
    {
        $dato['base'] = $this->input->post("base");
        $dato['area'] = $this->input->post("area");
        $dato['usuario'] = $this->input->post("usuario");
        $dato['tipo_fecha'] = $this->input->post("tipo_fecha");
        $dato['dia'] = $this->input->post("dia");
        $dato['mes'] = $this->input->post("mes");
        $dato['semana']=$request->semana;
        $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($id_semanas=$dato['semana']);
        $list_tardanza =  AsistenciaColaborador::get_list_tardanza($dato);
        // Retornar la vista con los datos
        return view('rrhh.AsistenciaColaboradores.tardanza.lista', compact('list_tardanza', 'dato'));
    }

    public function Excel_Tardanza($base, $area, $usuario, $tipo_fecha, $dia, $mes, $semana)
    {
        $dato['base'] = $base;
        $dato['area'] = $area;
        $dato['usuario'] = $usuario;
        $dato['tipo_fecha'] = $tipo_fecha;
        $dato['dia'] = $dia;
        $dato['mes'] = $mes;
        $dato['semana'] = $semana;
        $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($id_semanas=$dato['semana']);
        $list_tardanza = AsistenciaColaborador::get_list_tardanza_excel($dato);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:H1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:H1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tardanza');

        $sheet->setAutoFilter('A1:H1');

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(25);

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:H1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Colaborador');
        $sheet->setCellValue("B1", 'Base');
        $sheet->setCellValue("C1", 'Puesto');
        $sheet->setCellValue("D1", 'DNI');
        $sheet->setCellValue("E1", 'Fecha');
        $sheet->setCellValue("F1", 'Hora de inicio de turno');
        $sheet->setCellValue("G1", 'Hora de llegada');
        $sheet->setCellValue("H1", 'Minutos de atraso');

        $contador = 1;

        foreach ($list_tardanza as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", ucwords($list['colaborador']));
            $sheet->setCellValue("B{$contador}", $list['base']);
            $sheet->setCellValue("C{$contador}", ucwords($list['puesto']));
            $sheet->setCellValue("D{$contador}", $list['dni']);
            $sheet->setCellValue("E{$contador}", Date::PHPToExcel($list['fecha']));
            $sheet->getStyle("E{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("F{$contador}", $list['hora_inicio_turno']);
            $sheet->setCellValue("G{$contador}", $list['hora_llegada']);
            $sheet->setCellValue("H{$contador}", $list['minutos_atraso']);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Tardanza';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function Enviar_Correos_GerenteXJefe(){
        $usuarios = Usuario::select('users.id_usuario', 'users.usuario_nombres', 'puesto.id_area', 'puesto.id_nivel', 'users.emailp','area.nom_area')
            ->leftJoin('puesto', 'users.id_puesto', '=', 'puesto.id_puesto')
            ->leftJoin('area', 'puesto.id_area', '=', 'area.id_area')
            ->whereIn('puesto.id_nivel', [2, 3, 4])
            ->where('users.estado', 1)
            ->whereIn('users.id_usuario', [133,1459,2655]) // test comentar al subir
            ->orderBy('users.id_usuario', 'ASC')
            ->get();
        // print_r($usuarios);

        $dato['base'] = 0;
        // $dato['area'] = 18;
        $dato['usuario'] = 0;
        $dato['tipo_fecha'] = 3;
        $dato['dia'] = null;
        $dato['mes'] = null;
        $data = AsistenciaColaborador::get_list_semanas();
        $current_date = date('Y-m-d'); // Fecha actual en formato 'Y-m-d'

        $id = null; // Inicializar el ID como null
        foreach ($data as $list) {
            // Comparar la fecha actual con el rango de la semana
            if ($current_date >= $list->fec_inicio && $current_date <= $list->fec_fin) {
                $id = $list->id_semanas; // Capturar el ID de la semana actual
                break; // Salir del bucle al encontrar la semana actual
            }
        }

        // Establecer el valor de semana si se encontró una coincidencia
        if ($id !== null) {
            $dato['semana'] = $id;
        } else {
            // Manejar el caso en que no se encontró una semana actual (opcional)
            $dato['semana'] = null; // O algún valor predeterminado
        }
        $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($id_semanas=$dato['semana']);
        // $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($id_semanas=205);
        $dato['excel'] = 1;


        foreach($usuarios as $usuario){
            $dato['area'] = $usuario->id_area;

            $list_tardanza = AsistenciaColaborador::get_list_tardanza_excel($dato);
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getStyle("A1:E3")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:E3")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $spreadsheet->getActiveSheet()->setTitle('Tardanza');

            $sheet->setAutoFilter('A3:E3');

            $sheet->getColumnDimension('A')->setWidth(30);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(20);
            $sheet->getColumnDimension('E')->setWidth(25);

            $sheet->setCellValue('A1', $usuario->nom_area);
            $sheet->getStyle('A1:E3')->getFont()->setBold(true);

            $spreadsheet->getActiveSheet()->getStyle("A3:E3")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('DCE6F1');

            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A3:E3")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A3", 'Colaborador');
            $sheet->setCellValue("B3", 'Fecha');
            $sheet->setCellValue("C3", 'Hora de inicio de turno');
            $sheet->setCellValue("D3", 'Hora de llegada');
            $sheet->setCellValue("E3", 'Minutos de atraso');

            $contador = 3;

            foreach ($list_tardanza as $list) {
                $contador++;

                $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("A{$contador}:E{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleThinBlackBorderOutline);

                $sheet->setCellValue("A{$contador}", ucwords($list['colaborador']));
                Carbon::setLocale('es');
                $formattedDate = Carbon::createFromFormat('d/m/Y', $list['fecha'])->translatedFormat('l d \d\e F \d\e Y');
                $sheet->setCellValue("B{$contador}", ucfirst($formattedDate));
                $sheet->setCellValue("C{$contador}", $list['hora_inicio_turno']);
                $sheet->setCellValue("D{$contador}", $list['hora_llegada']);
                $sheet->setCellValue("E{$contador}", $list['minutos_atraso']);
            }

            $fec_inicio = $dato['get_semana'][0]->fec_inicio;
            $fec_fin = $dato['get_semana'][0]->fec_fin;
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Tardanza_semanal_' . $fec_inicio . '_' . $fec_fin . '.xlsx';
            $filePath = public_path('ARCHIVO_TEMPORAL/' . $fileName);

            $semana = $dato['get_semana'][0]->nom_semana;
            try {
                $writer->save($filePath);
                echo "Archivo guardado correctamente.";
            } catch (Exception $e) {
                echo "Error al guardar el archivo: " . $e->getMessage();
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
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                if (!empty($usuario->emailp)) {
                    $mail->addAddress($usuario->emailp);
                }
                // $mail->addAddress('pcardenas@lanumero1.com.pe');
                // $mail->addCC('fclaverias@lanumero1.com.pe');
                // $mail->addAddress('DVILCA@LANUMERO1.COM.PE');
                // $mail->addAddress('');
                // $mail->addAddress('');

                $mail->isHTML(true);

                $mail->Subject = "REPORTE DE TARDANZAS - SEMANA $semana";
                // Generar tabla HTML
                $tableHtml = "
                    <table border='1' cellspacing='0' cellpadding='5' style='border-collapse: collapse; width: 100%; text-align: center;'>
                        <thead style='background-color: #DCE6F1; font-weight: bold;'>
                            <tr>
                                <th>Colaborador</th>
                                <th>Fecha</th>
                                <th>Hora de inicio de turno</th>
                                <th>Hora de llegada</th>
                                <th>Minutos de atraso</th>
                            </tr>
                        </thead>
                        <tbody>";

                foreach ($list_tardanza as $list) {
                    Carbon::setLocale('es');
                    $formattedDate = Carbon::createFromFormat('d/m/Y', $list['fecha'])->translatedFormat('l d \d\e F \d\e Y');
                    $tableHtml .= "
                        <tr>
                            <td>" . ucwords($list['colaborador']) . "</td>
                            <td>" . ucfirst($formattedDate) . "</td>
                            <td>{$list['hora_inicio_turno']}</td>
                            <td>{$list['hora_llegada']}</td>
                            <td>{$list['minutos_atraso']}</td>
                        </tr>";
                }

                $tableHtml .= "
                        </tbody>
                    </table>";

                $area = $usuario->nom_area;
                $nombre = $usuario->usuario_nombres;
                $primerNombre = explode(' ', $nombre)[0];
                $mail->Body =  "Estimado/a $primerNombre <br>
                    Te envío el archivo de ASISTENCIA Y MARCACION $area - SEM 43
                    DEL $fec_inicio - $fec_fin <br><br>
                    De acuerdo a nuestras políticas del sábado free los colaboradores que llegaron tarde deberán asistir mañana.<br><br>
                    $tableHtml
                    <br>
                    <a style='color:blue'> Recordatorio: El beneficio del sábado free se brinda cuando se cumple los 2 siguientes puntos.</a><br><br>
                    1.- Cumplimiento de objetivos: El jefe inmediato dará la conformidad del cumplimiento de actividades planificados semanalmente.<br>
                    2.- Puntualidad perfecta: No acumular ningún minuto de tardanza de lunes a viernes.<br><br>
                    Saludos.";
                $mail->addAttachment($filePath);

                $mail->CharSet = 'UTF-8';
                $mail->send();
                echo "Correo enviado";
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
        }
        // Limpiar la carpeta ARCHIVO_TEMPORAL
        $directoryPath = public_path('ARCHIVO_TEMPORAL');
        if (is_dir($directoryPath)) {
            $files = glob($directoryPath . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Eliminar archivo
                }
            }
        }

    }
}
