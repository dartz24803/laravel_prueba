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
use App\Models\EjecutorResponsable;
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
use App\Models\Pendiente;
use App\Models\SedeLaboral;
use App\Models\Soporte;
use App\Models\SoporteAreaEspecifica;
use App\Models\SoporteEjecutor;
use App\Models\SoporteMotivoCancelacion;
use App\Models\SoporteNivel;
use App\Models\SoporteSolucion;
use App\Models\SoporteComentarios;
use Illuminate\Support\Facades\Storage;

use App\Models\SubGerencia;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Exception;
use Google\Service\AndroidEnterprise\Resource\Users;
use PHPMailer\PHPMailer\PHPMailer;

class SoporteController extends Controller
{
    protected $id_subgerenciam;

    public function __construct(Request $request)
    {
        // Aquí validamos que el id_subgerencia venga en el request
        $this->id_subgerenciam = $request->route('id_subgerencia');
    }


    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.soporte.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_tick()
    {
        $list_tickets_soporte = Soporte::listTicketsSoporte();
        $id_usuario = session('usuario')->id_usuario;
        $acceso_pp = Soporte::userExistsInAreaWithPuesto(18, $id_usuario);
        // VALIDACIÓN DE ESTADOS EN PROCESO Y COMPLETADO PARA CADA MODULO
        $list_tickets_soporte = $list_tickets_soporte->map(function ($ticket) {;
            $ticket->status_poriniciar = false;
            $ticket->status_enproceso = false;
            $ticket->status_completado = false;
            $ticket->status_standby = false;
            $ticket->status_cancelado = false;
            $ticket->status_derivado = false;

            $multirepsonsable = Soporte::getResponsableMultipleByAsunto($ticket->id_asunto);

            if (($ticket->estado_registro_sr == 3 && $ticket->estado_registro == 3) || ($ticket->estado_registro == 3 && $multirepsonsable == 0)) {
                $ticket->status_completado = true;
            } elseif ($ticket->estado_registro_sr == 5 || $ticket->estado_registro == 5) {
                $ticket->status_cancelado = true;
            } elseif ($ticket->estado_registro_sr == 4 || $ticket->estado_registro == 4) {
                $ticket->status_standby = true;
            } elseif ($ticket->estado_registro_sr == 2 || $ticket->estado_registro == 2) {
                $ticket->status_enproceso = true;
            } elseif ($ticket->estado_registro == 6 || $ticket->estado_registro_sr == 6) {
                $ticket->status_derivado = true;
            } elseif ($ticket->estado_registro_sr == 1 || $ticket->estado_registro == 1) {
                $ticket->status_poriniciar = true;
            } else {
                $ticket->status_enproceso = true;
            }

            return $ticket;
        });
        return view('soporte.soporte.lista', compact('list_tickets_soporte', 'acceso_pp'));
    }


    public function create_tick(Request $request)
    {
        $list_especialidad = Especialidad::select('id', 'nombre')
            ->where('especialidad.estado', 1)
            ->where('id', '!=', 4)
            ->orderBy('nombre', 'asc')
            ->get();
        $especialidadConId4 = Especialidad::select('id', 'nombre')
            ->where('id', 4)
            ->first();
        if ($especialidadConId4) {
            $list_especialidad->push($especialidadConId4);
        }

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->whereIn('id_area', [41, 25])
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        return view('soporte.soporte.modal_registrar', compact('list_area', 'list_especialidad'));
    }

