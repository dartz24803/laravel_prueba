<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;

class SliderRRHH extends Controller{

    public function __construct() {
        /*$this->middleware('verificar.sesion.usuario');
        parent::__construct();
        $this->load->database();
        $this->load->model('Model_Recursos_Humanos');
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->library("parser");
        $this->load->library('form_validation');
        $this->load->helper("url");
        $this->load->helper('form');
        $this->load->helper('text');
        $this->load->helper("post_helper");
        $this->load->helper("date_helper");
        $this->load->helper('string');
        $this->load->helper('text');*/
    }

    public function remap($method){
        if (strpos($method, '__') !== false) {
        
            $array = explode("__", $method);
            if (count($array) != 2) {
                abort(404, 'Method format is invalid.');
            }
        
            $funcioncontrolador = base64_decode($array[0]);
        
            switch ($funcioncontrolador) {
                case "Slider_Vista_RRHH":
                    $base = base64_decode($array[1]);
                    return $this->Slider_Vista_RRHH($base);
                default:
                    abort(404, 'Method not found.');
            }
        } else {
            $funcioncontrolador = base64_decode($method);
        
            switch ($funcioncontrolador) {
                case "Slider_Vista_Tienda":
                    return $this->Slider_Vista_Tienda();
                default:
                    abort(404, 'Method not found.');
            }
        }
    }
    

    public function Slider_Vista_RRHH($base) {
        $slider = Slide::where('estado', 1)
                    ->where('id_area', 11)
                    ->where('base', $base)
                    ->get();
        return view("rrhh.Comunicado.slider", compact('slider'));
    }
    public function Slider_Vista_Tienda() {
        $slider = Slide::where('estado', 1)
                ->where('id_area', 11)
                ->whereIn('tipo', [2])
                ->orderBy('orden', 'ASC')
                ->get();
        return view("rrhh.Comunicado.slider", compact('slider'));
    }

}
