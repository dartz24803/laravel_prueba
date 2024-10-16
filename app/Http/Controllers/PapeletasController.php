<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Notificacion;
use App\Models\SolicitudesUser;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class PapeletasController extends Controller
{
    
    protected $input;
    protected $Model_Permiso;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Permiso = new SolicitudesUser();
    }
    
    public function Lista_Papeletas_Salida_seguridad(){
                $dato['list_base'] = Base::get_list_base_only();
                $dato['list_papeletas_salida'] = $this->Model_Permiso->get_list_papeletas_salida(1);
                $dato['ultima_papeleta_salida_todo'] = count($this->Model_Permiso->get_list_papeletas_salida_uno());

                if(session('usuario')->id_puesto!=23 || session('usuario')->id_puesto!=26 || session('usuario')->id_puesto!=128 || 
                session('usuario')->id_nivel!=1 || session('usuario')->id_nivel!=21 || session('usuario')->id_nivel!=19 || 
                session('usuario')->centro_labores!=="CD" || session('usuario')->centro_labores!=="OFC" || session('usuario')->centro_labores!=="AMT"){
                    
                }else{
                    $dato['list_colaborador_control'] = $this->Model_Corporacion->get_list_usuarios_x_base($centro_labores);  
                }

        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
                return view('rrhh.Papeletas_Salida_seguridad.index',$dato);
    }
    /*    
        public function Buscar_Base_Papeletas_Seguiridad(){
            if ($this->session->userdata('usuario')) {
                $this->Model_Corporacion->verificacion_papeletas();
                
                $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
                $estado_solicitud = $this->input->post("estado_solicitud");
                $fecha_revision = $this->input->post("fecha_revision");
                $fecha_revision_fin = $this->input->post("fecha_revision_fin");
                $num_doc = $this->input->post("num_doc");
                $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
                $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
        
                if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){
                    $base=$this->input->post("base");
                }else{
                    $base=$_SESSION['usuario'][0]['centro_labores'];
                }
                $dato['list_papeletas_salida'] = $this->Model_Corporacion->get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc);
        
                $this->load->view('Admin/Configuracion/Papeletas_Salida_seguridad/lista_colaborador', $dato);
            }
            else{
                redirect('');
            }
        }
        public function Update_Papeletas_Salida_seguridad_Salida() {
            if ($this->session->userdata('usuario')) {
        
                $this->Model_Corporacion->verificacion_papeletas();
        
                $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
        
                $get_id=$this->Model_Corporacion->get_id_papeleta_salida($dato['id_solicitudes_user']);
                $motivo=$get_id[0]['id_motivo'];
                if($get_id[0]['estado_solicitud']==3){
                    echo "error";
                }else{
                    if($motivo==1){
                        $this->Model_Corporacion->edit_salida_papeletas_salida($dato);
                    }
                    else{
                        $valida = $this->Model_Corporacion->valida_hora_salida($dato['id_solicitudes_user']);
        
                        if(count($valida)>0){
                            $this->Model_Corporacion->edit_salida_papeletas_salida($dato);
                        }else{
                            echo "falta";
                        }
                    }
                }
            }else{
                redirect('');
            }
        }
        public function Update_Papeletas_Salida_seguridad_Retorno() {
            if ($this->session->userdata('usuario')) {
                    $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
                    $this->Model_Corporacion->edit_retorno_papeletas_salida($dato);
            }else{
                redirect('');
            }
        }
        public function Cambiar_solicitud_papeletas_seguridad() {
            if ($this->session->userdata('usuario')) {
                    $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
                    $this->Model_Corporacion->edit_cambiar_salida_papeletas_salida($dato);
            }else{
                redirect('');
            }
        }*/
}
