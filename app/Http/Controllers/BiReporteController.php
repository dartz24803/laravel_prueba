<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaUbicacion;
use App\Models\Base;
use App\Models\BiPuestoAcceso;
use App\Models\BiReporte;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\Gerencia;
use App\Models\IndicadorBi;
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
use Illuminate\Support\Facades\Schema;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Notificacion;
use App\Models\Organigrama;
use App\Models\SedeLaboral;
use App\Models\SistemaTablas;
use App\Models\TablaBi;
use App\Models\TipoIndicador;
use App\Models\Ubicacion;
use App\Models\Usuario;

class BiReporteController extends Controller
{

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.bi.reportes.index', compact('list_notificacion'));
    }


    public function index_ra()
    {
        return view('interna.bi.reportes.registroacceso_reportes.index');
    }


    public function index_ra_conf()
    {

        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.administracion.reportes.index', compact('list_notificacion'));
    }


    public function list_ra()
    {
        // Obtener la lista de reportes con los campos requeridos
        $list_bi_reporte = BiReporte::select(
            'acceso_bi_reporte.id_acceso_bi_reporte',
            'acceso_bi_reporte.nom_bi',
            'acceso_bi_reporte.actividad',
            'acceso_bi_reporte.estado',
            'acceso_bi_reporte.id_area', // Asegúrate de incluir id_area en la selección
            'acceso_bi_reporte.fec_reg',
            'acceso_bi_reporte.fec_valid',
            'acceso_bi_reporte.estado_valid'
        )
            ->where('acceso_bi_reporte.estado', '=', 1)
            ->orderBy('acceso_bi_reporte.fec_reg', 'DESC') // Ordena por fec_reg en orden descendente
            ->get();

        // Obtener IDs de los reportes
        $reportesIds = $list_bi_reporte->pluck('id_acceso_bi_reporte')->toArray();

        // Consultar nombres de los puestos asociados a los reportes
        $puestos = DB::table('bi_puesto_acceso')
            ->join('puesto', 'bi_puesto_acceso.id_puesto', '=', 'puesto.id_puesto')
            ->whereIn('bi_puesto_acceso.id_acceso_bi_reporte', $reportesIds)
            ->select('bi_puesto_acceso.id_acceso_bi_reporte', 'puesto.nom_puesto')
            ->get()
            ->groupBy('id_acceso_bi_reporte');

        // Consultar nombres de las áreas
        $areas = DB::table('area')
            ->whereIn('id_area', $list_bi_reporte->pluck('id_area')->flatten()->unique())
            ->pluck('nom_area', 'id_area')
            ->toArray();

        // Preparar los datos para cada reporte
        foreach ($list_bi_reporte as $reporte) {
            // Obtener nombres de los puestos asociados al reporte actual
            $nombresPuestosReporte = $puestos->get($reporte->id_acceso_bi_reporte, collect())->pluck('nom_puesto')->implode(', ');
            $reporte->nombres_puesto = $nombresPuestosReporte;

            // Obtener nombres de las áreas asociadas al reporte actual
            $ids = explode(',', $reporte->id_area);
            $nombresAreas = array_intersect_key($areas, array_flip($ids));
            $reporte->nombres_area = implode(', ', $nombresAreas);
            // Calcular los días sin atención
            // Suponiendo que $reporte->estado_valid contiene el valor del estado
            if ($reporte->estado_valid == 1) {
                // Si estado_valid es 1, se usa fec_valid
                $fec_reg = new \DateTime($reporte->fec_reg);
                $fec_valid = new \DateTime($reporte->fec_valid);
                $interval = $fec_valid->diff($fec_reg);
                $reporte->dias_sin_atencion = $interval->days;
            } else {
                // Si estado_valid no es 1, se usa la fecha actual
                $fec_reg = new \DateTime($reporte->fec_reg);
                $fecha_actual = new \DateTime(); // Fecha actual
                $interval = $fecha_actual->diff($fec_reg);
                $reporte->dias_sin_atencion = $interval->days;
            }
        }

        return view('interna.bi.reportes.registroacceso_reportes.lista', compact('list_bi_reporte'));
    }





    public function create_ra()
    {
        // $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')
        // ->get();
        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        $list_ubicaciones = Ubicacion::select('id_ubicacion', 'cod_ubi')
            ->where('estado', 1)
            ->orderBy('cod_ubi', 'ASC')
            ->distinct('cod_ubi')->get();

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->orderBy('descripcion', 'ASC')
            ->distinct('descripcion')->get();

        $list_tipo_indicador = TipoIndicador::select('idtipo_indicador', 'nom_indicador')
            ->where('estado', 1)
            ->orderBy('nom_indicador', 'ASC')
            ->distinct('nom_indicador')->get();

        $list_colaborador = Usuario::select('id_usuario', 'usuario_apater', 'usuario_amater', 'usuario_nombres')
            ->where('estado', 1)
            ->where('id_nivel', '!=', 8)
            ->get();

        $list_sistemas = SistemaTablas::select('id_sistema_tablas', 'cod_sistema', 'nom_sistema')
            ->where('estado', 1)
            ->orderBy('cod_sistema', 'ASC')
            ->get()
            ->unique('cod_sistema');

        $list_db = SistemaTablas::select('id_sistema_tablas', 'cod_db', 'nom_db')
            ->where('estado', 1)
            ->orderBy('cod_db', 'ASC')
            ->get()
            ->unique('cod_db');

        return view('interna.bi.reportes.registroacceso_reportes.modal_registrar', compact(
            'list_responsable',
            'list_area',
            'list_base',
            'list_tipo_indicador',
            'list_colaborador',
            'list_sistemas',
            'list_db',
            'list_sede',
            'list_ubicaciones'
        ));
    }

    public function getDBPorSistema(Request $request)
    {
        $sisId = $request->input('sis');
        // Obtiene los usuarios cuyo id_puesto coincida con el área seleccionada
        $dbs = SistemaTablas::where('cod_sistema', $sisId)
            ->where('estado', 1)  // Filtrar por usuarios activos si es necesario
            ->get(['cod_db', 'nom_db']);

        return response()->json($dbs);
    }

    public function getAreasPorBase(Request $request)
    {
        $idsBases = $request->input('bases');
        if (empty($idsBases)) {
            $bases = Base::select('id_base')
                ->where('estado', 1)
                ->orderBy('cod_base', 'ASC')
                ->distinct('cod_base')
                ->get()
                ->pluck('id_base');
            $idsBases = $bases->toArray();
        }
        // Filtra las áreas basadas en los idsBases seleccionados
        $areas = Area::where(function ($query) use ($idsBases) {
            foreach ($idsBases as $idBase) {
                $query->orWhereRaw("FIND_IN_SET(?, id_base)", [$idBase]);
            }
        })
            ->where('estado', 1)
            ->get();
        return response()->json($areas);
    }
    public function getAreasPorUbicacion(Request $request)
    {
        // Obtener ids de ubicaciones seleccionadas
        $idsUbis = $request->input('ubis');
        // Si no hay ubicaciones seleccionadas, devolver todas las áreas
        if (empty($idsUbis)) {
            $areas = Area::select('id_area', 'nom_area')
                ->where('estado', 1)
                ->get();
        } else {
            // Obtener todos los id_area relacionados con las ubicaciones seleccionadas
            $areasRelacionadas = AreaUbicacion::whereIn('id_ubicacion', $idsUbis)
                ->pluck('id_area');

            // Obtener las áreas relacionadas
            $areas = Area::select('id_area', 'nom_area')
                ->whereIn('id_area', $areasRelacionadas)
                ->where('estado', 1)
                ->get();
        }

        return response()->json($areas);
    }



    public function getUbicacionPorSede(Request $request)
    {
        $idsSedes = $request->input('sedes');
        if (empty($idsSedes)) {
            $sedes = SedeLaboral::select('id')
                ->where('estado', 1)
                ->orderBy('descripcion', 'ASC')
                ->distinct('descripcion')
                ->get()
                ->pluck('descripcion');
            $idsSedes = $sedes->toArray();
        }
        $sedes = Ubicacion::where(function ($query) use ($idsSedes) {
            foreach ($idsSedes as $idSede) {
                $query->orWhereRaw("FIND_IN_SET(?, id_sede)", [$idSede]);
            }
        })
            ->where('estado', 1)
            ->get();
        return response()->json($sedes);
    }

    public function getUsuariosPorArea(Request $request)
    {
        $areaId = $request->input('area_id');
        // Obtiene los usuarios cuyo id_puesto coincida con el área seleccionada
        $usuarios = Usuario::where('id_area', $areaId)
            ->where('estado', 1)  // Filtrar por usuarios activos si es necesario
            ->get(['id_usuario', 'usuario_apater', 'usuario_amater', 'usuario_nombres']);

        // Concatenar los campos en una propiedad adicional
        $usuarios->map(function ($usuario) {
            $usuario->nombre_completo = "{$usuario->usuario_apater} {$usuario->usuario_amater} {$usuario->usuario_nombres}";
            return $usuario;
        });

        return response()->json($usuarios);
    }



    public function getPuestosPorAreasBi(Request $request)
    {
        $idsAreas = $request->input('areas');
        if (empty($idsAreas)) {
            $areas = Area::select('id_area')
                ->where('estado', 1)
                ->orderBy('nom_area', 'ASC')
                ->distinct('nom_area')
                ->get()
                ->pluck('id_area');
            $idsAreas = $areas->toArray();
        }

        $puestos = Puesto::whereIn('id_area', $idsAreas)
            ->where('estado', 1)
            ->get();
        return response()->json($puestos);
    }



    public function store_ra(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombi' => 'required',
            'iframe' => 'required',
            'tipo_acceso_t' => 'required',
            'tablabi' => 'required',
            'indicador.*' => 'required',
            'descripcion.*' => 'required',
            'tipo.*' => 'required',
            'presentacion.*' => 'required',
        ], [
            'nombi.required' => 'Debe ingresar nombre bi.',
            'iframe.required' => 'Debe ingresar Iframe.',
            'tipo_acceso_t.required' => 'Debe seleccionar los Accesos por Puesto',
            'tablabi.required' => 'Debe seleccionar tablabi.',
            'indicador.*.required' => 'Debe ingresar un indicador.',
            'descripcion.*.required' => 'Debe ingresar una descripción.',
            'tipo.*.required' => 'Debe seleccionar un tipo.',
            'presentacion.*.required' => 'Debe seleccionar una presentación.',
        ]);
        // Reemplaza los atributos width y height con la clase responsive-iframe
        $iframeModificado = str_replace(
            ['width="1140"', 'height="541.25"'],
            ['class="responsive-iframe"'],
            $request->iframe
        );
        // Guardar los datos en la tabla portal_procesos_historial
        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;
        $biReporte = BiReporte::create([
            'nom_bi' => $request->nombi ?? '',
            'nom_intranet' => $request->nomintranet ?? '',
            'actividad' => $request->actividad_bi ?? '',
            'acceso_todo' => $accesoTodo,
            'id_area' => $request->areass ?? 0,
            'id_usuario' => $request->solicitante ?? 0,
            'frecuencia_act' => $request->frec_actualizacion ?? 1,
            'objetivo' => $request->objetivo ?? '',
            'iframe' => $iframeModificado,
            'estado' => 1,
            'estado_valid' => 0,
            'fec_reg' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_valid' => $request->fec_valid ? date('Y-m-d H:i:s', strtotime($request->fec_valid)) : now(),

        ]);

        // Obtener el ID del nuevo registro en bi_reportes
        $biReporteId = $biReporte->id_acceso_bi_reporte;

        // Guardar los datos en la tabla indicadores_bi
        $npaginas = $request->input('npagina', []);
        $indicadores = $request->input('indicador', []);
        $descripciones = $request->input('descripcion', []);
        $tipos = $request->input('tipo', []);
        $presentaciones = $request->input('presentacion', []);

        foreach ($indicadores as $index => $indicador) {
            IndicadorBi::create([
                'id_acceso_bi_reporte' => $biReporteId,
                'nom_indicador' => $indicador,
                'estado' => 1,
                'npagina' => $npaginas[$index] ?? '',
                'descripcion' => $descripciones[$index] ?? '',
                'idtipo_indicador' => $tipos[$index] ?? 0,
                'presentacion' => $presentaciones[$index] ?? 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }


        // Guardar los datos en la tabla tabla_bi
        $tablasbi = $request->input('tablabi', []);
        $sistemas = $request->input('sistema', []);
        $dbs = $request->input('db', []);

        foreach ($tablasbi as $index => $tabla) {
            TablaBi::create([
                'id_acceso_bi_reporte' => $biReporteId,
                'nom_tabla' => $tabla,
                'cod_sistema' => $sistemas[$index],
                'cod_db' => $dbs[$index],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }

        // Guardar los datos en la tabla bi_puesto_acceso
        $puestos = $request->input('tipo_acceso_t', []);

        foreach ($puestos as $puestoId) {
            BiPuestoAcceso::create([
                'id_acceso_bi_reporte' => $biReporteId,
                'id_puesto' => $puestoId,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }

        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    public function update_ra(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombi' => 'required',
            'iframe' => 'required',
            'indicador.*' => 'required',
            'descripcion.*' => 'required',
            'tipo.*' => 'required',
            'presentacion.*' => 'required',
        ], [
            'nombi.required' => 'Debe ingresar nombre BI.',
            'iframe.required' => 'Debe ingresar Iframe.',
            'indicador.*.required' => 'Debe ingresar un indicador.',
            'descripcion.*.required' => 'Debe ingresar una descripción.',
            'tipo.*.required' => 'Debe seleccionar un tipo.',
            'presentacion.*.required' => 'Debe seleccionar una presentación.',
        ]);

        // Buscar el registro existente
        $biReporte = BiReporte::findOrFail($id);
        // dd($biReporte);
        // Actualizar los datos en la tabla
        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;
        // dd($request->areasse);
        $biReporte->update([
            'nom_bi' => $request->nombi,
            'nom_intranet' => $request->nomintranet,
            'actividad' => $request->actividad_bi,
            'acceso_todo' => $accesoTodo,
            'id_area' => $request->areasse,
            'id_usuario' => $request->solicitantee,
            'frecuencia_act' => $request->frec_actualizacion,
            'objetivo' => $request->objetivo,
            'tablas' => $request->tablas,
            'iframe' => $request->iframe,
            'estado' => 1,
            'estado_valid' => 0,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_valid' => $request->fec_valid ? date('Y-m-d H:i:s', strtotime($request->fec_valid)) : now(),
        ]);

        // Actualizar indicadores
        if ($request->has('indicador')) {
            // Primero, eliminamos los registros antiguos que no están en la solicitud
            IndicadorBi::where('id_acceso_bi_reporte', $biReporte->id_acceso_bi_reporte)
                ->whereNotIn('idindicadores_bi', array_keys($request->indicador))
                ->delete();

            // Ahora, actualizamos o creamos los registros nuevos
            foreach ($request->indicador as $key => $indicador) {
                $biIndicador = IndicadorBi::updateOrCreate(
                    [
                        'id_acceso_bi_reporte' => $biReporte->id_acceso_bi_reporte,
                        'idindicadores_bi' => $key
                    ],
                    [
                        'estado' => 1,
                        'nom_indicador' => $indicador,
                        'npagina' => $request->npagina[$key] ?? '',
                        'descripcion' => $request->descripcion[$key] ?? '',
                        'idtipo_indicador' => $request->tipo[$key] ?? 0,
                        'presentacion' => $request->presentacion[$key] ?? 0,
                    ]
                );
            }
        }
        // Actualizar tablas
        if ($request->has('tablabi')) {
            // Primero, eliminamos los registros antiguos que no están en la solicitud
            TablaBi::where('id_acceso_bi_reporte', $biReporte->id_acceso_bi_reporte)
                ->whereNotIn('idtablas_bi', array_keys($request->tablabi))
                ->delete();

            // Ahora, actualizamos o creamos los registros nuevos
            foreach ($request->tablabi as $key => $tablabi) {
                $biTabla = TablaBi::updateOrCreate(
                    [
                        'id_acceso_bi_reporte' => $biReporte->id_acceso_bi_reporte,
                        'idtablas_bi' => $key
                    ],
                    [
                        'estado' => 1,
                        'nom_tabla' => $tablabi,
                        'cod_sistema' => $request->sistemas[$key],
                        'cod_db' => $request->db[$key],
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]
                );
            }
        }
    }



    public function update_valid(Request $request, $id)
    {

        BiReporte::where('id_acceso_bi_reporte', $id)->update([
            'fec_valid' => now(),
            'estado_valid' => 1,
        ]);
    }



    public function destroy_ra($id)
    {
        BiReporte::where('id_acceso_bi_reporte', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }


    public function edit_ra($id)
    {
        $get_id = BiReporte::findOrFail($id);
        $id_usuario = $get_id->id_usuario;
        $selected_puesto_ids = DB::table('bi_puesto_acceso')
            ->where('id_acceso_bi_reporte', $id)
            ->pluck('id_puesto')
            ->toArray(); // Convertir a array para usar en la vista
        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('id_area', 'ASC')
            ->get()
            ->unique('nom_area');


        $list_indicadores = IndicadorBi::with('tipoIndicador')
            ->select(
                'indicadores_bi.npagina',
                'indicadores_bi.nom_indicador',
                'indicadores_bi.descripcion',
                'indicadores_bi.idtipo_indicador',
                'indicadores_bi.presentacion',
                'indicadores_bi.fec_reg',
                'tipo_indicador.nom_indicador as tipo_indicador_nom'
            )
            ->where('id_acceso_bi_reporte', $id) // Filtra por el valor de $id en el campo id_acceso_bi_reporte
            ->join('tipo_indicador', 'indicadores_bi.idtipo_indicador', '=', 'tipo_indicador.idtipo_indicador')
            ->get();

        $list_tipo_indicador = TipoIndicador::select('idtipo_indicador', 'nom_indicador')
            ->where('estado', 1)
            ->orderBy('nom_indicador', 'ASC')
            ->distinct('nom_indicador')->get();

        $list_colaborador = Usuario::get_list_colaborador_usuario([
            'id_usuario' => $id_usuario // Filtro por id_usuario
        ]);

        $list_sistemas = SistemaTablas::select('id_sistema_tablas', 'cod_sistema', 'nom_sistema', 'cod_db', 'nom_db')
            ->where('estado', 1)
            ->get();

        $list_db = SistemaTablas::select('id_sistema_tablas', 'cod_db', 'nom_db')
            ->where('estado', 1)
            ->orderBy('cod_db', 'ASC')
            ->get()
            ->unique('cod_db');

        $list_tablas = TablaBi::select(
            'tablas_bi.nom_tabla',
            'tablas_bi.cod_sistema',
            'tablas_bi.cod_db'
        )
            ->where('id_acceso_bi_reporte', $id) // Filtra por el valor de $id en el campo id_acceso_bi_reporte
            ->get();


        return view('interna.bi.reportes.registroacceso_reportes.modal_editar', compact(
            'get_id',
            'list_responsable',
            'list_area',
            'selected_puesto_ids',
            'list_colaborador',
            'selected_puesto_ids', // IDs de los puestos seleccionados
            'list_tipo_indicador',
            'list_base',
            'list_indicadores',
            'list_sistemas',
            'list_db',
            'list_tablas'
        ));
    }



    public function excel_rebi($cod_base, $fecha_inicio, $fecha_fin)
    {
        // Obtener la lista de reportes con los campos requeridos
        $list_reportes = DB::table('indicadores_bi')
            ->join('acceso_bi_reporte', 'indicadores_bi.id_acceso_bi_reporte', '=', 'acceso_bi_reporte.id_acceso_bi_reporte')
            ->leftJoin('tipo_indicador', 'indicadores_bi.idtipo_indicador', '=', 'tipo_indicador.idtipo_indicador')
            ->select(
                'acceso_bi_reporte.id_acceso_bi_reporte',
                'acceso_bi_reporte.nom_bi',
                'acceso_bi_reporte.nom_intranet',
                'acceso_bi_reporte.iframe',
                'acceso_bi_reporte.actividad',
                'acceso_bi_reporte.id_area',
                'acceso_bi_reporte.objetivo',
                'acceso_bi_reporte.frecuencia_act',
                'acceso_bi_reporte.id_usuario',
                'acceso_bi_reporte.tablas',
                'acceso_bi_reporte.estado',
                'acceso_bi_reporte.fec_act',
                'acceso_bi_reporte.fec_reg',
                'acceso_bi_reporte.fec_valid',
                'acceso_bi_reporte.estado_valid',
                'indicadores_bi.nom_indicador',
                'indicadores_bi.descripcion', // Nueva columna
                'indicadores_bi.idtipo_indicador', // Nueva columna
                'indicadores_bi.presentacion', // Nueva columna
                'tipo_indicador.nom_indicador as tipo_indicador_nombre' // Obtenemos el nombre del indicador
            )
            ->where('acceso_bi_reporte.estado', '=', 1)
            ->where('acceso_bi_reporte.estado_valid', '=', 1)
            ->orderBy('acceso_bi_reporte.fec_reg', 'DESC') // Ordena por fec_reg en orden descendente
            ->get();

        // Obtener IDs de los reportes
        $reportesIds = $list_reportes->pluck('id_acceso_bi_reporte')->toArray();

        // Consultar nombres de los puestos asociados a los reportes
        $puestos = DB::table('bi_puesto_acceso')
            ->join('puesto', 'bi_puesto_acceso.id_puesto', '=', 'puesto.id_puesto')
            ->whereIn('bi_puesto_acceso.id_acceso_bi_reporte', $reportesIds)
            ->select('bi_puesto_acceso.id_acceso_bi_reporte', 'puesto.nom_puesto')
            ->get()
            ->groupBy('id_acceso_bi_reporte');

        // Consultar nombres de las áreas
        $areas = DB::table('area')
            ->whereIn('id_area', $list_reportes->pluck('id_area')->flatten()->unique())
            ->pluck('nom_area', 'id_area')
            ->toArray();

        // Consultar los nombres de los indicadores
        $tipoIndicadores = DB::table('tipo_indicador')
            ->whereIn('idtipo_indicador', $list_reportes->pluck('idtipo_indicador')->unique())
            ->pluck('nom_indicador', 'idtipo_indicador')
            ->toArray();

        // Preparar un array para almacenar los nombres de las áreas y el nombre del usuario
        foreach ($list_reportes as $reporte) {
            // Obtener nombres de los puestos asociados al reporte actual
            $nombresPuestosReporte = $puestos->get($reporte->id_acceso_bi_reporte, collect())->pluck('nom_puesto')->implode(', ');
            $reporte->nombres_puesto = $nombresPuestosReporte;

            // Obtener nombres de las áreas asociadas al reporte actual
            $ids = explode(',', $reporte->id_area);
            $nombresAreas = array_intersect_key($areas, array_flip($ids));
            $reporte->nombres_area = implode(', ', $nombresAreas);

            // Obtener el nombre del tipo de indicador
            $reporte->nombre_indicador = $tipoIndicadores[$reporte->idtipo_indicador] ?? 'Indicador desconocido';
        }

        // Creación del archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Listado de Reportes');

        $sheet->setAutoFilter('A1:N1'); // Actualización para incluir las nuevas columnas

        $columnWidths = [
            'A' => 20,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 20,
            'L' => 20,
            'M' => 20,
            'N' => 20, // Nueva columna
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A1:N1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        // Encabezados de columnas
        $sheet->setCellValue('A1', 'Nombre BI');
        $sheet->setCellValue('B1', 'Nombre Intranet');
        $sheet->setCellValue('C1', 'Actividad');
        $sheet->setCellValue('D1', 'Área');
        $sheet->setCellValue('E1', 'Solicitante');
        $sheet->setCellValue('F1', 'Frecuencia');
        $sheet->setCellValue('G1', 'Tablas');
        $sheet->setCellValue('H1', 'Objetivo');
        $sheet->setCellValue('I1', 'Iframe');
        $sheet->setCellValue('J1', 'Nombre del Indicador');
        $sheet->setCellValue('K1', 'Descripción'); // Nueva columna
        $sheet->setCellValue('L1', 'Tipo de Indicador'); // Nueva columna
        $sheet->setCellValue('M1', 'Presentación'); // Nueva columna
        $sheet->setCellValue('N1', 'Fecha Registro');

        // Obtener los ids de usuario únicos de la lista de reportes
        $idsUsuarios = $list_reportes->pluck('id_usuario')->unique();
        $nombresUsuarios = DB::table('users')
            ->whereIn('id_usuario', $idsUsuarios)
            ->select(DB::raw("id_usuario, CONCAT(usuario_nombres, ' ', usuario_apater, ' ', usuario_amater) as nombre_completo"))
            ->pluck('nombre_completo', 'id_usuario');

        $contador = 1;
        foreach ($list_reportes as $reporte) {
            $contador++;
            $actividad = ['1' => 'En Uso', '2' => 'Suspendido'][$reporte->actividad] ?? 'Desconocido';
            $frecuencia = ['1' => 'Minuto', '2' => 'Hora', '3' => 'Día', '4' => 'Mes'][$reporte->frecuencia_act] ?? 'Desconocido';
            $tipo_presentacion = ['1' => 'Tabla', '2' => 'Gráfico'][$reporte->presentacion] ?? 'Desconocido';


            $sheet->setCellValue("A{$contador}", $reporte->nom_bi);
            $sheet->setCellValue("B{$contador}", $reporte->nom_intranet);
            $sheet->setCellValue("C{$contador}", $actividad);
            $sheet->setCellValue("D{$contador}", $reporte->nombres_area);
            $nombreUsuario = $nombresUsuarios[$reporte->id_usuario] ?? 'Usuario desconocido';
            $sheet->setCellValue("E{$contador}", $nombreUsuario);
            $sheet->setCellValue("F{$contador}", $frecuencia);
            $sheet->setCellValue("G{$contador}", $reporte->tablas);
            $sheet->setCellValue("H{$contador}", $reporte->objetivo);
            $sheet->setCellValue("I{$contador}", $reporte->iframe);
            $sheet->setCellValue("J{$contador}", $reporte->nombre_indicador);
            $sheet->setCellValue("K{$contador}", $reporte->descripcion); // Nueva columna
            $sheet->setCellValue("L{$contador}", $reporte->nombre_indicador); // Nueva columna
            $sheet->setCellValue("M{$contador}", $tipo_presentacion); // Nueva columna
            $sheet->setCellValue("N{$contador}", $reporte->fec_reg);
        }


        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista Reporte BI ' . date('d-m-Y');

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    // BD REPORTES
    public function index_db()
    {
        return view('interna.bi.reportes.dbreportes.index');
    }

    public function list_db()
    {
        // Obtener la lista de reportes con los campos requeridos de la tabla indicadores_bi
        $list_bi_reporte = BiReporte::getBiReportes();
        // Obtener IDs de los reportes
        $reportesIds = $list_bi_reporte->pluck('id_acceso_bi_reporte')->toArray();
        // dd($reportesIds);
        // Consultar nombres de los puestos asociados a los reportes
        $puestos = DB::table('bi_puesto_acceso')
            ->join('puesto', 'bi_puesto_acceso.id_puesto', '=', 'puesto.id_puesto')
            ->whereIn('bi_puesto_acceso.id_acceso_bi_reporte', $reportesIds)
            ->select('bi_puesto_acceso.id_acceso_bi_reporte', 'puesto.nom_puesto')
            ->get()
            ->groupBy('id_acceso_bi_reporte');

        // Consultar nombres de las áreas
        $areas = DB::table('area')
            ->whereIn('id_area', $list_bi_reporte->pluck('id_area')->flatten()->unique())
            ->pluck('nom_area', 'id_area')
            ->toArray();

        // Consultar los nombres de los usuarios
        $idsUsuarios = $list_bi_reporte->pluck('id_usuario')->unique();
        $nombresUsuarios = DB::table('users')
            ->whereIn('id_usuario', $idsUsuarios)
            ->select(DB::raw("id_usuario, CONCAT(usuario_nombres, ' ', usuario_apater, ' ', usuario_amater) as nombre_completo"))
            ->pluck('nombre_completo', 'id_usuario');

        // Preparar los datos para cada reporte
        foreach ($list_bi_reporte as $reporte) {
            // Obtener nombres de los puestos asociados al reporte actual
            $nombresPuestosReporte = $puestos->get($reporte->id_acceso_bi_reporte, collect())->pluck('nom_puesto')->implode(', ');
            $reporte->nombres_puesto = $nombresPuestosReporte;

            // Obtener el nombre del usuario correspondiente
            $nombreUsuario = $nombresUsuarios[$reporte->id_usuario] ?? 'Usuario desconocido'; // Acceder por id_usuario
            $reporte->nombre_usuario = $nombreUsuario;

            // Obtener nombres de las áreas asociadas al reporte actual
            $ids = explode(',', $reporte->id_area);
            $nombresAreas = array_intersect_key($areas, array_flip($ids));
            $reporte->nombres_area = implode(', ', $nombresAreas);
            $reporte->tipo_presentacion = $reporte->presentacion == 1 ? 'Tabla' : ($reporte->presentacion == 2 ? 'Gráfico' : 'Desconocido');
            $reporte->tipo_frecuencia = $reporte->frecuencia_act == 1 ? 'Minuto' : ($reporte->frecuencia_act == 2 ? 'Hora' : ($reporte->frecuencia_act == 3 ? 'Día' : ($reporte->frecuencia_act == 4 ? 'Semana' : ($reporte->frecuencia_act == 5 ? 'Mes' : 'Desconocido'))));

            // Calcular los días sin atención
            if ($reporte->estado_valid == 1) {
                $fec_reg = new \DateTime($reporte->fec_reg);
                $fec_valid = new \DateTime($reporte->fec_valid);
                $interval = $fec_valid->diff($fec_reg);
                $reporte->dias_sin_atencion = $interval->days;
            } else {
                $fec_reg = new \DateTime($reporte->fec_reg);
                $fecha_actual = new \DateTime(); // Fecha actual
                $interval = $fecha_actual->diff($fec_reg);
                $reporte->dias_sin_atencion = $interval->days;
            }
        }

        return view('interna.bi.reportes.dbreportes.lista', compact('list_bi_reporte'));
    }


    // ADMINISTRABLE TIPO INDICADOR
    public function index_ti_conf()
    {
        return view('interna.administracion.reportes.indicadortipo.index');
    }

    public function list_tind()
    {
        $list_indicadores = TipoIndicador::select('idtipo_indicador', 'nom_indicador', 'descripcion')
            ->where('estado', 1)
            ->orderBy('nom_indicador', 'ASC')
            ->distinct('nom_indicador')->get();


        return view('interna.administracion.reportes.indicadortipo.lista', compact('list_indicadores'));
    }

    public function edit_tind($id)
    {
        $get_id = TipoIndicador::findOrFail($id);
        return view('interna.administracion.reportes.indicadortipo.modal_editar',  compact('get_id'));
    }

    public function destroy_tind($id)
    {
        TipoIndicador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function create_tind()
    {
        return view('interna.administracion.reportes.indicadortipo.modal_registrar');
    }

    public function store_tind(Request $request)
    {
        $request->validate([
            'nom_indicador' => 'required',
            'descripcion' => 'required',
        ], [
            'nom_indicador.required' => 'Debe ingresar nombre.',
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);

        TipoIndicador::create([
            'nom_indicador' => $request->nom_indicador,
            'descripcion' => $request->descripcion,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function update_tind(Request $request, $id)
    {
        $request->validate([
            'nombreindicadore' => 'required',
            'descripcionee' => 'required',
        ], [
            'nombreindicadore.required' => 'Debe seleccionar nombre.',
            'descripcionee.required' => 'Debe seleccionar descripción.',
        ]);


        TipoIndicador::findOrFail($id)->update([
            'nom_indicador' => $request->nombreindicadore,
            'descripcion' => $request->descripcionee,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }
}
