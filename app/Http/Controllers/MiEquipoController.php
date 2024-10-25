<?php

namespace App\Http\Controllers;

use App\Models\AsignacionJefatura;
use App\Models\Base;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;

class MiEquipoController extends Controller
{
    protected $input;
    protected $Model_Asignacion;
    // protected $Model_Permiso;
    // protected $Model_Perfil;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Asignacion = new AsignacionJefatura();
        // $this->Model_Permiso = new PermisoPapeletasSalida();
        // $this->Model_Perfil = new Model_Perfil();
    }
    public function ListaMiequipo() {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
            return view('rrhh.Mi_equipo.index', compact('list_subgerencia', 'list_notificacion'));
    }

    public function Cargar_Mi_Equipo(){ 
            $dato['lista_bases'] = Base::select('cod_base')
                        ->where('estado', '1')
                        ->distinct()
                        ->orderBy('cod_base', 'asc')
                        ->get();
            return view('rrhh.Mi_equipo.mi_equipo',$dato);
    }

    public function Cargar_Bases_Equipo($busq_base){ 
            $centro_labores = session('usuario')->centro_labores;
            $id_puesto = session('usuario')->id_puesto;

            $dato['list_ajefatura'] = $this->Model_Asignacion->get_list_ajefatura_puesto($id_puesto);

            $result="";

            foreach($dato['list_ajefatura'] as $char){
                $result.= $char['id_puesto_permitido'].",";
            }

            $cadena = substr($result, 0, -1);

            $dato['cadena'] = "(".$cadena.")";

            $data['base']=$busq_base;
            $dato['colaborador_porcentaje'] = Usuario::colaborador_porcentaje(0,$centro_labores,$dato,$data);

            
            return view('rrhh.Mi_equipo.lista_equipo',$dato);
    }
}
