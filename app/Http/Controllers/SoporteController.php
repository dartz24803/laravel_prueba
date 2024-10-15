<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AsuntoSoporte;
use App\Models\Base;
use App\Models\BiReporte;
use App\Models\Capacitacion;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ElementoSoporte;
use App\Models\Especialidad;
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

class SoporteController extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.soporte.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function index_tick()
    {
        return view('interna.procesos.portalprocesos.listamaestra.index');
    }
    public function handleAreaP($id_area, $id_subgerencia)
    {
        $list_notificacion = Notificacion::get_list_notificacion();

        if ($id_subgerencia == 2) {
            $list_subgerencia = SubGerencia::list_subgerencia_with_validation($id_subgerencia);
        } else {
            $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia);
        }

        $id_puesto = session('usuario')->id_puesto;
        $list_reportes = BiReporte::getByAreaDestino($id_area, $id_puesto);

        // Asignar el valor de $nominicio basado en $id_subgerencia
        switch ($id_subgerencia) {
            case 1:
                $nominicio = 'seguridad';
                break;
            case 2:
                $nominicio = 'tienda';
                break;
            case 3:
                $nominicio = 'comercial';
                break;
            case 4:
                $nominicio = 'manufactura';
                break;
            case 5:
                $nominicio = 'rrhh';
                break;
            case 6:
                $nominicio = 'general';
                break;
            case 7:
                $nominicio = 'logistica';
                break;
            case 8:
                $nominicio = 'finanzas';
                break;
            case 9:
                $nominicio = 'interna'; // Repetido, asegúrate de que este valor sea correcto
                break;
            case 10:
                $nominicio = 'infraestructura';
                break;
            case 11:
                $nominicio = 'materiales';
                break;
            case 12:
                $nominicio = 'finanzas'; // Repetido, asegúrate de que este valor sea correcto
                break;
            case 13:
                $nominicio = 'caja';
                break;
            default:
                $nominicio = 'default'; // Valor por defecto si no coincide con ningún caso
                break;
        }

        return view('soporte.index', compact('id_area', 'list_notificacion', 'list_subgerencia', 'list_reportes', 'nominicio'));
    }
    public function list_tick()
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



    public function create_tick()
    {
        $list_especialidad = Especialidad::select('id', 'nombre')->get();
        $list_elemento = ElementoSoporte::select('idsoporte_elemento', 'nombre')->get();
        $list_asunto = AsuntoSoporte::select('idsoporte_asunto', 'nombre')->get();

        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        // $list_puesto = NivelJerarquico::select('id_nivel', 'nom_nivel')
        //     ->where('estado', 1)
        //     ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        return view('soporte.soporte.modal_registrar', compact('list_responsable', 'list_area', 'list_base', 'list_especialidad', 'list_elemento', 'list_asunto'));
    }


    public function update_tick(Request $request, $id)
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

    public function destroy_tick($id)
    {

        ProcesosHistorial::where('id_portal_historial', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }


    public function approve_tick($id)
    {

        ProcesosHistorial::where('id_portal_historial', $id)->update([
            'estado_registro' => 2,
            'fec_aprob' => now(),
            'user_aprob' => session('usuario')->id_usuario
        ]);
    }
}
