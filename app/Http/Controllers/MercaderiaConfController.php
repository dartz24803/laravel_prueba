<?php

namespace App\Http\Controllers;

use App\Models\Model_Perfil;
use Illuminate\Http\Request;
use App\Models\Mercaderia;
use App\Models\Notificacion;
use App\Models\SubGerencia;

class MercaderiaConfController extends Controller
{
    protected $Model_Perfil;
    protected $input;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->Model_Perfil = new Model_Perfil();
        $this->input = $request;
    }
    
    public function TablaMercaderia(){
            //REPORTE BI CON ID
            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('Logistica.Administracion.mercaderia.tablalogistica',$dato);   
    }
/*
    public function Percha(){
            $dato['list_percha'] = $this->Model_Corporacion->get_list_percha($id_percha=null);
            return view('Admin/Configuracion/Logistica/Percha/index',$dato);   
    }

    public function Boton_Percha() {
        return view('Admin/Configuracion/Logistica/Percha/boton');
    }               

    public function Modal_Percha(){
            return view('Admin/Configuracion/Logistica/Percha/modal_registrar');
    }

    public function Insert_Percha(){
            $dato['nom_percha']= strtoupper($this->input->post("nom_percha"));
            $dato['mod']=1;
            $total=count($this->Model_Corporacion->valida_percha($dato));
            if($total>0){
                echo "error";
            }else{
                $this->Model_Corporacion->insert_percha($dato);
            }
    }

    public function Modal_Update_Percha($id_percha){
            $dato['get_id'] = $this->Model_Corporacion->get_list_percha($id_percha);
            return view('Admin/Configuracion/Logistica/Percha/modal_editar',$dato);   
    }

    public function Update_Percha(){
            $dato['id_percha'] =$this->input->post("id_percha");
            $dato['nom_percha']= strtoupper($this->input->post("nom_perchae"));
            $dato['mod']=2;
            $total=count($this->Model_Corporacion->valida_percha($dato));
            if($total>0){
                echo "error";
            }else{
                $this->Model_Corporacion->update_percha($dato);
            }
    }

    public function Delete_Percha(){
            $dato['id_percha']= $this->input->post("id_percha");
            $this->Model_Corporacion->delete_percha($dato);
    }

    //----------------nicho
    public function Nicho(){
            $dato['list_nicho'] = $this->Model_Corporacion->get_list_nicho($id_percha=null);
            $this->load->view('Admin/Configuracion/Logistica/Nicho/index',$dato);   
    }

    public function Boton_Nicho() {
        $this->load->view('Admin/Configuracion/Logistica/Nicho/boton');
    }               

    public function Modal_Nicho(){
            $dato['list_percha'] = $this->Model_Corporacion->get_list_percha($id_percha=null);
            $this->load->view('Admin/Configuracion/Logistica/Nicho/modal_registrar',$dato);
    }

    public function Insert_Nicho(){
            $dato['numero']= strtoupper($this->input->post("numero"));
            $dato['id_percha']=$this->input->post("id_percha");
            $dato['get_percha'] = $this->Model_Corporacion->get_list_percha($dato['id_percha']);
            $dato['nom_nicho']=$dato['get_percha'][0]['nom_percha'].$dato['numero'];
            $dato['mod']=1;
            $total=count($this->Model_Corporacion->valida_nicho($dato));
            if($total>0){
                echo "error";
            }else{
                $this->Model_Corporacion->insert_nicho($dato);
            }
    }

    public function Modal_Update_Nicho($id_nicho){
            $dato['get_id'] = $this->Model_Corporacion->get_list_nicho($id_nicho);
            $dato['list_percha'] = $this->Model_Corporacion->get_list_percha($id_percha=null);
            $this->load->view('Admin/Configuracion/Logistica/Nicho/modal_editar',$dato);   
    }

    public function Update_Nicho(){
            $dato['id_nicho'] =$this->input->post("id_nicho");
            $dato['id_percha']= $this->input->post("id_perchae");
            $dato['numero']= strtoupper($this->input->post("numeroe"));
            $dato['get_percha'] = $this->Model_Corporacion->get_list_percha($dato['id_percha']);
            $dato['nom_nicho']=$dato['get_percha'][0]['nom_percha'].$dato['numero'];
            $dato['mod']=2;
            $total=count($this->Model_Corporacion->valida_nicho($dato));
            if($total>0){
                echo "error";
            }else{
                $this->Model_Corporacion->update_nicho($dato);
            }
    }

    public function Delete_Nicho(){
            $dato['id_nicho']= $this->input->post("id_nicho");
            $this->Model_Corporacion->delete_nicho($dato);
    }*/
}
