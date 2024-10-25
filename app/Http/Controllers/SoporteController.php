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
use App\Models\SubGerencia;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Usuario;
use Carbon\Carbon;
use Exception;
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
        // Obtener la lista de procesos con los campos requeridos
        $list_tickets_soporte = Soporte::listTicketsSoporte();

        // dd($list_tickets_soporte);
        return view('soporte.soporte.lista', compact('list_tickets_soporte'));
    }


    public function create_tick(Request $request)
    {
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

    public function getSoporteNivelPorSede(Request $request)
    {
        $idSede = $request->input('sedes');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
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
        // dd($ubicacion);
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
        // dd($ubicaciones);
        return response()->json($ubicaciones);
    }


    public function getElementoPorEspecialidad(Request $request)
    {
        $idEspecialidad = $request->input('especialidad');
        // Si no se selecciona ninguna sede, devolver un arreglo vacío
        if (empty($idEspecialidad)) {
            return response()->json([]);
        }
        // dd($idEspecialidad);
        // Buscar ubicaciones asociadas a la sede seleccionada
        $elementos = ElementoSoporte::where(function ($query) use ($idEspecialidad) {
            $query->whereRaw("FIND_IN_SET(?, id_especialidad)", [$idEspecialidad]);
        })
            ->where('estado', 1)
            ->get();
        // dd($elementos);
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
        $rules = [
            'especialidad' => 'gt:0',
            'elemento' => 'gt:0',
            'asunto' => 'gt:0',
            'sede' => 'gt:0',
            'idsoporte_nivel' => 'gt:0',
            'vencimiento' => 'required',
            'descripcion' => 'required',
        ];
        $messages = [
            'especialidad.gt' => 'Debe seleccionar especialidad.',
            'elemento.gt' => 'Debe seleccionar elemento.',
            'asunto.gt' => 'Debe seleccionar asunto.',
            'sede.gt' => 'Debe seleccionar sede.',
            'idsoporte_nivel.gt' => 'Debe ingresar Ubicaciòn.',
            'vencimiento.required' => 'Debe ingresar vencimiento.',
            'descripcion.required' => 'Debe ingresar descripcion.',
        ];

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



        $request->validate($rules, $messages);

        $idsoporte_tipo = DB::table('soporte_asunto as sa')
            ->leftJoin('soporte_tipo as st', 'st.idsoporte_tipo', '=', 'sa.idsoporte_tipo')
            ->where('sa.idsoporte_asunto', $request->asunto)
            ->select('sa.idsoporte_tipo')
            ->first();

        if ($idsoporte_tipo) {
            $prefijo = $idsoporte_tipo->idsoporte_tipo == 1 ? 'RQ-TI-' : 'INC-TI-';
            $contador = Soporte::where('idsoporte_tipo', $idsoporte_tipo->idsoporte_tipo)->count();
            $nuevo_numero = $contador + 1;
            $numero_formateado = str_pad($nuevo_numero, 3, '0', STR_PAD_LEFT);
            $codigo_generado = $prefijo . $numero_formateado;
        } else {
            $codigo_generado = 'Código no disponible';
        }


        $soporte_solucion = SoporteSolucion::create([
            'id_responsable' => null,
            'comentario' => '',
            'fec_comentario' => null,
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
        // dd($request->idsoporte_area_especifica);
        Soporte::create([
            'codigo' => $codigo_generado,
            'id_especialidad' => $request->especialidad,
            'id_elemento' => $request->elemento,
            'id_asunto' => $request->asunto,
            'id_sede' => $request->sede,
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
            'idsoporte_tipo' => $idsoporte_tipo->idsoporte_tipo ?? 1,
            'estado' => 1,
            'estado_registro' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }

    public function ver_tick($id_soporte)
    {
        $get_id = Soporte::getTicketById($id_soporte);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        // dd($cantAreasEjecut);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);

        // dd($get_id->idejecutor_responsable);
        return view('soporte.soporte.modal_ver', compact('get_id', 'list_areas_involucradas', 'ejecutoresMultiples'));
    }

    public function update_tick(Request $request, $id)
    {

        Soporte::findOrFail($id)->update([
            'id_sede' =>  $request->sedee,
            'idsoporte_nivel' =>  $request->idsoporte_nivele,
            'idsoporte_area_especifica' => $request->idsoporte_area_especificae,
            'fec_vencimiento' =>  $request->fec_vencimiento,
            'id_especialidad' =>  $request->especialidade,
            'id_elemento' => $request->elementoe  ?? 6,
            'id_asunto' => $request->asuntoe ?? 9,
            'descripcion' => $request->descripcione,
            'id_area' => $request->areae,
            'estado_registro' => 1,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        // dd($get_id->idsoporte_solucion);

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
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('soporte.soporte_master.index', compact('list_notificacion', 'list_subgerencia', 'nominicio'));
    }

    public function list_tick_master()
    {
        // Obtener la lista de procesos con los campos requeridos
        $list_tickets_soporte = Soporte::listTicketsSoporteMaster();

        // dd($list_tickets_soporte);
        return view('soporte.soporte_master.lista', compact('list_tickets_soporte'));
    }


    public function ver_tick_master($id_soporte)
    {
        $get_id = Soporte::getTicketById($id_soporte);
        // dd($get_id->idejecutor_responsable);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        // dd($cantAreasEjecut);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);

        return view('soporte.soporte_master.modal_ver', compact('get_id', 'ejecutoresMultiples', 'list_areas_involucradas'));
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

        // dd($list_asunto);
        // dd($get_id->id_asunto);
        return view('soporte.soporte.modal_editar', compact('get_id', 'list_especialidad', 'list_area', 'list_sede', 'list_elementos', 'list_asunto'));
    }


    public function edit_tick_master($id_soporte)
    {
        $id_subgerencia = session('id_subgerenciam');

        $get_id = Soporte::getTicketById($id_soporte);
        $area = DB::table('soporte_asunto')
            ->leftJoin('area', 'soporte_asunto.id_area', '=', 'area.id_area')
            ->where('soporte_asunto.idsoporte_asunto', $get_id->id_asunto)
            ->select('soporte_asunto.*', 'area.nom_area') // Selecciona los campos que necesites
            ->first();
        if ($area->id_area == 0) {
            $areaResponsable = $get_id->id_area;
        } else {
            $areaResponsable = $area->id_area;
        }

        // Dividir el campo `id_area` en un array de IDs
        $areaIds = explode(',', $areaResponsable);
        // Crear listas basadas en los IDs obtenidos
        $list_primer_responsable = Usuario::get_list_colaborador_xarea_static(trim($areaIds[0]));
        $list_segundo_responsable = isset($areaIds[1]) ? Usuario::get_list_colaborador_xarea_static(trim($areaIds[1])) : [];
        // Verificar que las listas tengan al menos un elemento antes de acceder al campo `id_sub_gerencia`
        $primer_id_subgerencia = !empty($list_primer_responsable) ? $list_primer_responsable[0]->id_sub_gerencia : null;
        $segundo_id_subgerencia = !empty($list_segundo_responsable) ? $list_segundo_responsable[0]->id_sub_gerencia : null;
        // Condicional para seleccionar cuál lista asignar a `$list_responsable`
        if ($id_subgerencia == $primer_id_subgerencia) {
            $list_responsable = $list_primer_responsable;
        } else {
            $list_responsable = $list_segundo_responsable;
        }
        // dd($list_responsable);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);
        // dd($cantAreasEjecut);
        if ($cantAreasEjecut > 3) {
            $ejecutoresMultiples = true;
        } else {
            $ejecutoresMultiples = false;
        }
        $list_areas_involucradas = Soporte::obtenerListadoAreasInvolucradas($get_id->id_soporte);

        return view('soporte.soporte_master.modal_editar', compact('get_id', 'list_responsable', 'area', 'list_ejecutores_responsables', 'ejecutoresMultiples', 'list_areas_involucradas', 'id_subgerencia'));
    }

    public function update_tick_master(Request $request, $id)
    {
        $rules = [
            'ejecutor_responsable' => 'gt:0',
            'descripcione_solucion' => 'required|max:250',
        ];
        $messages = [
            'ejecutor_responsable.gt' => 'Debe seleccionar Ejecutor Responsable',
            'descripcione_solucion.max' => 'Comentario de Solución debe tener como máximo 250 caracteres.',
        ];
        $get_id = Soporte::getTicketById($id);

        // dd($request->id_responsablee_1);
        $list_ejecutores_responsables = EjecutorResponsable::obtenerListadoConEspecialidad($get_id->id_asunto);
        $cantAreasEjecut = count($list_ejecutores_responsables);


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
                'dni_prestador' => 'required|max:8',
                'ruc' => 'required|max:11'
            ]);

            $messages = array_merge($messages, [
                'nom_proyecto.required' => 'Debe ingresar Nombre del Proyecto',
                'proveedor.required' => 'Debe ingresar Nombre Proveedor',
                'nom_contratista.required' => 'Debe ingresar Nombre Contratista',
                'dni_prestador.required' => 'Debe ingresar DNI (Prestador).',
                'dni_prestador.max' => 'Nro. DNI (Prestador) debe tener como máximo 8 caracteres.',
                'ruc.required' => 'Debe ingresar Nro. RUC',
                'ruc.max' => 'Nro. RUC debe tener como máximo 11 caracteres.'
            ]);
        }

        $request->validate($rules, $messages);

        // dd($request->responsable_indice);
        if ($request->responsable_indice == "0") {
            // RESPONSABLE PRINCIPAL
            Soporte::findOrFail($id)->update([
                'id_responsable' => $request->id_responsablee_0,
                'fec_cierre' => $request->fec_cierree_0,
                'estado_registro' => $request->estado_registroe_0,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        } else {
            // SEGUNDO RESPONSABLE 
            Soporte::findOrFail($id)->update([
                'id_segundo_responsable' => $request->id_responsablee_1,
                'fec_cierre_sr' => $request->fec_cierree_1,
                'estado_registro_sr' => $request->estado_registroe_1,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        // dd($get_id->idsoporte_solucion);

        $soporteSolucion = SoporteSolucion::findOrFail($get_id->idsoporte_solucion);
        $soporteEjecutor = SoporteEjecutor::findOrFail($get_id->idsoporte_ejecutor);


        // Verifica si 'descripcione_solucion' ha cambiado
        $fec_comentario = $soporteSolucion->comentario !== $request->descripcione_solucion
            ? now()
            : $soporteSolucion->fec_comentario; // Mantiene la fecha actual si no ha cambiado

        $soporteSolucion->update([
            'id_responsable' => session('usuario')->id_usuario,
            'comentario' => $request->descripcione_solucion,
            'fec_comentario' => $fec_comentario,
            'tipo_soporte' => $request->tipo_soporte,
            'estado_solucion' => 0,
            'archivo_solucion' => 0,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
        // dd($request->fec_ini_proyecto);
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
        // dd($get_id->idejecutor_responsable);
        return view('soporte.soporte_master.modal_cancelar', compact('get_id', 'list_area', 'list_motivos_cancelacion'));
    }


    public function cancel_update_tick_master(Request $request, $id)
    {
        $get_id = Soporte::getTicketById($id);
        if ($request->motivo == 1) {
            // dd($request->id_areac);
            $soporteActualizado  = Soporte::findOrFail($id)->update([
                'idsoporte_motivo_cancelacion' => $request->motivo,
                'area_cancelacion' => $request->id_areac,
                'estado_registro' => 5,
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
                // dd($get_id);
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
                // LÓGICA DE ANTIGUO INTRANET PARA CREAR CÓDIGO_PENDIENTE EN TAREAS
                // dd($codigofinal);
                if (is_null($get_id->id_responsable)) {
                    return response()->json(['error' => 'No hay responsable asignado.'], 400);
                }

                Pendiente::create([
                    'id_usuario' => $get_id->user_reg,
                    'cod_base' => $get_id->base,
                    'cod_pendiente' =>  $codigofinal,
                    'titulo' => $get_id->nombre_especialidad . '-' . $get_id->nombre_elemento,
                    'id_tipo' => $get_id->idsoporte_tipo,
                    'id_area' => $request->id_areac,
                    'id_item' => 0,
                    'id_subitem' => 0,
                    'id_subsubitem' => 0,
                    'id_responsable' =>  $get_id->id_responsable,
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
            }
        } else {
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host       =  'mail.lanumero1.com.pe';
                $mail->SMTPAuth   =  true;
                $mail->Username   =  'intranet@lanumero1.com.pe';
                $mail->Password   =  'lanumero1$1';
                $mail->SMTPSecure =  'tls';
                $mail->Port     =  587;
                $mail->setFrom('intranet@lanumero1.com.pe', 'La Número 1');

                $mail->addAddress($get_id->usuario_email);

                $mail->isHTML(true);

                $mail->Subject = "Prueba de Soporte";

                $mail->Body =  "<h1> Hola, " . $get_id->usuario_nombre . "</h1>
                                <p>Su solicitud no puede proceder debido a la siguiente razón:</p>
                                <p>Necesitamos más detalle y/o brindenos una mejor sustentación, le invitamos a que lo corriga.
                                </p>
                                <p>Gracias.<br>Atte. Grupo La Número 1</p>";
                $mail->CharSet = 'UTF-8';
                $mail->send();


                echo 'Nombre y Apellidos ' . $get_id->usuario_nombres .
                    $get_id->usuario_amater . '<br>Correo: ' . $get_id->usuario_email;
            } catch (Exception $e) {
                echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
            }
            Soporte::findOrFail($id)->update([
                'idsoporte_motivo_cancelacion' => $request->motivo,
                'estado_registro' => 5,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }
}
