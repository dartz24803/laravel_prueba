<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotografico;
use App\Models\Area;
use App\Models\Base;
use App\Models\CodigosReporteFotografico;
use App\Models\Notificacion;
use App\Models\ReporteFotograficoArchivoTemporal;
use App\Models\ReporteFotograficoAdm;
use App\Models\SubGerencia;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Intervention\Image\ImageManagerStatic as Image;

class ReporteFotograficoController extends Controller
{
    //variables a usar
    protected $request;
    protected $modelo;
    protected $modeloarea;
    protected $modelobase;
    protected $modelocodigos;
    protected $modeloarchivotmp;
    protected $modelorfa;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->middleware('verificar.sesion.usuario')->except(['validar_reporte_fotografico_dia_job']);;
        $this->request = $request;
        $this->modelo = new ReporteFotografico();
        $this->modeloarea = new Area();
        $this->modelocodigos = new CodigosReporteFotografico();
        $this->modeloarchivotmp = new ReporteFotograficoArchivoTemporal();
        $this->modelorfa = new ReporteFotograficoAdm();
    }

    public function index()
    {
        //enviar listas a la vista
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(2);
        return view('tienda.ReporteFotografico.index', compact('list_notificacion', 'list_subgerencia'));
    }

    public function Reporte_Fotografico(Request $request)
    {
        //retornar vista si esta logueado
        $list_bases = Base::get_list_bases_tienda();
        $today = date('Y-m-d');
        $list_categorias = $this->modelorfa->where('estado', 1)->get();
        return view('tienda.ReporteFotografico.tabla_rf.reportefotografico', compact('list_categorias', 'list_bases', 'today'));
    }

    public function Reporte_Fotografico_Listar(Request $request)
    {
        $base = $request->input("base");
        $categoria = $request->input("categoria");
        $fecha = $request->input("fecha");
        $list = $this->modelo->listar($base, $categoria, $fecha);
        return view('tienda.ReporteFotografico.tabla_rf.listar', compact('list'));
    }

    public function ModalRegistroReporteFotografico()
    {
        // Lógica para obtener los datos necesarios
        $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->delete();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.tabla_rf.modal_registrar', compact('list_codigos'));
    }

    public function ModalUpdatedReporteFotografico($id)
    {
        // Lógica para obtener los datos necesarios
        $get_id = $this->modelo->where('id', $id)->get();
        $list_codigos = $this->modelocodigos->listar();
        // Retorna la vista con los datos
        return view('tienda.ReporteFotografico.tabla_rf.modal_editar', compact('list_codigos', 'get_id'));
    }

    public function Previsualizacion_Captura2()
    {
        //contador de archivos temporales para validar si tomó foto o no
        //$data = $this->modeloarchivotmp->contador_archivos_rf();
        $data = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();

        //si esta vacío
        if ($data->isEmpty()) {
            $foto_key = "photo1";
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

            if ((!$con_id) || (!$lr)) {
                echo "No se pudo conectar al servidor FTP";
            } else {
                //ftp_delete($con_id, 'REPORTE_FOTOGRAFICO/temporal_rf_'.Session::get('usuario')->id. "_1" .'.jpg');
                $nombre_soli = "temporal_rf_" . Session('usuario')->id_usuario . "_1";
                $path = $_FILES[$foto_key]["name"];
                $source_file = $_FILES[$foto_key]['tmp_name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "REPORTE_FOTOGRAFICO/" . $nombre, $source_file, FTP_BINARY);

                if ($subio) {
                    $dato = [
                        'ruta' => $nombre,
                        'id_usuario' => Session('usuario')->id_usuario,
                    ];
                    $this->modeloarchivotmp->insert($dato);
                    $respuesta['error'] = "";
                } else {
                    echo "Error al subir la foto<br>";
                }
            }
            return response()->json($respuesta);
        } else {
            echo "error";
        }
    }

    public function obtenerImagenes()
    {
        //obtener imagenes por usuario
        $imagenes = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();
        $data = array();
        foreach ($imagenes as $imagen) {
            $data[] = array(
                'ruta' => $imagen['ruta'],
                'id' => $imagen['id']
            );
        }

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function Delete_Imagen_Temporal(Request $request)
    {
        $id = $request->input('id');
        $this->modeloarchivotmp->where('id', $id)->delete();
    }

    public function Registrar_Reporte_Fotografico(Request $request){
        $data = $this->modeloarchivotmp->where('id_usuario', Session('usuario')->id_usuario)->get();
        //print_r($data);

        //si hay foto procede a registrar
        if (!$data->isEmpty()) {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);

            if ((!$con_id) || (!$lr)) {
                echo "No se pudo conectar al servidor FTP";
            } else {
                //validacion de codigo, q vaya con datos
                $validator = Validator::make($request->all(), [
                    'codigo' => 'not_in:0'
                ], [
                    'codigo.not_in' => 'Codigo: Campo obligatorio',
                ]);
                //alerta de validacion
                if ($validator->fails()) {
                    $respuesta['error'] = $validator->errors()->all();
                } else {
                    $nombre_actual = "REPORTE_FOTOGRAFICO/" . $data[0]['ruta'];
                    $nuevo_nombre = "REPORTE_FOTOGRAFICO/Evidencia_" . date('Y-m-d H:i:s') . "_" . Session('usuario')->id_usuario . "_" . Session('usuario')->centro_labores . "_captura.jpg";
                    ftp_rename($con_id, $nombre_actual, $nuevo_nombre);
                    $nombre = basename($nuevo_nombre);
                    //llenar array con datos para bd
                    $dato['foto'] = $nombre;
                    $dato = [
                        'base' => Session('usuario')->centro_labores,
                        'foto' => $nombre,
                        'codigo' => $request->input("codigo"),
                        'estado' => '1',
                        'fec_reg' => now(),
                        'user_reg' => Session('usuario')->id_usuario,
                    ];
                    $this->modelo->insert($dato);
                    $respuesta['error'] = "";
                }
            }
        } else {
            $respuesta['error'][0] = "Debe tomar una fotografía";
        }
        return response()->json($respuesta);
    }

    public function Delete_Reporte_Fotografico(Request $request)
    {
        $id = $request->input('id');
        $respuesta = array();
        try {
            $dato = [
                'estado' => 2,
                'fec_eli' => now(),
                'user_eli' => session('usuario')->id_usuario,
            ];
            $this->modelo->where('id', $id)->update($dato);
            $respuesta['error'] = "";
        } catch (Exception $e) {
            $respuesta['error'] = $e->getMessage();
        }
        return response()->json($respuesta);
    }

    public function Update_Registro_Fotografico(Request $request)
    {
        //verificar sesión
        $id = $request->input('id');
        $respuesta = array();
        $validator = Validator::make($request->all(), [
            'codigo_e' => 'required'
        ], [
            'codigo_e.required' => 'Codigo: Campo obligatorio',
        ]);
        //verificar validacion de select
        if ($validator->fails()) {
            $respuesta['error'] = $validator->errors()->all();
        } else {
            try {
                $dato = [
                    'codigo' => $request->input('codigo_e'),
                    'fec_act' => now(),
                    'user_act' => Session('usuario')->id_usuario,
                ];
                //actualizar codigo
                $this->modelo->where('id', $id)->update($dato);
                $respuesta['error'] = "";
                $respuesta['ok'] = "Se Elimino Correctamente";
            } catch (Exception $e) {
                $respuesta['error'] = $e->getMessage();
            }
        }
        return response()->json($respuesta);
    }

    public function Imagenes_Reporte_Fotografico(Request $request)
    {
        $list_bases = Base::get_list_bases_tienda();
        $list_categorias = $this->modelorfa->where('estado', 1)->get();
        $today = date('Y-m-d');
        $base = $request->input("base");
        $area = $request->input("area");
        $codigo = $request->input("codigo");
        return view('tienda.ReporteFotografico.imagenes_rf.index',  compact('list_categorias', 'list_bases', 'today'));
    }

    public function Listar_Imagenes_Reporte_Fotografico(Request $request)
    {
        $base = $request->input("base");
        $categoria = $request->input("categoria");
        $fecha = $request->input("fecha");
        $list_rf = $this->modelo->listar($base, $categoria, $fecha);
        //print_r($list_rf[0]);
        return view('tienda.ReporteFotografico.imagenes_rf.listar',  compact('list_rf'));
    }

    public function Modal_Detalle_RF($id,$prev=null,$next=null)
    {
        $get_id = ReporteFotografico::leftJoin('codigos_reporte_fotografico_new', 'reporte_fotografico_new.codigo', '=', 'codigos_reporte_fotografico_new.id')
            ->select('reporte_fotografico_new.id', 'reporte_fotografico_new.foto', 'reporte_fotografico_new.base', 'reporte_fotografico_new.fec_reg', 'codigos_reporte_fotografico_new.descripcion')
            ->where('reporte_fotografico_new.id', $id)
            ->get();
        
        return view('tienda.ReporteFotografico.imagenes_rf.modal_detalle', compact('get_id','prev','next'));
    }
    
    public function Modal_Detalle_RF_S($id)
    {
        $get_id = ReporteFotografico::leftJoin('codigos_reporte_fotografico_new', 'reporte_fotografico_new.codigo', '=', 'codigos_reporte_fotografico_new.id')
            ->select('reporte_fotografico_new.id', 'reporte_fotografico_new.foto', 'reporte_fotografico_new.base', 'reporte_fotografico_new.fec_reg', 'codigos_reporte_fotografico_new.descripcion')
            ->where('reporte_fotografico_new.id', $id)
            ->get();
        
    }
    //cron ejecutandose a las 19:00 a las 13:00
    public function validar_reporte_fotografico_dia_job_old()
    {
        $sql = "SELECT
                    IFNULL(rfa.categoria, 'Sin categoría') AS categoria,
                    bases.base,
                    IFNULL(COUNT(rf.id), 0) AS num_fotos
                FROM
                    (SELECT DISTINCT base FROM reporte_fotografico_new WHERE base LIKE 'B%') AS bases
                CROSS JOIN
                    (SELECT * FROM reporte_fotografico_adm_new WHERE estado = 1) rfa
                LEFT JOIN
                    codigos_reporte_fotografico_new crf ON rfa.id = crf.tipo
                LEFT JOIN
                    reporte_fotografico_new rf ON crf.id = rf.codigo AND rf.estado = 1 AND DATE(rf.fec_reg) = CURDATE() AND bases.base = rf.base
                GROUP BY
                    rfa.categoria,
                    bases.base
                ORDER BY
                    bases.base ASC,
                    categoria ASC;";

        $results = DB::select($sql);

        // Ejecutar la consulta
        $sql3 = "SELECT * FROM reporte_fotografico_adm_new WHERE estado=1 ORDER BY categoria ASC;";
        $results3 = DB::select($sql3);

        // Verificar si hay resultados
        if (count($results) > 0) {
            $emailBody = '<p>A continuación se presenta el detalle de las bases hoy:</p>';
            $emailBody .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 40%;">';
            $emailBody .= '<thead>';
            $emailBody .= '<tr>';
            $emailBody .= '<th style="text-align: center;">BASE</th>';
            foreach ($results3 as $row) {
                $emailBody .= '<th style="text-align: center;">' . $row->categoria . '</th>';
            }
            $emailBody .= '<th style="text-align: center;">ESTADO</th>';
            $emailBody .= '</tr>';
            $emailBody .= '</thead>';
            $emailBody .= '<tbody>';
            $previousBase2 = "";
            $isComplete = "";
            $totalValues = "";
            $emailBody .= '<tr>';

            foreach ($results as $result) {
                // Inicializa la variable para determinar si la fila está completa o no
                if ($previousBase2 !== "" && $previousBase2 !== $result->base) {
                    // Determina si la fila es "Completo", "Incompleto" o "FALTA"
                    if ($totalValues == 0) {
                        $emailBody .= '<th style="text-align: center; color:#fa2b5c; font-weight: normal">Falta</th>';
                    } else {
                        $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($isComplete ? '#000000' : '#6376ff') . '">' . ($isComplete ? 'Completo' : 'Incompleto') . '</th>';
                    }
                    $emailBody .= '</tr>';
                }

                // Si la base es diferente a la anterior, comienza una nueva fila
                if ($previousBase2 !== $result->base) {
                    $isComplete = true; // Resetea la variable para la nueva fila
                    $totalValues = 0; // Contador de valores diferentes de 0
                    $emailBody .= '<tr>';
                    $emailBody .= '<th style="text-align: center; font-weight: normal">' . $result->base . '</th>';
                }

                // Procesa cada valor de la fila
                $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($result->num_fotos == 0 ? '#fa2b5c' : '#000000') . '">' . $result->num_fotos . '</th>';

                // Verifica si hay algún 0 en la fila y cuenta los valores diferentes de 0
                if ($result->num_fotos == 0) {
                    $isComplete = false;
                } else {
                    $totalValues++;
                }

                // Actualiza la base anterior
                $previousBase2 = $result->base;
            }

            // Cierra la última fila
            if ($totalValues == 0) {
                $emailBody .= '<th style="text-align: center; color:#fa2b5c; font-weight: normal">Falta</th>';
            } else {
                $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($isComplete ? '#000000' : '#6376ff') . '">' . ($isComplete ? 'Completo' : 'Incompleto') . '</th>';
            }
            $emailBody .= '</tr>';


            $emailBody .= '</tbody>';
            $emailBody .= '</table>';


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
                $mail->setFrom('somosuno@lanumero1.com.pe', 'Somos Uno');

                //$mail->addAddress("pcardenas@lanumero1.com.pe");
                $mail->addAddress("acanales@lanumero1.com.pe");
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress("dvilca@lanumero1.com.pe");
                $mail->addAddress("fclaverias@lanumero1.com.pe");
                $mail->addAddress("mponte@lanumero1.com.pe");

                $mail->isHTML(true);
                $mail->Subject = 'Reporte diario de bases';
                $mail->Body    = $emailBody;
                $mail->CharSet = 'UTF-8';

                $mail->send();
                echo 'Correo enviado correctamente.';
            } catch (Exception $e) {
                return response()->json(['error' => "Error al enviar el correo: {$mail->ErrorInfo}"], 500);
            }
        } else {
            return response()->json(['message' => 'No hay bases con 0 fotos hoy.']);
        }
    }

    public function validar_reporte_fotografico_dia_job()
    {
        $sql = "SELECT
                    IFNULL(rfa.categoria, 'Sin categoría') AS categoria,
                    bases.base,
                    IFNULL(COUNT(rf.id), 0) AS num_fotos
                FROM
                    (SELECT DISTINCT base FROM reporte_fotografico_new WHERE base LIKE 'B%' AND base <> 'B17') AS bases
                CROSS JOIN
                    (SELECT * FROM reporte_fotografico_adm_new WHERE estado = 1) rfa
                LEFT JOIN
                    codigos_reporte_fotografico_new crf ON rfa.id = crf.tipo
                LEFT JOIN
                    reporte_fotografico_new rf ON crf.id = rf.codigo AND rf.estado = 1 AND DATE(rf.fec_reg) = CURDATE() AND bases.base = rf.base
                GROUP BY
                    rfa.categoria,
                    bases.base
                ORDER BY
                    bases.base ASC,
                    categoria ASC;";

        $results = DB::select($sql);

        // Ejecutar la consulta
        $sql3 = "SELECT * FROM reporte_fotografico_adm_new WHERE estado=1 ORDER BY categoria ASC;";
        $results3 = DB::select($sql3);

        // Verificar si hay resultados
        if (count($results) > 0) {
            $emailBody = '<p>A continuación se presenta el detalle de las bases hoy:</p>';
            $emailBody .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse; width: 40%;">';
            $emailBody .= '<thead>';
            $emailBody .= '<tr>';
            $emailBody .= '<th style="text-align: center;">BASE</th>';
            foreach ($results3 as $row) {
                $emailBody .= '<th style="text-align: center;">' . $row->categoria . '</th>';
            }
            $emailBody .= '<th style="text-align: center;">ESTADO</th>';
            $emailBody .= '</tr>';
            $emailBody .= '</thead>';
            $emailBody .= '<tbody>';
            $previousBase2 = "";
            $isComplete = "";
            $totalValues = "";
            $emailBody .= '<tr>';

            foreach ($results as $result) {
                // Inicializa la variable para determinar si la fila está completa o no
                if ($previousBase2 !== "" && $previousBase2 !== $result->base) {
                    // Determina si la fila es "Completo", "Incompleto" o "FALTA"
                    if ($totalValues == 0) {
                        $emailBody .= '<th style="text-align: center; color:#fa2b5c; font-weight: normal">Falta</th>';
                    } else {
                        $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($isComplete ? '#000000' : '#6376ff') . '">' . ($isComplete ? 'Completo' : 'Incompleto') . '</th>';
                    }
                    $emailBody .= '</tr>';
                }

                // Si la base es diferente a la anterior, comienza una nueva fila
                if ($previousBase2 !== $result->base) {
                    $isComplete = true; // Resetea la variable para la nueva fila
                    $totalValues = 0; // Contador de valores diferentes de 0
                    $emailBody .= '<tr>';
                    $emailBody .= '<th style="text-align: center; font-weight: normal">' . $result->base . '</th>';
                }

                // Procesa cada valor de la fila
                $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($result->num_fotos == 0 ? '#fa2b5c' : '#000000') . '">' . $result->num_fotos . '</th>';

                // Verifica si hay algún 0 en la fila y cuenta los valores diferentes de 0
                if ($result->num_fotos == 0) {
                    $isComplete = false;
                } else {
                    $totalValues++;
                }

                // Actualiza la base anterior
                $previousBase2 = $result->base;
            }

            // Cierra la última fila
            if ($totalValues == 0) {
                $emailBody .= '<th style="text-align: center; color:#fa2b5c; font-weight: normal">Falta</th>';
            } else {
                $emailBody .= '<th style="text-align: center; font-weight: normal; color:' . ($isComplete ? '#000000' : '#6376ff') . '">' . ($isComplete ? 'Completo' : 'Incompleto') . '</th>';
            }
            $emailBody .= '</tr>';


            $emailBody .= '</tbody>';
            $emailBody .= '</table>';


            // Generar el Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(15);
            // Encabezados del Excel
            $sheet->setCellValue('A1', 'BASE');
            $column = 'B';
            foreach ($results3 as $row) {
                $sheet->setCellValue($column . '1', $row->categoria);
                $column++;
            }
            $sheet->setCellValue($column . '1', 'ESTADO');

            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            $sheet->getStyle('A1:M1')->getFont()->setBold(true);
            $sheet->setAutoFilter('A1:M1');

            $sheet->getStyle("A1:M15")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A1:M15")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A1:M15")->applyFromArray($styleThinBlackBorderOutline);
            // Llenar el Excel con los datos
            $rowNum = 2;
            $previousBase2 = "";
            $isComplete = "";
            $totalValues = "";
            $styleFalta = [
                'font' => [
                    'color' => ['argb' => 'FFFA2B5C'], // Rojo
                    'bold' => false,
                ],
            ];

            $styleCompleto = [
                'font' => [
                    'color' => ['argb' => 'FF000000'], // Negro
                    'bold' => false,
                ],
            ];

            $styleIncompleto = [
                'font' => [
                    'color' => ['argb' => 'FF6376FF'], // Azul
                    'bold' => false,
                ],
            ];

            $columnIndex = 2;
            foreach ($results as $result) {
                if ($previousBase2 !== "" && $previousBase2 !== $result->base) {
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
                    if ($totalValues == 0) {
                        $sheet->setCellValue($columnLetter . $rowNum, 'Falta');
                        $sheet->getStyle($columnLetter . $rowNum)->applyFromArray($styleFalta);
                    } else {
                        $sheet->setCellValue($columnLetter . $rowNum, $isComplete ? 'Completo' : 'Incompleto');
                        $sheet->getStyle($columnLetter . $rowNum)->applyFromArray($isComplete ? $styleCompleto : $styleIncompleto);
                    }
                    $rowNum++;
                }

                if ($previousBase2 !== $result->base) {
                    $isComplete = true;
                    $totalValues = 0;
                    $sheet->setCellValue('A' . $rowNum, $result->base);
                    $columnIndex = 2; // Empieza desde la segunda columna
                }

                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
                $sheet->setCellValue($columnLetter . $rowNum, $result->num_fotos);
                $cellAddress = $columnLetter . $rowNum;

                if ($result->num_fotos == 0) {
                    $sheet->setCellValue($cellAddress, $result->num_fotos);
                    $sheet->getStyle($cellAddress)->applyFromArray($styleFalta);
                } else {
                    $sheet->setCellValue($cellAddress, $result->num_fotos);
                    $sheet->getStyle($cellAddress)->applyFromArray($styleCompleto);
                }
                if ($result->num_fotos == 0) {
                    $isComplete = false;
                } else {
                    $totalValues++;
                }

                $previousBase2 = $result->base;
                $columnIndex++;
            }

            // Cierra la última fila
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex);
            if ($totalValues == 0) {
                $sheet->setCellValue($columnLetter . $rowNum, 'Falta');
                $sheet->getStyle($columnLetter . $rowNum)->applyFromArray($styleFalta);
            } else {
                $sheet->setCellValue($columnLetter . $rowNum, $isComplete ? 'Completo' : 'Incompleto');
                $sheet->getStyle($columnLetter . $rowNum)->applyFromArray($isComplete ? $styleCompleto : $styleIncompleto);
            }

            // Guardar el archivo Excel en el servidor
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Reporte_Fotografico_' . date('Ymd') . '.xlsx';
            $filePath = storage_path('app/public/' . $fileName);
            $writer->save($filePath);

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
                $mail->setFrom('somosuno@lanumero1.com.pe', 'Somos Uno');

                $mail->addAddress("pcardenas@lanumero1.com.pe");
                $mail->addAddress('ogutierrez@lanumero1.com.pe');
                $mail->addAddress("acanales@lanumero1.com.pe");
                $mail->addAddress("dvilca@lanumero1.com.pe");
                $mail->addAddress("fclaverias@lanumero1.com.pe");
                $mail->addAddress("mponte@lanumero1.com.pe");
                $mail->addAddress("AVALDIVIESO@LANUMERO1.COM.PE");

                $mail->addCC('base03@lanumero1.com.pe');
                $mail->addCC('base04@lanumero1.com.pe');
                $mail->addCC('base05@lanumero1.com.pe');
                $mail->addCC('base06@lanumero1.com.pe');
                $mail->addCC('base07@lanumero1.com.pe');
                $mail->addCC('base08@lanumero1.com.pe');
                $mail->addCC('base09@lanumero1.com.pe');
                $mail->addCC('base10@lanumero1.com.pe');
                $mail->addCC('base11@lanumero1.com.pe');
                $mail->addCC('base12@lanumero1.com.pe');
                $mail->addCC('base15@lanumero1.com.pe');
                $mail->addCC('base16@lanumero1.com.pe');
                $mail->addCC('base18@lanumero1.com.pe');
                $mail->addCC('base19@lanumero1.com.pe');

                $mail->isHTML(true);
                $mail->Subject = 'Reporte diario de bases';
                $mail->Body    = $emailBody;
                $mail->CharSet = 'UTF-8';
                $mail->addAttachment($filePath);

                $mail->send();
                echo 'Correo enviado correctamente.';
            } catch (Exception $e) {
                return response()->json(['error' => "Error al enviar el correo: {$mail->ErrorInfo}"], 500);
            }
        } else {
            return response()->json(['message' => 'No hay bases con 0 fotos hoy.']);
        }
    }

    public function Rotar_Imagen_RF(Request $request){
        set_time_limit(0);
        $ftp_server = "lanumerounocloud.com";
        $ftp_usuario = "intranet@lanumerounocloud.com";
        $ftp_pass = "Intranet2022@";
        
        // Conectar al servidor FTP
        $con_id = ftp_connect($ftp_server);
        $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
        ftp_pasv($con_id, true);

        if ((!$con_id) || (!$lr)) {
            return response()->json(['error' => "No se pudo conectar al servidor FTP"]);
        } 
        
        // Buscar la imagen en la base de datos
        $list = ReporteFotografico::where('id', $request->id)->first();
        
        if (!$list || !$list->foto) {
            return response()->json(['error' => "Imagen no encontrada"]);
        }

        // Ruta de la imagen original en el servidor FTP
        $ftp_ruta = "REPORTE_FOTOGRAFICO/".$list->foto;
        $local_ruta = storage_path('app/temp_image.jpg');

        // Descargar la imagen al servidor local temporalmente
        ftp_get($con_id, $local_ruta, $ftp_ruta, FTP_BINARY);
        // Rotar la imagen con Intervention Image
        $imagen = Image::make($local_ruta);
        $imagen->rotate(90); // Rota 90 grados, puedes ajustar este valor
        $imagen->save($local_ruta);

        // Subir la imagen rotada al FTP
        $upload = ftp_put($con_id, $ftp_ruta, $local_ruta, FTP_BINARY);

        // Eliminar el archivo local temporal
        unlink($local_ruta);

        // Cerrar la conexión FTP
        ftp_close($con_id);

        if ($upload) {
            return response()->json(['success' => "Imagen rotada y guardada correctamente"]);
        } else {
            return response()->json(['error' => "Error al guardar la imagen en el servidor FTP"]);
        }
    }
}
