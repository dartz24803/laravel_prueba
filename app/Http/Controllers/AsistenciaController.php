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
use Illuminate\Support\Facades\Session;

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

    public function __construct(Request $request){
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
    public function index(){
        //$dato['list_asistencia'] = $this->Model_Asistencia->get_list_asistencia_biotime();
        $id_gerencia=0;

        $id_area = Session::get('usuario')->id_area;
        $id_puesto = Session::get('usuario')->id_puesto;
        $centro_labores = Session::get('usuario')->centro_labores;
        $cod_base=0;
        $num_doc=0;
        $list_base = $this->modelobase->select('cod_base')->where('estado',1)->groupBy('cod_base')->orderBy('cod_base', 'ASC')->get();
        if($id_puesto==29 || $id_puesto==98 || $id_puesto==26 || $id_puesto==16 || $id_puesto==197 || $id_puesto==161){
            $cod_base=$centro_labores;
        }else{
            $cod_base="OFC";
        }
        $estado=1;
        $list_colaborador = $this->modelousuarios->get_list_usuarios_x_baset($cod_base,$area=null,$estado);
        $list_area = $this->modeloarea->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_gerencia = $this->modelogerencia->get_list_gerencia();
        $list_mes = $this->modelomes->where('estado',1)->get();
        $list_anio = $this->modeloanio->where('estado',1)->orderBy('cod_anio', 'DESC')->get();
        if($id_puesto==29 || $id_puesto==98 || $id_puesto==26 || $id_puesto==16 || $id_puesto==197 || $id_puesto==161){
            return view('rrhh.Asistencia.reporte.indexct', compact('list_base','list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio'));
        }else{
            return view('rrhh.Asistencia.reporte.index', compact('list_base','list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio'));
        }
        /*
        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia('06','2024','OFC','76244986','1','2024-06-13','2024-06-13');
        print_r($list_asistencia);*/
    }
}
