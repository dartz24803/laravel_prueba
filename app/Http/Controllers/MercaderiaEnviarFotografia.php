<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Http\Controllers\Controller;
use App\Models\ArchivoSeguimientoCoordinador;
use App\Models\ArchivoSupervisionTienda;
use App\Models\Area;
use App\Models\AreaErrorPicking;
use App\Models\Articulos;
use App\Models\Base;
use App\Models\Capacitacion;
use App\Models\Consumible;
use App\Models\ConsumibleDetalle;
use App\Models\ContenidoSeguimientoCoordinador;
use App\Models\ContenidoSupervisionTienda;
use App\Models\DetalleSeguimientoCoordinador;
use App\Models\DetalleSupervisionTienda;
use App\Models\DiaSemana;
use App\Models\ErroresPicking;
use App\Models\ErrorPicking;
use App\Models\Gerencia;
use App\Models\Inventario;
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
use App\Models\RequerimientoPrendaDetalle;
use App\Models\SubGerencia;
use App\Models\TallaErrorPicking;
use App\Models\TipoErrorPicking;
use App\Models\UnidadLogistica;
use App\Models\User;
use App\Models\Usuario;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MercaderiaEnviarFotografia extends Controller
{

    public function index()
    {
        $list_subgerencia = SubGerencia::list_subgerencia(9);
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('logistica.mercaderia_fotografica.index', compact('list_notificacion', 'list_subgerencia'));
    }


    public function list_merc_foto(Request $request)
    {
        $anio = $request->input('anio');
        $mes = $request->input('mes');

        $dato = [
            'anio' => $anio,
            'mes' => $mes,
        ];
        // dd($dato);
        $list_requerimientos_prenda = RequerimientoPrendaDetalle::getListRequerimientoPrenda($dato);
        // Devuelve la vista con los datos requeridos
        return view('logistica.mercaderia_fotografica.lista', compact('list_requerimientos_prenda'));
    }




    public function create_merc_foto()
    {

        return view('logistica.mercaderia_fotografica.modal_registrar');
    }

    public function store_merc_foto(Request $request)
    {
        if ($this->session('usuario')->id_usuario) {
            $dato['anio'] = $request->input('anio');
            $dato['mes'] = $request->input('mes');

            $path = $_FILES["doc_mercaderia"]["tmp_name"];
            $id_usuario = substr($_SESSION['usuario'][0]['usuario_nombres'], 0, 1) . $_SESSION['usuario'][0]['usuario_apater'];

            $documento = IOFactory::load($path);
            $hojaDeProductos = $documento->getSheet(0);

            $numeroMayorDeFila = $hojaDeProductos->getHighestRow();
            $letraMayorDeColumna = $hojaDeProductos->getHighestColumn();
            $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

            // Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
            RequerimientoPrendaDetalle::delete_requerimiento_temporal();
            $total = 0;
            $error = 0;
            $encontrado = 0;
            $noencontrado = 0;
            for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                $dato['codigo'] = $hojaDeProductos->getCell('A' . $indiceFila)->getValue();
                $dato['usuario'] = $hojaDeProductos->getCell('B' . $indiceFila)->getValue();
                $dato['estilo'] = $hojaDeProductos->getCell('C' . $indiceFila)->getValue();
                $dato['descripcion'] = $hojaDeProductos->getCell('D' . $indiceFila)->getValue();
                $dato['color'] = $hojaDeProductos->getCell('E' . $indiceFila)->getValue();
                $dato['talla'] = $hojaDeProductos->getCell('F' . $indiceFila)->getValue();
                $dato['cantidad'] = $hojaDeProductos->getCell('G' . $indiceFila)->getValue();
                $dato['ubicacion'] = $hojaDeProductos->getCell('H' . $indiceFila)->getValue();
                $dato['observacion'] = $hojaDeProductos->getCell('I' . $indiceFila)->getValue();
                //echo $dato['codigo']."<br>";
                if (
                    substr($dato['codigo'], 0, 1) != "=" && $dato['codigo'] != "" &&
                    substr($dato['usuario'], 0, 1) != "=" && $dato['usuario'] != "" &&
                    substr($dato['estilo'], 0, 1) != "=" && $dato['estilo'] != "" &&
                    substr($dato['descripcion'], 0, 1) != "=" && $dato['descripcion'] != "" &&
                    substr($dato['color'], 0, 1) != "=" && $dato['color'] != "" &&
                    substr($dato['talla'], 0, 1) != "=" && $dato['talla'] != "" &&
                    substr($dato['cantidad'], 0, 1) != "=" && $dato['cantidad'] != ""
                ) {

                    $total++;
                    $existencia = RequerimientoPrendaDetalle::valida_mercaderia_fotografia($dato);
                    $dato['caracter'] = "";
                    if (count($existencia) > 0) {
                        $encontrado = $encontrado + 1;
                        $dato['duplicado'] = 1;
                        RequerimientoPrendaDetalle::insert_mercaderia_fotografia_temporal($dato);
                    } else {
                        $noencontrado = $noencontrado + 1;
                        $dato['duplicado'] = 0;
                        RequerimientoPrendaDetalle::insert_mercaderia_fotografia_temporal($dato);
                    }
                } else {
                    $total++;
                    $error = $error + 1;
                    if (
                        $dato['codigo'] == "" && $dato['usuario'] == "" && $dato['estilo'] == "" && $dato['descripcion'] == "" &&
                        $dato['color'] == "" && $dato['talla'] == "" && $dato['cantidad'] == ""
                    ) {
                        break;
                    } else {
                        if (
                            substr($dato['codigo'], 0, 1) == "=" || $dato['codigo'] == "" ||
                            substr($dato['usuario'], 0, 1) == "=" || $dato['usuario'] == "" ||
                            substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "" ||
                            substr($dato['descripcion'], 0, 1) == "=" || $dato['descripcion'] == "" ||
                            substr($dato['color'], 0, 1) == "=" || $dato['color'] == "" ||
                            substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "" ||
                            substr($dato['cantidad'], 0, 1) == "=" || $dato['cantidad'] == "" ||
                            substr($dato['ubicacion'], 0, 1) == "=" || $dato['ubicacion'] == ""
                        ) {
                            $columna = "";
                            if (substr($dato['codigo'], 0, 1) == "=" || $dato['codigo'] == "") {
                                $columna = $columna . "A,";
                            }
                            if (substr($dato['usuario'], 0, 1) == "=" || $dato['usuario'] == "") {
                                $columna = $columna . "B,";
                            }
                            if (substr($dato['estilo'], 0, 1) == "=" || $dato['estilo'] == "") {
                                $columna = $columna . "C,";
                            }
                            if (substr($dato['descripcion'], 0, 1) == "=" || $dato['descripcion'] == "") {
                                $columna = $columna . "D,";
                            }
                            if (substr($dato['color'], 0, 1) == "=" || $dato['color'] == "") {
                                $columna = $columna . "E,";
                            }
                            if (substr($dato['talla'], 0, 1) == "=" || $dato['talla'] == "") {
                                $columna = $columna . "F,";
                            }
                            if (substr($dato['cantidad'], 0, 1) == "=" || $dato['cantidad'] == "") {
                                $columna = $columna . "G,";
                            }
                            if (substr($dato['ubicacion'], 0, 1) == "=" || $dato['ubicacion'] == "") {
                                $columna = $columna . "H";
                            }
                            $dato['caracter'] = "Caracter no permitido, Fila " . $indiceFila . " Columna " . $columna;
                            $dato['duplicado'] = 0;
                            RequerimientoPrendaDetalle::insert_mercaderia_fotografia_temporal($dato);
                        }
                    }
                }
            }
            if ($error > 0) {
                echo "4<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='"  . "'>
                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                </a>";
            } else {

                $data = RequerimientoPrendaDetalle::get_list_mercaderia_fotografia();
                foreach ($data as $d) {
                    $dato['codigo'] = $d['codigo'];
                    //$dato['cantidad']=$d['stock'];
                    $dato['mes'] = $d['mes'];
                    $dato['anio'] = $d['anio'];
                    RequerimientoPrendaDetalle::update_mercaderia_fotografia($dato);
                }
                RequerimientoPrendaDetalle::insert_mercaderia_fotografia($dato);

                RequerimientoPrendaDetalle::delete_requerimiento_temporal();
                $list_correos = RequerimientoPrendaDetalle::correos_logistica_surtido();
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
                    $mail->setFrom('intranet@lanumero1.com.pe', 'NUEVO REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA');

                    //$mail->addAddress($_SESSION['usuario'][0]['emailp']);
                    foreach ($list_correos as $list) {
                        //$mail->addAddress('fhuertamendez2015@gmail.com');
                        $mail->addAddress($list['emailp']);
                    }

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "NUEVO REGISTRO DE REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA - LOGÍSTICA";

                    $mail->Body = "<h1><span style='color:#70BADB'>REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA</span></h1>
                                <p>¡Hola!</p>
                                <p>Se registró los requerimientos de prendas para fotografía.</p>
                                <p>Total de registros cargados: " . $total . ".</p>";

                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
                if ($error > 0) {
                    echo "1ERRORES: $error<br>TOTAL: $total";
                } else {
                    echo "2TOTAL: $total";
                };
            }
        } else {
            redirect('');
        }
    }



    public function enviar_oficina(Request $request)
    {
        if ($this->session('usuario')->id_usuario) {
            $dato['anio'] = $request->input('anio');
            $dato['mes'] = $request->input('mes');
            $dato['mod'] = 1;
            $data = RequerimientoPrendaDetalle::get_list_requerimiento_prenda($dato);
            $i = 0;
            foreach ($data as $d) {
                if ($d['estado_requerimiento'] == 2) {
                    $i++;
                    $dato['get_req'] = RequerimientoPrendaDetalle::get_id_requerimiento_prenda($d['codigo'], $dato['anio'], $dato['mes']);
                    $dato['get_mer'] = RequerimientoPrendaDetalle::get_id_mercaderia_fotografia($d['codigo'], $dato['anio'], $dato['mes']);
                    RequerimientoPrendaDetalle::enviar_oficina_requerimiento_prenda($dato);
                }
            }
            echo $i;
            //$this->Model_Logistica->delete_mercaderia_fotografia($dato);
        } else {
            redirect('');
        }
    }

    public function formato_mercaderia_fotografica()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Formato Mercadería a Envíar');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:I1');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", "Usuario");
        $sheet->setCellValue("C1", "Estilo");
        $sheet->setCellValue("D1", "Descripción");
        $sheet->setCellValue("E1", "Color");
        $sheet->setCellValue("F1", "Talla");
        $sheet->setCellValue("G1", "Cantidad");
        $sheet->setCellValue("H1", "Ubicación");
        $sheet->setCellValue("I1", "Observación");
        //$data = $this->Model_Logistica->get_list_duplicadoser($usuario, $semana);
        $fila = 2;
        $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", "89891911159");
        $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", "BEBA");
        $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", "GAZO-105");
        $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", "PANTALONETA ARRESTME ALG. COBERTURA BEBA");
        $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", "FUCSIA");
        $spreadsheet->getActiveSheet()->setCellValue("F{$fila}", "M");
        $spreadsheet->getActiveSheet()->setCellValue("G{$fila}", "1");
        $spreadsheet->getActiveSheet()->setCellValue("H{$fila}", "ALM TDA VIRTUAL");
        $spreadsheet->getActiveSheet()->setCellValue("I{$fila}", "Observación");
        //border
        $sheet->getStyle("A{$fila}:I{$fila}")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //$sheet->getStyle('A2:F100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(45);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(60);

        //final part
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Formato';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function requerimiento_surtido(Request $request)
    {
        $anio = $request->input('anio');
        $mes = $request->input('mes');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Requerimiento Surtido');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:I1');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:I1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Código');
        $sheet->setCellValue("B1", "Usuario");
        $sheet->setCellValue("C1", "Estilo");
        $sheet->setCellValue("D1", "Descripción");
        $sheet->setCellValue("E1", "Color");
        $sheet->setCellValue("F1", "Talla");
        $sheet->setCellValue("G1", "Cantidad Solicitada");
        $sheet->setCellValue("H1", "Ubicación");
        $sheet->setCellValue("I1", "Observación");
        //$data = $this->Model_Logistica->get_list_duplicadoser($usuario, $semana);
        $dato['anio'] = $anio;

        $dato['mes'] = $mes;
        // dd($dato['mes']);
        $dato['mod'] = 1;
        $data = RequerimientoPrendaDetalle::getListRequerimientoPrenda($dato);
        $fila = 1;
        // dd($data); // O var_dump($data) para ver la estructura

        foreach ($data as $d) {
            $fila = $fila + 1;
            // dd($fila);
            $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $d->codigo);
            $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $d->tipo_usuario);
            $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", $d->estilo);
            $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", $d->descripcion);
            $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $d->color);
            $spreadsheet->getActiveSheet()->setCellValue("F{$fila}", $d->talla);
            $spreadsheet->getActiveSheet()->setCellValue("G{$fila}", $d->cant_solicitado);
            $spreadsheet->getActiveSheet()->setCellValue("H{$fila}", $d->ubicacion);
            $spreadsheet->getActiveSheet()->setCellValue("I{$fila}", $d->obs_comercial);
            //border
            $sheet->getStyle("A{$fila}:I{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }


        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        //$sheet->getStyle('A2:F100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //Custom width for Individual Columns
        $sheet->getColumnDimension('A')->setWidth(16);
        $sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(45);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(60);
        // dd($spreadsheet);
        //final part
        $curdate = date('d-m-Y');
        $writer = new Xlsx($spreadsheet);
        $filename = 'Requerimiento_Surtido_' . date('Y-m-d') . '.xlsx';


        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function update_merc_foto(Request $request, $id)
    {
        // Validar los campos del formulario
        $request->validate([
            'areacon' => 'required',
            'colaborador' => 'required',

        ], [
            'areacon.required' => 'Debe ingresar el área.',
            'colaborador.required' => 'Debe ingresar el colaborador.',

        ]);

        // Actualizar el registro del consumible
        $consumible = Consumible::findOrFail($id);
        $consumible->update([
            'id_area' => $request->areacon,
            'id_usuario' => $request->colaborador,
            'observacion' => $request->observacion ?? '',
            'estado_consumible' => 1,
            'estado' => 1,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario,
        ]);
        // dd($request->all());
        // Eliminar los registros anteriores de consumible_detalle para este consumible
        ConsumibleDetalle::where('id_consumible', $consumible->id_consumible)->delete();
        $id_unidades = $request->input('id_unidad', []);
        $id_articulos = $request->input('id_articulo', []);
        $cantidades = $request->input('cantidad', []);
        // dd($id_unidades);
        foreach ($cantidades as $index => $cantidad) {
            ConsumibleDetalle::create([
                'id_consumible' => $consumible->id_consumible,
                'articulo' => $id_articulos[$index],
                'unidad' => $id_unidades[$index],
                'cantidad' => $cantidad,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
            ]);
        }

        return response()->json([
            'message' => 'Consumible actualizado correctamente',
        ]);
    }



    public function destroy_merc_foto($id)
    {
        Consumible::where('id_consumible', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
        ConsumibleDetalle::where('id_consumible', $id)->firstOrFail()->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
