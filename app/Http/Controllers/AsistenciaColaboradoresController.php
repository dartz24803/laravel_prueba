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


    public function list_inconsistencias_colaborador()
    {
        dd("####");
        $dato['base'] = $this->input->post("base");
        $dato['area'] = $this->input->post("area");
        $dato['usuario'] = $this->input->post("usuario");
        $dato['tipo_fecha'] = $this->input->post("tipo_fecha");
        $dato['dia'] = $this->input->post("dia");
        $dato['semana'] = $this->input->post("semana");
        $dato['get_semana'] =  AsistenciaColaborador::get_list_semanas($dato['semana']);

        $list_asistenciai = AsistenciaColaborador::get_list_marcacion_colaborador_inconsistencias(0, $dato);
        dd($list_asistenciai);
        return view('rrhh.AsistenciaColaboradores.inconsistencia.index', compact('list_asistenciai', 'data'));
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
        // Retornar la vista con los datos
        return view('rrhh.AsistenciaColaboradores.dotacion.lista', compact('list_dotacion', 'fecha'));
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
