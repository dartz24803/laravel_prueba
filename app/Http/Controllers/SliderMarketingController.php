<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Base;
use App\Models\Config;


class SliderMarketingController extends Controller
{
    public function __construct(Request $request){
        //constructor con variables
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);
    }
    public function index() {
        $dato["slider"] = Slide::where('estado', 1)
                        ->where('id_area', 7)
                        ->get();
        $dato['list_base'] = Base::where('nom_base', 'LIKE', 'BASE%')
                        ->orderBy('nom_base', 'ASC')
                        ->get();
        $dato["config"] = Config::where('descrip_config', 'Slidecomercial')
                        ->get();
        //NOTIFICACIÓN-NO BORRAR
        /*
        $dato['list_noti'] = $this->Model_Corporacion->get_list_notificacion();
        $dato['list_nav_evaluaciones'] = $this->Model_Corporacion->get_list_nav_evaluaciones();*/

        return view("marketing/slider/body", $dato);
    }
}