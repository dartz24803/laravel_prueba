<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Config;
use App\Models\FrasesInicio;
use App\Models\Notificacion;
use App\Models\SliderInicio;

class InicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $request;
    protected $modelo;
    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
    }
    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        // dd($subgerenciaId);
        $list_slider_inicio = SliderInicio::get();
        $list_frases = FrasesInicio::where('estado', 1)->get();
        $list_cumple = Usuario::get_list_proximos_cumpleanios();


        // Accesos a módulos en base a idsedeLaboral
        $idSedeLaboral = session('usuario')->id_sede_laboral;
        $acceso_tienda = ($idSedeLaboral == 6);


        $get_foto = Config::where('descrip_config', 'Foto_Colaborador')
            ->where('estado', 1)
            ->get();
        return view('inicio', compact('list_notificacion', 'list_cumple', 'get_foto', 'list_frases', 'list_slider_inicio', 'acceso_tienda'));
    }
    
    public function Modal_Ver_Todo_Cumpleanios(){
            $dato['list_cumple'] = Usuario::get_list_proximos_cumpleanios();
            $dato['get_foto'] = Config::where('descrip_config', 'Foto_Colaborador')
                        ->where('estado', 1)
                        ->get();
            return view('rrhh.Cumpleanio.modal_todos',$dato);
    }
}
