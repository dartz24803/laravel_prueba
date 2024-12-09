<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\CalendarioLogistico;
use App\Models\InvitadoCalendario;
use App\Models\Notificacion;
use App\Models\ProveedorGeneral;
use App\Models\PuestoInvitadoCalendarioLogistico;
use App\Models\TipoCalendarioLogistico;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarioLogisticoController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();    
        $list_tipo_calendario_todo = TipoCalendarioLogistico::all();
        $list_proveedor = DB::connection('sqlsrv')->table('tge_entidades')->where('clp_tipenti','PR')
                        ->where('clp_estado','!=','*')->get();
        $list_proveedor_taller = ProveedorGeneral::select('id_proveedor','nombre_proveedor')->where('id_proveedor_mae',2)
                                ->where('estado',1)->get();
        $list_proveedor_tela = ProveedorGeneral::select('id_proveedor','nombre_proveedor')->where('id_proveedor_mae',1)
                            ->where('estado',1)->get();
        $list_base = Base::get_list_todas_bases_agrupadas();
        if(session('usuario')->id_nivel=="1"){
            $list_tipo_calendario = TipoCalendarioLogistico::all();
        }elseif(session('usuario')->id_puesto=="83" ||
        session('usuario')->id_puesto=="122" ||
        session('usuario')->id_puesto=="195"){
            $list_tipo_calendario = TipoCalendarioLogistico::where('id_tipo_calendario',3)->get();
        }elseif(session('usuario')->id_puesto=="75"){
            $list_tipo_calendario = TipoCalendarioLogistico::whereIn('id_tipo_calendario',[1,2])->get();
        }
        return view('calendario_logistico.index',compact(
            'list_notificacion',
            'list_tipo_calendario_todo',
            'list_proveedor',
            'list_proveedor_taller',
            'list_proveedor_tela',
            'list_base',
            'list_tipo_calendario'
        ));
    }

    public function list()
    {
        $list_calendario = CalendarioLogistico::from('calendario_logistico AS cl')
                        ->select('cl.*','tc.color','pr.nombre_proveedor')
                        ->join('tipo_calendario_logistico AS tc','tc.id_tipo_calendario','=','cl.id_tipo_calendario')
                        ->leftjoin('proveedor AS pr','cl.id_proveedor','=','pr.id_proveedor')
                        ->where(DB::raw("YEAR(cl.fec_de)"),"=",DB::raw("YEAR(CURDATE())"))->where('cl.invitacion',0)
                        ->where('cl.estado',1)->get();
        $list_proveedor = DB::connection('sqlsrv')->table('tge_entidades')->where('clp_tipenti','PR')
                        ->where('clp_estado','!=','*')->get();
        //CONVERTIR EN ARRAY
        $list_proveedor = json_decode(json_encode($list_proveedor), true);
        $list_proveedor_taller = ProveedorGeneral::select('id_proveedor','nombre_proveedor')->where('id_proveedor_mae',2)
                                ->where('estado',1)->get()->toArray();
        $list_proveedor_tela = ProveedorGeneral::select('id_proveedor','nombre_proveedor')->where('id_proveedor_mae',1)
                            ->where('estado',1)->get()->toArray();                        
        return view('calendario_logistico.lista',compact(
            'list_calendario',
            'list_proveedor',
            'list_proveedor_taller',
            'list_proveedor_tela'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start-date' => 'required',
            'end-date' => 'required|after:start-date',
            'task' => 'required',
            'taskdescription' => 'required',
            'id_proveedor' => 'not_in:0',
            'cod_base' => 'not_in:0',
            'id_tipo_calendario' => 'required'
        ], [
            'start-date.required' => 'Debe ingresar fecha inicial.',
            'end-date.required' => 'Debe ingresar fecha final.',
            'end-date.after' => 'La fecha final debe ser mayor que la fecha inicial.',
            'task.required' => 'Debe ingresar título.',
            'taskdescription.required' => 'Debe ingresar descripción.',
            'id_proveedor.not_in' => 'Debe seleccionar proveedor.',
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_tipo_calendario.required' => 'Debe seleccionar tipo.'
        ]);

        if(session('usuario')->id_puesto=="83" ||
        session('usuario')->id_puesto=="122"){
            $id_tipo_calendario = 3;
        }else{
            $id_tipo_calendario = $request->id_tipo_calendario;
        }

        $array = explode("-",$request->id_proveedor);
        $id_proveedor = $array[0];
        $infosap = $array[1];

        if(date_format(date_create($request->input('start-date')), 'Y-m-d')>date('Y-m-d')){
            $estado_interno =1;
        }else{
            $estado_interno =2;
        }

        $id_usuario = session('usuario')->id_usuario;
        if(session('usuario')->id_nivel=="1"){
            if($request->id_tipo_calendario==1 || $request->id_tipo_calendario==2){
                //SUPERVISOR DE COMPRAS E INGRESOS
                $get_usuario = Usuario::select('id_usuario')->where('id_puesto',75)
                            ->orderBy('id_usuario','DESC')->first();
                if($get_usuario){
                    $id_usuario = $get_usuario->id_usuario;
                }
            }else{
                //JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN
                $get_usuario = Usuario::select('id_usuario')->where('id_puesto',122)
                            ->orderBy('id_usuario','DESC')->first();
                if($get_usuario){
                    $id_usuario = $get_usuario->id_usuario;
                }
            }
        }

        CalendarioLogistico::create([
            'id_usuario' => $id_usuario,
            'id_proveedor' => $id_proveedor,
            'infosap' => $infosap,
            'titulo' => $request->task,
            'fec_de' => $request->input('start-date'),
            'fec_hasta' => $request->input('end-date'),
            'descripcion' => $request->taskdescription,
            'id_tipo_calendario' => $id_tipo_calendario,
            'invitacion' => 0,
            'base' => $request->cod_base,
            'estado_reporte' => 1,
            'estado_interno' => $estado_interno,
            'cant_prendas' => $request->cant_prendas,
            'flag' => 0,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start-date' => 'required',
            'end-date' => 'required|after:start-date',
            'task' => 'required',
            'taskdescription' => 'required',
            'id_proveedor' => 'not_in:0',
            'cod_base' => 'not_in:0',
            'id_tipo_calendario' => 'required'
        ], [
            'start-date.required' => 'Debe ingresar fecha inicial.',
            'end-date.required' => 'Debe ingresar fecha final.',
            'end-date.after' => 'La fecha final debe ser mayor que la fecha inicial.',
            'task.required' => 'Debe ingresar título.',
            'taskdescription.required' => 'Debe ingresar descripción.',
            'id_proveedor.not_in' => 'Debe seleccionar proveedor.',
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_tipo_calendario.required' => 'Debe seleccionar tipo.'
        ]);

        $get_id = CalendarioLogistico::findOrFail($id);

        if($get_id->flag=="0"){
            if(session('usuario')->id_puesto=="83" ||
            session('usuario')->id_puesto=="122"){
                $id_tipo_calendario = 3;
            }else{
                $id_tipo_calendario = $request->id_tipo_calendario;
            }
    
            $array = explode("-",$request->id_proveedor);
            $id_proveedor = $array[0];
            $infosap = $array[1];
    
            if(date_format(date_create($request->input('start-date')), 'Y-m-d')>date('Y-m-d')){
                $estado_interno =1;
            }else{
                $estado_interno =2;
            }
    
            $id_usuario = $get_id->id_usuario;
            if(session('usuario')->id_nivel=="1"){
                if($request->id_tipo_calendario==1 || $request->id_tipo_calendario==2){
                    //SUPERVISOR DE COMPRAS E INGRESOS
                    $get_usuario = Usuario::select('id_usuario')->where('id_puesto',75)
                                ->orderBy('id_usuario','DESC')->first();
                    if($get_usuario){
                        $id_usuario = $get_usuario->id_usuario;
                    }
                }else{
                    //JEFE DE DPTO. PLANEAMIENTO Y PRODUCCIÓN
                    $get_usuario = Usuario::select('id_usuario')->where('id_puesto',122)
                                ->orderBy('id_usuario','DESC')->first();
                    if($get_usuario){
                        $id_usuario = $get_usuario->id_usuario;
                    }
                }
            }
    
            CalendarioLogistico::findOrFail($id)->update([
                'id_usuario' => $id_usuario,
                'id_proveedor' => $id_proveedor,
                'infosap' => $infosap,
                'titulo' => $request->task,
                'fec_de' => $request->input('start-date'),
                'fec_hasta' => $request->input('end-date'),
                'descripcion' => $request->taskdescription,
                'id_tipo_calendario' => $id_tipo_calendario,
                'base' => $request->cod_base,
                'estado_interno' => $estado_interno,
                'cant_prendas' => $request->cant_prendas,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }else{
            echo "error";
        }
    }

    public function destroy($id)
    {
        CalendarioLogistico::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
