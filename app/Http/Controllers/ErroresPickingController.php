<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaErrorPicking;
use App\Models\Base;
use App\Models\ErroresPicking;
use App\Models\Puesto;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use App\Models\ResponsableErrorPicking;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class ErroresPickingController extends Controller
{
    protected $modelopuesto;
    protected $modelousuarios;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');

        $this->modelousuarios = new Usuario();
        $this->modelopuesto = new Puesto();
    }

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.error_picking.index', compact('list_notificacion', 'list_subgerencia'));
    }




    public function indexta_conf()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.administracion.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function index_ta()
    {
        return view('logistica.administracion.talla2.talla.index');
    }

    public function list_le()
    {
        // Obtener la lista de errores picking con los campos requeridos
        $list_errores_picking = ErroresPicking::from('error_picking AS ep')
                                ->select('ep.id','ep.semana',DB::raw("CASE WHEN ep.pertenece = '0' THEN '' 
                                ELSE ep.pertenece END AS pertenece"),
                                'ep.encontrado','ar.nom_area','ep.estilo','ep.color','ta.nom_talla',
                                'ep.prendas_devueltas','ti.nom_tipo_error',
                                DB::raw("CONCAT(SUBSTRING_INDEX(us.usuario_nombres, ' ', 1),' ',
                                (CASE WHEN us.usuario_apater IS NULL THEN '' ELSE us.usuario_apater END)) AS nom_responsable"),
                                DB::raw("CASE WHEN ep.solucion = 1 THEN 'SI' WHEN ep.solucion = 2 THEN 'NO' 
                                ELSE '' END AS solucion"),'ep.observacion')
                                ->join('vw_area_error_picking AS ar', 'ep.id_area', '=', 'ar.id_area')
                                ->join('vw_talla_error_picking AS ta', 'ep.id_talla', '=', 'ta.id_talla')
                                ->join('vw_tipo_error_picking AS ti', 'ep.id_tipo_error', '=', 'ti.id_tipo_error')
                                ->join('users AS us', 'ep.id_responsable', '=', 'us.id_usuario')
                                ->where('ep.estado', '=', 1)
                                ->orderBy('ep.fec_reg', 'DESC')
                                ->get();
        return view('logistica.error_picking.lista', compact('list_errores_picking'));
    }


    public function edit_le($id)
    {
        $get_id = ErroresPicking::findOrFail($id);
        $list_base = Base::get_list_base_tracking();
        $list_area = AreaErrorPicking::all();
        $list_talla = TallaErrorPicking::all();
        $list_tipo_error = TipoErrorPicking::all();
        $list_responsable = ResponsableErrorPicking::all();
        return view('logistica.error_picking.modal_editar', compact(
            'get_id',
            'list_base',
            'list_area',
            'list_talla',
            'list_tipo_error',
            'list_responsable'
        ));
    }



    public function create_le()
    {
        $list_base = Base::get_list_base_tracking();
        $list_area = AreaErrorPicking::all();
        $list_talla = TallaErrorPicking::all();
        $list_tipo_error = TipoErrorPicking::all();
        $list_responsable = ResponsableErrorPicking::all();
        return view('logistica.error_picking.modal_registrar', compact(
            'list_base',
            'list_area',
            'list_talla',
            'list_tipo_error',
            'list_responsable'
        ));
    }

    public function store_le(Request $request)
    {
        $request->validate([
            'semana' => 'required',
            'encontrado' => 'not_in:0',
            'id_area' => 'gt:0',
            'estilo' => 'required',
            'color' => 'required',
            'id_talla' => 'gt:0',
            'prendas_devueltas' => 'required',
            'prendas_devueltas' => 'gt:0',
            'id_tipo_error' => 'gt:0',
            'id_responsable' => 'gt:0',
            'solucion' => 'gt:0'
        ], [
            'semana.required' => 'Debe ingresar semana.',
            'encontrado.not_in' => 'Debe seleccionar encontrado.',
            'id_area.gt' => 'Debe seleccionar área.',
            'estilo.required' => 'Debe ingresar estilo.',
            'color.required' => 'Debe ingresar color.',
            'id_talla.gt' => 'Debe seleccionar talla.',
            'prendas_devueltas.required' => 'Debe ingresar prendas devueltas.',
            'prendas_devueltas.gt' => 'Debe ingresar prendas devueltas mayor a 0.',
            'id_tipo_error.gt' => 'Debe seleccionar tipo de error.',
            'id_responsable.gt' => 'Debe seleccionar responsable.',
            'solucion.gt' => 'Debe seleccionar solución.'
        ]);

        ErroresPicking::create([
            'semana'  => $request->semana,
            'pertenece' => $request->pertenece,
            'encontrado' => $request->encontrado,
            'id_area' => $request->id_area,
            'estilo' => $request->estilo,
            'color' => $request->color,
            'id_talla' => $request->id_talla,
            'prendas_devueltas' => $request->prendas_devueltas,
            'id_tipo_error' => $request->id_tipo_error,
            'id_responsable' => $request->id_responsable,
            'solucion' => $request->solucion,
            'observacion' => $request->observacion,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function update_le(Request $request, $id)
    {
        $request->validate([
            'semanae' => 'required',
            'encontradoe' => 'not_in:0',
            'id_areae' => 'gt:0',
            'estiloe' => 'required',
            'colore' => 'required',
            'id_tallae' => 'gt:0',
            'prendas_devueltase' => 'required',
            'prendas_devueltase' => 'gt:0',
            'id_tipo_errore' => 'gt:0',
            'id_responsablee' => 'gt:0',
            'solucione' => 'gt:0'
        ], [
            'semanae.required' => 'Debe ingresar semana.',
            'encontradoe.not_in' => 'Debe seleccionar encontrado.',
            'id_areae.gt' => 'Debe seleccionar área.',
            'estiloe.required' => 'Debe ingresar estilo.',
            'colore.required' => 'Debe ingresar color.',
            'id_tallae.gt' => 'Debe seleccionar talla.',
            'prendas_devueltase.required' => 'Debe ingresar prendas devueltas.',
            'prendas_devueltase.gt' => 'Debe ingresar prendas devueltas mayor a 0.',
            'id_tipo_errore.gt' => 'Debe seleccionar tipo de error.',
            'id_responsablee.gt' => 'Debe seleccionar responsable.',
            'solucione.gt' => 'Debe seleccionar solución.'
        ]);

        ErroresPicking::findOrFail($id)->update([
            'semana'  => $request->semanae,
            'pertenece' => $request->pertenecee,
            'encontrado' => $request->encontradoe,
            'id_area' => $request->id_areae,
            'estilo' => $request->estiloe,
            'color' => $request->colore,
            'id_talla' => $request->id_tallae,
            'prendas_devueltas' => $request->prendas_devueltase,
            'id_tipo_error' => $request->id_tipo_errore,
            'id_responsable' => $request->id_responsablee,
            'solucion' => $request->solucione,
            'observacion' => $request->observacione,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }


    public function ver_le($id)
    {
        $get_id = ErroresPicking::findOrFail($id);
        $list_base = Base::get_list_base_tracking();
        $list_area = AreaErrorPicking::all();
        $list_talla = TallaErrorPicking::all();
        $list_tipo_error = TipoErrorPicking::all();
        $list_responsable = ResponsableErrorPicking::all();
        return view('logistica.error_picking.modal_ver', compact(
            'get_id',
            'list_base',
            'list_area',
            'list_talla',
            'list_tipo_error',
            'list_responsable'
        ));
    }


    public function destroy_le($id)
    {
        ErroresPicking::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
