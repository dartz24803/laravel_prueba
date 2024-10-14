<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Notificacion;
use App\Models\PermisoPapeletasSalida;
use App\Models\Puesto;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PapeletasConfController extends Controller
{
    
    protected $input;
    protected $Model_Permiso;

    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Permiso = new PermisoPapeletasSalida();
    }
    
    public function TablaPapeleta_Seguridad(){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            $dato['list_permisops'] = $this->Model_Permiso->get_list_permiso_papeletas_salida();

            return view('rrhh.administracion.papeletas.tablapapeleta_salida',$dato);   
    }

    public function Permisos_Papeletas_Salidas(){
            $dato['list_permisops'] = $this->Model_Permiso->get_list_permiso_papeletas_salida();
            return view('rrhh.administracion.papeletas.Permisos_papeletas_salidas.index',$dato);
    }

    public function Modal_Permisos_Papeletas_Salidas(){
            $dato['list_users'] = Usuario::where('estado', 1)->get();
            $dato['list_puesto'] = Puesto::get_list_puesto();
            return view('rrhh.administracion.papeletas.Permisos_papeletas_salidas.modal_registrar',$dato);   
    }

    public function Insert_Permisos_Papeletas_Salidas(){
            $dato['id_usuario']= $this->input->post("id_usuario"); 
            $dato['id_puesto']= $this->input->post("id_puesto");
            $dato['registro_masivo']= $this->input->post("checkmasivo"); 
            $puestos_permitido= $this->input->post("id_puesto_permitido");
            if($this->input->post("todos") == 99){
                $todos_puestos = Puesto::get_list_puesto();
                $ico= count($todos_puestos);
            }else{
                $ico= count($puestos_permitido);
            }
            $co = 0;
            do{
                if($this->input->post("todos") == 99){
                    $centro=$todos_puestos[$co]["id_puesto"];

                    $registro = 0;
                    if($this->input->checkmasivo){
                        $registro = $this->input->checkmasivo;
                    }
                    print_r($registro);
                    PermisoPapeletasSalida::create([
                        'id_puesto_permitido' => $centro,
                        'id_puesto_jefe' => $dato['id_puesto'],
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'estado' => 1,
                        'registro_masivo' => $registro,
                    ]);
                    $co=$co + 1;
                }else{

                    $registro = 0;
                    if($this->input->checkmasivo){
                        $registro = $this->input->checkmasivo;
                    }
                    $centro=$puestos_permitido[$co];
                    PermisoPapeletasSalida::create([
                        'id_puesto_permitido' => $centro,
                        'id_puesto_jefe' => $dato['id_puesto'],
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'estado' => 1,
                        'registro_masivo' => $registro,
                    ]);
                    $co=$co + 1;
                }
            }while($co < $ico);

    }

    public function Delete_Permisos_Papeletas_Salidas(){
            PermisoPapeletasSalida::where('id_permiso_papeletas_salida', $this->input->post("id_permiso_papeletas_salida"))->update([
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ]);
    }

    
    //------------------------------DESTINO-------------------------------
    public function Destino(){
            $dato['list_destino'] = Destino::selectRaw('*, CASE 
                                        WHEN id_motivo = 1 THEN "Laboral" 
                                        WHEN id_motivo = 2 THEN "Personal" 
                                        ELSE "" 
                                    END AS nom_motivo')
                            ->where('estado', 1)
                            ->get();
            
            return view('rrhh.Administracion.Destino.index',$dato);
    }
    /*
    public function Destino_boton(){
        if($this->session->userdata('usuario')) {
            $this->load->view('Admin/Configuracion/Destino/boton');
        }else{
            redirect('');
        }
    }

    public function Modal_Destino(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('Admin/Configuracion/Destino/modal_registrar');   
        }else{
            redirect('');
        }
    }

    public function Insert_Destino(){
        if ($this->session->userdata('usuario')) {
            $dato['id_motivo']= $this->input->post("id_motivo"); 
            $dato['nom_destino']= $this->input->post("nom_destino"); 
            $valida = $this->Model_Corporacion->valida_insert_destino($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Corporacion->insert_destino($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Destino($id_destino){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_destino($id_destino);
            $this->load->view('Admin/Configuracion/Destino/modal_editar',$dato);   
        }else{
            redirect('');
        }
    }

    public function Update_Destino(){
        if ($this->session->userdata('usuario')) {
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['id_motivo']= $this->input->post("id_motivo"); 
            $dato['nom_destino']= $this->input->post("nom_destino"); 
            $valida = $this->Model_Corporacion->valida_update_destino($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Corporacion->update_destino($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Delete_Destino(){
        if ($this->session->userdata('usuario')) {
            $dato['id_destino']= $this->input->post("id_destino");
            $this->Model_Corporacion->delete_destino($dato);
        }else{
            redirect('');
        }
    }
    //------------------------------TRÁMITE-------------------------------
    public function Tramite(){
        if($this->session->userdata('usuario')) {
            $dato['list_tramite'] = $this->Model_Corporacion->get_list_tramite();
            $this->load->view('Admin/Configuracion/Tramite/index',$dato);
        }else{
            redirect('');
        }
    }
    
    public function Tramite_boton(){
        if($this->session->userdata('usuario')) {
            $this->load->view('Admin/Configuracion/Tramite/boton');
        }else{
            redirect('');
        }
    }

    public function Modal_Tramite(){
        if ($this->session->userdata('usuario')) {
            $this->load->view('Admin/Configuracion/Tramite/modal_registrar');   
        }else{
            redirect('');
        }
    }

    public function Traer_Destino(){
        if ($this->session->userdata('usuario')) {
            $id_motivo = $this->input->post("id_motivo"); 
            $dato['list_destino'] = $this->Model_Corporacion->get_list_motivo_destino($id_motivo);
            $this->load->view('Admin/Configuracion/Tramite/destino',$dato);   
        }else{
            redirect('');
        }
    }

    public function Insert_Tramite(){
        if ($this->session->userdata('usuario')) {
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['nom_tramite']= $this->input->post("nom_tramite"); 
            $dato['cantidad_uso']= $this->input->post("cantidad_uso"); 
            $valida = $this->Model_Corporacion->valida_insert_tramite($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Corporacion->insert_tramite($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Modal_Update_Tramite($id_tramite){
        if ($this->session->userdata('usuario')) {
            $dato['get_id'] = $this->Model_Corporacion->get_list_tramite($id_tramite);
            $dato['list_destino'] = $this->Model_Corporacion->get_list_destino();
            $this->load->view('Admin/Configuracion/Tramite/modal_editar',$dato);   
        }else{
            redirect('');
        }
    }

    public function Update_Tramite(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tramite']= $this->input->post("id_tramite"); 
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['nom_tramite']= $this->input->post("nom_tramite"); 
            $dato['cantidad_uso']= $this->input->post("cantidad_uso"); 
            $valida = $this->Model_Corporacion->valida_update_tramite($dato);
            if(count($valida)>0){
                echo "error";
            }else{
                $this->Model_Corporacion->update_tramite($dato);
            }
        }else{
            redirect('');
        }
    }

    public function Delete_Tramite(){
        if ($this->session->userdata('usuario')) {
            $dato['id_tramite']= $this->input->post("id_tramite");
            $this->Model_Corporacion->delete_tramite($dato);
        }else{
            redirect('');
        }
    }*/
}
