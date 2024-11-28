<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
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
use App\Models\User;

class ProcesosController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.procesos.portalprocesos.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function indexcap()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.procesos.capacitacion.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_lm()
    {
        return view('interna.procesos.portalprocesos.listamaestra.index');
    }


    public function index_lm_conf()
    {
        return view('interna.procesos.administracion.portalprocesos.index');
    }

    public function list_lm()
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_procesos = ProcesosHistorial::select(
            'portal_procesos_historial.id_portal_historial',
            'portal_procesos_historial.id_portal',
            'portal_procesos_historial.codigo',
            'portal_procesos_historial.nombre',
            'portal_procesos_historial.version',
            'portal_procesos_historial.id_tipo',
            'portal_procesos_historial.id_area',
            'portal_procesos_historial.id_responsable',
            'portal_procesos_historial.fecha',
            'portal_procesos_historial.estado_registro'
        )
            ->join(
                DB::raw('(SELECT id_portal, MAX(version) AS max_version 
                         FROM portal_procesos_historial 
                         GROUP BY id_portal) as max_versions'),
                'portal_procesos_historial.id_portal',
                '=',
                'max_versions.id_portal'
            )
            ->whereColumn('portal_procesos_historial.version', 'max_versions.max_version')
            ->whereNotNull('portal_procesos_historial.codigo')
            ->where('portal_procesos_historial.codigo', '!=', '')
            ->where('portal_procesos_historial.estado', '=', 1)
            ->orderBy('portal_procesos_historial.codigo', 'ASC')
            ->get();


        // Preparar un array para almacenar los nombres de las áreas y del responsable
        foreach ($list_procesos as $proceso) {
            // Obtener nombres de las áreas
            $ids = explode(',', $proceso->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            // Asignar nombres de las áreas al proceso
            $proceso->nombres_area = $nombresAreas->implode(', ');
            // Obtener nombre del responsable
            $nombreResponsable = DB::table('puesto')
                ->where('id_puesto', $proceso->id_responsable)
                ->value('nom_puesto'); // Asumiendo que la columna del nombre es 'nombre'
            // Obtener nombre del tipo portal
            $nombreTipoPortal = DB::table('tipo_portal')
                ->where('id_tipo_portal', $proceso->id_tipo)
                ->value('nom_tipo'); // Asumiendo que la columna del nombre es 'nombre'

            // Asignar nombre del responsable al proceso
            $proceso->nombre_responsable = $nombreResponsable;
            $proceso->nombre_tipo_portal = $nombreTipoPortal;

            // Asignar texto basado en el estado
            switch ($proceso->estado_registro) {
                case 0:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 1:
                    $proceso->estado_texto = 'Por aprobar';
                    break;
                case 2:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 3:
                    $proceso->estado_texto = 'Por actualizar';
                    break;
                default:
                    $proceso->estado_texto = 'Desconocido';
                    break;
            }
        }

        return view('interna.procesos.portalprocesos.listamaestra.lista', compact('list_procesos'));
    }



    public function create_lm()
    {
        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo', 'cod_tipo')->get();
        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        $list_base = Base::get_list_todas_bases_agrupadas_bi();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel', 'nom_nivel')->where('estado', 1)->get();

        // $list_puesto = NivelJerarquico::select('id_nivel', 'nom_nivel')
        //     ->where('estado', 1)
        //     ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        return view('interna.procesos.portalprocesos.listamaestra.modal_registrar', compact('list_tipo', 'list_responsable', 'list_area', 'list_base', 'list_gerencia', 'list_nivel'));
    }

    public function getPuestosPorAreas(Request $request)
    {
        $idsAreas = $request->input('areas');
        // Verifica si $idsAreas es vacío o null
        if (empty($idsAreas)) {
            // Si es vacío o null, obten todos los id_area de la tabla Area
            $areas = Area::select('id_area')
                ->where('estado', 1)
                ->orderBy('nom_area', 'ASC')
                ->distinct('nom_area')
                ->get()
                ->pluck('id_area'); // Obtener solo los valores de id_area como un array

            $idsAreas = $areas->toArray(); // Convertir a un array para usar en la consulta
        }

        // Filtra los puestos basados en las áreas seleccionadas
        $puestos = Puesto::whereIn('id_area', $idsAreas)
            ->where('estado', 1)
            ->get();

        // Filtra los puestos basados en las áreas seleccionadas
        return response()->json($puestos);
    }





    public function image_lm($id)
    {
        $get_id = ProcesosHistorial::where('id_portal_historial', $id)->firstOrFail();
        // Construye la URL completa de la imagen
        $imageUrl = null;
        if ($get_id->archivo) {
            $imageUrl = "https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/" . $get_id->archivo;
        }
        return view('interna.procesos.portalprocesos.listamaestra.modal_imagen', compact('get_id', 'imageUrl'));
    }


    public function store_lm(Request $request)
    {

        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;

        // Obtener Lista de Bases
        $list_base = Base::select('id_base', 'cod_base')
            ->where('estado', 1)
            ->orderBy('cod_base', 'ASC')
            ->get()
            ->unique('cod_base')
            ->pluck('cod_base')
            ->toArray();
        // Obtener Lista Responsables
        $list_responsable = Puesto::select('id_puesto', 'nom_puesto')
            ->where('estado', 1)
            ->orderBy('id_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto')
            ->pluck('id_puesto')
            ->toArray();
        // Obtener Lista Nivel Jerárquico
        $list_nivel_jerarquico = NivelJerarquico::select('id_nivel', 'nom_nivel')
            ->where('estado', 1)
            ->orderBy('id_nivel', 'ASC')
            ->get()
            ->unique('nom_nivel')
            ->pluck('id_nivel')
            ->toArray();
        // Obtener Lista Gerencia
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')
            ->where('estado', 1)
            ->orderBy('id_gerencia', 'ASC')
            ->get()
            ->unique('nom_gerencia')
            ->pluck('id_gerencia')
            ->toArray();
        // Obtener Lista Area
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('id_area', 'ASC')
            ->get()
            ->unique('nom_area')
            ->pluck('id_area')
            ->toArray();
        // Convertir el array a una cadena separada por comas
        $list_responsable_string = implode(',', $list_responsable);
        $list_base_string = implode(',', $list_base);
        $list_niveljerarquico_string = implode(',', $list_nivel_jerarquico);
        $list_gerencia_string = implode(',', $list_gerencia);
        $list_area_string = implode(',', $list_area);

        // Cargar Imagenes
        $archivo = "";
        $documento = "";
        $diagrama = "";

        // Conectar al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        // dd($get_id);
        // Conexión a FTP SERVER
        if ($con_id && $lr) {
            ftp_pasv($con_id, true);
            // Subir archivo 1
            if (!empty($_FILES["archivo1"]["name"])) {

                $path = $_FILES["archivo1"]["name"];
                $source_file = $_FILES['archivo1']['tmp_name'];
                $nombre = $_FILES["archivo1"]["name"];

                $subio = ftp_put($con_id, "PORTAL_PROCESOS/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo = $nombre;
                } else {
                    echo "Archivo 1 no subido correctamente";
                }
            }

            // Subir documento
            if (!empty($_FILES["documentoa"]["name"])) {
                $path_doc = $_FILES["documentoa"]["name"];
                $source_file_doc = $_FILES['documentoa']['tmp_name'];
                $nombre_doc = $_FILES["documentoa"]["name"];

                $subio_doc = ftp_put($con_id, "PORTAL_PROCESOS/" . $nombre_doc, $source_file_doc, FTP_BINARY);
                if ($subio_doc) {
                    $documento = $nombre_doc;
                } else {
                    echo "Documento no subido correctamente";
                }
            }

            // Subir diagrama
            if (!empty($_FILES["diagramaa"]["name"])) {
                $path_diag = $_FILES["diagramaa"]["name"];
                $source_file_diag = $_FILES['diagramaa']['tmp_name'];
                $nombre_diag = $_FILES["diagramaa"]["name"];

                $subio_diag = ftp_put($con_id, "PORTAL_PROCESOS/" . $nombre_diag, $source_file_diag, FTP_BINARY);
                if ($subio_diag) {
                    $diagrama = $nombre_diag;
                } else {
                    echo "Diagrama no subido correctamente";
                }
            }

            ftp_close($con_id); // Cerrar conexión FTP

        } else {
            echo "No se conectó al servidor FTP";
        }


        // Si no existe, obtener el último ID del portal y crear un nuevo registro
        $ultimoIdPortal = ProcesosHistorial::max('id_portal');
        $id_portal_ag = $ultimoIdPortal ? $ultimoIdPortal + 1 : 1;

        // Crear un nuevo registro en la tabla portal_procesos_historial
        ProcesosHistorial::create([
            'id_portal' => $id_portal_ag,
            'codigo' => $request->codigo ?? 'SIN CÓDIGO',
            'numero' => $request->ndocumento ?? '',
            'version' => 1,
            'nombre' => $request->nombre ?? '',
            'id_tipo' => $request->id_portal ?? null,
            'id_area' => $accesoTodo
                ? $list_area_string
                : (is_array($request->id_area_acceso_t) ? implode(',', $request->id_area_acceso_t) : $request->id_area_acceso_t ?? ''),
            'fecha' => $request->fecha ?? null,
            'etiqueta' => is_array($request->etiqueta) ? implode(',', $request->etiqueta) : $request->etiqueta ?? '',
            'descripcion' => $request->descripcion ?? '',
            'id_responsable' => is_array($request->id_puesto) ? implode(',', $request->id_puesto) : $request->id_puesto ?? null,
            'acceso' => $accesoTodo
                ? $list_responsable_string
                : (is_array($request->tipo_acceso_t) ? implode(',', $request->tipo_acceso_t) : $request->tipo_acceso_t ?? ''),
            'acceso_area' => $accesoTodo
                ? $list_area_string
                : (is_array($request->id_area_acceso) ? implode(',', $request->id_area_acceso) : $request->id_area_acceso ?? ''),
            'acceso_nivel' => $accesoTodo ? $list_niveljerarquico_string
                : (is_array($request->id_nivel_acceso) ? implode(',', $request->id_nivel_acceso) : $request->id_nivel_acceso ?? ''),
            'acceso_gerencia' => $accesoTodo ? $list_gerencia_string
                : (is_array($request->id_gerencia_acceso) ? implode(',', $request->id_gerencia_acceso) : $request->id_gerencia_acceso ?? ''),
            'acceso_base' => $accesoTodo ? $list_base_string
                : (is_array($request->id_base_acceso) ? implode(',', $request->id_base_acceso) : $request->id_base_acceso ?? ''),
            'acceso_todo' => $accesoTodo,
            'div_puesto' => $accesoTodo ? 0 : (!empty($request->tipo_acceso_t) ? 1 : 0),
            'div_base' => $accesoTodo ? 0 : (!empty($request->id_base_acceso) ? 1 : 0),
            'div_area' => $accesoTodo ? 0 : (!empty($request->id_area_acceso) ? 1 : 0),
            'div_nivel' => $accesoTodo ? 0 : (!empty($request->id_nivel_acceso) ? 1 : 0),
            'div_gerencia' => $accesoTodo ? 0 : (!empty($request->id_gerencia_acceso) ? 1 : 0),
            'archivo' => $archivo ?? '',
            'archivo2' => $request->archivo2 ?? '',
            'archivo3' => $request->archivo3 ?? '',
            'archivo4' => $documento ?? '',
            'archivo5' => $diagrama ?? '',
            'user_aprob' => $request->user_aprob ?? 0,
            'fec_aprob' => $request->fec_aprob ?? null,
            'estado_registro' => $request->estado_registro ?? 1,
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



    public function update_lm(Request $request, $id)
    {

        // Obtener el registro del historial de procesos
        $get_id = ProcesosHistorial::where('id_portal_historial', $id)->firstOrFail();

        // Inicializar variables para los archivos
        $archivo = $get_id->archivo;
        $documento = $get_id->archivo4;
        $diagrama = $get_id->archivo5;

        // Conectar al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            ftp_pasv($con_id, true);

            // Subir archivo 1 si se ha cargado
            if ($request->hasFile('archivo1e')) {
                if ($get_id->archivo) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo));
                }
                $archivo = $request->file('archivo1e')->getClientOriginalName();
                $request->file('archivo1e')->move(storage_path('app/temp'), $archivo);
                $source_file = storage_path('app/temp/' . $archivo);
                $subio = ftp_put($con_id, "PORTAL_PROCESOS/" . $archivo, $source_file, FTP_BINARY);
                if (!$subio) {
                    echo "Archivo 1 no subido correctamente";
                }
            }

            // Subir documento si se ha cargado
            if ($request->hasFile('documentoae')) {
                if ($get_id->archivo4) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo4));
                }
                $documento = $request->file('documentoae')->getClientOriginalName();
                $request->file('documentoae')->move(storage_path('app/temp'), $documento);
                $source_file_doc = storage_path('app/temp/' . $documento);
                $subio_doc = ftp_put($con_id, "PORTAL_PROCESOS/" . $documento, $source_file_doc, FTP_BINARY);
                if (!$subio_doc) {
                    echo "Documento no subido correctamente";
                }
            }

            // Subir diagrama si se ha cargado
            if ($request->hasFile('diagramaae')) {
                if ($get_id->archivo5) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo5));
                }
                $diagrama = $request->file('diagramaae')->getClientOriginalName();
                $request->file('diagramaae')->move(storage_path('app/temp'), $diagrama);
                $source_file_diag = storage_path('app/temp/' . $diagrama);
                $subio_diag = ftp_put($con_id, "PORTAL_PROCESOS/" . $diagrama, $source_file_diag, FTP_BINARY);
                if (!$subio_diag) {
                    echo "Diagrama no subido correctamente";
                }
            }

            ftp_close($con_id); // Cerrar conexión FTP
        } else {
            echo "No se conectó al servidor FTP";
        }

        // Actualiza la tabla 'ProcesosHistorial'
        DB::table('portal_procesos_historial')
            ->where('id_portal_historial', $id)
            ->update([
                'nombre' => $request->nombre,
                'id_tipo' => $request->id_tipo,
                'fecha' => $request->fecha,
                'id_responsable' => $request->id_responsablee,
                'codigo' => $request->codigo,
                'numero' => $request->ndocumento,
                'version' => $request->versione,
                'estado_registro' => $request->estadoe,
                'descripcion' => $request->descripcione ?? '',
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'archivo' => $archivo,
                'archivo4' => $documento,
                'archivo5' => $diagrama,
            ]);
    }

    public function destroy_lm($id)
    {

        ProcesosHistorial::where('id_portal_historial', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }


    public function approve_lm($id)
    {

        ProcesosHistorial::where('id_portal_historial', $id)->update([
            'estado_registro' => 2,
            'fec_aprob' => now(),
            'user_aprob' => session('usuario')->id_usuario
        ]);
    }
    public function getTemasPorAreas(Request $request)
    {
        $idArea = $request->input('areas');
        $idAreaInt = intval($idArea);
        $temas = Capacitacion::where('id_area', $idAreaInt)
            ->where('estado', 1)
            ->get();
        return response()->json($temas);
    }
    public function getCapacitadoresPorAreas(Request $request)
    {
        $idArea = $request->input('areas');
        $idAreaInt = intval($idArea);
        $capacitadores = User::where('id_area', $idAreaInt)
            ->where('estado', 1)
            ->get();
        return response()->json($capacitadores);
    }


    public function version_lm(Request $request, $id)
    {
        // Obtener el registro del historial de procesos
        $get_id = ProcesosHistorial::where('id_portal', $id)->firstOrFail();

        // Inicializar variables para los archivos
        $archivo = $get_id->archivo1e;
        $documento = $get_id->archivo4;
        $diagrama = $get_id->archivo5;


        // Conectar al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            ftp_pasv($con_id, true);

            // Subir archivo 1 si se ha cargado
            if ($request->hasFile('archivo1e')) {
                if ($get_id->archivo) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo));
                }
                $archivo = $request->file('archivo1e')->getClientOriginalName();
                $request->file('archivo1e')->move(storage_path('app/temp'), $archivo);
                $source_file = storage_path('app/temp/' . $archivo);
                $subio = ftp_put($con_id, "PORTAL_PROCESOS/" . $archivo, $source_file, FTP_BINARY);
                if (!$subio) {
                    echo "Archivo 1 no subido correctamente";
                }
            }

            // Subir documento si se ha cargado
            if ($request->hasFile('documentoae')) {
                if ($get_id->archivo4) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo4));
                }
                $documento = $request->file('documentoae')->getClientOriginalName();
                $request->file('documentoae')->move(storage_path('app/temp'), $documento);
                $source_file_doc = storage_path('app/temp/' . $documento);
                $subio_doc = ftp_put($con_id, "PORTAL_PROCESOS/" . $documento, $source_file_doc, FTP_BINARY);
                if (!$subio_doc) {
                    echo "Documento no subido correctamente";
                }
            }

            // Subir diagrama si se ha cargado
            if ($request->hasFile('diagramaae')) {
                if ($get_id->archivo5) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo5));
                }
                $diagrama = $request->file('diagramaae')->getClientOriginalName();
                $request->file('diagramaae')->move(storage_path('app/temp'), $diagrama);
                $source_file_diag = storage_path('app/temp/' . $diagrama);
                $subio_diag = ftp_put($con_id, "PORTAL_PROCESOS/" . $diagrama, $source_file_diag, FTP_BINARY);
                if (!$subio_diag) {
                    echo "Diagrama no subido correctamente";
                }
            }

            ftp_close($con_id); // Cerrar conexión FTP
        } else {
            echo "No se conectó al servidor FTP";
        }

        $tipo_acceso_p = $request->input('tipo_acceso_p', []);
        $acceso = implode(',', $tipo_acceso_p);
        $area_p = $request->input('id_area_p', []);
        $areas = implode(',', $area_p);

        // Actualiza la tabla 'ProcesosHistorial'
        DB::table('portal_procesos_historial')
            // ->where('id_portal', $id)
            ->where('version', 1)
            ->insert([
                'id_portal' => $id,
                'nombre' => $request->nombre,
                'id_tipo' => $request->id_tipo,
                'fecha' => $request->fecha,
                'etiqueta' => '',
                'id_responsable' => $request->id_responsablee,
                'codigo' => $request->codigo,
                'numero' => $request->ndocumento,
                'acceso' =>  $acceso,
                'estado' => 1,
                'acceso_area' => '',
                'acceso_nivel' => '',
                'acceso_base' => '',
                'id_area' => $areas,
                'acceso_todo' =>  0,
                'acceso_gerencia' => '',
                'div_puesto' => 0,
                'div_base' => 0,
                'div_area' => 0,
                'div_nivel' =>  0,
                'div_gerencia' => 0,
                'version' => $request->versione + 1,
                'estado_registro' => $request->estadoe,
                'descripcion' => $request->descripcione ?? '',
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'fec_eli' => null,
                'user_eli' => null,
                'archivo' => $archivo,
                'archivo2' => $request->archivo2 ?? '',
                'archivo3' => $request->archivo3 ?? '',
                'archivo4' => $documento,
                'archivo5' => $diagrama,
                'user_aprob' => $request->user_aprob ?? 0,
                'fec_aprob' => $request->fec_aprob ?? null,


            ]);
    }


    public function edit_lm($id)
    {

        $get_id = ProcesosHistorial::where('id_portal', $id)
            ->where('version', function ($query) use ($id) {
                $query->selectRaw('MAX(version)')
                    ->from('portal_procesos_historial')
                    ->where('id_portal', $id);
            })
            ->firstOrFail();
        $div_puesto = $get_id->div_puesto;

        // Obtener el valor del campo `id_area` y convertirlo en un array
        $selected_area_ids = explode(',', $get_id->id_area);
        $selected_puesto_ids = explode(',', $get_id->acceso);

        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')->get();


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

        // dd($list_area);
        $list_procesos = ProcesosHistorial::select(
            'portal_procesos_historial.id_portal_historial',
            'portal_procesos_historial.id_portal',
            'portal_procesos_historial.version',
            'portal_procesos_historial.codigo',
            'portal_procesos_historial.nombre',
            'portal_procesos_historial.id_tipo',
            'portal_procesos_historial.id_area',
            'portal_procesos_historial.id_responsable',
            'portal_procesos_historial.fecha',
            'portal_procesos_historial.estado_registro',
            'portal_procesos_historial.archivo',
            'portal_procesos_historial.archivo4',
            'portal_procesos_historial.archivo5'


        )
            ->where('portal_procesos_historial.id_portal', '=', $id)
            ->where('portal_procesos_historial.estado', '=', 1)
            ->orderBy('portal_procesos_historial.codigo', 'ASC')
            ->get();


        // Preparar un array para almacenar los nombres de las áreas y del responsable
        foreach ($list_procesos as $proceso) {
            $ids = explode(',', $proceso->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            $proceso->nombres_area = $nombresAreas->implode(', ');
            $nombreResponsable = DB::table('puesto')
                ->where('id_puesto', $proceso->id_responsable)
                ->value('nom_puesto');
            $nombreTipoPortal = DB::table('tipo_portal')
                ->where('id_tipo_portal', $proceso->id_tipo)
                ->value('nom_tipo');

            $proceso->nombre_responsable = $nombreResponsable;
            $proceso->nombre_tipo_portal = $nombreTipoPortal;
            // dd($get_id->estado_registro, gettype($get_id->estado_registro));
            switch ($proceso->estado_registro) {
                case 0:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 1:
                    $proceso->estado_texto = 'Por aprobar';
                    break;
                case 2:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 3:
                    $proceso->estado_texto = 'Por actualizar';
                    break;
                default:
                    $proceso->estado_texto = 'Desconocido';
                    break;
            }
        }
        return view('interna.procesos.portalprocesos.listamaestra.modal_editar', compact(
            'get_id',
            'list_tipo',
            'list_responsable',
            'list_area',
            'selected_area_ids',
            'selected_puesto_ids',
            'div_puesto',
            'list_procesos',
        ));
    }


    public function excel_lm($cod_base, $fecha_inicio, $fecha_fin)
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_procesos = ProcesosHistorial::select(
            'portal_procesos_historial.id_portal',
            'portal_procesos_historial.codigo',
            'portal_procesos_historial.nombre',
            'portal_procesos_historial.id_tipo',
            'portal_procesos_historial.id_area',
            'portal_procesos_historial.id_responsable',
            'portal_procesos_historial.fecha',
            'portal_procesos_historial.estado_registro'
        )
            ->whereNotNull('portal_procesos_historial.codigo')
            ->where('portal_procesos_historial.codigo', '!=', '')
            ->where('portal_procesos_historial.estado', '=', 1)
            ->orderBy('portal_procesos_historial.codigo', 'ASC')
            ->get();

        // Preparar un array para almacenar los nombres de las áreas, del responsable, y tipo de portal
        foreach ($list_procesos as $proceso) {
            // Obtener nombres de las áreas
            $ids = explode(',', $proceso->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            // Asignar nombres de las áreas al proceso
            $proceso->nombres_area = $nombresAreas->implode(', ');

            // Obtener nombre del responsable
            $nombreResponsable = DB::table('puesto')
                ->where('id_puesto', $proceso->id_responsable)
                ->value('nom_puesto');

            // Obtener nombre del tipo portal
            $nombreTipoPortal = DB::table('tipo_portal')
                ->where('id_tipo_portal', $proceso->id_tipo)
                ->value('nom_tipo');

            // Asignar nombre del responsable y tipo portal al proceso
            $proceso->nombre_responsable = $nombreResponsable;
            $proceso->nombre_tipo_portal = $nombreTipoPortal;

            // Asignar texto basado en el estado
            switch ($proceso->estado_registro) {
                case 0:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 1:
                    $proceso->estado_texto = 'Por aprobar';
                    break;
                case 2:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 3:
                    $proceso->estado_texto = 'Por actualizar';
                    break;
                default:
                    $proceso->estado_texto = 'Desconocido';
                    break;
            }
        }

        // Creación del archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Listado de Procesos');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(50);
        $sheet->getColumnDimension('D')->setWidth(18);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(18);
        $sheet->getColumnDimension('G')->setWidth(18);


        $sheet->getStyle('A1:I1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:I1")->applyFromArray($styleThinBlackBorderOutline);

        // Encabezados de columnas
        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Tipo Portal');
        $sheet->setCellValue('D1', 'Área');
        $sheet->setCellValue('E1', 'Responsable');
        $sheet->setCellValue('F1', 'Fecha');
        $sheet->setCellValue('G1', 'Estado');


        $contador = 1;

        foreach ($list_procesos as $proceso) {
            $contador++;

            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("C{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:I{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:I{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $sheet->setCellValue("A{$contador}", $proceso->codigo);
            $sheet->setCellValue("B{$contador}", $proceso->nombre);
            $sheet->setCellValue("C{$contador}", $proceso->nombre_tipo_portal);
            $sheet->setCellValue("D{$contador}", $proceso->nombres_area);
            $sheet->setCellValue("E{$contador}", $proceso->nombre_responsable);
            $sheet->setCellValue("F{$contador}", Date::PHPToExcel($proceso->fecha));
            $sheet->getStyle("F{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("G{$contador}", $proceso->estado_texto);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista Maestra ' . date('d-m-Y');

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    // CAPACITACIONES

    public function index_cap()
    {
        return view('interna.procesos.capacitacion.capacitaciones.index');
    }


    public function list_cap()
    {

        // Obtener la lista de procesos con los campos requeridos
        $list_procesos = ProcesosHistorial::select(
            'portal_procesos_historial.id_portal_historial',
            'portal_procesos_historial.id_portal',
            'portal_procesos_historial.codigo',
            'portal_procesos_historial.nombre',
            'portal_procesos_historial.version',
            'portal_procesos_historial.id_tipo',
            'portal_procesos_historial.id_area',
            'portal_procesos_historial.id_responsable',
            'portal_procesos_historial.fecha',
            'portal_procesos_historial.estado_registro'
        )
            ->join(
                DB::raw('(SELECT id_portal, MAX(version) AS max_version 
                         FROM portal_procesos_historial 
                         GROUP BY id_portal) as max_versions'),
                'portal_procesos_historial.id_portal',
                '=',
                'max_versions.id_portal'
            )
            ->whereColumn('portal_procesos_historial.version', 'max_versions.max_version')
            ->whereNotNull('portal_procesos_historial.codigo')
            ->where('portal_procesos_historial.codigo', '!=', '')
            ->where('portal_procesos_historial.estado', '=', 1)
            ->orderBy('portal_procesos_historial.codigo', 'ASC')
            ->get();


        // Preparar un array para almacenar los nombres de las áreas y del responsable
        foreach ($list_procesos as $proceso) {
            // Obtener nombres de las áreas
            $ids = explode(',', $proceso->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            // Asignar nombres de las áreas al proceso
            $proceso->nombres_area = $nombresAreas->implode(', ');
            // Obtener nombre del responsable
            $nombreResponsable = DB::table('puesto')
                ->where('id_puesto', $proceso->id_responsable)
                ->value('nom_puesto'); // Asumiendo que la columna del nombre es 'nombre'
            // Obtener nombre del tipo portal
            $nombreTipoPortal = DB::table('tipo_portal')
                ->where('id_tipo_portal', $proceso->id_tipo)
                ->value('nom_tipo'); // Asumiendo que la columna del nombre es 'nombre'

            // Asignar nombre del responsable al proceso
            $proceso->nombre_responsable = $nombreResponsable;
            $proceso->nombre_tipo_portal = $nombreTipoPortal;

            // Asignar texto basado en el estado
            switch ($proceso->estado_registro) {
                case 0:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 1:
                    $proceso->estado_texto = 'Por aprobar';
                    break;
                case 2:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 3:
                    $proceso->estado_texto = 'Por actualizar';
                    break;
                default:
                    $proceso->estado_texto = 'Desconocido';
                    break;
            }
        }

        return view('interna.procesos.portalprocesos.listamaestra.lista', compact('list_procesos'));
    }




    public function edit_cap($id)
    {

        $get_id = ProcesosHistorial::where('id_portal', $id)
            ->where('version', function ($query) use ($id) {
                $query->selectRaw('MAX(version)')
                    ->from('portal_procesos_historial')
                    ->where('id_portal', $id);
            })
            ->firstOrFail();
        $div_puesto = $get_id->div_puesto;

        // Obtener el valor del campo `id_area` y convertirlo en un array
        $selected_area_ids = explode(',', $get_id->id_area);
        $selected_puesto_ids = explode(',', $get_id->acceso);

        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')->get();


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

        // dd($list_area);
        $list_procesos = ProcesosHistorial::select(
            'portal_procesos_historial.id_portal_historial',
            'portal_procesos_historial.id_portal',
            'portal_procesos_historial.version',
            'portal_procesos_historial.codigo',
            'portal_procesos_historial.nombre',
            'portal_procesos_historial.id_tipo',
            'portal_procesos_historial.id_area',
            'portal_procesos_historial.id_responsable',
            'portal_procesos_historial.fecha',
            'portal_procesos_historial.estado_registro',
            'portal_procesos_historial.archivo',
            'portal_procesos_historial.archivo4',
            'portal_procesos_historial.archivo5'


        )
            ->where('portal_procesos_historial.id_portal', '=', $id)
            ->where('portal_procesos_historial.estado', '=', 1)
            ->orderBy('portal_procesos_historial.codigo', 'ASC')
            ->get();


        // Preparar un array para almacenar los nombres de las áreas y del responsable
        foreach ($list_procesos as $proceso) {
            $ids = explode(',', $proceso->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            $proceso->nombres_area = $nombresAreas->implode(', ');
            $nombreResponsable = DB::table('puesto')
                ->where('id_puesto', $proceso->id_responsable)
                ->value('nom_puesto');
            $nombreTipoPortal = DB::table('tipo_portal')
                ->where('id_tipo_portal', $proceso->id_tipo)
                ->value('nom_tipo');

            $proceso->nombre_responsable = $nombreResponsable;
            $proceso->nombre_tipo_portal = $nombreTipoPortal;
            // dd($get_id->estado_registro, gettype($get_id->estado_registro));
            switch ($proceso->estado_registro) {
                case 0:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 1:
                    $proceso->estado_texto = 'Por aprobar';
                    break;
                case 2:
                    $proceso->estado_texto = 'Publicado';
                    break;
                case 3:
                    $proceso->estado_texto = 'Por actualizar';
                    break;
                default:
                    $proceso->estado_texto = 'Desconocido';
                    break;
            }
        }
        return view('interna.procesos.portalprocesos.listamaestra.modal_editar', compact(
            'get_id',
            'list_tipo',
            'list_responsable',
            'list_area',
            'selected_area_ids',
            'selected_puesto_ids',
            'div_puesto',
            'list_procesos',
        ));
    }

    public function store_cap(Request $request)
    {
        $id = $request->input('id_capacitacion');
        dd($id);
        // Obtener Lista Responsables
        $list_responsable = Puesto::select('id_puesto', 'nom_puesto')
            ->where('estado', 1)
            ->orderBy('id_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto')
            ->pluck('id_puesto')
            ->toArray();
        // Obtener Lista Area
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('id_area', 'ASC')
            ->get()
            ->unique('nom_area')
            ->pluck('id_area')
            ->toArray();

        // Cargar Imagenes
        $archivo = "";
        $documento = "";
        $diagrama = "";

        // Crear un nuevo registro en la tabla portal_procesos_historial
        ProcesosHistorial::create([
            'codigo' => $request->codigo ?? 'SIN CÓDIGO',
            'numero' => $request->ndocumento ?? '',
            'version' => 1,
            'nombre' => $request->nombre ?? '',
            'id_tipo' => $request->id_portal ?? null,
            'archivo' => $archivo ?? '',
            'archivo2' => $request->archivo2 ?? '',
            'archivo3' => $request->archivo3 ?? '',
            'archivo4' => $documento ?? '',
            'archivo5' => $diagrama ?? '',
            'user_aprob' => $request->user_aprob ?? 0,
            'fec_aprob' => $request->fec_aprob ?? null,
            'estado_registro' => $request->estado_registro ?? 1,
            'estado' => $request->estado ?? 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'fec_eli' => null,
            'user_eli' => null,

        ]);
    }



    public function create_cap()
    {
        // $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')
        // ->get();

        $list_users = User::select(
            'id_usuario',
            DB::raw("CONCAT(usuario_nombres, ' ', usuario_apater, ' ', usuario_amater) AS nombre_completo")
        )
            ->where('estado', 1)
            ->havingRaw("TRIM(nombre_completo) <> ''") // Filtra los resultados para excluir nombres vacíos
            ->orderBy('nombre_completo', 'ASC')
            ->distinct('id_usuario')
            ->get();


        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo', 'cod_tipo')->get();

        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        // $list_puesto = NivelJerarquico::select('id_nivel', 'nom_nivel')
        //     ->where('estado', 1)
        //     ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        return view('interna.procesos.capacitacion.capacitaciones.modal_registrar', compact('list_tipo', 'list_responsable', 'list_area', 'list_users'));
    }


    public function update_cap(Request $request, $id)
    {

        // Obtener el registro del historial de procesos
        $get_id = ProcesosHistorial::where('id_portal_historial', $id)->firstOrFail();

        // Inicializar variables para los archivos
        $archivo = $get_id->archivo;
        $documento = $get_id->archivo4;
        $diagrama = $get_id->archivo5;

        // Conectar al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            ftp_pasv($con_id, true);

            // Subir archivo 1 si se ha cargado
            if ($request->hasFile('archivo1e')) {
                if ($get_id->archivo) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo));
                }
                $archivo = $request->file('archivo1e')->getClientOriginalName();
                $request->file('archivo1e')->move(storage_path('app/temp'), $archivo);
                $source_file = storage_path('app/temp/' . $archivo);
                $subio = ftp_put($con_id, "PORTAL_PROCESOS/" . $archivo, $source_file, FTP_BINARY);
                if (!$subio) {
                    echo "Archivo 1 no subido correctamente";
                }
            }

            // Subir documento si se ha cargado
            if ($request->hasFile('documentoae')) {
                if ($get_id->archivo4) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo4));
                }
                $documento = $request->file('documentoae')->getClientOriginalName();
                $request->file('documentoae')->move(storage_path('app/temp'), $documento);
                $source_file_doc = storage_path('app/temp/' . $documento);
                $subio_doc = ftp_put($con_id, "PORTAL_PROCESOS/" . $documento, $source_file_doc, FTP_BINARY);
                if (!$subio_doc) {
                    echo "Documento no subido correctamente";
                }
            }

            // Subir diagrama si se ha cargado
            if ($request->hasFile('diagramaae')) {
                if ($get_id->archivo5) {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->archivo5));
                }
                $diagrama = $request->file('diagramaae')->getClientOriginalName();
                $request->file('diagramaae')->move(storage_path('app/temp'), $diagrama);
                $source_file_diag = storage_path('app/temp/' . $diagrama);
                $subio_diag = ftp_put($con_id, "PORTAL_PROCESOS/" . $diagrama, $source_file_diag, FTP_BINARY);
                if (!$subio_diag) {
                    echo "Diagrama no subido correctamente";
                }
            }

            ftp_close($con_id); // Cerrar conexión FTP
        } else {
            echo "No se conectó al servidor FTP";
        }

        // Actualiza la tabla 'ProcesosHistorial'
        DB::table('portal_procesos_historial')
            ->where('id_portal_historial', $id)
            ->update([
                'nombre' => $request->nombre,
                'id_tipo' => $request->id_tipo,
                'fecha' => $request->fecha,
                'id_responsable' => $request->id_responsablee,
                'codigo' => $request->codigo,
                'numero' => $request->ndocumento,
                'version' => $request->versione,
                'estado_registro' => $request->estadoe,
                'descripcion' => $request->descripcione ?? '',
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'archivo' => $archivo,
                'archivo4' => $documento,
                'archivo5' => $diagrama,
            ]);
    }




    // ADMINISTRABLE CAPACITACIÓN
    public function indexcap_conf()
    {

        $list_subgerencia = SubGerencia::list_subgerencia(9);
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna.administracion.procesos.index', compact('list_notificacion', 'list_subgerencia'));
    }
    public function index_cap_conf()
    {
        return view('interna.administracion.procesos.capacitacion.index');
    }

    public function list_cap_conf()
    {
        $list_capacitacion = Capacitacion::select('capacitacion.id_capacitacion', 'capacitacion.cod_capacitacion', 'capacitacion.id_area', 'capacitacion.nom_capacitacion', 'capacitacion.descripcion', 'area.nom_area')
            ->join('area', 'capacitacion.id_area', '=', 'area.id_area')
            ->where('capacitacion.estado', 1)
            ->orderBy('capacitacion.id_capacitacion', 'DESC')
            ->distinct('capacitacion.nom_capacitacion')
            ->get();
        return view('interna.administracion.procesos.capacitacion.lista', compact('list_capacitacion'));
    }

    public function edit_cap_conf($id)
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('id_area', 'ASC')
            ->get()
            ->unique('nom_area');
        $get_id = Capacitacion::findOrFail($id);
        return view('interna.administracion.procesos.capacitacion.modal_editar',  compact('get_id', 'list_area'));
    }

    public function destroy_cap_conf($id)
    {
        Capacitacion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function create_cap_conf()
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();



        return view('interna.administracion.procesos.capacitacion.modal_registrar', compact('list_area'));
    }

    public function store_cap_conf(Request $request)
    {
        $request->validate([
            'nom_capa' => 'required',
            'descripcion' => 'required',
        ], [
            'nom_capa.required' => 'Debe ingresar nombre.',
            'descripcion.required' => 'Debe ingresar descripción.',
        ]);
        // Obtener el último código de capacitación
        $lastCapacitacion = Capacitacion::orderBy('id_capacitacion', 'desc')->first();
        if ($lastCapacitacion) {
            // Extraer el número del último código (suponiendo que el código es siempre CP seguido de 5 números)
            $lastCodeNumber = intval(substr($lastCapacitacion->cod_capacitacion, 2));
            $newCodeNumber = $lastCodeNumber + 1;
        } else {
            // Si no existe un código previo, empezamos desde CP00001
            $newCodeNumber = 1;
        }

        $newCodCapacitacion = 'CP' . str_pad($newCodeNumber, 5, '0', STR_PAD_LEFT);
        Capacitacion::create([
            'nom_capacitacion' => $request->nom_capa,
            'descripcion' => $request->descripcion,
            'cod_capacitacion' => $newCodCapacitacion,
            'id_area' => $request->id_area,
            'estado' => 1,
            'orden' => '',
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function update_cap_conf(Request $request, $id)
    {
        $request->validate([
            'nombrecapae' => 'required',
            'descripcionee' => 'required',
        ], [
            'nombrecapae.required' => 'Debe seleccionar nombre.',
            'descripcionee.required' => 'Debe seleccionar descripción.',
        ]);

        Capacitacion::findOrFail($id)->update([
            'nom_capacitacion' => $request->nombrecapae,
            'descripcion' => $request->descripcionee,
            'id_area' => $request->id_areae,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }
}
