<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Empresas;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TipoComprobante;
use App\Models\TipoMoneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LetraCobrarController extends Controller
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
        $list_cliente = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_cliente"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_cliente"))
                        ->where('clp_estado','!=','*')->get();
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->orderby('cod_anio','DESC')->get();
        return view('finanzas.tesoreria.letra_cobrar.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_empresa',
            'list_cliente',
            'list_mes',
            'list_anio'
        ));
    }

    public function list(Request $request)
    {
        /*$list_letra_cobrar = ChequesLetras::get_list_cheques_letra([
            'estado'=>$request->estado,
            'id_empresa'=>$request->id_empresa,
            'id_aceptante'=>$request->id_aceptante,
            'tipo_fecha'=>$request->tipo_fecha,
            'mes'=>$request->mes,
            'anio'=>$request->anio
        ]);*/
        $list_letra_cobrar = [];
        $list_cliente = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_cliente"),
                        DB::raw("clp_razsoc AS nom_cliente"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();
        return view('finanzas.tesoreria.letra_cobrar.lista', compact(
            'list_letra_cobrar',
            'list_cliente'
        ));
    }

    public function create()
    {
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_cliente = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_cliente"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_cliente"))
                        ->where('clp_estado','!=','*')->get();
        $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,4])->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.letra_cobrar.modal_registrar',compact(
            'list_empresa',
            'list_cliente',
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
        return view('finanzas.tesoreria.letra_cobrar.modal_editar',compact(
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
        return view('finanzas.tesoreria.letra_cobrar.modal_unico',compact(
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
        return view('finanzas.tesoreria.letra_cobrar.modal_estado',compact('get_id','tipo'));
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
