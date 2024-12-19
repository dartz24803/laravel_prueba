<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CumpleaniosController extends Controller
{
    protected $input;
    protected $modelo;

    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->modelo = new Usuario();
    }

    public function index(){
        $dato['get_foto'] = Config::where('descrip_config','Foto_Colaborador')
                        ->where('estado', 1)
                        ->first();
        $dato['list_mes'] = Mes::where('estado',1)->get();
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('rrhh.Cumpleanio.index',$dato);
    }
    public function Busqueda_Cumple(){
        $dato['cod_mes']= $this->input->post("cod_mes");
        $dato['list_cumple'] = $this->modelo->get_list_proximos_cumpleanios_admin($dato);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('rrhh.Cumpleanio.busqueda_cumple',$dato);
    }
}
