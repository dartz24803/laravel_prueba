<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Base;
use App\Models\DatosServicio;
use App\Models\GastoServicio;
use App\Models\LugarServicio;
use App\Models\Mes;
use App\Models\Notificacion;
use App\Models\Servicio;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RegistroServicioController extends Controller
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

        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_servicio = Servicio::where('tipodeed', NULL)->where('estado', 1)->get();
        $list_lugar = LugarServicio::all();
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        return view('finanzas.tesoreria.registro_servicio.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_base',
            'list_servicio',
            'list_lugar',
            'list_mes',
            'list_anio'
        ));
    }

    public function list(Request $request)
    {
        $list_registro_servicio = GastoServicio::get_list_registro_servicio([
            'todos'=>$request->todos,
            'cod_base'=>$request->cod_base,
            'estado'=>$request->estado,
            'id_servicio'=>$request->id_servicio,
            'id_lugar_servicio'=>$request->id_lugar_servicio,
            'mes'=>$request->mes,
            'anio'=>$request->anio
        ]);
        return view('finanzas.tesoreria.registro_servicio.lista', compact(
            'list_registro_servicio'
        ));
    }

    public function create()
    {
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        return view('finanzas.tesoreria.registro_servicio.modal_registrar',compact(
            'list_base',
            'list_mes',
            'list_anio'
        ));
    }

    public function traer_lugar(Request $request)
    {
        $list_lugar = DatosServicio::from('datos_servicio AS ds')
                    ->select('ds.id_lugar_servicio', 'ls.nom_lugar_servicio')
                    ->leftjoin('vw_lugar_servicio AS ls','ls.id_lugar_servicio','=','ds.id_lugar_servicio')
                    ->where('ds.cod_base', $request->cod_base)->where('ds.estado', 1)
                    ->orderBy('ls.nom_lugar_servicio','ASC')
                    ->groupBy('ds.id_lugar_servicio','ls.nom_lugar_servicio')->get();
        return view('finanzas.tesoreria.registro_servicio.lugar', compact('list_lugar'));
    }

    public function traer_servicio(Request $request)
    {
        $list_servicio = DatosServicio::from('datos_servicio AS ds')
                        ->select('ds.id_servicio', 'se.nom_servicio')
                        ->leftjoin('servicio AS se','se.id_servicio','=','ds.id_servicio')
                        ->where('ds.cod_base', $request->cod_base)
                        ->where('ds.id_lugar_servicio', $request->id_lugar_servicio)
                        ->where('ds.estado', 1)
                        ->orderBy('se.nom_servicio','ASC')
                        ->groupBy('ds.id_servicio','se.nom_servicio')->get();
        return view('finanzas.tesoreria.registro_servicio.servicio', compact('list_servicio'));
    }

    public function traer_proveedor(Request $request)
    {
        $list_proveedor = DatosServicio::from('datos_servicio AS ds')
                        ->select('ds.id_proveedor_servicio', 'ps.nom_proveedor_servicio')
                        ->leftjoin('proveedor_servicio AS ps','ps.id_proveedor_servicio','=','ds.id_proveedor_servicio')
                        ->where('ds.cod_base', $request->cod_base)
                        ->where('ds.id_lugar_servicio', $request->id_lugar_servicio)
                        ->where('ds.id_servicio', $request->id_servicio)
                        ->where('ds.estado', 1)
                        ->orderBy('ps.nom_proveedor_servicio','ASC')
                        ->groupBy('ds.id_proveedor_servicio','ps.nom_proveedor_servicio')->get();
        return view('finanzas.tesoreria.registro_servicio.proveedor', compact('list_proveedor'));
    }

    public function traer_lectura(Request $request)
    {
        $get_id = Servicio::findOrFail($request->id_servicio);
        $v = $request->v;
        return view('finanzas.tesoreria.registro_servicio.lectura', compact('get_id','v'));
    }

    public function traer_suministro(Request $request)
    {
        $list_suministro = DatosServicio::from('datos_servicio AS ds')
                            ->select('ds.id_datos_servicio', 'ds.suministro')
                            ->where('ds.cod_base', $request->cod_base)
                            ->where('ds.id_lugar_servicio', $request->id_lugar_servicio)
                            ->where('ds.id_servicio', $request->id_servicio)
                            ->where('ds.id_proveedor_servicio', $request->id_proveedor_servicio)
                            ->where('ds.estado', 1)->get();
        return view('finanzas.tesoreria.registro_servicio.suministro', compact('list_suministro'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cod_base' => 'not_in:0',
            'id_lugar_servicio' => 'gt:0',
            'id_servicio' => 'gt:0',
            'id_proveedor_servicio' => 'gt:0'
        ],[
            'cod_base.not_in' => 'Debe seleccionar base.',
            'id_lugar_servicio.gt' => 'Debe seleccionar lugar.',
            'id_servicio.gt' => 'Debe seleccionar servicio.',
            'id_proveedor_servicio.gt' => 'Debe seleccionar proveedor.'
        ]);

        $errors = [];
        if($request->id_servicio!="5"){
            if ($request->suministro == "0") {
                $errors['suministro'] = ['Debe seleccionar suministro.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $valida = GastoServicio::where('id_proveedor_servicio', $request->id_proveedor_servicio)
                ->where('id_servicio', $request->id_servicio)
                ->where('id_lugar_servicio', $request->id_lugar_servicio)
                ->where('cod_base', $request->cod_base)->where('mes', $request->mes)
                ->where('suministro', $request->suministro)
                ->where('documento_serie', $request->documento_serie)
                ->where('documento_numero', $request->documento_numero)
                ->where('fec_emision',$request->fec_emision)
                ->where('fec_vencimiento',$request->fec_vencimiento)->where('importe',$request->importe)
                ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
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
                    $nombre_soli = "Recibo_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TIENDA/COMPROBANTE_SERVICIOS/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $documento = "https://lanumerounocloud.com/intranet/TIENDA/COMPROBANTE_SERVICIOS/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            GastoServicio::create([
                'cod_base' => $request->cod_base,
                'id_lugar_servicio' => $request->id_lugar_servicio,
                'id_servicio' => $request->id_servicio,
                'id_proveedor_servicio' => $request->id_proveedor_servicio,
                'suministro' => $request->suministro,
                'documento_serie' => $request->documento_serie,
                'documento_numero' => $request->documento_numero,
                'mes' => $request->mes,
                'anio' => $request->anio,
                'fec_emision' => $request->fec_emision,
                'fec_vencimiento' => $request->fec_vencimiento,
                'importe' => $request->importe,
                'lant_dato' => $request->lant_dato,
                'lant_fecha' => $request->lant_fecha,
                'lact_dato' => $request->lact_dato,
                'lact_fecha' => $request->lact_fecha,
                'documento' => $documento,
                'estado_servicio' => 1,
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
        $get_id = GastoServicio::from('gasto_servicio AS gs')
                ->select('gs.*','se.lectura')
                ->leftjoin('servicio AS se','se.id_servicio','=','gs.id_servicio')
                ->where('id_gasto_servicio',$id)->first();
        $list_base = Base::get_list_todas_bases_agrupadas();
        $list_lugar = DatosServicio::from('datos_servicio AS ds')
                    ->select('ds.id_lugar_servicio', 'ls.nom_lugar_servicio')
                    ->leftjoin('vw_lugar_servicio AS ls','ls.id_lugar_servicio','=','ds.id_lugar_servicio')
                    ->where('ds.cod_base', $get_id->cod_base)->where('ds.estado', 1)
                    ->orderBy('ls.nom_lugar_servicio','ASC')
                    ->groupBy('ds.id_lugar_servicio','ls.nom_lugar_servicio')->get();
        $list_servicio = DatosServicio::from('datos_servicio AS ds')
                    ->select('ds.id_servicio', 'se.nom_servicio')
                    ->leftjoin('servicio AS se','se.id_servicio','=','ds.id_servicio')
                    ->where('ds.cod_base', $get_id->cod_base)
                    ->where('ds.id_lugar_servicio', $get_id->id_lugar_servicio)
                    ->where('ds.estado', 1)
                    ->orderBy('se.nom_servicio','ASC')
                    ->groupBy('ds.id_servicio','se.nom_servicio')->get();
        $list_proveedor = DatosServicio::from('datos_servicio AS ds')
                    ->select('ds.id_proveedor_servicio', 'ps.nom_proveedor_servicio')
                    ->leftjoin('proveedor_servicio AS ps','ps.id_proveedor_servicio','=','ds.id_proveedor_servicio')
                    ->where('ds.cod_base', $get_id->cod_base)
                    ->where('ds.id_lugar_servicio', $get_id->id_lugar_servicio)
                    ->where('ds.id_servicio', $get_id->id_servicio)
                    ->where('ds.estado', 1)
                    ->orderBy('ps.nom_proveedor_servicio','ASC')
                    ->groupBy('ds.id_proveedor_servicio','ps.nom_proveedor_servicio')->get();
        $list_suministro = DatosServicio::from('datos_servicio AS ds')
                    ->select('ds.id_datos_servicio', 'ds.suministro')
                    ->where('ds.cod_base', $get_id->cod_base)
                    ->where('ds.id_lugar_servicio', $get_id->id_lugar_servicio)
                    ->where('ds.id_servicio', $get_id->id_servicio)
                    ->where('ds.id_proveedor_servicio', $get_id->id_proveedor_servicio)
                    ->where('ds.estado', 1)->get();                                                     
        $list_mes = Mes::select('cod_mes','abr_mes')->orderby('cod_mes','ASC')->get();
        $list_anio = Anio::select('cod_anio')->where('estado', 1)->orderBy('cod_anio', 'DESC')->get();
        return view('finanzas.tesoreria.registro_servicio.modal_editar',compact(
            'get_id',
            'list_base',
            'list_lugar',
            'list_servicio',
            'list_proveedor',
            'list_suministro',
            'list_mes',
            'list_anio'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cod_basee' => 'not_in:0',
            'id_lugar_servicioe' => 'gt:0',
            'id_servicioe' => 'gt:0',
            'id_proveedor_servicioe' => 'gt:0'
        ],[
            'cod_basee.not_in' => 'Debe seleccionar base.',
            'id_lugar_servicioe.gt' => 'Debe seleccionar lugar.',
            'id_servicioe.gt' => 'Debe seleccionar servicio.',
            'id_proveedor_servicioe.gt' => 'Debe seleccionar proveedor.'
        ]);

        $errors = [];
        if($request->id_servicioe!="5"){
            if ($request->suministroe == "0") {
                $errors['suministro'] = ['Debe seleccionar suministro.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $valida = GastoServicio::where('id_proveedor_servicio', $request->id_proveedor_servicioe)
                ->where('id_servicio', $request->id_servicioe)
                ->where('id_lugar_servicio', $request->id_lugar_servicioe)
                ->where('cod_base', $request->cod_basee)->where('mes', $request->mese)
                ->where('suministro', $request->suministroe)
                ->where('documento_serie', $request->documento_seriee)
                ->where('documento_numero', $request->documento_numeroe)
                ->where('fec_emision',$request->fec_emisione)
                ->where('fec_vencimiento',$request->fec_vencimientoe)->where('importe',$request->importee)
                ->where('id_gasto_servicio','!=',$id)->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            $get_id = GastoServicio::findOrFail($id);
            $documento = $get_id->documento;
            if ($_FILES["documentoe"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if($get_id->documento!=""){
                        ftp_delete($con_id, "TIENDA/COMPROBANTE_SERVICIOS/".basename($get_id->documento));
                    }

                    $path = $_FILES["documentoe"]["name"];
                    $source_file = $_FILES['documentoe']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Recibo_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "TIENDA/COMPROBANTE_SERVICIOS/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $documento = "https://lanumerounocloud.com/intranet/TIENDA/COMPROBANTE_SERVICIOS/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            GastoServicio::findOrFail($id)->update([                
                'cod_base' => $request->cod_basee,
                'id_lugar_servicio' => $request->id_lugar_servicioe,
                'id_servicio' => $request->id_servicioe,
                'id_proveedor_servicio' => $request->id_proveedor_servicioe,
                'suministro' => $request->suministroe,
                'documento_serie' => $request->documento_seriee,
                'documento_numero' => $request->documento_numeroe,
                'mes' => $request->mese,
                'anio' => $request->anioe,
                'fec_emision' => $request->fec_emisione,
                'fec_vencimiento' => $request->fec_vencimientoe,
                'importe' => $request->importee,
                'lant_dato' => $request->lant_datoe,
                'lant_fecha' => $request->lant_fechae,
                'lact_dato' => $request->lact_datoe,
                'lact_fecha' => $request->lact_fechae,
                'documento' => $documento,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function estado($id)
    {
        $get_id = GastoServicio::findOrFail($id);
        return view('finanzas.tesoreria.registro_servicio.modal_estado',compact('get_id'));
    }

    public function update_estado(Request $request, $id)
    {
        $request->validate([
            'fec_pagos' => 'required',
            'num_operacions' => 'required'
        ],[
            'fec_pagos.required' => 'Debe ingresar fecha pago.',
            'num_operacions.required' => 'Debe ingresar n° operación.'
        ]);

        $get_id = GastoServicio::findOrFail($id);

        $comprobante = $get_id->comprobante;
        if ($_FILES["comprobantes"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante!=""){
                    ftp_delete($con_id, "TIENDA/COMPROBANTE_SERVICIOS/".basename($get_id->comprobante));
                }

                $path = $_FILES["comprobantes"]["name"];
                $source_file = $_FILES['comprobantes']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "TIENDA/COMPROBANTE_SERVICIOS/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/TIENDA/COMPROBANTE_SERVICIOS/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        GastoServicio::findOrFail($id)->update([
            'fec_pago' => $request->fec_pagos,
            'num_operacion' => $request->num_operacions,
            'comprobante' => $comprobante,
            'estado_servicio' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy($id)
    {
        GastoServicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel($todos,$cod_base,$estado,$id_servicio,$id_lugar_servicio,$mes,$anio)
    {
        $list_registro_servicio = GastoServicio::get_list_registro_servicio([
            'todos'=>$todos,
            'cod_base'=>$cod_base,
            'estado'=>$estado,
            'id_servicio'=>$id_servicio,
            'id_lugar_servicio'=>$id_lugar_servicio,
            'mes'=>$mes,
            'anio'=>$anio
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:M1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:M1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Registro de servicios');

        $sheet->setAutoFilter('A1:M1');

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);

        $sheet->getStyle('A1:M1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:M1")->getFill()
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

        $sheet->getStyle("A1:M1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue('A1', 'BASE');
        $sheet->setCellValue('B1', 'TIPO DE SERVICIO');
        $sheet->setCellValue('C1', 'LUGAR');
        $sheet->setCellValue('D1', 'IMPORTE');
        $sheet->setCellValue('E1', 'PERIODO');
        $sheet->setCellValue('F1', 'ESTADO');
        $sheet->setCellValue('G1', 'PROGRESO');
        $sheet->setCellValue('H1', 'F. PAGO');
        $sheet->setCellValue('I1', 'N° OPERACIÓN');
        $sheet->setCellValue('J1', 'LECT. ANTERIOR');
        $sheet->setCellValue('K1', 'FEC. ANTERIOR');
        $sheet->setCellValue('L1', 'LECT. ACTUAL');
        $sheet->setCellValue('M1', 'FEC. ACTUAL');

        $contador = 1;
        $total = 0;
        foreach ($list_registro_servicio as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("B{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("D{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:M{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:M{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            $sheet->getStyle("G{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);

            $sheet->setCellValue("A{$contador}", $list->cod_base);
            $sheet->setCellValue("B{$contador}", $list->nom_servicio);
            $sheet->setCellValue("C{$contador}", $list->nom_lugar_servicio);
            $sheet->setCellValue("D{$contador}", $list->total);
            $sheet->setCellValue("E{$contador}", $list->periodo);
            $sheet->setCellValue("F{$contador}", $list->nom_estado);
            if($list->lectura==1){
                $porcentaje = round((($list->lugar_servicio+$list->servicio+$list->proveedor_servicio+
                                $list->suministro+$list->documentoserie+$list->documentonumero+
                                $list->fecha_vencimiento+$list->importe_porc+$list->documento_porc+
                                $list->lantdato+$list->lantfecha+$list->lactdato+$list->lactfecha)/13)*1,4);
                $sheet->setCellValue("G{$contador}", $porcentaje);
            }else{
                $porcentaje = round((($list->lugar_servicio+$list->servicio+$list->proveedor_servicio+
                                $list->documentoserie+$list->documentonumero+$list->fecha_vencimiento+
                                $list->importe_porc+$list->documento_porc)/8)*1,4);
                $sheet->setCellValue("G{$contador}", $porcentaje);
            }
            if($list->fec_pago!=""){
                $sheet->setCellValue("H{$contador}", Date::PHPToExcel($list->fec_pago));
                $sheet->getStyle("H{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY); 
            }
            $sheet->setCellValue("I{$contador}", $list->num_operacion);
            $sheet->setCellValue("J{$contador}", $list->lant_dato);
            if($list->lant_fecha!=""){
                $sheet->setCellValue("K{$contador}", Date::PHPToExcel($list->lant_fecha));
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY); 
            }
            $sheet->setCellValue("L{$contador}", $list->lact_dato);
            if($list->lact_fecha!=""){
                $sheet->setCellValue("M{$contador}", Date::PHPToExcel($list->lact_fecha));
                $sheet->getStyle("M{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY); 
            }

            $total = $total+$list->total;
        }
        $contador = $contador+1;
        $sheet->setCellValue("C{$contador}", 'Total Importe');
        $sheet->setCellValue("D{$contador}", $total);
        $sheet->getStyle("C{$contador}:D{$contador}")->applyFromArray($styleThinBlackBorderOutline);
        $sheet->getStyle("C{$contador}:D{$contador}")->getFont()->setBold(true);
        $sheet->getStyle("D{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Registro de servicios';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
