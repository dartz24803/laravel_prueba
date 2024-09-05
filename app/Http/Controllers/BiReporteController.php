<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\Base;
use App\Models\BiReporte;
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
        // Obtener la lista de procesos con los campos requeridos
        $list_bi_reporte = BiReporte::select(
            'acceso_bi_reporte.id_acceso_bi_reporte',
            'acceso_bi_reporte.nom_reporte',
            'acceso_bi_reporte.id_area',
            'acceso_bi_reporte.acceso',
        )
            ->where('acceso_bi_reporte.acceso', '!=', '')
            ->where('acceso_bi_reporte.estado', '=', 1)
            ->orderBy('acceso_bi_reporte.fec_reg', 'DESC') // Ordena por fec_reg en orden ascendente
            ->get();

        // Preparar un array para almacenar los nombres de las áreas y del responsable
        foreach ($list_bi_reporte as $reporte) {
            // Obtener nombres de las áreas
            $ids = explode(',', $reporte->id_area);
            $nombresAreas = DB::table('area')
                ->whereIn('id_area', $ids)
                ->pluck('nom_area');

            // Asignar nombres de las áreas al proceso
            $reporte->nombres_area = $nombresAreas->implode(', ');
            // Obtener nombres de las puestos
            $idsp = explode(',', $reporte->acceso);
            $nombresPuestos = DB::table('puesto')
                ->whereIn('id_puesto', $idsp)
                ->pluck('nom_puesto');

            // Asignar nombres de las áreas al proceso
            $reporte->nombres_puesto = $nombresPuestos->implode(', ');
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

        return view('interna.bi.reportes.registroacceso_reportes.modal_registrar', compact(
            'list_responsable',
            'list_area',
            'list_base'
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
        // $id = $request->input('id_acceso_bi_reporte');

        $accesoTodo = $request->has('acceso_todo') ? 1 : 0;

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
        // Convertir el array a una cadena separada por comas
        $list_responsable_string = implode(',', $list_responsable);
        $list_area_string = implode(',', $list_area);

        // Verificar si existe un código previo, si no, iniciar con 23AR00000
        $ultimoReporte = BiReporte::latest('id_acceso_bi_reporte')->first();
        if ($ultimoReporte) {
            // Extraer la parte numérica del código (ej: 00001)
            $ultimoCodigo = intval(substr($ultimoReporte->codigo, 4)); // Asumiendo que el prefijo es "23AR"
            $nuevoCodigo = $ultimoCodigo + 1; // Incrementar el número
        } else {
            // Si no hay reportes previos, iniciar en 23AR00000
            $nuevoCodigo = 1;
        }

        // Formatear el código con ceros a la izquierda
        $codigoFormateado = '23AR' . str_pad($nuevoCodigo, 5, '0', STR_PAD_LEFT);

        // Crear un nuevo registro en la tabla portal_procesos_historial
        BiReporte::create([
            'codigo' => $request->codigo ?? $codigoFormateado,
            'nom_reporte' => $request->nomreporte ?? '',
            'acceso_todo' => $accesoTodo,
            'id_area' => $accesoTodo
                ? $list_area_string
                : (is_array($request->id_area_acceso_t) ? implode(',', $request->id_area_acceso_t) : $request->id_area_acceso_t ?? ''),
            'fecha' => $request->fecha ?? null,
            'iframe' => $request->iframe ?? '',
            'id_responsable' => is_array($request->id_puesto) ? implode(',', $request->id_puesto) : $request->id_puesto ?? null,
            'acceso' => $accesoTodo
                ? $list_responsable_string
                : (is_array($request->tipo_acceso_t) ? implode(',', $request->tipo_acceso_t) : $request->tipo_acceso_t ?? ''),
            'estado' => $request->estado ?? 1,
            'fec_reg' => $request->fec_reg ? date('Y-m-d H:i:s', strtotime($request->fec_reg)) : now(),
            'user_reg' => session('usuario')->id_usuario,

        ]);

        // Redirigir o devolver respuesta
        return redirect()->back()->with('success', 'Reporte registrado con éxito.');
    }


    public function update_ra(Request $request, $id)
    {
        BiReporte::where('id_acceso_bi_reporte', $id)->update([
            'nom_reporte' => $request->nombrea,
            'iframe' => $request->iframea,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,

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
        // Obtener el valor del campo `id_area` y convertirlo en un array
        $selected_area_ids = explode(',', $get_id->id_area);
        $selected_puesto_ids = explode(',', $get_id->acceso);

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

        return view('interna.bi.reportes.registroacceso_reportes.modal_editar', compact(
            'get_id',
            'list_responsable',
            'list_area',
            'selected_area_ids',
            'selected_puesto_ids',
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
