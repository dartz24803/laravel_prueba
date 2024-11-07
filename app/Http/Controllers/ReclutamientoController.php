<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Base;
use App\Models\ModalidadLaboral;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\Puesto;
use App\Models\Reclutamiento;
use App\Models\ReclutamientoDetalle;
use App\Models\ReclutamientoReclutado;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ReclutamientoController extends Controller
{
    protected $input; 
    protected $modelo;
    protected $modelo_puestos;
    protected $modelo_users;
    protected $Model_Perfil;
    protected $modelo_detalles;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->input = $request;
        $this->modelo = new Reclutamiento();
        $this->modelo_puestos = new Puesto();
        $this->modelo_users = new Usuario();
        $this->Model_Perfil = new Model_Perfil();
        $this->modelo_detalles = new ReclutamientoDetalle();
    }

    public function Reclutamiento(){
            $dato['id_usuario'] = session('usuario')->id_usuario;
            $dato['list_reclutamiento_asig'] = $this->modelo->get_list_reclutamiento_asig();

            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('rrhh.Reclutamiento.index', $dato);
    }

    public function Buscador_Reclutamiento(){
            $id_usuario=$this->input->post("id_usuario");
            $dato['pestania']=$this->input->post("pestania");
            $dato['list_reclutamiento'] = $this->modelo->get_list_reclutamiento($id_reclutamiento=null,$id_usuario,$dato['pestania']);
            return view('rrhh.Reclutamiento.lista_reclutamiento', $dato);
    }

    public function Modal_Reclutamiento() {
        $dato['id_nivel'] = session('usuario')->id_nivel;
        $dato['id_puesto'] = session('usuario')->id_puesto;
        if($dato['id_nivel']==1 || $dato['id_nivel']==2 || $dato['id_puesto']==21 || $dato['id_puesto']==279){
            $dato['list_area'] = Area::get_list_area();
            $dato['puestos_jefes'] = $this->modelo_puestos->list_puestos_jefes();
            $dato['list_responsables'] = $this->modelo_users->list_usuarios_responsables($dato);
            $dato['list_rrhh'] = Usuario::select('id_usuario', 'usuario_nombres', 'usuario_apater', 'usuario_amater')
                            ->whereIn('id_puesto', [21, 277, 278])
                            ->where('estado', 1)
                            ->get();
        }else{
            $dato['id_gerencia'] = session('usuario')->id_gerencia;
            $dato['list_area'] = $this->Model_Perfil->get_list_area($dato['id_gerencia'], $id_area=null);
            $dato['id_area'] = session('usuario')->id_area;
        }
        $dato['list_colaborador'] = $this->modelo_users->get_list_colaborador();
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        $dato['list_modalidad_laboral'] = ModalidadLaboral::where('estado', 1)
                                    ->get();
        return view('rrhh.Reclutamiento.modal_reg',$dato);
    }

    public function Buscar_Puesto_Area($id_area,$t) {
        $dato['list_puesto'] = $this->modelo_puestos->where('id_area', $id_area)
                            ->where('estado', 1)
                            ->get();
        $dato['t']=$t;
        return view('rrhh.Reclutamiento.cmb_puesto',$dato);
    }

    public function Insert_Reclutamiento(){
        $this->input->validate([
            'id_area' => 'not_in:0',
            'id_puesto' => 'not_in:0',
            'id_solicitante' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'id_evaluador' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'vacantes' => 'required',
            'cod_base' => 'not_in:0',
            'id_modalidad_laboral' => 'not_in:0',
            'tipo_sueldo' => 'not_in:0',
            'sueldo' => 'required_if:tipo_sueldo,1',
            'desde' => 'required_if:tipo_sueldo,2',
            'a' => 'required_if:tipo_sueldo,2',
            'id_asignado' => 'not_in:0',
            'prioridad' => 'not_in:0',
            'fec_cierre' => 'required',
        ], [
            'id_area' => 'Debe seleccionar Área.',
            'id_puesto' => 'Debe seleccionar Puesto.',
            'id_solicitante' => 'Debe seleccionar Solicitante.',
            'id_evaluador' => 'Debe seleccionar Evaluador.',
            'vacantes' => 'Debe ingresar vacantes.',
            'cod_base' => 'Debe seleccionar Centro de Labores.',
            'id_modalidad_laboral' => 'Debe seleccionar modalidad',
            'tipo_sueldo' => 'Debe seleccionar tipo de remuneración.',
            'sueldo' => 'Debe ingresar sueldo.',
            'desde' => 'Debe ingresar Desde.',
            'a' => 'Debe ingresar A.',
            'id_asignado' => 'Debe seleccionar Asignado a',
            'prioridad' => 'Debe seleccionar Prioridad.',
            'fec_cierre' => 'Debe ingresar Fecha de Cierre.',
        ]);
            $dato['id_area']= $this->input->post("id_area");
            $dato['id_puesto']= $this->input->post("id_puesto");
            $dato['id_solicitante']= $this->input->post("id_solicitante");
            $dato['id_evaluador']= $this->input->post("id_evaluador");
            $dato['vacantes']= $this->input->post("vacantes");
            $dato['cod_base']= $this->input->post("cod_base");
            $dato['id_modalidad_laboral']= $this->input->post("id_modalidad_laboral");
            $dato['tipo_sueldo']= $this->input->post("tipo_sueldo");
            $dato['sueldo']= $this->input->post("sueldo")?: '0.00';
            $dato['desde']= $this->input->post("desde")?: '0.00';
            $dato['a']= $this->input->post("a")?: '0.00';
            $dato['id_asignado']= $this->input->post("id_asignado");
            $dato['prioridad']= $this->input->post("prioridad");
            $dato['fec_cierre']= $this->input->post("fec_cierre");
            $dato['observacion']= $this->input->post("observacion");
            $dato['mod']=1;
                $anio=date('Y');
                $totalRows_t = Reclutamiento::count();
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal="PR".$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal="PR".$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal="PR".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal="PR".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998){
                    $codigofinal="PR".$aniof.($totalRows_t+1);
                }
                $dato['cod_reclutamiento']=$codigofinal;

                Reclutamiento::create([
                    'cod_reclutamiento' => $dato['cod_reclutamiento'],
                    'id_area' => $dato['id_area'],
                    'id_puesto' => $dato['id_puesto'],
                    'id_solicitante' => $dato['id_solicitante'],
                    'id_evaluador' => $dato['id_evaluador'],
                    'vacantes' => $dato['vacantes'],
                    'cod_base' => $dato['cod_base'],
                    'id_modalidad_laboral' => $dato['id_modalidad_laboral'],
                    'tipo_sueldo' => $dato['tipo_sueldo'],
                    'sueldo' => $dato['sueldo'],
                    'desde' => $dato['desde'],
                    'a' => $dato['a'],
                    'id_asignado' => $dato['id_asignado'],
                    'prioridad' => $dato['prioridad'],
                    'fec_cierre' => $dato['fec_cierre'],
                    'observacion' => $dato['observacion'],
                    'estado_reclutamiento' => 1,
                    'estado' => 1,
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_reg' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                ]);
    }

    public function Modal_Update_Reclutamiento($id_reclutamiento) {
        $dato['get_id'] = $this->modelo->get_list_reclutamiento($id_reclutamiento,0,0);
        $dato['list_detalle_reclutamiento'] = $this->modelo_detalles->get_list_detalle_reclutamiento($id_reclutamiento);
        $dato['id_nivel'] = session('usuario')->id_nivel;
        $dato['id_puesto'] = session('usuario')->id_puesto;
        if($dato['id_nivel']==1 || $dato['id_nivel']==2 || $dato['id_puesto']==21 || $dato['id_puesto']==279){
            $dato['list_area'] = Area::get_list_area();
            $dato['puestos_jefes'] = $this->modelo_puestos->list_puestos_jefes();
            $dato['list_responsables'] = $this->modelo_users->list_usuarios_responsables($dato);
            $dato['list_rrhh'] = Usuario::select('id_usuario', 'usuario_nombres', 'usuario_apater', 'usuario_amater')
                            ->whereIn('id_puesto', [21, 277, 278])
                            ->where('estado', 1)
                            ->get();
        }else{
            $dato['id_gerencia'] = session('usuario')->id_gerencia;
            $dato['list_area'] = $this->Model_Perfil->get_list_area($dato['id_gerencia'], $id_area=null);
            $dato['id_area'] = session('usuario')->id_area;
        }
        $dato['list_colaborador'] = $this->modelo_users->get_list_colaborador();
        $dato['list_puesto'] = Puesto::where('id_area', $dato['get_id'][0]['id_area'])
                            ->where('estado', 1)
                            ->get();
        $dato['list_base'] = Base::get_list_todas_bases_agrupadas();
        $dato['list_modalidad_laboral'] = ModalidadLaboral::where('estado', 1)
                            ->get();

        return view('rrhh.Reclutamiento.modal_upd',$dato);
    }

    public function Delete_Reclutamiento_Detalle(){
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento");

            Reclutamiento::where('id_reclutamiento', $dato['id_reclutamiento'])
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);
            
            ReclutamientoReclutado::where('id_reclutamiento', $dato['id_reclutamiento'])
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);
    }

    public function Delete_Reclutado(){
            $id_detalle= $this->input->post("id_detalle");
            ReclutamientoReclutado::where('id_detalle', $id_detalle)
                            ->update([
                                'estado' => 2,
                                'fec_eli' => now(),
                                'user_eli' => session('usuario')->id_usuario,
                            ]);
    }

    public function Update_Reclutamiento(){
        $this->input->validate([
            'id_areae' => 'not_in:0',
            'id_puestoe' => 'not_in:0',
            'id_solicitantee' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'id_evaluadore' => 'required_if:nivel,1,2|required_if:puesto,21|not_in:0',
            'vacantese' => 'required',
            'cod_basee' => 'not_in:0',
            'id_modalidad_laborale' => 'not_in:0',
            'tipo_sueldoe' => 'not_in:0',
            'sueldoe' => 'required_if:tipo_sueldo,1',
            'desdee' => 'required_if:tipo_sueldo,2',
            'ae' => 'required_if:tipo_sueldo,2',
            'id_asignadoe' => 'not_in:0',
            'prioridade' => 'not_in:0',
            'fec_cierree' => 'required',
        ], [
            'id_area' => 'Debe seleccionar Área.',
            'id_puesto' => 'Debe seleccionar Puesto.',
            'id_solicitante' => 'Debe seleccionar Solicitante.',
            'id_evaluador' => 'Debe seleccionar Evaluador.',
            'vacantes' => 'Debe ingresar vacantes.',
            'cod_base' => 'Debe seleccionar Centro de Labores.',
            'id_modalidad_laboral' => 'Debe seleccionar modalidad',
            'tipo_sueldo' => 'Debe seleccionar tipo de remuneración.',
            'sueldo' => 'Debe ingresar sueldo.',
            'desde' => 'Debe ingresar Desde.',
            'a' => 'Debe ingresar A.',
            'id_asignado' => 'Debe seleccionar Asignado a',
            'prioridad' => 'Debe seleccionar Prioridad.',
            'fec_cierre' => 'Debe ingresar Fecha de Cierre.',
        ]);
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento");
            $dato['id_evaluador']= $this->input->post("id_evaluadore");
            $dato['id_modalidad_laboral']= $this->input->post("id_modalidad_laborale");
            $dato['tipo_sueldo']= $this->input->post("tipo_sueldoe");
            $dato['sueldo']= $this->input->post("sueldoe");
            $dato['desde']= $this->input->post("desdee");
            $dato['a']= $this->input->post("ae");
            $dato['id_asignado']= $this->input->post("id_asignadoe");
            $dato['observacion']= $this->input->post("observacione");
            $dato['estado_reclutamiento']= $this->input->post("estado_reclutamientoe");
            $dato['fec_termino']= $this->input->post("fec_terminoe");
            $dato['vacantes']= $this->input->post("vacantese");
            $dato['cod_base']= $this->input->post("cod_basee");
            
            $id_usuario = session('usuario')[0]['id_usuario']; // Asume que estás usando sesiones en Laravel
            $dia = date('Y-m-d');
            $fecha = [];

            // Determina el valor de los campos de fecha basados en el estado de reclutamiento
            if ($dato['estado_reclutamiento'] == 2) {
                $fecha['fec_enproceso'] = $dia;
            } elseif ($dato['estado_reclutamiento'] == 3) {
                $fecha['fec_cierre_r'] = $dia;
            }

            // Realiza la actualización
            Reclutamiento::where('id_reclutamiento', $dato['id_reclutamiento'])
                ->update(array_merge([
                    'id_evaluador' => $dato['id_evaluador'],
                    'id_modalidad_laboral' => $dato['id_modalidad_laboral'],
                    'tipo_sueldo' => $dato['tipo_sueldo'],
                    'id_asignado' => $dato['id_asignado'],
                    'sueldo' => $dato['sueldo'],
                    'desde' => $dato['desde'],
                    'a' => $dato['a'],
                    'observacion' => $dato['observacion'],
                    'vacantes' => $dato['vacantes'],
                    'cod_base' => $dato['cod_base'],
                    'estado_reclutamiento' => $dato['estado_reclutamiento'],
                    'fec_termino' => $dato['fec_termino'],
                    'fec_act' => now(),
                    'user_act' => $id_usuario,
                ], $fecha));
    }
