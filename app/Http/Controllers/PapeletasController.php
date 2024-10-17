<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Destino;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\PermisoPapeletasSalida;
use App\Models\SolicitudesUser;
use App\Models\SubGerencia;
use App\Models\Tramite;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PapeletasController extends Controller
{
    
    protected $input;
    protected $Model_Solicitudes;
    protected $Model_Permiso;
    protected $Model_Perfil;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Solicitudes = new SolicitudesUser();
        $this->Model_Permiso = new PermisoPapeletasSalida();
        $this->Model_Perfil = new Model_Perfil();
    }
    
    public function Lista_Papeletas_Salida_seguridad(){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
                return view('rrhh.Papeletas_Salida_seguridad.index',$dato);
    }

    public function Buscar_Papeleta_Registro(){
        $dato['list_base'] = Base::get_list_base_only();
        $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida(1);
        $dato['ultima_papeleta_salida_todo'] = count($this->Model_Solicitudes->get_list_papeletas_salida_uno());

        if(session('usuario')->id_puesto!=23 || session('usuario')->id_puesto!=26 || session('usuario')->id_puesto!=128 || 
        session('usuario')->id_nivel!=1 || session('usuario')->id_nivel!=21 || session('usuario')->id_nivel!=19 || 
        session('usuario')->centro_labores!=="CD" || session('usuario')->centro_labores!=="OFC" || session('usuario')->centro_labores!=="AMT"){
            $dato['list_colaborador_control'] = Usuario::where('centro_labores', session('usuario')->centro_labores)
                                            ->where('estado', 1)
                                            ->get();
        }
        return view('rrhh.Papeletas_Salida.Registro.index', $dato);
    }

    

    public function Buscar_Estado_Solicitud_Papeletas_Salida_Usuario(){
            $estado_solicitud = $this->input->post("estado_solicitud");

            //$this->Model_Corporacion->verificacion_papeletas();
            
            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida($estado_solicitud);
            
            return view('rrhh.Papeletas_Salida.registro.lista_colaborador', $dato);
    }
    
    public function Modal_Papeletas_Salida($parametro){
            $dato['parametro']=$parametro;
            $centro_labores = session('usuario')->centro_labores;
            $lista_puesto_gest_array = $this->Model_Permiso->permiso_pps_puestos_gest_dinamico();
            $separado_por_comas_puestos = implode(",", array_column($lista_puesto_gest_array, 'id_puesto_permitido'));

            if($dato['parametro']==1){
                $dato['list_vendedor'] = Usuario::get_list_vendedor($centro_labores, $separado_por_comas_puestos);
            }

            return view('rrhh.Papeletas_Salida.registro.modal_registrar', $dato);   
    }
    
    public function Cambiar_Motivo(){
            $dato['id_motivo'] = $this->input->post("id_motivo");
            $dato['list_destino'] = Destino::where('id_motivo', $dato['id_motivo'])
                                ->get();
            return view('rrhh.Papeletas_Salida.registro.destino', $dato);   
    }
    
    public function Traer_Tramite(){
            $id_destino = $this->input->post("id_destino");
            $dato['list_tramite'] = Tramite::where('id_destino', $id_destino)
                                ->get();
            return view('rrhh.Papeletas_Salida.registro.tramite', $dato);   
    }

    public function Buscar_Papeletas_Salida_Gestion(){
            $estado_solicitud = $this->input->post("estado_solicitud");
            $fecha_revision = $this->input->post("fecha_revision");
            $fecha_revision_fin = $this->input->post("fecha_revision_fin");
            $lista_puesto_gest_array = $this->Model_Permiso->permiso_pps_puestos_gest_dinamico();
            $separado_por_comas_puestos = implode(",", array_column($lista_puesto_gest_array, 'id_puesto_permitido'));

            //$this->Model_Corporacion->verificacion_papeletas();

            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida_gestion($estado_solicitud,$fecha_revision, $fecha_revision_fin, $separado_por_comas_puestos);
            $dato['acciones']=1;

            return view('rrhh.Papeletas_Salida_gerencia.lista_colaborador', $dato);
    }

    public function Buscar_Base_Papeletas_Seguridad(){
            //$this->Model_Corporacion->verificacion_papeletas();
            
            $id_puesto = session('usuario')->id_puesto;
            $estado_solicitud = $this->input->post("estado_solicitud");
            $fecha_revision = $this->input->post("fecha_revision");
            $fecha_revision_fin = $this->input->post("fecha_revision_fin");
            $num_doc = $this->input->post("num_doc");
            $id_nivel = session('usuario')->id_nivel;
            $centro_labores = session('usuario')->centro_labores;
    
            if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $centro_labores=="CD" || $centro_labores=="OFC" || $centro_labores=="AMT"){
                $base=$this->input->post("base");
            }else{
                $base = session('usuario')->centro_labores;
            }
            $dato['list_papeletas_salida'] = $this->Model_Solicitudes->get_list_papeletas_salida_seguridad($base,$estado_solicitud,$fecha_revision,$fecha_revision_fin,$num_doc);
    
            return view('rrhh.Papeletas_Salida_seguridad.lista_colaborador', $dato);
    }

    public function Insert_or_Update_Papeletas_Salida() {
            $id_solicitudes_user= $this->input->post("id_solicitudes_user");
            $dato['parametro']= $this->input->post("parametro");
            $colaborador= $this->input->post("colaborador_p");

            if($id_solicitudes_user == null && $dato['parametro']!=1){
                //USUARIOS PARA NOTIFICACION
                $get_gerente = Usuario::select('users.id_usuario', 'users.usuario_nombres', 'users.usuario_apater', 'users.usuario_amater', 'users.emailp', 'users.id_gerencia', 'puesto.nom_puesto')
                        ->leftJoin('puesto', 'puesto.id_puesto', '=', 'users.id_puesto')
                        ->where('users.estado', 1)
                        ->where('users.id_gerencia', session('usuario')->id_gerencia)
                        ->where('puesto.nom_puesto', 'LIKE', 'GERENTE %')
                        ->get()
                        ->toArray();
                $dato['id_responsable']=$get_gerente[0]['id_usuario'];
                Notificacion::create([
                    'id_usuario' => $dato['id_responsable'],
                    'solicitante' => session('usuario')->id_usuario,
                    'id_tipo' => 7,
                    'leido' => 0,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                ]);

                $get_puestos = $this->Model_Permiso::where('id_puesto_permitido')
                            ->get();
                $i=0;
                while($i<count($get_puestos)){
                    $dato['id_puesto_jefe']=$get_puestos[$i]['id_puesto_jefe'];
                    $get_usuarios = Usuario::where('id_puesto', $dato['id_puesto_jefe'])
                                ->get();
                    $j=0;
                    while($j<count($get_usuarios)){
                        $dato['id_responsable']=$get_usuarios[$j]['id_usuario'];
                        Notificacion::create([
                            'id_usuario' => $dato['id_responsable'],
                            'solicitante' => session('usuario')->id_usuario,
                            'id_tipo' => 7,
                            'leido' => 0,
                            'estado' => 1,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                        ]);     
                        $j++;
                    }
                    $i++;
                }
            }
            
            if ($id_solicitudes_user == null){
                $dato['id_motivo']= $this->input->post("id_motivo");
                $dato['destino']= $this->input->post("destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_destino']= $this->input->post("especificacion_destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_tramite']= $this->input->post("especificacion_tramite");
                $dato['hora_retorno']= $this->input->post("hora_retorno");
                $dato['hora_salida']= $this->input->post("hora_salida");
                $dato['fec_solicitud']= $this->input->post("fec_solicitud");
                $dato['sin_ingreso'] = $this->input->post("sin_ingreso") ?: 0;
                $dato['sin_retorno'] = $this->input->post("sin_retorno") ?: 0;
                $dato['otros']= $this->input->post("otros");

                if($dato['parametro']==0){
                    $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
                        ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
                        ->count();

                    $aniof=date('Y');
                    if($totalt<9){
                        $codigofinal='PP'.$aniof."0000".($totalt+1);
                    }
                    if($totalt>8 && $totalt<99){
                        $codigofinal='PP'.$aniof."000".($totalt+1);
                    }
                    if($totalt>98 && $totalt<999){
                        $codigofinal='PP'.$aniof."00".($totalt+1);
                    }
                    if($totalt>998 && $totalt<9999){
                        $codigofinal='PP'.$aniof."0".($totalt+1);
                    }
                    if($totalt>9998){
                        $codigofinal='PP'.$aniof.($totalt+1);
                    }
                    $dato['cod_solicitud']=$codigofinal;

                    $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                    $validar_insert = $this->Model_Solicitudes->validar_insert_papeletas_salida($dato);

                    if(count($validar_insert)>=$get_tramite[0]['cantidad_uso']){
                        echo "error";
                    }else{
                        $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                    }
                }else{
                    $ico= count($colaborador);
                    $co=0;

                    do{
                        $dato['colaborador']=$colaborador[$co];
        
                        $traer_datos = $this->Model_Perfil->get_id_usuario($dato['colaborador']);
        
                        $dato['centro_labores'] = $traer_datos[0]['centro_labores'];
        
                        $totalt = $this->Model_Solicitudes::where('id_solicitudes', 2)
                            ->whereRaw("SUBSTR(cod_solicitud, 3, 4) = ?", [date('Y')])
                            ->count();
                        $aniof=date('Y');
                        if($totalt<9){
                            $codigofinal='PP'.$aniof."0000".($totalt+1);
                        }
                        if($totalt>8 && $totalt<99){
                            $codigofinal='PP'.$aniof."000".($totalt+1);
                        }
                        if($totalt>98 && $totalt<999){
                            $codigofinal='PP'.$aniof."00".($totalt+1);
                        }
                        if($totalt>998 && $totalt<9999){
                            $codigofinal='PP'.$aniof."0".($totalt+1);
                        }
                        if($totalt>9998){
                            $codigofinal='PP'.$aniof.($totalt+1);
                        }
                        $dato['cod_solicitud']=$codigofinal;
        
                        $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                        $validar_insert = $this->Model_Solicitudes->validar_insert_papeletas_salida($dato);
    
                        if(count($validar_insert)>=$get_tramite[0]['cantidad_uso']){
                            echo "error";
                        }else{
                            $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                        }

                        $co=$co + 1;
                    }while($co < $ico);
                }
            }else{
                $get_id = $this->Model_Solicitudes->get_id_papeletas_salida($id_solicitudes_user);
                $dato['id_solicitudes_user']= $this->input->post("id_solicitudes_user");
                $dato['id_motivo']= $this->input->post("id_motivo");
                $dato['destino']= $this->input->post("destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_destino']= $this->input->post("especificacion_destino");
                $dato['tramite']= $this->input->post("tramite");
                $dato['especificacion_tramite']= $this->input->post("especificacion_tramite");
                $dato['hora_salida']= $this->input->post("hora_salida");
                $dato['hora_retorno']= $this->input->post("hora_retorno");
                $dato['fec_solicitud']= $this->input->post("fec_solicitud");
                $dato['sin_ingreso']= $this->input->post("sin_ingreso");
                $dato['sin_retorno']= $this->input->post("sin_retorno");
                $dato['otros']= $this->input->post("otros");

                if($dato['id_motivo']==3){
                    $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                }else{
                    $dato['id_usuario'] = $get_id[0]['id_usuario'];
                    $get_tramite = Tramite::get_list_tramite($dato['tramite']);
                    $validar_update = SolicitudesUser::where('id_solicitudes_user', '!=', $dato['id_solicitudes_user'])
                                ->where('id_usuario', $dato['id_usuario'])
                                ->where('fec_solicitud', $dato['fec_solicitud'])
                                ->where('tramite', $dato['tramite'])
                                ->where('estado', 1)
                                ->get();

                    if(count($validar_update)>=$get_tramite[0]['cantidad_uso']){
                        echo "error";
                    }else{
                        $this->Model_Solicitudes->insert_or_update_papeletas_salida($dato,$id_solicitudes_user);
                    }   
                }
            }
    }
//especifique no obligatorio

    /*
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
