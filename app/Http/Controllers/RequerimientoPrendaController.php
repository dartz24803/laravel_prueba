<?php

namespace App\Http\Controllers;

use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\RequerimientoPrendaDetalle;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RequerimientoPrendaController extends Controller
{
    protected $input;
    protected $Model_Perfil;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Perfil = new Model_Perfil();
    }

    public function index() {
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            return view('comercial.Requerimiento_Prenda.index', $dato);
    }

    public function Busqueda_Requerimiento_Prenda(){
            $dato['anio']= $this->input->post("anio");
            $dato['mes']= $this->input->post("mes");
            $dato['mod']=1;
            $list_requerimiento = RequerimientoPrendaDetalle::getListRequerimientoPrenda($dato);
            $dato['list_requerimiento'] = json_decode(json_encode($list_requerimiento), true);
            return view('comercial.Requerimiento_Prenda.lista', $dato);
    }

    public function Modal_Requerimiento_Prenda(){
            $dato['list_mes'] = $this->Model_Perfil->get_list_mes();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            return view('comercial.Requerimiento_Prenda.modal_registrar', $dato);
    }

    public function Insert_Requerimiento_Prenda(){
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anio");
            $dato['mes']= $this->input->post("mes");

            $path = $_FILES["drequerimiento"]["tmp_name"];
            $id_usuario= substr($_SESSION['usuario'][0]['usuario_nombres'],0,1).$_SESSION['usuario'][0]['usuario_apater'];

            $documento = IOFactory::load($path);
            $hojaDeProductos = $documento->getSheet(0);

            $numeroMayorDeFila = $hojaDeProductos->getHighestRow();
            $letraMayorDeColumna = $hojaDeProductos->getHighestColumn();
            $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
            // Recorrer filas; comenzar en la fila 2 porque omitimos el encabezado
            $this->Model_Logistica->delete_requerimiento_temporal();
            $total=0;
            $error=0;
            $duplicados=0;
            for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                $dato['codigo_barra'] = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila);
                $dato['tipo_usuario'] = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila);
                $dato['estilo'] = $hojaDeProductos->getCellByColumnAndRow(3, $indiceFila);
                $dato['descripcion'] = $hojaDeProductos->getCellByColumnAndRow(4, $indiceFila);
                $dato['color'] = $hojaDeProductos->getCellByColumnAndRow(5, $indiceFila);
                $dato['talla'] = $hojaDeProductos->getCellByColumnAndRow(6, $indiceFila);
                $dato['OFC'] = $hojaDeProductos->getCellByColumnAndRow(7, $indiceFila);
                $dato['ubicacion'] = $hojaDeProductos->getCellByColumnAndRow(8, $indiceFila);
                $dato['observacion'] = $hojaDeProductos->getCellByColumnAndRow(9, $indiceFila);


                if (substr($dato['codigo_barra'], 0, 1)!="=" && $dato['codigo_barra']!="" &&
                    substr($dato['tipo_usuario'], 0, 1)!="=" && $dato['tipo_usuario']!="" &&
                    substr($dato['estilo'], 0, 1)!="=" && $dato['estilo']!="" &&
                    substr($dato['descripcion'], 0, 1)!="=" && $dato['descripcion']!="" &&
                    substr($dato['color'], 0, 1)!="=" && $dato['color']!="" &&
                    substr($dato['talla'], 0, 1)!="=" && $dato['talla']!="" &&
                    substr($dato['OFC'], 0, 1)!="=" && $dato['OFC']!="" &&
                    substr($dato['ubicacion'], 0, 1)!="=" && $dato['ubicacion']!=""){

                        $total=$total+1;
                        $list_duplicados=$this->Model_Logistica->get_list_requerimiento_duplicados($dato);
                        $list_duplicados_tempo=$this->Model_Logistica->get_list_duplicado_temporal($dato);

                        $dato['caracter']="";
                        if(count($list_duplicados)>0){
                            $duplicados=$duplicados+1;
                            $dato['duplicado']=1;
                            $dato['caracter']="Registro existente en sistema para el mes y año";
                            $this->Model_Logistica->insert_requerimiento_temporal($dato);
                        }elseif(count($list_duplicados_tempo)>0){
                            $duplicados=$duplicados+1;
                            $dato['duplicado']=1;
                            $dato['caracter']="Registro duplicado en el excel cargado";
                            $this->Model_Logistica->insert_requerimiento_temporal($dato);
                        }else{
                            $dato['duplicado']=0;
                            $this->Model_Logistica->insert_requerimiento_temporal($dato);
                        }
                }else{

                    $error=$error+1;
                    if($dato['codigo_barra']=="" && $dato['tipo_usuario']=="" && $dato['estilo']=="" && $dato['descripcion']=="" &&
                        $dato['color']=="" && $dato['talla']=="" && $dato['OFC']=="" && $dato['ubicacion']=="" && $dato['observacion']==""){
                        break;
                    }else{
                        $total=$total+1;
                                $columna="";
                                if(substr($dato['codigo_barra'], 0, 1)=="=" || $dato['codigo_barra']==""){
                                    $columna=$columna."A,";
                                }if(substr($dato['tipo_usuario'], 0, 1)=="=" || $dato['tipo_usuario']==""){
                                    $columna=$columna."B,";
                                }if(substr($dato['estilo'], 0, 1)=="=" || $dato['estilo']==""){
                                    $columna=$columna."C,";
                                }if(substr($dato['descripcion'], 0, 1)=="=" || $dato['descripcion']==""){
                                    $columna=$columna."D,";
                                }if(substr($dato['color'], 0, 1)=="=" || $dato['color']==""){
                                    $columna=$columna."E,";
                                }if(substr($dato['talla'], 0, 1)=="=" || $dato['talla']==""){
                                    $columna=$columna."F,";
                                }if(substr($dato['OFC'], 0, 1)=="=" || $dato['OFC']==""){
                                    $columna=$columna."G,";
                                }if(substr($dato['ubicacion'], 0, 1)=="=" || $dato['ubicacion']==""){
                                    $columna=$columna."H,";
                                }
                                $dato['caracter']="Caracter no permitido, Fila ".$indiceFila." Columna ".$columna;
                                $dato['duplicado']=0;
                                $this->Model_Logistica->insert_requerimiento_temporal($dato);

                    }
                }
            }
            if($duplicados>0 || $error>0){
                echo "4<a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='".site_url("Logistica/Excel_Requerimiento_Duplicado")."'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                    </a>";
            }else{

                $this->Model_Logistica->insert_requerimiento($dato);

                $this->Model_Logistica->delete_requerimiento_temporal();
                $list_correos=$this->Model_Logistica->correos_logistica_surtido();
                $mail = new PHPMailer(true);

                try {
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host       =  'mail.lanumero1.com.pe';
                    $mail->SMTPAuth   =  true;
                    $mail->Username   =  'intranet@lanumero1.com.pe';
                    $mail->Password   =  'lanumero1$1';
                    $mail->SMTPSecure =  'tls';
                    $mail->Puerto     =  587;
                    $mail->setFrom('intranet@lanumero1.com.pe','NUEVO REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA - COMERCIAL');

                    //$mail->addAddress($_SESSION['usuario'][0]['emailp']);
                    foreach($list_correos as $list){
                        //$mail->addAddress('fhuertamendez2015@gmail.com');
                        $mail->addAddress($list['emailp']);
                    }

                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = "NUEVO REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA";

                    $mail->Body = "<h1><span style='color:#70BADB'>REQUERIMIENTO DE PRENDAS PARA FOTOGRAFÍA</span></h1>
                                    <p>¡Hola!</p>
                                    <p>Se registró un nuevo requerimiento de prendas para fotografía.</p>
                                    <p>Total de registros nuevos: ".$total.".</p>";

                    $mail->CharSet = 'UTF-8';
                    $mail->send();

                }catch(Exception $e) {
                    echo "Hubo un error al enviar el correo: {$mail->ErrorInfo}";
                }
                if ($error>0){echo "1ERRORES: $error<br>TOTAL: $total";} else {echo "2TOTAL: $total";};
            }
        }
        else{
            redirect('');
        }
    }

    public function Excel_Requerimiento_Duplicado(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Registros Duplicados');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->setCellValue("A1", 'CÓDIGO');
        $sheet->setCellValue("B1", "USUARIO");
        $sheet->setCellValue("C1", "ESTILO");
        $sheet->setCellValue("D1", "DESCRIPCIÓN");
        $sheet->setCellValue("E1", "COLOR");
        $sheet->setCellValue("F1", "TALLA");
        $sheet->setCellValue("G1", "STOCK");
        $sheet->setCellValue("H1", "OBSERVACIÓN");
        $data = $this->Model_Logistica->get_list_requerimiento_duplicado_temporal();
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:H1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');
        $fila=1;
        foreach($data as $d){
            $fila = $fila+1;
            //echo $fila." ".$d['sfa_descrip']."<br>";
            $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $d['codigo']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $d['tipo_usuario']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", $d['estilo']);
            $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", $d['descripcion']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $d['color']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$fila}", $d['talla']);
            $spreadsheet->getActiveSheet()->setCellValue("G{$fila}", $d['stock']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$fila}", $d['observacion']);

            //border
            $sheet->getStyle("A{$fila}:H{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }

        $sheet->getStyle('A1:H1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//$sheet->getStyle('A2:F100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(14);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(100);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(6);
        $sheet->getColumnDimension('G')->setWidth(6);
        $sheet->getColumnDimension('H')->setWidth(40);
        //$sheet->getColumnDimension('I')->setWidth(40);


        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Duplicados';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Formato_Mercaderia_Fotografia(){
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
        $fila=2;
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
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Formato_Requerimiento_Prenda(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Formato Requerimiento Prenda');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle("A1:AM1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", "Costo");
        $sheet->setCellValue("C1", "PC");
        $sheet->setCellValue("D1", "PV");
        $sheet->setCellValue("E1", "PP");
        $sheet->setCellValue("F1", "PC B4");
        $sheet->setCellValue("G1", "PV B4");
        $sheet->setCellValue("H1", "PP B4");
        $sheet->setCellValue("I1", "Usuario");
        $sheet->setCellValue("J1", "Tipo de Prenda");
        $sheet->setCellValue("K1", "Código Barra");
        $sheet->setCellValue("L1", "Autogenerado");
        $sheet->setCellValue("M1", "Estilo");
        $sheet->setCellValue("N1", "Descripción");
        $sheet->setCellValue("O1", "Color");
        $sheet->setCellValue("P1", "Talla");
        $sheet->setCellValue("Q1", "Stock");
        $sheet->setCellValue("R1", "Total");
        $sheet->setCellValue("S1", "OBS");
        $sheet->setCellValue("T1", "B01");
        $sheet->setCellValue("U1", "B02");
        $sheet->setCellValue("V1", "B03");
        $sheet->setCellValue("W1", "B04");
        $sheet->setCellValue("X1", "B05");
        $sheet->setCellValue("Y1", "B06");
        $sheet->setCellValue("Z1", "B07");
        $sheet->setCellValue("AA1", "B08");
        $sheet->setCellValue("AB1", "B09");
        $sheet->setCellValue("AC1", "B10");
        $sheet->setCellValue("AD1", "B11");
        $sheet->setCellValue("AE1", "B12");
        $sheet->setCellValue("AF1", "B13");
        $sheet->setCellValue("AG1", "B14");
        $sheet->setCellValue("AH1", "B15");
        $sheet->setCellValue("AI1", "B16");
        $sheet->setCellValue("AJ1", "B17");
        $sheet->setCellValue("AK1", "B18");
        $sheet->setCellValue("AL1", "BEC");
        $sheet->setCellValue("AM1", "REQ");

        $fila=2;
        $spreadsheet->getActiveSheet()->setCellValue("I{$fila}", "BEBA");
        $spreadsheet->getActiveSheet()->setCellValue("J{$fila}", "PANTALONETA");
        $spreadsheet->getActiveSheet()->setCellValue("K{$fila}", "89891911157");
        $spreadsheet->getActiveSheet()->setCellValue("L{$fila}", "VVB031P00601326-9");
        $spreadsheet->getActiveSheet()->setCellValue("M{$fila}", "GAZO-215");
        $spreadsheet->getActiveSheet()->setCellValue("N{$fila}", "VESTIDO ARRESTME ALG. C/ESTAM. BEBA");
        $spreadsheet->getActiveSheet()->setCellValue("O{$fila}", "ENTE");
        $spreadsheet->getActiveSheet()->setCellValue("P{$fila}", "6-9 M");
        $spreadsheet->getActiveSheet()->setCellValue("Q{$fila}", "479");
        $spreadsheet->getActiveSheet()->setCellValue("R{$fila}", "5");
        $spreadsheet->getActiveSheet()->setCellValue("S{$fila}", "474");
        $spreadsheet->getActiveSheet()->setCellValue("T{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("U{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("V{$fila}", "5");
        $spreadsheet->getActiveSheet()->setCellValue("W{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("X{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("Y{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("Z{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AA{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AB{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AC{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AD{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AE{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AF{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AG{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AH{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AI{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AJ{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AK{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AL{$fila}", "0");
        $spreadsheet->getActiveSheet()->setCellValue("AM{$fila}", "R");

        //border
        $sheet->getStyle("A1:AM{$fila}")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle("A1:AM{$fila}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(8);
		$sheet->getColumnDimension('B')->setWidth(6);
		$sheet->getColumnDimension('C')->setWidth(3);
        $sheet->getColumnDimension('D')->setWidth(3);
        $sheet->getColumnDimension('E')->setWidth(3);
        $sheet->getColumnDimension('F')->setWidth(3);
        $sheet->getColumnDimension('G')->setWidth(3);
        $sheet->getColumnDimension('H')->setWidth(3);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(100);
        $sheet->getColumnDimension('R')->setWidth(5.8);
        $sheet->getColumnDimension('S')->setWidth(4.5);
        $sheet->getColumnDimension('T')->setWidth(4.5);
        $sheet->getColumnDimension('U')->setWidth(4.5);
        $sheet->getColumnDimension('V')->setWidth(4.5);
        $sheet->getColumnDimension('W')->setWidth(4.5);
        $sheet->getColumnDimension('X')->setWidth(4.5);
        $sheet->getColumnDimension('Y')->setWidth(4.5);
        $sheet->getColumnDimension('Z')->setWidth(4.5);
        $sheet->getColumnDimension('AA')->setWidth(4.5);
        $sheet->getColumnDimension('AB')->setWidth(4.5);
        $sheet->getColumnDimension('AC')->setWidth(4.5);
        $sheet->getColumnDimension('AD')->setWidth(4.5);
        $sheet->getColumnDimension('AE')->setWidth(4.5);
        $sheet->getColumnDimension('AF')->setWidth(4.5);
        $sheet->getColumnDimension('AG')->setWidth(4.5);
        $sheet->getColumnDimension('AH')->setWidth(4.5);
        $sheet->getColumnDimension('AI')->setWidth(4.5);
        $sheet->getColumnDimension('AJ')->setWidth(4.5);
        $sheet->getColumnDimension('AK')->setWidth(4.5);
        $sheet->getColumnDimension('AL')->setWidth(4.5);
        $sheet->getColumnDimension('AM')->setWidth(4.5);
        //$sheet->getColumnDimension('AN')->setWidth(4.5);


        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Formato';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Modal_Update_Requerimiento_Prenda($codigo,$anio,$mes) {
            $dato['get_id'] = RequerimientoPrendaDetalle::where('codigo', $codigo)
                        ->where('anio', $anio)
                        ->where('mes', $mes)
                        ->where('estado', 1)
                        ->get();

            return view('comercial.Requerimiento_Prenda.modal_editar', $dato);
    }

    public function Update_Requerimiento_Prenda() {
        $this->input->validate([
            'cantidad' => 'required'
        ], [
            'cantidad.required' => 'Cantidad: Campo obligatorio',
        ]);
            $dato['cantidad']= $this->input->post("cantidad");
            $dato['id_requerimientod']= $this->input->post("id_requerimientod");
            $id_usuario = session('usuario')->id_usuario;

            RequerimientoPrendaDetalle::where('id_requerimientod', $dato['id_requerimientod'])
                ->update([
                    'OFC' => $dato['cantidad'],
                    'user_act' => $id_usuario,
                    'fec_act' => now(),
                ]);
    }

    public function Delete_Requerimiento_Prenda() {
            $codigo= $this->input->post("codigo");
            $anio= $this->input->post("anio");
            $mes= $this->input->post("mes");
            $get_id = RequerimientoPrendaDetalle::where('codigo', $codigo)
                        ->where('anio', $anio)
                        ->where('mes', $mes)
                        ->where('estado', 1)
                        ->get();
            $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión
            print_r($get_id);

        RequerimientoPrendaDetalle::where('id_requerimientod', $get_id[0]->id_requerimientod)
            ->update([
                'estado' => 2,
                'user_eli' => $id_usuario,
                'fec_eli' => now(),
            ]);

    }

    public function Delete_Todo_Requerimiento_Prenda() {
        if ($this->session->userdata('usuario')) {
            $dato['anio']= $this->input->post("anio");
            $dato['mes']= $this->input->post("mes");
            $dato['mod']= 1;
            $data=$this->Model_Logistica->get_list_requerimiento_prenda($dato);
            $i=0;
            foreach($data as $d){
                if($d['estado_requerimiento']==1){
                    $i++;
                    $dato['get_id'] = $this->Model_Logistica->get_id_requerimiento_prenda($d['codigo'],$dato['anio'],$dato['mes']);
                    $this->Model_Logistica->delete_requerimiento_prenda($dato);
                }

            }
            echo $i;
            //$this->Model_Logistica->delete_todo_requerimiento_prenda($dato);
        }
        else{
            redirect('');
        }
    }
}
