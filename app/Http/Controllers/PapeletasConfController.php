<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Notificacion;
use App\Models\PermisoPapeletasSalida;
use App\Models\Puesto;
use App\Models\SubGerencia;
use App\Models\Tramite;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            
            return view('rrhh.administracion.papeletas.Destino.index',$dato);
    }
    
    public function Modal_Destino(){
            return view('rrhh.administracion.papeletas.Destino.modal_registrar');   
    }

    public function Insert_Destino(){
            $dato['id_motivo']= $this->input->post("id_motivo"); 
            $dato['nom_destino']= $this->input->post("nom_destino"); 
            $valida = Destino::where('id_motivo', $dato['id_motivo'])
                    ->where('nom_destino', $dato['nom_destino'])
                    ->where('estado', 1)
                    ->exists();
            if($valida){
                echo "error";
            }else{
                Destino::create([
                    'id_motivo' => $dato['id_motivo'],
                    'nom_destino' => $dato['nom_destino'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);
            }
    }

    public function Modal_Update_Destino($id_destino){
            $dato['get_id'] = Destino::where('id_destino', $id_destino)
                            ->get();
            return view('rrhh.administracion.papeletas.Destino.modal_editar',$dato);   
    }

    public function Update_Destino(){
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['id_motivo']= $this->input->post("id_motivo"); 
            $dato['nom_destino']= $this->input->post("nom_destino");
            $valida = Destino::where('id_motivo', $dato['id_motivo'])
                    ->where('nom_destino', $dato['nom_destino'])
                    ->where('estado', 1)
                    ->exists();
            if($valida){
                echo "error";
            }else{
                Destino::where('id_destino', $dato['id_destino'])
                    ->update([
                        'id_motivo' => $dato['id_motivo'],
                        'nom_destino' => $dato['nom_destino'],
                        'fec_act' => now(), // Fecha de actualización actual
                        'user_act' => session('usuario')->id_usuario, // Usuario que actualiza
                    ]);

            }
    }

    public function Delete_Destino(){
            $dato['id_destino']= $this->input->post("id_destino");
            Destino::where('id_destino', $dato['id_destino'])
                ->update([
                    'estado' => 2, // Cambiar estado a 2
                    'fec_eli' => now(), // Fecha de eliminación actual
                    'user_eli' => session('usuario')->id_usuario, // Usuario que elimina
                ]);
    }
    //------------------------------TRÁMITE-------------------------------
    
    public function Tramite(){
            $dato['list_tramite'] = Tramite::select(
                            'tramite.*', 
                            DB::raw("CASE 
                                        WHEN destino.id_motivo = 1 THEN 'Laboral' 
                                        WHEN destino.id_motivo = 2 THEN 'Personal' 
                                        ELSE '' 
                                    END AS nom_motivo"), 
                            'destino.nom_destino'
                        )
                        ->leftJoin('destino', 'destino.id_destino', '=', 'tramite.id_destino')
                        ->where('tramite.estado', 1)
                        ->get();
            return view('rrhh.administracion.papeletas.Tramite.index',$dato);
    }

    public function Modal_Tramite(){
            return view('rrhh.administracion.papeletas.Tramite.modal_registrar');
    }

    public function Traer_Destino(){
            $id_motivo = $this->input->post("id_motivo"); 
            $dato['list_destino'] = Destino::where('id_motivo', $id_motivo)
                                    ->where('estado', 1)
                                    ->get()
                                    ->toArray();
            return view('rrhh.administracion.papeletas.Tramite.destino',$dato);   
    }

    public function Insert_Tramite(){
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['nom_tramite']= $this->input->post("nom_tramite"); 
            $dato['cantidad_uso']= $this->input->post("cantidad_uso"); 
            $valida = Tramite::where('id_destino', $dato['id_destino'])
                ->where('nom_tramite', $dato['nom_tramite'])
                ->where('estado', 1)
                ->exists();
            if($valida){
                echo "error";
            }else{
                Tramite::create([
                    'id_destino' => $dato['id_destino'],
                    'nom_tramite' => $dato['nom_tramite'],
                    'cantidad_uso' => $dato['cantidad_uso'],
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);
            }
    }

    public function Modal_Update_Tramite($id_tramite){
            $dato['get_id'] = Tramite::select('tr.*', 'de.id_motivo')
                        ->from('tramite as tr')
                        ->leftJoin('destino as de', 'de.id_destino', '=', 'tr.id_destino')
                        ->where('tr.id_tramite', $id_tramite)
                        ->get();
            $dato['list_destino'] = Destino::select('*')
                                ->selectRaw("CASE 
                                                WHEN id_motivo = 1 THEN 'Laboral' 
                                                WHEN id_motivo = 2 THEN 'Personal' 
                                                ELSE '' 
                                            END AS nom_motivo")
                                ->where('estado', 1)
                                ->get();
            return view('rrhh.administracion.papeletas.Tramite.modal_editar',$dato);   
    }

    public function Update_Tramite(){
            $dato['id_tramite']= $this->input->post("id_tramite"); 
            $dato['id_destino']= $this->input->post("id_destino"); 
            $dato['nom_tramite']= $this->input->post("nom_tramite"); 
            $dato['cantidad_uso']= $this->input->post("cantidad_uso"); 
            $valida = Tramite::where('id_destino', $dato['id_destino'])
                ->where('nom_tramite', $dato['nom_tramite'])
                ->where('estado', 1)
                ->exists();
            
            if($valida){
                echo "error";
            }else{
                Tramite::where('id_tramite', $dato['id_tramite'])->update([
                    'id_destino' => $dato['id_destino'],
                    'nom_tramite' => $dato['nom_tramite'],
                    'cantidad_uso' => $dato['cantidad_uso'],
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);
            }
    }

    public function Delete_Tramite(){
            $dato['id_tramite']= $this->input->post("id_tramite");
            Tramite::where('id_tramite', $dato['id_tramite'])->update([
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ]);
    }

    public function Lista_Papeletas_Salida_seguridad(){
        if ($this->session->userdata('usuario')) {
            $dato['list_base'] = $this->Model_Corporacion->get_list_base_only();
            $dato['list_papeletas_salida'] = $this->Model_Corporacion->get_list_papeletas_salida(1);
            $dato['ultima_papeleta_salida_todo'] = count($this->Model_Corporacion->get_list_papeletas_salida_uno());
            //$dato['list_colaborador'] = $this->Model_Corporacion->get_list_colaboradort($id_usuario=null,$estado);
            $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
            $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
            $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
            if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $id_nivel==21 || $id_nivel==19 || $centro_labores==="CD" || $centro_labores==="OFC" || $centro_labores==="AMT"){
                
            }else{
                $dato['list_colaborador_control'] = $this->Model_Corporacion->get_list_usuarios_x_base($centro_labores);  
            }
            //NOTIFICACIÓN-NO BORRAR
            $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
            $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();
            $this->load->view('Admin/Configuracion/Papeletas_Salida_seguridad/index',$dato);
        }else{
            redirect('');
        }
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