    public function getSoporteNivelPorSede()
    {
        // Obtener id_sede desde la función estática de SedeLaboral
        $idSede = SedeLaboral::obtenerIdSede();
        // Si no se obtiene id_sede, devolver un arreglo vacío
        if (empty($idSede)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $sedes = SoporteNivel::where(function ($query) use ($idSede) {
            $query->whereRaw("FIND_IN_SET(?, id_sede_laboral)", [$idSede]);
        })
            ->where('estado', 1)
            ->get();

        return response()->json($sedes);
    }




    public function getAreaEspeficaPorNivel(Request $request)
    {
        $ubicacion = $request->input('ubicacion1');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($ubicacion)) {
            return response()->json([]);
        }
        // Buscar ubicaciones asociadas a la sede seleccionada
        $ubicaciones = SoporteAreaEspecifica::where(function ($query) use ($ubicacion) {
            $query->whereRaw("FIND_IN_SET(?, id_soporte_nivel)", [$ubicacion]);
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
            ->orderBy('nombre', 'asc')
            ->get();
        return response()->json($elementos);
    }

    public function getAsuntoPorElemento(Request $request)
    {
        $idElemento = $request->input('elemento');
        if (empty($idElemento)) {
            return response()->json([]);
        }

        // Buscar ubicaciones asociadas a la sede seleccionada, incluyendo `evidencia_adicional`
        $asuntos = AsuntoSoporte::where(function ($query) use ($idElemento) {
            $query->whereRaw("FIND_IN_SET(?, idsoporte_elemento)", [$idElemento]);
        })
            ->where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get(['idsoporte_asunto', 'nombre', 'evidencia_adicional']); // Incluir evidencia_adicional en la consulta

        return response()->json($asuntos);
    }



    public function store_tick(Request $request)
    {
        $rules = [
            'especialidad' => 'gt:0',
            'idsoporte_nivel' => 'gt:0',
            'vencimiento' => 'required',
            'descripcion' => 'required',
            'descripcion' => 'max:150',
        ];
        $messages = [
            'especialidad.gt' => 'Debe seleccionar especialidad.',
            'idsoporte_nivel.gt' => 'Debe ingresar Ubicaciòn.',
            'vencimiento.required' => 'Debe ingresar vencimiento.',
            'descripcion.required' => 'Debe ingresar propósito.',
            'descripcion.max' => 'El propósito debe tener como máximo 150 carácteres.',
        ];
        if ($request->hasOptionsFieldEspecialidad == "0") {
            $rules = array_merge($rules, [
                'asunto' => 'gt:0',
                'elemento' => 'gt:0',
            ]);
            $messages = array_merge($messages, [
                'asunto.gt' => 'Debe seleccionar asunto.',
                'elemento.gt' => 'Debe seleccionar elemento.',
            ]);
        }

        if ($request->hasOptionsField == "1") {
            $rules = array_merge($rules, [
                'idsoporte_area_especifica' => 'gt:0',
            ]);

            $messages = array_merge($messages, [
                'idsoporte_area_especifica.gt' => 'Debe seleccionar Área Específica',
            ]);
        }

        if ($request->especialidad == 4) {
            $rules = array_merge($rules, [
                'area' => 'gt:0',
            ]);

            $messages = array_merge($messages, [
                'area.gt' => 'Debe seleccionar Área',
            ]);
        }
        // GENERACIÓN DE CÓDIGO
        $cod_area = Soporte::getCodAreaByAsunto($request->asunto); // Obtiene el área
        $request->validate($rules, $messages);
        $idsoporte_tipo = DB::table('soporte_asunto as sa')
            ->leftJoin('soporte_tipo as st', 'st.idsoporte_tipo', '=', 'sa.idsoporte_tipo')
            ->where('sa.idsoporte_asunto', $request->asunto)
            ->select('sa.idsoporte_tipo')
            ->first();

        if ($idsoporte_tipo) {
            // Usa el valor de $cod_area en lugar de 'TI'
            $area_code = $cod_area ? $cod_area['cod_area'] : 'TI';
            $prefijo = $idsoporte_tipo->idsoporte_tipo == 1 ? 'RQ-' . $area_code . '-' : 'INC-' . $area_code . '-';
            $contador = Soporte::leftJoin('soporte_asunto', 'soporte.id_asunto', '=', 'soporte_asunto.idsoporte_asunto')
                ->leftJoin('soporte_tipo', 'soporte_asunto.idsoporte_tipo', '=', 'soporte_tipo.idsoporte_tipo')
                ->where('soporte_tipo.idsoporte_tipo', $idsoporte_tipo->idsoporte_tipo)
                ->count();
            $nuevo_numero = $contador + 1;
            $numero_formateado = str_pad($nuevo_numero, 3, '0', STR_PAD_LEFT);
            $codigo_generado = $prefijo . $numero_formateado;
        } else {
            $codigo_generado = 'Código no disponible';
        }
        // GENERECIÓN DE CÓDIGO

        $soporte_solucion = SoporteSolucion::create([
            'estado_solucion' => 0,
            'archivo_solucion' => 0,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        $soporte_ejecutor = SoporteEjecutor::create([
            'idejecutor_responsable' => null,
            'fec_inicio_proyecto' => null,
            'nombre_proyecto' => '',
            'proveedor' => '',
            'nombre_contratista' => '',
            'dni_prestador_servicio' => '',
            'ruc' => '',
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        SoporteComentarios::create([
            'idsoporte_solucion' => $soporte_solucion->idsoporte_solucion,
            'id_responsable' => null,
            'comentario' => '',
            'estado' => 1,
            'fec_comentario' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        // Almacenar Imagenes
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);


        if ($con_id && $lr) {
            // Decodificar las URLs de las imágenes desde el request
            $imagenes = json_decode($request->input('imagenes'), true);
            $evidenciaAdicional = AsuntoSoporte::obtenerEvidenciaAdicionalPorId($request->asunto);
            // $imagenes = $request->file('imagenes'); // Asumiendo que estás recibiendo imágenes en una variable llamada 'imagenes'
            if ($evidenciaAdicional == 1) {
                // Validar que haya entre 3 y 5 imágenes
                if (!is_array($imagenes) || count($imagenes) < 3 || count($imagenes) > 5) {
                    return response()->json([
                        'error' => 'Debe cargar al menos 3 fotos y máximo 5 fotos.'
                    ], 400);
                }
            } else {
                // Validar que al menos haya una imagen
                if (!$imagenes || !is_array($imagenes)) {
                    return response()->json([
                        'error' => 'Debe cargar al menos una foto.'
                    ], 400);
                }
            }

            // // Inicializar un array para almacenar los resultados
            $resultados = [];
            // Subida de imágenes
            $resultados = $this->uploadImages($imagenes, $con_id);
            if (!$resultados) {
                return response()->json(['error' => 'No se pudo subir alguna imagen'], 500);
            }
            // Eliminación de archivos temporales en SOPORTE/TEMPORAL
            $this->deleteTempFiles($con_id, "SOPORTE/TEMPORAL/");
            ftp_close($con_id);
            // Obtener los campos de imagen
            $img1 = isset($resultados[0]) ? $resultados[0]['url_ftp'] : '';
            $img2 = isset($resultados[1]) ? $resultados[1]['url_ftp'] : '';
            $img3 = isset($resultados[2]) ? $resultados[2]['url_ftp'] : '';
            $img4 = isset($resultados[3]) ? $resultados[3]['url_ftp'] : '';
            $img5 = isset($resultados[4]) ? $resultados[4]['url_ftp'] : '';
            $idSede = SedeLaboral::obtenerIdSede();

            // Almacenar la información de soporte en la base de datos
            Soporte::create([
                'codigo' => $codigo_generado,
                'id_especialidad' => $request->especialidad,
                'id_elemento' => $request->elemento ?? 6,
                'id_asunto' => $request->asunto === "0" ? 245 : $request->asunto,
                'id_sede' => $idSede,
                'idsoporte_nivel' => $request->idsoporte_nivel,
                'idsoporte_area_especifica' => $request->idsoporte_area_especifica ?? 0,
                'id_area' => $request->area ?? 0,
                'id_responsable' => null,
                'area_cancelacion' => 0,
                'idsoporte_motivo_cancelacion' => null,
                'idsoporte_solucion' => $soporte_solucion->idsoporte_solucion,
                'idsoporte_ejecutor' => $soporte_ejecutor->idsoporte_ejecutor,
                'fec_vencimiento' => $request->vencimiento,
                'descripcion' => $request->descripcion,
                'estado' => 1,
                'estado_registro' => 1,
                'estado_registro_sr' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
                'img1' => $img1,
                'img2' => $img2,
                'img3' => $img3,
                'img4' => $img4,
                'img5' => $img5,
                'tipo_otros' => $request->nombre_tipo,
                'activo_tipo' => $request->asunto === "0" ? 1 : 0
            ]);

            return response()->json([
                'success' => 'Imágenes subidas correctamente al servidor FTP',
                'resultados' => $resultados
            ]);
        } else {
            return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
        }

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    protected function uploadImages($imagenes, $ftp_connection)
    {
        $resultados = [];
        foreach ($imagenes as $url) {
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $nombre_soli = "soporte_" . session('usuario')->id_usuario . "_" . date('YmdHis') . "_" . uniqid();
            $nombre = $nombre_soli . '.' . strtolower($extension);
            $ftp_upload_path = "SOPORTE/" . $nombre;

            $source_file = tempnam(sys_get_temp_dir(), 'ftp_');
            file_put_contents($source_file, file_get_contents($url));

            if (ftp_put($ftp_connection, $ftp_upload_path, $source_file, FTP_BINARY)) {
                $archivo_ftp = "https://lanumerounocloud.com/intranet/SOPORTE/" . $nombre;
                $resultados[] = ['url_ftp' => $archivo_ftp, 'identificador' => $nombre_soli];
            }

            unlink($source_file);
        }
        return $resultados;
    }

    protected function deleteTempFiles($ftp_connection, $temp_folder)
    {
        $file_list = ftp_nlist($ftp_connection, $temp_folder);
        foreach ($file_list as $file) {
            if (!in_array(basename($file), ['.', '..'])) {
                ftp_delete($ftp_connection, $file);
            }
        }
    }


    public function ver_tick($id_soporte)
    {
        $get_id = Soporte::getTicketById($id_soporte);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $comentarios = SoporteSolucion::getComentariosBySolucion($get_id->idsoporte_solucion);

        $cantAreasEjecut = count($list_ejecutores_responsables);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);
        return view('soporte.soporte.modal_ver', compact('get_id', 'list_areas_involucradas', 'ejecutoresMultiples', 'comentarios'));
    }

    public function update_tick(Request $request, $id)
    {
        $rules = [
            // 'ejecutor_responsable' => 'in:-1,3,4',
            'descripcione' => 'required',
            'descripcione' => 'max:150',
        ];
        $messages = [
            // 'ejecutor_responsable.in' => 'Debe seleccionar Ejecutor Responsable',
            'descripcione.required' => 'Debe ingresar propósito.',
            'descripcione.max' => 'El propósito debe tener como máximo 150 carácteres.',
        ];
        $request->validate($rules, $messages);
        $idSede = SedeLaboral::obtenerIdSede();
        // Almacenar Imagenes
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            // Decodificar las URLs de las imágenes desde el request
            $imagenes = json_decode($request->input('imagenes'), true);
            // Inicializar un array para almacenar los resultados de la subida
            $resultados = [];
            // Verificar si $imagenes es un array válido y tiene al menos una imagen
            if ($imagenes && is_array($imagenes)) {
                $resultados = $this->uploadImages($imagenes, $con_id);
                if (!$resultados) {
                    return response()->json(['error' => 'No se pudo subir alguna imagen'], 500);
                }
                // Obtener los campos de imagen si se subieron imágenes exitosamente
                $img1 = isset($resultados[0]) ? $resultados[0]['url_ftp'] : '';
                $img2 = isset($resultados[1]) ? $resultados[1]['url_ftp'] : '';
                $img3 = isset($resultados[2]) ? $resultados[2]['url_ftp'] : '';
                $img4 = isset($resultados[3]) ? $resultados[3]['url_ftp'] : '';
                $img5 = isset($resultados[4]) ? $resultados[4]['url_ftp'] : '';
            }
            // Construir los datos de actualización
            $idSede = SedeLaboral::obtenerIdSede();
            $data = [
                'id_sede' =>  $idSede,
                'idsoporte_nivel' =>  $request->idsoporte_nivele,
                'idsoporte_area_especifica' => $request->idsoporte_area_especificae,
                'fec_vencimiento' =>  $request->fec_vencimiento,
                'id_especialidad' =>  $request->especialidade,
                'id_elemento' => $request->elementoe ?? 6,
                'id_asunto' => $request->asuntoe === "0" ? 245 : $request->asuntoe,
                'descripcion' => $request->descripcione,
                'id_area' => $request->areae,
                'estado_registro' => 1,
                'estado_registro_sr' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario,
            ];
            // Agregar solo las imágenes si existen
            if (!empty($resultados)) {
                $data['img1'] = $img1;
                $data['img2'] = $img2;
                $data['img3'] = $img3;
                $data['img4'] = $img4;
                $data['img5'] = $img5;
            }

            // Actualizar la base de datos
            Soporte::findOrFail($id)->update($data);
            // Eliminar archivos temporales en SOPORTE/TEMPORAL si se subieron imágenes
            if (!empty($resultados)) {
                $this->deleteTempFiles($con_id, "SOPORTE/TEMPORAL/");
            }
            ftp_close($con_id);
            return response()->json([
                'success' => 'Imágenes subidas correctamente al servidor FTP',
                'resultados' => $resultados
            ]);
        } else {
            return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
        }
    }

    public function destroy_tick($id)
    {
        Soporte::where('id_soporte', $id)->firstOrFail()->update([
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



    // SOPORTE MASTER 
    public function index_master($id_subgerencia)
    {
        session(['id_subgerenciam' => $id_subgerencia]);

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
                $nominicio = 'interna';
                break;
            case 10:
                $nominicio = 'infraestructura';
                break;
            case 11:
                $nominicio = 'materiales';
                break;
            case 12:
                $nominicio = 'finanzas';
                break;
            case 13:
                $nominicio = 'caja';
                break;
            default:
                $nominicio = 'default';
                break;
        }
        $list_subgerencia = SubGerencia::list_subgerencia($id_subgerencia);

        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.soporte_master.index', compact('list_notificacion', 'list_subgerencia', 'nominicio'));
    }

    public function list_tick_master()
    {
        // Obtener el id_subgerencia de la sesión
        $id_subgerencia = session('id_subgerenciam');
        // Obtener la lista de tickets relacionados con el soporte
        $list_tickets_soporte = Soporte::listTicketsSoporteMaster($id_subgerencia);
        // Procesar cada ticket para determinar su estado
        $list_tickets_soporte = $list_tickets_soporte->map(function ($ticket) use ($id_subgerencia) {
            // Inicializamos todos los estados como false
            $ticket->status_poriniciar = false;
            $ticket->status_enproceso = false;
            $ticket->status_completado = false;
            $ticket->status_stand_by = false;
            $ticket->status_cancelado = false;
            $ticket->status_derivado = false;

            // Obtener el responsable múltiple para el asunto del ticket
            // $responsable_multiple = Soporte::getResponsableMultipleByAsunto($ticket->id_asunto);
            // Si la subgerencia es 9, validamos los estados relacionados con estado_registro_sr
            // dd($ticket);
            if ($id_subgerencia == 9) {
                switch ($ticket->estado_registro) {
                    case 6:
                        $ticket->status_derivado = true;
                        break;
                    case 5:
                        $ticket->status_cancelado = true;
                        break;
                    case 4:
                        $ticket->status_stand_by = true;
                        break;
                    case 3:
                        $ticket->status_completado = true;
                        break;
                    case 2:
                        $ticket->status_enproceso = true;
                        break;
                    case 1:
                    case null:
                        // Validación de null para estado_registro_sr
                        $ticket->status_poriniciar = true;
                        break;
                }
            } else {
                // Si no es subgerencia 9, validamos los estados relacionados con estado_registro
                switch ($ticket->estado_registro_sr) {
                    case 6:
                        $ticket->status_derivado = true;
                        break;
                    case 5:
                        $ticket->status_cancelado = true;
                        break;
                    case 4:
                        $ticket->status_stand_by = true;
                        break;
                    case 3:
                        $ticket->status_completado = true;
                        break;
                    case 2:
                        $ticket->status_enproceso = true;
                        break;
                    case 1:
                        $ticket->status_poriniciar = true;
                        break;
                }
            }


            return $ticket;
        });

        // Devolver la vista con la lista de tickets procesados
        return view('soporte.soporte_master.lista', compact('list_tickets_soporte'));
    }




    public function ver_tick_master($id_soporte)
    {
        $get_id = Soporte::getTicketById($id_soporte);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        $comentarios = SoporteSolucion::getComentariosBySolucion($get_id->idsoporte_solucion);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);

        return view('soporte.soporte_master.modal_ver', compact('get_id', 'ejecutoresMultiples', 'list_areas_involucradas', 'comentarios'));
    }

    public function edit_tick($id_soporte)
    {

        $get_id = Soporte::getTicketById($id_soporte);

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        $list_especialidad = Especialidad::select('id', 'nombre')
            ->where('especialidad.estado', 1)
            ->where('id', '!=', 4)
            ->get();

        $especialidadConId4 = Especialidad::select('id', 'nombre')
            ->where('id', 4)
            ->first();
        if ($especialidadConId4) {
            $list_especialidad->push($especialidadConId4);
        }

        $list_sede = SedeLaboral::select('id', 'descripcion')
            ->where('estado', 1)
            ->whereNotIn('id', [3, 5]) // Excluir los id EXT y REMOTO
            ->get();

        $list_elementos = ElementoSoporte::select('idsoporte_elemento', 'nombre')
            ->where('estado', 1)
            ->get();

        $list_asunto = AsuntoSoporte::select('idsoporte_asunto', 'nombre')->get();

        return view('soporte.soporte.modal_editar', compact('get_id', 'list_especialidad', 'list_area', 'list_sede', 'list_elementos', 'list_asunto'));
    }


    public function edit_tick_master($id_soporte)
    {
        $id_subgerencia = session('id_subgerenciam');
        $get_id = Soporte::getTicketById($id_soporte);
        $comentarios_user = SoporteSolucion::getComentariosUserBySolucion($get_id->idsoporte_solucion);
        if ($get_id->id_asunto == 245) {
            // Si el id_asunto es 245, obtenemos id_area directamente de la tabla soporte
            $idArea = DB::table('soporte')
                ->where('soporte.id_soporte', $get_id->id_soporte)
                ->select('soporte.id_area')
                ->first();
        } else {
            // En otros casos, mantenemos el leftJoin con la tabla area para obtener nom_area
            $idArea = DB::table('soporte_asunto')
                ->leftJoin('area', 'soporte_asunto.id_area', '=', 'area.id_area')
                ->where('soporte_asunto.idsoporte_asunto', $get_id->id_asunto)
                ->select('soporte_asunto.id_area')
                ->first();
        }
        if ($idArea && $idArea->id_area == 0) {
            $areaResponsable = $get_id->id_area;
        } else {
            $areaResponsable = $idArea->id_area;  // Accedemos directamente a la propiedad id_area
        }
        // Dividir el campo `id_area` en un array de IDs
        $areaIds = is_string($areaResponsable) ? explode(',', $areaResponsable) : [$areaResponsable];
        // Crear listas basadas en los IDs obtenidos
        $list_primer_responsable = Usuario::get_list_colaborador_xarea_static(trim($areaIds[0]));
        $list_segundo_responsable = isset($areaIds[1]) ? Usuario::get_list_colaborador_xarea_static(trim($areaIds[1])) : [];
        // Verificar que las listas tengan al menos un elemento antes de acceder al campo `id_sub_gerencia`
        $primer_id_subgerencia = !empty($list_primer_responsable) ? $list_primer_responsable[0]->id_sub_gerencia : null;
        $segundo_id_subgerencia = !empty($list_segundo_responsable) ? $list_segundo_responsable[0]->id_sub_gerencia : null;
        if ($id_subgerencia == $primer_id_subgerencia) {
            $list_responsable = $list_primer_responsable;
        } else {
            $list_responsable = $list_segundo_responsable;
        }

        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto, $idArea->id_area);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);
        $list_ejecutores_responsables = collect($list_ejecutores_responsables);

        if ($list_ejecutores_responsables->count() > 3) {
            $filtered = $list_ejecutores_responsables->filter(function ($item) {
                return in_array($item->idejecutor_responsable, [1, 2]);
            });
            // Crear el nuevo objeto consolidado
            $consolidated = (object)[
                'idejecutor_responsable' => "3,4",
                'nombre' => 'AREA',
                'id_area' => 0,
            ];
            // Combina el array filtrado con el nuevo objeto consolidado
            $filtered = $filtered->push($consolidated);
            $list_ejecutores_responsables = $filtered->values();
        }
        return view('soporte.soporte_master.modal_editar', compact('get_id', 'list_responsable',  'list_ejecutores_responsables', 'ejecutoresMultiples', 'list_areas_involucradas', 'id_subgerencia', 'comentarios_user'));
    }

    public function update_tick_master(Request $request, $id)
    {
        $id_subgerencia = session('id_subgerenciam');


        if ($request->nombre_tipo == 0) {
            $tipo_otros = 0;
        } else {
            $tipo_otros = $request->nombre_tipo;
        }
        $get_id = Soporte::getTicketById($id);
        $rules = [
            'descripcione_solucion' => function ($attribute, $value, $fail) use ($get_id) {
                if ($get_id->comentario_existe == 0 && empty($value)) {
                    $fail('Comentario de Solución es obligatorio cuando no existe un comentario.');
                }
            },
            'nombre_tipo' => $get_id->activo_tipo == 1 && $get_id->tipo_otros == 0 ? 'required|gt:0' : 'nullable',
        ];

        $messages = [
            'descripcione_solucion.max' => 'Comentario de Solución debe tener como máximo 150 caracteres.',
            'nombre_tipo.gt' => 'Debe seleccionar tipo.',
        ];

        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        $responsableMultiple = Soporte::getResponsableMultipleByAsunto($get_id->id_asunto);
        if ($id_subgerencia == "9" && $responsableMultiple == 1) {
            $rules = array_merge($rules, [
                'id_responsablee_0' => 'gt:0',
            ]);
            $messages = array_merge($messages, [
                'id_responsablee_0.gt' => 'Debe seleccionar Responsable',
            ]);
        }
        if ($id_subgerencia == "10") {
            $rules = array_merge($rules, [
                'id_responsablee_1' => 'gt:0',

            ]);
            $messages = array_merge($messages, [
                'id_responsablee_1.gt' => 'Debe seleccionar Responsable',

            ]);
        }
        if ($cantAreasEjecut < 4) {
            $rules = array_merge($rules, [
                'id_responsablee' => 'gt:0',
            ]);
            $messages = array_merge($messages, [
                'id_responsablee.gt' => 'Debe seleccionar Responsable',
            ]);
        }
        if ($request->ejecutor_responsable == 2) {
            $rules = array_merge($rules, [
                'nom_proyecto' => 'required',
                'proveedor' => 'required',
                'nom_contratista' => 'required',
            ]);
            $messages = array_merge($messages, [
                'nom_proyecto.required' => 'Debe ingresar Nombre del Proyecto',
                'proveedor.required' => 'Debe ingresar Nombre Proveedor',
                'nom_contratista.required' => 'Debe ingresar Nombre Contratista',

            ]);
        }

        $request->validate($rules, $messages);

        // GENERECIÓN DE CÓDIGO
        $cod_area = Soporte::getCodAreaByIdArea($get_id->id_area); // Obtiene el área
        $request->validate($rules, $messages);
        $idsoporte_tipo = $request->nombre_tipo;
        if ($get_id->activo_tipo == 1) {
            $area_code = $cod_area ? $cod_area['cod_area'] : 'TI';
            $prefijo = $idsoporte_tipo == 1 ? 'RQ-' . $area_code . '-' : 'INC-' . $area_code . '-';
            $contador = Soporte::where('tipo_otros', $idsoporte_tipo)->count();
            $nuevo_numero = $contador + 1;
            $numero_formateado = str_pad($nuevo_numero, 3, '0', STR_PAD_LEFT);
            $codigo_generado = $prefijo . $numero_formateado;
        } else {
            $codigo_generado = $get_id->codigo;
        }
        // Campos comunes
        $updateData = [
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
            'tipo_otros' => $tipo_otros,
            'codigo' => $codigo_generado
        ];

        if ($cantAreasEjecut < 4) {
            // Si $id_subgerencia es 9, actualiza 'fec_cierre' y 'estado_registro' EN MÓDULO TI
            $updateData['id_responsable'] = $request->id_responsablee;
            $updateData['fec_cierre'] = $request->fec_cierree;
            $updateData['estado_registro'] = $request->estado_registroe;

            // Si no, actualiza 'fec_cierre_sr' y 'estado_registro_sr' EN MÓDULO INFRAESTRUCTURA
            if ($id_subgerencia != 9) {
                $updateData['fec_cierre_sr'] = $request->fec_cierree;
                $updateData['estado_registro_sr'] = $request->estado_registroe;
            }
        } else {
            // Si $id_subgerencia es 9, actualiza para el responsable principal MÓDULO INFRAESTRUCTURA
            if ($id_subgerencia == 9) {
                $updateData['id_responsable'] = $request->id_responsablee_0;
                $updateData['fec_cierre'] = $request->fec_cierree_0;
                $updateData['estado_registro'] = $request->estado_registroe_0;
            } else {
                // Si $id_subgerencia NO es 9, actualiza para el segundo responsable MÓDULO TI
                $updateData['id_segundo_responsable'] = $request->id_responsablee_1;
                $updateData['fec_cierre_sr'] = $request->fec_cierree_1;
                $updateData['estado_registro_sr'] = $request->estado_registroe_1;
            }
        }

        // Realiza la actualización
        Soporte::findOrFail($id)->update($updateData);


        $soporteComentarios = SoporteComentarios::where('idsoporte_solucion', $get_id->idsoporte_solucion)->get();

        // Verifica si hay comentarios existentes
        if ($soporteComentarios->isEmpty()) {
            // No hay comentarios, puedes manejar esto como desees, por ejemplo, crear uno nuevo
            $data = [
                'idsoporte_solucion' => $get_id->idsoporte_solucion,
                'comentario' => $request->descripcione_solucion,
                'id_responsable' => session('usuario')->id_usuario,
                'fec_comentario' => now(),
                'estado' => 1,
                'user_act' => session('usuario')->id_usuario,
                'fec_act' => now(),
            ];

            SoporteComentarios::create($data);
        } else {
            // Hay comentarios existentes
            $comentarioExistente = $soporteComentarios->first();
            // Verifica si id_responsable es null
            if ($comentarioExistente->id_responsable === null) {
                // Reemplaza el comentario existente
                $comentarioExistente->update([
                    'comentario' => $request->descripcione_solucion,
                    'id_responsable' => session('usuario')->id_usuario,
                    'fec_comentario' => now(),
                    'user_act' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                ]);
            } else {
                // Si id_responsable no es null, agrega un nuevo comentario
                $data = [
                    'idsoporte_solucion' => $get_id->idsoporte_solucion,
                    'comentario' => $request->descripcione_solucion,
                    'id_responsable' => session('usuario')->id_usuario,
                    'fec_comentario' => now(),
                    'estado' => 1,
                    'user_act' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                ];

                // Primero, verifica si descripcione_solucion no es null ni vacío
                if (!is_null($request->descripcione_solucion) && $request->descripcione_solucion !== '') {
                    // Si no es null ni vacío, entonces ejecuta la creación de los datos
                    SoporteComentarios::create($data);
                } else {
                    // Si es null o vacío, puedes realizar alguna acción o devolver una respuesta de error, si es necesario
                }
            }
        }

        $soporteEjecutor = SoporteEjecutor::findOrFail($get_id->idsoporte_ejecutor);

        if ($request->ejecutor_responsable == "0") {
            // Concatenar los valores de idejecutor_responsable como una cadena
            $idejecutor_responsable = "3,4";
            // Crear o actualizar el registro con idejecutor_responsable concatenado
            $soporteEjecutor->update([
                'idejecutor_responsable' => $idejecutor_responsable,
                'fec_inicio_proyecto' => $request->fec_ini_proyecto,
                'nombre_proyecto' => $request->nom_proyecto,
                'proveedor' => $request->proveedor,
                'nombre_contratista' => $request->nom_contratista,
                'dni_prestador_servicio' => $request->dni_prestador,
                'ruc' => $request->ruc,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        } else {
            // Actualizar el registro existente con el valor real de ejecutor_responsable
            $soporteEjecutor->update([
                'idejecutor_responsable' => $request->ejecutor_responsable,
                'fec_inicio_proyecto' => $request->fec_ini_proyecto,
                'nombre_proyecto' => $request->nom_proyecto,
                'proveedor' => $request->proveedor,
                'nombre_contratista' => $request->nom_contratista,
                'dni_prestador_servicio' => $request->dni_prestador,
                'ruc' => $request->ruc,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }

        // Almacenar Imagenes
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        if ($con_id && $lr) {
            // Decodificar las URLs de las imágenes desde el request
            $imagenes = json_decode($request->input('imagenes'), true);
            $resultados = [];
            // Validar que haya entre 3 y 5 imágenes
            if ($imagenes && is_array($imagenes)) {
                $resultados = $this->uploadImages($imagenes, $con_id);
                if (!$resultados) {
                    return response()->json(['error' => 'No se pudo subir alguna imagen'], 500);
                }
                // Eliminación de archivos temporales en SOPORTE/TEMPORAL
                $this->deleteTempFiles($con_id, "SOPORTE/TEMPORAL/");
                // Obtener los campos de imagen
                $archivo1 = isset($resultados[0]) ? $resultados[0]['url_ftp'] : '';
                $archivo2 = isset($resultados[1]) ? $resultados[1]['url_ftp'] : '';
                $archivo3 = isset($resultados[2]) ? $resultados[2]['url_ftp'] : '';
                $archivo4 = isset($resultados[3]) ? $resultados[3]['url_ftp'] : '';
                $archivo5 = isset($resultados[4]) ? $resultados[4]['url_ftp'] : '';
            }
            // Subida de imágenes

            $data = [
                'estado_solucion' => 1,
                'archivo_solucion' => 1,
                'estado' => 1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ];

            // CARGAR DOCUMENTOS
            if (!empty($_FILES["documentoa1"]["name"][0])) {
                $uploaded_files = [];
                $documentosCargados = [
                    'documento1' => $get_id->documento1,
                    'documento2' => $get_id->documento2,
                    'documento3' => $get_id->documento3,
                ];

                // Recorremos los archivos seleccionados
                for ($count = 0; $count < count($_FILES["documentoa1"]["name"]); $count++) {
                    $path = $_FILES["documentoa1"]["name"][$count];

                    if (empty($path)) {
                        continue; // Salta si no hay archivo
                    }

                    $nameDoc = $_FILES["documentoa1"]["name"][$count]; // Accede al nombre del archivo individual
                    $fecha = date('Y-m-d');
                    $ext = pathinfo($nameDoc, PATHINFO_EXTENSION); // Obtiene la extensión correctamente

                    // Eliminar la extensión original del nombre del archivo
                    $nombre_soli = pathinfo($nameDoc, PATHINFO_FILENAME);

                    // Crear el nombre con el formato deseado
                    $nombre = $nombre_soli . "_" . $fecha . "_" . rand(10, 999) . "." . $ext;

                    // Asignar propiedades para subir
                    $_FILES["file"]["name"] = $nombre;
                    $_FILES["file"]["type"] = $_FILES["documentoa1"]["type"][$count];
                    $source_file = $_FILES["documentoa1"]["tmp_name"][$count];
                    $_FILES["file"]["error"] = $_FILES["documentoa1"]["error"][$count];
                    $_FILES["file"]["size"] = $_FILES["documentoa1"]["size"][$count];

                    if ($_FILES["file"]["error"] == 0 && is_uploaded_file($source_file)) {
                        ftp_pasv($con_id, true);
                        $subio = ftp_put($con_id, "SOPORTE/" . $nombre, $source_file, FTP_BINARY);

                        if ($subio) {
                            $uploaded_files[] = $nombre;
                        } else {
                            echo "Archivo no subido correctamente: " . $nombre;
                        }
                    } else {
                        echo "Error al cargar el archivo: " . $nombre;
                    }

                    if (count($uploaded_files) == 3) {
                        break; // Detener después de subir 3 archivos
                    }
                }

                // Verifica si se subieron archivos correctamente
                if (!empty($uploaded_files)) {
                    $columns = ['documento1', 'documento2', 'documento3'];

                    foreach ($uploaded_files as $file) {
                        foreach ($columns as $column) {
                            if (empty($documentosCargados[$column])) {
                                $data[$column] = $file; // Asignar al primer espacio vacío
                                $documentosCargados[$column] = $file; // Marcar como ocupado
                                break; // Salir del bucle una vez asignado
                            }
                        }
                    }

                    echo "Archivos subidos correctamente: " . implode(", ", $uploaded_files);
                } else {
                    echo "No se subieron archivos correctamente.";
                }
            } else {
                echo "No se seleccionaron archivos.";
            }

            if (!empty($resultados)) {
                $data['archivo1'] = $archivo1;
                $data['archivo2'] = $archivo2;
                $data['archivo3'] = $archivo3;
                $data['archivo4'] = $archivo4;
                $data['archivo5'] = $archivo5;
            }
            // Actualizar la base de datos
            SoporteSolucion::findOrFail($get_id->idsoporte_solucion)->update($data);
            // Eliminar archivos temporales en SOPORTE/TEMPORAL si se subieron imágenes
            if (!empty($resultados)) {
                $this->deleteTempFiles($con_id, "SOPORTE/TEMPORAL/");
            }
            // Cerrar conexión FTP
            ftp_close($con_id);
        } else {
            return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
        }
    }




    public function destroy_documentos($id, $documento)
    {
        // Buscar el soporte en la tabla soporte_solucion por su ID
        $soporte = SoporteSolucion::find($id);

        if (!$soporte) {
            return response()->json(['success' => false, 'message' => 'Soporte no encontrado']);
        }

        // Crear el nombre de la columna basado en el valor de $documento
        $documentoColumna = 'documento' . $documento;

        // Verificar si la columna existe en el modelo SoporteSolucion
        if (in_array($documentoColumna, ['documento1', 'documento2', 'documento3'])) {
            // Limpiar la columna correspondiente
            $soporte->$documentoColumna = null;

            // Guardar los cambios
            if ($soporte->save()) {
                return response()->json(['success' => true, 'message' => 'Documento eliminado correctamente']);
            } else {
                return response()->json(['success' => false, 'message' => 'Error al eliminar el documento']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Documento no válido']);
        }
    }

    public function cancelar_tick_master(Request $request, $id)
    {
        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')
            ->get();

        $list_motivos_cancelacion = SoporteMotivoCancelacion::select('idsoporte_motivo_cancelacion', 'motivo')
            ->orderBy('motivo', 'ASC')
            ->distinct('motivo')
            ->get();


        $get_id = Soporte::getTicketById($id);

        return view('soporte.soporte_master.modal_cancelar', compact('get_id', 'list_area', 'list_motivos_cancelacion'));
    }


    public function cancel_update_tick_master(Request $request, $id)
    {
        $get_id = Soporte::getTicketById($id);

        // MOTIVO : NO CORRESPONDE AL ÁREA CORRESPONDIENTE
        if ($request->motivo == 1) {
            $nom_area = Area::obtenerNombreArea($request->id_areac);
            $soporteActualizado  = Soporte::findOrFail($id)->update([
                'idsoporte_motivo_cancelacion' => $request->motivo,
                'area_cancelacion' => $request->id_areac,
                'estado_registro' => 6,
                'estado_registro_sr' => 6,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            if ($soporteActualizado) {
                // LÓGICA DE ANTIGUO INTRANET PARA CREAR CÓDIGO_PENDIENTE EN TAREAS
                if ($get_id->idsoporte_tipo == 1) {
                    $requerimiento = "REQ";
                } elseif ($get_id->idsoporte_tipo == 2) {
                    $requerimiento = "INC";
                }
                $dato['id_tipo'] = $get_id->idsoporte_tipo;
                $dato['id_area'] = $request->id_areac;
                $cod_area = $get_id->cod_area;
                $query_id = Pendiente::ultimoAnioCodPendiente($dato);
                $totalRows_t = count($query_id);

                if ($totalRows_t < 9) {
                    $codigofinal = $requerimiento . "-" . $cod_area . "-00000" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 8 && $totalRows_t < 99) {
                    $codigofinal = $requerimiento . "-" . $cod_area . "-0000" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 98 && $totalRows_t < 999) {
                    $codigofinal = $requerimiento . "-" . $cod_area . "-000" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 998 && $totalRows_t < 9999) {
                    $codigofinal = $requerimiento . "-" . $cod_area . "-00" . ($totalRows_t + 1);
                }
                if ($totalRows_t > 9998) {
                    $codigofinal = $requerimiento . "-" . $cod_area . "-0" . ($totalRows_t + 1);
                }
                $dato['cod_pendiente'] = $codigofinal;

                // Validar si ya existe un registro con los mismos campos
                $existePendiente = Pendiente::where('id_usuario', $get_id->user_reg)
                    ->where('cod_base', $get_id->base)
                    ->where('cod_pendiente', $codigofinal)
                    ->where('titulo', $get_id->nombre_especialidad . '-' . $get_id->nombre_elemento)
                    ->where('id_tipo', $get_id->idsoporte_tipo)
                    ->where('id_area', $request->id_areac)
                    ->where('id_responsable', $request->id_responsable)
                    ->exists();
                if (!$existePendiente) {
                    // Si no existe, se crea el registro
                    Pendiente::create([
                        'id_usuario' => $get_id->user_reg,
                        'cod_base' => $get_id->base,
                        'cod_pendiente' => $codigofinal,
                        'titulo' => $get_id->nombre_especialidad . '-' . $get_id->nombre_elemento,
                        'id_tipo' => $get_id->idsoporte_tipo,
                        'id_area' => $request->id_areac,
                        'id_item' => 0,
                        'id_subitem' => 0,
                        'id_subsubitem' => 0,
                        'id_responsable' => $request->id_responsable,
                        'id_prioridad' => 0,
                        'descripcion' => $get_id->nombre_asunto . '-' . $get_id->descripcion,
                        'envio_mail' => 0,
                        'conforme' => 0,
                        'calificacion' => 0,
                        'flag_programado' => 0,
                        'id_programacion' => 0,
                        'equipo_i' => '',
                        'estado' => 1,
                        'fec_reg' => now(),
                        'user_reg' => session('usuario')->id_usuario,
                        'fec_act' => now(),
                        'user_act' => session('usuario')->id_usuario
                    ]);
                } else {
                    return response()->json(['message' => 'El registro ya existe.'], 400);
                }


                $subject = "Derivación de Solicitud de Soporte";
                $nombre_completo = $get_id->usuario_nombre . ' ' . $get_id->usuario_apater;
                $body = "<h1> Hola, " . $nombre_completo . "</h1>
                                <p>Le informamos que su solicitud de soporte ha sido derivada al área correspondiente:. $nom_area .</p>
                                <p>Podrá dar seguimiento a su solicitud haciendo clic en el siguiente enlace:</p>
                                <a href='https://demo.grupolanumero1.com.pe/Tareas/index' style='text-decoration: none; color: blue; font-weight: bold;'>Ver el estado de mi solicitud</a>
                                <p>Atentamente.<br>Grupo La Número 1</p>";
                $this->enviarCorreoSoporte($subject, $get_id->emailp, $body);
            }
        }
        // MOTIVO : INFORMACIÓN INSUFICIENTE O FALTA DE DETALLES
        else {
            $soporteActualizado  = Soporte::findOrFail($id)->update([
                'idsoporte_motivo_cancelacion' => $request->motivo,
                'estado_registro' => 5,
                'estado_registro_sr' => 5,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
            if ($soporteActualizado) {
                $subject = "Cancelación de Solicitud de Soporte";
                $nombre_completo = $get_id->usuario_nombre . ' ' . $get_id->usuario_apater;
                $body = "<h1> Hola, " . $nombre_completo . "</h1>
                                     <p>Lamentamos informarle que no podemos procesar su solicitud de soporte en este momento por la siguiente razón:</p>
                                     <ul><li>Información insuficiente o falta de detalles necesarios.
                                     </li></ul>
                                    <p>Le pedimos que revise y complete la información requerida o proporcione una justificación más clara. Esto nos permitirá atender su solicitud de manera adecuada.</p>
                                    <p>Puede actualizar su solicitud haciendo clic en el siguiente enlace:</p>
                                    <a href='https://demo.grupolanumero1.com.pe/soporte' style='text-decoration: none; color: blue; font-weight: bold;'>Actualizar mi solicitud</a>
                                    <p>Gracias.<br>Atte. Grupo La Número 1</p>";
                $this->enviarCorreoSoporte($subject, $get_id->emailp, $body);
            }
        }
    }

    function enviarCorreoSoporte($subject, $emailp, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->SMTPDebug = 0; // Cambia a 2 para habilitar detalles de depuración
            $mail->isSMTP();
            $mail->Host = 'mail.lanumero1.com.pe';
            $mail->SMTPAuth = true;
            $mail->Username = 'intranet@lanumero1.com.pe';
            $mail->Password = 'lanumero1$1';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');
            $mail->addAddress($emailp); // Correo del destinatario
            $mail->isHTML(true);
            $mail->Subject = $subject;

            // Cuerpo del correo
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';
            // Enviar el correo
            $mail->send();

            // Retornar mensaje de éxito
            return "Correo enviado correctamente a $emailp.";
        } catch (Exception $e) {
            // Manejar errores al enviar el correo
            return "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
        }
    }


    public function getResponsableByArea(Request $request)
    {
        $areaId = $request->input('area');
        $responsables = Usuario::get_list_responsable_area($areaId);
        return response()->json($responsables);
    }


    // Activación Cámara
    public function previsualizacionCaptura(Request $request)
    {
        if (!$request->hasFile('photo')) {
            return response()->json(['error' => 'No se envió ninguna imagen'], 400);
        }

        // Generar un identificador único para el archivo
        $nombre_soli = "temporal_" . session('usuario')->id_usuario . "_" . date('YmdHis');
        $extension = $request->file('photo')->getClientOriginalExtension();
        $nombre = $nombre_soli . '.' . strtolower($extension);
        // Guardar temporalmente en el almacenamiento local
        $path = $request->file('photo')->storeAs('soporte_temporal', $nombre);
        // Subir el archivo al servidor FTP
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

        if ($con_id && $lr) {
            ftp_pasv($con_id, true);
            $source_file = Storage::path($path);
            $ftp_upload_path = "SOPORTE/TEMPORAL/" . $nombre;
            // Subir el archivo al FTP
            $subio = ftp_put($con_id, $ftp_upload_path, $source_file, FTP_BINARY);
            // Cerrar conexión FTP
            ftp_close($con_id);
            if ($subio) {
                // Obtener URL del archivo en almacenamiento local para referencia
                $archivo_local = Storage::url($path);
                $archivo_ftp = "https://lanumerounocloud.com/intranet/SOPORTE/TEMPORAL/" . $nombre;

                return response()->json([
                    'success' => 'Archivo subido correctamente a local y FTP',
                    'url_local' => $archivo_local,
                    'url_ftp' => $archivo_ftp,
                    'identificador' => $nombre_soli
                ]);
            } else {
                return response()->json(['error' => 'No se pudo subir el archivo al servidor FTP'], 500);
            }
        } else {
            return response()->json(['error' => 'No se pudo conectar al servidor FTP'], 500);
        }
    }


    public function edit_comentarios_master(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'comentario' => 'required|string|max:250',
        ]);
        $comentario = SoporteComentarios::find($id);
        if (!$comentario) {
            return response()->json(['success' => false, 'message' => 'Comentario no encontrado']);
        }
        $comentario->comentario = $request->comentario;

        if ($comentario->save()) {
            return response()->json(['success' => true, 'message' => 'Comentario actualizado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el comentario']);
        }
    }


    public function destroy_comentarios($id)
    {
        // Buscar el comentario por su ID
        $comentario = SoporteComentarios::find($id);
        if (!$comentario) {
            return response()->json(['success' => false, 'message' => 'Comentario no encontrado']);
        }
        if ($comentario->delete()) {
            return response()->json(['success' => true, 'message' => 'Comentario eliminado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el comentario']);
        }
    }



    // TABLAS GENERALES
    public function index_tg()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();

        return view('soporte.tabla_general.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function adicionarParametro($list_tablageneral_soporte)
    {
        $list_tablageneral_soporte = $list_tablageneral_soporte->map(function ($ticket) {;
            $multirepsonsable = Soporte::getResponsableMultipleByAsunto($ticket->id_asunto);
            if (($ticket->estado_registro_sr == 3 && $ticket->estado_registro == 3) || ($ticket->estado_registro == 3 && $multirepsonsable == 0)) {
                $ticket->fecha_completado = (strtotime($ticket->fec_cierre) > strtotime($ticket->fec_cierre_sr))
                    ? $ticket->fec_cierre
                    : $ticket->fec_cierre_sr;
                $ticket->status_ticket = "Completado";
            } elseif ($ticket->estado_registro_sr == 5 || $ticket->estado_registro == 5) {
                $ticket->fecha_completado = now();
                $ticket->status_ticket = "Cancelado";
            } elseif ($ticket->estado_registro_sr == 6 || $ticket->estado_registro == 6) {
                $ticket->status_ticket = "Derivado";
            } elseif ($ticket->estado_registro_sr == 1 || $ticket->estado_registro == 1) {
                $ticket->fecha_completado = now();
                $ticket->status_ticket = "Por Iniciar";
            } elseif ($ticket->estado_registro_sr == 4 || $ticket->estado_registro == 4) {
                $ticket->fecha_completado = now();
                $ticket->status_ticket = "Stand By";
            } elseif ($ticket->estado_registro_sr == 2 || $ticket->estado_registro == 2) {
                $ticket->fecha_completado = (strtotime($ticket->fec_cierre) > strtotime($ticket->fec_cierre_sr))
                    ? $ticket->fec_cierre
                    : $ticket->fec_cierre_sr;
                $ticket->status_ticket = "En Proceso";
            } else {
                $ticket->status_ticket = "En Proceso";
            }

            return $ticket;
        });
        return $list_tablageneral_soporte;
    }

    public function list_soporte_tablagenerales_filtro(Request $request)
    {
        $dato['fecha_iniciob'] = $request->input("fecha_iniciob");
        $dato['fecha_finb'] =  $request->input("fecha_finb");
        $dato['cpiniciar'] =  $request->input("cpiniciar");
        $dato['cproceso'] =  $request->input("cproceso");
        $dato['ccompletado'] =  $request->input("ccompletado");
        $dato['cstandby'] =  $request->input("cstandby");
        $dato['ccancelado'] =  $request->input("ccancelado");
        $dato['cderivado'] =  $request->input("cderivado");

        $list_tablageneral_soporte = Soporte::listTablaGeneralSoporteFiltro($dato);
        $list_tablageneral_soporte = $this->adicionarParametro($list_tablageneral_soporte);
        return view('soporte.tabla_general.lista', compact('list_tablageneral_soporte'));
    }


    public function excel_tg($fecha_inicio, $fecha_fin, $cpiniciar, $cproceso,  $cstandby, $ccompletado, $ccancelado)
    {
        $dato['fecha_iniciob'] = $fecha_inicio;
        $dato['fecha_finb'] =  $fecha_fin;
        $dato['cpiniciar'] =  $cpiniciar;
        $dato['cproceso'] =  $cproceso;
        $dato['ccompletado'] =  $ccompletado;
        $dato['cstandby'] =  $cstandby;
        $dato['ccancelado'] =  $ccancelado;
        $dato['cderivado'] =  $ccancelado;

        $list_tablageneral_soporte = Soporte::listTablaGeneralSoporteFiltro($dato);
        $list_tablageneral_soporte = $this->adicionarParametro($list_tablageneral_soporte);
        // Creación del archivo Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:G1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A1:G1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Tabla General Soporte');

        $sheet->setAutoFilter('A1:G1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
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
        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);
        // Encabezados de columnas
        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Sede Laboral');
        $sheet->setCellValue('C1', 'Fecha Registro');
        $sheet->setCellValue('D1', 'Usuario');
        $sheet->setCellValue('E1', 'Área');
        $sheet->setCellValue('F1', 'Responsable');
        $sheet->setCellValue('G1', 'Tipo');
        $sheet->setCellValue('H1', 'Especialidad');
        $sheet->setCellValue('I1', 'Elemento');
        $sheet->setCellValue('J1', 'Asunto');
        $sheet->setCellValue('K1', 'F.Vencimiento');
        $sheet->setCellValue('L1', 'F.Completado');
        $sheet->setCellValue('M1', 'F.R.U');
        $sheet->setCellValue('N1', 'Estado');

        $contador = 1;
        foreach ($list_tablageneral_soporte as $soporte) {
            $contador = 1;
            foreach ($list_tablageneral_soporte as $soporte) {
                $contador++;

                $sheet->setCellValue("A{$contador}", $soporte->codigo);
                $sheet->setCellValue("B{$contador}", $soporte->base);

                // Fecha Registro
                if ($soporte->fec_reg) {
                    $sheet->setCellValue("C{$contador}", Date::PHPToExcel($soporte->fec_reg));
                    $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("C{$contador}", '-'); // Valor por defecto si es nulo
                }

                $sheet->setCellValue("D{$contador}", $soporte->usuario_nombre);
                $sheet->setCellValue("E{$contador}", $soporte->nombre_area);
                $sheet->setCellValue("F{$contador}", $soporte->nombres_responsables);
                $sheet->setCellValue("G{$contador}", $soporte->tipo_soporte);
                $sheet->setCellValue("H{$contador}", $soporte->nombre_especialidad);
                $sheet->setCellValue("I{$contador}", $soporte->nombre_elemento);
                $sheet->setCellValue("J{$contador}", $soporte->nombre_asunto);
                if ($soporte->fec_vencimiento) {
                    $sheet->setCellValue("K{$contador}", Date::PHPToExcel($soporte->fec_vencimiento));
                    $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("K{$contador}", '-');
                }
                if ($soporte->fecha_completado) {
                    $sheet->setCellValue("L{$contador}", Date::PHPToExcel($soporte->fecha_completado));
                    $sheet->getStyle("L{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("L{$contador}", '-');
                }
                if ($soporte->fec_reg) {
                    $sheet->setCellValue("M{$contador}", Date::PHPToExcel($soporte->fec_reg));
                    $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                } else {
                    $sheet->setCellValue("M{$contador}", '-');
                }
                $sheet->setCellValue("N{$contador}", $soporte->status_ticket);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Lista Soporte ' . date('d-m-Y');

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
