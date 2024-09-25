<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorariosCuadroControl;
use App\Models\Base;
use App\Models\Usuario;
use App\Models\HorarioDia;
use App\Models\AsignacionCargoCap;
use App\Models\CuadroControlVisualEstado;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class CuadroControlVisualController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelousuarios;
    protected $modelohorario;
    protected $modeloasignacioncargocap;
    protected $modeloccve;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new HorariosCuadroControl();
        $this->modelousuarios = new Usuario();
        $this->modelohorario = new HorarioDia();
        $this->modeloasignacioncargocap = new AsignacionCargoCap();
        $this->modeloccve = new CuadroControlVisualEstado();
    }

    public function Cuadro_Control_Visual_Vista()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(2);
        $list_subgerencia_logis = SubGerencia::list_subgerencia(7);
        $list_bases = Base::get_list_bases_tienda();
        return view('tienda.Cuadro_Control_Visual.index', compact('list_notificacion', 'list_subgerencia', 'list_bases', 'list_subgerencia_logis'));
    }

    public function Lista_Cuadro_Control_Visual_Vista(Request $request)
    {
        $base = $request->input("base");
        $cuadro_control_visual = $this->modelousuarios->get_list_cuadro_control_visual($base);
        $horarios = $this->modelohorario->get_horarios_x_base_hoy($base);
        $contador_vendedores = $this->modeloasignacioncargocap->where('cod_base', $base)->where('estado', 1)->where('id_cargo_cap', 18)->get();
        $contador_presentes = $this->modelousuarios->contador_presentes_ccv($base);
        $contador_total_x_bases = $this->modelousuarios->contador_total_x_bases($base);
        return view('tienda.Cuadro_Control_Visual.lista', compact('cuadro_control_visual', 'horarios', 'contador_vendedores', 'contador_presentes', 'contador_total_x_bases'));
    }

    public function Insert_Cuadro_Control_Visual_Estado(Request $request)
    {
        $dato['id_usuario'] = $request->input("id_usuario");
        $dato['estado'] = $request->input('estado');
        $dato['fec_reg'] = now();
        $dato['user_reg'] = Session('usuario')->id_usuario;
        $this->modeloccve->insert($dato);
    }

    public function Insert_Cuadro_Control_Visual_Estado1(Request $request)
    {
        $dato['id_usuario'] = $request->input("id_usuario");
        $dato['estado'] = $request->input('estado');
        $dato['fec_reg'] = now();
        $dato['user_reg'] = Session('usuario')->id_usuario;
        $valida = $this->modeloccve->validar_presente($dato['id_usuario']);
        if ($valida == 0) {
            $this->modeloccve->insert($dato);
        }
    }
}
