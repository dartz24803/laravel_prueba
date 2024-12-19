<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Base;
use App\Models\Usuario;
use App\Models\Area;
use App\Models\Gerencia;
use App\Models\Mes;
use App\Models\Anio;
use App\Models\SubGerencia;
use DateTime;
use App\Models\Notificacion;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class AsistenciaController extends Controller
{
    protected $request;
    protected $modelo;
    protected $modelobase;
    protected $modelousuarios;
    protected $modeloarea;
    protected $modelogerencia;
    protected $modelomes;
    protected $modeloanio;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario');
        $this->request = $request;
        $this->modelo = new Asistencia();
        $this->modelobase = new Base();
        $this->modelousuarios = new Usuario();
        $this->modelogerencia = new Gerencia();
        $this->modeloarea = new Area();
        $this->modelomes = new Mes();
        $this->modeloanio = new Anio();
    }

    //parte superior de pestañas
    public function index()
    {
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(5);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //$dato['list_asistencia'] = $this->Model_Asistencia->get_list_asistencia_biotime();
        $id_gerencia = 0;

        $id_area = Session('usuario')->id_area;
        $id_puesto = Session('usuario')->id_puesto;
        $centro_labores = Session('usuario')->id_centro_labor;
        $cod_base = 0;
        $num_doc = 0;
        $list_base = Ubicacion::select('id_ubicacion', 'cod_ubi')
            ->where('estado', 1)
            ->orderBy('cod_ubi', 'ASC')
            ->get();
        //print_r($list_base[0]);

        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161  || $id_puesto == 314) {
            $cod_base = $centro_labores;
        } else {
            $cod_base = 23;
        }
        $estado = 1;
        $list_colaborador = $this->modelousuarios->get_list_usuarios_x_baset($cod_base, $area = null, $estado);
        $list_area = $this->modeloarea->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_gerencia = $this->modelogerencia->get_list_gerencia();
        $list_mes = $this->modelomes->where('estado', 1)->get();
        $list_anio = $this->modeloanio->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161 || $id_puesto == 311 || $id_puesto == 314) {
            return view('rrhh.Asistencia.reporte.indexct', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        } else {
            return view('rrhh.Asistencia.reporte.index', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        }
    }

    public function Buscar_Reporte_Control_Asistencia(Request $request)
    {
        set_time_limit(600);
        ini_set('max_execution_time', 600);
        $tipo = $request->input("tipo");
        $codMes = $request->input('cod_mes');
        $codAnio = $request->input('cod_anio');

        $codBase = $request->input('cod_base', 0);
        $codBase = ($codBase === "-1") ? -1 : (is_numeric($codBase) ? intval($codBase) : $codBase);
        $numDoc = $request->input('num_doc', []);
        if (empty($numDoc)) {
            $numDoc = [0];
        }
        //$numDoc = array_map('intval', $numDoc);

        $area = intval($request->input('area', 0));
        $estado = $request->input('estado', null);
        if (empty($estado)) {
            $estado = 1;
        }
        $tipo = $request->input('tipo');
        $initialDate = $request->input('finicio');
        $endDate = $request->input('ffin');

        if ($tipo == 1) {
            // Convertir el mes y el año a un rango de fechas (initialDate, endDate)
            try {
                // Primer día del mes
                $initialDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->format('d/m/Y'); // Primer día del mes
                // Último día del mes
                $endDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->endOfMonth()->format('d/m/Y'); // Último día del mes
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al procesar las fechas: ' . $e->getMessage()], 400);
            }
        } else {
            $initialDate = $request->input('finicio');
            $endDate = $request->input('ffin');
            // Transformar las fechas al formato dd/mm/yyyy
            $initialDate = date('d/m/Y', strtotime($initialDate));
            $endDate = date('d/m/Y', strtotime($endDate));
        }

        // Construir los datos para la consulta a la API
        $queryParams = [
            'initialDate' => $initialDate,
            'endDate' => $endDate,
            'clabores' => $codBase,
            'area' => intval($area),
            'estado' => intval($estado),
            'colaborador' => $numDoc,
        ];
        // print_r(json_encode($numDoc));
        // dd($queryParams);

        $response = Http::post('http://172.16.0.140:8001/api/v1/list/asistenciaColaborador', $queryParams);
        // print_r($response->json()['data']);

        // Verificar si la respuesta fue exitosa
        if ($response->successful()) {
            // Obtener los datos de la respuesta JSON
            $list_asistencia = $response->json()['data']; // Aquí asumimos que 'data' es la clave que contiene los resultados
            // print_r($list_asistencia);
            // Pasar las variables a la vista
            return view('rrhh.Asistencia.reporte.listar', compact('initialDate', 'endDate', 'list_asistencia', 'numDoc'));
        } else {
            // Si la API falla, puedes manejar el error
            return response()->json([
                'error' => true,
            ]);
        }
    }
    public function Traer_Colaborador_Asistencia(Request $request)
    {
        $dato['cod_base'] = $request->input('cod_base');
        $dato['id_area'] = $request->input('id_area');
        $dato['estado'] = $request->input('estado');
        $dato['list_colaborador'] = $this->modelousuarios->get_list_usuarios_x_baset($dato['cod_base'], $dato['id_area'], $dato['estado']);
        return view('rrhh.Asistencia.reporte.colaborador', $dato);
    }

    public function Excel_Reporte_Asistencia($codMes, $codAnio, $codBase, $numDoc, $area, $estado, $tipo, $initialDate, $endDate, Request $request){
        set_time_limit(600);
        ini_set('max_execution_time', 600);
        // Crear una nueva instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Reporte Control Asistencia');

        if (empty($numDoc)) {
            $numDoc = 0;
        }
        if ($tipo == 1) {
            // Convertir el mes y el año a un rango de fechas (initialDate, endDate)
            try {
                // Primer día del mes
                $initialDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->format('d/m/Y'); // Primer día del mes
                // Último día del mes
                $endDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->endOfMonth()->format('d/m/Y'); // Último día del mes
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al procesar las fechas: ' . $e->getMessage()], 400);
            }
        } else {
            // Transformar las fechas al formato dd/mm/yyyy
            $initialDate = date('d/m/Y', strtotime($initialDate));
            $endDate = date('d/m/Y', strtotime($endDate));
        }
        $colaboradores = explode(',', $numDoc); // Convertir la cadena a un array

        // Construir los datos para la consulta a la API
        $queryParams = [
            'initialDate' => $initialDate,
            'endDate' => $endDate,
            'clabores' => intval($codBase), // Aquí mapeamos 'cod_base' como 'clabores'
            'area' => intval($area),
            'estado' => $estado,
            'colaborador' => $colaboradores,
        ];
        // print_r(json_encode($numDoc));
        // print_r($queryParams);
        $response = Http::post('http://172.16.0.140:8001/api/v1/list/asistenciaColaborador', $queryParams);
        $list_asistencia = $response->json()['data'];
        // print_r($list_asistencia);

        // Establecer fechas de inicio y fin
        $fechas = [];
        if ($tipo == 1) {
            $fecha_inicio = new DateTime("$codAnio-$codMes-01");
            $fecha_fin = new DateTime("$codAnio-$codMes-" . $fecha_inicio->format('t'));
        } else {
            $fecha_inicio = DateTime::createFromFormat('d/m/Y', $initialDate);
            $fecha_fin = DateTime::createFromFormat('d/m/Y', $endDate);
        }
        $get_mes = Mes::where('cod_mes', $codMes)->get();
        if ($tipo == 1) {
            $spreadsheet->getActiveSheet()->setCellValue("C1", $get_mes[0]->nom_mes . ' ' . $codAnio);
        } else {
            $spreadsheet->getActiveSheet()->setCellValue("C1", $initialDate . ' - ' . $endDate);
        }

        while ($fecha_inicio <= $fecha_fin) {
            $fechas[] = $fecha_inicio->format('Y-m-d');
            $fecha_inicio->modify('+1 day');
        }

        $spreadsheet->getActiveSheet()->setCellValue("Q1", 'CONTROL DE ASISTENCIA');
        $spreadsheet->getActiveSheet()->setCellValue("A6", 'N°');
        $spreadsheet->getActiveSheet()->setCellValue("B6", 'APELLIDOS Y NOMBRES');

        $spreadsheet->getActiveSheet()->setCellValue("D3", 'ASISTENCIA');
        $spreadsheet->getActiveSheet()->setCellValue("G3", '1');
        $spreadsheet->getActiveSheet()->setCellValue("J3", 'FALTAS');
        $spreadsheet->getActiveSheet()->setCellValue("L3", '0');
        $spreadsheet->getActiveSheet()->setCellValue("Q3", 'TARDANZAS');
        $spreadsheet->getActiveSheet()->setCellValue("T3", 'T');
        $spreadsheet->getActiveSheet()->setCellValue("Y3", 'FALTA JUSTIFICADA');
        $spreadsheet->getActiveSheet()->setCellValue("AC3", 'FJ');

        $sheet->getStyle('C1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '51B9D6'], // Color de texto en formato RGB
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ]);

        $sheet->getStyle("D3:AC3")->getFont()->setBold(true);

        $colIndex = 3; // Comenzamos en la columna C
        foreach ($fechas as $fecha) {
            $colLetter = Coordinate::stringFromColumnIndex($colIndex); // Convertir índice de columna a letra
            $fechaDatetime = new DateTime($fecha);

            // Día de la semana (L, M, M, J, V, S, D)
            $diaSemana = [
                'Mon' => 'L',
                'Tue' => 'M',
                'Wed' => 'M',
                'Thu' => 'J',
                'Fri' => 'V',
                'Sat' => 'S',
                'Sun' => 'D',
            ][$fechaDatetime->format('D')];

            // Número del día
            $numeroDia = $fechaDatetime->format('d');

            // Escribir en las celdas
            $sheet->setCellValue($colLetter . '5', $diaSemana);
            $sheet->setCellValue($colLetter . '6', $numeroDia);

            $colIndex++;
        }
        $sheet->getStyle('A5:' . $colLetter . '6')->applyFromArray([
            'font' => ['bold' => true],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFdce6f1', // Color de fondo en formato ARGB (A: alfa, R: rojo, G: verde, B: azul)
                ],
            ],
        ]);

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(40);
        // $sheet->getColumnDimension('C')->setWidth(40);
        $allborder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        // Agregar los datos de los usuarios
        $rowIndex = 7; // Comenzamos en la fila 7
        $usuarios = [];

        $usuarios = []; // Inicializamos el array para los usuarios sin repetir
        $usuarios_unique = []; // Este array almacenará los números de documento para garantizar que los usuarios no se repitan

        foreach ($list_asistencia as $registro) {
            // Verificar si el usuario ya existe en el array (por el número de documento)
            if (!in_array($registro['Num_Doc'], $usuarios_unique)) {
                // Si no existe, agregar al array de usuarios y al array de referencia
                $usuarios[] = [
                    'num_doc' => $registro['Num_Doc'],
                    'usuario_apater' => $registro['Usuario_Apater'],
                    'usuario_amater' => $registro['Usuario_Amater'],
                    'usuario_nombres' => $registro['Usuario_Nombres'],
                    'fecha' => $registro['Fecha'],
                ];
                $usuarios_unique[] = $registro['Num_Doc']; // Guardamos el número de documento para verificarlo en el siguiente ciclo
            }
        }

        // print_r($list_asistencia);
        foreach ($usuarios as $key => $usuario) {
            $sheet->setCellValue('A' . $rowIndex, $key + 1); // Número
            $sheet->setCellValue('B' . $rowIndex, $usuario['usuario_apater'] . ' ' . $usuario['usuario_amater'] . ', ' . $usuario['usuario_nombres']);

            $colIndex = 3; // Columna inicial para las fechas

            foreach ($fechas as $fecha) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex); // Convertir índice de columna a letra
                $fechaFormateada = Carbon::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');

                $estadoMarcacion = 0; // Por defecto, asumimos 0
                if (isset($list_asistencia)) {
                    foreach ($list_asistencia as $asistencia) {
                        // print_r("Usuario:". $usuario['fecha']);
                        // print_r("Asistencia:". $asistencia['Fecha']);
                        if ($asistencia['Num_Doc'] == $usuario['num_doc']) {
                            if ($fechaFormateada == $asistencia['Fecha']) {
                                if (!empty($asistencia['Salida'])) {
                                    $estadoMarcacion = 1; // Si hay salida, marcar como 1
                                }
                            }
                        }
                    }
                }

                // Escribir en la celda
                $sheet->setCellValue($colLetter . $rowIndex, $estadoMarcacion);
                $colIndex++;
            }
            $rowIndex++;
        }

        $bordeTabla = $rowIndex - 1;
        $sheet->getStyle('A5:' . $colLetter . $bordeTabla)->applyFromArray($allborder);

        // Descargar el archivo Excel
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Reporte Control Asistencia ' . $curdate;

        // Configuración de cabeceras para la descarga
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Guardar y enviar el archivo al navegador
        $writer->save('php://output');
    }



    public function Excel_Asistencia_Colaborador($codMes, $codAnio, $codBase, $numDoc, $area, $estado, $tipo, $initialDate, $endDate, Request $request){
        set_time_limit(600);
        ini_set('max_execution_time', 600);
        // Crear una nueva instancia de Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Reporte Control Asistencia');

        if (empty($numDoc)) {
            $numDoc = 0;
        }
        if ($tipo == 1) {
            // Convertir el mes y el año a un rango de fechas (initialDate, endDate)
            try {
                // Primer día del mes
                $initialDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->format('d/m/Y'); // Primer día del mes
                // Último día del mes
                $endDate = \Carbon\Carbon::createFromDate($codAnio, $codMes, 1)->endOfMonth()->format('d/m/Y'); // Último día del mes
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al procesar las fechas: ' . $e->getMessage()], 400);
            }
        } else {
            // Transformar las fechas al formato dd/mm/yyyy
            $initialDate = date('d/m/Y', strtotime($initialDate));
            $endDate = date('d/m/Y', strtotime($endDate));
        }
        $colaboradores = explode(',', $numDoc); // Convertir la cadena a un array

        // Construir los datos para la consulta a la API
        $queryParams = [
            'initialDate' => $initialDate,
            'endDate' => $endDate,
            'clabores' => intval($codBase), // Aquí mapeamos 'cod_base' como 'clabores'
            'area' => intval($area),
            'estado' => $estado,
            'colaborador' => $colaboradores,
        ];
        // dd($queryParams);
        // Solicitud HTTP a la API externa
        $response = Http::post('http://172.16.0.140:8001/api/v1/list/asistenciaColaborador', $queryParams);
        $list_asistencia = $response->json()['data'];
        // dd($list_asistencia);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Configuración de estilos y dimensiones
        $sheet->getStyle("A1:K1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:K1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->setTitle('Asistencias');
        $sheet->setAutoFilter('A1:K1');

        $columnWidths = [
            'A' => 50,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 30,
            'F' => 15,
            'G' => 25,
            'H' => 25,
            'I' => 15,
            'J' => 15,
            'K' => 18
        ];

        foreach ($columnWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()
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

        $sheet->getStyle("A1:H1")->applyFromArray($styleThinBlackBorderOutline);

        // Encabezados del Excel
        $headers = [
            'A' => 'Colaborador',
            'B' => 'DNI',
            'C' => 'Base',
            'D' => 'Fecha',
            'E' => 'Entrada',
            'F' => 'Salida a refrigerio',
            'G' => 'Entrada de refrigerio',
            'H' => 'Salida',
        ];

        foreach ($headers as $col => $text) {
            $sheet->setCellValue("{$col}1", $text);
        }

        // Llenar datos en el Excel
        $contador = 1;
        foreach ($list_asistencia as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("E{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:H{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:H{$contador}")->applyFromArray($styleThinBlackBorderOutline);

            $spreadsheet->getActiveSheet()->setCellValue(
                "A{$contador}",
                $list['Usuario_Nombres'] . " " . $list['Usuario_Apater'] . " " . $list['Usuario_Amater']
            );
            $spreadsheet->getActiveSheet()->setCellValue("B{$contador}", $list['Num_Doc']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$contador}", $list['Centro_Labores']);

            // Convertir la fecha al formato Excel
            $fechaExcel = Date::PHPToExcel(\DateTime::createFromFormat('d/m/Y', $list['Fecha']));
            $sheet->setCellValue("D{$contador}", $fechaExcel);
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

            // Extraer solo la hora de los campos con fecha y hora
            $horaIngreso = $list['Ingreso'] ? date('H:i:s', strtotime($list['Ingreso'])) : '';
            $horaInicioRefrigerio = $list['Inicio_Refrigerio'] ? date('H:i:s', strtotime($list['Inicio_Refrigerio'])) : '';
            $horaFinRefrigerio = $list['Fin_Refrigerio'] ? date('H:i:s', strtotime($list['Fin_Refrigerio'])) : '';
            $horaSalida = $list['Salida'] ? date('H:i:s', strtotime($list['Salida'])) : '';

            // Colocar valores en las columnas
            $spreadsheet->getActiveSheet()->setCellValue("E{$contador}", $horaIngreso);
            $spreadsheet->getActiveSheet()->setCellValue("F{$contador}", $horaInicioRefrigerio);
            $spreadsheet->getActiveSheet()->setCellValue("G{$contador}", $horaFinRefrigerio);
            $spreadsheet->getActiveSheet()->setCellValue("H{$contador}", $horaSalida);
        }



        // Configuración para la descarga del archivo
        $writer = new Xlsx($spreadsheet);
        $filename = 'Asistencias';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }



    public function Update_Asistencia_Diaria(Request $request)
    {
        $request->validate([
            'hora' => 'required'
        ], [
            'hora' => 'Debe ingresar hora.',
        ]);

        $dato['hora'] = $request->post("hora");
        $dato['fecha'] = $request->post("fecha");
        $dato['punch_time'] = $dato['fecha'] . " " . $dato['hora'];
        $dato['id_asistencia_remota'] = $request->post("id_asistencia_remota");

        DB::connection('second_mysql')
            ->table('iclock_transaction')
            ->where('id', $dato['id_asistencia_remota'])
            ->update([
                'punch_time' => $dato['punch_time']
            ]);
    }

    public function Modal_Reg_Asistencia(Request $request)
    {
        return view('rrhh.Asistencia.reporte.modal_reg');
    }

    public function Modal_Registro_Dia($nombres, $num_doc, $orden, $time)
    {
        $dato['nombres'] = $nombres;
        $dato['num_doc'] = $num_doc;
        $dato['fecha'] = $orden;
        $dato['time'] = $time;
        return view('rrhh.Asistencia.reporte.modal_reg', $dato);
    }

    public function Insert_Asistencia_Diaria(Request $request)
    {
        $dato['hora'] = $request->post("horar");
        $dato['fecha'] = $request->post("fechar");
        $dato['num_doc'] = $request->post("num_docr");
        $dato['punch_time'] = $dato['fecha'] . " " . $dato['hora'];
        $dato['get_id'] = Usuario::select('ubicacion.cod_ubi AS centro_labores')
            ->leftJoin('ubicacion', 'users.id_centro_labor', '=', 'ubicacion.id_ubicacion')
            ->where('users.num_doc', $dato['num_doc'])
            ->get();

        //print_r($dato['get_id']);
        if (empty($dato['get_id'])) {
            echo "error";
        } else {
            $dato['base'] = $dato['get_id'][0]->centro_labores;
            $dato['get_employee'] = DB::connection('second_mysql')
                ->table('personnel_employee')
                ->select('id')
                ->whereRaw("LPAD(emp_code, 8, '0') = ?", [$dato['num_doc']])
                ->first();

            //print_r($dato['get_employee']);
            $dato['emp_id'] = $dato['get_employee']->id;
            $dato['get_terminal'] = DB::connection('second_mysql')
                ->table('iclock_terminal')
                ->select('id', 'sn', 'alias')
                ->where('alias', $dato['base'])
                ->get();
            if (count($dato['get_terminal']) > 0) {
                $dato['terminal_id'] = $dato['get_terminal'][0]->id;
                $dato['terminal_sn'] = $dato['get_terminal'][0]->sn;
                $dato['terminal_alias'] = $dato['get_terminal'][0]->alias;
            } else {
                $dato['terminal_id'] = "23";
                $dato['terminal_sn'] = "AF6P211660021";
                $dato['terminal_alias'] = $dato['base']; //"OFC";
            }
            DB::connection('second_mysql')
                ->table('iclock_transaction')
                ->insert([
                    'emp_code'      => $dato['num_doc'],
                    'punch_time'    => $dato['punch_time'],
                    'punch_state'   => 0,
                    'verify_type'   => 1,
                    'terminal_sn'   => $dato['terminal_sn'],
                    'terminal_alias' => $dato['terminal_alias'],
                    'source'        => 1,
                    'purpose'       => 9,
                    'upload_time'   => $dato['punch_time'],
                    'emp_id'        => $dato['emp_id'],
                    'terminal_id'   => $dato['terminal_id'],
                    'is_mask'       => '255',
                    'temperature'   => '255.0',
                ]);
        }
    }

    public function Buscar_No_Marcados(Request $request)
    {
        $id_puesto = Session('usuario')->id_puesto;
        $cod_mes = $request->input("cod_mes");
        $cod_anio = $request->input("cod_anio");
        $cod_base = $request->input("cod_base");
        $num_doc = $request->input("num_doc");
        $area = $request->input("area");
        $estado = $request->input("estado");
        $tipo = $request->input("tipo");
        $finicio = $request->input("finicio");
        $ffin = $request->input("ffin");

        $usuarios = Usuario::select('usuario_codigo', 'id_usuario');

        if ($estado == 1 || $estado == 2) {
            $usuarios->where('users.estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('users.usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            if ($cod_base === "t") {
                $usuarios->leftJoin('ubicacion', 'users.id_centro_labor', 'ubicacion.id_ubicacion');
                $usuarios->where('ubicacion.estado', 1);
                $usuarios->where('ubicacion.id_sede', 6);
            } else {
                $usuarios->where('users.id_centro_labor', $cod_base);
            }
        }
        if ($area != 0) {
            $usuarios->leftJoin('puesto', 'users.id_puesto', 'puesto.id_puesto');
            $usuarios->where('puesto.id_area', $area);
        }

        // $query = $usuarios->toSql(); // Obtener la consulta SQL generada
        // $bindings = $usuarios->getBindings(); // Obtener los bindings (valores)

        // echo "Consulta: $query\n";
        // print_r($bindings); // Imprimir los valores que se utilizan en la consulta

        $usuarios = $usuarios->get();
        // print_r($cod_base);

        $year = date('Y');
        if ($tipo == 1) {
            $year = $cod_anio;
            $fecha_inicio = strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01");
            $fecha_fin = $L->format('Y-m-t');
            $timestamp = strtotime($fecha_fin);
            $fecha_fin = strtotime(date("d-m-Y", $timestamp));
        } else {
            $fecha_inicio = strtotime(date("d-m-Y", strtotime($request->input("finicio"))));
            $fecha_fin = strtotime(date("d-m-Y", strtotime($request->input("ffin"))));
        }

        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia_nm($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios);
        // print_r($list_asistencia);
        if ($num_doc != 0) {
            $list_colaborador = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        } else {
            $list_colaborador = $this->modelo->get_list_usuarios_x_baset($cod_base, $area, $estado);
        }
        $n_documento = $num_doc;

        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197) {
            return view('rrhh.Asistencia.NoMarcados.listarct_nm', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        } else {
            return view('rrhh.Asistencia.NoMarcados.listar_nm', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        }
    }

    public function Modal_Update_Asistencia($nombres, $dni, $orden, $time)
    {
        $dato['nombres'] = $nombres;
        $dato['get_id'] = DB::connection('second_mysql')
            ->table('iclock_transaction')
            ->whereDate('punch_time', $orden)
            ->where('punch_time', 'LIKE', '%' . $time . '%')
            ->where('emp_code', $dni)
            ->get();
        //print_r($dato['get_id']);
        return view('rrhh.Asistencia.reporte.modal_editar', $dato);
    }
}
