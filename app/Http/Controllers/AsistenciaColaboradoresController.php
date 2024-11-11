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

        $list_asistenciai = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias(0, (object) $dato); // convertimos $dato a objeto

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
        AsistenciaColaborador::update_turno_inconsistencia($dato, $minutos);
    }


    public function divturno_inconsistencias($id_asistencia_inconsistencia)
    {
        $dato['id_asistencia_inconsistencia'] = $id_asistencia_inconsistencia;
        $dato['get_asist'] = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias($id_asistencia_inconsistencia, 0);
        return view('rrhh.AsistenciaColaboradores.asistencia.div_turno_inconsistencia', compact('get_asist'));
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
        $list_tardanza =  AsistenciaColaborador::get_list_tardanza($dato);
        // Retornar la vista con los datos
        return view('rrhh.AsistenciaColaboradores.tardanza.lista', compact('list_tardanza'));
    }
}
