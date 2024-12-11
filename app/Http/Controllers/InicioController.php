<?php

namespace App\Http\Controllers;

use App\Models\BolsaTrabajo;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Config;
use App\Models\FrasesInicio;
use App\Models\Notificacion;
use App\Models\SaludoTemporal;
use App\Models\SliderInicio;
use Illuminate\Support\Facades\DB;

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
        $list_slider_inicio = SliderInicio::get();
        $list_frases = FrasesInicio::where('estado', 1)->get();
        $list_cumple = Usuario::get_list_proximos_cumpleanios();
        // Accesos a módulos en base a idsedeLaboral
        $idSedeLaboral = session('usuario')->id_sede_laboral;
        $acceso_tienda = ($idSedeLaboral == 6);
        $get_foto = Config::where('descrip_config', 'Foto_Colaborador')
                    ->where('estado', 1)
                    ->get();
        $get_id = Usuario::select(DB::raw("CASE WHEN DATE_FORMAT(fec_nac,'%m-%d')=DATE_FORMAT(NOW(),'%m-%d') 
                THEN 1 ELSE 0 END AS cumple_anio"))->where('id_usuario',session('usuario')->id_usuario)
                ->first();
        $list_bolsa_trabajo = BolsaTrabajo::where('estado',1)->where('publicado',1)
                            ->where('cod_base',session('usuario')->centro_labores)
                            ->orderBy('orden','ASC')->get();
        $url_bt = Config::where('descrip_config','Slide_Bolsa_Trabajo')->first();
        return view('inicio', compact(
            'list_notificacion', 
            'list_slider_inicio', 
            'list_frases', 
            'list_cumple', 
            'acceso_tienda',
            'get_foto',
            'get_id',
            'list_bolsa_trabajo',
            'url_bt'
        ));
    }
    
    public function Modal_Ver_Todo_Cumpleanios(){
            $dato['list_cumple'] = Usuario::get_list_proximos_cumpleanios();
            $dato['get_foto'] = Config::where('descrip_config', 'Foto_Colaborador')
                        ->where('estado', 1)
                        ->get();
            return view('rrhh.Cumpleanio.modal_todos',$dato);
    }

    public function modal_cumpleanio(){
        $get_id = SaludoTemporal::where('id_usuario',session('usuario')->id_usuario)->first();
        return view('modal_cumpleanio',compact('get_id'));
    }
}
