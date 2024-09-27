<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\ChequesLetras;
use App\Models\ChequesLetrasTemporal;
use App\Models\Empresas;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TipoComprobante;
use App\Models\TipoMoneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RegistroLetraController extends Controller
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
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get();
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->orderby('cod_anio','DESC')->get();
        return view('finanzas.tesoreria.registro_letra.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_empresa',
            'list_aceptante',
            'list_mes',
            'list_anio'
        ));
    }

    public function list(Request $request)
    {
        $list_cheque_letra = ChequesLetras::get_list_cheques_letra([
            'estado'=>$request->estado,
            'id_empresa'=>$request->id_empresa,
            'id_aceptante'=>$request->id_aceptante,
            'tipo_fecha'=>$request->tipo_fecha,
            'mes'=>$request->mes,
            'anio'=>$request->anio
        ]);
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("clp_razsoc AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();
        return view('finanzas.tesoreria.registro_letra.lista', compact(
            'list_cheque_letra',
            'list_aceptante'
        ));
    }

    public function create()
    {
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get();
        $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,4])->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.registro_letra.modal_registrar',compact(
            'list_empresa',
            'list_aceptante',
            'list_tipo_comprobante',
            'list_tipo_moneda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'gt:0',
            'fec_emision' => 'required',
            'fec_vencimiento' => 'required',
            'id_tipo_documento' => 'gt:0',
            'num_doc' => 'required',
            'id_aceptante' => 'not_in:0',
            'id_tipo_comprobante' => 'gt:0',
            'num_comprobante' => 'required',
            'monto' => 'required|gt:0'
        ],[
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'fec_emision.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimiento.required' => 'Debe ingresar fecha vencimiento.',
            'id_tipo_documento.gt' => 'Debe seleccionar tipo documento.',
            'num_doc.required' => 'Debe ingresar n° documento.',
            'id_aceptante.not_in' => 'Debe seleccionar aceptante.',
            'id_tipo_comprobante.gt' => 'Debe seleccionar tipo comprobante.',
            'num_comprobante.required' => 'Debe ingresar n° comprobante.',
            'monto.required' => 'Debe ingresar monto.',
            'monto.gt' => 'Debe ingresar monto mayor a 0.'
        ]);

        $valida = ChequesLetras::where('id_empresa', $request->id_empresa)
                ->where('fec_vencimiento',$request->fec_vencimiento)->where('num_doc',$request->num_doc)
                ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            $aceptante = explode("_",$request->id_aceptante);
            $tipo_doc_empresa_vinculada = NULL;
            $num_doc_empresa_vinculada = NULL;
            if($request->negociado_endosado=="2"){
                $empresa_vinculada = explode("_",$request->id_empresa_vinculada);
                $tipo_doc_empresa_vinculada = $empresa_vinculada[0];
                $num_doc_empresa_vinculada = $empresa_vinculada[1];
            }

            $documento = "";
            if ($_FILES["documento"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["documento"]["name"];
                    $source_file = $_FILES['documento']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Cheque_Letra_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $documento = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            ChequesLetras::create([
                'id_empresa' => $request->id_empresa,
                'fec_emision' => $request->fec_emision,
                'fec_vencimiento' => $request->fec_vencimiento,
                'id_tipo_documento' => $request->id_tipo_documento,
                'num_doc' => $request->num_doc,
                'tipo_doc_aceptante' => $aceptante[0],
                'num_doc_aceptante' => $aceptante[1],
                'tipo_doc_emp_vinculada' => $tipo_doc_empresa_vinculada,
                'num_doc_emp_vinculada' => $num_doc_empresa_vinculada,
                'id_tipo_comprobante' => $request->id_tipo_comprobante,
                'num_comprobante' => $request->num_comprobante,
                'id_moneda' => $request->id_moneda,
                'monto' => $request->monto,
                'negociado_endosado' => $request->negociado_endosado,
                'documento' => $documento,
                'estado_registro' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function import()
    {
        return view('finanzas.tesoreria.registro_letra.modal_importar');
    }

    public function excel_plantilla(){ 
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Formato Letras-Cobrar');

        $sheet->getColumnDimension('A')->setWidth(13);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getColumnDimension('C')->setWidth(11);
        $sheet->getColumnDimension('D')->setWidth(16);
        $sheet->getColumnDimension('E')->setWidth(11);
        $sheet->getColumnDimension('F')->setWidth(11);
        $sheet->getColumnDimension('G')->setWidth(13);
        $sheet->getColumnDimension('H')->setWidth(13);
        $sheet->getColumnDimension('I')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(16);
        $sheet->getColumnDimension('L')->setWidth(11);
        $sheet->getColumnDimension('M')->setWidth(16);

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setARGB('000000');

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFont()->getColor()->setARGB(Color::COLOR_WHITE);

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("A1:M2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle('A1:M1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle("A1:M2")->getFont()->setSize(9);

        $sheet->setCellValue('A1', 'RUC EMPRESA');
        $sheet->setCellValue('B1', 'EMPRESA');
        $sheet->setCellValue('C1', 'F.EMISIÓN');
        $sheet->setCellValue('D1', 'F.VENCIMIENTO');
        $sheet->setCellValue('E1', 'TIPO DOC Cheque (C) Letra (L)');
        $sheet->setCellValue('F1', 'N° LETRA');
        $sheet->setCellValue('G1', 'TIPO DOC ACEPTANTE (DNI/RUC)');
        $sheet->setCellValue('H1', 'NUM DOC ACEPTANTE');
        $sheet->setCellValue('I1', 'ACEPTANTE');
        $sheet->setCellValue('J1', 'T.COMPROBANTE Factura (F), Boleta (B), Recibo (R)');
        $sheet->setCellValue('K1', 'N.COMPROBANTE');
        $sheet->setCellValue('L1', 'T.MONEDA Soles (S) Dolares (D)');
        $sheet->setCellValue('M1', 'IMPORTE');

        $sheet->getStyle("B2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("I2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("M2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("M2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

        $sheet->setCellValue("A2", "20730598421");
        $sheet->setCellValue("B2", "empresa x");
        $sheet->setCellValue("C2", Date::PHPToExcel("03/08/2023"));
        $sheet->getStyle("C2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("D2", Date::PHPToExcel("02/10/2023"));
        $sheet->getStyle("D2")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
        $sheet->setCellValue("E2", "C");
        $sheet->setCellValue("F2", "87047");
        $sheet->setCellValue("G2", "RUC");
        $sheet->setCellValue("H2", "20730598421");
        $sheet->setCellValue("I2", "proveedor y");
        $sheet->setCellValue("J2", "F");
        $sheet->setCellValue("K2", "F064-00021998");
        $sheet->setCellValue("L2", "D");
        $sheet->setCellValue("M2", 5204.90);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Formato Imp. Cheque-Letra';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function store_imp(Request $request)
    {
        $request->validate([
            'exceli' => 'required'
        ],[
            'exceli.required' => 'Debe adjuntar archivo excel.'
        ]);

        ChequesLetrasTemporal::where('user_reg',session('usuario')->id_usuario)->delete();

        $path = $_FILES['exceli']['tmp_name'];

        $object = IOFactory::load($path);
        $worksheet = $object->getSheet(0);
        $highestRow = $worksheet->getHighestRow(); 

        for ($row = 2; $row <= $highestRow; $row++) {
            $ruc_empresa = $worksheet->getCell("A{$row}")->getValue();
            $nom_empresa = $worksheet->getCell("B{$row}")->getValue();
            $excelDate = $worksheet->getCell("C{$row}")->getValue();
            $fec_emision = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
            $excelDate = $worksheet->getCell("D{$row}")->getValue();
            $fec_vencimiento = NumberFormat::toFormattedString($excelDate, 'YYYY-MM-DD');
            $tipo_doc = $worksheet->getCell("E{$row}")->getValue();
            $n_letra = $worksheet->getCell("F{$row}")->getValue();
            $tipo_doc_aceptante = $worksheet->getCell("G{$row}")->getValue();
            $num_doc_aceptante = $worksheet->getCell("H{$row}")->getValue();
            $nom_aceptante = $worksheet->getCell("I{$row}")->getValue();
            $tipo_comprobante = $worksheet->getCell("J{$row}")->getValue();
            $n_comprobante = $worksheet->getCell("K{$row}")->getValue();
            $tipo_moneda = $worksheet->getCell("L{$row}")->getValue();
            $importe = $worksheet->getCell("M{$row}")->getValue();
            
            $validacion = true;
            $obs = "";

            //VALIDACIONES
            if (substr($ruc_empresa, 0, 1) === "=" || empty($ruc_empresa)){
                $obs = $obs."RUC empresa inválido/ ";
                $validacion = false;
            }
            if (substr($fec_emision, 0, 1) === "=" || empty($fec_emision)){
                $obs = $obs."F. Emisión inválida/ ";
                $validacion = false;
            }
            if (substr($fec_vencimiento, 0, 1) === "=" || empty($fec_vencimiento)){
                $obs = $obs."F. Vencimiento inválida/ ";
                $validacion = false;
            }
            if (substr($tipo_doc, 0, 1) === "=" || empty($tipo_doc)){
                $obs = $obs."Tipo documento inválido (C/L)/ ";
                $validacion = false;
            }
            if (substr($n_letra, 0, 1) === "=" || empty($n_letra)){
                $obs = $obs."N° letra inválido/ ";
                $validacion = false;
            }
            if (substr($tipo_doc_aceptante, 0, 1) === "=" || empty($tipo_doc_aceptante)){
                $obs = $obs."Tipo documento de aceptante inválida/ ";
                $validacion = false;
            }
            if (substr($num_doc_aceptante, 0, 1) === "=" || empty($num_doc_aceptante)){
                $obs = $obs."N° documento de aceptante inválida/ ";
                $validacion = false;
            }
            if (substr($tipo_comprobante, 0, 1) === "=" || empty($tipo_comprobante)){
                $obs = $obs."Tipo comprobante inválido (F/B/R)/ ";
                $validacion = false;
            }
            if ((isset($n_comprobante) && substr($n_comprobante, 0, 1) === "=") || 
            empty($n_comprobante)){
                $obs = $obs."N° comprobante inválido/ ";
                $validacion = false;
            }
            if (substr($tipo_moneda, 0, 1) === "=" || empty($tipo_moneda)){
                $obs = $obs."Tipo moneda inválido/ ";
                $validacion = false;
            }
            if (substr($importe, 0, 1) === "=" || empty($importe)){
                $obs = $obs."Importe inválido/ ";
                $validacion = false;
            }
            $obs = substr($obs,0,-2);

            if (!$validacion) {
                ChequesLetrasTemporal::create([
                    'num_doc' => $n_letra,
                    'fec_emision' => $fec_emision,
                    'fec_vencimiento' => $fec_vencimiento,
                    'importe' => $importe,
                    'n_comprobante' => $n_comprobante,
                    'obs' => $obs,
                    'ok' => 0,
                    'ruc_empresa' => $ruc_empresa,
                    'tipo_doc' => $tipo_doc,
                    'tipo_doc_aceptante' => $tipo_doc_aceptante,
                    'num_doc_aceptante' => $num_doc_aceptante,
                    'tipo_comprobante' => $tipo_comprobante,
                    'tipo_moneda' => $tipo_moneda,
                    'nom_empresa' => $nom_empresa,
                    'nom_aceptante' => $nom_aceptante,
                    'user_reg' =>  session('usuario')->id_usuario
                ]);
            }else{
                $empresa = Empresas::select('id_empresa')->where('ruc_empresa',$ruc_empresa)
                            ->where('estado',1)->first();
                if(!$empresa){
                    $obs = $obs."RUC de empresa no encontrada/ ";
                    $validacion = false;
                }

                if (strtotime($fec_emision) == false) {
                    $obs = $obs."Formato de F. Emisión inválida/ ";
                    $validacion = false;
                }
                
                if (strtotime($fec_vencimiento) == false) {
                    $obs = $obs."Formato de F. Vencimiento inválida/ ";
                    $validacion = false;
                }
                
                if($tipo_doc!="C" && $tipo_doc!="L"){
                    $obs = $obs."Tipo de Documento inválido (C/L)/ ";
                    $validacion = false;
                }
                if($tipo_doc_aceptante!="DNI" && $tipo_doc_aceptante!="RUC"){
                    $obs = $obs."Tipo de Documento de Aceptante inválido (DNI/RUC)/ ";
                    $validacion = false;
                }

                $aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                            ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                            DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"),
                            'tdo_codigo','clp_numdoc')
                            ->where('tdo_codigo',"$tipo_doc_aceptante")
                            ->where('clp_numdoc',"$num_doc_aceptante")
                            ->where('clp_estado','!=','*')->get();                         
                if(count($aceptante)<1){
                    $obs = $obs."Aceptante no encontrado/ ";
                    $validacion = false;
                }
                if($tipo_comprobante!="F" && $tipo_comprobante!="B" &&
                $tipo_comprobante!="R"){
                    $obs = $obs."Tipo comprobante inválido (F/B/R)/ ";
                    $validacion = false;
                }
                if($tipo_moneda!="S" && $tipo_moneda!="D"){
                    $obs = $obs."Tipo moneda inválido (S/D)/ ";
                    $validacion = false;
                }
                if (!is_numeric($importe)) {
                    $obs = $obs."No es un Importe válido/ ";
                    $validacion = false;
                }
                $obs = substr($obs,0,-2);

                if (!$validacion) {
                    ChequesLetrasTemporal::create([
                        'num_doc' => $n_letra,
                        'fec_emision' => $fec_emision,
                        'fec_vencimiento' => $fec_vencimiento,
                        'importe' => $importe,
                        'n_comprobante' => $n_comprobante,
                        'obs' => $obs,
                        'ok' => 0,
                        'ruc_empresa' => $ruc_empresa,
                        'tipo_doc' => $tipo_doc,
                        'tipo_doc_aceptante' => $tipo_doc_aceptante,
                        'num_doc_aceptante' => $num_doc_aceptante,
                        'tipo_comprobante' => $tipo_comprobante,
                        'tipo_moneda' => $tipo_moneda,
                        'nom_empresa' => $nom_empresa,
                        'nom_aceptante' => $nom_aceptante,
                        'user_reg' =>  session('usuario')->id_usuario
                    ]);
                }else{
                    $id_empresa = $empresa->id_empresa;

                    $valida = ChequesLetras::where('id_empresa', $id_empresa)
                            ->where('fec_vencimiento',$fec_vencimiento)
                            ->where('num_doc',$n_letra)->where('estado', 1)->exists();
                    if($valida){
                        $obs = $obs."Existe un registro con los mismos datos (Empresa, F. vencimiento y N° letra)/ ";
                        $validacion = false;
                    }

                    $valida = ChequesLetrasTemporal::where('id_empresa', $id_empresa)
                            ->where('fec_vencimiento_ok',$fec_vencimiento)
                            ->where('num_doc',$n_letra)->exists();
                    if($valida){
                        $obs = $obs."Existe un registro con los mismos datos en el excel (Empresa, F. vencimiento y N° letra)/ ";
                        $validacion = false;
                    }
                    $obs = substr($obs,0,-2);
                    
                    if (!$validacion) {
                        ChequesLetrasTemporal::create([
                            'num_doc' => $n_letra,
                            'fec_emision' => $fec_emision,
                            'fec_vencimiento' => $fec_vencimiento,
                            'importe' => $importe,
                            'n_comprobante' => $n_comprobante,
                            'obs' => $obs,
                            'ok' => 0,
                            'ruc_empresa' => $ruc_empresa,
                            'tipo_doc' => $tipo_doc,
                            'tipo_doc_aceptante' => $tipo_doc_aceptante,
                            'num_doc_aceptante' => $num_doc_aceptante,
                            'tipo_comprobante' => $tipo_comprobante,
                            'tipo_moneda' => $tipo_moneda,
                            'nom_empresa' => $nom_empresa,
                            'nom_aceptante' => $nom_aceptante,
                            'user_reg' =>  session('usuario')->id_usuario
                        ]);
                    }else{
                        $id_tipo_documento = "1";
                        if($tipo_doc=="L"){
                            $id_tipo_documento = "2";
                        }
                        
                        $aceptante = $aceptante[0];
                        $tipo_doc_aceptante = $aceptante->tdo_codigo;
                        $num_doc_aceptante = $aceptante->clp_numdoc;
                        
                        $id_tipo_comprobante = 1;
                        if($tipo_comprobante=="B"){
                            $id_tipo_comprobante = 2;
                        }elseif($tipo_comprobante=="R"){
                            $id_tipo_comprobante = 4;
                        }

                        $num_comprobante = $n_comprobante;
                        $id_moneda = 1;
                        if($tipo_moneda=="D"){
                            $id_moneda = 2;
                        }

                        ChequesLetrasTemporal::create([
                            'num_doc' => $n_letra,
                            'fec_emision_ok' => $fec_emision,
                            'fec_vencimiento_ok' => $fec_vencimiento,
                            'importe' => $importe,
                            'n_comprobante' => $n_comprobante,
                            'ok' => 1,
                            'id_empresa' => $id_empresa,
                            'id_tipo_documento' => $id_tipo_documento,
                            'tipo_doc_aceptante' => $tipo_doc_aceptante,
                            'num_doc_aceptante' => $num_doc_aceptante,
                            'id_tipo_comprobante' => $id_tipo_comprobante,
                            'num_comprobante' => $num_comprobante,
                            'id_moneda' => $id_moneda,
                            'user_reg' =>  session('usuario')->id_usuario
                        ]);
                    }
                }
            }
        }

        $temporal = ChequesLetrasTemporal::where('user_reg',session('usuario')->id_usuario)
                    ->where('ok',0)->count();
            
        if($temporal>0){
            echo "<p align='center'>
                    Excel con errores<br>
                    Errores: ".$temporal."<br>
                    Total: ".($highestRow-1)."<br>
                    <a class='btn mt-2' style='background-color: #28a745 !important;font-size: 3px!important;' href='".route('registro_letra.excel_error')."'>
                        <svg xmlns='http://www.w3.org/2000/svg' x='0px' y='0px' width='64' height='64' viewBox='0 0 172 172' style=' fill:#000000;'>
                            <g fill='none' fill-rule='nonzero' stroke='none' stroke-width='1' stroke-linecap='butt' stroke-linejoin='miter' stroke-miterlimit='10' stroke-dasharray='' stroke-dashoffset='0' font-family='none' font-weight='none' font-size='none' text-anchor='none' style='mix-blend-mode: normal'>
                                <path d='M0,172v-172h172v172z' fill='none'></path>
                                <g fill='#ffffff'>
                                    <path d='M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z'></path>
                                </g>
                            </g>
                        </svg>
                    </a>
                </p>";
        }else{
            $list_temporal = ChequesLetrasTemporal::where('user_reg',session('usuario')->id_usuario)
                            ->where('ok',1)->get();
            foreach($list_temporal as $list){
                ChequesLetras::create([
                    'id_empresa' => $list->id_empresa,
                    'fec_emision' => $list->fec_emision_ok,
                    'fec_vencimiento' => $list->fec_vencimiento_ok,
                    'id_tipo_documento' => $list->id_tipo_documento,
                    'num_doc' => $list->num_doc,
                    'tipo_doc_aceptante' => $list->tipo_doc_aceptante,
                    'num_doc_aceptante' => $list->num_doc_aceptante,
                    'tipo_doc_emp_vinculada' => 0,
                    'num_doc_emp_vinculada' => "",
                    'id_tipo_comprobante' => $list->id_tipo_comprobante,
                    'num_comprobante' => $request->num_comprobante,
                    'id_moneda' => $list->id_moneda,
                    'monto' => $list->importe_ok,
                    'negociado_endosado' => 0,
                    'documento' => "",
                    'estado_registro' => 1,
                    'estado' => 1,
                    'fec_reg' => now(),
                    'user_reg' => session('usuario')->id_usuario,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
            ChequesLetrasTemporal::where('user_reg',session('usuario')->id_usuario)->delete();
        }
    }

    public function excel_error(){
        $list_error = ChequesLetrasTemporal::where('user_reg',session('usuario')->id_usuario)
                    ->where('ok',0)->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:N1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:N1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Excel con errores');

        $sheet->setAutoFilter('A1:N1');

        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(12);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(18);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(15);
        $sheet->getColumnDimension('N')->setWidth(50);

        $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('000000');

        $spreadsheet->getActiveSheet()->getStyle("A1:N1")->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle("A1:N1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle('A1:N1')->getAlignment()->setWrapText(true);
        $sheet->getRowDimension(1)->setRowHeight(37);
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle("A1:N1")->getFont()->setSize(9);

        $sheet->setCellValue('A1', 'RUC EMPRESA');
        $sheet->setCellValue('B1', 'EMPRESA');
        $sheet->setCellValue('C1', 'F.EMISIÓN');
        $sheet->setCellValue('D1', 'F.VENCIMIENTO');
        $sheet->setCellValue('E1', 'TIPO DOC Cheque (C) Letra (L)');
        $sheet->setCellValue('F1', 'N° LETRA');
        $sheet->setCellValue('G1', 'TIPO DOC ACEPTANTE (DNI/RUC)');
        $sheet->setCellValue('H1', 'NUM DOC ACEPTANTE');
        $sheet->setCellValue('I1', 'ACEPTANTE');
        $sheet->setCellValue('J1', 'T.COMPROBANTE Factura (F), Boleta (B), Recibo (R)');
        $sheet->setCellValue('K1', 'N.COMPROBANTE');
        $sheet->setCellValue('L1', 'T.MONEDA Soles (S) Dolares (D)');
        $sheet->setCellValue('M1', 'IMPORTE');
        $sheet->setCellValue('N1', 'OBERVACIONES');

        $contador = 1;

        foreach($list_error as $list){
            $contador++;

            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("I{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("N{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:N{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:N{$contador}")->getFont()->setSize(9);
            $sheet->getStyle("A{$contador}:N{$contador}")->getAlignment()->setWrapText(true);

            $sheet->setCellValue("A{$contador}", $list->ruc_empresa);
            $sheet->setCellValue("B{$contador}", $list->nom_empresa);
            if (strtotime($list->fec_emision) == true) {
                $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list->fec_emision));
                $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            if (strtotime($list->fec_vencimiento) == true) {
                $sheet->setCellValue("D{$contador}", Date::PHPToExcel($list->fec_vencimiento));
                $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            }
            $sheet->setCellValue("E{$contador}", $list->tipo_doc);
            $sheet->setCellValue("F{$contador}", $list->num_doc);
            $sheet->setCellValue("G{$contador}", $list->tipo_doc_aceptante);
            $sheet->setCellValue("H{$contador}", $list->num_doc_aceptante);
            $sheet->setCellValue("I{$contador}", $list->nom_aceptante);
            $sheet->setCellValue("J{$contador}", $list->tipo_comprobante);
            $sheet->setCellValue("K{$contador}", $list->n_comprobante);
            $sheet->setCellValue("L{$contador}", $list->tipo_moneda);
            $sheet->setCellValue("M{$contador}", $list->importe);
            $sheet->setCellValue("N{$contador}", $list->obs);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Excel con errores';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function edit($id)
    {
        $get_id = ChequesLetras::findOrFail($id);
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get();
        $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,4])->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.registro_letra.modal_editar',compact(
            'get_id',
            'list_empresa',
            'list_aceptante',
            'list_tipo_comprobante',
            'list_tipo_moneda'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_empresae' => 'gt:0',
            'fec_emisione' => 'required',
            'fec_vencimientoe' => 'required',
            'id_tipo_documentoe' => 'gt:0',
            'num_doce' => 'required',
            'id_aceptantee' => 'not_in:0',
            'id_tipo_comprobantee' => 'gt:0',
            'num_comprobantee' => 'required',
            'montoe' => 'required|gt:0'
        ],[
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'fec_emisione.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimientoe.required' => 'Debe ingresar fecha vencimiento.',
            'id_tipo_documentoe.gt' => 'Debe seleccionar tipo documento.',
            'num_doce.required' => 'Debe ingresar n° documento.',
            'id_aceptantee.not_in' => 'Debe seleccionar aceptante.',
            'id_tipo_comprobantee.gt' => 'Debe seleccionar tipo comprobante.',
            'num_comprobantee.required' => 'Debe ingresar n° comprobante.',
            'montoe.required' => 'Debe ingresar monto.',
            'montoe.gt' => 'Debe ingresar monto mayor a 0.'
        ]);

        $valida = ChequesLetras::where('id_empresa', $request->id_empresae)
                ->where('fec_vencimiento',$request->fec_vencimientoe)->where('num_doc',$request->num_doce)
                ->where('estado', 1)->where('id_cheque_letra','!=',$id)->exists();

        if($valida){
            echo "error";
        }else{
            $aceptante = explode("_",$request->id_aceptantee);
            $tipo_doc_empresa_vinculada = NULL;
            $num_doc_empresa_vinculada = NULL;
            if($request->negociado_endosadoe=="2"){
                $empresa_vinculada = explode("_",$request->id_empresa_vinculadae);
                $tipo_doc_empresa_vinculada = $empresa_vinculada[0];
                $num_doc_empresa_vinculada = $empresa_vinculada[1];
            }

            $get_id = ChequesLetras::findOrFail($id);
            $documento = $get_id->documento;
            if ($_FILES["documentoe"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if($get_id->documento!=""){
                        ftp_delete($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/".basename($get_id->documento));
                    }

                    $path = $_FILES["documentoe"]["name"];
                    $source_file = $_FILES['documentoe']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Cheque_Letra_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $documento = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            ChequesLetras::findOrFail($id)->update([                
                'id_empresa' => $request->id_empresae,
                'fec_emision' => $request->fec_emisione,
                'fec_vencimiento' => $request->fec_vencimientoe,
                'id_tipo_documento' => $request->id_tipo_documentoe,
                'num_doc' => $request->num_doce,
                'tipo_doc_aceptante' => $aceptante[0],
                'num_doc_aceptante' => $aceptante[1],
                'tipo_doc_emp_vinculada' => $tipo_doc_empresa_vinculada,
                'num_doc_emp_vinculada' => $num_doc_empresa_vinculada,
                'id_tipo_comprobante' => $request->id_tipo_comprobantee,
                'num_comprobante' => $request->num_comprobantee,
                'id_moneda' => $request->id_monedae,
                'monto' => $request->montoe,
                'negociado_endosado' => $request->negociado_endosadoe,
                'documento' => $documento,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function unico($id, $tipo)
    {
        $get_id = ChequesLetras::findOrFail($id);
        $list_banco = DB::connection('sqlsrv')->table('vw_bancos')
                    ->select(DB::raw("c_sigl_banc AS id_banco"),
                    DB::raw("CONCAT(c_desc_banc,' (',c_sigl_banc,')') AS nom_banco"))
                    ->orderBy('c_desc_banc','ASC')->get();
        return view('finanzas.tesoreria.registro_letra.modal_unico',compact(
            'get_id',
            'list_banco',
            'tipo'
        ));
    }

    public function update_unico(Request $request, $id)
    {
        $request->validate([
            'tipo_nunicou' => 'required',
            'num_unicou' => 'required_if:tipo_nunicou,1',
            'num_cuentau' => 'required_if:tipo_nunicou,2',
            'bancou' => 'not_in:0'
        ],[
            'tipo_nunicou.required' => 'Debe seleccionar el tipo de letra.',
            'num_unicou.required_if' => 'Debe ingresar número único.',
            'num_cuentau.required_if' => 'Debe ingresar número de cuenta.',
            'bancou.not_in' => 'Debe seleccionar banco.'
        ]);

        if($request->tipo_nunicou=="1"){
            $valida = ChequesLetras::where('num_unico', $request->num_unicou)
                    ->where('estado', 1)->where('id_cheque_letra','!=',$id)->exists();

            if($valida){
                echo "error";
            }else{
                ChequesLetras::findOrFail($id)->update([
                    'tipo_nunico' => $request->tipo_nunicou,
                    'num_unico' => $request->num_unicou,
                    'num_cuenta' => $request->num_cuentau,
                    'banco' => $request->bancou,
                    'fec_act' => now(),
                    'user_act' => session('usuario')->id_usuario
                ]);
            }
        }else{
            ChequesLetras::findOrFail($id)->update([
                'tipo_nunico' => $request->tipo_nunicou,
                'num_unico' => $request->num_unicou,
                'num_cuenta' => $request->num_cuentau,
                'banco' => $request->bancou,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function estado($id, $tipo)
    {
        $get_id = ChequesLetras::findOrFail($id);
        return view('finanzas.tesoreria.registro_letra.modal_estado',compact('get_id','tipo'));
    }

    public function update_estado(Request $request, $id)
    {
        $request->validate([
            'fec_pagos' => 'required',
            'noperacions' => 'required'
        ],[
            'fec_pagos.required' => 'Debe ingresar fecha pago.',
            'noperacions.required' => 'Debe ingresar n° operación.'
        ]);

        $get_id = ChequesLetras::findOrFail($id);

        $comprobante_pago = $get_id->comprobante_pago;
        if ($_FILES["comprobante_pagos"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante_pago!=""){
                    ftp_delete($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/".basename($get_id->comprobante_pago));
                }

                $path = $_FILES["comprobante_pagos"]["name"];
                $source_file = $_FILES['comprobante_pagos']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_Pago_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante_pago = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES_LETRAS/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        ChequesLetras::findOrFail($id)->update([
            'fec_pago' => $request->fec_pagos,
            'noperacion' => $request->noperacions,
            'comprobante_pago' => $comprobante_pago,
            'estado_registro' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy($id)
    {
        ChequesLetras::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel($estado,$id_empresa,$id_aceptante,$tipo_fecha,$mes,$anio)
    {
        $list_cheque_letra = ChequesLetras::get_list_cheques_letra([
            'estado'=>$estado,
            'id_empresa'=>$id_empresa,
            'id_aceptante'=>$id_aceptante,
            'tipo_fecha'=>$tipo_fecha,
            'mes'=>$mes,
            'anio'=>$anio
        ]);
        $list_aceptante = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_aceptante"),
                        DB::raw("clp_razsoc AS nom_aceptante"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A2:Q2")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("A2:Q2")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Cheques y letras');

        $sheet->setAutoFilter('A2:Q2');

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(10);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(35);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(25);
        $sheet->getColumnDimension('M')->setWidth(12);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(13);
        $sheet->getColumnDimension('P')->setWidth(10);
        $sheet->getColumnDimension('Q')->setWidth(13);

        $sheet->getStyle('A1:Q2')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A2:Q2")->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('92D050');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A2:Q2")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->getStyle("A1:Q1")->getFont()->setSize(16);
        $sheet->getStyle("A2:Q2")->getFont()->setSize(10); 

        $sheet->setCellValue('E1', 'LETRA - CHEQUES - '.$anio);
        $sheet->setCellValue('A2', 'EMPRESA');
        $sheet->setCellValue('B2', 'F. EMISIÓN');
        $sheet->setCellValue('C2', 'F. VENCIMIENTO');
        $sheet->setCellValue('D2', 'DIAS ATRASO');
        $sheet->setCellValue('E2', 'TIPO DOCUMENTO');
        $sheet->setCellValue('F2', 'N° DOCUMENTO');
        $sheet->setCellValue('G2', 'ACEPTANTE');
        $sheet->setCellValue('H2', 'TIPO COMPROBANTE');
        $sheet->setCellValue('I2', 'N° COMPROBANTE');
        $sheet->setCellValue('J2', 'MONTO');
        $sheet->setCellValue('K2', 'NEGOCIADO/ENDOSADO');
        $sheet->setCellValue('L2', 'EMPRESA ENDOSADO');
        $sheet->setCellValue('M2', 'ESTADO');
        $sheet->setCellValue('N2', 'F. PAGO');
        $sheet->setCellValue('O2', 'N° OPERACIÓN');
        $sheet->setCellValue('P2', 'N° ÚNICO');
        $sheet->setCellValue('Q2', 'BANCO');

        $contador = 2;
        $soles = 0;
        $dolares = 0;
        foreach ($list_cheque_letra as $list) {
            $contador++;

            $nom_aceptante = "";
            $empresa_vinculada = "";

            $busqueda = in_array($list->id_aceptante, array_column($list_aceptante, 'id_aceptante'));
            $posicion = array_search($list->id_aceptante, array_column($list_aceptante, 'id_aceptante'));    
            if ($busqueda != false) {
                $nom_aceptante = $list_aceptante[$posicion]['nom_aceptante'];
            }

            if($list->negociado_endosado=="Endosado"){
                $busqueda = in_array($list->id_empresa_vinculada, array_column($list_aceptante, 'id_aceptante'));
                $posicion = array_search($list->id_empresa_vinculada, array_column($list_aceptante, 'id_aceptante'));    
                if ($busqueda != false) {
                    $empresa_vinculada = $list_aceptante[$posicion]['nom_aceptante'];
                }
            }

            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("A{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("G{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("J{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("Q{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:Q{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("A{$contador}:Q{$contador}")->getFont()->setSize(10);
            if($list->id_moneda=="1"){
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            }else{
                $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            }

            $sheet->setCellValue("A{$contador}", $list->nom_empresa);
            $sheet->setCellValue("B{$contador}", Date::PHPToExcel($list->fec_emision));
            $sheet->getStyle("B{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            $sheet->setCellValue("C{$contador}", Date::PHPToExcel($list->fec_vencimiento));
            $sheet->getStyle("C{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            $sheet->setCellValue("D{$contador}", $list->dias_atraso);
            $sheet->setCellValue("E{$contador}", $list->nom_tipo_documento);
            $sheet->setCellValue("F{$contador}", $list->num_doc);
            $sheet->setCellValue("G{$contador}", $nom_aceptante);
            $sheet->setCellValue("H{$contador}", $list->nom_tipo_comprobante);
            $sheet->setCellValue("I{$contador}", $list->num_comprobante); 
            $sheet->setCellValue("J{$contador}", $list->monto);
            $sheet->setCellValue("K{$contador}", $list->negociado_endosado);
            $sheet->setCellValue("L{$contador}", $empresa_vinculada);
            $sheet->setCellValue("M{$contador}", $list->nom_estado);
            if($list->fec_pago!=""){
                $sheet->setCellValue("N{$contador}", Date::PHPToExcel($list->fec_pago));
                $sheet->getStyle("N{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DMYSLASH); 
            }
            $sheet->setCellValue("O{$contador}", $list->noperacion);
            $sheet->setCellValue("P{$contador}", $list->num_unico);
            $sheet->setCellValue("Q{$contador}", $list->banco);

            if($list->id_moneda=="1"){
                $soles = $soles+$list->monto;
            }else{
                $dolares = $dolares+$list->monto;
            }
        }
        $contador = $contador+1;
        $sheet->setCellValue("I{$contador}", 'Total Soles');
        $sheet->setCellValue("J{$contador}", $soles);
        $sheet->getStyle("I{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("I{$contador}:J{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
        $contador = $contador+1;
        $sheet->setCellValue("I{$contador}", 'Total Dólares');
        $sheet->setCellValue("J{$contador}", $dolares);
        $sheet->getStyle("I{$contador}:J{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("I{$contador}:J{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("J{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Cheques y letras';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
