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
        return view('rrhh.AsistenciaColaboradores.asistencia.index');
    }

    // INCONSISTENCIAS
    public function index_inconsistencia()
    {
        return view('rrhh.AsistenciaColaboradores.inconsistencia.index');
    }

    // AUSENCIAS
    public function index_ausencias()
    {
        return view('rrhh.AsistenciaColaboradores.ausencias.index');
    }

    // DOTACIÓN
    public function index_dotacion()
    {
        return view('rrhh.AsistenciaColaboradores.dotacion.index');
    }

    // TARDANZAS
    public function index_tardanza()
    {
        return view('rrhh.AsistenciaColaboradores.tardanza.index');
    }
}
