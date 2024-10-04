<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlUbicacion;
use App\Models\Mercaderia;
use App\Models\Nicho;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ControlUbicacionesController extends Controller
{
    protected $input;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
    }

    public function index() {
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('logistica.Control_Ubicaciones.index', $dato);
    }

    public function Cargar_Control_Ubicacion($t) {
        $dato['list_estilo'] = Mercaderia::get_list_estilo_infosap($t);
            $dato['list_control'] = Mercaderia::get_list_control_ubicaciones();
            $dato['list_nicho'] = Mercaderia::get_list_nicho();
            return view('logistica.Control_Ubicaciones.lista', $dato);
    }

    public function Excel_Control_Ubicacion($t){
        $list_estilo = Mercaderia::get_list_estilo_infosap($t);
        $list_control = Mercaderia::get_list_control_ubicaciones();
        $list_nicho = Mercaderia::get_list_nicho();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Control de Ubicaciones');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:E1');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:E1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Fecha Actualización');
        $sheet->setCellValue("B1", "Estilo");
        $sheet->setCellValue("C1", "Percha");
        $sheet->setCellValue("D1", "Ubicación");
        $sheet->setCellValue("E1", "Stock");
        $fila=1;
        foreach($list_estilo as $list){
            $fila = $fila+1;
            $busqueda = in_array($list->art_estiloprd, array_column($list_control, 'estilo'));
            $posicion = array_search($list->art_estiloprd, array_column($list_control, 'estilo'));
            if ($busqueda!= false) {
                $ubicacion="";
                $percha="";
                if($list_control[$posicion]['id_nicho']!=""){
                    $control2=explode(",",$list_control[$posicion]['id_nicho']);
                    $contador=0;
                    while($contador<count($control2)){
                        $posicion_puesto=array_search($control2[$contador],array_column($list_nicho,'id_nicho'));
                        $ubicacion=$ubicacion.$list_nicho[$posicion_puesto]['nom_percha'].$list_nicho[$posicion_puesto]['numero'].",";
                        $percha=$percha.$list_nicho[$posicion_puesto]['nom_percha'].",";
                        $contador++;
                    }
                }
                $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $list_control[$posicion]['fecha']);
                $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $list_control[$posicion]['estilo']);
                $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", substr($percha,0,-1));
                $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", substr($ubicacion,0,-1));
                $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $list->stock);
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $list->art_estiloprd);
                $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $list->stock);
            }


            //border
            $sheet->getStyle("A{$fila}:E{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }

        $sheet->getStyle('A1:E1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		$sheet->getColumnDimension('A')->setWidth(16);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(15);

        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Control de Ubicaciones';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Modal_Carga_Masiva(){
            DB::table('control_ubicacion_temporal')->where('user_reg', session('usuario')->id_usuario)->delete();
            return view('logistica.Control_Ubicaciones.modal_carga');
    }

    public function Insert_Carga_Masiva(){
            $dato['doc_control']= $this->input->post("doc_control");

            $path = $_FILES["doc_control"]["tmp_name"];
            $list_estilo = Mercaderia::get_list_estilo_infosap('1');

            $documento = IOFactory::load($path);
            $hojaDeProductos = $documento->getSheet(0);

            $numeroMayorDeFila = $hojaDeProductos->getHighestRow();
            $letraMayorDeColumna = $hojaDeProductos->getHighestColumn();
            $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);
            //$this->Model_Logistica->elimina_pedido();
            $total=0;
            $error=0;
            $insertado=0;
            $noencontrado=0;
            for ($indiceFila = 2; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                $dato['estilo'] = $hojaDeProductos->getCellByColumnAndRow(1, $indiceFila)->getValue();
                $dato['ubicacion'] = $hojaDeProductos->getCellByColumnAndRow(2, $indiceFila)->getValue();
                $dato['ubicacion'] = str_replace(' ', '', $dato['ubicacion']);



                if (substr($dato['estilo'], 0, 1)!="=" && $dato['estilo']!="" && substr($dato['ubicacion'], 0, 1)!="=" && $dato['ubicacion']!=""){
                        $total++;

                        $busqueda = in_array($dato['estilo'], array_column($list_estilo, 'art_estiloprd'));
                        $posicion = array_search($dato['estilo'], array_column($list_estilo, 'art_estiloprd'));
                        if ($busqueda!= false) {
                            $get_control = ControlUbicacion::where('estilo', $dato['estilo'])
                                        ->where('estado',1)
                                        ->get();
                            if(count($get_control)>0){
                                $list_ubicacion=explode(",", $dato['ubicacion']);
                                $actualizar=1;

                                //echo "Actualizar";
                                $nuevo_nicho="";
                                foreach($list_ubicacion as $b){
                                    $nicho = Mercaderia::get_list_nicho($id_percha=null);
                                    $busqueda = in_array($b, array_column($nicho, 'nicho'));
                                    $posicion = array_search($b, array_column($nicho, 'nicho'));
                                    if ($busqueda!= false) {
                                        $nuevo_nicho=$nuevo_nicho.$nicho[$posicion]['id_nicho'].",";
                                    }
                                }
                                $dato['id_nicho']=substr($nuevo_nicho, 0, -1);

                                $anio=date('Y');
                                $totalRows_t = ControlUbicacion::whereYear('fec_reg', $anio)->get();
                                $aniof=substr($anio, 2,2);
                                if($totalRows_t<9){
                                    $codigofinal="CU".$aniof."0000".($totalRows_t+1);
                                }
                                if($totalRows_t>8 && $totalRows_t<99){
                                        $codigofinal="CU".$aniof."000".($totalRows_t+1);
                                }
                                if($totalRows_t>98 && $totalRows_t<999){
                                    $codigofinal="CU".$aniof."00".($totalRows_t+1);
                                }
                                if($totalRows_t>998 && $totalRows_t<9999){
                                    $codigofinal="CU".$aniof."0".($totalRows_t+1);
                                }
                                if($totalRows_t>9998)
                                {
                                    $codigofinal="CU".$aniof.($totalRows_t+1);
                                }
                                $dato['cod_control']=$codigofinal;

                                    $fecha = now()->toDateString(); // Obtener la fecha actual en formato Y-m-d
                                    $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión

                                    // 1. Actualizar registros
                                    ControlUbicacion::where('estilo', $dato['estilo'])
                                        ->where('estado', 1)
                                        ->update([
                                            'estado' => 2,
                                            'user_act' => $id_usuario,
                                            'fec_act' => now(),
                                        ]);

                                    // 2. Insertar un nuevo registro
                                    ControlUbicacion::create([
                                        'cod_control' => $dato['cod_control'],
                                        'id_nicho' => $dato['id_nicho'],
                                        'estilo' => $dato['estilo'],
                                        'fecha' => $fecha,
                                        'estado' => 1,
                                        'fec_reg' => now(),
                                        'user_reg' => $id_usuario,
                                    ]);
                                $insertado++;
                            }else{
                                $dato['mod']=1;
                                $list_ubicacion=explode(",", $dato['ubicacion']);
                                $nuevo_nicho="";
                                foreach($list_ubicacion as $b){
                                    $nicho = Mercaderia::get_list_nicho($id_percha=null);
                                    $busqueda = in_array($b, array_column($nicho, 'nicho'));
                                    $posicion = array_search($b, array_column($nicho, 'nicho'));
                                    if($busqueda!= false) {
                                        $nuevo_nicho=$nuevo_nicho.$nicho[$posicion]['id_nicho'].",";
                                    }
                                }
                                $dato['id_nicho']=substr($nuevo_nicho, 0, -1);
                                $valida = ControlUbicacion::where('id_nicho', $dato['id_nicho'])
                                    ->where('estilo', $dato['estilo'])
                                    ->where('estado', 1)
                                    ->count();
                                if($valida<1){
                                    $anio=date('Y');
                                    $totalRows_t = ControlUbicacion::whereYear('fec_reg', $anio)->count();
                                    $aniof=substr($anio, 2,2);
                                    if($totalRows_t<9){
                                        $codigofinal="CU".$aniof."0000".($totalRows_t+1);
                                    }
                                    if($totalRows_t>8 && $totalRows_t<99){
                                            $codigofinal="CU".$aniof."000".($totalRows_t+1);
                                    }
                                    if($totalRows_t>98 && $totalRows_t<999){
                                        $codigofinal="CU".$aniof."00".($totalRows_t+1);
                                    }
                                    if($totalRows_t>998 && $totalRows_t<9999){
                                        $codigofinal="CU".$aniof."0".($totalRows_t+1);
                                    }
                                    if($totalRows_t>9998)
                                    {
                                        $codigofinal="CU".$aniof.($totalRows_t+1);
                                    }
                                    $dato['cod_control']=$codigofinal;
                                    $fecha = now()->toDateString(); // Obtener la fecha actual en formato Y-m-d
                                    $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión

                                    // Inserción utilizando Eloquent
                                    ControlUbicacion::create([
                                        'cod_control' => $dato['cod_control'],
                                        'id_nicho' => $dato['id_nicho'],
                                        'estilo' => $dato['estilo'],
                                        'fecha' => $fecha,
                                        'estado' => 1,
                                        'fec_reg' => now(), // Fecha de registro actual
                                        'user_reg' => $id_usuario, // Usuario que registra
                                    ]);
                                    $insertado++;
                                }
                            }
                        }else{
                            $noencontrado++;
                            $dato['caracter']="Estilo no encontrado, Fila ".$indiceFila;
                            $fecha = now()->toDateString(); // Obtener la fecha actual en formato Y-m-d
                            $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión

                            // Inserción utilizando Eloquent
                            ControlUbicacion::create([
                                'cod_control' => $dato['cod_control'],
                                'id_nicho' => $dato['id_nicho'],
                                'estilo' => $dato['estilo'],
                                'fecha' => $fecha,
                                'estado' => 1,
                                'fec_reg' => now(), // Fecha de registro actual
                                'user_reg' => $id_usuario, // Usuario que registra
                            ]);
                        }
                }else{
                    $error++;
                    if (substr($dato['estilo'], 0, 1)=="=" || $dato['estilo']=="" || substr($dato['ubicacion'], 0, 1)=="=" || $dato['ubicacion']==""){
                        $total++;
                        $columna="";
                        if(substr($dato['estilo'], 0, 1)=="=" || $dato['estilo']==""){
                            $columna=$columna."A";
                        }if(substr($dato['ubicacion'], 0, 1)=="=" || $dato['ubicacion']==""){
                            $columna=$columna."B";
                        }
                        $dato['caracter']="Caracter no permitido, Fila ".$indiceFila." Columna ".$columna;
                        $fecha = now()->toDateString(); // Obtener la fecha actual en formato Y-m-d
                        $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión

                        // Inserción utilizando Eloquent
                        ControlUbicacion::create([
                            'cod_control' => $dato['cod_control'],
                            'id_nicho' => $dato['id_nicho'],
                            'estilo' => $dato['estilo'],
                            'fecha' => $fecha,
                            'estado' => 1,
                            'fec_reg' => now(), // Fecha de registro actual
                            'user_reg' => $id_usuario, // Usuario que registra
                        ]);
                    }
                }
            }


            if ($error>0){
                echo "1ERRORES: $error<br>TOTAL ACTUALIZADOS:".$insertado."<br>TOTAL: $total<br><a class='btn mb-2 mr-2' style='background-color: #28a745 !important;' href='". url("ControlUbicaciones/Excel_Control_Ubicacion_Error")."'>
                    <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'><g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'><path d='M0,172v-172h172v172z' fill='none'></path><g fill='#ffffff'><path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path></g></g></svg>
                </a>";
            } else {
                echo "2TOTAL ACTUALIZADOS:".$insertado."<br>TOTAL: $total";
            };


    }

    public function Excel_Control_Ubicacion_Error(){
        $list_control = DB::table('control_ubicacion_temporal')->where('user_reg', session('usuario')->id_usuario)
                    ->where('estado', 1)
                    ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Error de Carga-Ctrl Ubicaciones');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:C1');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:C1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Estilo');
        $sheet->setCellValue("B1", "Ubicación");
        $sheet->setCellValue("C1", "Observación");
        $fila=1;
        foreach($list_control as $list){
            $fila = $fila+1;
            $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $list['estilo']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $list['ubicacion']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", $list['caracter']);


            //border
            $sheet->getStyle("A{$fila}:C{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }

        $sheet->getStyle('A1:C1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(16);
		$sheet->getColumnDimension('B')->setWidth(16);
		$sheet->getColumnDimension('C')->setWidth(30);

        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Control de Ubicaciones - Error de Carga';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Formato_Carga_Ubicacion(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Formato Control de Ubicaciones');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->setAutoFilter('A1:B1');
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle("A1:B1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F29D64');

        $sheet->setCellValue("A1", 'Estilo');
        $sheet->setCellValue("B1", "Ubicación");


        $sheet->getStyle('A1:B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(16);
		$sheet->getColumnDimension('B')->setWidth(30);

        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Formato Control de Ubicaciones';
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Modal_Control_Ubicaciones(){
            $dato['list_nicho'] = Mercaderia::get_list_nicho();
            $dato['list_estilo'] = Mercaderia::get_list_estilo_infosap('1');
            return view('logistica.Control_Ubicaciones.modal_registrar', $dato);
    }

    public function Insert_Control_Ubicaciones(){
        $this->input->validate([
            'id_nicho' => 'required',
            'estilo' => 'not_in:0',
        ], [
            'estilo' => 'Debe escoger estilo.',
            'id_nicho' =>  'Debe escoger nicho',
        ]);
            $dato['estilo']=$this->input->post("estilo");
            $dato['mod']=1;

            $dato['id_nicho']= implode(",",$this->input->post("id_nicho"));

            $valida = ControlUbicacion::where('id_nicho', $dato['id_nicho'])
                ->where('estilo', $dato['estilo'])
                ->where('estado', 1)
                ->count();
            if($valida>0){
                echo "error";
            }else{
                $anio=date('Y');
                $totalRows_t = ControlUbicacion::whereYear('fec_reg', $anio)->count();
                $aniof=substr($anio, 2,2);
                if($totalRows_t<9){
                    $codigofinal="CU".$aniof."0000".($totalRows_t+1);
                }
                if($totalRows_t>8 && $totalRows_t<99){
                        $codigofinal="CU".$aniof."000".($totalRows_t+1);
                }
                if($totalRows_t>98 && $totalRows_t<999){
                    $codigofinal="CU".$aniof."00".($totalRows_t+1);
                }
                if($totalRows_t>998 && $totalRows_t<9999){
                    $codigofinal="CU".$aniof."0".($totalRows_t+1);
                }
                if($totalRows_t>9998)
                {
                    $codigofinal="CU".$aniof.($totalRows_t+1);
                }
                $dato['cod_control']=$codigofinal;
                $fecha = now()->toDateString(); // Obtener la fecha actual en formato Y-m-d
                $id_usuario = session('usuario')->id_usuario; // Obtener el id del usuario desde la sesión

                // Inserción utilizando Eloquent
                ControlUbicacion::create([
                    'cod_control' => $dato['cod_control'],
                    'id_nicho' => $dato['id_nicho'],
                    'estilo' => $dato['estilo'],
                    'fecha' => $fecha,
                    'estado' => 1,
                    'fec_reg' => now(), // Fecha de registro actual
                    'user_reg' => $id_usuario, // Usuario que registra
                ]);
            }
    }

    public function Modal_Update_Control_Ubicaciones($id_control_ubicacion){
            $dato['get_id'] = ControlUbicacion::where('id_control_ubicacion', $id_control_ubicacion)->get();
            $dato['list_nicho'] = Mercaderia::get_list_nicho();
            $dato['list_estilo'] = Mercaderia::get_list_estilo_infosap('1');
            return view('logistica/Control_Ubicaciones/modal_editar', $dato);
    }

    public function Update_Control_Ubicaciones(){
        $this->input->validate([
            'estiloe' => 'not_in:0',
            'id_nichoe' => 'required',
        ], [
            'estiloe' => 'Debe escoger estilo.',
            'id_nichoe' =>  'Debe escoger nicho',
        ]);

            $dato['id_control_ubicacion']=$this->input->post("id_control_ubicacion");
            $dato['estilo']=$this->input->post("estiloe");
            $dato['mod']=2;
            $dato['id_nicho']= implode(",",$this->input->post("id_nichoe"));

            $valida = ControlUbicacion::where('id_nicho', $dato['id_nicho'])
                ->where('estilo', $dato['estilo'])
                ->where('id_control_ubicacion', '!=', $dato['id_control_ubicacion'])
                ->where('estado', 1)
                ->count();
            if($valida>0){
                echo "error";
            }else{
                // Encuentra el registro y actualízalo
                ControlUbicacion::where('id_control_ubicacion', $dato['id_control_ubicacion'])
                    ->update([
                        'id_nicho' => $dato['id_nicho'],
                        'fecha' => now(),
                        'estilo' => $dato['estilo'],
                        'user_act' => session('usuario')->id_usuario,
                        'fec_act' => now(), // Establece la fecha actual
                    ]);
            }
    }


    public function Delete_Control_Ubicacion(){
        $dato['estado'] = 2;
        $dato['fec_eli'] = now();
        $dato['user_eli'] = session('usuario')->id_usuario;
        ControlUbicacion::where('id_control_ubicacion', $this->input->post("id_control_ubicacion"))->update($dato);
    }
}
