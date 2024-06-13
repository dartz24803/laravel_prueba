<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorariosCuadroControl;
use App\Models\Base;
use App\Models\DiaSemana;
use App\Models\Puesto;
use Illuminate\Support\Facades\Session;
use App\Models\CuadroControlVisualHorario;
use App\Models\Usuario;
use Illuminate\Support\Facades\Validator;

class TablaCuadroControlVisualController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelodiasemana;
    protected $modelopuestos;
    protected $modeloccvh;
    protected $modelousuarios;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new HorariosCuadroControl();
        $this->modelobase = new Base();
        $this->modelodiasemana = new DiaSemana();
        $this->modelopuestos = new Puesto();
        $this->modeloccvh = new CuadroControlVisualHorario();
        $this->modelousuarios = new Usuario();
    }

    //parte superior de pestañas
    public function index(){
        return view('tienda.administracion.CuadroControlVisual.tabla_ccv');
    }

    //adm horarios
    public function Horarios_Cuadro_Control(){
        $list_bases = $this->modelobase->listar();
        return view('tienda.administracion.CuadroControlVisual.Horarios.index', compact('list_bases'));
    }

    public function Lista_Horarios_Cuadro_Control(Request $request){
        $base= $request->input("base");
        $list_horarios = $this->modelo->listar($base);
        return view('tienda.administracion.CuadroControlVisual.Horarios.lista', compact('list_horarios'));
    }

    public function Modal_Horarios_Cuadro_Control(){
        // Lógica para obtener los datos necesarios
        $list_base = $this->modelobase->listar();
        $list_dia = $this->modelodiasemana->get();
        $list_puestos = $this->modelopuestos->get();
        // Retorna la vista con los datos
        return view('tienda.administracion.CuadroControlVisual.Horarios.modal_registrar', compact('list_base', 'list_dia'));
    }

    public function Traer_Puesto_Horario(Request $request){
        $base = $request->input("cod_base");
        $list_puesto = $this->modelopuestos->get_list_puesto_horario($base);
        return view('tienda.administracion.CuadroControlVisual.Horarios.puesto', compact('list_puesto'));
    }

    public function Modal_Update_Horarios_Cuadro_Control($id){
        // Lógica para obtener los datos necesarios
        $get_id = $this->modelo->where('id_horarios_cuadro_control', $id)->get();
        $list_base = $this->modelobase->listar();
        $list_dia = $this->modelodiasemana->get();
        $list_puestos = $this->modelopuestos->get();
        // Retorna la vista con los datos
        return view('tienda.administracion.CuadroControlVisual.Horarios.modal_editar', compact('get_id', 'list_base', 'list_dia'));
    }

    public function Insert_Horarios_Cuadro_Control(Request $request){
        //validacion de codigo, q vaya con datos
        $validator = Validator::make($request->all(), [
            'cod_base' => 'not_in:0'
        ], [
            'cod_base.not_in' => 'Base: Campo obligatorio',
        ]);
        //alerta de validacion
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->get('cod_base');
        }else{
            $dato['cod_base'] = $request->input("cod_base");
            $dato['id_puesto'] = $request->input("puesto");
            $dato['dia'] = $request->input("dia");
            $get_id = $this->modelopuestos->where('id_puesto', $dato['id_puesto'])->get();
            $puesto = $get_id[0]['nom_puesto'];
            $valor = $this->modelo->contador_x_puesto_y_base($dato['cod_base'], $puesto, $dato['dia']);
            $dato['puesto'] = $puesto.''.$valor;
            //print_r($dato['puesto']);
            $dato['t_refrigerio_h'] = $request->input("t_refrigerio_h");
            $dato['hora_entrada']= $request->input("hora_entrada");
            $dato['hora_salida']= $request->input("hora_salida");
            $dato['ini_refri']= $request->input("ini_refri");
            $dato['fin_refri']= $request->input("fin_refri");
            $dato['ini_refri2']= $request->input("ini_refri2");
            $dato['fin_refri2']= $request->input("fin_refri2");
            $dato['estado']= 1;
            $dato['fec_reg']= now();
            $dato['user_reg']= Session::get('usuario')->id_usuario;
            print_r($dato);
            // $this->modelo->insert($dato);
        }
        return response()->json($respuesta);
    }

    public function Update_Horarios_Cuadro_Control(Request $request){
        $id = $request->input("id");
        $dato['t_refrigerio_h'] = $request->input("t_refrigerio_he");
        $dato['hora_entrada']= $request->input("hora_entradae");
        $dato['hora_salida']= $request->input("hora_salidae");
        $dato['ini_refri']= $request->input("ini_refrie");
        $dato['fin_refri']= $request->input("fin_refrie");
        $dato['ini_refri2']= $request->input("ini_refri2e");
        $dato['fin_refri2']= $request->input("fin_refri2e");
        $dato['fec_act']= now();
        $dato['user_act']= Session::get('usuario')->id_usuario;
        $this->modelo->where('id_horarios_cuadro_control', $id)->update($dato);
    }

    public function Delete_Horarios_Cuadro_Control(Request $request){
        $id = $request->input("id");
        $this->modelo->where('id_horarios_cuadro_control', $id)->delete();
    }

    public function Modal_Agregar_Horarios_Cuadro_Control($id){
        $get_id = $this->modelo->where('id_horarios_cuadro_control', $id)->get();
        $list_base = $this->modelobase->listar();
        $list_dia = $this->modelodiasemana->get();
        return view('tienda.administracion.CuadroControlVisual.Horarios.modal_agregar_horario', compact('get_id','list_base','list_dia'));
    }

    public function Agregar_Horarios_Cuadro_Control(Request $request){
        $id= $request->input("id");
        $get_id = $this->modelo->where('id_horarios_cuadro_control', $id)->get();
        $dato['cod_base'] = $get_id[0]['cod_base'];
        $dato['id_puesto'] = $get_id[0]['id_puesto'];
        $dato['puesto'] = $get_id[0]['puesto'];
        $dato['dia'] = $request->input("dia_na");
        $dato['t_refrigerio_h'] = $request->input("t_refrigerio_ha");
        $dato['hora_entrada']= $request->input("hora_entradaa");
        $dato['hora_salida']= $request->input("hora_salidaa");
        $dato['ini_refri']= $request->input("ini_refria");
        $dato['fin_refri']= $request->input("fin_refria");
        $dato['ini_refri2']= $request->input("ini_refri2a");
        $dato['fin_refri2']= $request->input("fin_refri2a");
        $this->modelo->insert($dato);
    }
    
    //ADM CUADRO CONTROL VISUAL
    public function Cuadro_Control_Visual(){
        $list_bases = $this->modelobase->listar();
        return view('tienda.administracion.CuadroControlVisual.Cuadro_Control_Visual.index', compact('list_bases'));
    }
    
    public function Lista_Cuadro_Control_Visual(Request $request){
        $base= $request->input("base");
        $list_cuadro_control_visual = $this->modelo->get_list_c_cuadro_control_visual($base);
        return view('tienda.administracion.CuadroControlVisual.Cuadro_Control_Visual.lista', compact('list_cuadro_control_visual'));
    }
    
    public function Insert_Cuadro_Control_Visual_Horario(Request $request){
        $dato['id_usuario']= $request->input("id_usuario"); 
        $dato['horario']= $request->input("id_horario");
        $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
        $dato['dia'] = $get_id[0]['dia'];
        $dato['fec_reg'] = now();
        $dato['user_reg'] = Session::get('usuario')->id_usuario;
        //print_r($dato);
        $this->modeloccvh->insert($dato);
    }

    //ADM PROGRAMACION DIARIA
    public function Programacion_Diaria(){
        $list_bases = $this->modelobase->listar();
        return view('tienda.administracion.CuadroControlVisual.Programacion_Diaria.index', compact('list_bases'));
    }
    
    public function Lista_Programacion_Diaria(Request $request){
        $base= $request->input("base");
        $list_programacion_diaria = $this->modelo->get_list_programacion_diaria($base);
        return view('tienda.administracion.CuadroControlVisual.Programacion_Diaria.lista', compact('list_programacion_diaria'));
    }
    
    public function Modal_Programacion_Diaria(){
        // Lógica para obtener los datos necesarios
        $list_base = $this->modelobase->listar();
        // Retorna la vista con los datos
        return view('tienda.administracion.CuadroControlVisual.Programacion_Diaria.modal_registrar', compact('list_base'));
    }

    public function Traer_Colaborador_Programacion_Diaria(Request $request){
        $base = $request->input("cod_base");
        $id_puesto = $request->input("id_puesto");
        $dato['list_colaborador'] = $this->modelousuarios->get_list_colaborador_programacion_diaria($base,$id_puesto);
        return view('Tienda.administracion.CuadroControlVisual.Programacion_Diaria.usuario', $dato);
    }

    public function Traer_Horario_Programacion_Diaria(Request $request){
        $base = $request->input("cod_base");
        $id_puesto = $request->input("id_puesto");
        $dia = $request->input("dia");
        $dato['list_horario'] = $this->modelo->get_list_horario_programacion_diaria($base,$id_puesto,$dia);
        return view('Tienda.Administracion.CuadroControlVisual.Programacion_Diaria.horario', $dato);
    }
    //test insert
    public function Insert_Programacion_Diaria(Request $request){
        $dato['id_usuario']= $request->input("id_usuario");

        $data['ch_lunes']= $request->input("ch_dia_laborado_lu");
        if($data['ch_lunes']==1){
            $dato['horario']= $request->input("id_horario_lu");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_martes']= $request->input("ch_dia_laborado_ma");
        if($data['ch_martes']==1){
            $dato['horario']= $request->input("id_horario_ma");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_miercoles']= $request->input("ch_dia_laborado_mi");
        if($data['ch_miercoles']==1){
            $dato['horario']= $request->input("id_horario_mi");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_jueves']= $request->input("ch_dia_laborado_ju");
        if($data['ch_jueves']==1){
            $dato['horario']= $request->input("id_horario_ju");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_viernes']= $request->input("ch_dia_laborado_vi");
        if($data['ch_viernes']==1){
            $dato['horario']= $request->input("id_horario_vi");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_sabado']= $request->input("ch_dia_laborado_sa");
        if($data['ch_sabado']==1){
            $dato['horario']= $request->input("id_horario_sa");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }

        $data['ch_domingo']= $request->input("ch_dia_laborado_do");
        if($data['ch_domingo']==1){
            $dato['horario']= $request->input("id_horario_do");
            $get_id = $this->modelo->where('id_horarios_cuadro_control', $dato['horario'])->get();
            $dato['dia'] = $get_id[0]['dia'];
            $this->modeloccvh->insert($dato);
        }
    }
}
