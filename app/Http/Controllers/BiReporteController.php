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
use App\Models\SubGerencia;
use App\Models\TablaBi;
use App\Models\Tablasdb;
use App\Models\TipoIndicador;
use App\Models\Ubicacion;
use App\Models\Usuario;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BiReporteController extends Controller
{

    public function index()
    {
        //NOTIFICACIONES
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.bi.reportes.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function index_ra()
    {
        return view('interna.bi.reportes.registroacceso_reportes.index');
    }


    public function index_ra_conf()
    {

        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.administracion.reportes.index', compact('list_notificacion', 'list_subgerencia'));
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
            'acceso_bi_reporte.fec_act',
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

        // Preparar los datos para cada reporte
        foreach ($list_bi_reporte as $reporte) {
            // Obtener nombres de los puestos asociados al reporte actual
            $nombresPuestosReporte = $puestos->get($reporte->id_acceso_bi_reporte, collect())->pluck('nom_puesto')->implode(', ');
            $reporte->nombres_puesto = $nombresPuestosReporte;

            $cod_area = BiReporte::join('area', 'acceso_bi_reporte.id_area', '=', 'area.id_area')
                ->where('acceso_bi_reporte.id_area', $reporte->id_area)
                ->select('acceso_bi_reporte.*', 'area.cod_area')
                ->first();

            $reporte->codigo_area = $cod_area->cod_area;
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
        // dd($list_bi_reporte->toArray());

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

        $list_tablasdb = Tablasdb::select('idtablas_db', 'nombre', 'descripcion')
            ->where('estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->get();



        return view('interna.bi.reportes.registroacceso_reportes.modal_registrar', compact(
            'list_responsable',
            'list_area',
            'list_base',
            'list_tipo_indicador',
            'list_colaborador',
            'list_sistemas',
            'list_db',
            'list_sede',
            'list_ubicaciones',
            'list_tablasdb'
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
    public function getTBPorDB(Request $request)
    {
        $codDB = $request->input('dbs');

        // Obtiene los usuarios cuyo id_puesto coincida con el área seleccionada
        $tbs = Tablasdb::where('cod_db', $codDB)
            ->where('estado', 1)  // Filtrar por usuarios activos si es necesario
            ->get(['idtablas_db', 'cod_db', 'nombre'])
            ->toArray();

        // dd($tbs);
        return response()->json($tbs);
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

    public function getAreaPorUsuario(Request $request)
    {
        $userId = $request->input('user_id');
        // Obtiene los usuarios cuyo id_puesto coincida con el área seleccionada
        $usuarios = Usuario::where('id_usuario', $userId)
            ->where('users.estado', 1)  // Filtrar por usuarios activos si es necesario
            ->leftJoin('area', 'users.id_area', '=', 'area.id_area')  // Left join con la tabla Area
            ->get([
                'users.id_usuario',
                'users.usuario_apater',
                'users.usuario_amater',
                'users.usuario_nombres',
                'area.id_area',
                'area.nom_area'
            ]);
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
            'tbdb' => 'required',
            'indicador.*' => 'required',
            'indicador.*' => 'string|max:150',
            'descripcion.*' => 'required',
            'descripcion.*' => 'string|max:150',
            'tipo.*' => 'required',
            'presentacion.*' => 'required',
        ], [
            'nombi.required' => 'Debe ingresar nombre bi.',
            'iframe.required' => 'Debe ingresar Iframe.',
            'tipo_acceso_t.required' => 'Debe seleccionar los Accesos por Puesto',
            'descripcion.*.max' => 'La descripción no puede tener más de 150 caracteres.',
            'indicador.*.max' => 'El Nombre del Indicador no puede tener más de 150 caracteres.',
            'tbdb.required' => 'Debe seleccionar tbdb.',
            'indicador.*.required' => 'Debe ingresar un indicador.',
            'descripcion.*.required' => 'Debe ingresar una descripción.',
            'tipo.*.required' => 'Debe seleccionar un tipo.',
            'presentacion.*.required' => 'Debe seleccionar una presentación.',
        ]);


        // Validar todas las tablas seleccionadas
        $tablasbi = $request->input('tbdb', []);
        $db = $request->input('db', []);

        foreach ($tablasbi as $index => $nombre) {
            $idTablaDb = DB::table('tablas_db')
                ->where('tablas_db.cod_db', $db[$index])
                ->where('tablas_db.nombre', $nombre)
                ->value('tablas_db.idtablas_db');

            if (is_null($idTablaDb)) {
                return response()->json([
                    'errors' => [
                        'tabla_db' => [
                            "No se encontró una tabla con el nombre '{$nombre}' para la base de dato, en la fila " . ($index + 1)
                        ]
                    ]
                ], 422);
            }
        }



        // Reemplaza los atributos width y height con la clase responsive-iframe
        $iframeModificado = str_replace(
            ['width="1140"', 'height="541.25"'],
            ['class="responsive-iframe"'],
            $request->iframe
        );



        // Guardar los datos en la tabla portal_procesos_historial
        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;

        $sessionUserId = session('usuario')->id_usuario;
        // Configuración FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";

        // Conectar al servidor FTP
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            // Habilitar el modo pasivo FTP
            ftp_pasv($con_id, true);

            // Definir función para subir un archivo
            function uploadFile($fileKey, $biReporteId, $sessionUserId, $con_id)
            {
                if ($_FILES[$fileKey]["name"] != "") {
                    $path = $_FILES[$fileKey]["name"];
                    $source_file = $_FILES[$fileKey]['tmp_name'];

                    // Obtener extensión del archivo
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $randomDigits = rand(100, 999);
                    // Crear el nombre del archivo
                    $nombre_soli =  $biReporteId . "_" . $sessionUserId . "_" . $randomDigits;
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    // Subir archivo al servidor FTP
                    $subio = ftp_put($con_id, "REPORTE_BI/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        return $nombre; // Devolver el nombre del archivo si la subida fue exitosa
                    } else {
                        echo "Archivo $fileKey no subido correctamente";
                        return null;
                    }
                }
                return null;
            }

            // Subir los archivos
            $img1 = uploadFile('archivo_base_1', $request->nombi, $sessionUserId, $con_id);
            $img2 = uploadFile('archivo_base_2', $request->nombi, $sessionUserId, $con_id);
            $img3 = uploadFile('archivo_base_3', $request->nombi, $sessionUserId, $con_id);

            // Obtener los valores del select múltiple
            $idAreasAcceso = $request->input('id_area_acceso_t', []);
            $filtroArea = implode(',', $idAreasAcceso);
            $idUbiAcceso = $request->input('tipo_acceso_ubi', []);
            $filtroUbi = implode(',', $idUbiAcceso);
            $idSedeAcceso = $request->input('tipo_acceso_sede', []);
            $filtroSede = implode(',', $idSedeAcceso);

            // Crear el registro en la base de datos
            $biReporte = BiReporte::create([
                'nom_bi' => $request->nombi ?? '',
                'nom_intranet' => $request->nomintranet ?? '',
                'actividad' => $request->actividad_bi ?? '',
                'acceso_todo' => $accesoTodo,
                'img1' => $img1 ?? '',
                'img2' => $img2 ?? '',
                'img3' => $img3 ?? '',
                'filtro_area' => $filtroArea,
                'filtro_sede' => $filtroSede,
                'filtro_ubicaciones' => $filtroUbi,
                'id_area' => $request->areass ?? 0,
                'id_area_destino' => $request->areasd ?? 0,
                'id_usuario' => $request->solicitante ?? 0,
                'frecuencia_act' => $request->frec_actualizacion ?? 1,
                'objetivo' => $request->objetivo ?? '',
                'iframe' => $iframeModificado,
                'estado' => 1,
                'estado_valid' => 0,
                'fec_reg' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
                'user_reg' => $sessionUserId,
                'fec_act' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
                'user_act' => $sessionUserId,
                'fec_valid' => $request->fec_valid ? date('Y-m-d H:i:s', strtotime($request->fec_valid)) : now(),
            ]);
        } else {
            echo "No se conectó al servidor FTP";
        }

        // Obtener el ID del nuevo registro en bi_reportes
        $biReporteId = $biReporte->id_acceso_bi_reporte;

        // Validar todas las tablas seleccionadas antes de crear los registros
        $tablasbi = $request->input('tbdb', []); // Nombres de las tablas seleccionadas
        $db = $request->input('db', []); // Cod_sistema

        foreach ($tablasbi as $index => $nombre) {
            $idTablaDb = DB::table('tablas_db')
                ->where('tablas_db.cod_db', $db[$index])
                ->where('tablas_db.nombre', $nombre)
                ->value('tablas_db.idtablas_db');
            TablaBi::create([
                'id_acceso_bi_reporte' => $biReporte->id_acceso_bi_reporte,
                'idtablas_db' => $idTablaDb,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }





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
            'indicador.*' => 'string|max:150',
            'descripcion.*' => 'required',
            'descripcion.*' => 'string|max:150',
            'tipo.*' => 'required',
            'presentacion.*' => 'required',
        ], [
            'nombi.required' => 'Debe ingresar nombre BI.',
            'iframe.required' => 'Debe ingresar Iframe.',
            'descripcion.*.max' => 'La descripción no puede tener más de 150 caracteres.',
            'indicador.*.max' => 'El Nombre del Indicador no puede tener más de 150 caracteres.',
            'indicador.*.required' => 'Debe ingresar un indicador.',
            'descripcion.*.required' => 'Debe ingresar una descripción.',
            'tipo.*.required' => 'Debe seleccionar un tipo.',
            'presentacion.*.required' => 'Debe seleccionar una presentación.',
        ]);

        // Buscar el registro existente
        $biReporte = BiReporte::findOrFail($id);

        // Actualizar los datos en la tabla
        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;


        // Actualizar tablas
        if ($request->has('tablabi')) {
            TablaBi::where('id_acceso_bi_reporte', $biReporte->id_acceso_bi_reporte)->delete();
            $dbtest = $request->input('dbe', []); // Bases de datos seleccionadas

            foreach ($request->tablabi as $key => $nombre) {
                // Obtener el idtablas_db basado en el nombre y cod_db
                $idTablaDb = DB::table('tablas_db')
                    ->where('tablas_db.cod_db', $dbtest[$key])
                    ->where('tablas_db.nombre', $nombre)
                    ->value('tablas_db.idtablas_db');
                // Validar si no se encuentra el idTablaDb
                if (is_null($idTablaDb)) {
                    // Retornar una alerta o señal de error
                    return response()->json([
                        'errors' => [
                            'tabla_db' => [
                                "No se encontró una tabla con el nombre '{$nombre}' para la base de dato, en la fila " . ($key + 1)
                            ]
                        ]
                    ], 422);
                } else {

                    TablaBi::create([
                        'id_acceso_bi_reporte' => $biReporte->id_acceso_bi_reporte,
                        'idtablas_db' => $idTablaDb, // ID de la tabla seleccionada
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                }
                // Insertar el nuevo registro

            }
        }

        // Configuración FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            // Habilitar el modo pasivo FTP
            ftp_pasv($con_id, true);

            // Definir función para subir un archivo
            function uploadFile($fileKey, $biReporteId, $sessionUserId, $con_id)
            {
                if ($_FILES[$fileKey]["name"] != "") {
                    $path = $_FILES[$fileKey]["name"];
                    $source_file = $_FILES[$fileKey]['tmp_name'];

                    // Obtener extensión del archivo
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $randomDigits = rand(100, 999);
                    // Crear el nombre del archivo
                    $nombre_soli =  $biReporteId . "_" . $sessionUserId . "_" . $randomDigits;
                    $nombre = $nombre_soli . "." . strtolower($ext);

                    // Subir archivo al servidor FTP
                    $subio = ftp_put($con_id, "REPORTE_BI/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        return $nombre; // Devolver el nombre del archivo si la subida fue exitosa
                    } else {
                        echo "Archivo $fileKey no subido correctamente";
                        return null;
                    }
                }
                return null;
            }

            $sessionUserId = session('usuario')->id_usuario;

            // Subir los archivos
            $img1 = uploadFile('archivo_basee_1', $request->nombi, $sessionUserId, $con_id);
            $img2 = uploadFile('archivo_basee_2', $request->nombi, $sessionUserId, $con_id);
            $img3 = uploadFile('archivo_basee_3', $request->nombi, $sessionUserId, $con_id);
            // Obtener los valores del select múltiple
            $idAreasAcceso = $request->input('id_area_acceso_te', []);
            $filtroArea = implode(',', $idAreasAcceso);
            $idUbiAcceso = $request->input('tipo_acceso_ubie', []);
            $filtroUbi = implode(',', $idUbiAcceso);
            $idSedeAcceso = $request->input('tipo_acceso_sedee', []);
            $filtroSede = implode(',', $idSedeAcceso);
            // Crear un array de actualización que solo incluya las imágenes que fueron subidas
            $updateData = [
                'nom_bi' => $request->nombi,
                'nom_intranet' => $request->nomintranet,
                'actividad' => $request->actividad_bi,
                'acceso_todo' => $accesoTodo,
                'filtro_area' => $filtroArea,
                'filtro_sede' => $filtroSede,
                'filtro_ubicaciones' => $filtroUbi,
                'id_area' => $request->areasse,
                'id_area_destino' => $request->areassd,
                'id_usuario' => $request->solicitantee,
                'frecuencia_act' => $request->frec_actualizacion,
                'objetivo' => $request->objetivo,
                'iframe' => $request->iframe,
                'estado' => 1,
                'estado_valid' => 0,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'fec_valid' => $request->fec_valid ? date('Y-m-d H:i:s', strtotime($request->fec_valid)) : now(),
            ];

            // Solo actualiza img1 si se ha subido una nueva imagen
            if ($img1) {
                $updateData['img1'] = $img1;
            }

            // Solo actualiza img2 si se ha subido una nueva imagen
            if ($img2) {
                $updateData['img2'] = $img2;
            }

            // Solo actualiza img3 si se ha subido una nueva imagen
            if ($img3) {
                $updateData['img3'] = $img3;
            }

            // Actualizar el registro en la base de datos una sola vez
            $biReporte->update($updateData);
        } else {
            echo "No se conectó al servidor FTP";
        }

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




        // Guardar los datos en la tabla bi_puesto_acceso
        $biReporteId = $biReporte->id_acceso_bi_reporte;
        // Eliminar los registros existentes para ese ID de reporte
        BiPuestoAcceso::where('id_acceso_bi_reporte', $biReporteId)->delete();
        // Obtener los nuevos puestos del request
        $puestos = $request->input('tipo_acceso_tee', []);
        // Crear nuevos registros
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
    }



    public function update_valid(Request $request, $id)
    {

        BiReporte::where('id_acceso_bi_reporte', $id)->update([
            'fec_valid' => now(),
            'estado_valid' => 1,
        ]);
    }


    public function update_duplicar(Request $request, $id)
    {

        $registroOriginal = BiReporte::findOrFail($id);

        // Crear un nuevo registro duplicado con los mismos datos
        $nuevoRegistro = $registroOriginal->replicate(); // Copia todos los atributos del registro original
        $nuevoRegistro->fec_reg = now(); // Establecer nueva fecha de registro para el duplicado
        $nuevoRegistro->estado_valid = 0; // Cambiar otros campos si es necesario
        $nuevoRegistro->save();

        // ID del nuevo registro duplicado
        $nuevoId = $nuevoRegistro->id_acceso_bi_reporte;

        // Duplicar registros relacionados en la tabla IndicadorBi
        $indicadoresOriginales = IndicadorBi::where('id_acceso_bi_reporte', $id)->get();
        foreach ($indicadoresOriginales as $indicadorOriginal) {
            IndicadorBi::create([
                'id_acceso_bi_reporte' => $nuevoId,
                'nom_indicador' => $indicadorOriginal->nom_indicador,
                'estado' => $indicadorOriginal->estado,
                'npagina' => $indicadorOriginal->npagina,
                'descripcion' => $indicadorOriginal->descripcion,
                'idtipo_indicador' => $indicadorOriginal->idtipo_indicador,
                'presentacion' => $indicadorOriginal->presentacion,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }

        // Duplicar registros relacionados en la tabla BiPuestoAcceso
        $puestosOriginales = BiPuestoAcceso::where('id_acceso_bi_reporte', $id)->get();
        foreach ($puestosOriginales as $puestoOriginal) {
            BiPuestoAcceso::create([
                'id_acceso_bi_reporte' => $nuevoId,
                'id_puesto' => $puestoOriginal->id_puesto,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }

        // Duplicar registros relacionados en la tabla TablaBi
        $tablasOriginales = TablaBi::where('id_acceso_bi_reporte', $id)->get();
        foreach ($tablasOriginales as $tablaOriginal) {
            TablaBi::create([
                'id_acceso_bi_reporte' => $nuevoId,
                'idtablas_db' => $tablaOriginal->idtablas_db,
                'estado' => $tablaOriginal->estado,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ]);
        }

        return response()->json(['mensaje' => 'Registro duplicado correctamente', 'nuevo_id' => $nuevoId]);
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
            ->toArray();

        // filtros sede
        $selected_sede_ids = DB::table('acceso_bi_reporte')
            ->where('id_acceso_bi_reporte', $id)
            ->pluck('filtro_sede')
            ->first();
        $selected_sede_ids_array = $selected_sede_ids ? explode(',', $selected_sede_ids) : [];

        // filtros ubicaciones
        $selected_ubi_ids = DB::table('acceso_bi_reporte')
            ->where('id_acceso_bi_reporte', $id)
            ->pluck('filtro_ubicaciones')
            ->first();
        $selected_ubi_ids_array = $selected_ubi_ids ? explode(',', $selected_ubi_ids) : [];

        // filtros area
        $selected_area_ids = DB::table('acceso_bi_reporte')
            ->where('id_acceso_bi_reporte', $id)
            ->pluck('filtro_area')
            ->first();
        $selected_area_ids_array = $selected_area_ids ? explode(',', $selected_area_ids) : [];


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

        $list_tablas = TablaBi::select(
            'tablas_bi.idtablas_db',
            'sistema_tablas.cod_sistema',
            'tablas_db.cod_db'
        )
            ->join('tablas_db', 'tablas_bi.idtablas_db', '=', 'tablas_db.idtablas_db')
            ->join('sistema_tablas', 'sistema_tablas.cod_db', '=', 'tablas_db.cod_db')
            ->where('id_acceso_bi_reporte', $id)
            ->get();



        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->orderBy('descripcion', 'ASC')
            ->distinct('descripcion')->get();

        $list_ubicaciones = Ubicacion::select('id_ubicacion', 'cod_ubi')
            ->where('estado', 1)
            ->orderBy('cod_ubi', 'ASC')
            ->distinct('cod_ubi')->get();

        $list_tablasdb = Tablasdb::select(
            'tablas_db.idtablas_db',
            'tablas_db.nombre',
        )
            ->get();

        return view('interna.bi.reportes.registroacceso_reportes.modal_editar', compact(
            'get_id',
            'list_responsable',
            'list_area',
            'selected_puesto_ids',
            'selected_ubi_ids_array',
            'selected_sede_ids_array',
            'selected_area_ids_array',
            'list_colaborador',
            'list_tipo_indicador',
            'list_base',
            'list_indicadores',
            'list_sistemas',
            'list_db',
            'list_tablas',
            'list_sede',
            'list_ubicaciones',
            'list_tablasdb'
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
                'acceso_bi_reporte.estado',
                'acceso_bi_reporte.fec_act',
                'acceso_bi_reporte.fec_reg',
                'acceso_bi_reporte.fec_valid',
                'acceso_bi_reporte.estado_valid',
                'indicadores_bi.nom_indicador',
                'indicadores_bi.descripcion',
                'indicadores_bi.idtipo_indicador',
                'indicadores_bi.presentacion',
                'tipo_indicador.nom_indicador as tipo_indicador_nombre'
            )
            ->where('acceso_bi_reporte.estado', '=', 1)
            ->where('acceso_bi_reporte.estado_valid', '=', 1)
            ->orderBy('acceso_bi_reporte.fec_reg', 'DESC')
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
            $nombresPuestosReporte = $puestos->get($reporte->id_acceso_bi_reporte, collect())->pluck('nom_puesto')->implode(', ');
            $reporte->nombres_puesto = $nombresPuestosReporte;

            $ids = explode(',', $reporte->id_area);
            $nombresAreas = array_intersect_key($areas, array_flip($ids));
            $reporte->nombres_area = implode(', ', $nombresAreas);

            $reporte->nombre_indicador = $tipoIndicadores[$reporte->idtipo_indicador] ?? 'Indicador desconocido';
        }

        // Creación del archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Listado de Reportes');

        $sheet->setAutoFilter('A1:M1'); // Actualizado para 13 columnas

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
        ];

        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A1:M1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A1:M1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        // Encabezados de columnas
        $sheet->setCellValue('A1', 'Nombre BI');
        $sheet->setCellValue('B1', 'Nombre Intranet');
        $sheet->setCellValue('C1', 'Actividad');
        $sheet->setCellValue('D1', 'Área');
        $sheet->setCellValue('E1', 'Solicitante');
        $sheet->setCellValue('F1', 'Frecuencia');
        $sheet->setCellValue('G1', 'Objetivo');
        $sheet->setCellValue('H1', 'Iframe');
        $sheet->setCellValue('I1', 'Nombre del Indicador');
        $sheet->setCellValue('J1', 'Descripción');
        $sheet->setCellValue('K1', 'Tipo de Indicador');
        $sheet->setCellValue('L1', 'Presentación');
        $sheet->setCellValue('M1', 'Fecha Registro');

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
            $sheet->setCellValue("G{$contador}", $reporte->objetivo);
            $sheet->setCellValue("H{$contador}", $reporte->iframe);
            $sheet->setCellValue("I{$contador}", $reporte->nombre_indicador);
            $sheet->setCellValue("J{$contador}", $reporte->descripcion);
            $sheet->setCellValue("K{$contador}", $reporte->nombre_indicador);
            $sheet->setCellValue("L{$contador}", $tipo_presentacion);
            $sheet->setCellValue("M{$contador}", $reporte->fec_reg);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista Reporte BI ' . date('d-m-Y');

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // REPORTES X INDICADORES
    public function index_ind()
    {
        return view('interna.bi.reportes.reporteind.index');
    }

    public function list_ind()
    {
        // Obtener la lista de reportes con los campos requeridos de la tabla indicadores_bi
        $list_bi_reporte = BiReporte::getBiReportesxIndicador();
        // Obtener IDs de los reportes
        $reportesIds = $list_bi_reporte->pluck('id_acceso_bi_reporte')->toArray();

        // Consultar nombres de los puestos asociados a los reportes
        $puestos = DB::table('bi_puesto_acceso')
            ->join('puesto', 'bi_puesto_acceso.id_puesto', '=', 'puesto.id_puesto')
            ->whereIn('bi_puesto_acceso.id_acceso_bi_reporte', $reportesIds)
            ->select('bi_puesto_acceso.id_acceso_bi_reporte', 'puesto.nom_puesto')
            ->get()
            ->groupBy('id_acceso_bi_reporte');

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

            $cod_area = BiReporte::join('area', 'acceso_bi_reporte.id_area', '=', 'area.id_area')
                ->where('acceso_bi_reporte.id_area', $reporte->id_area)
                ->select('acceso_bi_reporte.*', 'area.cod_area')
                ->first();
            $reporte->codigo_area = $cod_area->cod_area;

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

        return view('interna.bi.reportes.reporteind.lista', compact('list_bi_reporte'));
    }



    // REPORTES X BASE DE DATOS
    public function index_db()
    {
        return view('interna.bi.reportes.reportedb.index');
    }

    public function list_db()
    {
        // Obtener la lista de reportes con los campos requeridos de la tabla indicadores_bi
        $list_bi_reporte = BiReporte::getBiReportesxTablas();

        // Obtener IDs de los reportes
        $reportesIds = $list_bi_reporte->pluck('id_acceso_bi_reporte')->toArray();
        // Consultar nombres de los puestos asociados a los reportes
        $puestos = DB::table('bi_puesto_acceso')
            ->join('puesto', 'bi_puesto_acceso.id_puesto', '=', 'puesto.id_puesto')
            ->whereIn('bi_puesto_acceso.id_acceso_bi_reporte', $reportesIds)
            ->select('bi_puesto_acceso.id_acceso_bi_reporte', 'puesto.nom_puesto')
            ->get()
            ->groupBy('id_acceso_bi_reporte');


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

            $cod_area = BiReporte::join('area', 'acceso_bi_reporte.id_area', '=', 'area.id_area')
                ->where('acceso_bi_reporte.id_area', $reporte->id_area)
                ->select('acceso_bi_reporte.*', 'area.cod_area')
                ->first();

            $reporte->codigo_area = $cod_area->cod_area;

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

        return view('interna.bi.reportes.reportedb.lista', compact('list_bi_reporte'));
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

    // ADMINISTRABLE SISTEMA
    public function index_sis_conf()
    {
        return view('interna.administracion.reportes.sistema.index');
    }

    public function list_sis()
    {
        $list_sistemasdb = SistemaTablas::select('id_sistema_tablas', 'nom_sistema', 'cod_sistema', 'cod_db', 'nom_db')
            ->where('estado', 1)
            ->orderBy('cod_db', 'ASC')
            ->distinct('cod_sistema')
            ->get();


        return view('interna.administracion.reportes.sistema.lista', compact('list_sistemasdb'));
    }

    public function edit_sis($id)
    {
        $list_sistemas = SistemaTablas::select('id_sistema_tablas', 'nom_sistema', 'cod_sistema')
            ->where('estado', 1)
            ->orderBy('cod_sistema', 'ASC')
            ->distinct('cod_sistema')
            ->get()
            ->unique('cod_sistema');


        $get_id = SistemaTablas::findOrFail($id);
        return view('interna.administracion.reportes.sistema.modal_editar',  compact('get_id', 'list_sistemas'));
    }

    public function destroy_sis($id)
    {
        SistemaTablas::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function create_sis()
    {
        $list_sistemas = SistemaTablas::select('id_sistema_tablas', 'nom_sistema', 'cod_sistema')
            ->where('estado', 1)
            ->orderBy('cod_sistema', 'ASC')
            ->distinct('cod_sistema')
            ->get()
            ->unique('cod_sistema');

        return view('interna.administracion.reportes.sistema.modal_registrar', compact('list_sistemas'));
    }

    public function create_sistema()
    {
        return view('interna.administracion.reportes.sistema.modal_registrar_sistema');
    }

    public function store_sis(Request $request)
    {
        $request->validate([
            'nom_sistemae' => 'required',
            'nom_bde' => 'required',
        ], [
            'nom_sistemae.required' => 'Debe ingresar Sistema.',
            'nom_bde.required' => 'Debe ingresar nombre Base de Datos.',
        ]);

        // Obtener el valor más alto de cod_sistema en la tabla SistemaTablas
        $highestCodSistema = SistemaTablas::max('cod_sistema');
        $nextCodSistema = $this->generateNextCode($highestCodSistema, 'S', 3);
        // Obtener el valor más alto de cod_db en la tabla SistemaTablas
        $highestCodDb = SistemaTablas::max('cod_db');
        $nextCodDb = $this->generateNextCode($highestCodDb, 'DB', 3);

        SistemaTablas::create([
            'cod_sistema' => $nextCodSistema,
            'cod_db' => $nextCodDb,
            'nom_sistema' => $request->nom_sistemae,
            'nom_db' => $request->nom_bde,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function store_sistema(Request $request)
    {
        $request->validate([
            'nom_sistema' => 'required',
            'nom_db' => 'required',
        ], [
            'nom_sistema.required' => 'Debe ingresar sistema.',
            'nom_db.required' => 'Debe ingresar base de datos.',
        ]);
        // Obtener el valor más alto de cod_sistema en la tabla SistemaTablas
        $highestCodSistema = SistemaTablas::max('cod_sistema');
        $nextCodSistema = $this->generateNextCode($highestCodSistema, 'S', 3);
        // Obtener el valor más alto de cod_db en la tabla SistemaTablas
        $highestCodDb = SistemaTablas::max('cod_db');
        $nextCodDb = $this->generateNextCode($highestCodDb, 'DB', 3);

        // Crear el nuevo registro con los códigos generados
        SistemaTablas::create([
            'cod_sistema' => $nextCodSistema,
            'cod_db' => $nextCodDb,
            'nom_sistema' => $request->nom_sistema,
            'nom_db' => $request->nom_db,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    private function generateNextCode($currentCode, $prefix, $length)
    {
        if ($currentCode) {
            // Remove prefix and zero-pads
            $number = intval(substr($currentCode, strlen($prefix))) + 1;
        } else {
            // Start with the first number
            $number = 1;
        }

        // Format the number with the prefix and zero-padded to the specified length
        return $prefix . str_pad($number, $length, '0', STR_PAD_LEFT);
    }


    public function update_sis(Request $request, $id)
    {
        $request->validate([
            'nom_sistemae' => 'required',
            'nom_dbe' => 'required',
        ], [
            'nom_sistemae.required' => 'Debe seleccionar SISTEMA.',
            'nom_dbe.required' => 'Debe seleccionar BASE DE DATOS.',
        ]);


        SistemaTablas::findOrFail($id)->update([
            'nom_sistema' => $request->nom_sistemae,
            'nom_db' => $request->nom_dbe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }


    // ADMINISTRABLE BASE DE DATOS
    public function index_dbsis_conf()
    {
        return view('interna.administracion.reportes.sistema.index');
    }

    public function list_dbsis()
    {
        $list_indicadores = TipoIndicador::select('idtipo_indicador', 'nom_indicador', 'descripcion')
            ->where('estado', 1)
            ->orderBy('nom_indicador', 'ASC')
            ->distinct('nom_indicador')->get();


        return view('interna.administracion.reportes.sistema.lista', compact('list_indicadores'));
    }

    public function edit_dbsis($id)
    {
        $get_id = TipoIndicador::findOrFail($id);
        return view('interna.administracion.reportes.sistema.modal_editar',  compact('get_id'));
    }

    public function destroy_dbsis($id)
    {
        TipoIndicador::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function create_dbsis()
    {
        return view('interna.administracion.reportes.sistema.modal_registrar');
    }

    public function store_dbsis(Request $request)
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

    public function update_dbsis(Request $request, $id)
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

    public function image_ra($id)
    {
        $get_id = BiReporte::where('id_acceso_bi_reporte', $id)->firstOrFail();

        // Construye un array con las URLs de las imágenes y sus nombres
        $imageUrls = [];
        if ($get_id->img1) {
            $imageUrls[] = [
                'url' => "https://lanumerounocloud.com/intranet/REPORTE_BI/" . $get_id->img1,
                'name' => 'Imagen 1: ' . $get_id->img1 // Nombre de la imagen
            ];
        }
        if ($get_id->img2) {
            $imageUrls[] = [
                'url' => "https://lanumerounocloud.com/intranet/REPORTE_BI/" . $get_id->img2,
                'name' => 'Imagen 2: ' . $get_id->img2 // Nombre de la imagen
            ];
        }
        if ($get_id->img3) {
            $imageUrls[] = [
                'url' => "https://lanumerounocloud.com/intranet/REPORTE_BI/" . $get_id->img3,
                'name' => 'Imagen 3: ' . $get_id->img3 // Nombre de la imagen
            ];
        }

        return view('interna.bi.reportes.registroacceso_reportes.modal_imagen', compact('get_id', 'imageUrls'));
    }





    // ADMINISTRABLE TABLAS
    public function index_tb_conf()
    {
        return view('interna.administracion.reportes.tablas.index');
    }

    public function list_tb()
    {
        $list_tablasdb = Tablasdb::select('idtablas_db', 'nombre', 'descripcion', 'cod_db')
            ->where('estado', 1)
            ->orderBy('fec_reg', 'DESC')
            ->get();

        return view('interna.administracion.reportes.tablas.lista', compact('list_tablasdb'));
    }

    public function edit_tb($id)
    {
        $list_db = SistemaTablas::select('id_sistema_tablas', 'nom_sistema', 'cod_db')
            ->where('estado', 1)
            ->orderBy('cod_db', 'ASC')
            ->distinct('cod_db')
            ->get()
            ->unique('cod_db');

        $get_id = Tablasdb::findOrFail($id);
        return view('interna.administracion.reportes.tablas.modal_editar',  compact('get_id', 'list_db'));
    }

    public function destroy_tb($id)
    {
        Tablasdb::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function update_tb(Request $request, $id)
    {
        $request->validate([
            'co_basede' => 'required',
            'nom_tble' => 'required',
        ], [
            'co_basede.required' => 'Debe seleccionar BASE DE DATOS.',
            'nom_tble.required' => 'Debe seleccionar tabla.',
        ]);


        Tablasdb::findOrFail($id)->update([
            'nombre' => $request->nom_tble,
            'cod_db' => $request->co_basede,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function create_tb()
    {
        $list_db = SistemaTablas::select('id_sistema_tablas', 'nom_db', 'cod_db')
            ->where('estado', 1)
            ->orderBy('cod_db', 'ASC')
            ->distinct('cod_db')
            ->get()
            ->unique('cod_db');

        return view('interna.administracion.reportes.tablas.modal_registrar', compact('list_db'));
    }


    public function store_tb(Request $request)
    {
        $request->validate([
            'nom_tabe' => 'required',
            'cod_dbee' => 'required',
        ], [
            'nom_tabe.required' => 'Debe ingresar tabla.',
            'cod_dbee.required' => 'Debe ingresar código Base de Datos.',
        ]);

        Tablasdb::create([
            'cod_db' => $request->cod_dbee,
            'nombre' => $request->nom_tabe,
            'descripcion' => $request->descripcione,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function importarExcel(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls',
        ]);

        $archivo = $request->file('archivo');
        $spreadsheet = IOFactory::load($archivo->getRealPath());
        $hoja = $spreadsheet->getActiveSheet();

        $idActual = null;
        $biReporteId = null;
        $processedIds = [];

        // Recorrer las filas de la hoja de cálculo
        foreach ($hoja->getRowIterator() as $fila) {
            $numeroFila = $fila->getRowIndex();

            // Saltar la primera fila si es el encabezado
            if ($numeroFila == 1) {
                continue;
            }

            // Obtener las celdas de la fila
            $id = $hoja->getCell('A' . $numeroFila)->getValue(); // Leer el ID
            $nombrebi = $hoja->getCell('B' . $numeroFila)->getValue();
            $nombreintranet = $hoja->getCell('C' . $numeroFila)->getValue();
            $iframe = $hoja->getCell('D' . $numeroFila)->getValue();
            $objetivo = $hoja->getCell('E' . $numeroFila)->getValue();
            $actividad = $hoja->getCell('F' . $numeroFila)->getValue();
            $id_usuario = $hoja->getCell('G' . $numeroFila)->getValue();
            $frecuencia_act = $hoja->getCell('H' . $numeroFila)->getValue();
            $grupo = $hoja->getCell('I' . $numeroFila)->getValue();
            $area_destino = $hoja->getCell('J' . $numeroFila)->getValue();
            // ACCESSOS
            $filtro_ubicaciones = $hoja->getCell('K' . $numeroFila)->getValue();
            $acceso_puestos = $hoja->getCell('L' . $numeroFila)->getValue();
            // Tablas
            $npagina = $hoja->getCell('M' . $numeroFila)->getValue();
            $nombre_contenido = $hoja->getCell('N' . $numeroFila)->getValue();
            $descripcion_contenido = $hoja->getCell('O' . $numeroFila)->getValue();
            $concepto = $hoja->getCell('P' . $numeroFila)->getValue();
            $presentacion = $hoja->getCell('Q' . $numeroFila)->getValue();
            // Indicadores
            $base_de_datos = $hoja->getCell('R' . $numeroFila)->getValue();
            $nombre_db  = $hoja->getCell('S' . $numeroFila)->getValue();
            $tabla = $hoja->getCell('T' . $numeroFila)->getValue();

            // Comprobar si estamos en un nuevo ID y si ya ha sido procesado
            if ($id != $idActual) {
                // Verificar si los campos obligatorios no están vacíos
                if (!empty($nombrebi) && !empty($nombreintranet) && !empty($iframe) && !empty($objetivo) && !empty($id_usuario)) {
                    if (!in_array($id, $processedIds)) { // Verificar si el ID no ha sido procesado
                        // Crear un nuevo registro en BiReporte
                        $biReporte = BiReporte::create([
                            'nom_bi' => $nombrebi,
                            'nom_intranet' => $nombreintranet,
                            'iframe' => $iframe,
                            'objetivo' => $objetivo,
                            'actividad' => $actividad,
                            'id_usuario' => $id_usuario,
                            'frecuencia_act' => $frecuencia_act,
                            'id_area' => $grupo,
                            'id_area_destino' => $area_destino,
                            'filtro_ubicaciones' => $filtro_ubicaciones,
                            'estado' => 1,
                            'acceso_todo' => 0,
                        ]);

                        $biReporteId = $biReporte->id_acceso_bi_reporte;
                        $idActual = $id;
                        $processedIds[] = $id;
                    }
                }
            }

            // Solo crear las entradas en IndicadorBi y TablaBi si biReporteId está definido
            if ($biReporteId) {
                // Crear las entradas en IndicadorBi
                IndicadorBi::create([
                    'id_acceso_bi_reporte' => $biReporteId,
                    'npagina' => $npagina,
                    'nom_indicador' => $nombre_contenido,
                    'descripcion' => $descripcion_contenido,
                    'idtipo_indicador' => $concepto,
                    'presentacion' => $presentacion,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);

                // Buscar el idtablas_db en la tabla tablas_db usando un inner join con base_de_datos y nombre_db
                $idTablaDb = DB::table('tablas_db')
                    ->where('tablas_db.cod_db', $base_de_datos)
                    ->where('tablas_db.nombre', $nombre_db)
                    ->value('tablas_db.idtablas_db');
                // dd($idTablaDb);
                // Crear las entradas en TablaBi
                TablaBi::create([
                    'id_acceso_bi_reporte' => $biReporteId,
                    // 'nombre_db' => $nombre_db,
                    // 'cod_db' => $base_de_datos,
                    'idtablas_db' => $idTablaDb,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario,
                ]);

                // Convertir el string en un array, si solo tiene un ID no habrá problema
                $puestos = explode(',', $acceso_puestos);
                foreach ($puestos as $puestoId) {
                    // Convertir a entero y filtrar valores inválidos
                    $puestoId = intval(trim($puestoId));

                    // Verificar si el puestoId es válido y existe en la base de datos
                    if ($puestoId > 0 && DB::table('puesto')->where('id_puesto', $puestoId)->exists()) {
                        BiPuestoAcceso::create([
                            'id_acceso_bi_reporte' => $biReporteId,
                            'id_puesto' => $puestoId,
                            'fec_reg' => now(),
                            'user_reg' => session('usuario')->id_usuario,
                            'fec_act' => now(),
                            'user_act' => session('usuario')->id_usuario,
                        ]);
                    }
                }
            }
        }
    }
}
