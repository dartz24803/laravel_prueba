<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Base;
use App\Models\Modulo;
use App\Models\Notificacion;
use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelomodulo;
    protected $modeloarea;
    protected $modelobase;/*
    protected $modelogravedada;
    protected $modelomotivoa;
    protected $modelotipoa;*/

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Tickets();
        $this->modelomodulo = new Modulo();
        $this->modeloarea = new Area();
        $this->modelobase = new Base();/*
        $this->modelogravedada = new Gravedad_Amonestacion();
        $this->modelomotivoa = new Motivo_Amonestacion();
        $this->modelotipoa = new Tipo_Amonestacion();*/
    }
    
    public function Tickets_Vista(){
            $dato['list_plataforma'] = $this->modelomodulo::select('id_modulo AS id_plataforma', 'nom_modulo AS nom_plataforma')
                                    ->where('estado', 1)
                                    ->get();
            $dato['list_base'] = $this->modelobase->get_list_base_only();
            $dato['list_area'] = $this->modeloarea->get_list_area();

            // print_r($dato['list_plataforma']);
            //NOTIFICACIÓN-NO BORRAR
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('Tickets.index',$dato);
    }
    
    public function Busqueda_Tickets_Admin($busq_plataforma,$busq_base,$busq_area,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
        $dato['plataforma']=$busq_plataforma;
        $dato['base']=$busq_base;
        $dato['area']=$busq_area;
        $dato['cpiniciar']=$cpiniciar;
        $dato['cproceso']=$cproceso;
        $dato['cfinalizado']=$cfinalizado;
        $dato['cstandby']=$cstandby;
        $dato['list_tickets_usu'] = $this->modelo->get_list_tickets($dato);

        return view('Tickets.lista_tickets',$dato);
    }

    
    public function Busqueda_Tickets($busq_plataforma,$cpiniciar,$cproceso,$cfinalizado,$cstandby){
            $dato['plataforma']=$busq_plataforma;
            $dato['cpiniciar']=$cpiniciar;
            $dato['cproceso']=$cproceso;
            $dato['cfinalizado']=$cfinalizado;
            $dato['cstandby']=$cstandby;
            $dato['list_tickets_usu'] = $this->modelo->get_list_tickets_usuario($dato);

            return view('Tickets.lista_tickets',$dato);
    }
}
