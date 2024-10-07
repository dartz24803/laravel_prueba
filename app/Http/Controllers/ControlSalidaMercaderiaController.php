<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\ControlMercaderiaActivo;
use App\Models\Mercaderia;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;

class ControlSalidaMercaderiaController extends Controller
{
    protected $input;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
    }

    public function index() {
        $dato['list_base'] = Base::get_list_bases();
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('logistica.Control_Mercaderia_Activo.index', $dato);
    }

    public function Buscar_Control_Mercaderia_Activo(){
        $this->input->validate([
            'f_inicio' => 'required',
            'f_fin' => 'required',
            'base' => 'not_in:0',
        ], [
            'base' => 'Debe escoger base.',
            'f_inicio' =>  'Debe escoger fecha inicio',
            'f_fin' => 'Debe escoger fecha fin',
        ]);
            $dato['base']= $this->input->post("base");
            $dato['f_inicio']= str_replace('-', '', $this->input->post("f_inicio"));
            $dato['f_fin']= str_replace('-', '',$this->input->post("f_fin"));
            $dato['tvista']= $this->input->post("tvista");
            $dato['list_reporte'] = Mercaderia::buscar_control_mercaderia_activo($dato);
            $dato['list_reporte_ln1'] = ControlMercaderiaActivo::list_control_mercaderia_activo_ln1($dato);
            return view('logistica.Control_Mercaderia_Activo.lista', $dato);
    }
/*
    public function Modal_Update_Control_Mercaderia_Activo($Doc_Despacho){
        if ($this->session->userdata('usuario')) {
            $dato['Doc_Despacho']=str_replace('_', ' ',$Doc_Despacho);
            $dato['get_id'] = $this->Model_Logistica->get_list_control_mercaderia_activo($dato['Doc_Despacho']);
            $this->load->view('Logistica/Control_Mercaderia_Activo/modal_estado', $dato);
        }
        else{
            redirect('');
        }
    }*/

    public function Update_Estado_Control_Mercaderia_Activo(){
            $dato['estado_control']= $this->input->post("estado_control")+1;
            $dato['doc_despacho']=str_replace('_', ' ',$this->input->post("doc_despacho"));
            $cant = ControlMercaderiaActivo::where('doc_despacho', $dato['doc_despacho'])
                ->where('estado', 1)
                ->exists();

            $id_usuario = session('usuario')->id_usuario;
            if($cant){
                $controlMercaderia = ControlMercaderiaActivo::where('doc_despacho', $dato['doc_despacho'])
                                                            ->where('estado', 1)
                                                            ->first();

                if ($controlMercaderia) {
                    $controlMercaderia->estado_control = $dato['estado_control'];

                    // Conditionally set the user and timestamp based on estado_control
                    if ($dato['estado_control'] == 2) {
                        $controlMercaderia->user_conf_salida = $id_usuario;
                        $controlMercaderia->fec_conf_salida = now();
                    } elseif ($dato['estado_control'] == 3) {
                        $controlMercaderia->user_conf_recepcion = $id_usuario;
                        $controlMercaderia->fec_conf_recepcion = now();
                    }

                    $controlMercaderia->user_act = $id_usuario;
                    $controlMercaderia->fec_act = now();
                    $controlMercaderia->save(); // Save the updated record
                }
            }else{
                ControlMercaderiaActivo::create([
                    'estado_control' => $dato['estado_control'],
                    'user_conf_salida' => $id_usuario,
                    'fec_conf_salida' => now(),
                    'doc_despacho' => $dato['doc_despacho'],
                    'estado' => 1,
                    'user_reg' => $id_usuario,
                    'fec_reg' => now(),
                    'user_conf_recepcion' => 0,
                ]);
            }
    }
}
