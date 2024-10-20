<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaErrorPicking;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ErroresPicking;
use App\Models\ErrorPicking;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\NivelJerarquico;
use App\Models\Procesos;
use App\Models\ProcesosHistorial;
use App\Models\Puesto;
use App\Models\SeguimientoCoordinador;
use App\Models\SupervisionTienda;
use App\Models\TipoPortal;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\User;
use App\Models\Usuario;

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
        $list_errores_picking = ErroresPicking::select(
            'error_picking.id',
            'error_picking.fec_reg AS orden',
            'error_picking.semana',
            DB::raw("CASE WHEN error_picking.pertenece = '0' THEN '' ELSE error_picking.pertenece END AS pertenece"),
            DB::raw("CASE WHEN error_picking.encontrado = '0' THEN '' ELSE error_picking.encontrado END AS encontrado"),
            'area_error_picking.nombre AS area',
            'error_picking.estilo',
            'error_picking.color',
            'talla_error_picking.nombre AS talla',
            'error_picking.prendas_devueltas',
            'tipo_error_picking.nombre AS tipo_error',
            DB::raw("CONCAT(SUBSTRING_INDEX(users.usuario_nombres, ' ', 1), ' ', users.usuario_apater) AS responsable"),
            DB::raw("CASE WHEN error_picking.solucion = 1 THEN 'SI' WHEN error_picking.solucion = 2 THEN 'NO' ELSE '' END AS solucion"),
            'error_picking.observacion'
        )
            ->leftJoin('area_error_picking', 'error_picking.id_area', '=', 'area_error_picking.id')
            ->leftJoin('talla_error_picking', 'error_picking.id_talla', '=', 'talla_error_picking.id')
            ->leftJoin('tipo_error_picking', 'error_picking.id_tipo_error', '=', 'tipo_error_picking.id')
            ->leftJoin('users', 'error_picking.id_responsable', '=', 'users.id_usuario')
            ->where('error_picking.estado', '=', 1)
            ->orderBy('error_picking.fec_reg', 'DESC')
            ->get();

        return view('logistica.error_picking.lista', compact('list_errores_picking'));
    }


    public function edit_le($id)
    {
        $get_id = ErroresPicking::findOrFail($id);
        // dd($get_id);

        $list_tipo_error = TipoErrorPicking::select('id', 'nombre')->get();

        $list_talla = TallaErrorPicking::select('id', 'nombre')
            ->where('talla_error_picking.estado', 1)
            ->get();

        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        // Aquí seleccionamos los campos correctos
        $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
        $list_responsable = $this->modelousuarios->list_usuarios_responsables($dato);

        $list_area = AreaErrorPicking::select('id', 'nombre')
            ->orderBy('id', 'ASC')
            ->get();


        return view('logistica.error_picking.modal_editar', compact(
            'list_base',
            'list_tipo_error',
            'list_responsable',
            'list_area',
            'list_talla',
            'get_id'
        ));
    }



    public function create_le()
    {
        $list_tipo_error = TipoErrorPicking::select('id', 'nombre')->get();

        $list_talla = TallaErrorPicking::select('id', 'nombre')

            ->where('talla_error_picking.estado', 1)
            ->get();

        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
        $list_responsable = $this->modelousuarios->list_usuarios_responsables($dato);

        $list_area = AreaErrorPicking::select('id', 'nombre')
            ->get();

        return view('logistica.error_picking.modal_registrar', compact(
            'list_base',
            'list_tipo_error',
            'list_responsable',
            'list_area',
            'list_talla',
        ));
    }

    public function store_le(Request $request)
    {
        $request->validate([
            'semana' => 'required',
            'pertenece' => 'required',
            'encontrado' => 'required',
            'id_area' => 'required',
            'estilo.*' => 'required',
            'color.*' => 'required',
            'id_talla.*' => 'required',
            'prendas_devueltas.*' => 'required',
            'id_tipo_error.*' => 'required',
            'id_responsable.*' => 'required',
            'solucion.*' => 'required',
            'observacion.*' => 'required',
        ], [
            'semana.required' => 'Debe ingresar semana.',
            'pertenece.required' => 'Debe ingresar pertenece.',
            'encontrado.required' => 'Debe seleccionar encontrado',
            'id_area.required' => 'Debe seleccionar Area.',
            'estilo.*.required' => 'Debe ingresar un estilo.',
            'color.*.required' => 'Debe ingresar una color.',
            'id_talla.*.required' => 'Debe seleccionar una talla.',
            'prendas_devueltas.*.required' => 'Debe seleccionar una prendas devueltas.',
            'id_tipo_error.*.required' => 'Debe ingresar un tipo de error.',
            'id_responsable.*.required' => 'Debe ingresar un responsable.',
            'solucion.*.required' => 'Debe seleccionar una solución.',
            'observacion.*.required' => 'Debe seleccionar una observación.',
        ]);
        ErroresPicking::create([
            'semana'  => $request->semana ?? null,
            'pertenece' => $request->pertenece ?? null,
            'encontrado' => $request->encontrado ?? null,
            'id_area' => $request->id_area ?? null,
            'estilo' => $request->estilo ?? null,
            'color' => $request->color ?? null,
            'id_talla' => $request->id_talla ?? null,
            'prendas_devueltas' => $request->prendas_devueltas ?? null,
            'id_tipo_error' => $request->id_tipo_error ?? null,
            'id_responsable' => $request->id_responsable ?? null,
            'solucion' => $request->solucion ?? null,
            'observacion' => $request->observacion ?? null,
            'estado' => $request->estado ?? 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);


        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Datos guardados exitosamente');
    }

    public function update_le(Request $request, $id)
    {
        $request->validate([
            'semanae' => 'required',
            'pertenecee' => 'required',
            'encontradoe' => 'required',
            'id_areae' => 'required',
            'estiloe.*' => 'required',
            'colore.*' => 'required',
            'id_tallae.*' => 'required',
            'prendas_devueltase.*' => 'required',
            'id_tipo_errore.*' => 'required',
            'id_responsable.*' => 'required',
            'solucione.*' => 'required',
            'observacione.*' => 'required',
        ], [
            'semanae.required' => 'Debe ingresar semana.',
            'pertenecee.required' => 'Debe ingresar pertenece.',
            'encontradoe.required' => 'Debe seleccionar encontrado',
            'id_areae.required' => 'Debe seleccionar Area.',
            'estiloe.*.required' => 'Debe ingresar un estilo.',
            'colore.*.required' => 'Debe ingresar una color.',
            'id_tallae.*.required' => 'Debe seleccionar una talla.',
            'prendas_devueltase.*.required' => 'Debe seleccionar una prendas devueltas.',
            'id_tipo_errore.*.required' => 'Debe ingresar un tipo de error.',
            'id_responsablee.*.required' => 'Debe ingresar un responsable.',
            'solucione.*.required' => 'Debe seleccionar una solución.',
            'observacione.*.required' => 'Debe seleccionar una observación.',
        ]);

        ErroresPicking::where('id', $id)->update([
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
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,
        ]);
    }


    public function ver_le($id)
    {
        $get_id = ErroresPicking::findOrFail($id);
        // dd($get_id);

        $list_tipo_error = TipoErrorPicking::select('id', 'nombre')->get();

        $list_talla = TallaErrorPicking::select('id', 'nombre')
            ->where('talla_error_picking.estado', 1)
            ->get();

        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        // Aquí seleccionamos los campos correctos
        $dato['puestos_jefes'] = $this->modelopuesto->list_puestos_jefes();
        $list_responsable = $this->modelousuarios->list_usuarios_responsables($dato);

        $list_area = AreaErrorPicking::select('id', 'nombre')
            ->orderBy('id', 'ASC')
            ->get();


        return view('logistica.error_picking.modal_ver', compact(
            'list_base',
            'list_tipo_error',
            'list_responsable',
            'list_area',
            'list_talla',
            'get_id'
        ));
    }


    public function destroy_le($id)
    {
        ErroresPicking::where('ID', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
