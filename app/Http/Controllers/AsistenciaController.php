<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Base;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\Anio;
use App\Models\SubGerencia;
use DateTime;
use App\Models\Notificacion;

class AsistenciaController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelousuarios;
    protected $modeloarea;
    protected $modelogerencia;
    protected $modelomes;
    protected $modeloanio;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Asistencia();
        $this->modelobase = new Base();
        $this->modelousuarios = new Usuario();
        $this->modelogerencia = new Gerencia();
        $this->modeloarea = new Area();
        $this->modelomes = new Mes();
        $this->modeloanio = new Anio();
    }

    //parte superior de pestañas
    public function index()
    {

        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //$dato['list_asistencia'] = $this->Model_Asistencia->get_list_asistencia_biotime();
        $id_gerencia = 0;

        $id_area = Session('usuario')->id_area;
        $id_puesto = Session('usuario')->id_puesto;
        $centro_labores = Session('usuario')->centro_labores;
        $cod_base = 0;
        $num_doc = 0;
        $list_base = $this->modelobase->select('cod_base')->where('estado', 1)->groupBy('cod_base')->orderBy('cod_base', 'ASC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161) {
            $cod_base = $centro_labores;
        } else {
            $cod_base = "OFC";
        }
        $estado = 1;
        $list_colaborador = $this->modelousuarios->get_list_usuarios_x_baset($cod_base, $area = null, $estado);
        $list_area = $this->modeloarea->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_gerencia = $this->modelogerencia->get_list_gerencia();
        $list_mes = $this->modelomes->where('estado', 1)->get();
        $list_anio = $this->modeloanio->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161) {
            return view('rrhh.Asistencia.reporte.indexct', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        } else {
            return view('rrhh.Asistencia.reporte.index', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        }
        /*
        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia('06','2024','OFC','76244986','1','2024-06-13','2024-06-13');
        print_r($list_asistencia);*/
    }

    public function Buscar_Reporte_Control_Asistencia(Request $request)
    {
        $id_puesto = Session('usuario')->id_puesto;
        $cod_mes = $request->input("cod_mes");
        $cod_anio = $request->input("cod_anio");
        $cod_base = $request->input("cod_base");
        $num_doc = $request->input("num_doc");
        $area = $request->input("area");
        $estado = $request->input("estado");
        $tipo = $request->input("tipo");
        $finicio = $request->input("finicio");
        $ffin = $request->input("ffin");
        //echo date('Y-m-01'); // first day of this month
        $year = date('Y');
        if ($tipo == 1) {
            $year = $cod_anio;
            $fecha_inicio = strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01");
            $fecha_fin = $L->format('Y-m-t');
            $timestamp = strtotime($fecha_fin);
            $fecha_fin = strtotime(date("d-m-Y", $timestamp));
        } else {
            $fecha_inicio = strtotime(date("d-m-Y", strtotime($request->input("finicio"))));
            $fecha_fin = strtotime(date("d-m-Y", strtotime($request->input("ffin"))));
        }

        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin);
        //print_r($list_asistencia);
        if ($num_doc != 0) {
            $list_colaborador = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        } else {
            $list_colaborador = $this->modelo->get_list_usuarios_x_baset($cod_base, $area, $estado);
        }
        $n_documento = $num_doc;

        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197) {
            return view('rrhh.Asistencia.reporte.listarct', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        } else {
            return view('rrhh.Asistencia.reporte.listar', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        }
    }
}
