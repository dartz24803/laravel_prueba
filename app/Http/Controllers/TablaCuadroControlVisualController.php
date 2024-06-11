<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorariosCuadroControl;
use App\Models\Base;
use App\Models\DiaSemana;
use App\Models\Puestos;
use Illuminate\Support\Facades\Session;

class TablaCuadroControlVisualController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelodiasemana;
    protected $modelopuestos;

    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new HorariosCuadroControl();
        $this->modelobase = new Base();
        $this->modelodiasemana = new DiaSemana();
        $this->modelopuestos = new Puestos();
    }

    public function index(){
        //retornar vista si esta logueado
        // $list_area = $this->modeloarea->listar();
        // $list_bases = $this->modelobase->listar();
        // $list_codigos = $this->modelocodigos->listar();
        //enviar listas a la vista
        return view('tienda.administracion.CuadroControlVisual.tabla_ccv');
    }

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
        $this->modelo->insert($dato);
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
}