/*
    public function Insert_Reclutamiento_Reclutado(){
        if ($this->session->userdata('usuario')) {
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento2");
            $dato['id_usuario']= $this->input->post("id_colaborador");
            
            $cant=count($this->Model_Corporacion->valida_reclutamiento_reclutado($dato));
            if($cant>0){
                echo "error1";
            }else{
                $dato['get_id'] = $this->Model_Corporacion->get_list_reclutamiento($dato['id_reclutamiento'],0,0);
                $dato['list_detalle_reclutamiento'] = $this->Model_Corporacion->get_list_detalle_reclutamiento($dato['id_reclutamiento']);
                if(count($dato['list_detalle_reclutamiento'])<$dato['get_id'][0]['vacantes']){
                    $this->Model_Corporacion->insert_reclutamiento_reclutado($dato);
                }else{
                    echo "error2";
                }
            }
        }
        else{
            redirect('');
        }        
    }

    public function List_Reclutamiento_Reclutado(){
        if ($this->session->userdata('usuario')) {
            $id_reclutamiento= $this->input->post("id_reclutamiento");
            $dato['list_detalle_reclutamiento'] = $this->Model_Corporacion->get_list_detalle_reclutamiento($id_reclutamiento);
            $this->load->view('Recursos_Humanos/Reclutamiento/list_reclutado',$dato);
        }
        else{
            redirect('');
        }        
    }



    public function Delete_Reclutamiento(){
        if ($this->session->userdata('usuario')) {
            $dato['id_reclutamiento']= $this->input->post("id_reclutamiento");
            $this->Model_Corporacion->delete_reclutamiento($dato);
        }
        else{
            redirect('');
        }        
    }

    public function Modal_Reclutamiento_Reclutado($id_reclutamiento) {
        if (!$this->session->userdata('usuario')) {
            redirect(base_url());
        }
        $dato['id_reclutamiento']=$id_reclutamiento;
        $dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaborador();
        $this->load->view('Recursos_Humanos/Reclutamiento/modal_reg_reclutado',$dato);
    }

*/
}
