<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\NivelJerarquico;
use App\Models\Procesos;
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

class ProcesosController extends Controller
{

    public function index()
    {
        return view('procesos.portalprocesos.index');
    }


    public function index_lm()
    {
        return view('procesos.portalprocesos.listamaestra.index');
    }


    public function index_lm_conf()
    {
        return view('procesos.administracion.portalprocesos.index');
    }

    public function list_lm()
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_procesos = Procesos::select(
            'portal_procesos.id_portal',
            'portal_procesos.codigo',
            'portal_procesos.nombre',
            'portal_procesos.id_tipo',
            'portal_procesos.id_area',
            'portal_procesos.id_responsable',
            'portal_procesos.fecha',
            'portal_procesos.estado_registro'
        )
            ->whereNotNull('portal_procesos.codigo')
            ->where('portal_procesos.codigo', '!=', '')
            ->where('portal_procesos.estado', '=', 1)
            ->orderBy('portal_procesos.codigo', 'ASC')
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

        return view('procesos.portalprocesos.listamaestra.lista', compact('list_procesos'));
    }



    public function create_lm()
    {
        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')
            ->get();
        $list_responsable = Puesto::select('id_puesto', 'nom_puesto')
            ->where('estado', 1)
            ->orderBy('nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_gerencia = Gerencia::select('id_gerencia', 'nom_gerencia')->where('estado', 1)->get();
        $list_nivel = NivelJerarquico::select('id_nivel', 'nom_nivel')->where('estado', 1)->get();

        $list_puesto = NivelJerarquico::select('id_nivel', 'nom_nivel')
            ->where('estado', 1)
            ->get();
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        return view('procesos.portalprocesos.listamaestra.modal_registrar', compact('list_tipo', 'list_responsable', 'list_area', 'list_puesto', 'list_base', 'list_gerencia', 'list_nivel'));
    }



    public function image_lm($id)
    {
        $get_id = Procesos::findOrFail($id);
        // Construye la URL completa de la imagen
        $imageUrl = null;
        if ($get_id->archivo) {
            $imageUrl = "https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/" . $get_id->archivo;
        }
        return view('procesos.portalprocesos.listamaestra.modal_imagen', compact('get_id', 'imageUrl'));
    }

    public function image_edit_lm($id)
    {
        $get_id = Procesos::findOrFail($id);
        // Construye la URL completa de la imagen
        $imageUrl = null;
        if ($get_id->archivo) {
            $imageUrl = "https://lanumerounocloud.com/intranet/PORTAL_PROCESOS/" . $get_id->archivo;
        }
        return view('procesos.portalprocesos.listamaestra.modal_imagen', compact('get_id', 'imageUrl'));
    }


    public function store_lm(Request $request)
    {
        $id = $request->input('id_portal');

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
        $get_id = Procesos::findOrFail($id);

        $archivo = "";
        if ($_FILES["archivo1"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if ($get_id->imagen != "") {
                    ftp_delete($con_id, 'PORTAL_PROCESOS/' . basename($get_id->imagen));
                }
                $path = $_FILES["archivo1"]["name"];
                $source_file = $_FILES['archivo1']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $_FILES["archivo1"]["name"];

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "PORTAL_PROCESOS/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $archivo =  $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }
        // Cargar Imagenes


        // Crear un nuevo registro de Portal Procesos utilizando el método estático create
        $portal = Procesos::create([
            'nombre' => $request->nombre ?? '',
            'id_tipo' => $request->id_portal ?? null,
            'fecha' => $request->fecha ?? null,
            'id_responsable' => is_array($request->id_puesto) ? implode(',', $request->id_puesto) : $request->id_puesto ?? '',
            'id_area' => is_array($request->id_area) ? implode(',', $request->id_area) : $request->id_area ?? '',
            'numero' => $request->ndocumento ?? '',
            'version' =>  1,
            'descripcion' => $request->descripcion ?? '',
            'cod_portal' => '22TEST', // Puedes mantener este campo vacío o asignarlo según tu lógica
            'codigo' => $request->codigo ?? 'LNU-T-D05-T',
            'etiqueta' => is_array($request->etiqueta) ? implode(',', $request->etiqueta) : $request->etiqueta ?? '',
            'acceso' => $accesoTodo
                ? $list_responsable_string
                : (is_array($request->id_puesto_acceso) ? implode(',', $request->id_puesto_acceso) : $request->id_puesto_acceso ?? ''),
            'acceso_area' => $accesoTodo
                ? $list_area_string
                : (is_array($request->id_area_acceso) ? implode(',', $request->id_area_acceso) : $request->id_area_acceso ?? ''),
            'acceso_nivel' => $accesoTodo ? $list_niveljerarquico_string
                : (is_array($request->id_nivel_acceso) ? implode(',', $request->id_nivel_acceso) : $request->id_nivel_acceso ?? ''),
            // 'acceso_nivel' => $accesoTodo ? $list_niveljerarquico_string : '', // Asignar la cadena de IDs si acceso_todo es 1
            'acceso_gerencia' => $accesoTodo ? $list_gerencia_string
                : (is_array($request->id_gerencia_acceso) ? implode(',', $request->id_gerencia_acceso) : $request->id_gerencia_acceso ?? ''),
            // 'acceso_base' => $accesoTodo ? $list_base_string : '', // Asignar la cadena de IDs si acceso_todo es 1
            'acceso_base' => $accesoTodo ? $list_base_string
                : (is_array($request->id_base_acceso) ? implode(',', $request->id_base_acceso) : $request->id_base_acceso ?? ''),
            'acceso_todo' => $accesoTodo,

            'div_puesto' => $accesoTodo ? 0 : (!empty(implode(',', (array) $request->id_puesto_acceso)) ? 1 : 0),
            'div_base' => $accesoTodo ? 0 : (!empty(implode(',', (array) $request->id_base_acceso)) ? 1 : 0),
            // 'div_base' => $accesoTodo ? 0 : 1,
            'div_area' => $accesoTodo ? 0 : (!empty(implode(',', (array) $request->id_area_acceso)) ? 1 : 0),
            // 'div_area' => $accesoTodo ?  0 : 1,
            'div_nivel' => $accesoTodo ? 0 : (!empty(implode(',', (array) $request->id_nivel_acceso)) ? 1 : 0),
            // 'div_nivel' => $accesoTodo ?  0 : 1,
            'div_gerencia' => $accesoTodo ? 0 : (!empty(implode(',', (array) $request->id_gerencia_acceso)) ? 1 : 0),
            // 'div_gerencia' => $accesoTodo ? 0 : 1,
            'archivo' => $archivo ?? '',
            'archivo2' => $request->archivo2 ?? '',
            'archivo3' => $request->archivo3 ?? '',
            'archivo4' => $request->archivo4 ?? '',
            'archivo5' => $request->archivo5 ?? '',
            'user_aprob' => $request->user_aprob ?? null,
            'fec_aprob' => $request->fec_aprob ?? null,
            'estado_registro' => $request->estado_registro ?? 1,
            'estado' => $request->estado ?? 1,
            'fec_reg' => $request->fec_reg ?? now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => $request->fec_act ?? null,
            'user_act' => $request->user_act ?? null,
            'fec_eli' => $request->fec_eli ?? null,
            'user_eli' => $request->user_eli ?? null,
        ]);




        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Portal registrado con éxito.');
    }


    public function destroy_lm($id)
    {
        Procesos::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function edit_lm($id)
    {
        $get_id = Procesos::findOrFail($id);
        // Obtener el valor del campo `id_area` y convertirlo en un array
        $selected_area_ids = explode(',', $get_id->id_area);
        $list_tipo = TipoPortal::select('id_tipo_portal', 'nom_tipo')->get();
        $list_responsable = Puesto::select('id_puesto', 'nom_puesto')
            ->where('estado', 1)
            ->orderBy('nom_puesto', 'ASC')
            ->get()
            ->unique('nom_puesto');

        // Cambiar la consulta para obtener objetos en lugar de IDs
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('id_area', 'ASC')
            ->get()
            ->unique('nom_area');

        return view('procesos.portalprocesos.listamaestra.modal_editar', compact('get_id', 'list_tipo', 'list_responsable', 'list_area', 'selected_area_ids'));
    }
}
