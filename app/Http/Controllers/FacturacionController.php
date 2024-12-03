<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\CajaChicaPago;
use App\Models\Empresas;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TbContabilidad;
use App\Models\TbContabilidadCerrados;
use App\Models\TbContabilidadCerradosParcial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class FacturacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        return view('finanzas.contabilidad.index', compact('list_notificacion', 'list_subgerencia'));
    }



    public function index_ic()
    {
        // Obtener el último registro de la tabla tb_contabilidad_configuracion
        $configuracion = DB::table('tb_contabilidad_configuracion')
            ->where('tipo', 1)
            ->first();
        $configuracion_enviados = DB::table('tb_contabilidad_configuracion')
            ->where('tipo', 2)
            ->first();
        // Si no hay registros, podemos manejarlo según sea necesario
        if ($configuracion) {
            Carbon::setLocale('es');
            $peruTimezone = 'America/Lima';
            // Establecer la fecha y hora en la zona horaria de Perú
            $fecha_actualizacion = Carbon::parse($configuracion->fecha_actualizacion, $peruTimezone)
                ->translatedFormat('l, d M y H:i');
            $fecha_actualizacion_enviados = Carbon::parse($configuracion_enviados->fecha_actualizacion, $peruTimezone)
                ->translatedFormat('l, d M y H:i');

            $cantidad_registros = $configuracion->cantidad_registros;
        } else {
            // En caso de que no haya registros, asignar valores predeterminados o vacíos
            $fecha_actualizacion = 'No disponible';
            $fecha_actualizacion_enviados = 'No disponible';
            $cantidad_registros = 0;
        }

        // Pasar los datos a la vista
        return view('finanzas.contabilidad.facturacion.index', compact('fecha_actualizacion', 'cantidad_registros', 'fecha_actualizacion_enviados'));
    }

    public function index_fp()
    {
        return view('finanzas.contabilidad.facturacion_parcial.index');
    }

    public function index_ft()
    {
        return view('finanzas.contabilidad.facturacion_total.index');
    }

    public function obtenerSkus(Request $request)
    {
        $search = $request->input('search'); // Buscar por este término
        $query = TbContabilidad::query();

        if ($search) {
            $query->where('sku', 'like', "%{$search}%"); // Filtrar por el término de búsqueda en el campo SKU
        }

        // Paginar resultados (por ejemplo, 100 registros por llamada)
        $skus = $query->select('sku') // Seleccionar solo el campo SKU
            ->distinct() // Asegurar que no haya duplicados
            ->limit(100) // Limitar la cantidad de resultados
            ->get();

        // Formatear para Select2
        $results = $skus->map(function ($sku) {
            return [
                'id' => $sku->sku,
                'text' => $sku->sku,
            ];
        });

        return response()->json(['results' => $results]);
    }


    public function list()
    {
        // Obtener la lista de empresas con los campos id_empresa y nom_empresa
        $empresas = Empresas::select('id_empresa', 'nom_empresa')
            ->whereIn('id_empresa', [29, 28, 33, 31, 34, 27, 32, 30]) // Filtrar por los IDs específicos
            ->get();
        // Obtener la lista de SKU únicos desde la tabla tb_contabilidad donde cerrado = 0
        $skus = TbContabilidad::select('sku')
            ->where('cerrado', 0)
            ->distinct()
            ->limit(100)
            ->get();

        // Retornar la vista con las empresas y los SKUs
        return view('finanzas.contabilidad.facturacion.lista', compact('empresas', 'skus'));
    }


    public function facturados_ver(Request $request)
    {
        $idsSeleccionados = $request->input('ids');
        $list_previsualizacion_por_facturar = TbContabilidad::filtrarCerrados($idsSeleccionados);
        // Devolver los registros actualizados en el JSON de respuesta
        return response()->json([
            'updated_records' => $list_previsualizacion_por_facturar
        ]);
    }


    public function facturar_cerrar(Request $request)
    {
        $filas = $request->input('filas'); // Recibimos las filas enviadas desde el frontend

        // Iterar sobre las filas recibidas
        foreach ($filas as $fila) {
            $id = $fila['id']; // ID de la fila
            $parcial = $fila['parcial']; // Estado parcial
            // Buscar el registro original en la tabla tb_contabilidad
            $registro = TbContabilidad::find($id);
            if ($registro) {
                if ($parcial == 1) {
                    // Caso parcial = 1, insertar en tb_contabilidad_cerrados_parcial
                    TbContabilidadCerradosParcial::create([
                        'estilo' => $registro->estilo,
                        'color' => $registro->color,
                        'talla' => $registro->talla,
                        'sku' => $registro->sku,
                        'descripcion' => $registro->descripcion,
                        'costo_precio' => $registro->costo_precio,
                        'empresa' => $registro->empresa,
                        'alm_dsc' => $registro->alm_dsc,
                        'alm_ln1' => $registro->alm_ln1,
                        'alm_discotela' => $registro->alm_discotela,
                        'alm_pb' => $registro->alm_pb,
                        'alm_mad' => $registro->alm_mad,
                        'alm_fam' => $registro->alm_fam,
                        'fecha_documento' => $registro->fecha_documento,
                        'guia_remision' => $registro->guia_remision,
                        'base' => $registro->base,
                        'enviado' => $fila['enviado'],
                        'pendiente' =>  $registro->enviado - $fila['enviado'],
                        'cia' => $registro->cia,
                        'estado' => $registro->estado,
                        'stock' => $registro->stock,
                        'cerrado' => 0,
                        'fecha_cerrado_parcial' => now()
                    ]);
                    // Actualizar el campo 'enviado' en la tabla tb_contabilidad haciendo la resta
                    $registro->enviado = $registro->enviado - $fila['enviado'];
                    $registro->save();
                } else {
                    // Caso parcial = 0, insertar en tb_contabilidad_cerrados
                    TbContabilidadCerrados::create([
                        'estilo' => $registro->estilo,
                        'color' => $registro->color,
                        'talla' => $registro->talla,
                        'sku' => $registro->sku,
                        'descripcion' => $registro->descripcion,
                        'costo_precio' => $registro->costo_precio,
                        'empresa' => $registro->empresa,
                        'alm_dsc' => $registro->alm_dsc,
                        'alm_ln1' => $registro->alm_ln1,
                        'alm_discotela' => $registro->alm_discotela,
                        'alm_pb' => $registro->alm_pb,
                        'alm_mad' => $registro->alm_mad,
                        'alm_fam' => $registro->alm_fam,
                        'fecha_documento' => $registro->fecha_documento,
                        'guia_remision' => $registro->guia_remision,
                        'base' => $registro->base,
                        'enviado' => $registro->enviado,
                        'cia' => $registro->cia,
                        'estado' => $registro->estado,
                        'stock' => $registro->stock,
                        'cerrado' => 1,
                        'fecha_cerrado_total' => now()
                    ]);
                    // Eliminar el registro de la tabla tb_contabilidad
                    $registro->delete();  // Eliminar el registro
                }
            } else {
                // Manejo de error si el registro no existe
                return response()->json([
                    'success' => false,
                    'message' => "El registro con ID $id no existe en la tabla tb_contabilidad."
                ]);
            }
        }

        // Si todo ha ido bien, devolver una respuesta positiva
        return response()->json([
            'success' => true,
            'message' => "Las filas han sido procesadas correctamente."
        ]);
    }


    public function list_datatable(Request $request)
    {
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search')['value'] ?? '';
        $order = $request->input('order');
        $columns = $request->input('columns');
        $almacenSeleccionadoInput = $request->input('almacenSeleccionadoInput');
        $almacenes = [
            '1' => 'alm_dsc',
            '2' => 'alm_discotela',
            '3' => 'alm_pb',
            '4' => 'alm_mad',
            '5' => 'alm_fam',
        ];
        $almacenActivo = $almacenes[$almacenSeleccionadoInput] ?? null;
        $query = TbContabilidad::filtros([
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'estado' => $request->input('estado'),
            'sku' => $request->input('filtroSku'),
            'empresa' => $request->input('filtroEmpresa'),
            'search' => $search,
            'almacen' => $almacenActivo,
        ]);
        if ($order) {
            $columnIndex = $order[0]['column'];
            $columnName = $columns[$columnIndex]['data'];
            $columnSortOrder = $order[0]['dir'];
            if ($columnName) {
                $query->orderBy($columnName, $columnSortOrder);
            }
        }
        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }



    public function actualizarTabla(Request $request)
    {
        try {
            // Llamar a la función para sincronizar datos
            $cantidadRegistrosActualizados = TbContabilidad::sincronizarContabilidad();
            // Obtener la configuración
            $configuracion = DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 1)
                ->first();
            if ($configuracion) {
                Carbon::setLocale('es');
                $peruTimezone = 'America/Lima';
                $fecha_actualizacion = Carbon::parse($configuracion->fecha_actualizacion, $peruTimezone)
                    ->translatedFormat('l, d M y H:i');
                $cantidad_registros = $configuracion->cantidad_registros;
                // Retornar una respuesta JSON
                return response()->json([
                    'success' => true,
                    'fecha_actualizacion' => $fecha_actualizacion,
                    'cantidad_registros' => $cantidad_registros,
                    'cantidad_insertados' => $cantidadRegistrosActualizados,
                ]);
            }
            // Si no hay configuración, devolver valores predeterminados
            return response()->json([
                'success' => false,
                'fecha_actualizacion' => 'No disponible',
                'cantidad_registros' => 0,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function actualizarEnviadosTabla()
    {
        try {
            // Llamar a la función para sincronizar datos
            $cantidadRegistrosActualizados = TbContabilidad::sincronizarEnviadosContabilidad();
            // Obtener la configuración
            $configuracion = DB::table('tb_contabilidad_configuracion')
                ->where('tipo', 2)
                ->first();
            if ($configuracion) {
                Carbon::setLocale('es');
                $peruTimezone = 'America/Lima';
                $fecha_actualizacion_enviados = Carbon::parse($configuracion->fecha_actualizacion, $peruTimezone)
                    ->translatedFormat('l, d M y H:i');
                // Retornar una respuesta JSON
                return response()->json([
                    'success' => true,
                    'fecha_actualizacion_enviados' => $fecha_actualizacion_enviados,
                    'cantidad_insertados_enviados' => $cantidadRegistrosActualizados,
                ]);
            }
            // Si no hay configuración, devolver valores predeterminados
            return response()->json([
                'success' => false,
                'fecha_actualizacion_enviados' => 'No disponible',
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }




    public function excel_ic($fecha_inicio, $fecha_fin)
    {
        // Establece un límite de tiempo para la ejecución si es necesario
        set_time_limit(500);
        // Obtén los registros filtrados por fecha
        $list_previsualizacion_por_facturar = TbContabilidad::filtrarCerradosExcel($fecha_inicio, $fecha_fin);
        // Crea un objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Alineación y estilo de encabezado
        $sheet->getStyle("A1:T1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:T1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->setTitle('Facturación');
        // Establece el filtro automático
        $sheet->setAutoFilter('A1:T1');

        // Establece el ancho de las columnas
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(15);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(15);
        $sheet->getColumnDimension('S')->setWidth(15);
        $sheet->getColumnDimension('T')->setWidth(15);

        // Estilo de fuente en negrita para los encabezados
        $sheet->getStyle('A1:T1')->getFont()->setBold(true);

        // Color de fondo de los encabezados
        $spreadsheet->getActiveSheet()->getStyle("A1:T1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        // Definir el borde de las celdas
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // Aplicar borde a los encabezados
        $sheet->getStyle("A1:T1")->applyFromArray($styleThinBlackBorderOutline);

        // Agregar encabezados
        $sheet->setCellValue("A1", 'Estilo');
        $sheet->setCellValue("B1", 'Color');
        $sheet->setCellValue("C1", 'Talla');
        $sheet->setCellValue("D1", 'SKU');
        $sheet->setCellValue("E1", 'Descripción');
        $sheet->setCellValue("F1", 'Costo Prom');
        $sheet->setCellValue("G1", 'Empresa');
        $sheet->setCellValue("H1", 'Alm Dsc');
        $sheet->setCellValue("I1", 'Alm Ln1');
        $sheet->setCellValue("J1", 'Alm Discotela');
        $sheet->setCellValue("K1", 'Alm Pb');
        $sheet->setCellValue("L1", 'Alm Mad');
        $sheet->setCellValue("M1", 'Alm Fam');
        $sheet->setCellValue("N1", 'Fecha Documento');
        $sheet->setCellValue("O1", 'Guía Remisión');
        $sheet->setCellValue("P1", 'Base');
        $sheet->setCellValue("Q1", 'Despachado');
        $sheet->setCellValue("R1", 'Cia');
        $sheet->setCellValue("S1", 'Estado');
        $sheet->setCellValue("T1", 'Stock');

        // Contador para las filas
        $contador = 1;

        // Recorrer los registros y agregar los datos a las celdas
        foreach ($list_previsualizacion_por_facturar as $list) {
            $contador++;

            // Alineación de los datos y aplicación de borde
            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:T{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            // Asignación de valores a las celdas, asegurando que se mantengan como texto cuando sea necesario
            $sheet->setCellValueExplicit("A{$contador}", $list->estilo, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("B{$contador}", $list->color, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("C{$contador}", $list->talla, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("D{$contador}", $list->sku, DataType::TYPE_STRING); // SKU con ceros
            $sheet->setCellValueExplicit("E{$contador}", $list->descripcion, DataType::TYPE_STRING);
            $sheet->setCellValue("F{$contador}", $list->costo_precio);
            $sheet->setCellValueExplicit("G{$contador}", $list->empresa, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("H{$contador}", $list->alm_dsc, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("I{$contador}", $list->alm_ln1, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("J{$contador}", $list->alm_discotela, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("K{$contador}", $list->alm_pb, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("L{$contador}", $list->alm_mad, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit("M{$contador}", $list->alm_fam, DataType::TYPE_STRING);
            $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list->fecha_documento));
            $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValueExplicit("O{$contador}", $list->guia_remision, DataType::TYPE_STRING);
            $sheet->setCellValue("P{$contador}", $list->base);
            $sheet->setCellValue("Q{$contador}", $list->enviado);
            $sheet->setCellValue("R{$contador}", $list->cia);
            $sheet->setCellValueExplicit("S{$contador}", $list->estado, DataType::TYPE_STRING);
            $sheet->setCellValue("T{$contador}", $list->stock);
        }

        // Crear el archivo Excel y enviarlo al navegador
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_Facturación_General';

        // Limpiar el buffer de salida y establecer encabezados para el archivo
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Guardar el archivo en la salida estándar (navegador)
        $writer->save('php://output');
    }



    public function excel_filtrado($ids)
    {
        // Recuperamos los IDs desde la solicitud y los convertimos a un arreglo
        $idsSeleccionados = explode(',', $ids);

        // Filtramos los datos según los IDs seleccionados
        $list_previsualizacion_por_facturar = TbContabilidad::filtrarCerrados($idsSeleccionados);

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Formato de encabezado
        $sheet->getStyle("A1:T1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:T1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Establecer el nombre de la hoja
        $spreadsheet->getActiveSheet()->setTitle('Informe Facturación Filtrado');

        // Establecer autofiltro
        $sheet->setAutoFilter('A1:T1');

        // Definir el tamaño de las columnas
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);
        $sheet->getColumnDimension('Q')->setWidth(15);
        $sheet->getColumnDimension('R')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
        $sheet->getColumnDimension('T')->setWidth(15);

        // Estilo del encabezado
        $sheet->getStyle('A1:T1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:T1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        // Estilo de bordes
        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // Definir encabezados de las columnas
        $sheet->setCellValue("A1", 'Estilo');
        $sheet->setCellValue("B1", 'Color');
        $sheet->setCellValue("C1", 'Talla');
        $sheet->setCellValue("D1", 'SKU');
        $sheet->setCellValue("E1", 'Descripción');
        $sheet->setCellValue("F1", 'Costo Prom');
        $sheet->setCellValue("G1", 'Empresa');
        $sheet->setCellValue("H1", 'Almacen LN1');
        $sheet->setCellValue("I1", 'Almacen DSC');
        $sheet->setCellValue("J1", 'Almacen Discotela');
        $sheet->setCellValue("K1", 'Almacen PB');
        $sheet->setCellValue("L1", 'Almacen Fam');
        $sheet->setCellValue("M1", 'Almacen Mad');
        $sheet->setCellValue("N1", 'Fecha Documento');
        $sheet->setCellValue("O1", 'Guía Remisión');
        $sheet->setCellValue("P1", 'Despachado');
        $sheet->setCellValue("Q1", 'Estado');
        $sheet->setCellValue("R1", 'Base');
        $sheet->setCellValue("S1", 'CIA');
        $sheet->setCellValue("T1", 'Stock');

        // Variable para contador de filas
        $contador = 1;

        // Recorrer la lista filtrada y añadir los datos al Excel
        foreach ($list_previsualizacion_por_facturar as $list) {
            $contador++;

            // Alinear las celdas y aplicar bordes
            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}:T{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:T{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            // Asignar valores a las celdas
            $sheet->setCellValue("A{$contador}", $list->estilo);
            $sheet->setCellValue("B{$contador}", $list->color);
            $sheet->setCellValue("C{$contador}", $list->talla);
            $sheet->setCellValue("D{$contador}", $list->sku);
            $sheet->setCellValue("E{$contador}", $list->descripcion);
            $sheet->setCellValue("F{$contador}", $list->costo_precio);
            $sheet->setCellValue("G{$contador}", $list->empresa);
            $sheet->setCellValue("H{$contador}", $list->alm_ln1);
            $sheet->setCellValue("I{$contador}", $list->alm_dsc);
            $sheet->setCellValue("J{$contador}", $list->alm_discotela);
            $sheet->setCellValue("K{$contador}", $list->alm_pb);
            $sheet->setCellValue("L{$contador}", $list->alm_fam);
            $sheet->setCellValue("M{$contador}", $list->alm_mad);
            $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list->fecha_documento));
            $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("O{$contador}", $list->guia_remision);
            $sheet->setCellValue("P{$contador}", $list->enviado);
            $sheet->setCellValue("Q{$contador}", $list->estado);
            $sheet->setCellValue("R{$contador}", $list->base);
            $sheet->setCellValue("S{$contador}", $list->cia);
            $sheet->setCellValue("T{$contador}", $list->stock);
        }

        // Crear el archivo Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Informe_Facturación_Filtrado';

        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Guardar el archivo Excel en la salida
        $writer->save('php://output');
    }









    // FACTURACIÓN PARCIAL
    public function list_fp()
    {

        return view('finanzas.contabilidad.facturacion_parcial.lista');
    }

    public function list_datatable_fp(Request $request)
    {
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search')['value'] ?? '';
        $order = $request->input('order'); // Parámetros de ordenamiento
        $columns = $request->input('columns'); // Información de las columnas

        $query = TbContabilidadCerradosParcial::filtros([
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'estado' => $request->input('estado'),
            'sku' => $request->input('filtroSku'),
            'empresa' => $request->input('filtroEmpresa'),
            'search' => $search
        ]);

        // Manejo de ordenamiento
        if ($order) {
            $columnIndex = $order[0]['column']; // Índice de la columna
            $columnName = $columns[$columnIndex]['data']; // Nombre de la columna
            $columnSortOrder = $order[0]['dir']; // Dirección (asc o desc)

            if ($columnName) {
                $query->orderBy($columnName, $columnSortOrder);
            }
        }

        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data
        ]);
    }


    // FACTURACIÓN TOTAL
    public function list_ft()
    {
        return view('finanzas.contabilidad.facturacion_total.lista');
    }

    public function list_datatable_ft(Request $request)
    {
        $draw = intval($request->input('draw'));
        $start = intval($request->input('start'));
        $length = intval($request->input('length'));
        $search = $request->input('search')['value'] ?? '';
        $order = $request->input('order'); // Parámetros de ordenamiento
        $columns = $request->input('columns'); // Información de las columnas

        $almacenSeleccionadoInput = $request->input('almacenSeleccionadoInput');

        $almacenes = [
            '1' => 'alm_dsc',
            '2' => 'alm_discotela',
            '3' => 'alm_pb',
            '4' => 'alm_mad',
            '5' => 'alm_fam',
        ];
        $almacenActivo = $almacenes[$almacenSeleccionadoInput] ?? null;
        // dd($almacenActivo);
        $query = TbContabilidadCerrados::filtros([
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin' => $request->input('fecha_fin'),
            'estado' => $request->input('estado'),
            'sku' => $request->input('filtroSku'),
            'empresa' => $request->input('filtroEmpresa'),
            'search' => $search,
            'almacen' => $almacenActivo,

        ]);

        // Manejo de ordenamiento
        if ($order) {
            $columnIndex = $order[0]['column']; // Índice de la columna
            $columnName = $columns[$columnIndex]['data']; // Nombre de la columna
            $columnSortOrder = $order[0]['dir']; // Dirección (asc o desc)
            if ($columnName) {
                $query->orderBy($columnName, $columnSortOrder);
            }
        }

        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        $facturadosTotal = $query->sum('enviado');
        // dd($facturadosTotal);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
            'facturadosTotal' => $facturadosTotal
        ]);
    }
}
