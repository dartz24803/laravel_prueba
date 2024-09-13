<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\BiPuestoAcceso;
use App\Models\BiReporte;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\Gerencia;
use App\Models\IndicadorReporteBi;
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
use App\Models\TipoIndicador;
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
        return view('interna.procesos.administracion.portalprocesos.index');
    }

    public function list_ra()
    {
        // Obtener la lista de reportes con los campos requeridos
        $list_bi_reporte = BiReporte::select(
            'acceso_bi_reporte.id_acceso_bi_reporte',
            'acceso_bi_reporte.estado_act',
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
            if ($reporte->fec_valid) {
                $fec_reg = new \DateTime($reporte->fec_reg);
                $fec_valid = new \DateTime($reporte->fec_valid);
                $interval = $fec_valid->diff($fec_reg);
                $reporte->dias_sin_atencion = $interval->days;
            } else {
                $reporte->dias_sin_atencion = 'N/A'; // O cualquier otro valor que indique que no se puede calcular
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

        $list_area = Area::select('id_area', 'nom_area')
            ->where('estado', 1)
            ->orderBy('nom_area', 'ASC')
            ->distinct('nom_area')->get();

        $list_tipo_indicador = TipoIndicador::select('idtipo_indicador', 'nom_indicador')
            ->where('estado', 1)
            ->orderBy('nom_indicador', 'ASC')
            ->distinct('nom_indicador')->get();

        $list_colaborador = Usuario::select('id_usuario', 'usuario_apater', 'usuario_amater', 'usuario_nombres')
            ->where('estado', 1)
            ->get();  // Añadir el método get() para obtener los resultados


        // $list_colaborador = Organigrama::get_list_colaborador(['id_gerencia' => 0]);
        // dd($list_colaborador);

        return view('interna.bi.reportes.registroacceso_reportes.modal_registrar', compact(
            'list_responsable',
            'list_area',
            'list_base',
            'list_tipo_indicador',
            'list_colaborador'
        ));
    }

    public function getAreasPorBase(Request $request)
    {
        $idsBases = $request->input('bases');
        // Verifica si $idsAreas es vacío o null
        if (empty($idsBases)) {
            // Si es vacío o null, obten todos los id_area de la tabla Area
            $bases = Base::select('id_base')
                ->where('estado', 1)
                ->orderBy('cod_base', 'ASC')
                ->distinct('cod_base')
                ->get()
                ->pluck('id_base'); // Obtener solo los valores de id_area como un array

            $idsBases = $bases->toArray(); // Convertir a un array para usar en la consulta
        }

        // Filtra las áreas basadas en los idsBases seleccionados
        $areas = Area::where(function ($query) use ($idsBases) {
            foreach ($idsBases as $idBase) {
                $query->orWhereRaw("FIND_IN_SET(?, id_base)", [$idBase]);
            }
        })
            ->where('estado', 1)
            ->get();
        // $areas = Area::whereIn('id_base', $idsBases)
        //     ->where('estado', 1)
        //     ->get();

        // Filtra los puestos basados en las áreas seleccionadas
        return response()->json($areas);
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



    public function store_ra(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombi' => 'required',
            'iframe' => 'required',
            'tipo_acceso_t' => 'required',
            // 'id_area_acceso_t' => 'required',
            'indicador.*' => 'required',
            'descripcion.*' => 'required',
            'tipo.*' => 'required',
            'presentacion.*' => 'required',
        ], [
            'nombi.required' => 'Debe ingresar nombre bi.',
            'iframe.required' => 'Debe ingresar Iframe.',
            'tipo_acceso_t.required' => 'Debe seleccionar los Accesos por Puesto',
            // 'id_area_acceso_t.required' => 'Debe seleccionar área.',
            'indicador.*.required' => 'Debe ingresar un indicador.',
            'descripcion.*.required' => 'Debe ingresar una descripción.',
            'tipo.*.required' => 'Debe seleccionar un tipo.',
            'presentacion.*.required' => 'Debe seleccionar una presentación.',
        ]);

        // Guardar los datos en la tabla portal_procesos_historial
        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;
        $biReporte = BiReporte::create([
            'estado_act' => 'Actualizado',
            'nom_bi' => $request->nombi ?? '',
            'nom_intranet' => $request->nomintranet ?? '',
            'actividad' => $request->actividad_bi ?? '',
            'acceso_todo' => $accesoTodo,
            'id_area' => $request->areass ?? 0,
            'id_usuario' => $request->solicitante ?? 0,
            'frecuencia_act' => $request->frec_actualizacion ?? 1,
            'objetivo' => $request->objetivo ?? '',
            'tablas' => $request->tablas ?? '',
            'iframe' => $request->iframe ?? '',
            'estado' => 1,
            'estado_valid' => 0,
            'fec_reg' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
            'user_act' => session('usuario')->id_usuario,
        ]);
        // Obtener el ID del nuevo registro en bi_reportes
        $biReporteId = $biReporte->id_acceso_bi_reporte;
        // dd($biReporteId);
        // Guardar los datos en la tabla indicadores_bi
        $indicadores = $request->input('indicador', []);
        $descripciones = $request->input('descripcion', []);
        $tipos = $request->input('tipo', []);
        $presentaciones = $request->input('presentacion', []);

        foreach ($indicadores as $index => $indicador) {
            IndicadorReporteBi::create([
                'id_acceso_bi_reporte' => $biReporteId,
                'nom_indicador' => $indicador,
                'estado' => 1,
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
        $request->validate([
            'nombrea' =>  'required',
            'iframea' => 'required',
        ], [
            'nombrea.required' => 'Debe ingresar nombre.',
            'iframea.required' => 'Debe ingresar Iframe.',

        ]);
        BiReporte::where('id_acceso_bi_reporte', $id)->update([
            'nom_reporte' => $request->nombrea,
            'iframe' => $request->iframea,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,

        ]);
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
        $id_usuario = $get_id->id_usuario; // Asignamos el valor de id_usuario desde $get_id

        // Obtener el valor del campo `id_area` y convertirlo en un array
        // $selected_puesto_ids = explode(',', $get_id->acceso);
        // Obtener los IDs de los puestos asociados al reporte
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

        $list_indicadores = IndicadorReporteBi::with('tipoIndicador')
            ->select(
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

        // dd($id_usuario);

        $list_colaborador = Usuario::get_list_colaborador_usuario([
            'id_usuario' => $id_usuario // Filtro por id_usuario
        ]);

        return view('interna.bi.reportes.registroacceso_reportes.modal_editar', compact(
            'get_id',
            'list_responsable',
            'list_area',
            'selected_puesto_ids',
            'list_colaborador',
            'selected_puesto_ids', // IDs de los puestos seleccionados
            'list_tipo_indicador',
            'list_base',
            'list_indicadores'
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
}
