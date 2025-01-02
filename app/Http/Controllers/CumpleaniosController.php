<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Config;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $dato['list_anio'] = Anio::where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('rrhh.Cumpleanio.index',$dato);
    }
    public function Busqueda_Cumple(){
        $dato['cod_mes']= $this->input->post("cod_mes");
        $dato['list_cumple'] = $this->modelo->get_list_proximos_cumpleanios_admin($dato);
        $dato['conteo_mes'] = count($dato['list_cumple']);
        $dato['conteo'] = DB::table('users')
            ->where('estado', 1)
            ->whereBetween(DB::raw('MONTH(fec_nac)'), [now()->month, $dato['cod_mes']])
            ->count();
        $dato['conteoA'] = $dato['conteo']*1;
        $dato['conteoB'] = $dato['conteo']*1;
        $dato['conteoC'] = $dato['conteo']*3;
        //$dato['conteoT'] = $dato['conteo']*5;//suma de los anteriores
        $dato['inventario'] = DB::table('inventario_ofc')->where('estado', 1)->get();
        $dato['restanteA'] = $dato['inventario'][2]->cantidad - $dato['conteoA'];
        $dato['restanteB'] = $dato['inventario'][1]->cantidad - $dato['conteoB'];
        $dato['restanteC'] = $dato['inventario'][0]->cantidad - $dato['conteoC'];
        $dato['mesActual'] = Carbon::now()->locale('es')->translatedFormat('F'); // Obtiene el mes en español
        return view('rrhh.Cumpleanio.busqueda_cumple',$dato);
    }
}
