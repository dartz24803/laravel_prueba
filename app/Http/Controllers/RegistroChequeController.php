<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\ConceptoCheque;
use App\Models\Empresas;
use App\Models\FinanzasCheque;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use App\Models\TipoMoneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistroChequeController extends Controller
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
        return view('finanzas.tesoreria.registro_cheque.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_empresa'
        ));
    }

    public function list(Request $request)
    {
        $list_cheque = FinanzasCheque::get_list_cheque([
            'todos'=>$request->todos,
            'id_empresa'=>$request->id_empresa,
            'estado'=>$request->estado,
            'fec_inicio'=>$request->fec_inicio,
            'fec_fin'=>$request->fec_fin,
            'tipo_fecha'=>$request->tipo_fecha,
        ]);
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("clp_razsoc AS nom_girado"))
                        ->where('clp_estado','!=','*')->get()->map(function($item) {
                            return (array) $item;
                        })->toArray();
        return view('finanzas.tesoreria.registro_cheque.lista', compact(
            'list_cheque',
            'list_girado'
        ));
    }

    public function create()
    {
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_girado"))
                        ->where('clp_estado','!=','*')->get();
        $list_concepto = ConceptoCheque::select('id_concepto_cheque','nom_concepto_cheque')
                        ->where('estado',1)->orderBy('nom_concepto_cheque','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','nom_moneda')->get();
        return view('finanzas.tesoreria.registro_cheque.modal_registrar',compact(
            'list_empresa',
            'list_banco',
            'list_girado',
            'list_concepto',
            'list_tipo_moneda'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_empresa' => 'gt:0',
            'id_banco' => 'gt:0',
            'n_cheque' => 'required',
            'fec_emision' => 'required',
            'fec_vencimiento' => 'required|after_or_equal:fec_emision',
            'importe' => 'required|gt:0'
        ],[
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'id_banco.gt' => 'Debe seleccionar banco.',
            'n_cheque.required' => 'Debe ingresar n° cheque.',
            'fec_emision.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimiento.required' => 'Debe ingresar fecha vencimiento.',
            'fec_vencimiento.after_or_equal' => 'Fecha vencimiento no debe ser menor a la fecha emisión.',
            'importe.required' => 'Debe ingresar importe.',
            'importe.gt' => 'Debe ingresar importe mayor a 0.'
        ]);

        $valida = FinanzasCheque::where('id_empresa', $request->id_empresa)->where('n_cheque',$request->n_cheque)
                ->where('id_moneda',$request->id_moneda)->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->id_girado!="0"){
                $girado = explode("_",$request->id_girado);
            }

            FinanzasCheque::create([
                'id_empresa' => $request->id_empresa,
                'id_banco' => $request->id_banco,
                'n_cheque' => $request->n_cheque,
                'fec_emision' => $request->fec_emision,
                'fec_vencimiento' => $request->fec_vencimiento,
                'tipo_doc' => $girado[0],
                'num_doc' => $girado[1],
                'concepto' => $request->concepto,
                'id_moneda' => $request->id_moneda,
                'importe' => $request->importe,
                'estado_cheque' => 1,
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
        $get_id = FinanzasCheque::findOrFail($id);
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('estado',1)
                        ->orderBy('nom_empresa','ASC')->get();
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_girado = DB::connection('sqlsrv')->table('tge_entidades')
                        ->select(DB::raw("CONCAT(tdo_codigo,'_',clp_numdoc) AS id_girado"),
                        DB::raw("CONCAT(clp_razsoc,' - ',clp_numdoc) AS nom_girado"))
                        ->where('clp_estado','!=','*')->get();
        $list_concepto = ConceptoCheque::select('id_concepto_cheque','nom_concepto_cheque')
                        ->where('estado',1)->orderBy('nom_concepto_cheque','ASC')->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','nom_moneda')->get();
        return view('finanzas.tesoreria.registro_cheque.modal_editar',compact(
            'get_id',
            'list_empresa',
            'list_banco',
            'list_girado',
            'list_concepto',
            'list_tipo_moneda'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_empresae' => 'gt:0',
            'id_bancoe' => 'gt:0',
            'n_chequee' => 'required',
            'fec_emisione' => 'required',
            'fec_vencimientoe' => 'required|after_or_equal:fec_emisione',
            'importee' => 'required|gt:0'
        ],[
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'id_bancoe.gt' => 'Debe seleccionar banco.',
            'n_chequee.required' => 'Debe ingresar n° cheque.',
            'fec_emisione.required' => 'Debe ingresar fecha emisión.',
            'fec_vencimientoe.required' => 'Debe ingresar fecha vencimiento.',
            'fec_vencimientoe.after_or_equal' => 'Fecha vencimiento no debe ser menor a la fecha emisión.',
            'importee.required' => 'Debe ingresar importe.',
            'importee.gt' => 'Debe ingresar importe mayor a 0.'
        ]);

        $valida = FinanzasCheque::where('id_empresa', $request->id_empresae)->where('n_cheque',$request->n_chequee)
                ->where('id_moneda',$request->id_monedae)->where('estado', 1)->where('id_cheque','!=',$id)->exists();

        if($valida){
            echo "error";
        }else{
            if($request->id_giradoe!="0"){
                $girado = explode("_",$request->id_giradoe);
            }

            FinanzasCheque::findOrFail($id)->update([                
                'id_empresa' => $request->id_empresae,
                'id_banco' => $request->id_bancoe,
                'n_cheque' => $request->n_chequee,
                'fec_emision' => $request->fec_emisione,
                'fec_vencimiento' => $request->fec_vencimientoe,
                'tipo_doc' => $girado[0],
                'num_doc' => $girado[1],
                'concepto' => $request->conceptoe,
                'id_moneda' => $request->id_monedae,
                'importe' => $request->importee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function update_estado(Request $request, $id)
    {
        if($request->estado=="2"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_autorizado' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="3"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_pend_cobro' => now(),
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="4"){
            $request->validate([
                'fec_cobroc' => 'required'
            ],[
                'fec_cobroc.required' => 'Debe ingresar fecha cobro.'
            ]);

            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_cobro' => $request->fec_cobroc,
                'noperacion' => $request->noperacionc,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="5"){
            $request->validate([
                'motivo_anuladon' => 'required'
            ],[
                'motivo_anuladon.required' => 'Debe ingresar motivo.'
            ]);
    
            FinanzasCheque::findOrFail($id)->update([
                'motivo_anulado' => $request->motivo_anuladon,
                'estado_cheque' => $request->estado,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
        if($request->estado=="6"){
            FinanzasCheque::findOrFail($id)->update([
                'estado_cheque' => $request->estado,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function modal_cancelar($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_cancelar',compact(
            'get_id'
        ));
    }

    public function modal_motivo($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_motivo',compact(
            'get_id'
        ));
    }

    public function update_motivo(Request $request, $id)
    {
        FinanzasCheque::findOrFail($id)->update([
            'motivo_anulado' => $request->motivo_anuladom,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function modal_archivo($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_archivo',compact(
            'get_id'
        ));
    }

    public function update_archivo(Request $request, $id)
    {
        $get_id = FinanzasCheque::findOrFail($id);

        $img_cheque = $get_id->img_cheque;
        if ($_FILES["img_chequea"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->img_cheque!=""){
                    ftp_delete($con_id, "ADM_FINANZAS/CHEQUES/".basename($get_id->img_cheque));
                }

                $path = $_FILES["img_chequea"]["name"];
                $source_file = $_FILES['img_chequea']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Cheques_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "ADM_FINANZAS/CHEQUES/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $img_cheque = "https://lanumerounocloud.com/intranet/ADM_FINANZAS/CHEQUES/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        FinanzasCheque::findOrFail($id)->update([
            'img_cheque' => $img_cheque,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function modal_anular($id)
    {
        $get_id = FinanzasCheque::findOrFail($id);
        return view('finanzas.tesoreria.registro_cheque.modal_anular',compact(
            'get_id'
        ));
    }

    public function destroy($id)
    {
        FinanzasCheque::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    /*public function excel($estado,$id_empresa,$id_aceptante,$tipo_fecha,$mes,$anio)
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
    }*/
}
