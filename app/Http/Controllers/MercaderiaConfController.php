<?php

namespace App\Http\Controllers;

use App\Models\Model_Perfil;
use Illuminate\Http\Request;
use App\Models\Mercaderia;
use App\Models\Nicho;
use App\Models\Notificacion;
use App\Models\Percha;
use App\Models\SubGerencia;
use Illuminate\Support\Facades\DB;

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
            return view('logistica.administracion.mercaderia.tablalogistica',$dato);
    }

    public function Percha(){
            $dato['list_percha'] = Percha::where('estado',1)
                            ->get();
            return view('logistica.administracion.mercaderia.Percha.index',$dato);
    }

    public function Modal_Percha(){
            return view('logistica.administracion.mercaderia.Percha.modal_registrar');
    }

    public function Insert_Percha(){
        $this->input->validate([
            'nom_percha' => 'required',
        ], [
            'nom_percha.not_in' => 'Debe escribir descripcion de percha.',
        ]);
            $dato['nom_percha']= strtoupper($this->input->post("nom_percha"));
            $total= Percha::where('nom_percha', $dato['nom_percha'])
                ->where('estado', 1)
                ->exists();
            if($total){
                echo "error";
            }else{
                $dato['estado'] = 1;
                $dato['fec_reg'] = now();
                $dato['fec_act'] = now();
                $dato['user_act'] = session('usuario')->id_usuario;
                $dato['user_reg'] = session('usuario')->id_usuario;
                Percha::create($dato);
            }
    }

    public function Modal_Update_Percha($id_percha){
            $dato['get_id'] = Percha::where('id_percha', $id_percha)
                        ->get();
            return view('logistica.administracion.mercaderia.Percha.modal_editar',$dato);
    }

    public function Update_Percha(){
            $id_percha =$this->input->post("id_percha");
            $dato['nom_percha']= strtoupper($this->input->post("nom_perchae"));
            $total = Percha::where('nom_percha', $dato['nom_percha'])
                ->where('id_percha', '!=', $id_percha)
                ->where('estado', 1)
                ->exists();
            if($total){
                echo "error";
            }else{
                $dato['fec_act'] = now();
                $dato['user_act'] = session('usuario')->id_usuario;
                Percha::where('id_percha', $id_percha)->update($dato);
            }
    }

    public function Delete_Percha(){
            $id_percha= $this->input->post("id_percha");
            $dato['estado'] = 2;
            $dato['fec_eli'] = now();
            $dato['user_eli'] = session('usuario')->id_usuario;
            Percha::findOrFail($id_percha)->update($dato);
    }

    //----------------nicho
    public function Nicho(){
            $dato['list_nicho'] = Nicho::select('nicho.*', 'percha.nom_percha',
                DB::raw("CONCAT(percha.nom_percha, nicho.numero) as nicho"))
                ->leftJoin('percha', 'nicho.id_percha', '=', 'percha.id_percha')
                ->where('nicho.estado', 1)
                ->orderBy('nicho.nom_nicho')
                ->get();
            return view('logistica.administracion.mercaderia.Nicho.index',$dato);
    }


    public function Modal_Nicho(){
        $dato['list_percha'] = Percha::where('estado',1)
                        ->get();
        return view('logistica.administracion.mercaderia.Nicho.modal_registrar',$dato);
    }

    public function Insert_Nicho(){
            $this->input->validate([
                'id_percha' => 'not_in:0',
                'numero' => 'required',
            ], [
                'id_percha' => 'Debe escoger percha.',
                'numero' =>  'Debe ingresar número',
            ]);
            $dato['numero']= strtoupper($this->input->post("numero"));
            $dato['id_percha'] = $this->input->post("id_percha");
            $dato['get_percha'] = Percha::where('id_percha', $dato['id_percha'])
                        ->get();
            $dato['nom_nicho']=$dato['get_percha'][0]['nom_percha'].$dato['numero'];

            $total = Nicho::where('nom_nicho',$dato['nom_nicho'])
                ->where('id_percha', $dato['id_percha'])
                ->where('estado', 1)
                ->exists();

            if($total){
                echo "error";
            }else{
                $dato['estado'] = 1;
                $dato['fec_reg'] = now();
                $dato['fec_act'] = now();
                $dato['user_act'] = session('usuario')->id_usuario;
                $dato['user_reg'] = session('usuario')->id_usuario;
                Nicho::create($dato);
            }
    }

    public function Modal_Update_Nicho($id_nicho){
        $dato['get_id'] = Nicho::select('nicho.*', 'percha.nom_percha')
            ->leftJoin('percha', 'nicho.id_percha', '=', 'percha.id_percha')
            ->where('nicho.id_nicho', $id_nicho)
            ->get();

        $dato['list_percha'] = Percha::where('estado',1)
                    ->get();

        return view('logistica.administracion.mercaderia.Nicho.modal_editar',$dato);
    }

    public function Update_Nicho(){
            $this->input->validate([
                'id_perchae' => 'not_in:0',
                'numeroe' => 'required',
            ], [
                'id_perchae' => 'Debe escoger percha.',
                'numeroe' =>  'Debe ingresar número',
            ]);
            $id_nicho =$this->input->post("id_nicho");
            $dato['id_percha']= $this->input->post("id_perchae");
            $dato['numero']= strtoupper($this->input->post("numeroe"));
            $get_percha = Percha::where('id_percha', $dato['id_percha'])
                                ->get();
            $dato['nom_nicho']=$get_percha[0]['nom_percha'].$dato['numero'];
            $total = Nicho::where('nom_nicho', $dato['nom_nicho'])
                ->where('id_percha', $dato['id_percha'])
                ->where('id_nicho', '!=', $id_nicho)
                ->where('estado', 1)
                ->exists();
            if($total>0){
                echo "error";
            }else{
                $dato['fec_act'] = now();
                $dato['user_act'] = session('usuario')->id_usuario;
                Nicho::where('id_nicho', $id_nicho)->update($dato);
            }
    }

    public function Delete_Nicho(){
        $id_nicho= $this->input->post("id_nicho");
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        Nicho::findOrFail($id_nicho)->update($dato);
    }
}
