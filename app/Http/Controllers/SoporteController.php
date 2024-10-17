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
use App\Models\SedeLaboral;
use App\Models\Soporte;
use App\Models\SoporteUbicacion1;
use App\Models\SoporteUbicacion2;
use App\Models\SubGerencia;
use App\Models\Ubicacion;
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


    public function index_master()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.soporte_master.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function list_tick()
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_tickets_soporte = Soporte::listTicketsSoporte();

        // dd($list_tickets_soporte);
        return view('soporte.soporte.lista', compact('list_tickets_soporte'));
    }


    public function create_tick(Request $request)
    {
        $list_especialidad = Especialidad::select('id', 'nombre')
            ->where('id', '!=', 4)
            ->get();
        $especialidadConId4 = Especialidad::select('id', 'nombre')
            ->where('id', 4)
            ->first();
        if ($especialidadConId4) {
            $list_especialidad->push($especialidadConId4);
        }
        $list_elemento = ElementoSoporte::select('idsoporte_elemento', 'nombre')->get();
        $list_asunto = AsuntoSoporte::select('idsoporte_asunto', 'nombre')->get();
        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->whereNotIn('id', [3, 5]) // Excluir los id EXT y REMOTO
            ->get();

        $list_responsable = Puesto::select('puesto.id_puesto', 'puesto.nom_puesto', 'area.cod_area')
            ->join('area', 'puesto.id_area', '=', 'area.id_area')  // Realiza el INNER JOIN entre Puesto y Area
            ->where('puesto.estado', 1)
            ->orderBy('puesto.nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        $list_base = Base::get_list_todas_bases_agrupadas_bi();

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        return view('soporte.soporte.modal_registrar', compact('list_responsable', 'list_area', 'list_base', 'list_especialidad', 'list_elemento', 'list_asunto', 'list_sede'));
    }

    public function getSoporteUbicacionPorSede(Request $request)
    {
        $idSede = $request->input('sedes');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($idSede)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $sedes = SoporteUbicacion1::where(function ($query) use ($idSede) {
            $query->whereRaw("FIND_IN_SET(?, id_sede_laboral)", [$idSede]);
        })
            ->where('estado', 1)
            ->get();

        return response()->json($sedes);
    }



    public function getUbicacion2PorUbicacion1(Request $request)
    {
        $ubicacion = $request->input('ubicacion1');
        // dd($ubicacion);
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($ubicacion)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $ubicaciones = SoporteUbicacion2::where(function ($query) use ($ubicacion) {
            $query->whereRaw("FIND_IN_SET(?, id_soporte_ubicacion1)", [$ubicacion]);
        })
            ->where('estado', 1)
            ->get();

        return response()->json($ubicaciones);
    }


    public function getElementoPorEspecialidad(Request $request)
    {
        $idEspecialidad = $request->input('especialidad');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($idEspecialidad)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $elementos = ElementoSoporte::where(function ($query) use ($idEspecialidad) {
            $query->whereRaw("FIND_IN_SET(?, id_especialidad)", [$idEspecialidad]);
        })
            ->where('estado', 1)
            ->get();

        return response()->json($elementos);
    }

    public function getAsuntoPorElemento(Request $request)
    {
        $idElemento = $request->input('elemento');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($idElemento)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $asuntos = AsuntoSoporte::where(function ($query) use ($idElemento) {
            $query->whereRaw("FIND_IN_SET(?, idsoporte_elemento)", [$idElemento]);
        })
            ->where('estado', 1)
            ->get();

        return response()->json($asuntos);
    }



    public function store_tick(Request $request)
    {
        $request->validate([
            'especialidad' => 'gt:0',
            'elemento' => 'gt:0',
            'asunto' => 'gt:0',
            'sede' => 'gt:0',
            'idsoporte_ubicacion' => 'gt:0',
            'vencimiento' => 'required',
            'descripcion' => 'required',

        ], [
            'especialidad.gt' => 'Debe seleccionar especialidad.',
            'elemento.gt' => 'Debe seleccionar elemento.',
            'asunto.gt' => 'Debe seleccionar asunto.',
            'sede.gt' => 'Debe seleccionar sede.',
            'idsoporte_ubicacion.gt' => 'Debe ingresar Ubicaciòn.',
            'vencimiento.required' => 'Debe ingresar vencimiento.',
            'descripcion.required' => 'Debe ingresar descripcion.',

        ]);
        // dd($request->all());
        Soporte::create([
            'id_especialidad' => $request->especialidad,
            'id_elemento' => $request->elemento,
            'id_asunto' => $request->asunto,
            'id_sede' => $request->sede,
            'idsoporte_ubicacion' => $request->idsoporte_ubicacion,
            'idsoporte_ubicacion2' => $request->idsoporte_ubicacion2 ?? 0,
            'id_area' => $request->area ?? 0,
            'fec_vencimiento' => $request->vencimiento,
            'descripcion' => $request->descripcion,
            'estado' => 1,
            'estado_registro' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
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
