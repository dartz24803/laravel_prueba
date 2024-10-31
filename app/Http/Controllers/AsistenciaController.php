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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $centro_labores = Session('usuario')->centro_labores;
        $cod_base = 0;
        $num_doc = 0;
        $list_base = $this->modelobase->select('cod_base')->where('estado', 1)->groupBy('cod_base')->orderBy('cod_base', 'ASC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161) {
            $cod_base = $centro_labores;
        } else {
            $cod_base = "OFC";
        }
        $estado = 1;
        $list_colaborador = $this->modelousuarios->get_list_usuarios_x_baset($cod_base, $area = null, $estado);
        $list_area = $this->modeloarea->where('estado', 1)->orderBy('nom_area', 'ASC')->get();
        $list_gerencia = $this->modelogerencia->get_list_gerencia();
        $list_mes = $this->modelomes->where('estado', 1)->get();
        $list_anio = $this->modeloanio->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        if ($id_puesto == 29 || $id_puesto == 98 || $id_puesto == 26 || $id_puesto == 16 || $id_puesto == 197 || $id_puesto == 161) {
            return view('rrhh.Asistencia.reporte.indexct', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        } else {
            return view('rrhh.Asistencia.reporte.index', compact('list_base', 'list_colaborador', 'list_area', 'list_gerencia', 'list_mes', 'list_anio', 'list_notificacion', 'list_subgerencia'));
        }
        /*
        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia('06','2024','OFC','76244986','1','2024-06-13','2024-06-13');
        print_r($list_asistencia);*/
    }

    public function Buscar_Reporte_Control_Asistencia(Request $request){
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
            $usuarios->where('estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            $usuarios->where('centro_labores', $cod_base);
        }
        if ($area != 0) {
            $usuarios->where('id_area', $area);
        }
        
        $query = $usuarios->toSql(); // Obtener la consulta SQL generada
        $bindings = $usuarios->getBindings(); // Obtener los bindings (valores)
        
        // echo "Consulta: $query\n";
        // print_r($bindings); // Imprimir los valores que se utilizan en la consulta
        
        $usuarios = $usuarios->get();
        // print_r($usuarios);        
        
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

        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia($cod_mes, $cod_anio, $cod_base, $num_doc, $tipo, $finicio, $ffin, $usuarios);
        // print_r($list_asistencia);
        if ($num_doc != 0) {
            $list_colaborador = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        } else {
            $list_colaborador = $this->modelo->get_list_usuarios_x_baset($cod_base, $area, $estado);
        }
        $n_documento = $num_doc;

        if ($id_puesto == 29 || $id_puesto == 161 || $id_puesto == 197) {
            return view('rrhh.Asistencia.reporte.listarct', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        } else {
            return view('rrhh.Asistencia.reporte.listar', compact('fecha_inicio', 'fecha_fin', 'list_asistencia', 'list_colaborador', 'n_documento'));
        }
    }
    
    public function Traer_Colaborador_Asistencia(Request $request){
            $dato['cod_base'] = $request->input('cod_base');
            $dato['id_area'] = $request->input('id_area');
            $dato['estado'] = $request->input('estado');
            $dato['list_colaborador'] = $this->modelousuarios->get_list_usuarios_x_baset($dato['cod_base'],$dato['id_area'],$dato['estado']);
            return view('rrhh.Asistencia.reporte.colaborador', $dato);
    }
    
    public function Excel_Reporte_Asistencia($cod_mes,$cod_anio,$cod_base,$num_doc,$area,$estado,$tipo,$finicio,$ffin){
        if($tipo==1){
            $year=$cod_anio;
            $dato['fecha_inicio']= strtotime("01-$cod_mes-$year");
            $L = new DateTime("$year-$cod_mes-01"); 
            $fecha_fin= $L->format( 'Y-m-t' );
            $timestamp = strtotime($fecha_fin); 
            $dato['fecha_fin'] = strtotime(date("d-m-Y", $timestamp ));
        }else{
            $dato['fecha_inicio'] = strtotime(date("d-m-Y", strtotime($finicio)));
            $dato['fecha_fin'] = strtotime(date("d-m-Y", strtotime($ffin)));
        }
        
        $usuarios = Usuario::select('usuario_codigo', 'id_usuario');

        if ($estado == 1 || $estado == 2) {
            $usuarios->where('estado', $estado);
        }
        if ($num_doc != 0) {
            $usuarios->where('usuario_codigo', $num_doc);
        }
        if ($cod_base != 0) {
            $usuarios->where('centro_labores', $cod_base);
        }
        if ($area != 0) {
            $usuarios->where('id_area', $area);
        }

        $usuarios = $usuarios->get();
        $list_asistencia = $this->modelo->buscar_reporte_control_asistencia($cod_mes,$cod_anio,$cod_base,$num_doc,$tipo,$finicio,$ffin,$usuarios);
        $get_mes = Mes::where('cod_mes', $cod_mes)
                ->get();
        
        if($num_doc!=0){
            $dato['list_colaborador'] = $this->modelo->get_list_usuario_xnum_doc($num_doc);
        }else{
            $dato['list_colaborador'] = $this->modelo->get_list_usuarios_x_baset($cod_base,$area,$estado);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Reporte Control Asistencia');
        if($tipo==1){

            $dato['n_documento']=$num_doc;
            $num=6;
            
            
            $prueba=$num_doc;
            if($tipo==1){
                $spreadsheet->getActiveSheet()->setCellValue("C1", $get_mes[0]['nom_mes'].' '.$year);
            }else{
                $spreadsheet->getActiveSheet()->setCellValue("C1", date("d/m/Y", strtotime($finicio)).' - '.date("d/m/Y", strtotime($ffin)));
            }
            
            $spreadsheet->getActiveSheet()->setCellValue("Q1", 'CONTROL DE ASISTENCIA');
            $spreadsheet->getActiveSheet()->setCellValue("B{$num}", 'N°');
            $spreadsheet->getActiveSheet()->setCellValue("C{$num}", 'APELLIDOS Y NOMBRES');
            
            $spreadsheet->getActiveSheet()->setCellValue("D3", 'ASITENCIA');
            $spreadsheet->getActiveSheet()->setCellValue("G3", '1');
            $spreadsheet->getActiveSheet()->setCellValue("J3", 'FALTAS');
            $spreadsheet->getActiveSheet()->setCellValue("L3", '0');
            $spreadsheet->getActiveSheet()->setCellValue("Q3", 'TARDANZAS');
            $spreadsheet->getActiveSheet()->setCellValue("T3", 'T');
            $spreadsheet->getActiveSheet()->setCellValue("Y3", 'FALTA JUSTIFICADA');
            $spreadsheet->getActiveSheet()->setCellValue("AC3", 'FJ');
            
            $sheet->getStyle("D3:AC3")->getFont()->setBold(true);
            
            for($i=$dato['fecha_inicio'],$j='D';$i<=$dato['fecha_fin'];$i+=86400,$j++){
            }
            $columna=$j;
            $spreadsheet->getActiveSheet()->mergeCells($columna.'5:'.$columna.'6');
            $sheet->getStyle($columna.'5:'.$columna.'6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle($columna.'5:'.$columna.'6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($columna.'5:'.$columna.'6')->getAlignment()->setWrapText(true);
            $sheet->getStyle($columna.'5:'.$columna.'6')->getFont()->setBold(true);
            $sheet->getStyle($columna.'5:'.$columna.'6')->getFont()->setSize(10);
            
            $fila=count($dato['list_colaborador'])+6;
            $spreadsheet->getActiveSheet()->setCellValue($columna."5", 'Asistencia (Puntual)');
            $allborder = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ];
            $sheet->getStyle('B5:'.$columna.$fila)->applyFromArray($allborder);
            
            //Le aplicamos color a la cabecera
            $spreadsheet->getActiveSheet()->getStyle("B5:".$columna."6")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('dce6f1');
            $styleArray = [
                'font' => [
                    'bold'  =>  true,
                    'size'  =>  16,
                    'color' => ['rgb' => '51b9d6']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]/*,
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]*/
            ];
            //$spreadsheet->getActiveSheet()->getStyle("C1:X1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('51b9d6');
            $sheet->getStyle('C1:X1')->applyFromArray($styleArray);

            
            //border
            $styleThinBlackBorderOutline = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ];
            //Font BOLD
            $sheet->getStyle("B5:AH{$num}")->getFont()->setBold(true);
            
            $p = $num;
            $d=0;
            for($i=$dato['fecha_inicio'],$j='D';$i<=$dato['fecha_fin'];$i+=86400,$j++){
                

                $fecha = date("d-m-Y",$i);
                $numeroDia = date('d', strtotime($fecha));
                $dia = date('l', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));
                $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                $spreadsheet->getActiveSheet()->setCellValue($j.(5), substr($nombredia, 0,1));
                $spreadsheet->getActiveSheet()->setCellValue($j.(6), $numeroDia);
                $sheet->getColumnDimension($j)->setWidth(5);
                $sheet->getStyle($j.(5))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($j.(6))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                $sheet->getStyle($j.(5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($j.(6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }

            $orden=$num+1;
            $numero=0;
            foreach($dato['list_colaborador'] as $list){
                $numero++;
                $spreadsheet->getActiveSheet()->setCellValue("B{$orden}", $numero);
                $spreadsheet->getActiveSheet()->setCellValue("C{$orden}", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                $asistencia=0;
                for($i=$dato['fecha_inicio'],$j='D';$i<=$dato['fecha_fin'];$i+=86400,$j++){
                    $fecha = date("d-m-Y",$i);
                    $numeroDia = date('d', strtotime($fecha));
                    $dia = date('l', strtotime($fecha));
                    $mes = date('F', strtotime($fecha));
                    $anio = date('Y', strtotime($fecha));
                    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                    //$spreadsheet->getActiveSheet()->setCellValue($j.(5), substr($nombredia, 0,1));
                    //$spreadsheet->getActiveSheet()->setCellValue($j.(6), $numeroDia);
                    $sheet->getColumnDimension($j)->setWidth(5);
                    $sheet->getStyle($j.(5))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle($j.(6))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    $sheet->getStyle($j.(5))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle($j.(6))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                    $busq_modulo = in_array($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    $posicion = array_search($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    //$cadenaConvert = str_replace(" ", "-", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                    
                    $fecha = date("d-m-Y",$i);
                    $numeroDia = date('d', strtotime($fecha));
                    $dia = date('l', strtotime($fecha));
                    $mes = date('F', strtotime($fecha));
                    $anio = date('Y', strtotime($fecha));
                    $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                    $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                    $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                    $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                    if ($busq_modulo == true) {
                        if($nombredia=="Sábado"){
                            if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['salidasabado']!=null){
                                $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "1");
                                $asistencia=$asistencia+1;
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                            }
                        }else{
                            if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['idescanso']!=null && 
                            $list_asistencia[$posicion]['fdescanso']!=null && $list_asistencia[$posicion]['salida']!=null || $nombredia=="Domingo"){
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){
                                    $asistencia=$asistencia+1;
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "1");
                                }else{
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                                }
                                /*if($fecha>=$list['fec_inicio']){
                                    $asistencia=$asistencia+1;
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "1");
                                }else{
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                                }*/
                                
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                            }
                            if($nombredia=="Domingo"){
                                $borderight = [
                                    'borders' => [
                                        'right' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['rgb' => 'FF0000']
                                        ]
                                    ]
                                ];
                                $sheet->getStyle($j.$orden)->applyFromArray($borderight);
                                
                            }
                        }
                    }else{
                        if($nombredia=="Sábado"){
                            $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                        }else{
                            if($nombredia=="Domingo"){
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){
                                    $asistencia=$asistencia+1;
                                    $borderight = [
                                        'borders' => [
                                            'right' => [
                                                'borderStyle' => Border::BORDER_THIN,
                                                'color' => ['rgb' => 'FF0000']
                                            ]
                                        ]
                                    ];
                                    $sheet->getStyle($j.$orden)->applyFromArray($borderight);
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "1");
                                }else{
                                    $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                                }
                                
                                    
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue($j.$orden, "0");
                            }
                            
                        }
                    }
                    $sheet->getStyle($j.$orden)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $spreadsheet->getActiveSheet()->setCellValue($columna.$orden, $asistencia);
                $sheet->getStyle($columna.$orden)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $orden++;
            }
            $sheet->getStyle("A{$num}:I{$num}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            //Custom width for Individual Columns
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(5);
            $sheet->getColumnDimension('C')->setWidth(40);
        }else{
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->getColumnDimension('B')->setWidth(8);
            $sheet->getColumnDimension('E')->setWidth(40);
            $sheet->getColumnDimension('F')->setWidth(40);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(20);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getStyle("B1:K1")->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->setCellValue("B1", '#');
            $spreadsheet->getActiveSheet()->setCellValue("C1", 'CENTRO LABORES');
            $spreadsheet->getActiveSheet()->setCellValue("D1", 'DNI');
            $spreadsheet->getActiveSheet()->setCellValue("E1", 'COLABORADOR');
            $spreadsheet->getActiveSheet()->setCellValue("F1", 'FECHA');
            $spreadsheet->getActiveSheet()->setCellValue("G1", 'INGRESO');
            $spreadsheet->getActiveSheet()->setCellValue("H1", 'INICIO DESCANSO');
            $spreadsheet->getActiveSheet()->setCellValue("I1", 'FIN DESCANSO');
            $spreadsheet->getActiveSheet()->setCellValue("J1", 'SALIDA');
            $spreadsheet->getActiveSheet()->setCellValue("K1", 'DIA LABORADO');
            $spreadsheet->getActiveSheet()->setAutoFilter("B1:K1");  
            $spreadsheet->getActiveSheet()->getStyle("B1:K1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('dce6f1');
            $styleArray = [
                'font' => [
                    'bold'  =>  true,
                    'size'  =>  12,
                    'color' => ['rgb' => '000000']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ]/*,
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]*/
            ];
            //$spreadsheet->getActiveSheet()->getStyle("C1:X1")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('51b9d6');
            $sheet->getStyle('B1:K1')->applyFromArray($styleArray);
            $allborder = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000']
                    ]
                ]
            ];
            $sheet->getStyle("B1:K1")->applyFromArray($allborder);
            $p=2;$d=0;$fila=0;
            for($i=$dato['fecha_inicio']; $i<=$dato['fecha_fin']; $i+=86400){$fila++;
                $no=$p;  $n=count($dato['list_colaborador']);
                foreach($dato['list_colaborador'] as $list){
                    $busq_modulo = in_array($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    $posicion = array_search($list['num_doc']."-".date("d-m-Y",$i), array_column($list_asistencia, 'validador'));
                    $cadenaConvert = str_replace(" ", "-", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                            $fecha = date("d-m-Y",$i);
                            $numeroDia = date('d', strtotime($fecha));
                            $dia = date('l', strtotime($fecha));
                            $mes = date('F', strtotime($fecha));
                            $anio = date('Y', strtotime($fecha));
                            $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
                            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
                            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
                            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
                    if ($busq_modulo == true) {
                        if($nombredia=="Sábado"){ 
                            $spreadsheet->getActiveSheet()->setCellValue("B{$no}", $no);
                            $spreadsheet->getActiveSheet()->setCellValue("C{$no}", $list['centro_labores']);
                            $spreadsheet->getActiveSheet()->setCellValue("D{$no}", $list['num_doc']);
                            $spreadsheet->getActiveSheet()->setCellValue("E{$no}", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                            $spreadsheet->getActiveSheet()->setCellValue("F{$no}", $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio);
                            if($list_asistencia[$posicion]['ingreso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['ingreso']);
                                $spreadsheet->getActiveSheet()->setCellValue("G{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['salidasabado']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['salidasabado']);
                                $spreadsheet->getActiveSheet()->setCellValue("J{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['salidasabado']!=null){ 
                                //if($n_documento!=0){$d=$d+1;}
                                $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "1"); 
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                            }
                           
                        }else{
                            $spreadsheet->getActiveSheet()->setCellValue("B{$no}", $no);
                            $spreadsheet->getActiveSheet()->setCellValue("C{$no}", $list['centro_labores']);
                            $spreadsheet->getActiveSheet()->setCellValue("D{$no}", $list['num_doc']);
                            $spreadsheet->getActiveSheet()->setCellValue("E{$no}", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                            $spreadsheet->getActiveSheet()->setCellValue("F{$no}", $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio);
                            if($list_asistencia[$posicion]['ingreso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['ingreso']);
                                $spreadsheet->getActiveSheet()->setCellValue("G{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['idescanso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['idescanso']);
                                $spreadsheet->getActiveSheet()->setCellValue("H{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['fdescanso']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['fdescanso']);
                                $spreadsheet->getActiveSheet()->setCellValue("I{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['salida']!=null){
                                $parte = explode("--", $list_asistencia[$posicion]['salida']);
                                $spreadsheet->getActiveSheet()->setCellValue("J{$no}", $parte[0]);
                            }
                            if($list_asistencia[$posicion]['ingreso']!=null && $list_asistencia[$posicion]['idescanso']!=null && 
                            $list_asistencia[$posicion]['fdescanso']!=null && $list_asistencia[$posicion]['salida']!=null || $nombredia=="Domingo"){ 
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){$d=$d+1;
                                    $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "1"); 
                                }else{
                                    $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                                }   
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                            }
                            
                        }
                    }else{
                        if($nombredia=="Sábado"){
                            $spreadsheet->getActiveSheet()->setCellValue("B{$no}", $no);
                            $spreadsheet->getActiveSheet()->setCellValue("C{$no}", $list['centro_labores']);
                            $spreadsheet->getActiveSheet()->setCellValue("D{$no}", $list['num_doc']);
                            $spreadsheet->getActiveSheet()->setCellValue("E{$no}", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                            $spreadsheet->getActiveSheet()->setCellValue("F{$no}", $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio);
                            $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                            }else{
                            $spreadsheet->getActiveSheet()->setCellValue("B{$no}", $no);
                            $spreadsheet->getActiveSheet()->setCellValue("C{$no}", $list['centro_labores']);
                            $spreadsheet->getActiveSheet()->setCellValue("D{$no}", $list['num_doc']);
                            $spreadsheet->getActiveSheet()->setCellValue("E{$no}", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                            $spreadsheet->getActiveSheet()->setCellValue("F{$no}", $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio);
                            
                            if($nombredia=="Domingo"){
                                if(date("Y-m-d",$i)>=$list['fec_inicio']){
                                    $d=$d+1; 
                                    $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "1");
                                }else{
                                    $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                                }  
                            }else{
                                $spreadsheet->getActiveSheet()->setCellValue("K{$no}", "0"); 
                            }
                        } 
                    }
                    $sheet->getStyle("B".$no.":K".$no)->applyFromArray($allborder);
                    $no=$no+1; $n=$n-1;
                    if($n==0){
                        $p=$no;
                    }
                }
            }
        }
        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Reporte Control Asistencia '.$curdate;
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
    }
}
